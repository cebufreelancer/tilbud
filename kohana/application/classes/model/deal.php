<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Deal extends ORM {
	
	protected $_table_name = 'deals';
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
	
	public function get_alldeals($limit=NULL, $offset=NULL)
	{
    $result = ORM::factory('deal')
             ->order_by('ID', 'DESC')
             ->find_all();
		$deals = array();
		
    foreach($result as $d) {
      $deals[] = $d->as_array();
    }
		
		return $deals;
	}
	
	public function get_deal($id){
    $deal = ORM::factory('deal')->find($id);
		return $deal;
	}
	
} // End of Product Model
