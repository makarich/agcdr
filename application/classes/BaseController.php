<?php

/**
 * BaseController.php	Base controller class
 * 
 * @author		Various, SBF
 * @copyright		2010
 */

abstract class BaseController {
	
	/**
	 * Template object.
	 * 
	 * @var object
	 * @access public
	 */
	public $template;
	
	/**
	 * Database object.
	 * 
	 * @var object
	 * @access protected
	 */
	protected $db;
	
	/**
	 * Utility class object.
	 * 
	 * @var object
	 * @access protected
	 */
	protected $utils;
	
	/**
	 * Array of parameters extracted from GET query.
	 * 
	 * @var array
	 * @access protected
	 */
	protected $get = array();
	
	/**
	 * Construct.
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct($controller) {
		
		// create database connection
		$this->db = DB::Instance();
		
		// create template object
		$this->template = new Template($controller);
		
		// access to utilities library
		$this->utils = new Utilities();
		
		// extract parameters from GET request
		if (isset($_SERVER["REQUEST_URI"])) {
			$uri_parts = explode("/",$_SERVER["REQUEST_URI"]);
			$params = explode("&",ltrim(array_pop($uri_parts),"?"));
			foreach ($params as $param) {
				$parts = explode("=",$param);
				$this->get[$parts[0]] = $parts[1];
			}
		}
		
	}

	/**
	 * All controllers must contain an index method.
	 * 
	 * @return void
	 */
	abstract function index();
	
}

?>