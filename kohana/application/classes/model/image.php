<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Image extends ORM {
	
	protected $_table_name = 'images';
	protected $_primary_key = 'ID';
	protected $_primary_val = 'ID';
	
	protected $_table_columns = array(
		'ID'				=> array('data_type' => 'int'),
		'path'			=> array('data_type' => 'string', 'is_nullable' => FALSE),
		'caption'		=> array('data_type' => 'int'),
		'type'			=> array('data_type' => 'string'),
		'tid'				=> array('data_type' => 'int')
		);
	
} // End of Product Model