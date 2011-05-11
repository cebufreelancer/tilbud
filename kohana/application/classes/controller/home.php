<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller {

	public function action_index()
	{
		$page = View::factory('tilbud/index');
    $deal = ORM::factory('deal')->get_featured();
		
		if(!empty($deal)) {
			$orders = ORM::factory('order')->get_orders($deal->ID);
			$product = ORM::factory('product')->get_product($deal->product_id);
			//$vendor = ORM::factory('vendor')->get_vendor($product->vendor_id);
			$address = $deal->addresses;
			
			$page->deal = $deal;
			$page->orders = $orders;
			//$page->vendor = $vendor;
			$page->address = $address;
		}
		
		if(isset($_GET['status'])) {
			switch($_GET['status']) {
				case 'verify':
					$page->msg = 'Congratulations! Kindly check your email to account verification.';
					break;
				case 'referral':
					$page->is_referral = true;
					break;
			}
		}
		$this->response->body($page);
	}

	public function action_fb($id = null)
	{
		$page = View::factory('tilbud/fb');
		if ($id == null) {
      $deal = ORM::factory('deal')->get_featured();
    }else {
      $deal = ORM::factory('deal', $id);
    }
		
		if(!empty($deal)) {
			$orders = ORM::factory('order')->get_orders($deal->ID);
			$product = ORM::factory('product')->get_product($deal->product_id);
			$address = $deal->addresses;
			
			$page->deal = $deal;
			$page->orders = $orders;
			$page->address = $address;
			
		}
		$this->response->body($page);
	}

	public function action_page($c = NULL)
	{
	  if ($c == NULL) {
	    $this->request->redirect('/');
	  }else {
	    echo "This is for common page";
	  }
		
	}
	
	public function action_signup()
	{
		$page			= View::factory('tilbud/signupform');
		$citylist = Kohana::config('global.cities');
		
		$url   = '';
    $posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
	
			$email = $posts['semail'];
			$city  = $posts['city'];
		
		  $to = $posts['semail'];
		  $subject = "Confirm your registration to TilbudiByen newsletter.";
		  $headers = 'MIME-Version: 1.0' . "\r\n";
		  $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
		  $headers .= "From: TilbudiByen <no-reply@tilbudibyen.com>" . "\r\n".
		              "Reply-To: no-reply@tilbudibyen.com" . "\r\n".
		              "X-Mailer: PHP/" . phpversion();

			$subscriber = ORM::factory('subscriber');
			
			// check if email and city already subscribed			
			if(!$subscriber->is_subscribed($email, $city)) {
				// Add to Subcribers DB
				$subscriber->add($email, $city);
			}
			
			// Check if user already registered
			if(!ORM::factory('user')->email_exist($email)) {
			
				// Add email to users
				try {
					// Construct username
					$username = substr($email, 0, strpos($email, "@"));
					
					$user['username'] = $username;
					$user['firstname'] = $username;
					$user['email']		 = $email;
					$user['status']	 = 'pending';
					$user['password'] = ORM::factory('user')->generate_password(6);
					$user['password_confirm'] = $user['password'];
				
					ORM::factory('user')->create_user($user, array('username','firstname','email','status','password'));
					
				} catch (ORM_Validation_Exception $e) {
					$errors = $e->errors('register');
					$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()));
					//print_r($errors);
				}
							
				// Send email to activate
				$confirm_url = "http://www.tilbudibyen.com/verify?e=" . $email;
				ob_start();
				include_once(APPPATH . 'views/tilbud/template_confirm.php');
				$content = ob_get_clean();
				
				$message = $content;
				
				if(mail($to, $subject, $message, $headers)) {
					// Should notify to check email for verification process
					Request::current()->redirect(Url::base(TRUE) . '?status=referral');
					return;
				}
			}
		}
		
		$this->response->body($page);
	}
	
	public function action_verify()
	{ 
		// Check if already logged in
		//	Redirect to account page
		if(Auth::instance()->logged_in()) {
			Request::current()->redirect('user/myaccount');
		}
		
		if(!empty($_GET)) {
			$email = $_GET['e'];
			$user = ORM::factory('user');
			
			if($user->where('email', '=', $email)->count_all() > 0 ) {
				$user = $user->where('email', '=', $email)->find();
				
				// Check if status is already active
				// Redirect to home page
				if(strcmp($user->status, 'active') == 0) {
					Request::current()->redirect('/');
					return;
				}
				
				$user->status = 'active';

				if($user->save()) {
					// Add login Role
					$user->add('roles', 1);
					
					// Auto Login User
					Auth::instance()->force_login($user->username);
					
					Message::add('success', __('Your account has been verified. '));
					
					Request::current()->redirect('/');
					return;
				}
			} else {
				Message::add('success', __('Email does not exists'));
				$success = false;
			}
		}
	
		$this->response->body(View::factory('tilbud/verify')
						->set('success', $success)
						->set('email', $email)); 
	}
	
	public function action_password_update()
	{
	  $posts = $this->request->post();
	  if (!empty($posts)) {
	    $email = $_POST['email'];

	    if ($_POST['password'] == $_POST['password_confirm']){

				$clean_posts['password'] = $_POST['password'];
				try {
					Auth::instance()->get_user()->update_user($_POST, array('password'));
				} catch (ORM_Validation_Exception $e) {
					$errors = $e->errors('register');
					$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()));
					print_r($errors);
				}
				
		    $this->response->body(View::factory('tilbud/password_update'));
				
	    }else{
		    $this->request->redirect('verify?e=' . $email);
	    }
	  }
	}

	public function action_about()
	{
		$this->response->body(View::factory('tilbud/about'));
	}

	public function action_faq()
	{
		$this->response->body(View::factory('tilbud/faq'));
	}

	public function action_contact()
	{
    $this->response->body(View::factory('tilbud/contact'));
	}
	
	public function action_referral()
	{
		$posts = $this->request->post();
		
		if(!empty($posts)) {
			$emails = explode(",", $posts['email']);
			
			foreach($emails as $email) {
				$email = trim($email);
				if(Valid::email($email)) {
					$referral[] = $email;
				}
			}
			
			if(!empty($referral)) {
				
				$subject = "You have been invited to join TilbudiByen!";
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
				$headers .= "From: TilbudiByen <no-reply@tilbudibyen.com>" . "\r\n".
										"Reply-To: no-reply@tilbudibyen.com" . "\r\n".
										"X-Mailer: PHP/" . phpversion();
				
				ob_start();
				include_once(APPPATH . 'views/tilbud/template_referral.php');
				$content = ob_get_clean();
				
				$message = $content;
				
				foreach($referral as $ref) {
					mail($ref, $subject, $message, $headers);
				}
				
				Request::current()->redirect(Url::base(TRUE));
				return;
			}
		}
		
		$this->response->body(View::factory('tilbud/referralform'));
	}
} // End Welcome
