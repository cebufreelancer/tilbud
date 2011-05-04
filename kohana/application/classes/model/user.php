<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Useradmin_User {

	// This class can be replaced or extended
  public function email_exist($email){
    $total_users = DB::select(array('COUNT("email")', 'total_users'))->from('users')->where('email','=',$email)->execute()->get('total_users', 0);
    return $total_users;
  }

  public function rules()
{
    return array(
        'username' => array(
            array('not_empty'),
            array('min_length', array(':value', 4)),
            array('max_length', array(':value', 32)),
            array('regex', array(':value', '/^[-\pL\pN_.@]++$/uD')),
						array(array($this, 'email_available'), array(':validation', ':field')),
            //array(array($this, 'username_available'), array(':validation', ':field')),
        ),
        'password' => array(
            array('not_empty'),
        ),
        'email' => array(
            array('not_empty'),
            array('min_length', array(':value', 4)),
            array('max_length', array(':value', 127)),
            array('email'),
            array(array($this, 'email_available'), array(':validation', ':field')),
        ),
    );
	}
} // End User Model
