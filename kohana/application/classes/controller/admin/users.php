<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Users extends Controller_Useradmin_User {
	
	public function action_index()
	{	
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
							
		foreach($result as $ven) {
			$res[] = $ven->as_array();
		}

		// Show Pager
		$show_page = ($total > $pagination->items_per_page) ? TRUE : FALSE;

		$this->template->content = View::factory('/tilbud/admin/user_index')
																	->set('paging', $pagination)
																	->set('users', $res)
																	->set('show_pager', $show_page);
	}
	
	public function action_add()
	{
		// set the template title (see Controller_App for implementation)
      $this->template->title = __('Edit user');
      // load the content from view
      $view = View::factory('/tilbud/admin/user_form');
			$view->label = 'Add a User';
			$view->user_types = array('admin' => 'Administrator',
															 'user'  => 'Regular User');
			
			$posts = $this->request->post();
			
			if(!empty($posts)) {
				$user = ORM::factory('user');
				
				try {
					$user->create_user($posts, array('username','password','email'));
					$result = true;
				} catch (ORM_Validation_Exception $e) {
					$errors = $e->errors('register');
					$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()) );
				}	
				
				if(empty($errors)) {
					// Update Roles
					$user->add('roles', ORM::factory('role')->where('name', '=', 'login')->find());
					if($posts['user_type'] == 'admin') {
						$user->add('roles', ORM::factory('role')->where('name', '=', 'admin')->find());
					} 
					
					// message: save success
					Message::add('success', __('User ' . $user->username . ' has been successfully added.'));
					// redirect and exit
					Request::current()->redirect('admin/users');
					return;
				} else {
					$view->errors = $errors;
				}
			}

			$view->username  = isset($posts['username']) ? $posts['username'] : '';
			$view->email 		 = isset($posts['email']) ? $posts['email'] : '';
			$view->user_type = isset($posts['user_type']) ? $posts['user_type'] : 'user';

      $this->template->content = $view;
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