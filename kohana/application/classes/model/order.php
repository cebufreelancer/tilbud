<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Order extends ORM {
	
	protected $_table_name = 'orders';
	protected $_primary_key = 'ID';
	protected $_primary_val = 'ID';
	
/*	protected $_table_columns = array(
		'ID'						=> array('data_type' => 'int'),
		'city_id'		  	=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'product_id'		=> array('data_type' => 'string'),
		'title' 	      => array('data_type' => 'string', 'is_nullable' => TRUE),
		'description' 	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'image' 				=> array('data_type' => 'decimal'), 
		'regular_price'	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'date_created' 	=> array('data_type' => 'string'),
		);
*/
	
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
	
	public function get_order($id){
    $order = ORM::factory('order')->find($id);
		return $order;
	}
	
} // End of Product Model