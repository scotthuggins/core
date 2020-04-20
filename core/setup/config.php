<?php
error_reporting(E_ALL);


//Constant Definitions

define("SITE_URL",'www.fatstream.com');
define("MEDIA_DIRECTORY",'./core/media/');
define('SITE_NAME','Sol');
define("ADMIN_PASSWORD","12345");
define('VIEWS_DIRECTORY','./core/view');
define('VIEWS_DIRECTORY_DEFAULT','./core/view/default');
define('JS_DIRECTORY_DEFAULT','./core/js');
define('CSS_DIRECTORY_DEFAULT','./core/css');


//defaut guest role permissions
$default_guest_roles = array(
	'user_view',
	'user_login_view',
	'user_logout',
	'home',
	'pagination',
	'test_view',
	'get_HTML',
	'getForm',
	'getEntity',
	'default_view',
	'getTable'
	
	
);



//Rewrite Rules;
//Rewrites files for all entities
define("DEVELOPMENT", false);
define("REWRITE_PERMISSIONS", false);
define("REWRITE_CONTROLLERS", false);
define("REWRITE_FORMS", false);
define("REWRITE_VIEWS",	false);
define("REWRITE_MODALS", false);
define("REWRITE_JS", false);
define("REWRITE_APIS", false);
define("REWRITE_INCLUDES", false);

define("SALT","3b6ba35896797c5e618db14b2fcfe655");
define("PEPPER","066bdb9db485e679936cc5375c77434c");
define("DATE_FORMAT","Y-m-d G:i:s");


//Configure DB USERS dynamically by hosting machine.
if ($_SERVER['SERVER_NAME'] == 'localhost')
	{
		//Setup Local Databases here
		define("DBHOST",'localhost');
		define("DBUSER",'fatstream');
		define("DBPASSWORD",'T0nC3tJ4AVGsRHa4');
		define("COREDBNAME","core");
		define("COMPANYDBPREFIX","");
		

	}
/*	if ($_SERVER['SERVER_NAME'] != 'localhost')
	{
		if(DEVELOPMENT == TRUE){
			//Connect to webserver
			
			define("DBHOST",'localhost');
			define("DBUSER",'cfwebsol_core');
			define("DBPASSWORD",'T0nC3tJ4AVGsRHa4');
			define("COREDBNAME","cfwebsol_core");
			define("COMPANYDBPREFIX","cfwebsol_");
			
		}
		if(DEVELOPMENT == FALSE){
			//Connect to production webserver
			$dbhost = 'localhost';
			$dbuser = 'cfwebsol_fatstrm';
			$dbpass = 'aT48%My@$S';
			$dbname = 'cfwebsol_fatstream_production';
			
		}
	}
*/

//get the autoloader
require(dirname(dirname(__FILE__))."/utility/autoloader.php");
require(dirname(dirname(__FILE__))."/utility/db.php");



autoloader(dirname(dirname(__FILE__))."/utility");

// register the core directories for the namespace prefix
autoloader(dirname(dirname(__FILE__)).'/core/model/entity');
autoloader(dirname(dirname(__FILE__)).'/core/model/table');
autoloader(dirname(dirname(__FILE__)).'/model/entity');
autoloader(dirname(dirname(__FILE__)).'/model/table');

autoloader(dirname(dirname(__FILE__)).'/vendors/Ratchet-master');

//init the hooks object
$hooks = hooks::getInstance();
//$calendar = new calendar();
$colors = new colors();

//create mapper and load sol map
$map = new map();
$map->addNamespace('core_entities', dirname(dirname(__FILE__)).'/core/model/entity');
$map->addNamespace('core_tables', dirname(dirname(__FILE__)).'/core/model/table');
$map->addNamespace('company_entities', dirname(dirname(__FILE__)).'/model/entity');
$map->addNamespace('company_tables', dirname(dirname(__FILE__)).'/model/table');
$map->register();

//build the assocation map
//We do this after all namespaces are named and registered
//$map->createEntityMap();
