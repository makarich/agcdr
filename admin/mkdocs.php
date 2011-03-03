#!/usr/bin/php
<?php

/**
 * Generate PhpDocumentor documentation.
 * 
 * @package	AGCDR
 * @author	Stuart Benjamin Ford <stuartford@me.com>
 * @copyright	03/03/2011
 */

// my path
$mypath = realpath(dirname(array_shift($argv)));

// process each target directory
foreach (array("controllers","models","classes") as $dir) {

	// base command
	$cmd = "phpdoc -d {$mypath}/../application/{$dir} -t {$mypath}/../docs/phpdoc/{$dir}/ -ti 'AGCDR ".ucfirst($dir)."' -dn 'AGCDR'";
	
	// include private functions?
	if (in_array("pp",$argv)) $cmd .= " -pp";
	
	// use evolve template?
	if (in_array("evolve",$argv)) $cmd .= " -o HTML:Smarty/Evolve:default -s on";
	
	// show and run command
	print "{$cmd}\n";
	system($cmd);
	
}

?>