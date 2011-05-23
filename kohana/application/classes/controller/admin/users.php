<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Users extends Controller_Useradmin_User {
	
	public function action_index()
	{	
		$page = View::factory('/tilbud/admin/user_index');
		$page->group = 0; // This is set to all
		
		$posts = $this->request->post();
		
		$users = ORM::factory('user');
		$total = $users->count_all();
		
		// Create a paginator
		$pagination = new Pagination(array(
			 'total_items' 		=> $total,
			 'items_per_page'	=> 15, // set this to 30 or 15 for the real thing, now just for testing purposes...
			 'auto_hide' 			=> false,
			 'view'           => 'pagination/useradmin',
		));
		
		// Get the items for the query
		$sort = isset($_GET['sort']) ? $_GET['sort'] : 'username'; // set default sorting direction here
		$dir = isset($_GET['dir']) ? 'DESC' : 'ASC';
		$result = $users->limit($pagination->items_per_page)
									  ->offset($pagination->offset)
										->order_by($sort, $dir)
										->find_all();

		if(!empty($posts)) {
			// If user made a search
			if(isset($posts['search_string']) && isset($posts['search_filter'])
				&& strlen($posts['search_string']) > 0) {
				// Validate fields
				
				$search_str = strip_tags(strtolower($posts['search_string']));
				switch($posts['search_filter']) {
				case 'email':
					// Search for Email
					$tsearch = $users->where(DB::expr('LOWER(email)'), 'like', '%' . $search_str . '%')->count_all();
					$search = $users->where(DB::expr('LOWER(email)'), 'like', '%' . $search_str . '%')
													->limit($pagination->items_per_page)
													->offset($pagination->offset)
													->find_all();
					break;
					
				case 'name':
					// Search for Full name
					$sql = "SELECT * FROM users WHERE LOWER(CONCAT(firstname, ' ', lastname)) LIKE '%{$search_str}%'";
					$search = DB::query(Database::SELECT, $sql)->execute()->as_array();
					$tsearch = DB::query(Database::SELECT, $sql)->execute()->count();
					break;
					
				case 'order':
					// Search for Order Number
					$order = ORM::factory('order', (int)$search_str);
					$tsearch = $users->where('id', '=', $order->user_id)->count_all(); 
					$search = $users->where('id', '=', $order->user_id)
													->limit($pagination->items_per_page)
													->offset($pagination->offset)
													->find_all();
					$search_str = __(LBL_ORDER_NUMBER) . ': ' . $search_str;
					break;
				}
				
				$page->query_result = sprintf(__(LBL_SEARCH_RESULT), $search_str, $tsearch);
				$pagination->total_items = $tsearch;
				$result = $search;

			} // End of Search
			
			// Show Users by Subscriber
			if(isset($posts['show_city']) && $posts['show_city'] > 0) {
				$subs = ORM::factory('subscriber')->get_subscribers_by_city($posts['show_city']);
			
				foreach($subs as $e) {
					$emails[] = $e['email'];
				}
			
				if(!empty($emails)) {
					$pagination->total_items = $users->where('email','in', $emails)->count_all();
					$page->group 						 = (int)$posts['show_city'];
					
					$result = $users->limit($pagination->items_per_page)
												->offset($pagination->offset)
												->order_by($sort, $dir)
												->where('email', 'in', $emails)
												->find_all();
				} else {
					$result = array(0);
					$pagination->total_items = 0;
				}
			} // End of show users by subscriber
		}
		
		if(!empty($result)) {
			$res = array();
			foreach($result as $ven) {
				$res[] = !is_array($ven) ? $ven->as_array() : $ven;
			}
		}

		// Show Pager
		$show_page = ($total > $pagination->items_per_page) ? TRUE : FALSE;

	  $cities = Kohana::config('global.cities');
	  $categories = Kohana::config('global.categories');

		$page->paging = $pagination;
		$page->users	= $res;
		$page->cities = $cities;
		$page->categories = $categories;
		$page->show_pager = $show_page;

		$this->template->content = $page;
	}
	
	public function action_add()
	{
		// set the template title (see Controller_App for implementation)
      $this->template->title = __('Edit user');
      // load the content from view
      $view = View::factory('/tilbud/admin/user_form');
			$view->label = __(LBL_USER_ADD);
			$view->user_types = array('admin' => 'Administrator',
															  'user'  => 'Regular User');
			
			$posts = $this->request->post();
			
			if(!empty($posts)) {
				$fields = array('username','email','firstname','lastname','group_id','mobile','address','password');
				
				$clean['group'] = $posts['group'];
				$clean['firstname'] = $posts['firstname'];
				$clean['lastname'] = $posts['lastname'];
				$clean['email'] = $posts['email'];
				$clean['username'] = substr($posts['email'], 0, strpos($posts['email'], "@"));
				$clean['password'] = $posts['password'];
				$clean['password_confirm'] = $posts['password_confirm'];
				$clean['user_type'] = 'user'; // default  $posts['user_type'];
				$clean['group_id'] = $posts['group'];
				$clean['mobile'] = $posts['mobile'];
				$clean['address']		= $posts['address'];
				
				$user = ORM::factory('user');
				
				try {
					$user->create_user($clean, $fields);
					$result = true;
				} catch (ORM_Validation_Exception $e) {
					$errors = $e->errors('register');
					$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()) );
					print_r($errors);
				}	
				
				if(empty($errors)) {
					// Update Roles
					$user->add('roles', ORM::factory('role')->where('name', '=', 'login')->find());
					/*
					Removed upon clients requests --(x x)--
					if($posts['user_type'] == 'admin') {
						$user->add('roles', ORM::factory('role')->where('name', '=', 'admin')->find());
					} */
					
					// message: save success
					Message::add('success', __('User ' . $user->email . ' has been successfully added.'));
					// redirect and exit
					Request::current()->redirect('admin/users');
					return;
				} else {
					$view->errors = $errors;
				}
			}

			$view->username  = isset($posts['username']) ? $posts['username'] : '';
			$view->firstname = isset($posts['firstname']) ? $posts['firstname'] : '';
			$view->lastname  = isset($posts['lastname']) ? $posts['lastname'] : '';
			$view->email 		 = isset($posts['email']) ? $posts['email'] : '';
			$view->mobile		 = isset($posts['mobile']) ? $posts['mobile'] :'';
			$view->user_type = isset($posts['user_type']) ? $posts['user_type'] : 'user';
			$view->group		 = isset($posts['group']) ? $posts['group'] : 0;
			$view->address	 = isset($posts['address']) ? $posts['address'] : '';
			
			$view->groups 	 = Kohana::config('global.categories');

      $this->template->content = $view;
	}
	
	public function action_edit($id)
	{
		$user = ORM::factory('user', $id);
		// set the template title (see Controller_App for implementation)
		$this->template->title = __('Edit user');
		// load the content from view
		$view = View::factory('/tilbud/admin/user_form');
		$view->label = __(LBL_USER_EDIT);
		$view->user_types = array('admin' => 'Administrator',
															'user'  => 'Regular User');
		
		$posts = $this->request->post();
		
		if(!empty($posts)) {
			
			$fields = array('username','email','firstname','lastname','group_id','mobile','address');
			
			$clean['group'] 		= $posts['group'];
			$clean['firstname'] = $posts['firstname'];
			$clean['lastname'] 	= $posts['lastname'];
			$clean['email'] 		= $posts['email'];
			$clean['username'] 	= substr($posts['email'], 0, strpos($posts['email'], "@"));
			$clean['user_type'] = 'user'; //$posts['user_type'];
			$clean['group_id'] 	= $posts['group'];
			$clean['mobile'] 		= $posts['mobile'];
			$clean['address']		= $posts['address'];
			
			if(strlen($_POST['password']) > 0 && strlen($_POST['password_confirm']) > 0) {
				$clean['password'] = $posts['password'];
				$clean['password_confirm'] = $posts['password_confirm'];
				array_push($fields, 'password');
			}
			
			try {
				$user->update_user($clean, $fields);
				$result = true;
			} catch (ORM_Validation_Exception $e) {
				$errors = $e->errors('register');
				$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()) );
				print_r($errors);
			}	
			
			if(empty($errors)) {
				// Update Roles
				//$user->remove('roles');
				//$user->add('roles', ORM::factory('role')->where('name', '=', 'login')->find());
				/*
					Removed upon clients requests --(x x)--
					if($posts['user_type'] == 'admin') {
						$user->add('roles', ORM::factory('role')->where('name', '=', 'admin')->find());
					} */
				
				// message: save success
				Message::add('success', __(sprintf(LBL_SUCCESS_UPDATE, LBL_USER, $user->email)));
				// redirect and exit
				Request::current()->redirect('admin/users');
				return;
			} else {
				$view->errors = $errors;
			}
		}

		$user_type = $user->is_admin($user) ? 'admin' : 'user';

		$view->username  = isset($posts['username']) ? $posts['username'] : $user->username;
		$view->firstname = isset($posts['firstname']) ? $posts['firstname'] : $user->firstname;
		$view->lastname  = isset($posts['lastname']) ? $posts['lastname'] : $user->lastname;
		$view->email 		 = isset($posts['email']) ? $posts['email'] : $user->email;
		$view->mobile		 = isset($posts['mobile']) ? $posts['mobile'] : $user->mobile;
		$view->user_type = isset($posts['user_type']) ? $posts['user_type'] : $user_type;
		$view->group		 = isset($posts['group']) ? $posts['group'] : $user->group_id;
		$view->address	 = isset($posts['address']) ? $posts['address'] : $user->address;
		$view->is_edit	 = TRUE;
		
		$view->groups 	 = Kohana::config('global.categories');

		$this->template->content = $view;
	}
	
	public function action_delete($id=NULL)
	{
		$page = View::factory('tilbud/admin/confirm_user_delete');
		$page->label =__(LBL_USER_DELETE);
	
		$user = ORM::factory('user', $id);
		
		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
			
			if(strcmp($posts['submit'], 'Ok') == 0) {
				if($user->loaded()) {
					$name = $user->firstname . ' ' . $user->lastname;
					$user->delete();
				}
			}
			
			// message: save success
			Message::add('success', sprintf(LBL_SUCCESS_DELETE, LBL_USER, $name));
			
			// Assuming all is correct
			Request::current()->redirect('admin/users');
			return;

		} else {
		
			$rec['email'] = html_entity_decode($user->email);
			$rec['name'] 	= html_entity_decode($user->firstname) . ' ' . html_entity_decode($user->lastname);
			
			$page->records = $rec;
		}
		
		$this->template->content = $page;
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
	
} // End of Admin Users