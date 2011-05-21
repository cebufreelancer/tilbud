<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Orders extends Controller {

	public function action_index()
	{	
		$page = View::factory('tilbud/admin/orders/index');
		$orders = ORM::factory('order');
		$total = $orders->count_all();

		$pagination = new Pagination(array(
										 'total_items' 		=> $total,
										 'items_per_page'	=> 10, 
										 'auto_hide' 			=> false,
										 'view'           => 'pagination/useradmin',));

		$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_created'; // set default sorting direction here
		$dir  = isset($_GET['dir']) ? 'DESC' : 'ASC';
		$result = $orders->limit($pagination->items_per_page)->offset($pagination->offset)->order_by($sort, $dir)
							->find_all();
							
		// For Search 
		$posts = $this->request->post();		
		if(!empty($posts)) {
			if(isset($posts['search_string']) && isset($posts['search_filter'])
				&& strlen($posts['search_string']) > 0) {
				
				$search_str = strip_tags(strtolower($posts['search_string']));
				
				switch($posts['search_filter']) {
				case 'email':
					// Search for Email
					$total = DB::select()->from('v_orders')->where(DB::expr('LOWER(email)'), 'like', '%' . $search_str . '%')->execute()->count();
					$search = DB::select()->from('v_orders')->where(DB::expr('LOWER(email)'), 'like', '%' . $search_str . '%')->execute();
					break;
					
				case 'name':
					$total = DB::select()->from('v_orders')->where(DB::expr('LOWER(lastname)'), 'like', '%' . $search_str . '%')->execute()->count();
					$search = DB::select()->from('v_orders')->where(DB::expr('LOWER(lastname)'), 'like', '%' . $search_str . '%')->execute();
					break;
					
				case 'order':
					// Search for Order Number
					$total = $orders->where('id', '=', (int)$search_str)->count_all(); 
					$search  = $orders->where('id', '=', (int)$search_str)
													  ->limit($pagination->items_per_page)
													  ->offset($pagination->offset)
													  ->find_all();
					$search_str = __(LBL_ORDER_NUMBER) . ': ' . $search_str;
					break;
				case 'refno':
					$total = $orders->where('refno', 'like', "%$search_str%")->count_all();
					$search = $orders->where('refno', 'like', "%$search_str%")->find_all();
					break;
				}
				
				$page->query_result = sprintf(__(LBL_SEARCH_RESULT), $search_str, $total);
				$pagination->total_items = $total;
				$result = $search;
			}
		}

		if(!empty($result)) {
			$res = array();
			foreach($result as $ven) {
				$res[] = !is_array($ven) ? $ven->as_array() : $ven;
			}
		}
		
		// Show Pager
		$show_page = ($total > $pagination->items_per_page) ? TRUE : FALSE;

		$page->paging = $pagination;
		$page->orders	= $res;
		$page->show_pager = $show_page;
		
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
				
				// Send Email To Client
				switch($order->status) {
				case 'cancelled':
					break;
				case 'delivered':
					break;
				}
				
				// message: save success
        Message::add('success', sprintf(LBL_Successfully, LBL_ORDER, $order->ID));
				
				Request::current()->redirect('admin/orders');
				return;
			}
		}
		
		$deal = ORM::factory('deal', $order->deal_id);
		
		$page->order_user = ORM::factory('user', $order->user_id)->firstname . ' ' . ORM::factory('user', $order->user_id)->lastname;
		$page->reference_no = $order->refno;
		$page->order_user_id = $order->user_id;
		$page->order_deal_title = ORM::factory('deal', $order->deal_id)->description;
		$page->order_quantity = $order->quantity;
		$page->order_amount_paid = $order->total_count;
		$page->order_status = $order->status;
		$page->order_date_paid = $order->date_paid;
		$page->order_date_created = $order->date_created;
		
		//print_r($order);
		
		$this->response->body($page);
	}
} // End Welcome
