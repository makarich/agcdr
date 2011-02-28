<?php

/**
 * Template.php		Template control class and supporting functions.
 * 
 * @author		Various, SBF
 * @copyright		2010-2011
 */

class Template {

	/**
	 * Variables array
	 * 
	 * @var Array
	 * @access private
	 */
	private $vars = array();
	
	/**
	 * Smarty template object
	 * 
	 * @var object
	 * @access protected
	 */
	public $smarty;
	
	/**
	 * Name of controller.
	 * 
	 * @var string
	 * @access private
	 */
	private $controller;
	
	/**
	 * Construct.
	 * 
	 * @return void
	 */
	function __construct($controller) {
		
		// set up Smarty template object
		$smarty = new Smarty();
		$smarty->template_dir = APP_PATH."/views";
		$smarty->compile_dir = DATA_PATH."/templates_c";
		$smarty->cache_dir = DATA_PATH."/cache";
		$smarty->config_dir = DATA_PATH."/configs";
		$this->smarty = $smarty;
		
		// set controller name
		$this->controller = $controller;
		
	}
	
	/**
	 * Setter - sets template variables in the variables array. These are
	 * then assigned to the Smarty object when the show() method is called.
	 * 
	 * @param unknown_type $index
	 * @param unknown_type $value
	 * @return void
	 */
	public function __set($index,$value) {
		$this->vars[$index] = $value;
	}
	
	/**
	 * Render specified template
	 * 
	 * @param String $name		- template name inside a subdirectory of "views" named after the controller
	 * @return void
	 */
	function show($name) {
		
		// path to template
		$path = strtolower(preg_replace("/Controller/","",$this->controller)."/{$name}.tpl");

		// check template file exists
		if (file_exists(APP_PATH."/views/{$path}") == false) { 
			throw new Exception("Template not found in {$path}");
			return false;
		}
		
		// assign variables
		foreach ($this->vars as $key => $value) $this->smarty->assign($key,$value);
		
		// render template
		$this->smarty->display($path);
		
	}
	
	/**
	 * Returns string of <OPTION> tags for use a SELECT menu or by the jQuery
	 * Datables plugin to render a "records per page" menu, amongst other
	 * applications.
	 * 
	 * @param integer $totalrows	- Maximum number of rows per page (usually the total record count)
	 * @return string
	 * @access public
	 */
	public function datatablesRecordCountMenu($totalrows) {
		
		$menuoptions = "";
		$numbers = array();
		
		// low numbers
		foreach (array(10,25,50) as $i) {
			if ($i <= $totalrows) {
				array_push($numbers,$i);
			}
		}
		
		// hundreds
		if ($totalrows >= 100) {
			for ($i=100; $i<1000; $i=$i+100) {
				if ($i <= $totalrows) {
					array_push($numbers,$i);
				}
			}
		}
		
		// thousands
		if ($totalrows >= 1000) {
			for ($i=1000; $i<10000; $i=$i+1000) {
				if ($i <= $totalrows) {
					array_push($numbers,$i);
				}
			}
		}
		
		// tens of thousands
		if ($totalrows >= 10000) {
			for ($i=10000; $i<100000; $i=$i+10000) {
				if ($i <= $totalrows) {
					array_push($numbers,$i);
				}
			}
		}
		
		// hundreds of thousands
		if ($totalrows >= 100000) {
			for ($i=100000; $i<1000000; $i=$i+100000) {
				if ($i <= $totalrows) {
					array_push($numbers,$i);
				}
			}
		}
		
		// assemble string
		foreach ($numbers as $number) {
			$menuoptions .= "<option value=\"{$number}\">{$number}</option>";
		}
		
		// add "all" option
		if (!in_array($totalrows,$numbers)) {
			$menuoptions .= "<option value=\"{$totalrows}\">{$totalrows} (all)</option>";
		}
		
		return $menuoptions;
		
	}
	
}

?>