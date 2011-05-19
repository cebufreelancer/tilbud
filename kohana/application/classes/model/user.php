<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Useradmin_User {

	// This class can be replaced or extended
  public function email_exist($email){
    $total_users = DB::select(array('COUNT("email")', 'total_users'))->from('users')->where('email','=',$email)->execute()->get('total_users', 0);
    return $total_users;
  }
	
	public function is_admin($user)
	{
		return $user->has('roles', array(1,2));
	}
	
	public function get_city($email)
	{
		$return = __(LBL_NOT_ASSIGNED);
		$city = DB::select('city_id')->from('subscribers')->where('email', '=', $email)->limit(1)->execute()->as_array();
		
		if(isset($city[0]['city_id'])) {
			$city = ORM::factory('city', $city[0]['city_id']);
			$return = $city->name;
		}
		
		return $return;
	}
} // End User Model
