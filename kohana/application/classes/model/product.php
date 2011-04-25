<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Product extends ORM {
	
	protected $_table_name = 'products';
	protected $_primary_key = 'ID';
	protected $_primary_val = 'ID';
	
	//protected $_belongs_to = array('vendor' => array());
	
	protected $_table_columns = array(
		'ID'						=> array('data_type' => 'int'),
		'vendor_id'			=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'title'					=> array('data_type' => 'string'),
		'description' 	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'price' 				=> array('data_type' => 'decimal'), 
		'image'					=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'date_created' 	=> array('data_type' => 'string'),
		);
	
	public function get($limit=15,$offset=NULL)
	{
		$result = DB::select()->from($this->_table_name)
						->order_by('ID','ASC')
						->limit($limit)
						->offset($offset)->execute();
		$products = array();
		
		foreach($result as $prod) {
			$products[] = $prod;
		}
		
		return $products;
	}
	
	public function get_vendors($is_select=FALSE)
	{
		$vendors = ORM::factory('vendor')->find_all();
		
		foreach($vendors as $v) {
			if($is_select) {
				$vendor = $v->as_array();
				$vends[$vendor['ID']] = $vendor['name'];
			} else {
				$vends[] = $v->as_array();
			}
		}
		
		return $vends;
	}
	
} // End of Product Model