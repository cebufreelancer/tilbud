<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Deal extends ORM {
	
	protected $_table_name = 'deals';
	protected $_primary_key = 'ID';
	protected $_primary_val = 'ID';
	
/*	protected $_table_columns = array(
		'ID'						=> array('data_type' => 'int'),
		'city_id'		  	=> array('data_type' => 'int', 'is_nullable' => FALSE),
		'product_id'		=> array('data_type' => 'string'),
		'title' 	      => array('data_type' => 'string', 'is_nullable' => TRUE),
		'description' 	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'image' 				=> array('data_type' => 'decimal'), 
		'regular_price'	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'date_created' 	=> array('data_type' => 'string'),
		);
*/
	
	public function alldeals($limit=NULL, $offset=NULL)
	{
		$result = DB::select()->from($this->_table_name)
						->order_by('ID','DESC')
						->limit($limit)

		$deals = array();
		
		foreach($result as $deal) {
			$deals[] = $deal;
		}
		
		return $deals;
	}
	
} // End of Product Model