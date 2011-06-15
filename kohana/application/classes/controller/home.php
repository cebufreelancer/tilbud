<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller {

  public function action_forcelogin()
  {
    $orig_user = ORM::factory('user')->find($_GET['id']);
    Auth::instance()->force_login($orig_user);
    Request::current()->redirect("/home?fb=1");
  }
  
  public function before()
  {
      error_reporting(0);
        session_start();
//        session_destroy();
//        die();

  }
	public function action_pdf()
	{
    $tilbud = "TILBUDIBYEN";
    $datas[] = "Michael Gimena;04-05-2011;5.august 2011";

    $title = "this is a title";
    $description = "this is a little description";
    $refno = "Referencenummer: 22424-ABC";
    $address = "cebu city";
    $second = mb_convert_encoding('Købsdato', "ISO-8859-1", "UTF-8");
    $third = mb_convert_encoding('Udløbsdato', "ISO-8859-1", "UTF-8");

$guide = mb_convert_encoding("
Sådan bruger du dit værdibevis <br>
- Print værdibeviset ud<br>
- Hæng det op på køleskabet eller læg det i din pung<br>
- Nyd oplevelsen med dine venner eller familie", "ISO-8859-1", "UTF-8");
    
    $pdf = new PDF('P', 'mm', array(250,200));
    //Column titles
    $header=array('Indehave',$second,$third);
    //Data loading
    $data=$pdf->LoadData($datas);
    $pdf->SetFont('Arial','B',20);
    $pdf->AddPage();    
    
    $pdf->Cell(0,20,$tilbud,0,1);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,6,$title,0,1);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(0,6,$description,0,1);
    $pdf->Ln();
        
    $pdf->BasicTable($header,$data);
    $pdf->Ln();
    $pdf->SetFont('Arial','B',11);    
    $pdf->Cell(0,7,$refno,0,1);

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,5,$address,0,1);

    $pdf->Ln();
    $pdf->WriteHTML($guide);
    $pdf->Ln();
    $pdf->Cell(0,6, "TilbudIbyen kundeservice", 0,1);
    $pdf->Cell(0,6, "Mail: kundeservice@tilbudibyen.com", 0,1);
    $pdf->Cell(0,6, mb_convert_encoding("Vi ses på www.tilbudibyen.com","ISO-8859-1", "UTF-8"), 0,1);
    
    $pdf->Output('testing123.pdf', 'F');

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
    $url = "http://www.addthis.com/bookmark.php?v=250&winname=addthis&pub=ra-4d6e3a782d6e35f6&source=tbx-250&lng=da&s=facebook&url=" . url::base(true) . "deals/view/" . $deal->ID;
	  
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
				$mailer->to = $posts['semail'];
							
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