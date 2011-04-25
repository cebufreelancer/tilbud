<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Products extends Controller {

	public function action_index()
	{		
		$products = ORM::factory('product');
		
		// This is an example of how to use Kohana pagination
    // Get the total count for the pagination
		$total = $products->count_all();
		
		$pagination = new Pagination(array(
									 'total_items' 		=> $total,
									 'items_per_page'	=> 15, 
									 'auto_hide' 			=> false,
									 'view'           => 'pagination/useradmin',));
		$sort = isset($_GET['sort']) ? $_GET['sort'] : 'title'; // set default sorting direction here
    $dir  = isset($_GET['dir']) ? 'DESC' : 'ASC';
		$result = $products->limit($pagination->items_per_page)->offset($pagination->offset)->order_by($sort, $dir)
              ->find_all();
							
		foreach($result as $prods) {
			$res[] = $prods->as_array();
		}

		$this->response->body(View::factory('tilbud/admin/index')
													->set('paging', $pagination)
													->set('products', $res)
											);
	}
	
	public function action_add()
	{
		$page = View::factory('tilbud/admin/product_add');
		$page->label = 'Add a Product';
		
		$products = ORM::factory('product');
		$page->vendors = $products->get_vendors(TRUE);
		
		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
					
			$products->vendor_id 	 = $posts['product_vendor'];
			$products->title 			 = htmlentities($posts['product_name']);
			$products->description = htmlentities($posts['product_desc']);
			$products->price 	 		 = $posts['product_price'];
			
			if(isset($_FILES['product_vendor'])) {
				$products->image = $_FILES['product_image']['name'];
			}
			
			if($products->save()) {
				// message: save success
        Message::add('success', __('Values saved.'));
						
				// Assuming all is correct
				Request::current()->redirect('admin/products');
				return;
			}
		}
		
		$page->prod_vid = isset($posts['product_vendor']) ? $posts['product_vendor'] : '';
		$page->prod_title = isset($posts['product_name']) ? $posts['product_name'] : '';
		$page->prod_desc = isset($posts['product_desc']) ? $posts['product_desc'] : '';
		$page->prod_price = isset($posts['product_price']) ? $posts['product_price'] : '';
		
		$this->response->body($page);
	}
	
	public function action_edit($id=NULL)
	{
		$page = View::factory('tilbud/admin/product_add');
		$page->label = 'Edit a Product';
		
		$products = ORM::factory('product', $id);
		$page->vendors = $products->get_vendors(TRUE);
		
		// Get posts
		$posts = $this->request->post();
		
		// This will check if submitted
		if(!empty($posts)) {
					
			$products->vendor_id 	 = $posts['product_vendor'];
			$products->title 			 = htmlentities($posts['product_name']);
			$products->description = htmlentities($posts['product_desc']);
			$products->price 	 		 = $posts['product_price'];
			
			if(isset($_FILES['product_vendor'])) {
				$products->image = $_FILES['product_image']['name'];
			}
			
			if($products->save()) {			
				// Assuming all is correct
				Request::current()->redirect('admin/products');
				return;
			}
		}
		
		$page->prod_vid = isset($posts['product_vendor']) ? $posts['product_vendor'] : $products->vendor_id;
		$page->prod_title = isset($posts['product_name']) ? $posts['product_name'] : html_entity_decode($products->title);
		$page->prod_desc = isset($posts['product_desc']) ? $posts['product_desc'] : html_entity_decode($products->description);
		$page->prod_price = isset($posts['product_price']) ? $posts['product_price'] : $products->price;
		
		$this->response->body($page);
		/*
		echo '<pre>';
		print_r($products->as_array());
		echo '</pre>';
		
		$products->price = 15000;
		$products->description = 'this is a nose job FYI';
		$products->save();
		
		echo '<pre>';
		print_r($products->as_array());
		echo '</pre>';
		*/
	}
	
	public function action_delete($id=NULL)
	{
		echo "Removing last entry";
		$products = ORM::factory('product', $id);
		$products->delete();
	}

} // End Welcome
