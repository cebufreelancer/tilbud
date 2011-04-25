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
		echo "Creating a new product";
		$products = ORM::factory('product');
		
		$products->vendor_id = 1;
		$products->title = 'Foot Scrub';
		$products->description = 'This is a special foot scrub.';
		$products->price = 100;
		$products->image = '';
		
		$products->save();
		
		echo '<pre>';
		print_r($products->as_array());
		echo '</pre>';
	}
	
	public function action_update($id=NULL)
	{
		echo "Retrieving this entry";
		$products = ORM::factory('product', $id);
		
		echo '<pre>';
		print_r($products->as_array());
		echo '</pre>';
		
		$products->price = 15000;
		$products->description = 'this is a nose job FYI';
		$products->save();
		
		echo '<pre>';
		print_r($products->as_array());
		echo '</pre>';
	}
	
	public function action_delete($id=NULL)
	{
		echo "Removing last entry";
		$products = ORM::factory('product', $id);
		$products->delete();
	}

} // End Welcome
