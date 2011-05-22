<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Deals extends Controller {

	public function action_index()
	{		

		$page = View::factory('tilbud/admin/deals/index');
		$deals = ORM::factory('deal');
		
		$total = $deals->count_all();
		$pagination = new Pagination(array(
									 'total_items' 		=> $total,
									 'items_per_page'	=> 10, 
									 'auto_hide' 			=> false,
									 'view'           => 'pagination/useradmin',));
		$sort = isset($_GET['sort']) ? $_GET['sort'] : 'ID'; // set default sorting direction here
		$dir  = isset($_GET['dir']) ? 'DESC' : 'ASC';
		$result = $deals->limit($pagination->items_per_page)->offset($pagination->offset)->order_by($sort, $dir)
							->find_all();
				
		// Check for actions
		if(!empty($_GET)) {
			$get = $_GET;
			
			// Filter for dates
			if(isset($get['s']) && isset($get['f']) && (strlen($get['s']) > 0 || strlen($get['df']) > 0 || strlen($get['dt']) > 0)) {
				
				$search_str = strip_tags(strtolower($get['s']));
				
				switch($get['f']) {
				case 'deals':
					// Search for Email
					$total = $deals->where('description', 'like', '%' . $search_str . '%')->count_all();
					$search = $deals->where('description', 'like', '%' . $search_str . '%')
																->limit($pagination->items_per_page)
																->offset($pagination->offset)
																->find_all();
					break;
				
				case 'startdate':
					$from = strlen($get['df']) > 0 ? $get['df'] : date("Y-m-d");
					$to   = strlen($get['dt']) > 0 ? $get['dt'] : date("Y-m-d");
					
					if(strlen($from) > 0 && strlen($to) > 0) {
						$total = $deals->where(DB::expr('DATE(start_date)'), '>=', $from)->and_where(DB::expr('DATE(start_date)'), '<=', $to)->count_all();
						$search = $deals->where(DB::expr('DATE(start_date)'), '>=', $from)->and_where(DB::expr('DATE(start_date)'), '<=', $to)
														->limit($pagination->items_per_page)
														->offset($pagination->offset)
														->find_all();
						$search_str = __(LBL_DEAL_START_DATE) . ': ' . date("Y-m-d", strtotime($from)) . ' - ' . date("Y-m-d", strtotime($to));
					} else {
						
					}
					break;
					
				case 'enddate':
					$from = strlen($get['df']) > 0 ? $get['df'] : date("Y-m-d");
					$to   = strlen($get['dt']) > 0 ? $get['dt'] : date("Y-m-d");
					
					if(strlen($from) > 0 && strlen($to) > 0) {
						$total = $deals->where(DB::expr('DATE(end_date)'), '>=', $from)->and_where(DB::expr('DATE(end_date)'), '<=', $to)->count_all();
						$search = $deals->where(DB::expr('DATE(end_date)'), '>=', $from)->and_where(DB::expr('DATE(end_date)'), '<=', $to)
														->limit($pagination->items_per_page)
														->offset($pagination->offset)
														->find_all();
						$search_str = __(LBL_DEAL_END_DATE) . ': ' . date("Y-m-d", strtotime($from)) . ' - ' . date("Y-m-d", strtotime($to));
					} else {
						
					}
					break;
					
				case 'date':
					$from = strlen($get['df']) > 0 ? $get['df'] : date("Y-m-d");
					$to   = strlen($get['dt']) > 0 ? $get['dt'] : date("Y-m-d");
					
					if(strlen($from) > 0 && strlen($to) > 0) {
						$total = $deals->where(DB::expr('DATE(start_date)'), '>=', $from)->and_where(DB::expr('DATE(end_date)'), '<=', $to)->count_all();
						$search = $deals->where(DB::expr('DATE(start_date)'), '>=', $from)->and_where(DB::expr('DATE(end_date)'), '<=', $to)
														->limit($pagination->items_per_page)
														->offset($pagination->offset)
														->find_all();
						$search_str = __(LBL_DEAL_START_DATE) . ': ' . date("Y-m-d", strtotime($from)) . ' - ' .
													__(LBL_DEAL_END_DATE). ': ' . date("Y-m-d", strtotime($to));
					} else {
						
					}
					break;
				}
				
				$page->query_result = sprintf(__(LBL_SEARCH_RESULT), $search_str, $total);
				$pagination->total_items = $total;
				$result = $search;
			}
			
			// Filter for City and Category
			if(isset($get['cid']) && isset($get['gid']) && (strlen($get['cid']) > 0 || strlen($get['gid']) > 0)) {
					$city_id = (int)$get['cid'] > 0 ? (int)$get['cid'] : "";
					$cat_id  = (int)$get['gid'] > 0 ? (int)$get['gid'] : "";
					
				if($city_id > 0 || $cat_id > 0) {
					if($city_id > 0 && $cat_id > 0) {
						$total = $deals->where('city_id', '=', $city_id)->and_where('group_id', '=', $cat_id)->count_all();
						$search = $deals->where('city_id', '=', $city_id)->and_where('group_id', '=', $cat_id)
																	->limit($pagination->items_per_page)
													  			->offset($pagination->offset)
																	->find_all();
						
						$search_str = __(LBL_CITY) . ': ' . ORM::factory('city', $city_id)->name . ' , ' . 
													__(LBL_GROUP) . ': ' . ORM::factory('category', $cat_id)->name;
					} else {
						$id = $city_id>0 ? $city_id : $cat_id;
						$col = $city_id>0 ? 'city_id' : 'group_id';
						$model = $city_id>0 ? 'city' : 'category';
						$label = $city_id>0 ? __(LBL_CITY) : __(LBL_GROUP);
						
						$total = $deals->where($col, '=', $id)->count_all();
						$search = $deals->where($col, '=', $id)->limit($pagination->items_per_page)
													  											 ->offset($pagination->offset)
																									 ->find_all();
																	
						$search_str = $label . ': ' . ORM::factory($model, $id)->name;
					}
					
					$page->query_result = sprintf(__(LBL_SEARCH_RESULT), $search_str, $total);
					$pagination->total_items = $total;
					$result = $search;
				} 
			}
						
			// Check if send mail is accessed
			if(isset($_GET['action']) && $_GET['action'] = 'email') {
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
				$deals = ORM::factory('deal', (int)$_GET['did']);
				
				ob_start();
				include_once(APPPATH . 'views/tilbud/template_email.php');
				$content = ob_get_clean();
	
				$message  = 'Content-type: text/html; charset="iso-8859-1"' . "\r\n";
				$message .= $content;
	
				$subscribers = ORM::factory('category')->get_subscribers($_GET['city']);
				
				if(!empty($subscribers)) {
					foreach($subscribers as $sub) {
						if(mail($sub['email'], $subject, $message, $headers)) {
							$send=true;
						}
					}
				} else {
					Message::add('success', __('No user has been subscribe on this city.'));
				}
				
				if($send==true) {
					// message: save success
					Message::add('success', __('Email has been sent to subscribers'));
					
					Request::current()->redirect('admin/deals');
					return;
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
			$page->deals = $res;
			$page->show_pager = $show_page;
		}	
	
		$page->cities = Kohana::config('global.cities');
		$page->categories = Kohana::config('global.categories');
		
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
			$deals->title 			= htmlentities($posts['deal_title'], ENT_QUOTES ,"ISO8859-1");
			$deals->description = htmlentities($posts['deal_desc']);
			$deals->contents_title = htmlentities($posts['deal_content_title']);
			$deals->contents		= htmlentities($posts['deal_desc_long']);
			$deals->whatyouget	= htmlentities($posts['deal_whatyouget']);
			$deals->information	= htmlentities($posts['deal_information']);
			$deals->city_id 	 	= (int)$posts['deal_city'];
			$deals->group_id		= (int)$posts['deal_group'];
			$deals->regular_price = number_format($posts['deal_regular_price'], 2, '.', '');
			$deals->discount  	= (int)$posts['deal_discount'];
			//$deals->vouchers 	 	= (int)$posts['deal_vouchers'];
			$deals->reference_no= htmlentities($posts['deal_refno']);

			if ($posts['deal_video_url'] != "") {
			  //$deals->youtube_url	= $this->clean_video_url($posts['deal_video_url']);
			  $deals->youtube_url	= $posts['deal_video_url'];
		  }else {
		    $deals->youtube_url = "";
		  }

			$deals->min_buy 	 	= (int)$posts['deal_min_buy'];
			$deals->max_buy 	 	= (int)$posts['deal_max_buy'];
			$deals->min_sold 	 	= (int)$posts['deal_min_sold'];
			$deals->max_sold 	 	= (int)$posts['deal_max_sold'];
			$deals->status  		= htmlentities($posts['deal_status']);
			$deals->start_date	= date("Y-m-d H:i:S", strtotime($posts['deal_start_date']));
			$deals->end_date		= date("Y-m-d H:i:S", strtotime($posts['deal_end_date'] . " 23:59:59"));
			$deals->expiry_date = date("Y-m-d H:i:S", strtotime($posts['deal_expiry_date'] . " 23:59:59"));
			$deals->addresses		= htmlentities($posts['deal_address']);
			$deals->is_featured = 1;
			
			if (isset($_FILES['deal_image'])) {
			  $deals->image = $_FILES['deal_image']['name'];
			}
			if (isset($_FILES['deal_image2'])) {
			  $deals->image2 = $_FILES['deal_image2']['name'];
			}
			if (isset($_FILES['deal_image3'])) {
			  $deals->image3 = $_FILES['deal_image3']['name'];
			}
			if (isset($_FILES['deal_image4'])) {
			  $deals->image4 = $_FILES['deal_image4']['name'];
			}
			if (isset($_FILES['deal_image5'])) {
			  $deals->image5 = $_FILES['deal_image5']['name'];
			}
			
			if (isset($_FILES['deal_facebook_image']) && $_FILES['deal_facebook_image'] != "") {
			  $deals->facebook_image = $_FILES['deal_facebook_image']['name'];
			}
			
			
			if($deals->save()) {
				if(!empty($_FILES)) {
				  
				  if (!file_exists(APPPATH . "../uploads/". $deals->ID)) {
			  	  mkdir(APPPATH . "../uploads/". $deals->ID);
			  	}
			  	
				  if ($_FILES['deal_image']) {
  			  	move_uploaded_file($_FILES["deal_image"]["tmp_name"], APPPATH . "../uploads/" . $deals->ID . "/" . $_FILES["deal_image"]["name"]);
  			  }
  			  if ($_FILES['deal_image2']) {
			  	  move_uploaded_file($_FILES["deal_image2"]["tmp_name"], APPPATH . "../uploads/" . $deals->ID . "/" . $_FILES["deal_image2"]["name"]);
		  	  }
		  	  if ($_FILES['deal_image3']) {
			  	  move_uploaded_file($_FILES["deal_image3"]["tmp_name"], APPPATH . "../uploads/" . $deals->ID . "/" . $_FILES["deal_image3"]["name"]);
			  	}
			  	if ($_FILES['deal_image4']) {
			  	  move_uploaded_file($_FILES["deal_image4"]["tmp_name"], APPPATH . "../uploads/" . $deals->ID . "/" . $_FILES["deal_image4"]["name"]);
		  	  }
		  	  if ($_FILES['deal_image5']) {
			  	  move_uploaded_file($_FILES["deal_image5"]["tmp_name"], APPPATH . "../uploads/" . $deals->ID . "/" . $_FILES["deal_image5"]["name"]);
		  	  }
			  	

				  if (!file_exists(APPPATH . "../uploads/". $deals->ID)) {
			  	  mkdir(APPPATH . "../uploads/". $deals->ID);
			  	}
			  	move_uploaded_file($_FILES["deal_facebook_image"]["tmp_name"], APPPATH . "../uploads/" . $deals->ID . "/" . $_FILES["deal_facebook_image"]["name"]);
			  	
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
		$page->deal_min_buy 	= isset($posts['deal_min_buy']) ? $posts['deal_min_buy'] : 0;
		$page->deal_max_buy 	= isset($posts['deal_max_buy']) ? $posts['deal_max_buy'] : 5;
		$page->deal_min_sold 	= isset($posts['deal_min_sold']) ? $posts['deal_min_sold'] : 5;
		$page->deal_max_sold 	= isset($posts['deal_max_sold']) ? $posts['deal_max_sold'] : 0;
		$page->start_date 		= isset($posts['deal_start_date']) ? $posts['deal_start_date'] : date("Y/m/d");
		$page->end_date 			= isset($posts['deal_end_date']) ? $posts['deal_end_date'] : date("Y/m/d");
		$page->expiry_date 		= isset($posts['deal_expiry_date']) ? $posts['deal_expiry_date'] : '';
		$page->deal_status 		= isset($posts['deal_status']) ? $posts['deal_status'] : '';
		$page->deal_video_url	= isset($posts['deal_video_url']) ? $posts['deal_video_url'] : '';
		$page->deal_refno			= isset($posts['deal_refno']) ? $posts['deal_refno'] : '';
		$page->address		    = isset($posts['deal_address']) ? $posts['deal_address'] : $deals->addresses;
		$page->deal_image     = $deals->image;
		$page->deal_image2     = $deals->image2;
		$page->deal_image3     = $deals->image3;
		$page->deal_image4     = $deals->image4;
		$page->deal_image5     = $deals->image5;
		$page->deal_facebook_image     = $deals->facebook_image;



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
			$deals->title 			= htmlentities($posts['deal_title'], ENT_QUOTES ,"ISO8859-1");
			$deals->description = htmlentities($posts['deal_desc']);
			$deals->contents_title = htmlentities($posts['deal_content_title']);
			$deals->contents		= htmlentities($posts['deal_desc_long']);
			$deals->whatyouget	= htmlentities($posts['deal_whatyouget']);
			$deals->information	= htmlentities($posts['deal_information']);
			$deals->city_id 	 	= (int)$posts['deal_city'];
			$deals->group_id		= (int)$posts['deal_group'];
			$deals->regular_price = number_format($posts['deal_regular_price'], 2, '.', '');
			$deals->discount  	= (int)$posts['deal_discount'];
			$deals->reference_no= htmlentities($posts['deal_refno']);

			if ($posts['deal_video_url'] != "") {
			  //$deals->youtube_url	= $this->clean_video_url($posts['deal_video_url']);
			  $deals->youtube_url	= $posts['deal_video_url'];
		  }else {
		    $deals->youtube_url = "";
		  }
			//$deals->vouchers 	 	= (int)$posts['deal_vouchers'];
			$deals->min_buy 	 	= (int)$posts['deal_min_buy'];
			$deals->max_buy 	 	= (int)$posts['deal_max_buy'];
			$deals->min_sold 	 	= (int)$posts['deal_min_sold'];
			$deals->max_sold 	 	= (int)$posts['deal_max_sold'];
			$deals->status  		= htmlentities($posts['deal_status']);
			$deals->start_date	= date("Y-m-d H:i:S", strtotime($posts['deal_start_date']));
			$deals->end_date		= date("Y-m-d H:i:S", strtotime($posts['deal_end_date'] . " 23:59:59"));
			$deals->expiry_date = date("Y-m-d H:i:S", strtotime($posts['deal_expiry_date'] . " 23:59:59"));
			$deals->last_update = date("Y-m-d H:i:S");
			$deals->addresses		= htmlentities($posts['deal_address']);
			$deals->is_featured = 1;

			if ($_FILES['deal_image']['name'] != "") {
			  $deals->image = $_FILES['deal_image']['name'];
			}
			if ($_FILES['deal_image2']['name'] != "") {
			  $deals->image2 = $_FILES['deal_image2']['name'];
			}
			if ($_FILES['deal_image3']['name'] != "") {
			  $deals->image3 = $_FILES['deal_image3']['name'];
			}
			if ($_FILES['deal_image4']['name'] != "") {
			  $deals->image4 = $_FILES['deal_image4']['name'];
			}
			if ($_FILES['deal_image5']['name'] != "") {
			  $deals->image5 = $_FILES['deal_image5']['name'];
			}

			if (isset($_FILES['deal_facebook_image']) && $_FILES['deal_facebook_image'] != "") {
			  $deals->facebook_image = $_FILES['deal_facebook_image']['name'];
			}



			if($deals->save()) {

				if(!empty($_FILES)) {
				  if (!file_exists(APPPATH . "../uploads/". $deals->ID)) {
			  	  mkdir(APPPATH . "../uploads/". $deals->ID);
			  	}
				  
				  if ($_FILES['deal_image'] != "") {
  			  	move_uploaded_file($_FILES["deal_image"]["tmp_name"], APPPATH . "../uploads/" . $deals->ID . "/" . $_FILES["deal_image"]["name"]);
  			  }
  			  if ($_FILES['deal_image2'] != "") {
			  	  move_uploaded_file($_FILES["deal_image2"]["tmp_name"], APPPATH . "../uploads/" . $deals->ID . "/" . $_FILES["deal_image2"]["name"]);
		  	  }
		  	  if ($_FILES['deal_image3'] != "") {
			  	  move_uploaded_file($_FILES["deal_image3"]["tmp_name"], APPPATH . "../uploads/" . $deals->ID . "/" . $_FILES["deal_image3"]["name"]);
			  	}
			  	if ($_FILES['deal_image4'] != "") {
			  	  move_uploaded_file($_FILES["deal_image4"]["tmp_name"], APPPATH . "../uploads/" . $deals->ID . "/" . $_FILES["deal_image4"]["name"]);
		  	  }
		  	  if ($_FILES['deal_image5'] != "") {
            print_r($_FILES['deal_image5']);		  	    
			  	  move_uploaded_file($_FILES["deal_image5"]["tmp_name"], APPPATH . "../uploads/" . $deals->ID . "/" . $_FILES["deal_image5"]["name"]);
		  	  }
			  	
				  if (!file_exists(APPPATH . "../uploads/". $deals->ID)) {
			  	  mkdir(APPPATH . "../uploads/". $deals->ID);
			  	}
			  	move_uploaded_file($_FILES["deal_facebook_image"]["tmp_name"], APPPATH . "../uploads/" . $deals->ID . "/" . $_FILES["deal_facebook_image"]["name"]);
			  	
				}
			  
				// message: save success
        Message::add('success', __(sprintf(LBL_SUCCESS_UPDATE, LBL_DEALS, $deals->title)));
				
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
		$page->address		    = isset($posts['deal_address']) ? $posts['deal_address'] : html_entity_decode($deals->addresses);
		$page->deal_image     = $deals->image;
		$page->deal_image2     = $deals->image2;
		$page->deal_image3     = $deals->image3;
		$page->deal_image4     = $deals->image4;
		$page->deal_image5     = $deals->image5;
		$page->deal_facebook_image     = $deals->facebook_image;
		$page->deal_id        = $deals->ID;

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
