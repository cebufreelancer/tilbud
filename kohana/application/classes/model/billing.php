<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Billing extends ORM {
	
	protected $_table_name = 'billings';
	protected $_primary_key = 'ID';
	protected $_primary_val = 'ID';
	
	protected $_table_columns = array(
		'ID'				=> array('data_type' => 'int'),
		'user_id'		=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'cardname'	=> array('data_type' => 'string'),
		'cardnumber'=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'cardcode' 	=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'expiry_year' 	=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'expiry_month' 	=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'address'		=> array('data_type' => 'string', 'is_nullable' => FALSE),
		'city'	    => array('data_type' => 'string', 'is_nullable' => FALSE),
		'state'	    => array('data_type' => 'string', 'is_nullable' => FALSE),
		'zipcode'		=> array('data_type' => 'int', 'is_nullable' => TRUE),
		);
} // End of Billing Model
