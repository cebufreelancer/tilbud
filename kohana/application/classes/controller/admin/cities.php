<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Cities extends Controller {

	public function action_index()
	{	
		$cities = ORM::factory('city');
		
		// This is an example of how to use Kohana pagination
    // Get the total count for the pagination
		$total = $cities->count_all();
		
		$pagination = new Pagination(array(
									 'total_items' 		=> $total,
									 'items_per_page'	=> 10, 
									 'auto_hide' 			=> false,
									 'view'           => 'pagination/useradmin',));
		$sort = isset($_GET['sort']) ? $_GET['sort'] : 'order'; // set default sorting direction here
    $dir  = isset($_GET['dir']) ? $_GET['dir'] : 'ASC';
		$result = $cities->limit($pagination->items_per_page)->offset($pagination->offset)->order_by($sort, $dir)
              ->find_all();
							
		foreach($result as $city) {
			$res[] = $city->as_array();
		}

		$this->response->body(View::factory('tilbud/admin/city_index')
													->set('paging', $pagination)
													->set('cities', $res)
													->set('no_pager', TRUE)
											);
	}
	
	public function action_add()
	{		
		$cities = ORM::factory('city');
		
		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
					
			$cities->name = htmlentities($posts['city']);
			$cities->order = (int)$posts['order'];
					
			if($cities->save()) {
				// message: save success
        Message::add('success', __(sprintf(LBL_SUCCESS_ADD, LBL_CITY, $cities->name)));
						
				// Assuming all is correct
				Request::current()->redirect('admin/cities');
				return;
			}
		}
				
		$this->response->body(View::factory('tilbud/admin/city_form')
														->set('city', isset($posts['city']) ? $posts['city'] : '')
														->set('order', isset($posts['order']) ? $posts['order'] : 0)
														->set('label', __(LBL_CITY_ADD))
											);
	}
	
	public function action_edit($id=NULL)
	{
		$cities = ORM::factory('city', $id);
		
		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
			$cities->name = htmlentities($posts['city']);
			$cities->order = (int)$posts['order'];
					
			if($cities->save()) {
				// message: save success
        Message::add('success', __(sprintf(LBL_SUCCESS_UPDATE, LBL_CITY, $cities->name)));
						
				// Assuming all is correct
				Request::current()->redirect('admin/cities');
				return;
			}
		}
				
		$this->response->body(View::factory('tilbud/admin/city_form')
														->set('city', isset($posts['city']) ? $posts['city'] : html_entity_decode($cities->name))
														->set('order', isset($posts['order']) ? $posts['order'] : $cities->order)
														->set('label', __(LBL_CITY_EDIT))
											);
	}
	
	public function action_delete($id=NULL)
	{
		$page = View::factory('tilbud/admin/confirm_delete');
	
		$cities = ORM::factory('city', $id);
		
		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
			if(strcmp($posts['submit'], 'Ok') == 0) {
				if($cities->loaded()) {
					$cities->delete();
				}
			}
		
			// Assuming all is correct
			Request::current()->redirect('admin/cities');
			return;

		} else {
			$rec['city'] = html_entity_decode($cities->name);
		}
		$this->response->body(View::factory('tilbud/admin/confirm_delete')
														->set('records',$rec)
														->set('label', __(LBL_CITY_DELETE))
											);
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

} // End Cities
