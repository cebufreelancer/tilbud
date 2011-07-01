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

  public function action_pdfviewer()
  {
    $posts = $this->request->post();
    if (isset($posts['action'])) {
      $refno = $_REQUEST['refno'];
      $res = DB::select()->from('refnumbers')->where('refno', '=', $reno)->execute()->as_array();
      $pdf_refno = $res['refno'];
      $user = Auth::instance()->get_user();
      $deal = ORM::factory('deal', $res['deal_id']);
    
      ob_start();
      include_once(APPPATH . 'views/tilbud/template_order_pdf.php');
      $content = ob_get_clean();
      ob_clean();
      ob_end_flush();

      $html2pdf = new HTML2PDF('P','A4','en');
      $html2pdf->WriteHTML($content, false);

      $html2out = $html2pdf->Output('','S');
    }
  }
  
	public function action_refnumbers()
	{ 
    //$orders = DB::select()->from('orders')->where('user_id', '=', Auth::instance()->get_user()->ID)->execute();
    $orders = DB::select()->from('orders')->where('user_id', '=', 82)->execute();
    $ids = array();
    foreach($orders as $order){
      $ids[] = $order['ID'];
    }
    $ids = array('30','31','32');
      $refnumbers = DB::select()->from('refnumbers')->where('order_id', 'IN', $ids)->and_where('is_claimed', '=', '0')->execute()->as_array();
      
  		$view = View::factory('tilbud/refnumbers');
  		$view->set('user', Auth::instance()->get_user());
  		$view->refnumbers;
  		$this->template->content = $view;
      
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
					$this->request->redirect('admin/');
			 }

			 $view = View::factory('tilbud/login');
			 $view->label = 'Login';
			 $view->is_simple = 'true';
			 // If there is a post and $_POST is not empty
			 if ($_REQUEST && isset($_REQUEST['username'], $_REQUEST['password'])) {

					// Check Auth if the post data validates using the rules setup in the user model
					if ( Auth::instance()->login($_REQUEST['username'], $_REQUEST['password']) ) {
						
						// Check Cookie if set and update cookie value
						Cookie::set('tib', md5(date("Ymd")), Date::WEEK*2);
						
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
			 //$this->template->content = $view;
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
		
		$posts = $this->request->post();
		
		if(!empty($posts)) {
			 if(empty($_POST['password']) || empty($_POST['password_confirm'])) {
					// force unsetting the password! Otherwise Kohana3 will 
					// automatically hash the empty string - preventing logins
					unset($_POST['password'], $_POST['password_confirm']);
			 }

			 try {
					Auth::instance()->get_user()->update_user($_POST, array(
						 'firstname',
						 'lastname',
						 'mobile',
						 'password',
						 'email',
						 'address'
					));
					
					Message::add('success', __(LBL_ACCOUNT_UPDATE_CONFIRM));
					$this->request->redirect('user/myaccount');
					return;
					
			 } catch (ORM_Validation_Exception $e) {
					Message::add('error', __('Error: Values could not be saved.'));
					$errors = $e->errors('register');
					$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()));
					$view->set('errors', $errors);
					// Pass on the old form values
					$user->password = '';
					$view->set('data', $user->as_array());
			 }
			 $view->set('posts', $posts);
		}
		
		$view = View::factory('tilbud/myaccount');
		$view->set('user', Auth::instance()->get_user());
		
		$this->template->content = $view;
	}

	public function action_billing()
	{
		if ( Auth::instance()->logged_in() == false ){
			 $this->request->redirect('user/login');
		}
		
		$view = View::factory('tilbud/billing');
		
		$id = Auth::instance()->get_user()->id;
		$billing = ORM::factory('billing')->where('user_id', '=', $id)->find();
		$posts = $this->request->post();
		
		if(!empty($posts)) {
						
			$valid_card = Validation::factory($posts);
			$valid_card->rule('cardname', 'not_empty')
								 ->rule('cardname', 'regex', array(':value', '/^[A-Za-z\s]+$/'))
								 ->rule('cardnumber', 'credit_card')
								 ->rule('cardcode', 'not_empty')
								 ->rule('cardcode', 'exact_length', array(':value', 3))
								 ->rule('address', 'not_empty')
								 ->rule('city', 'not_empty')
								 ->rule('zipcode', 'not_empty')
								 ->rule('zipcode', 'min_length', array(':value', 3))
								 ->rule('zipcode', 'min_length', array(':value', 4));
								 
			if($valid_card->check()) {
			
				try {				
					$posts['user_id'] = $id;
					$billing->values($posts);
					$billing->save();
				
					Message::add('success', __(LBL_BILLING_UPDATE_CONFIRM));
					$this->request->redirect('user/billing');
					return;
					
				} catch (ORM_Validation_Exception $e) {
					Message::add('error', __('Error: Values could not be saved.'));
					$errors = $e->errors('register');
					$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()));
					$view->set('errors', $errors);
				}
			} else {
				$view->set('errors', $valid_card->errors('billing'));
			}
		}
		
		
		$view->set('billing', $billing);
		$view->cardtypes = array("visa" => "VISA", 
															 "mastercard" => "Master Card",
															 "jcb" => "JCB",
															 "american-express" => "American Express");
		
		$this->template->content = $view;
	}
	
	public function action_signup()
	{
		if (Auth::instance()->logged_in()) {
			 $this->request->redirect('user/');
		}

		$view = View::factory('tilbud/signup');
		$view->header = __(LBL_SIGNUP);

		$posts = $this->request->post();

		if(!empty($posts)) {
			
		}

		$view->username = isset($posts['username']) ? $posts['username'] : '';
		$view->email = isset($posts['email']) ? $posts['email'] : '';

		$this->template->content = $view;
	}
	
	public function action_orders()
	{
		if ( Auth::instance()->logged_in() == false ){
			 $this->request->redirect('user/login');
		}
		
		$page = View::factory('tilbud/myorders');
		$page->header = __(LBL_My_Orders);

    $id = Auth::instance()->get_user()->id;
    $orders_model = ORM::factory('order');
    $orders = ORM::factory('order')
        ->where('user_id', '=', $id)
        ->find_all();

		// This is an example of how to use Kohana pagination
    // Get the total count for the pagination
		$total = $orders->count();

		if($total > 0) {
			$pagination = new Pagination(array(
										 'total_items' 		=> $total,
										 'items_per_page'	=> 10, 
										 'auto_hide' 			=> false,
										 'view'           => 'pagination/useradmin',));
			$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_created'; // set default sorting direction here
			$dir  = isset($_GET['dir']) ? 'DESC' : 'ASC';
			$result = $orders_model->limit($pagination->items_per_page)->offset($pagination->offset)->order_by($sort, $dir)
			          ->where('user_id', '=', $id)
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
		
		$this->template->content = $page;
	}
	
} // End of Admin Users
