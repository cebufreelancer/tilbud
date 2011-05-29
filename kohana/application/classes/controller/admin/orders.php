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
		$get = $_GET;
		
		if(!empty($get)) {
			if(isset($get['s']) && isset($get['f'])
				&& (strlen($get['s']) > 0 || strlen($get['df']) > 0 || strlen($get['dt']) > 0)) {
				
				$search_str = strip_tags(strtolower($get['s']));
				
				switch($get['f']) {
				case 'email':
					// Search for Email
					$total = DB::select()->from('v_orders')->where(DB::expr('LOWER(email)'), 'like', '%' . $search_str . '%')->execute()->count();
					$search = DB::select()->from('v_orders')->where(DB::expr('LOWER(email)'), 'like', '%' . $search_str . '%')
																->limit($pagination->items_per_page)
																->offset($pagination->offset)
																->execute();
					break;
					
				case 'name':
					$total = DB::select()->from('v_orders')->where(DB::expr('LOWER(lastname)'), 'like', '%' . $search_str . '%')->execute()->count();
					$search = DB::select()->from('v_orders')->where(DB::expr('LOWER(lastname)'), 'like', '%' . $search_str . '%')
																->limit($pagination->items_per_page)
																->offset($pagination->offset)
																->execute();
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
					$search = $orders->where('refno', 'like', "%$search_str%")
													 ->limit($pagination->items_per_page)
													 ->offset($pagination->offset)
													 ->find_all();
					break;
				case 'date':
					$from = strlen($get['df']) > 0 ? $get['df'] : date("Y-m-d");
					$to   = strlen($get['dt']) > 0 ? $get['dt'] : date("Y-m-d");
					
					if(strlen($from) > 0 && strlen($to) > 0) {
						$total = $orders->where(DB::expr('DATE(date_created)'), '>=', $from)->and_where(DB::expr('DATE(date_created)'), '<=', $to)->count_all();
						$search = $orders->where(DB::expr('DATE(date_created)'), '>=', $from)->and_where(DB::expr('DATE(date_created)'), '<=', $to)
														 ->limit($pagination->items_per_page)
														 ->offset($pagination->offset)
														 ->find_all();
						$search_str = date("Y-m-d", strtotime($from)) . ' - ' . date("Y-m-d", strtotime($to));
					} else {
						
					}
					
					//$total = $orders->where(DB::expr('DATE(date_created)'), '=', '');
					break;
				}
				
				$page->query_result = sprintf(__(LBL_SEARCH_RESULT), $search_str, $total);
				$pagination->total_items = $total;
				$result = $search;
			}
			
			// For filters
			if(isset($get['cid']) && isset($get['gid'])
				&& (strlen($get['cid']) > 0 || strlen($get['gid']) > 0)) {
					$city_id = (int)$get['cid'] > 0 ? (int)$get['cid'] : "";
					$cat_id  = (int)$get['gid'] > 0 ? (int)$get['gid'] : "";
					
				if($city_id > 0 || $cat_id > 0) {
					if($city_id > 0 && $cat_id > 0) {
						$total = DB::select()->from('v_orders')->where('city_id', '=', $city_id)->and_where('group_id', '=', $cat_id)->execute()->count();
						$search = DB::select()->from('v_orders')->where('city_id', '=', $city_id)->and_where('group_id', '=', $cat_id)
																	->limit($pagination->items_per_page)
													  			->offset($pagination->offset)
																	->execute();
						
						$search_str = __(LBL_CITY) . ': ' . ORM::factory('city', $city_id)->name . ' , ' . 
													__(LBL_GROUP) . ': ' . ORM::factory('category', $cat_id)->name;
					} else {
						$id = $city_id>0 ? $city_id : $cat_id;
						$col = $city_id>0 ? 'city_id' : 'group_id';
						$model = $city_id>0 ? 'city' : 'category';
						$label = $city_id>0 ? __(LBL_CITY) : __(LBL_GROUP);
						
						$total = DB::select()->from('v_orders')->where($col, '=', $id)->execute()->count();
						$search = DB::select()->from('v_orders')->where($col, '=', $id)
																	->limit($pagination->items_per_page)
													  			->offset($pagination->offset)
																	->execute();
																	
						$search_str = $label . ': ' . ORM::factory($model, $id)->name;
					}
					
					$page->query_result = sprintf(__(LBL_SEARCH_RESULT), $search_str, $total);
					$pagination->total_items = $total;
					$result = $search;
				} 
			}
		}

		if(!empty($result)) {
			$res = array();
			foreach($result as $ven) {
				$res[] = !is_array($ven) ? $ven->as_array() : $ven;
			}
			
			// Show Pager
			$show_page = ($total > $pagination->items_per_page) ? TRUE : FALSE;
	
			$page->paging = $pagination;
			$page->orders	= $res;
			$page->show_pager = $show_page;
		}
		
		$page->cities = Kohana::config('global.cities');
		$page->categories = Kohana::config('global.categories');
		
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

	public function action_delete($id)
	{
		$page = View::factory('tilbud/admin/confirm_delete');
	
		$orders = ORM::factory('order', $id);
		
		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
			$refno = $orders->refno;
			if(strcmp($posts['submit'], 'Ok') == 0) {
				if($orders->loaded()) {
					$orders->delete();
				}
			}
		
			// message: save success
			Message::add('success', sprintf(LBL_SUCCESS_DELETE, LBL_ORDER, $refno));
		
			// Assuming all is correct
			Request::current()->redirect('admin/orders');
			return;

		} else {
			$users = ORM::factory('user', $orders->user_id);
			$deal = ORM::factory('deal', $orders->deal_id);
			
			$rec[LBL_REFERENCE_NO] 	= $orders->refno;
			$rec[LBL_CUSTOMER_NAME] = $users->firstname . ' ' . $users->lastname;
			$rec[LBL_DEAL] 					= $deal->description;
			$rec[LBL_QUANTITY] 			= $orders->quantity;
			$rec[LBL_AMOUNT_PAID] 	= $orders->total_count . ' DKK';
		}
		$this->response->body(View::factory('tilbud/admin/confirm_delete')
														->set('records',$rec)
														->set('label', __(LBL_ORDER_DELETE))
											);
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
					require_once(APPPATH . 'vendor/html2fpdf/html2pdf.class.php');
					
					$deal = ORM::factory('deal', $order->deal_id);
					$user = ORM::factory('user', $order->user_id);			
					
					ob_start();
					include_once(APPPATH . 'views/tilbud/template_after_order.php');
					$message = ob_get_clean();
										
					$mailer = new XMail();
					$mailer->to = $user->email;
					$mailer->subject = "Tillykke med dit køb: " . html_entity_decode($deal->contents_title) . " hos TilbudiByen.com (Ordrenummer {$order->ID})";;
					$mailer->message = $message;
					
					ob_start();
					include_once(APPPATH . 'views/tilbud/template_order_pdf.php');
					$content = ob_get_clean();
					
					$html2pdf = new HTML2PDF('P','A4','en');
					$html2pdf->WriteHTML($content, false);
					
					$html2out = $html2pdf->Output('','S');
					$filename = mb_convert_encoding("Værdibevis-" . $order->refno . ".pdf", "ISO-8859-1", "UTF-8");
					$mailer->addAttachment($filename, $html2out);
					
					$mailer->send();
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
