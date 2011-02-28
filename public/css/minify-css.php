#!/usr/bin/php
<?php 

/**
 * Minifies all the CSS files in use from their full-fat masters.
 * 
 * @author	SBF
 * @copyright	2010-2011
 */

// required resources
$libpath = "./cssmin-v2.0.1.0064.php";
if (!is_file($libpath)) die("Please run this script within the stylesheet directory.\n");
require_once($libpath);

// get list of CSS masters
$masters = array();
$dh = opendir(".");
while (false !== ($file = readdir($dh))) {
	if (substr($file,-4) == ".css" && substr($file,-8) != "-min.css") array_push($masters,$file);
}
closedir($dh);

// minify each master
foreach ($masters as $master) {
	
	$minifile = preg_replace("/.css/","",$master)."-min.css";
	print "Minifying {$master} into {$minifile} ... ";
	
	$minified = CssMin::minify(file_get_contents($master));
	file_put_contents($minifile,$minified);
	
	$oldsize = filesize($master);
	$newsize = filesize($minifile);
	$pc = round((100-($newsize/$oldsize)*100),1);
	
	print "saved ".($oldsize-$newsize)." bytes ({$pc}%).\n";
	
}

?>
