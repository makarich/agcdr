<?php

/**
 * Icon shortcut function.
 * 
 * Not part of the standard Smarty plugins.
 * 
 * @param array $params		- parameters
 * @param object $smarty	- Smarty object
 * 
 * @return string		- <img> HTML tag
 */
function smarty_function_icon($params,&$smarty) {
	
	$html = "<img src=\"/images/icons/{$params["name"]}.png\" width=\"16\" height=\"16\" border=\"0\" align=\"top\" alt=\"{$params["name"]}\" />";
	
	return $html;
	
}

?>