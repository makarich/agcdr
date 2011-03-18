<?php

/**
 * Manages help pages.
 * 
 * @package	AGCDR.
 * @author	Various, SBF
 * @copyright	2011
 */

/**
 * HelpController.
 */
class HelpController extends BaseController {
	
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

}

?>