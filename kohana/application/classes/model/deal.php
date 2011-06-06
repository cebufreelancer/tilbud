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
		'image2' 				=> array('data_type' => 'string', 'is_nullable' => TRUE), 
		'image3' 				=> array('data_type' => 'string', 'is_nullable' => TRUE), 
		'image4' 				=> array('data_type' => 'string', 'is_nullable' => TRUE), 
		'image5' 				=> array('data_type' => 'string', 'is_nullable' => TRUE), 
		'facebook_image' 	=> array('data_type' => 'string', 'is_nullable' => TRUE), 
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
		'regno'   			=> array('data_type' => 'string'),
		'itemno' 				=> array('data_type' => 'string'),
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

  public function get_mainimages($id)
  {    
    $deal = ORM::factory('deal', $id);
    $images = array();
    
    if ($deal->image != "") {
      $images[] = $deal->image;
    }
    
    if ($deal->image2 != "") {
      $images[] = $deal->image2;
    }
    if ($deal->image3 != "") {
      $images[] = $deal->image3;
    }
    if ($deal->image4 != "") {
      $images[] = $deal->image4;
    }
    if ($deal->image5 != "") {
      $images[] = $deal->image5;
    }
    return $images;
  }

	public function get_active_deals($limit=NULL, $limit=20)
	{
    $result = ORM::factory('deal')
             ->order_by('ID', 'DESC')
             ->where('status', '=', 'active')
             ->where("end_date",'<=', "DATE_FORMAT(NOW(), '%Y-%m-%d')")
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
    $sql = "SELECT `deals`.* FROM `deals` WHERE `is_featured` = 1 AND `status` = 'active' AND (CURDATE() BETWEEN start_date AND end_date) ORDER BY `end_date` DESC LIMIT 1";
    $deals = DB::query(Database::SELECT, $sql)->execute()->as_array();
    if (sizeof($deals) > 0) {
      return $deals[0];
    }else {
      // didn't found any
      $sql = "SELECT `deals`.* FROM `deals` WHERE `is_featured` = 1 AND `status` = 'active' AND (start_date < CURDATE()) ORDER BY `end_date` DESC LIMIT 1";
      $deals = DB::query(Database::SELECT, $sql)->execute()->as_array();
      return $deals[0];
    }
    

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