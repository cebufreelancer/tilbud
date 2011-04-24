<?php defined('SYSPATH') or die('No direct script access.');

class Controller_City extends Controller {

	public function action_index()
	{	
		$cities = ORM::factory('city')->get();
		
		echo '<pre>';
		print_r($cities);
		echo '</pre>';
		//$this->response->body(View::factory('tilbud/index'));
	}
	
	public function action_add()
	{
		echo "Creating a new city";
		$city = ORM::factory('city');
		
		$city->name = 'Cebu';
		
		$city->save();
		
		echo '<pre>';
		print_r($city->as_array());
		echo '</pre>';
	}
	
	public function action_update($id=NULL)
	{
		echo "Retrieving this entry";
		$city = ORM::factory('city', $id);
		
		echo '<pre>';
		print_r($city->as_array());
		echo '</pre>';
		
		$city->name = 'Davao';
		$city->save();
		
		echo '<pre>';
		print_r($city->as_array());
		echo '</pre>';
	}
	
	public function action_delete($id=NULL)
	{
		echo "Removing last entry";
		$city = ORM::factory('city', $id);
		$city->delete();
	}

} // End Welcome
