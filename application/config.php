<?php

/**
 * Main application configuration script
 * 
 * @package	House
 * @author	AGCDR
 * @copyright	2010-2011
 */

// release version
define('VERSION','0.900');

// beta version flag
define('BETA',true);

// global debug mode
define('DEBUG',true);

// application titles (short and long)
define('APP_TITLE','AGCDR');
define('LONG_TITLE','Asterisk CDR Statistics');

// live URL
define('LIVE_URL','http://agcdr.heddonconsulting.com/');

// main database server configuration (first server is the default)
$_SESSION["servers"] = array(
	"zaleriza.snwo.org" => array(
		"description"	=> "Heddon PBX",
		"dbtype"	=> "mysql",
		"hostname"	=> "zaleriza.snwo.org",
		"username"	=> "root",
		"password"	=> "NMeHBpWdFUrtGFPj",
		"dbname"	=> "asterisk",
		"tablename"	=> "cdr"
		
	),
	"voip.glide.uk.com" => array(
		"description"	=> "Glide PBX",
		"dbtype"	=> "mysql",
		"hostname"	=> "voip.glide.uk.com",
		"username"	=> "root",
		"password"	=> "passw0rd",
		"dbname"	=> "asteriskcdrdb",
		"tablename"	=> "cdr"
	)
);

// application URL
if (isset($_SERVER["SERVER_NAME"])) {
	if (BETA) {
		define('APP_URL',"http://{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}/");
	} else {
		define('APP_URL',"http://{$_SERVER['SERVER_NAME']}/");
	}
}

?>