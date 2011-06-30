<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Subscriber extends ORM {
	
	protected $_table_name = 'subscribers';
		
	//protected $_belongs_to = array('vendor' => array());
	
	protected $_table_columns = array(
		'email'					=> array('data_type' => 'string', 'is_nullable' => FALSE),
		'city_id'				=> array('data_type' => 'int'),
		);
	
	public function add($email, $city_id)
	{
	  $date = date("Y-m-d H:i:s");
		$insert = DB::insert($this->_table_name, array('email','city_id', 'created_at'))
								->values(array($email, $city_id, $date));
		
		list($insert_id, $affected_rows) = $insert->execute();
		
		return $insert_id;
	}
	
	public function is_subscribed($email, $city)
	{
		$email = DB::select()->from($this->_table_name)
												->where('email', '=', $email)
												->and_where('city_id', '=', $city)
												->execute()
												->as_array();
		return !empty($email) ? TRUE : FALSE;
	}
	
	/**
	 * This will return the subscription of the user
	 */
	public function get_subscription_by_email($email)
	{
		$query = DB::select()->from($this->_table_name)
							->where('email', '=', $email)->execute();
		$subscribers = $query->as_array();
		
		return $subscribers;
	}
	
	/**
	 * This will return the subcribers of the city
	 */
	public function get_subscribers_by_city($city_id)
	{
		$query = DB::select()->from($this->_table_name)
							->where('city_id', '=', $city_id)->execute();
		$subscribers = $query->as_array();
		
		return $subscribers;
	}
	
} // End of Subscriber Model