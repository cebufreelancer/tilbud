<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Vendor extends ORM {
	
	protected $_table_name = 'vendors';
	protected $_primary_key = 'ID';
	protected $_primary_val = 'ID';
	
	//protected $_belongs_to = array('vendor' => array());
	
	protected $_table_columns = array(
		'ID'						=> array('data_type' => 'int'),
		'name'					=> array('data_type' => 'string'),
		'description' 	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'address' 			=> array('data_type' => 'string', 'is_nullable' => TRUE), 
		'phone'					=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'url'						=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'phone'					=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'email'					=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'office_hours'	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'status'				=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'notes' 				=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'date_created' 	=> array('data_type' => 'string'),
		);
	
	public function get($limit=15,$offset=NULL)
	{
		$result = DB::select()->from($this->_table_name)
						->order_by('name','ASC')
						->limit($limit)
						->offset($offset)->execute();
		$vendors = array();
		
		foreach($result as $v) {
			$vendors[] = $v;
		}
		
		return $vendors;
	}	
	
	public function get_vendor($id){
    $vendor = ORM::factory('vendor')->find($id);
		return $vendor;
	}	
} // End of Product Model