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
		'group_id'			=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'reference_no'	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'title' 	      => array('data_type' => 'string'),
		'description' 	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'contents' 			=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'contents_title' => array('data_type' => 'string', 'is_nullable' => TRUE),
		'information' 	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'whatyouget' 		=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'image' 				=> array('data_type' => 'string', 'is_nullable' => TRUE), 
		'regular_price'	=> array('data_type' => 'float'),
		'discount'    	=> array('data_type' => 'float', 'is_nullable' => TRUE),
		'vouchers'  	  => array('data_type' => 'int', 'is_nullable' => TRUE),
		'min_buy'    	  => array('data_type' => 'int', 'is_nullable' => TRUE),
		'max_buy'    	  => array('data_type' => 'int', 'is_nullable' => TRUE),
		'min_sold'    	=> array('data_type' => 'int', 'is_nullable' => TRUE),
		'max_sold'    	=> array('data_type' => 'int', 'is_nullable' => TRUE),
		'status'    	  => array('data_type' => 'string', 'is_nullable' => TRUE),
		'addresses' 	  => array('data_type' => 'text'),
		'is_featured'   => array('data_type' => 'string'),
		'start_date' 		=> array('data_type' => 'string'),
		'end_date' 			=> array('data_type' => 'string'),
		'expiry_date' 	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'youtube_url'   => array('data_type' => 'string', 'is_nullable' => TRUE),
		'date_create' 	=> array('data_type' => 'string'),
		'last_update' 	=> array('data_type' => 'string'),
		);

  // deprecate this please
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

	public function get_active_deals($limit=NULL, $limit=20)
	{
    $result = ORM::factory('deal')
             ->order_by('ID', 'DESC')
             ->where('status', '=', 'active')
  	         ->limit($limit)
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
	          ->and_where('status', '=', 'active')
	          ->and_where('start_date', '=', date('Y-m-d'))
	          ->limit(1)
	          ->order_by('date_create', 'DESC')
	          ->find_all();

    $d = NULL;
    foreach($deals as $deal){
      $d =  $deal;
    }
    
    return $d;

	}
	
	public function get_categories($deal_id)
	{
		$query = DB::select()->from('category_relationships')
												 ->where('deal_id', '=', $deal_id)
												 ->execute()
												 ->as_array();
		$categories = array();
		foreach($query as $q) {
			$categories[] = $q['category_id'];
		}
		
		return $categories;
	}
	
	public function get_to_expire_deals()
	{
		$query = DB::select()->from($this->_table_name)
												 ->where(DB::expr('CURDATE()'), '<', 'end_date')
												 ->and_where('status', '=', 'active')
												 ->execute()
												 ->as_array();
												 
		return $query;
	}
	
} // End of Product Model