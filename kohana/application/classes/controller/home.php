<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller {

	public function action_index()
	{	
		$this->response->body(View::factory('tilbud/index'));
	}
	
	public function action_login()
	{	
		$this->response->body(View::factory('tilbud/login'));
	}
	
	public function action_signup()
	{
		echo "This is signup page";
	}
	
	public function action_logout()
	{
		echo "This is logout page";
	}

} // End Welcome
