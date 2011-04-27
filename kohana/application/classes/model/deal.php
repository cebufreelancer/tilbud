<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Deal extends ORM {
	
	protected $_table_name = 'deals';
	protected $_primary_key = 'ID';
	protected $_primary_val = 'ID';
	
	protected $_has_one = array('product' => array());
	
	protected $_table_columns = array(
		'ID'						=> array('data_type' => 'int'),
		'city_id'		  	=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'product_id'		=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'title' 	      => array('data_type' => 'string'),
		'description' 	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'image' 				=> array('data_type' => 'string', 'is_nullable' => TRUE), 
		'regular_price'	=> array('data_type' => 'decimal'),
		'discount'    	=> array('data_type' => 'decimal', 'is_nullable' => TRUE),
		'vouchers'  	  => array('data_type' => 'int', 'is_nullable' => TRUE),
		'min_buy'    	  => array('data_type' => 'int', 'is_nullable' => TRUE),
		'max_buy'    	  => array('data_type' => 'int', 'is_nullable' => TRUE),
		'status'    	  => array('data_type' => 'string', 'is_nullable' => TRUE),
		'date_create' 	=> array('data_type' => 'string'),
		);

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

	public function get_featured() {
	  $deals = ORM::factory('deal')
	          ->where('is_featured', '=', 1)
	          ->limit(1)
	          ->order_by('date_create', 'DESC')
	          ->find_all();

    $d = NULL;
    foreach($deals as $deal){
      $d =  $deal;
    }
    
    return $d;

	}
} // End of Product Model
