<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Email extends ORM {
	
	protected $_table_name = 'email_templates';
	protected $_primary_key = 'ID';
	protected $_primary_val = 'ID';
	
	protected $_table_columns = array(
		'ID'		=> array('data_type' => 'int'),
		'name'	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'text'	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		);

} // End of Product Model
