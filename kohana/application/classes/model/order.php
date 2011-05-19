<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Order extends ORM {
	
	protected $_table_name = 'orders';
	protected $_table_view = 'v_orders';
	protected $_primary_key = 'ID';
	protected $_primary_val = 'ID';
	
	protected $_table_columns = array(
		'ID'						=> array('data_type' => 'int'),
		'user_id'		  	=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'deal_id'		  	=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'quantity'	    => array('data_type' => 'int', 'is_nullable' => FALSE),
		'total_count'	  => array('data_type' => 'int', 'is_nullable' => FALSE),
		'payment_type'	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'status' 				=> array('data_type' => 'string'),
		'date_paid' 		=> array('data_type' => 'datetime'),
		'date_created' 	=> array('data_type' => 'datetime'),
		);

	
	public function get_orders($deal_id)
	{
    $result = ORM::factory('order')
             ->where('deal_id', '=', $deal_id)
             ->find_all();

		$orders = array();

    foreach($result as $d) {
      $orders[] = $d->as_array();
    }
	  
		return $orders;
	}

	public function get_user_orders($user_id)
	{
    $result = ORM::factory('order')
             ->where('user_id', '=', $user_id)
             ->find_all();
		$orders = array();

    foreach($result as $d) {
      $orders[] = $d->as_array();
    }
	  
		return $orders;
	}

	
	public function get_order($id)
	{
    $order = ORM::factory('order')->find($id);
		return $order;
	}
	
	public function count_orders_by_city($city_id)
	{
		$query = DB::select()->from('v_orders')
												 ->where('city_id', '=', $city_id)
												 ->execute()
												 ->count();
												 
		return $query;
	}
	
	public function orders_sales_by_city($city_id)
	{
		$total = 0;
		$query = DB::select(DB::expr('SUM(total_count) AS total'))->from('v_orders')
												 ->where('city_id', '=', $city_id)
												 ->execute()
												 ->as_array();
												 
		if($query[0]['total'] > 0) {
			$total = $query[0]['total'];
		}
		
		return $total;
	}
	
} // End of Product Model
