<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Deals extends Controller {

	public function action_index()
	{		
		$page = View::factory('tilbud/admin/deals/index');
		$deals = ORM::factory('deal');
		
		// This is an example of how to use Kohana pagination
    // Get the total count for the pagination
		$res = array();
		$total = $deals->count_all();
		if($total > 0) {
			$pagination = new Pagination(array(
										 'total_items' 		=> $total,
										 'items_per_page'	=> 10, 
										 'auto_hide' 			=> false,
										 'view'           => 'pagination/useradmin',));
			$sort = isset($_GET['sort']) ? $_GET['sort'] : 'ID'; // set default sorting direction here
			$dir  = isset($_GET['dir']) ? 'DESC' : 'ASC';
			$result = $deals->limit($pagination->items_per_page)->offset($pagination->offset)->order_by($sort, $dir)
								->find_all();
								
			foreach($result as $ven) {
				$res[] = $ven->as_array();
			}
			
			// Show Pager
			$show_page = ($total > $pagination->items_per_page) ? TRUE : FALSE;
			
			$page->paging = $pagination;
			$page->deals = $res;
			$page->show_pager = $show_page;
		}
		
		$this->response->body($page);
	}
	
	public function action_add()
	{
		$page = View::factory('tilbud/admin/deals/deal_form');
		$page->label = 'Add a Deal';
		
		$deals = ORM::factory('deal');
		$result = ORM::factory('city');
		$cities = $result->order_by('name', 'ASC')->find_all();
		
		$allproducts = ORM::factory('product');
		$result_products = $allproducts->order_by('ID', 'ASC')->find_all();

    $citylist = array();
		foreach($cities as $city) {
		  $city_arr = $city->as_array();
		  $citylist[$city_arr['ID']] = $city_arr['name'];
		}

    $products = array();
		foreach($result_products as $p) {
		  $p_arr = $p->as_array();
		  $products[$p_arr['ID']] = $p_arr['title'];
		}


		// Get posts
		$posts = $this->request->post();

		// This will check if submitted
		if(!empty($posts)) {
		  $deals->product_id 			 	= htmlentities($posts['deal_product']);
			$deals->title 			 	= htmlentities($posts['deal_title']);
			$deals->description = htmlentities($posts['deal_desc']);
			$deals->city_id 	 	= htmlentities($posts['deal_city']);
			$deals->regular_price 			= htmlentities($posts['deal_regular_price']);
			$deals->discount  			= htmlentities($posts['deal_discount']);
			$deals->vouchers 	 		= htmlentities($posts['deal_vouchers']);
			$deals->min_buy 	 		= htmlentities($posts['deal_min_buy']);
			$deals->max_buy 	 		= htmlentities($posts['deal_max_buy']);
			$deals->status  		= htmlentities($posts['deal_status']);
			$deals->date_create = Date("Y-m-d H:i:S");

			if($deals->save()) {
				// message: save success
        Message::add('success', __('Deal ' . $deals->title . 'has been successfully added.'));
						
				// Assuming all is correct
				Request::current()->redirect('admin/deals');
				return;
			}
		}
		
		$page->deal_product 		= isset($posts['deal_product']) ? $posts['deal_product'] : '';
		$page->deal_title 		= isset($posts['deal_title']) ? $posts['deal_title'] : '';
		$page->deal_desc 		= isset($posts['deal_desc']) ? $posts['deal_desc'] : '';
		$page->deal_city = isset($posts['deal_city']) ? $posts['deal_city'] : '';
		$page->deal_regular_price 	= isset($posts['deal_regular_price']) ? $posts['deal_regular_price'] : '';
		$page->deal_discount = isset($posts['deal_discount']) ? $posts['deal_discount'] : '';
		$page->deal_vouchers 	= isset($posts['deal_vouchers']) ? $posts['deal_vouchers'] : '';
		$page->deal_min_buy 	= isset($posts['deal_min_buy']) ? $posts['deal_min_buy'] : '';
		$page->deal_max_buy 	= isset($posts['deal_max_buy']) ? $posts['deal_max_buy'] : '';
		$page->deal_status = isset($posts['deal_status']) ? $posts['deal_status'] : '';

		$page->cities = $citylist;
		$page->products = $products;

		$this->response->body($page);
	}
	
	public function action_edit($id=NULL)
	{
		$page = View::factory('tilbud/admin/vendors/vendor_form');
		$page->label = 'Edit a Vendor';
		
		$vendors = ORM::factory('vendor', $id);
		
		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
					
			$vendors->name 			 	= htmlentities($posts['vendor_name']);
			$vendors->description = htmlentities($posts['vendor_desc']);
			$vendors->address 	 	= htmlentities($posts['vendor_address']);
			$vendors->phone 			= htmlentities($posts['vendor_phone']);
			$vendors->url  				= htmlentities($posts['vendor_website']);
			$vendors->email 	 		= htmlentities($posts['vendor_email']);
			$vendors->office_hours = htmlentities($posts['vendor_office_hours']);
			$vendors->status  		= 'active';
					
			if($vendors->save()) {
				// message: save success
        Message::add('success', __('Vendor ' . $vendors->name . 'has been successfully updated.'));
						
				// Assuming all is correct
				Request::current()->redirect('admin/vendors');
				return;
			}
		}
		
		$page->vendor_name 		= isset($posts['vendor_name']) ? $posts['vendor_name'] : html_entity_decode($vendors->name);
		$page->vendor_desc 		= isset($posts['vendor_desc']) ? $posts['vendor_desc'] : html_entity_decode($vendors->description);
		$page->vendor_address = isset($posts['vendor_address']) ? $posts['vendor_address'] : html_entity_decode($vendors->address);
		$page->vendor_phone 	= isset($posts['vendor_phone']) ? $posts['vendor_phone'] : html_entity_decode($vendors->phone);
		$page->vendor_website = isset($posts['vendor_website']) ? $posts['vendor_website'] : html_entity_decode($vendors->url);
		$page->vendor_email 	= isset($posts['vendor_email']) ? $posts['vendor_email'] : html_entity_decode($vendors->email);
		$page->vendor_office_hours = isset($posts['vendor_office_hours']) ? $posts['vendor_office_hours'] : html_entity_decode($vendors->office_hours);
		
		$this->response->body($page);
	}
	
	public function action_delete($id=NULL)
	{
		$page = View::factory('tilbud/admin/confirm_deals_delete');
		$page->label = 'Delete Deal';
	
		$deal = ORM::factory('deal', $id);
		
		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
			
			if(strcmp($posts['submit'], 'Ok') == 0) {
				if($deal->loaded()) {
					$deal->delete();
				}
			}
						
			// Assuming all is correct
			Request::current()->redirect('admin/deals');
			return;

		} else {
		
			$rec['title'] 			= html_entity_decode($deal->title);
			$rec['description'] = html_entity_decode($deal->description);
			
			$page->records = $rec;
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

} // End Welcome
