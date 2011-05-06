<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Category extends ORM {
	
	protected $_table_name = 'categories';
	protected $_primary_key = 'ID';
	protected $_primary_val = 'ID';
	
	protected $_table_columns = array(
		'ID'						=> array('data_type' => 'int'),
		'name'		  		=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'url_code'		  => array('data_type' => 'string', 'is_nullable' => TRUE),
		);

	public function update_relationship($deal_id, $categories)
	{
		
		// Clear existing relationships first
		$query = DB::delete('category_relationships')
										->where('deal_id','=',$deal_id)
										->execute();
		
		if(!empty($categories)) {				
			// Insert new categories
			$query = DB::query(Database::INSERT, 'INSERT INTO category_relationships (category_id, deal_id) VALUES (:cat_id, :deal_id)')
    										->bind(':cat_id', $cat)
												->bind(':deal_id', $deal_id);
		
			foreach($categories as $cat) {
				$query->execute();	
			}
		}
		
		return true;
	}
	
	public function get_subscribers($category_id)
	{
		$query = DB::select()->from('subscribers')->where('city_id', '=', $category_id)->execute();
		$result = $query->as_array();

		return $result;
	}

} // End of Product Model
