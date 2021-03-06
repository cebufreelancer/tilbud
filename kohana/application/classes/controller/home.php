<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller {

  public function action_import()
  {
    // users_id;group_id;group_name;signup_date;email_address;firstname;lastname
    // 10;1;KÃ¸benhavn;0;m_ringsted@hotmail.com;;
    $file = isset($_GET['f']) ?   $_GET['f'] : '';
    $file_subscribers = APPPATH . $file;

    if (file_exists($file_subscribers)) {
      $handle = fopen($file_subscribers, "r");
      $contents = fread($handle, filesize($file_subscribers));
      $arr = explode("\n", $contents);
      $limit = 10;
      $cnt = 0;
      foreach($arr as $row){
        $arr_str = explode(";", $row);
        if (sizeof($arr_str) >=5 ) {
            $email = trim($arr_str[4]);
            $date = date("Y-m-d H:i:s");
            $origin = trim($arr_str[3]);
            $res = DB::select()->from('subscribers')->where('email', '=', $email)->execute()->as_array();
            echo "-->";
            if (sizeof($res) < 1) {
              echo "====>" . $email . " - " . $origin .  "<br/>";
              DB::insert('subscribers', array('email', 'city_id', 'created_at', 'status', 'origin'))->values(array($email, '3', $date,'1', $origin))->execute();
            }
        }
      }
      fclose($handle);
    }{
      echo "File doesn't exists!";
    }
  }
  
  public function action_sendsms()
  {
   /*
   $message = urlencode(mb_convert_encoding("some text with æøå", "ISO-8859-1", "UTF-8"));
    $url = "http://www.email2sms.dk/cgi/url_api/incoming.cgi?login=846919dml&password=846919dml&action=send&to=0034689757011&from=tilbudibyen&text=$message";
    //$url = "http://www.email2sms.dk/cgi/url_api/incoming.cgi?login=846919dml&password=846919dml&action=send&to=00639391751522&from=tilbudibyen&text=$message";
$ch = curl_init($url);
$fp = fopen("example_homepage.txt", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);
curl_close($ch);
fclose($fp);
   */
  }
 
  public function action_payment_success(){
    error_log( print_r($_REQUEST, true), 3, $_SERVER['DOCUMENT_ROOT'] . '/paymentsuccess.txt');

    $result = DB::select()->from('users')->where('email', '=', $_REQUEST['email'])->execute()->as_array();
    if (sizeof($result) > 0) {
      //do nothing i guess
    }else {
      // new record
      $firstname    = (isset($_REQUEST['firstname']) ? $_REQUEST['firstname'] : '' );
      $lastname     = (isset($_REQUEST['lastname'])  ? $_REQUEST['lastname'] : '' );
      $email        = (isset($_REQUEST['email'])     ? $_REQUEST['email'] : '' );
      $address      = (isset($_REQUEST['address'])   ? $_REQUEST['address'] : '' );
      $postal_code  = (isset($_REQUEST['postal_code']) ? $_REQUEST['postal_code'] : '' );
      $city         = (isset($_REQUEST['city'])       ? $_REQUEST['city'] : '' );
      $mobile       = (isset($_REQUEST['mobile'])     ? $_REQUEST['mobile'] : '' );
      
      $result = DB::insert('users', array('firstname','lastname', 'email', 'address', 'postal_code', 'city', 'mobile', 'status', 'username'))
              ->values(array($firstname, $lastname, $email, $address, $postal_code, $city, $mobile, 'active', $email))->execute();
      $result = DB::select()->from('users')->where('email', '=', $_REQUEST['email'])->execute()->as_array();
      $user = $result[0];
      DB::insert('roles_users', array('user_id', 'role_id'))->values(array($user['id'], 1))->execute();
    }

    $result = DB::select()->from('users')->where('email', '=', $_REQUEST['email'])->execute()->as_array();

    $password = rand(9999, 999999);
		$user = ORM::factory('user')->where('email', '=', $_REQUEST['email'])->find();
		$clean['password'] = $password;
		$clean['password_confirm'] = $password;
		$user->update_user($clean, array('password'));

    // get the first and only record
    $user = $result[0];

    // creating an order
    $order['deal_id'] = $_REQUEST['deal_id'];
    $order['user_id'] = $user['id'];
    $order['quantity'] = $_REQUEST['qty'];
    $order['status'] = 'new';
    $order['total_count'] = "0";
    if (isset($_REQUEST['amount'])) {
      $order['total_count'] = $_REQUEST['amount'];
    }

    $payment_type = "";
    if (isset($_REQUEST['payment_type'])) {
      $payment_type = $_REQUEST['payment_type'];
    }
    $order['payment_type'] = $payment_type;

    $proc_order = ORM::factory('order');
    $order['refno'] = $proc_order->generate_reference_no(8, $_REQUEST['deal_id']);
    $proc_order->values($order);
    $proc_order->save();

    for($i=1; $i<= $_REQUEST['qty']; $i++) {
      $newrefno = $proc_order->generate_reference_no(8, $_REQUEST['deal_id']);
      DB::insert('refnumbers', array('refno', 'order_id', 'deal_id'))->values(array($newrefno,$proc_order->ID, $_REQUEST['deal_id']))->execute();
    }

    $this_deal = ORM::factory('deal', (int)$_REQUEST['deal_id']);

    /************************
     *    Email the user
    ************************/ 
    $transaction_id = "";
    if (isset($_REQUEST['transaction_id'])) {
      $transaction_id = $_REQUEST['transaction_id'];
    }


    $title = "Tillykke med dit køb hos TilbudiByen.dk (Ordrenummer {$transaction_id})";

    $mailer = new XMail();
    $mailer->to = $user['email'];
    $mailer->subject = mb_convert_encoding($title, "ISO-8859-1", "UTF-8");

    // Requires $order, $user, $deal variables
    $order = ORM::factory('order', $proc_order->ID);
    $deal = ORM::factory('deal', $order->deal_id);
    $user = ORM::factory('user', $order->user_id);

    ob_start();
    include_once(APPPATH . 'views/tilbud/template_after_order.php');
    $mailer->message = ob_get_clean();
    $mailer->send();

    $page = View::factory('tilbud/payment_success');
    $this->response->body($page);

  }
  
  public function action_payment_response() {
    error_log( print_r($_REQUEST, true), 3, $_SERVER['DOCUMENT_ROOT'] . '/paymentresponse.txt');
  }

  public function action_unsubscribeme()
  {
    $error = array();
    $page = View::factory('tilbud/unsubscribeme');
    $token = $_REQUEST['t'];
    $sql = "select * from subscribers where token='$token'";
    $result = DB::query(Database::SELECT, $sql)->execute()->as_array();

    if (sizeof($result) > 0) {
      DB::delete('subscribers')->where('token', '=', $token)->execute();
      $message = __(LBL_UNSUBSCRIPTION_SUCCESS_MESSAGE);
    }

    $page->message = $message;
    $this->response->body($page);
  }

  public function action_unsubscribe()
  {
    $error = array();
    $page = View::factory('tilbud/unsubscribe');
  
    if (isset($_POST['unsubscribeme'])) {
      $email = trim($_POST['email']);
      $sql = "select * from subscribers where email='" . $email . "'";
  		$result = DB::query(Database::SELECT, $sql)->execute()->as_array();

  		if (sizeof($result) > 0) {
  		  // validate link
  		  $token = md5($email . time());
  		  $result = DB::update('subscribers')->set(array('token' => $token))->where('email', '=', $email);

          $mailer = new XMail();
          $mailer->subject = __(LBL_EMAIL_UNSUBSCRIBE_SUBJECT);
          $mailer->message = "
Please click the link below to unsubscribe from Tilbudibyen.com
          <br/><br/>
http://wwww.tilbudibyen.com/unsubscribeme?t=$token
          <br/>

          <br/><br/>
          TilbudIbyen.com

          ";
                  $mailer->to = $email;
                  $mailer->send();
            $page->status = 'success';

  		  }else {
  		    $error[] = __(LBL_EMAIL_NOT_ON_LIST);
  		  }
  		}

    $page->error = $error;
    $this->response->body($page);
  }

  public function action_changepassword()
  {
    // TODO: change password here
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

		$user = ORM::factory('user')->where('email', '=', $email)->find();
		
		if($user->loaded()) {
			$clean['password'] = $password;
			$clean['password_confirm'] = $confirm_password;
			$user->update_user($clean, array('password'));
			
			echo "success";
		} else {
    	echo "fail";
		}
  }

  public function action_password_reset()
  {
    $error = array();
    $page = View::factory('tilbud/password_reset');
    
    $sql = "select * from users where email='" . $_GET['email'] . "'";
		$result = DB::query(Database::SELECT, $sql)->execute()->as_array();
		
		if (sizeof($result) > 0) {
		  // validate link
		  $token = $_GET['token'];
		  $email = $_GET['email'];
		  $sql = "select * from forget_passwords where email='$email' and token='$token' and NOW() <= valid_until";
		  $result = DB::query(Database::SELECT, $sql)->execute()->as_array();
		  if (sizeof($result) > 0) {
		    // do nothing
		  }else {
		    $error[] = "Invalid change password session.";
		  }
		}else{
		  $error[] = "User / Email address does not exists.";
		}
		
		$this->response->body($page);
  }
  
  public function action_forgot()
  {
    $page = View::factory('tilbud/forgot');

    if (isset($_POST['email'])) {
      $sql = "select * from users where email='" . $_POST['email'] . "'";
  		$result = DB::query(Database::SELECT, $sql)->execute()->as_array();
  		if (sizeof($result) > 0) {
  		  $user = $result[0];
  		  
  		  $email = $user['email'];
  		  $token = ORM::factory('user')->generate_token();
  		  $valid_until = date("Y-m-d", strtotime("+2 days"));
  		  $date_created = date("Y-m-d H:i:s");

  		  $sql = "Insert into forget_passwords (email, token, status, valid_until, date_created) values('$email', '$token', 'pending', '$valid_until', '$date_created')";
  		  $result = DB::query(Database::INSERT, $sql)->execute();

  		  $reset_url = url::base(true) . "home/password_reset?email=" . $user['email'] . "&token=" . $token;
        $mailer = new XMail();
        $mailer->subject = __(LBL_RESET_PASSWORD_SUBJECT);
        $mailer->message = "Forgot your password " . $user['firstname'] . " ($email)? \r\n
<br/><br/>
If you want to reset your password, click on the link below (or copy and paste the URL into your browser):
<br/>
$reset_url

<br/><br/>
TilbudIbyen.com

";
        $mailer->to = $email;
        $mailer->send();
        
        echo __(LBL_FORGOT_PASSWORD_SENT);
      }else{
        // email doesnt exists
        echo __(LBL_EMAIL_DOESNT_EXISTS);
      }
    }else{
      $this->response->body($page);
    }
  }

	public function action_index()
	{
		$page = View::factory('tilbud/index');
    $deal = ORM::factory('deal')->get_featured();  
    $total_qty = 0;
		
		if(!empty($deal)) {
			$orders = ORM::factory('order')->get_orders($deal['ID']);
			$product = ORM::factory('product')->get_product($deal['product_id']);
			$deal_images = ORM::factory('deal')->get_mainimages($deal['ID']);
			//$vendor = ORM::factory('vendor')->get_vendor($product->vendor_id);
			$address = !@unserialize($deal['addresses']) ? array($deal['addresses']) : @unserialize($deal['addresses']);
			
			$page->deal = $deal;
			$page->images = $deal_images;
      for($i=0; $i<sizeof($orders); $i++) {
       $total_qty += $orders[$i]['quantity'];
      }
      
			$page->total_qty = $total_qty;
			//$page->vendor = $vendor;
			$page->address = $address;
		}
		
		if(isset($_GET['status'])) {
			switch($_GET['status']) {
				case 'verify':
					//$page->msg = 'Congratulations! Kindly check your email to account verification.';
					$page->account_verified = true;
					$page->is_referral = true;
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
    $deal = ORM::factory('deal')->get_featured();
    $url = "http://www.addthis.com/bookmark.php?v=250&winname=addthis&pub=ra-4d6e3a782d6e35f6&source=tbx-250&lng=da&s=facebook&url=" . url::base(true) . "deals/view/" . $deal['ID'];
	  
    $this->request->redirect($url);
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
	  setcookie("tilbud_user_cookie", '1', time() + (86400 * 14));
		$page			= View::factory('tilbud/signupform');
		$citylist = Kohana::config('global.cities');
		
		$url   = '';
    $posts = $this->request->post();

		// This will check if submitted
		if(!empty($posts)) {
			$email = $posts['semail'];
			$city  = $posts['city'];

			$subscriber = ORM::factory('subscriber');
			// check if email and city already subscribed

			if(!$subscriber->is_subscribed($email, $city)) {
				// Add to Subcribers DB
				$subscriber->add($email, $city);
				// Add to Cookie that user is already subscribed
				Cookie::set('tib', md5(date("Ymd")), Date::WEEK*2);

    		// Send email to activate
				$mailer = new XMail();
				$mailer->subject = __(LBL_SIGNUP_SUBJECT);
				$mailer->to = $posts['semail'];

				$confirm_url = "http://www.tilbudibyen.com/verify?e=" . $email;
				ob_start();
				include_once(APPPATH . 'views/tilbud/template_confirm.php');
				$content = ob_get_clean();
				$mailer->message = $content;

				// Send email to admin
				/*
				$mailer = new XMail();
				$mailer->subject = __(LBL_SUBSCRIBE_NEW);
				$mailer->to = "michaxze@gmail.com";
				ob_start();
				echo $email;
				$mailer->message = ob_get_clean();
				$mailer->send();
        */
        
				$page	= View::factory('tilbud/referral');
				$mailer->send();

			}else{
				$page = View::factory('tilbud/signupform');
				$errors['email'] = __(EMAIL_EXIST);
				$page->errors = $errors;
			}

		}
		    $this->response->body($page);
	}
	
	public function action_signupx()
	{
		$page			= View::factory('tilbud/signupform');
		$citylist = Kohana::config('global.cities');
		
		$url   = '';
    $posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
	
			$email = $posts['semail'];
			$city  = $posts['city'];
		
			$subscriber = ORM::factory('subscriber');
						
			// Check if user already registered
			// And is not subscriber only
			if(!ORM::factory('user')->email_exist($email)
			   && !isset($posts['subscriber'])) {
			
				// Add email to users
				try {
					// Construct username
					$username = $email; // substr($email, 0, strpos($email, "@"));
					
					$user['username'] = $username;
					$user['firstname'] = "";
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
				$mailer = new XMail();
				$mailer->subject = __(LBL_SIGNUP_SUBJECT);
				$mailer->to = $posts['semail'];

				$confirm_url = "http://www.tilbudibyen.com/verify?e=" . $email;
				ob_start();
				include_once(APPPATH . 'views/tilbud/template_confirm.php');
				$content = ob_get_clean();
				
				$mailer->message = $content;
				
				if($mailer->send()) {
					// Should notify to check email for verification process
					$page	= View::factory('tilbud/referral');
				}
				
		    $this->response->body($page);
			}else {
			  // email already exists
				// TODO: if email exists (paul)
				//   - asks if enter another email or login
				// $page = View::factory('tilbud/login');
				$page = View::factory('tilbud/signupform');
				$errors['email'] = __(EMAIL_EXIST);
				$page->errors = $errors;
		    $this->response->body($page);			  
			}
		}
	}

	public function action_signup_old()
	{
		$page			= View::factory('tilbud/signupform');
		$citylist = Kohana::config('global.cities');
		
		$url   = '';
    $posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
	
			$email = $posts['semail'];
			$city  = $posts['city'];
		
			$subscriber = ORM::factory('subscriber');
			
			// check if email and city already subscribed			
			if(!$subscriber->is_subscribed($email, $city)) {
				// Add to Subcribers DB
				$subscriber->add($email, $city);
				// Add to Cookie that user is already subscribed
				Cookie::set('tib', md5(date("Ymd")), Date::WEEK*2);
			}
			
			// Check if user already registered
			// And is not subscriber only
			if(!ORM::factory('user')->email_exist($email)
			   && !isset($posts['subscriber'])) {
			
				// Add email to users
				try {
					// Construct username
					$username = $email; // substr($email, 0, strpos($email, "@"));
					
					$user['username'] = $username;
					$user['firstname'] = "";
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
				$mailer = new XMail();
				$mailer->subject = __(LBL_SIGNUP_SUBJECT);
				$mailer->to = $posts['semail'];

				$confirm_url = "http://www.tilbudibyen.com/verify?e=" . $email;
				ob_start();
				include_once(APPPATH . 'views/tilbud/template_confirm.php');
				$content = ob_get_clean();
				
				$mailer->message = $content;
				
				if($mailer->send()) {
					// Should notify to check email for verification process
					$page	= View::factory('tilbud/referral');
				}
				
		    $this->response->body($page);
			}else {
			  // email already exists
				// TODO: if email exists (paul)
				//   - asks if enter another email or login
				// $page = View::factory('tilbud/login');
				$page = View::factory('tilbud/signupform');
				$errors['email'] = __(EMAIL_EXIST);
				$page->errors = $errors;
		    $this->response->body($page);			  
			}
		}
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
      $result = DB::select()->from('subscribers')->where('email', '=', $email)->execute()->as_array();

      if (sizeof($result) > 0) {
        DB::update('subscribers')->set(array('status' => "1"))->where('email', '=', $email)->execute();
        Request::current()->redirect('/');
        return;
  		} else {
  			Message::add('success', __('Email does not exists'));
  			$success = false;
  		}
  	}
	
		$this->response->body(View::factory('tilbud/verify')
						->set('success', $success)
						->set('email', $email)); 
	}

	// to be deleted soon
	public function action_verify_old()
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
					// Auth::instance()->force_login($user->username);
					
					//Message::add('success', __('Your account has been verified. '));
					
					Request::current()->redirect('/?status=verify');
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
		$ret_message= "";
		
		if(!empty($posts)) {
			$emails = explode(",", $posts['email']);
			
			foreach($emails as $email) {
				$email = trim($email);
				if(Valid::email($email)) {
					$referral[] = $email;
				}
			}
			
			if(!empty($referral)) {

				// Send Referral Message to emails
				$mailer = new XMail();
				$mailer->subject = "Du er blevet tilmeldt TilbudiByen af en ven!";
				$mailer->to = $posts['email'];
							
				ob_start();
				include_once(APPPATH . 'views/tilbud/template_referral.php');
				$mailer->message = ob_get_clean();
							
				foreach($referral as $ref) {
					$mailer->to = $ref;
					$mailer->send();
				}
				$ret_message	= View::factory('tilbud/referral2');
			}
		}else{
		  $ret_message = LBL_INVALID_SESSION;
		}

    $this->response->body($ret_message);
	}
} // End Welcome
