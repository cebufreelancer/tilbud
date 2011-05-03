<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Orders extends Controller {

	public function action_index()
	{	
		$page = View::factory('tilbud/admin/orders/index');
		$orders = ORM::factory('order');
		
		// This is an example of how to use Kohana pagination
    // Get the total count for the pagination
		$total = $orders->count_all();

		if($total > 0) {
			$pagination = new Pagination(array(
										 'total_items' 		=> $total,
										 'items_per_page'	=> 10, 
										 'auto_hide' 			=> false,
										 'view'           => 'pagination/useradmin',));
			$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_created'; // set default sorting direction here
			$dir  = isset($_GET['dir']) ? 'DESC' : 'ASC';
			$result = $orders->limit($pagination->items_per_page)->offset($pagination->offset)->order_by($sort, $dir)
								->find_all();
								
			foreach($result as $ven) {
				$res[] = $ven->as_array();
			}
			
			// Show Pager
			$show_page = ($total > $pagination->items_per_page) ? TRUE : FALSE;
			
			$page->paging = $pagination;
			$page->orders = $res;
			$page->show_pager = $show_page;
		}
		
		$this->response->body($page);
	}
	
	public function before() 
	{
		// This codeblock is very useful in development sites:
		// What it does is get rid of invalid sessions which cause exceptions, which may happen
		// 1) when you make errors in your code.
		// 2) when the session expires!
		try {
			 $this->session = Session::instance();
		} catch(ErrorException $e) {
			 session_destroy();
		}
		// Execute parent::before first
		parent::before();
		// Open session
		$this->session = Session::instance();

		// Check user auth and role
		$action_name = Request::current()->action();

		if(Auth::instance()->logged_in('admin') === FALSE) {
			if(Auth::instance()->logged_in()) {
				Request::current()->redirect('user/myaccount');
			} else {
				Request::current()->redirect('user/login?u=' . urlencode($_SERVER['REDIRECT_URL']));
			}
		}
	}

	public function action_edit($id)
	{	
		$page = View::factory('tilbud/admin/orders/order_form');
		$page->label = LBL_ORDER_EDIT;
		
		$order = ORM::factory('order', $id);
		
		// Get posts
		$posts = $this->request->post();
		
		if(!empty($posts)) {
			$order->status = $posts['order_status'];
			
			if($order->save()) {
				// message: save success
        Message::add('success', sprintf(LBL_Successfully, LBL_ORDER, $order->ID));
				
				Request::current()->redirect('admin/orders');
				return;
			}
		}
		
		$deal = ORM::factory('deal', $order->deal_id);
		
		$page->order_user = ORM::factory('user', $order->user_id)->firstname . ' ' . ORM::factory('user', $order->user_id)->lastname;
		$page->order_deal_title = $deal->title;
		$page->order_product_name = ORM::factory('product', $deal->product_id)->title; 
		$page->order_quantity = $order->quantity;
		$page->order_amount_paid = $order->total_count;
		$page->order_status = $order->status;
		$page->order_date_paid = $order->date_paid;
		$page->order_date_created = $order->date_created;
		
		//print_r($order);
		
		$this->response->body($page);
	}
} // End Welcome
