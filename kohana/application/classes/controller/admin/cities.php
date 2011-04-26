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
		$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name'; // set default sorting direction here
    $dir  = isset($_GET['dir']) ? 'DESC' : 'ASC';
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
					
			if($cities->save()) {
				// message: save success
        Message::add('success', __('City ' . $cities->name . ' has been successfully added.'));
						
				// Assuming all is correct
				Request::current()->redirect('admin/cities');
				return;
			}
		}
				
		$this->response->body(View::factory('tilbud/admin/city_form')
														->set('city', isset($posts['city']) ? $posts['city'] : '')
														->set('label', 'Add a City')
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
					
			if($cities->save()) {
				// message: save success
        Message::add('success', __('City ' . $cities->name . ' has been successfully updated.'));
						
				// Assuming all is correct
				Request::current()->redirect('admin/cities');
				return;
			}
		}
				
		$this->response->body(View::factory('tilbud/admin/city_form')
														->set('city', isset($posts['city']) ? $posts['city'] : $cities->name)
														->set('label', 'Edit a City')
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
														->set('label', 'Delete a City')
											);
	}

} // End Cities
