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
		$dir  = isset($_GET['dir']) ? 'ASC' : 'DESC';
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
				&& (strlen($get['cid']) > 0 || strlen($get['gid']) > 0 || strlen($get['status']) > 0)) {
					$city_id = (int)$get['cid'] > 0 ? (int)$get['cid'] : "";
					$cat_id  = (int)$get['gid'] > 0 ? (int)$get['gid'] : "";
					$status = isset($get['status']) ? trim($get['status']) : "";
				
				if($city_id > 0 || $cat_id > 0 || isset($status)) {
					if($city_id > 0 && $cat_id > 0 && strlen($status) > 0) {
						$total = DB::select()->from('v_orders')->where('city_id', '=', $city_id)
																									 ->and_where('group_id', '=', $cat_id)
																									 ->and_where('status', '=', $status)
																									 ->execute()->count();
						$search = DB::select()->from('v_orders')->where('city_id', '=', $city_id)
																										->and_where('group_id', '=', $cat_id)
																										->and_where('status', '=', $status)
																										->limit($pagination->items_per_page)
																										->offset($pagination->offset)
																										->execute();
						
						$search_str = __(LBL_CITY) . ': ' . ORM::factory('city', $city_id)->name . ' , ' . 
													__(LBL_GROUP) . ': ' . ORM::factory('category', $cat_id)->name . ' , ' .
													__(LBL_STATUS) . ': ' . $this->get_lbl_status($status);
					} else {
						$id = $city_id>0 ? $city_id : $cat_id;
						$col = $city_id>0 ? 'city_id' : 'group_id';
						$model = $city_id>0 ? 'city' : 'category';
						$label = $city_id>0 ? __(LBL_CITY) : __(LBL_GROUP);

					  if(strlen($status) > 0 && $id==0) {
							$total = DB::select()->from('v_orders')->where('status', '=', $status)
																										 ->execute()->count();
							$search = DB::select()->from('v_orders')->where('status', '=', $status)
																											->limit($pagination->items_per_page)
																											->offset($pagination->offset)
																											->execute();
																											
							$search_str = __(LBL_STATUS) . ': ' . $this->get_lbl_status($status);
						} else if(strlen($status) > 0 && $id > 0) {
							$total = DB::select()->from('v_orders')->where($col, '=', $id)
																										 ->and_where('status', '=', $status)
																										 ->execute()->count();
							$search = DB::select()->from('v_orders')->where($col, '=', $id)
																											->and_where('status', '=', $status)
																											->limit($pagination->items_per_page)
																											->offset($pagination->offset)
																											->execute();
																											
							$search_str = $label . ': ' . ORM::factory($model, $id)->name . ' , ' . 
														__(LBL_STATUS) . ': ' . $this->get_lbl_status($status);
						} else {
							$total = DB::select()->from('v_orders')->where($col, '=', $id)->execute()->count();
							$search = DB::select()->from('v_orders')->where($col, '=', $id)
																		->limit($pagination->items_per_page)
														  			->offset($pagination->offset)
																		->execute();
							$search_str = $label . ': ' . ORM::factory($model, $id)->name;
						}
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
		
		$status = array('' => __(LBL_STATUS),
										'new' => __(LBL_ORDER_NEW),
										'delivered' => __(LBL_ORDER_DELIVERED),
										'cancelled' => __(LBL_ORDER_CANCELLED),
										'notreached' => __(LBL_ORDER_NOTREACHED));
		
		$page->status = $status;
		$page->cities = Kohana::config('global.cities');
		$page->categories = Kohana::config('global.categories');
		
		$this->response->body($page);
	}
	
	/**
	 * This is the operation for the action performed on the
	 * index page.
	 */
	public function action_process()
	{
		$posts = $this->request->post();
		if(isset($posts['action'])) {
			
			// Substitution for language
			if($posts['action'] == __(LBL_DELETE)) {
				$posts['action'] = 'delete';
			} else if ($posts['action'] == __(LBL_SEND_EMAIL)) {
				$posts['action'] = 'sendpdf';
			}
			
			$action = strtolower(str_replace(" ", "", $posts['action']));
			$ids		= $posts['obox'];
			$label	= count($ids)==1 ? __(LBL_ORDER) : __(LBL_ORDERS);
			
			switch($action) {
				// Send Email
				case 'sendpdf':
					foreach($ids as $oid) {
						$order = ORM::factory('order', $oid);
						
						// Update Total Sold
						if($order->status == 'delivered') {
							$this->send_mail_template($oid, $status);
						}
					}
	
					// Delete message
					Message::add('success', __(LBL_EMAIL_SENT));
	
					break;
				
				// Delete orders
				case 'delete':
					foreach($ids as $oid) {
						$order = ORM::factory('order', $oid);
						
						// Update Total Sold
						if($order->status == 'delivered') {
							$deal = ORM::factory('deal', $order->deal_id);
							$deal->total_sold-=$order->total_count;
							$deal->save();
						}
						
						if($order->loaded()) {
							$order->delete();
							
							// Delete message
							Message::add('success', sprintf(__(LBL_SUCCESS_DELETE), $label, __(LBL_STATUS)));
						}
					}
					break;
				
				// Update order status
				case 'set':
					$status = $posts['status'];
					
					switch($status) {
						case 'new':
							$query = DB::update('orders')->set(array('status' => $status))
																					 ->where('ID', 'IN', $ids)
																					 ->execute();
							Message::add('success', sprintf(__(LBL_SUCCESS_UPDATE), $label, __(LBL_STATUS)));
							break;
							
						case 'delivered':
							$query = DB::update('orders')->set(array('status' => $status))
																					 ->where('ID', 'IN', $ids)
																					 ->execute();
							
							// Send Emails
							foreach($ids as $oid) {
								$this->send_mail_template($oid, $status);
								// Update deals total sold
								$order = ORM::factory('order', $oid);
								$deal = ORM::factory('deal', $order->deal_id);
								$deal->total_sold+=$order->total_count;
								$deal->save();

                // Send Sms to customer
								$this->send_sms($order);
							}
							
							// Update 
							Message::add('success', sprintf(__(LBL_SUCCESS_UPDATE), $label, __(LBL_STATUS)));
							break;
							
						case 'cancelled':
							$query = DB::update('orders')->set(array('status' => $status))
																					 ->where('ID', 'IN', $ids)
																					 ->execute();
							// Send Emails
							foreach($ids as $oid) {
								$this->send_mail_template($oid, $status);
								
								// Update deals total sold
								$order = ORM::factory('order', $oid);
								$deal = ORM::factory('deal', $order->deal_id);
								$deal->total_sold-=$order->total_count;
								$deal->save();
							}
							
							Message::add('success', sprintf(__(LBL_SUCCESS_UPDATE), $label, __(LBL_STATUS)));
							break;
							
						case 'notreached':
							$query = DB::update('orders')->set(array('status' => $status))
																					 ->where('ID', 'IN', $ids)
																					 ->execute();
							// Send Emails
							foreach($ids as $oid) {
								$this->send_mail_template($oid, $status);
							}
							
							Message::add('success', sprintf(__(LBL_SUCCESS_UPDATE), $label, __(LBL_STATUS)));
							break;
					}

					break;
			}
		}
		
		Request::current()->redirect('admin/orders');
		return;
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
					
					if($orders->status == 'delivered') {
						$deal = ORM::factory('deal', $orders->deal_id);
						$deal->total_sold-=$orders->total_count;
						$deal->save();
					}
					
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
				$this->send_mail_template($order->ID, $status);
				
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
		
		$this->response->body($page);
	}
	
	public function send_sms($order)
	{
	  $user = ORM::factory('user', $order->user_id);
	  if ($user->mobile != "") {
        $message = "Din ordre er nu leveret. Dit refferance nummer er: '" + $order->refno . "' Hilsen www.Tilbudibyen.dk";
        $message = urlencode($message);
        $url = "http://www.email2sms.dk/cgi/url_api/incoming.cgi?login=846919dml&password=846919dml&action=send&to=0063" . trim($user->mobile) . "&from=tilbudibyen&text=$message";

        $ch = curl_init($url);
        $fp = fopen("sms_sending.log", "w");
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }
	}
	
	public function send_mail_template($id, $status=NULL)
	{
		$order = ORM::factory('order', $id);
		$status = isset($status) ? $status : $order->status;
		
		// Check if order has values
		if(is_null($order->ID)) {
			return FALSE;
		}

		$deal	 = ORM::factory('deal', $order->deal_id);
		$user = ORM::factory('user', $order->user_id);

		switch($status) {
			case 'new':
				break;
				
			case 'delivered':
				require_once(APPPATH . 'vendor/html2fpdf/html2pdf.class.php');
				
				ob_start();
				include_once(APPPATH . 'views/tilbud/template_order.php');
				$message = ob_get_clean();
									
				$mailer = new XMail();
				$mailer->to = $user->email;
				$mailer->subject = "Tillykke med dit " . mb_convert_encoding("køb", "ISO-8859-1", "UTF-8") . ": " . html_entity_decode($deal->contents_title) . " hos TilbudiByen.com (Ordrenummer {$order->ID})";
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
				
			case 'cancelled':
				$mailer = new XMail();
				$mailer->to = $user->email;
				$mailer->subject = "[" . __(LBL_ORDER_CANCELLED) . "] " . $order->refno . " hos TilbudiByen.com (Ordrenummer {$order->ID})";
				$mailer->message = __(LBL_ORDER_CANCELLED);
				
				$mailer->send();
				
				break;
				
			case 'notreached':
				$mailer = new XMail();
				$mailer->to = $user->email;
				$mailer->subject = "[" . __(LBL_ORDER_NOTREACHED) . "] " . $order->refno . " hos TilbudiByen.com (Ordrenummer {$order->ID})";
				$mailer->message = __(LBL_ORDER_NOTREACHED);
				
				$mailer->send();
				
				break;
				
			default:
				return FALSE;
				break;
		}
	}
	
	public function get_lbl_status($s)
	{
		switch($s) {
		case 'delivered': 	$s_lbl = __(LBL_ORDER_DELIVERED); break;
		case 'notreached': 	$s_lbl = __(LBL_ORDER_NOTREACHED); break;
		case 'cancelled': 	$s_lbl = __(LBL_ORDER_DELIVERED); break;
		case 'new': 				$s_lbl = __(LBL_ORDER_NEW); break;
		}
		
		return $s_lbl;
	}
} // End Welcome