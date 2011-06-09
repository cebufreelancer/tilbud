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
	
	/**
	 * This will generate a token string un sha1
	 */
	public function generate_token()
	{
		do {
			$token = sha1(uniqid(Text::random(md5(date("Y-m-d H:i:s")), 32), TRUE));
		} while(ORM::factory('user', array('reset_token' => $token))->loaded());
		
		return $token;
	}
	
	public function admin_count($type='all')
	{
		$ad_count = 0;
		$mem_count = 0;
		
		foreach(parent::find_all()->as_array() as $user) {
			if($user->has('roles', 1) && $user->has('roles', 2)) {
				$ad_count++;
			} else {
				$mem_count++;
			}
		}
		
		if($type == 'member') {
			return $mem_count;
		} else if($type == 'admin') {
			return $ad_count;
		} else {
			return array('admin' => $ad_count, 'member' => $mem_count);
		}
	}
} // End User Model
