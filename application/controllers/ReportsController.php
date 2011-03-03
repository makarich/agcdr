<?php

/**
 * Main reporting functions.
 * 
 * @package	AGCDR.
 * @author	Various, SBF
 * @copyright	2011
 */

/**
 * ReportsController.
 */
class ReportsController extends BaseController {
	
	/**
	 * Construct via parent.
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct(get_class());	
	}
	
	/**
	 * Prepare and render static index page.
	 * 
	 * @return void
	 * @access public
	 */
	public function index() {

		// render page
		$this->template->show("index");
		
	}

	/**
	 * Detailed month report.
	 * 
	 * @return void
	 * @access public
	 */
	public function month() {
		

		
		// render page
		$this->template->show("month");
		
	}
	
	/**
	 * Detailed year report.
	 * 
	 * @return void
	 * @access public
	 */
	public function year() {
		
		
		
		// render page
		$this->template->show("year");
		
	}
	
	/**
	 * Quick search.
	 * 
	 * @return void
	 * @access public
	 */
	public function quick_search() {
		
		
		
		// render page
		$this->template->show("quick_search");
		
	}
	
	/**
	 * Advanced search.
	 * 
	 * @return void
	 * @access public
	 */
	public function advanced_search() {
		
		
		
		// render page
		$this->template->show("advanced_search");
		
	}
	
}

?>