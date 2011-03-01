<?php

/**
 * IndexController.php.
 * 
 * Presents landing page, introduction main options.
 * 
 * @package	AGCDR.
 * @author	Various, SBF
 * @copyright	2011
 */

/**
 * IndexController.
 */
class IndexController extends BaseController {
	
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