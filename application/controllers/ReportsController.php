<?php

/**
 * ReportsController.php
 * 
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
	function __construct() {
		parent::__construct(get_class());	
	}
	
	/**
	 * Prepare and render static index page.
	 * 
	 * @return void
	 */
	public function index() {

		// render page
		$this->template->show("index");
		
	}

}

?>