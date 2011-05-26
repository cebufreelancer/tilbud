<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pages extends Controller {

	public function action_index()
	{		
		$pages = ORM::factory('page');
		
		// This is an example of how to use Kohana pagination
    // Get the total count for the pagination
		$total = $pages->count_all();
		
		$pagination = new Pagination(array(
									 'total_items' 		=> $total,
									 'items_per_page'	=> 15, 
									 'auto_hide' 			=> false,
									 'view'           => 'pagination/useradmin',));
		$sort = isset($_GET['sort']) ? $_GET['sort'] : 'page_code'; // set default sorting direction here
    $dir  = isset($_GET['dir']) ? 'DESC' : 'ASC';
		$result = $pages->limit($pagination->items_per_page)->offset($pagination->offset)->order_by($sort, $dir)
              ->find_all();
    $res = array();

		foreach($result as $prods) {
			$res[] = $prods->as_array();
		}

		$this->response->body(View::factory('tilbud/admin/page-index')
													->set('paging', $pagination)
													->set('pages', $res)
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

	public function action_add()
	{
		$page = View::factory('tilbud/admin/page_edit');
		$page->label = __(LBL_PAGE_ADD);
		$thepage = ORM::factory('page');

		$page->thepage = $thepage;

		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
					
			$thepage->content 	 = $posts['page_content'];
			
			if($thepage->save()) {			
				// Assuming all is correct
				Request::current()->redirect('admin/pages');
				return;
			}
		}

		$this->response->body($page);
		
	}

	public function action_edit($id=NULL)
	{
		$page = View::factory('tilbud/admin/page_edit');
		$page->label = __(LBL_PAGE_EDIT);
		$thepage = ORM::factory('page')->get_page_byid($id);

		$page->thepage = $thepage;

		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
					
			$thepage->content 	 = $posts['page_content'];
			
			if($thepage->save()) {			
				// Assuming all is correct
				Request::current()->redirect('admin/pages');
				return;
			}
		}

		$this->response->body($page);
		
	}
	
	public function action_delete($id=NULL)
	{
		$page = View::factory('tilbud/admin/confirm_delete');
		$page->label = 'Delete Product';
	
		$products = ORM::factory('product', $id);
		
		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
			
			if(strcmp($posts['submit'], 'Ok') == 0) {
				if($products->loaded()) {
					$products->delete();
				}
			}
						
			// Assuming all is correct
			Request::current()->redirect('admin/products');
			return;

		} else {
		
			$rec['product'] = html_entity_decode($products->title);
			$rec['description'] = html_entity_decode($products->description);
			$rec['price'] = html_entity_decode($products->price);
			$rec['vendor'] = html_entity_decode(ORM::factory('vendor',$products->vendor_id)->name);
			
			$page->records = $rec;
		}
		$this->response->body($page);

	}

} // End Welcome
