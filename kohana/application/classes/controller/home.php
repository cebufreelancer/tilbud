<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller {

	public function action_index()
	{	
    $deal = ORM::factory('deal')->get_featured();
    $orders = ORM::factory('order')->get_orders($deal->ID);
//    $product = ORM::factory('product')->get_product($deal->ID);
//    $vendor = ORM::factory('vendor')->get_orders($deal->ID);

		$this->response->body(View::factory('tilbud/index')
		                      ->set('deal', $deal)
		                      ->set('orders', $orders));
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
		  
		  $to = $posts['email'];
		  $subject = "Confirm your registration to TilbudiByen newsletter.";
		  $headers = 'MIME-Version: 1.0' . "\r\n";
		  $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
		  $headers .= "From: no-reply@tilbudibyen.com" . "\r\n".
		              "Reply-To: no-reply@tilbudibyen.com" . "\r\n".
		              "X-Mailer: PHP/" . phpversion();

      $duplicates = ORM::factory('user')->email_exist($to);
      
      if ($duplicates) {
        Message::add('success', __('Email already exists.'));
      }else { 
          $insert = DB::insert('users')
              ->columns(array('email'))
              ->values(array($to));
          $insert->execute();
      
    		  $message = "
    Hi, \n
    \n
    To complete signup for Groupon, you must verify your email address.
    <a href=\"http://www.tilbudibyen.com/verify?e=$to\">Click here to verify your account</a>

    \n\n
    The Tilbudibyen Team\n
    http://www.tilbudibyen.com
    ";

    		  mail($to, $subject, $message, $headers);
          Message::add('success', __('You have successfully subscribed to our newsletter.'));
		 }
		 
		}


	  $this->response->body(View::factory('tilbud/signup')->set('cities', $citylist)->set('header', 'Sign Up'));
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
