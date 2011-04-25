<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Deals extends Controller {

	public function action_index($id = NULL)
	{	
	  if ($id == NULL) {
	    $deals = ORM::factory('deal')
	             ->order_by('ID', 'DESC')
	             ->find_all();
		  $this->response->body(View::factory('tilbud/deals'));
		}else{
		  
		}
	}


} // End Welcome
