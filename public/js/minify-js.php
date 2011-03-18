#!/usr/bin/php
<?php 

/**
 * Minifies all the JS files in use from their full-fat masters.
 * 
 * @author	SBF
 * @copyright	2010-2011
 */

// required resources
$libpath = "./jsmin-v1.1.1.php";
if (!is_file($libpath)) die("Please run this script within the Javascript directory.\n");
require_once($libpath);

// get list of JS masters
$masters = array();
$dh = opendir(".");
while (false !== ($file = readdir($dh))) {
	if (substr($file,-3) == ".js" && substr($file,-7) != "-min.js") array_push($masters,$file);
}
closedir($dh);

// minify each master
foreach ($masters as $master) {
	
	$minifile = preg_replace("/.js/","",$master)."-min.js";
	print "Minifying {$master} into {$minifile} ... ";
	
	$minified = JSMin::minify(file_get_contents($master));
	file_put_contents($minifile,$minified);
	
	$oldsize = filesize($master);
	$newsize = filesize($minifile);
	$pc = round((100-($newsize/$oldsize)*100),1);
	
	print "saved ".($oldsize-$newsize)." bytes ({$pc}%).\n";
	
}

?>
