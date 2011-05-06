<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Deals extends Controller {

	public function action_index()
	{		

		$page = View::factory('tilbud/admin/deals/index');
		$deals = ORM::factory('deal');
		
		// Check if send mail is accessed
		if(!empty($_GET)) {
			$send = false;
			
			$random_hash = md5(date('r', time())); 
			// Headers
			$headers  = 'Content-Type: multipart/alternative; boundary="PHP-alt-' . $random_hash . '"' . "\r\n"; 
			//$headers .= 'MIME-Version: 1.0' . "\r\n";

			$headers .= "From: TilbudiByen <no-reply@tilbudibyen.com>" . "\r\n".
		              "Reply-To: no-reply@tilbudibyen.com" . "\r\n".
		              "X-Mailer: PHP/" . phpversion();
			// Subject
			$subject = ORM::factory('deal', (int)$_GET['did'])->title;

			// Message
			$message  = '--PHP-alt-' . $random_hash . "\r\n";
			$message .= 'Content-type: text/html; charset="iso-8859-1"' . "\r\n";
			$message .= 'Content-Transfer-Encoding: 7bit' . "\n";
			$message .= View::factory('tilbud/template_email')
									->set('deals', ORM::factory('deal', (int)$_GET['did']));
			$message .= '--PHP-alt-'.$random_hash.'--'."\n";

			$subscribers = ORM::factory('category')->get_subscribers($_GET['city']);
			
			if(!empty($subscribers)) {
				foreach($subscribers as $sub) {
					if(mail($sub['email'], $subject, htmlentities($message), $headers)) {
						$send=true;
					}
				}
			} else {
				Message::add('success', __('No user has been subscribe on this city.'));
			}
			
			if($send==true) {
				// message: save success
        Message::add('success', __('Email has been sent to subscribers'));
			}
		}
		
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
			//echo '<pre>'; print_r($posts); echo '</pre>'; exit;
		  //$deals->product_id 	= (int)$posts['deal_product'];
			$deals->title 			= htmlentities($posts['deal_title']);
			$deals->description = htmlentities($posts['deal_desc']);
			$deals->contents_title = htmlentities($posts['deal_content_title']);
			$deals->contents		= $posts['deal_desc_long'];
			$deals->whatyouget	= htmlentities($posts['deal_whatyouget']);
			$deals->information	= htmlentities($posts['deal_information']);
			$deals->city_id 	 	= (int)$posts['deal_city'];
			$deals->group_id		= (int)$posts['deal_group'];
			$deals->regular_price = number_format($posts['deal_regular_price'], 2, '.', '');
			$deals->discount  	= (int)$posts['deal_discount'];
			//$deals->vouchers 	 	= (int)$posts['deal_vouchers'];
			$deals->reference_no= htmlentities($posts['deal_refno']);
			$deals->youtube_url	= $this->clean_video_url($posts['deal_video_url']);
			$deals->min_buy 	 	= (int)$posts['deal_min_buy'];
			$deals->max_buy 	 	= (int)$posts['deal_max_buy'];
			$deals->min_sold 	 	= (int)$posts['deal_min_sold'];
			$deals->max_sold 	 	= (int)$posts['deal_max_sold'];
			$deals->status  		= htmlentities($posts['deal_status']);
			$deals->start_date	= date("Y-m-d H:i:S", strtotime($posts['deal_start_date']));
			$deals->end_date		= date("Y-m-d H:i:S", strtotime($posts['deal_start_date'] . " 23:59:59"));
			$deals->expiry_date = date("Y-m-d H:i:S", strtotime($posts['deal_expiry_date'] . " 23:59:59"));
			$deals->is_featured = 1;
			
			if (isset($_FILES['deal_image'])) {
			  $deals->image = $_FILES['deal_image']['name'];
			}
			
			if($deals->save()) {
				if(!empty($_FILES)) {
			  	mkdir(APPPATH . "../uploads/". $deals->ID);
			  	move_uploaded_file($_FILES["deal_image"]["tmp_name"], APPPATH . "../uploads/" . $deals->ID . "/" . $_FILES["deal_image"]["name"]);
				}
			  
				// message: save success
        Message::add('success', __(sprintf(LBL_SUCCESS_ADD, LBL_DEAL,$deals->title)));
		
				// Update all the Category Relationships
				$posts['category'] = !empty($posts['category']) ? $posts['category'] : array();		
				ORM::factory('category')->update_relationship($deals->ID, $posts['category']);
				
				// Assuming all is correct
				Request::current()->redirect('admin/deals');
				return;
			}
		}
		
		$page->deal_product 	= isset($posts['deal_product']) ? $posts['deal_product'] : '';
		$page->group					= isset($posts['deal_group']) ? $posts['deal_group'] : 1;
		$page->deal_title 		= isset($posts['deal_title']) ? $posts['deal_title'] : 'Dagens Tilbud';
		$page->deal_desc 			= isset($posts['deal_desc']) ? $posts['deal_desc'] : '';
		$page->deal_desc_long = isset($posts['deal_desc_long']) ? $posts['deal_desc_long'] : '';
		$page->deal_whatyouget = isset($posts['deal_whatyouget']) ? $posts['deal_whatyouget'] : '';
		$page->deal_content_title = isset($posts['deal_content_title']) ? $posts['deal_content_title'] : '';
		$page->deal_information = isset($posts['deal_information']) ? $posts['deal_information'] : '';
		$page->deal_city 			= isset($posts['deal_city']) ? $posts['deal_city'] : '';
		$page->deal_regular_price = isset($posts['deal_regular_price']) ? $posts['deal_regular_price'] : 0.00;
		$page->deal_discount 	= isset($posts['deal_discount']) ? $posts['deal_discount'] : 50;
		//$page->deal_vouchers 	= isset($posts['deal_vouchers']) ? $posts['deal_vouchers'] : '';
		$page->deal_min_buy 	= isset($posts['deal_min_buy']) ? $posts['deal_min_buy'] : 5;
		$page->deal_max_buy 	= isset($posts['deal_max_buy']) ? $posts['deal_max_buy'] : 5;
		$page->deal_min_sold 	= isset($posts['deal_min_sold']) ? $posts['deal_min_sold'] : 5;
		$page->deal_max_sold 	= isset($posts['deal_max_sold']) ? $posts['deal_max_sold'] : 5;
		$page->start_date 		= isset($posts['deal_start_date']) ? $posts['deal_start_date'] : date("Y/m/d");
		$page->end_date 			= isset($posts['deal_end_date']) ? $posts['deal_end_date'] : date("Y/m/d");
		$page->expiry_date 		= isset($posts['deal_expiry_date']) ? $posts['deal_expiry_date'] : '';
		$page->deal_status 		= isset($posts['deal_status']) ? $posts['deal_status'] : '';
		$page->deal_video_url	= isset($posts['deal_video_url']) ? $posts['deal_video_url'] : '';
		$page->deal_refno			= isset($posts['deal_refno']) ? $posts['deal_refno'] : '';

		$page->cities = $citylist;
		$page->products = $products;
		$page->categories = Kohana::config('global.categories');

		$this->response->body($page);
	}
	
	public function action_edit($id=NULL)
	{
		$page = View::factory('tilbud/admin/deals/deal_form');
		$page->label = 'Edit a Deal';
		
		$deals = ORM::factory('deal', $id);
		
		$allproducts = ORM::factory('product');
		$result_products = $allproducts->order_by('ID', 'ASC')->find_all();

		$products = array();
		foreach($result_products as $p) {
		  $p_arr = $p->as_array();
		  $products[$p_arr['ID']] = $p_arr['title'];
		}


		// Get posts
		$posts = $this->request->post();

		// This will check if submitted
		if(!empty($posts)) {
			//echo '<pre>'; print_r($posts); echo '</pre>'; exit;
		  //$deals->product_id 	= htmlentities($posts['deal_product']);
			$deals->title 			= htmlentities($posts['deal_title']);
			$deals->description = htmlentities($posts['deal_desc']);
			$deals->contents_title = htmlentities($posts['deal_content_title']);
			$deals->contents		= $posts['deal_desc_long'];
			$deals->whatyouget	= htmlentities($posts['deal_whatyouget']);
			$deals->information	= htmlentities($posts['deal_information']);
			$deals->city_id 	 	= (int)$posts['deal_city'];
			$deals->group_id		= (int)$posts['deal_group'];
			$deals->regular_price = number_format($posts['deal_regular_price'], 2, '.', '');
			$deals->discount  	= (int)$posts['deal_discount'];
			$deals->reference_no= htmlentities($posts['deal_refno']);
			$deals->youtube_url	= $this->clean_video_url($posts['deal_video_url']);
			//$deals->vouchers 	 	= (int)$posts['deal_vouchers'];
			$deals->min_buy 	 	= (int)$posts['deal_min_buy'];
			$deals->max_buy 	 	= (int)$posts['deal_max_buy'];
			$deals->min_sold 	 	= (int)$posts['deal_min_sold'];
			$deals->max_sold 	 	= (int)$posts['deal_max_sold'];
			$deals->status  		= htmlentities($posts['deal_status']);
			$deals->start_date	= date("Y-m-d H:i:S", strtotime($posts['deal_start_date']));
			$deals->end_date		= date("Y-m-d H:i:S", strtotime($posts['deal_start_date'] . " 23:59:59"));
			$deals->expiry_date = date("Y-m-d H:i:S", strtotime($posts['deal_expiry_date'] . " 23:59:59"));
			$deals->last_update = date("Y-m-d H:i:S");
			$deals->is_featured = 1;

			if($deals->save()) {
				// message: save success
        Message::add('success', __('Deal ' . $deals->title . 'has been successfully added.'));
				
				// Update all the Category Relationships
				$posts['category'] = !empty($posts['category']) ? $posts['category'] : array();		
				ORM::factory('category')->update_relationship($deals->ID, $posts['category']);
				
				// Assuming all is correct
				Request::current()->redirect('admin/deals');
				return;
			}
		}
		
		//$page->deal_product 	= isset($posts['deal_product']) ? $posts['deal_product'] : $deals->product_id;
		$page->city_id				= isset($posts['deal_group']) ? $posts['deal_group'] : $deals->city_id;
		$page->group					= isset($posts['deal_group']) ? $posts['deal_group'] : $deals->group_id;
		$page->deal_title 		= isset($posts['deal_title']) ? $posts['deal_title'] : html_entity_decode($deals->title);
		$page->deal_desc 			= isset($posts['deal_desc']) ? $posts['deal_desc'] : html_entity_decode($deals->description);
		$page->deal_desc_long = isset($posts['deal_desc_long']) ? $posts['deal_desc_long'] : html_entity_decode($deals->contents);
		$page->deal_whatyouget = isset($posts['deal_whatyouget']) ? $posts['deal_whatyouget'] : html_entity_decode($deals->whatyouget);
		$page->deal_content_title = isset($posts['deal_content_title']) ? $posts['deal_content_title'] : html_entity_decode($deals->contents_title);
		$page->deal_information = isset($posts['deal_information']) ? $posts['deal_information'] : html_entity_decode($deals->information);
		$page->deal_city = isset($posts['deal_city']) ? $posts['deal_city'] : $deals->city_id;
		$page->deal_regular_price 	= isset($posts['deal_regular_price']) ? $posts['deal_regular_price'] : $deals->regular_price;
		$page->deal_discount 	= isset($posts['deal_discount']) ? $posts['deal_discount'] : $deals->discount;
		$page->deal_vouchers 	= isset($posts['deal_vouchers']) ? $posts['deal_vouchers'] : $deals->vouchers;
		$page->deal_min_buy 	= isset($posts['deal_min_buy']) ? $posts['deal_min_buy'] : $deals->min_buy;
		$page->deal_max_buy 	= isset($posts['deal_max_buy']) ? $posts['deal_max_buy'] : $deals->max_buy;
		$page->deal_min_sold 	= isset($posts['deal_min_sold']) ? $posts['deal_min_sold'] : $deals->min_sold;
		$page->deal_max_sold 	= isset($posts['deal_max_sold']) ? $posts['deal_max_sold'] : $deals->max_sold;
		$page->deal_status 		= isset($posts['deal_status']) ? $posts['deal_status'] : $deals->status;
		$page->deal_video_url	= isset($posts['deal_video_url']) ? $posts['deal_video_url'] : $deals->youtube_url;
		$page->start_date 		= isset($posts['deal_start_date']) ? $posts['deal_start_date'] : date("Y/m/d", strtotime($deals->start_date));
		$page->end_date 			= isset($posts['deal_end_date']) ? $posts['deal_end_date'] : date("Y/m/d", strtotime($deals->end_date));
		$page->expiry_date 		= isset($posts['deal_expiry_date']) ? $posts['deal_expiry_date'] : date("Y/m/d", strtotime($deals->expiry_date));
		$page->deal_refno			= isset($posts['deal_refno']) ? $posts['deal_refno'] : $deals->reference_no;

		$page->cities = Kohana::config('global.cities');
		$page->products = $products;
		$page->categories = Kohana::config('global.categories');
		$page->deal_categories = $deals->get_categories($deals->ID);

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
	
	public function clean_video_url($url)
	{
		$youtube_url = 'http://www.youtube.com/watch?';
		preg_match('/youtube|youtu.be|vimeo/', $url, $match);

		switch($match[0]) {
		case 'youtube':
				preg_match('~v=([-_\d\w]+)~is', $url, $match);
				$clean_url = !empty($match) ? $youtube_url . $match[0] : $url;
				break;
		case 'youtu.be':
				$clean_url = str_replace("/", "", str_replace("http://youtu.be/", "", $url));
				$clean_url = $youtube_url . 'v=' . $clean_url;
				break;
		case 'vimeo':
				$clean_url = $url;
				break;
		}
		
		return $clean_url;
	}
	
} // End Welcome
