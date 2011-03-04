#!/usr/bin/php
<?php

/**
 * Prepare and commit.
 * 
 * Compiles minified JS and CSS files and generates phpdoc documentation before
 * commiting to SVN. Basically a lazy shortcut for running the other admin
 * scripts and a manual commit.
 * 
 * Under construction, not complete.
 * 
 * @package	AGCDR
 * @author	Stuart Benjamin Ford <stuartford@me.com>
 * @copyright	03/03/2011
 */

// my path
$mypath = realpath(dirname(array_shift($argv)));

// set commit text if not passed
if (isset($argv[0])) {
	$commit = $argv[0];
} else {
	exec("hostname -f",$host);
	$user = rtrim(`whoami`);
	$commit = strftime("General commit on %d/%m/%Y %H:%M by {$user}@{$host[0]}.",time());
}

// create command list
$commands = array(
//	"{$mypath}/mkdocs.php",
	"rm -f {$mypath}/../public/images/charts/*.png",
	"svn status {$mypath}/..",
	"svn commit -m \"{$commit}\" {$mypath}/.."
);

// run commands
foreach ($commands as $cmd) {
	print "{$cmd}\n";
	system($cmd);
}

?>
