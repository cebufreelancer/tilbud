<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

require APPPATH.'languages/dk'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

/**
 * Set the cookie configuration
 */
Cookie::$salt = 'DealsTilbud i Byen 2011'; 
Cookie::$domain = 'tilbudibyen.com';

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
	'index_file' => FALSE,
	'charset'		 => 'iso-8859-1',
	'base_url'   => '/',
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

// Attach Tilbud Global Configuration
Kohana::$config->attach(new Config_File('global'));
/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	 'user'       => MODPATH.'user',       // Useradmin module
   'auth'       => MODPATH.'auth',       // Basic authentication
   'database'   => MODPATH.'database',   // Database access
   'orm'        => MODPATH.'orm',        // Object Relationship Mapping
   'pagination' => MODPATH.'pagination',        // Pagination
   'oauth'      => MODPATH.'oauth',        // Kohana-Oauth for Twitter
   'kohana-email' => MODPATH.'kohana-email',        // Kohana-Email for email
	// 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'image'      => MODPATH.'image',      // Image manipulation
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
// Special Pages Routes
// Ex: This turns home/login into /login
Route::set('pdf', 'pdf')->defaults(array('controller' => 'home', 'action' => 'pdf'));
Route::set('login', 'login')->defaults(array('controller' => 'home', 'action' => 'login'));
Route::set('password_update', 'password_update')->defaults(array('controller' => 'home', 'action' => 'password_update'));
Route::set('verify', 'verify')->defaults(array('controller' => 'home', 'action' => 'verify'));
Route::set('signup', 'signup')->defaults(array('controller' => 'home', 'action' => 'signup'));
Route::set('about', 'about')->defaults(array('controller' => 'home', 'action' => 'about'));
Route::set('faq', 'faq')->defaults(array('controller' => 'home', 'action' => 'faq'));
Route::set('contact', 'contact')->defaults(array('controller' => 'home', 'action' => 'contact'));
Route::set('page', 'page')->defaults(array('controller' => 'home', 'action' => 'page'));
Route::set('users', 'users')->defaults(array('controller' => 'users', 'action' => 'index'));
Route::set('referral', 'referral')->defaults(array('controller' => 'home', 'action' => 'referral'));

Route::set('ipages', 'ipages(<controller>(/<action>(/<id>)))')
		->defaults(array('controller' => 'ipages', 'action' => 'index'));
Route::set('alldeals', 'alldeals(<controller>(/<action>(/<id>)))')
		->defaults(array('controller' => 'deals', 'action' => 'index'));
Route::set('view', 'view(<controller>(/<action>(/<id>)))')
		->defaults(array('controller' => 'deals', 'action' => 'view'));
		
// Admin directory
// This route enables access to admin controllers
// Ex: admin/products, admin/vendors
Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
	->defaults(array(
		'directory'		=> 'admin',
		'controller'	=> 'deals',
		'action'			=> 'index',
	));
	
// Cron path
// This route will enable cpanel cron job to access local cron functions
// Ex: [Manual Trigger] http://tilbudibyen.com/cron/deals
Route::set('cron', 'cron(/<controller>(/<action>(/<param>)))')
	->defaults(array(
		'directory' 	=> 'cron',
		'controller'	=> 'deals',
		'action'			=> 'index',
	));
	
// Default Routes - must be at the bottom
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'home',
		'action'     => 'index',
	));

define('UPLOADPATH',	realpath(DOCROOT . 'uploads'));
define('BANNER_WIDTH_MAX',	950);
define('BANNER_HEIGHT_MAX', 310);