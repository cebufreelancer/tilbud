<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_City extends ORM {
	
	protected $_table_name = 'cities';
	protected $_primary_key = 'ID';
	protected $_primary_val = 'ID';
	
	//protected $_belongs_to = array('vendor' => array());
	
	protected $_table_columns = array(
		'ID'						=> array('data_type' => 'int'),
		'name'					=> array('data_type' => 'string', 'is_nullable' => FALSE),
		'order'					=> array('data_type' => 'int'),
		);
	
	public function get($limit=15,$offset=NULL)
	{
		$result = DB::select()->from($this->_table_name)
						->order_by('ID','ASC')
						->limit($limit)
						->offset($offset)->execute();
		$cities = array();
		
		foreach($result as $city) {
			$cities[] = $city;
		}
		
		return $cities;
	}
	
} // End of Product Model