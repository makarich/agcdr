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

// main database server configuration
$db_servers = array(
	"zaleriza.snwo.org" => array(
		"password"	=> "NMeHBpWdFUrtGFPj",
		"username"	=> "root",
		"hostname"	=> "zaleriza.snwo.org",
		"dbname"	=> "asterisk",
		"dbtype"	=> "mysql"
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

/*

Suitable Apache virtual host configuration

<VirtualHost *:port>

        DocumentRoot /path/to/public/dir

        <Directory /path/to/public/dir/>
                Options SymLinksIfOwnerMatch
                AllowOverride All
                Order deny,allow
                allow from all
        </Directory>

	RewriteCond %{REQUEST_URI} !^/images/
	RewriteCond %{REQUEST_URI} !^/libraries/
        RewriteCond %{REQUEST_URI} !^/css
        RewriteCond %{REQUEST_URI} !^/js
	RewriteCond %{REQUEST_URI} !^/Favicon.ico
        RewriteRule ^(.*)$ /index.php?route=$1

        ErrorLog /path/to/error.log
        LogLevel debug
        CustomLog /path/to/access.log combined

</VirtualHost>

*/
	
?>