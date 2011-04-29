<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ipages extends Controller {

	public function action_index()
	{	
	  $page_code = $_GET['p'];
	  $page = ORM::factory('page')->get_page($page_code);
		$this->response->body(View::factory('tilbud/ipages')->set('page',$page));
	}
	
} // End Ipages
