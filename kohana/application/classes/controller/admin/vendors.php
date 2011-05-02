<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Vendors extends Controller {

	public function action_index()
	{	
		$page = View::factory('tilbud/admin/vendors/index');
		$vendors = ORM::factory('vendor');
		
		// This is an example of how to use Kohana pagination
    // Get the total count for the pagination
		$total = $vendors->count_all();

		if($total > 0) {
			$pagination = new Pagination(array(
										 'total_items' 		=> $total,
										 'items_per_page'	=> 10, 
										 'auto_hide' 			=> false,
										 'view'           => 'pagination/useradmin',));
			$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name'; // set default sorting direction here
			$dir  = isset($_GET['dir']) ? 'DESC' : 'ASC';
			$result = $vendors->limit($pagination->items_per_page)->offset($pagination->offset)->order_by($sort, $dir)
								->find_all();
								
			foreach($result as $ven) {
				$res[] = $ven->as_array();
			}
			
			// Show Pager
			$show_page = ($total > $pagination->items_per_page) ? TRUE : FALSE;
			
			$page->paging = $pagination;
			$page->vendors = $res;
			$page->show_pager = $show_page;
		}
		
		$this->response->body($page);
	}
	
	public function action_add()
	{
		$page = View::factory('tilbud/admin/vendors/vendor_form');
		$page->label = 'Add a Vendor';
		
		$vendors = ORM::factory('vendor');
		
		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
					
			$vendors->name 			 	= htmlentities($posts['vendor_name']);
			$vendors->description = htmlentities($posts['vendor_desc']);
			$vendors->address 	 	= htmlentities($posts['vendor_address']);
			$vendors->phone 			= htmlentities($posts['vendor_phone']);
			$vendors->url  				= htmlentities($posts['vendor_website']);
			$vendors->email 	 		= htmlentities($posts['vendor_email']);
			$vendors->office_hours = htmlentities($posts['vendor_office_hours']);
			$vendors->status  		= 'active';
					
			if($vendors->save()) {
				// message: save success
        Message::add('success', __('Vendor ' . $vendors->name . 'has been successfully added.'));
						
				// Assuming all is correct
				Request::current()->redirect('admin/vendors');
				return;
			}
		}
		
		$page->vendor_name 		= isset($posts['vendor_name']) ? $posts['vendor_name'] : '';
		$page->vendor_desc 		= isset($posts['vendor_desc']) ? $posts['vendor_desc'] : '';
		$page->vendor_address = isset($posts['vendor_address']) ? $posts['vendor_address'] : '';
		$page->vendor_phone 	= isset($posts['vendor_phone']) ? $posts['vendor_phone'] : '';
		$page->vendor_website = isset($posts['vendor_website']) ? $posts['vendor_website'] : '';
		$page->vendor_email 	= isset($posts['vendor_email']) ? $posts['vendor_email'] : '';
		$page->vendor_office_hours = isset($posts['vendor_office_hours']) ? $posts['vendor_office_hours'] : '';
		
		$this->response->body($page);
	}
	
	public function action_edit($id=NULL)
	{
		$page = View::factory('tilbud/admin/vendors/vendor_form');
		$page->label = 'Edit a Vendor';
		
		$vendors = ORM::factory('vendor', $id);
		
		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
					
			$vendors->name 			 	= htmlentities($posts['vendor_name']);
			$vendors->description = htmlentities($posts['vendor_desc']);
			$vendors->address 	 	= htmlentities($posts['vendor_address']);
			$vendors->phone 			= htmlentities($posts['vendor_phone']);
			$vendors->url  				= htmlentities($posts['vendor_website']);
			$vendors->email 	 		= htmlentities($posts['vendor_email']);
			$vendors->office_hours = htmlentities($posts['vendor_office_hours']);
			$vendors->status  		= 'active';
					
			if($vendors->save()) {
				// message: save success
        Message::add('success', __('Vendor ' . $vendors->name . 'has been successfully updated.'));
						
				// Assuming all is correct
				Request::current()->redirect('admin/vendors');
				return;
			}
		}
		
		$page->vendor_name 		= isset($posts['vendor_name']) ? $posts['vendor_name'] : html_entity_decode($vendors->name);
		$page->vendor_desc 		= isset($posts['vendor_desc']) ? $posts['vendor_desc'] : html_entity_decode($vendors->description);
		$page->vendor_address = isset($posts['vendor_address']) ? $posts['vendor_address'] : html_entity_decode($vendors->address);
		$page->vendor_phone 	= isset($posts['vendor_phone']) ? $posts['vendor_phone'] : html_entity_decode($vendors->phone);
		$page->vendor_website = isset($posts['vendor_website']) ? $posts['vendor_website'] : html_entity_decode($vendors->url);
		$page->vendor_email 	= isset($posts['vendor_email']) ? $posts['vendor_email'] : html_entity_decode($vendors->email);
		$page->vendor_office_hours = isset($posts['vendor_office_hours']) ? $posts['vendor_office_hours'] : html_entity_decode($vendors->office_hours);
		
		$this->response->body($page);
	}
	
	public function action_delete($id=NULL)
	{
		$page = View::factory('tilbud/admin/confirm_delete');
		$page->label = 'Delete Vendor';
	
		$vendors = ORM::factory('vendor', $id);
		
		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
			
			if(strcmp($posts['submit'], 'Ok') == 0) {
				if($vendors->loaded()) {
					$vendors->delete();
				}
			}
						
			// Assuming all is correct
			Request::current()->redirect('admin/vendors');
			return;

		} else {
		
			$rec['vendor'] 			= html_entity_decode($vendors->name);
			$rec['description'] = html_entity_decode($vendors->description);
			$rec['address'] 		= html_entity_decode($vendors->address);
			$rec['telephone'] 	= html_entity_decode($vendors->phone);
			$rec['website'] 		= html_entity_decode($vendors->url);
			$rec['email'] 			= html_entity_decode($vendors->email);
			$rec['office'] 			= html_entity_decode($vendors->office_hours);
			
			$page->records = $rec;
		}
		$this->response->body($page);

	}

} // End Welcome
