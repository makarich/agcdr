<?php

/**
 * Presents landing page, introduction and main options.
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
	 * List of overview boxes to render (in order).
	 * 
	 * @var array
	 * @access private
	 */
	private $boxes = array(
		"10_most_recent",
		"summary_day",
		"summary_week",
		"top10_src",
		"top10_dst",
		"top10_clid"
	);
	
	/**
	 * Construct via parent.
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct(get_class());	
	}
	
	/**
	 * Prepare and render overview/landing page.
	 * 
	 * @return void
	 * @access public
	 */
	public function index() {

		// set list of boxes to render
		$this->template->boxes = $this->boxes;
		$this->template->boxlist = "'".implode("','",$this->boxes)."'";
		
		// render page
		$this->template->show("index");
		
	}
	
	/**
	 * Load overview box content.
	 * 
	 * @return void
	 * @access public
	 */
	public function box() {
		
		// prepare box data
		switch ($this->get["box"]) {
			
			case "10_most_recent":
				
				
				
				break;
				
			case "summary_day":
				
				
				
				break;
				
			case "summary_week":
				
				
				
				break;
				
			case "top10_src":
				
				
				
				break;
				
			case "top10_dst":
				
				
				
				break;
				
			case "top10_clid":
				
				
				
				break;
			
		}
		
		// render box template
		$this->template->show("box_".$this->get["box"]);
		
	}

}

?>