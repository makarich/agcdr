<?php

/**
 * Box loader function
 * 
 * Not part of the standard Smarty plugins.
 * 
 * @param array $params		- parameters
 * @param object $smarty	- Smarty object
 * 
 * @return string		- <img> HTML tag
 */
function smarty_function_boxloader($params,&$smarty) {
	
	$html = "<div class=\"boxloader\">";
	$html .= "<img src=\"/images/ajax-loader-large.gif\" width=\"66\" height=\"66\" alt=\"Loader\" /><br /><br />";
	$html .= "Loading box {$params['box']}";
	$html .= "</div>";
	
	return $html;
	
}

?>