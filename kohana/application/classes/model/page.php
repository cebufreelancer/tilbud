<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Page extends ORM {
	
	protected $_table_name = 'pages';
	protected $_primary_key = 'id';
	protected $_primary_val = 'id';
	
	protected $_table_columns = array(
		'id'					=> array('data_type' => 'int'),
		'page_code'		=> array('data_type' => 'string', 'is_nullable' => FALSE),
		'content'		  => array('data_type' => 'int', 'is_nullable' => FALSE),
		'created_at' 	=> array('data_type' => 'string'),
		'updated_at' 	=> array('data_type' => 'string'),
		);

	public function get_page($code){
	  $result = ORM::factory('page')->where('page_code', '=', $code)->find();	

	  return $result;
	}

} // End of Product Model