<?php

/**
 * Main application access and setup script.
 * 
 * @package	AGCDR
 * @author	SBF
 * @copyright	2011
 */

// development mode
define('DEVMODE',true);

// set error reporting
if (DEVMODE == true) {
	error_reporting(E_ALL);
} else {
	error_reporting(E_ERROR);
}
	
// set locale
setlocale(LC_ALL,'en_GB');

// start session
session_start();

// define site paths
define('PUB_PATH',realpath(dirname(__FILE__)));
define('APP_PATH',PUB_PATH."/../application");
define('DATA_PATH',PUB_PATH."/../data");

// include configuration script
require_once(APP_PATH."/config.php");

// required resources
require_once(APP_PATH."/libraries/adodb5/adodb.inc.php");
require_once(APP_PATH."/libraries/Smarty-3.0.7/libs/Smarty.class.php");

// determine server choice
if (!isset($_SESSION["server"])) {
	$server = array_shift(array_keys($db_servers));
	$_SESSION["server"] = $server;
} else {
	$server = $_SESSION["server"];
}

// set database connection constants
define('DB_PASS',$db_servers[$server]["password"]);
define('DB_NAME',$db_servers[$server]["dbname"]);
define('DB_USER',$db_servers[$server]["username"]);
define('DB_HOST',$db_servers[$server]["hostname"]);
define('DB_TYPE',$db_servers[$server]["dbtype"]);

// if not the live version, create a label for the version we're running
if (DEVMODE == true) {
	exec("svn info ".APP_PATH."/..",$svninfo);
	$svnpath = explode("/",$svninfo[1]);
	$devdir = array_pop($svnpath);
	if ($devdir != "trunk") $devdir = array_pop($svnpath)."/".$devdir;
	$rev = array_pop(explode(" ",trim($svninfo[4])));
	define('DEVINFO',"<b>Development:</b> {$devdir} revision {$rev} (v".VERSION.")");
}

// register class autoloader
spl_autoload_register("ClassAutoloader");

// create router and run requested controller
$router = new Router();
$router->setPath(APP_PATH."/controllers");
$router->loader();

// class autoloader function saves having to manually include each class and model file
function ClassAutoloader($class) {
	foreach (array("classes","models") as $dir) {
		if (file_exists(APP_PATH."/{$dir}/{$class}.php")) {
			require_once(APP_PATH."/{$dir}/{$class}.php");
		}
	}
}


?>