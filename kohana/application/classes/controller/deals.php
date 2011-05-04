<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Deals extends Controller {

	public function action_index()
	{	
    $deals = ORM::factory('deal')->get_alldeals();
		$orders = ORM::factory('order');
    $this->response->body(View::factory('tilbud/deals')
                   ->set('deals', $deals)
									 ->set('orders', $orders));
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
		
		$get = $_GET;
		// When Posts Submit is made
		$posts = $this->request->post();
		if(!empty($posts)) {
			$this_deal = ORM::factory('deal', (int)$posts['did']);
			$deals['ID'] = $posts['did'];
			$deals['quantity'] = $posts['quantity'];
			$deals['deal_price'] =( $this_deal->regular_price * (100 - $this_deal->discount)) / 100;
			$deals['total'] = $deals['quantity'] * $deals['deal_price'];
			
			// Billing section
			$billing['cardname'] 		= $posts['cardname'];
			$billing['cardnumber'] 	= $posts['cardnumber'];
			$billing['cardcode'] 		= $posts['cardcode'];
			$billing['expiry_month'] = $posts['expiry_month'];
			$billing['expiry_year'] = $posts['expiry_year'];
			$billing['address'] 		= $posts['address'];
			$billing['city'] 				= $posts['city'];
			$billing['state'] 			= $posts['state'];
			$billing['zipcode'] 		= $posts['zipcode'];
			
			if(!Auth::instance()->logged_in()) {
				// Order section
				$name = explode(" ", $posts['fullname']);
				$new_user['lastname'] 	= $name[count($name)-1];
				unset($name[count($name)-1]);
				$new_user['firstname'] 	= implode($name);
				$new_user['email'] 			= $posts['email'];
				$new_user['password'] 	= $posts['password'];
				
				$user = ORM::factory('user');
				
				// Create validation rules for User Posts
				$valid_user = Validation::factory($posts);
				$valid_user->rule('fullname', 'not_empty')
									 ->rule('email', 'email')
									 ->rule('email', 'not_empty')
									 ->rule('password', 'not_empty')
									 ->rule('password', 'min_length', array(':value', 6))
									 ->rule('password_confirm', 'matches', array(':validation', ':field', 'password'));
									 
				if($valid_user->check()) {
					$user->firstname = $new_user['firstname'];
					$user->lastname = $new_user['lastname'];
					$user->email = $new_user['email'];
					$user->password = Auth::instance()->hash($new_user['password']);
					if($user->save()) {
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
						$to = Auth::instance()->get_user()->email;
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
			$name  = Auth::instance()->get_user()->lastname . ',' . Auth::instance()->get_user()->firstname;
			
			// Send user an email
			
			
			$this->response->body(View::factory('tilbud/order-thankyou')
															->set('deal_id', $deals->ID)
															->set('title', $deals->title)
															->set('quantity', $order->quantity)
															->set('price', $deals->regular_price * ((100 - $deals->discount) / 100))
															->set('name', $name)
															->set('email', Auth::instance()->get_user()->email));
			return;
		}
		
		if(isset($deal_id)) {
			$deal = ORM::factory('deal', $deal_id);
			$page->deal = $deal;
		
			// Check if errors has been set
			if(!empty($errors)) {
				$page->errors = $errors;
				print_r($errors);
			}
			
			$this->response->body($page);
			return;
		} else {
			$this->request->redirect('alldeals');
			return;
		}
	}
} // End Welcome
