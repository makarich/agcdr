<?php

/**
 * Main application configuration script
 * 
 * @package	AGCDR
 * @author	SBF
 * @copyright	2010-2011
 */

// full URL of your virtual host
define('LIVE_URL','http://agcdr.heddonconsulting.com/');

// main database server configuration (first server is the default)
$_SESSION["servers"] = array(
	"zaleriza.snwo.org" => array(
		"description"	=> "Home PBX",
		"type"		=> "mysql",
		"hostname"	=> "zaleriza.snwo.org",
		"username"	=> "asterisk",
		"password"	=> "irkEsdecs8",
		"dbname"	=> "asterisk",
		"tablename"	=> "cdr"
		
	),
	"voip.glide.uk.com" => array(
		"description"	=> "Glide PBX",
		"type"		=> "mysql",
		"hostname"	=> "voip.glide.uk.com",
		"username"	=> "root",
		"password"	=> "passw0rd",
		"dbname"	=> "asteriskcdrdb",
		"tablename"	=> "cdr"
	)
);

/**
 * It's not necessary to change anything beyond this point but you obviously
 * can if you wish. Of most interest will be configuration that changes the
 * way the system looks, such as CHART_PALETTE AND JQUI_THEME.
 */

// release version
define('VERSION','1.0.1.0');

// beta version flag
define('BETA',true);

// application titles (short and long)
define('APP_TITLE','AGCDR');
define('LONG_TITLE','Asterisk CDR Statistics');

// jQuery UI theme to use
// (the theme must be installed in public/libraries/<jquery-ui>/css/)
define('JQUI_THEME','smoothness');

// chart colour palette to use
define('CHART_PALETTE','pastel');

// chart cache expiry (seconds, 86400 = 1 day, 604800 = 1 week)
define('CHART_CACHE_EXPIRE',604800);

?>