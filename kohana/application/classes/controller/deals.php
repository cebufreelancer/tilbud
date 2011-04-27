<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Deals extends Controller {

	public function action_index()
	{	
    $deals = ORM::factory('deal')->get_alldeals();
    $this->response->body(View::factory('tilbud/deals')
                   ->set('deals', $deals));
	}
	
	public function action_view($id){
    $deal = ORM::factory('deal', $id);
    $orders = ORM::factory('order')->get_orders($deal->ID);
    
    $this->response->body(View::factory('tilbud/index')
                   ->set('deal', $deal)
                   ->set('orders', $orders));
	  
	}


} // End Welcome
