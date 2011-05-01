<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller {

	public function action_index()
	{	
    $deal = ORM::factory('deal')->get_featured();
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
	/*
	public function action_login()
	{	
		$this->response->body(View::factory('tilbud/login')
														->set('label', 'Login'));
	}*/

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
		$result = ORM::factory('city');
		$cities = $result->order_by('name', 'ASC')->find_all();		
    $citylist = array();
		foreach($cities as $city) {
		  $city_arr = $city->as_array();
		  $citylist[$city_arr['ID']] = $city_arr['name'];
		}

    $posts = $this->request->post();
		// This will check if submitted

		if(!empty($posts)) {

		  $to = $posts['semail'];
		  $subject = "Confirm your registration to TilbudiByen newsletter.";
		  $headers = 'MIME-Version: 1.0' . "\r\n";
		  $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
		  $headers .= "From: no-reply@tilbudibyen.com" . "\r\n".
		              "Reply-To: no-reply@tilbudibyen.com" . "\r\n".
		              "X-Mailer: PHP/" . phpversion();

      $duplicates = ORM::factory('user')->email_exist($to);
      
      if ($duplicates > 0 ) {
        echo "Email already exists.";
      }else { 

        $dbconfig = Kohana::config('database.default');
        $conn = mysql_connect('localhost', $dbconfig['connection']['username'], $dbconfig['connection']['password']  );
        mysql_select_db($dbconfig['connection']['database']);
        $sql = "Insert into users (email) values('$to')";
        mysql_query($sql, $conn);
        mysql_close($conn);
        
        
  		  $message = "
    Hi, 
    <br/>
    <br/>
    To complete signup for TilbudiByen, you must verify your email address.<br/><br/>
    <a href=\"http://www.tilbudibyen.com/verify?e=$to\">Click here to verify your account</a>

    <br/><br/>
    The Tilbudibyen Team
    <br/>
    <a href=\"http://www.tilbudibyen.com\">http://www.tilbudibyen.com</a>
    ";
    		  mail($to, $subject, $message, $headers);
          echo 'You have successfully subscribed to our newsletter.';
		 }
		 
		}


	  //$this->response->body(View::factory('tilbud/signup')->set('cities', $citylist)->set('header', 'Sign Up'));
	}
	
	public function action_verify()
	{ 
	  
	  $dbconfig = Kohana::config('database.default');
    $conn = mysql_connect('localhost', $dbconfig['connection']['username'], $dbconfig['connection']['password']  );
    mysql_select_db($dbconfig['connection']['database']);
  
    $email = $_GET['e'];
	  $sql = "select * from users where email='$email'";
	  $res = mysql_query($sql, $conn);
	  $rec = mysql_fetch_assoc($res);
	  $success  = false;
	  
	  if (mysql_num_rows($res) > 0) {
	    $sql = "Update users set status='active', username='$email' where email='$email'";
	    mysql_query($sql, $conn) or die(mysql_error());
	    $success = true;
	    Message::add('success', __('Your account has been verified. '));
	  }else{
	    Message::add('success', __('Email does not exists'));
	  }

		  $this->response->body(View::factory('tilbud/verify')->set('success', $success)->set('email', $email));	
	  
	}
	
	public function action_password_update()
	{
	  $posts = $this->request->post();
	  if (!empty($posts)) {
	    $email = $_POST['email'];

	    if ($_POST['password'] == $_POST['confirm_password']){
	      $clean_posts['password'] = "mike";
	      Auth::instance()->get_user()->update_user($clean_posts, array('password'));
	      
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
	
	public function action_logout()
	{
		echo "This is logout page";
	}
	
} // End Welcome
