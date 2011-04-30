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

	public function action_buy()
	{
		$get = $_GET;
		// When Posts Submit is made
		$posts = $this->request->post();
		if(!empty($posts)) {			
			$this_deal = ORM::factory('deal', (int)$posts['did']);
			$deals['ID'] = $posts['did'];
			$deals['quantity'] = $posts['quantity'];
			$deals['deal_price'] =( $this_deal->regular_price * (100 - $this_deal->discount)) / 100;
			$deals['total'] = $deals['quantity'] * $deals['deal_price'];
			
			$billing['cardname'] = $posts['cardname'];
			$billing['cardnumber'] = $posts['cardnumber'];
			$billing['cardcode'] = $posts['cardcode'];
			$billing['expiry_month'] = $posts['expiry_month'];
			$billing['expiry_year'] = $posts['expiry_year'];
			$billing['address'] = $posts['address'];
			$billing['city'] = $posts['city'];
			$billing['state'] = $posts['state'];
			$billing['zipcode'] = $posts['zipcode'];
			
			$order['deal_id'] = $deals['ID'];
			$order['user_id'] = Auth::instance()->get_user()->id;
			$order['quantity'] = $deals['quantity'];
			$order['payment_type'] = 'mastercard';
			$order['total_count'] = $deals['total'];
			$order['status'] = 'pending';
			
			// Add Order now to DB and redirect to merchant/payment gateway page
			$proc_order = ORM::factory('order');
			$proc_order->values($order);
			if($proc_order->save()) {
					$url = sprintf('deals/buy?did=%d&oid=%d&payment=success', $proc_order->deal_id, $proc_order->ID);
					$this->request->redirect($url);
					return;
			}
		}
		
		// Check if referrer came from merchant/payment gateway
		if(isset($get['did']) && isset($get['oid']) && isset($get['payment'])) {
			$order = ORM::factory('order', $get['oid']);
			$deals = ORM::factory('deal', $get['did']);
			$name  = Auth::instance()->get_user()->lastname . ',' . Auth::instance()->get_user()->firstname;
			
			// Send user an email
			
			
			$this->response->body(View::factory('tilbud/order-thankyou')
															->set('title', $deals->title)
															->set('quantity', $order->quantity)
															->set('price', $deals->regular_price * ((100 - $deals->discount) / 100))
															->set('name', $name)
															->set('email', Auth::instance()->get_user()->email));
			return;
		}
		
		
		$did = isset($get['did']) ? $get['did'] : 0;
		if($did > 0) {
			$deal = ORM::factory('deal', $did);
			$this->response->body(View::factory('tilbud/order-deal')
														 ->set('deal', $deal));
		} else {
			//$this->request->redirect('/');
		}
	}
} // End Welcome
