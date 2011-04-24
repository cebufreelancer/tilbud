<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Products extends Controller {

	public function action_index()
	{	
		/*$products = ORM::factory('product')->get();
		
		echo '<pre>';
		print_r($products);
		echo '</pre>';*/
		$this->response->body(View::factory('tilbud/admin/index'));
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
