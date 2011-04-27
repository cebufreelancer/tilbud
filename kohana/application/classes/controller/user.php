<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller_App {
	
	/**
	 * @var string Filename of the template file.
	 */
  public $template = 'tilbud/template';
	
	public function action_index()
	{	
		// if the user has the admin role, redirect to admin_user controller
		if(Auth::instance()->logged_in('admin')) {
			 $this->request->redirect('admin/');
		} else {
			 $this->request->redirect('user/myaccount');
		}
	}
	
	public function action_login()
	{
		// ajax login
		if($this->request->is_ajax() && isset($_REQUEST['username'], $_REQUEST['password'])) {
			 $this->auto_render = false;
			 $this->request->headers('Content-Type', 'application/json');
			 if(Auth::instance()->logged_in() != 0) {
					$this->response->status(200);
					$this->template->content = $this->request->body('{ "success": "true" }');
					return;
			 }
			 else if( Auth::instance()->login($_REQUEST['username'], $_REQUEST['password']) )
			 {
					$this->response->status(200);
					$this->template->content = $this->request->body('{ "success": "true" }');
					return;
			 }
			 $this->response->status(500);
			 $this->template->content = $this->request->body('{ "success": "false" }');
			 return;
		} else {
			 // If user already signed-in
			 if(Auth::instance()->logged_in() != 0){
					// redirect to the user account
					//$this->request->redirect('user/profile');
					$this->request->redirect('admin/');
			 }
			 
			 $view = View::factory('tilbud/login');
			 $view->label = 'Login';
			 // If there is a post and $_POST is not empty
			 if ($_REQUEST && isset($_REQUEST['username'], $_REQUEST['password'])) {

					// Check Auth if the post data validates using the rules setup in the user model
					if ( Auth::instance()->login($_REQUEST['username'], $_REQUEST['password']) ) {
						 // redirect to the user account
						 $this->request->redirect('user/');
						 return;
					} else {
						 $view->set('username', $_REQUEST['username']);
						 // Get errors for display in view
						 $validation = Validation::factory($_REQUEST)
								->rule('username', 'not_empty')
								->rule('username', 'min_length', array(':value', 1))
								->rule('username', 'max_length', array(':value', 127))
								->rule('password', 'not_empty');             
						 if ($validation->check()) {
								$validation->error('password', 'invalid');
						 }
						 $view->set('errors', $validation->errors('login'));  
					}
			 }
			 // allow setting the username as a get param
			 if(isset($_GET['username'])) {
					$view->set('username', Security::xss_clean($_GET['username']));
			 }
			 //$providers = Kohana::config('useradmin.providers');
			 //$view->set('facebook_enabled', isset($providers['facebook']) ? $providers['facebook'] : false);
			 $this->template->content = $view;
		}
	}
	
	/**
   * Log the user out.
   */
  public function action_logout() {
		// Sign out the user
		Auth::instance()->logout();
		
		// redirect to the user account and then the signin page if logout worked as expected
		$this->request->redirect(URL::base(TRUE));
  }
	
	public function action_myaccount()
	{ 
		if ( Auth::instance()->logged_in() == false ){
			 // No user is currently logged in
			 $this->request->redirect('user/login');
		}

		$view = View::factory('tilbud/myaccount');
		$view->set('user', Auth::instance()->get_user());
		
		$this->template->content = $view;
	}

	public function action_signup()
	{
		if (Auth::instance()->logged_in()) {
			 $this->request->redirect('user/');
		}

		$view = View::factory('tilbud/signup');
		$view->header = 'Sign Up';

		$posts = $this->request->post();

		if(!empty($posts)) {
			
		}

		$view->username = isset($posts['username']) ? $posts['username'] : '';
		$view->email = isset($posts['email']) ? $posts['email'] : '';

		$this->template->content = $view;
	}
	
} // End of Admin Users
