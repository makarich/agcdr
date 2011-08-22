#!/usr/bin/php
<?php

/**
 * Prepare and commit.
 *
 * @package	AGCDR
 * @author	Stuart Benjamin Ford <stuartford@me.com>
 * @copyright	12/04/2011
 */

// my path
$mypath = realpath(dirname(array_shift($argv)));

// set commit text if not passed
if (isset($argv[1])) {
	$commit = $argv[1];
} else {
	exec("hostname -f",$host);
	$user = rtrim(`whoami`);
	$commit = strftime("General commit on %d/%m/%Y %H:%M by {$user}@{$host[0]}.",time());
}

// create command list
$commands = array(
	"cp {$mypath}/../application/config.php /tmp/agcdr.conf",
	"cp {$mypath}/example-config.php {$mypath}/../application/config.php",
	"rm -f {$mypath}/../public/images/charts/*.png",
	"git --git-dir={$mypath}/../.git --work-tree={$mypath}/../ status",
	"git --git-dir={$mypath}/../.git --work-tree={$mypath}/../ commit -a -m \"{$commit}\"",
	"git --git-dir={$mypath}/../.git --work-tree={$mypath}/../ push",
	"mv /tmp/agcdr.conf {$mypath}/../application/config.php"
);

// run commands
foreach ($commands as $cmd) {
	print "{$cmd}\n";
	system($cmd);
}

?>
