<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Useradmin_User {

	// This class can be replaced or extended
  public function email_exist($email){
    $total_users = DB::select(array('COUNT("email")', 'total_users'))->from('users')->where('email','=',$email)->execute()->get('total_users', 0);
    return $total_users;
  }
} // End User Model