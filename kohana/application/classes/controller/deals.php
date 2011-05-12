<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Deals extends Controller {

	public function action_index()
	{
    $deals = ORM::factory('deal')->get_active_deals('active', 20);
		$orders = ORM::factory('order');
    $this->response->body(View::factory('tilbud/deals')
                   ->set('deals', $deals)
									 ->set('orders', $orders));
	}
	
	public function action_email_format($deal_id)
	{
			$deals = ORM::factory('deal', $deal_id);
			$this->response->body(View::factory('tilbud/template_email')
															->set('deals', $deals));
	}
	
	public function action_view($id){
    $deal = ORM::factory('deal', $id);
    $orders = ORM::factory('order')->get_orders($deal->ID);
    $product = ORM::factory('product')->get_product($deal->product_id);
    $vendor = ORM::factory('vendor')->get_vendor($product->vendor_id);
    $address = $vendor->address;

		$this->response->body(View::factory('tilbud/index')
		                      ->set('deal', $deal)
		                      ->set('orders', $orders)
		                      ->set('vendor', $vendor)
		                      ->set('address', $address));
	}

	public function action_buy($deal_id=null)
	{
		$page = View::factory('tilbud/order-deal');
		$user_exists = false;

		$get = $_GET;
		$user = ORM::factory('user');
		// When Posts Submit is made
		$posts = $this->request->post();
		if(!empty($posts)) {
			$this_deal = ORM::factory('deal', (int)$posts['did']);
			$deals['ID'] = $posts['did'];
			$deals['quantity'] = $posts['quantity'];
			$deals['deal_price'] =( $this_deal->regular_price * (100 - $this_deal->discount)) / 100;
			$deals['total'] = $deals['quantity'] * $deals['deal_price'];
			
			// Billing section
			$billing['cardname'] 		= $posts['cardname']; //378282246310005
			$billing['cardnumber'] 	= $posts['cardnumber'];
			$billing['cardcode'] 		= $posts['cardcode'];
			$billing['expiry_month'] = $posts['expiry_month'];
			$billing['expiry_year'] = $posts['expiry_year'];
			$billing['address'] 		= $posts['address'];
			$billing['city'] 				= $posts['city'];
			//$billing['state'] 			= $posts['state'];
			$billing['zipcode'] 		= $posts['zipcode'];
			
			$valid_card = Validation::factory($billing);
			$valid_card->rule('cardname', 'not_empty')
								 ->rule('cardname', 'regex', array(':value', '/^[A-Za-z\s]+$/'))
								 ->rule('cardnumber', 'credit_card')
								 ->rule('cardcode', 'not_empty')
								 ->rule('cardcode', 'exact_length', array(':value', 3))
								 ->rule('address', 'not_empty')
								 ->rule('city', 'not_empty')
								 ->rule('zipcode', 'not_empty')
								 ->rule('zipcode', 'min_length', array(':value', 3))
								 ->rule('zipcode', 'min_length', array(':value', 4));
								 
			if($valid_card->check()) {
			
				if(!Auth::instance()->logged_in()) {
					// Order section
					$name = explode(" ", $posts['fullname']);
					$new_user['lastname'] 	= $name[count($name)-1];
					unset($name[count($name)-1]);
					$new_user['firstname'] 	= implode($name);
					$new_user['email'] 			= $posts['email'];
					$new_user['password'] 	= $posts['password'];
					$new_user['password_confirm'] = $posts['password_confirm'];
					$new_user['username'] = $posts['email']; // substr($posts['email'], 0, strpos($posts['email'], "@"));
					$new_user['group'] = 1;
					$new_user['fullname'] = $posts['fullname'];
					$new_user['user_type']  = 'user';
	
	//        $user->create_user($new_user, array('username','password','email','firstname','lastname','group_id'));
	/*        
					$clean['group'] = $posts['group'];
					$clean['firstname'] = $posts['firstname'];
					$clean['lastname'] = $posts['lastname'];
					$clean['email'] = $posts['email'];
					$clean['username'] = substr($posts['email'], 0, strpos($posts['email'], "@"));
					$clean['password'] = $posts['password'];
					$clean['password_confirm'] = $posts['password_confirm'];
					$clean['user_type'] = $posts['user_type'];
					$clean['group_id'] = $posts['group'];
					$clean['mobile'] = $posts['mobile'];
	*/
					
	//				$user = ORM::factory('user');
	
					
					// Create validation rules for User Posts
					$valid_user = Validation::factory($new_user);
					
					$valid_user->rule('fullname', 'not_empty')
										 ->rule('email', 'email')
										 ->rule('email', 'not_empty')
										 ->rule('password', 'not_empty')
										 ->rule('password', 'min_length', array(':value', 6))
										 ->rule('password_confirm', 'matches', array(':validation', ':field', 'password'));
										 
					if($valid_user->check()) {
						if (ORM::factory('user')->email_exist($new_user['email']) == 1) {
							$errors = array();
							$errors['user_exist'] = true;
						}else{
	/*
							$user->firstname = $new_user['firstname'];
							$user->lastname = $new_user['lastname'];
							$user->email = $new_user['email'];
							$user->password = Auth::instance()->hash($new_user['password']);
							$user->username = $new_user['username'];
							$user->group_id = 1;
		*/
	
							
	
							try {
								$user->create_user($new_user, array('username','password','email','firstname','lastname','group_id'));
								$user_id = $user->id;
								$user = ORM::factory('user', $user_id);
							} catch (ORM_Validation_Exception $e) {
								$errors = $e->errors('register');
								$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()) );
							}	
	
							$user_id = $user->id;
						}
					} else {
						$errors = $valid_user->errors('user');
					}
					
					
					/*
					try {
						$user->create_user($new_user, array('lastname','firstname','email','password'));
					} catch (ORM_Validation_Exception $e) {
						$errors = $e->errors('register');
						$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()) );
					}*/
					
				} else {
					$user_id = Auth::instance()->get_user()->id;
					$user = Auth::instance()->get_user();
				}
			
			} else {
				$errors = $valid_card->errors('billing');
			}
			
			// Check if no error on user creation if none,
			// process order variables
			if(empty($errors)) {
				// Order section
				$order['deal_id'] = $deals['ID'];
				$order['user_id'] = $user_id;
				$order['quantity'] = $deals['quantity'];
				$order['payment_type'] = 'mastercard';
				$order['total_count'] = $deals['total'];
				$order['status'] = 'pending';
				
				
				// Add Order now to DB and redirect to merchant/payment gateway page
				$proc_order = ORM::factory('order');
				$proc_order->values($order);
				if($proc_order->save()) {

						/************************
						 *    Email the user
						************************/ 
						$to = $user->email;
						$subject = "Thank you for your Order!";
						$headers = 'MIME-Version: 1.0' . "\r\n";
						$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
						$headers .= "From: no-reply@tilbudibyen.com" . "\r\n".
												"Reply-To: no-reply@tilbudibyen.com" . "\r\n".
												"X-Mailer: PHP/" . phpversion();
												
						$message = "
Hello, 
<br/>
<br/>
You have made an order to tilbudibyen.com.  Please do make the payment now.<br/><br/>

<br/><br/>
The Tilbudibyen Team
<br/>
<a href=\"http://www.tilbudibyen.com\">http://www.tilbudibyen.com</a>
";
						mail($to, $subject, $message, $headers);
					
						$url = sprintf('deals/buy?did=%d&oid=%d&payment=success', $proc_order->deal_id, $proc_order->ID);
						$this->request->redirect($url);
						return;
				}
			}
		}
		
		// Check if referrer came from merchant/payment gateway
		if(isset($get['did']) && isset($get['oid']) && isset($get['payment'])) {
			$order = ORM::factory('order', $get['oid']);
			$deals = ORM::factory('deal', $get['did']);
			$name  = $user->lastname . ',' . $user->firstname;
			
			// Send user an email
			
			
			$this->response->body(View::factory('tilbud/order-thankyou')
															->set('deal_id', $deals->ID)
															->set('title', $deals->title)
															->set('description', $deals->description)
															->set('contents_title', $deals->contents_title)
															->set('quantity', $order->quantity)
															->set('price', $deals->regular_price * ((100 - $deals->discount) / 100))
															->set('name', $name)
															->set('email', $user->email));
			return;
		}
		
		if(isset($deal_id)) {
			$deal = ORM::factory('deal', $deal_id);
			$page->deal = $deal;
			$page->cardtypes = array("visa" => "VISA", 
															 "mastercard" => "Master Card",
															 "jcb" => "JCB",
															 "american-express" => "American Express");
			
			$page->cardname		= isset($posts['cardname']) ? $posts['cardname'] : '';
			$page->cardnumber = isset($posts['cardnumber']) ? $posts['cardnumber'] : '';
			$page->address 		= isset($posts['address']) ? $posts['address'] : '';
			$page->city				= isset($posts['city']) ? $posts['city'] : '';
			$page->zipcode		= isset($posts['zipcode']) ? $posts['zipcode'] : '';
			$page->cardcode 	= isset($posts['cardcode']) ? $posts['cardcode'] : '';
			// Check if errors has been set
			if(!empty($errors)) {
				$page->errors = $errors;
			}
			
			$this->response->body($page);
			return;
		} else {
			$this->request->redirect('alldeals');
			return;
		}
	}
} // End Welcome
