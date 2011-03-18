<?php

/**
 * MVC router class.
 * 
 * @package	AGCDR
 * @author	Various, SBF
 * @copyright	2010-2011
 */

/**
 * Router.
 */
class Router {

	/**
	 * Controller path.
	 * 
	 * @var string
	 * @access private
	 */
	private $path;

	/**
	 * Controller file path.
	 * 
	 * @var string
	 * @access public
	 */
	public $file;
	
	/**
	 * Controller name.
	 * 
	 * @var string
	 * @access public
	 */
	public $controller;
	
	/**
	 * Action name.
	 * 
	 * @var string
	 * @access public
	 */
	public $action;
	
	/**
	 * Construct.
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct() {
				
	}

	/**
	 * Set controller directory path.
	 *
	 * @param string $path
	 * 
	 * @return void
	 * @access public
	 */
	public function setPath($path) {

		// check that path is a directory
		if (is_dir($path) == false) {
			throw new Exception("Invalid controller path: {$path}");
		}
		
		$this->path = $path;
	
	}

	/**
	 * Load the controller and execute requested action.
	 *
	 * @access public
	 * @return void
	 */
	public function loader() {
		
		// check the route
		$this->getController();
	
		// if controller not found, redirect to front page
		if (is_readable($this->file) == false) Header("Location: /");
	
		// include the controller
		include $this->file;
	
		// create new controller class instance
		$class = $this->controller;
		$controller = new $class();

		// set controller and action names in the template
		$controller->template->controller = strtolower(preg_replace("/Controller/","",$this->controller));
		$controller->template->action = strtolower($this->action);
		
		// set the page title in the template (can be overridden by controllers if required)
		$controller->template->title = APP_TITLE." - ".ucfirst(preg_replace("/Controller/","",$this->controller))." - ".ucfirst($this->action);
		
		// check if the action is callable, if it's not then default to "index"
		// action which must be present in all controllers
		if (is_callable(array($controller,$this->action)) == false) {
			$action = "index";
		} else {
			$action = $this->action;
		}
		
		// run the action
		$controller->$action();
		
	}
	
	/**
	 * Get the controller and action from the URL.
	 *
	 * @access private
	 * @return void
	 */
	private function getController() {
	
		// determine the route from the URL
		$route = (empty($_GET['route'])) ? '' : $_GET['route'];
		$route = ltrim($route,"/");
		
		if (empty($route)) {
			
			// default to index controller if there is no route 
			$route = "index";

		} else {
			
			// build controller name
			$parts = explode('/',$route);
			$this->controller = ucfirst($parts[0])."Controller";
			
			// set action
			if (isset($parts[1])) $this->action = $parts[1];
			
		}
	
		// set default controller and action if they do not exist
		if (empty($this->controller)) $this->controller = 'IndexController';
		if (empty($this->action)) $this->action = 'index';

		// set the file path
		$this->file = $this->path.'/'.$this->controller.'.php';
		
	}

}

?>