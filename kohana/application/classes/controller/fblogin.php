<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Fblogin extends Controller {

	public function action_login()
	{
    session_start();
//    session_destroy();
//    die('stop');

    if(isset($_SESSION['oauth_uid']) && $_SESSION['oauth_uid'] != ""){
      Request::current()->redirect("/home");
    }

    $conn = mysql_connect('localhost', Kohana::config('database')->default['connection']['username'], Kohana::config('database')->default['connection']['password']) or die(mysql_error());
    mysql_select_db(Kohana::config('database')->default['connection']['database']) or die(mysql_error());

    # We require the library
    require( APPPATH ."facebook.php");

    # Creating the facebook object
    $facebook = new Facebook(array(
    	'appId'  => Kohana::config('facebook')->app_id,
    	'secret' => Kohana::config('facebook')->secret,
    	'cookie' => true
    ));

    # Let's see if we have an active session
    $session = $facebook->getSession();
    if(!empty($session)) {
    	# Active session, let's try getting the user id (getUser()) and user info (api->('/me'))
    	try{
    		$uid = $facebook->getUser();
    		$user = $facebook->api('/me');
    	} catch (Exception $e){}  		

    	if(!empty($user)){
    		# We have an active session, let's check if we have already registered the user
    		$query = mysql_query("SELECT * FROM users WHERE email='" . $user['email'] . "'", $conn) or die(mysql_error());
    		$result = mysql_fetch_array($query) or die(mysql_error());

    		# If not, let's add it to the database
    		if(empty($result)){
    			$query = mysql_query("INSERT INTO users (firstname, lastname, link, fb_username, birthday, gender, locale, oauth_provider, oauth_uid, status) 
    			        VALUES ('{$user['first_name']}', '{$user['last_name']}', '{$user['link']}', '{$user['username']}', '{$user['birthday']}', 
    			          '{$user['gender']}', '{$user['locale']}','facebook', '{$user['id']}', 'active')", $conn) or die(mysql_error());
    			$query = mysql_query("SELECT * FROM users WHERE id = " . mysql_insert_id());
    			$result = mysql_fetch_array($query) or die(mysql_error());
    		}else {
    		  // lets update the user information
    		  $query = sprintf("Update users set firstname='%s',
    		           lastname='%s',
    		           link='%s',
    		           fb_username='%s',
    		           birthday='%s',
    		           gender='%s',
    		           locale='%s',
    		           oauth_provider='facebook',
    		           oauth_uid='%s' WHERE email='%s'",
    		           $user['first_name'],
    		           $user['last_name'],
    		           $user['link'],
    		           $user['username'],
    		           $user['birthday'],
    		           $user['gender'],
    		           $user['locale'],
    		           $user['id'],
    		           $user['email']);
    		  mysql_query($query, $conn) or die(mysql_error());
    		}

    		// this sets variables in the session 
    		$_SESSION['id'] = $result['id'];
    		$_SESSION['oauth_uid'] = $result['oauth_uid'];
    		$_SESSION['oauth_provider'] = $result['oauth_provider'];
    		$_SESSION['username'] = $result['username'];
    		$_SESSION['email'] = $result['email'];

    		$orig_user = ORM::factory('user')->find($result['id']);

    		

    		Request::current()->redirect("/home/forcelogin?id=".$result['id']);
    	} else {
    		# For testing purposes, if there was an error, let's kill the script
    		Request::current()->redirect("/home");
    	}
    } else {
    	# There's no active session, let's generate one
  		$url = $facebook->getLoginUrl(array(
  			'req_perms' => 'email,user_birthday,status_update,publish_stream,user_photos,user_videos'
  		));
  		
//    	header("Location: ".$url);
    	Request::current()->redirect($url);
    }
	}
} 