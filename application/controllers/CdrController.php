<?php

/**
 * Manages individual caller detail records.
 * 
 * @package	AGCDR.
 * @author	Various, SBF
 * @copyright	2011
 */

/**
 * CdrController.
 */
class CdrController extends BaseController {
	
	/**
	 * Construct via parent.
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct(get_class());	
	}
	
	/**
	 * There is no index for this controller but we have to define the method
	 * because the abstract class demands it.
	 * 
	 * @return void
	 * @access public
	 */
	public function index() { }
	
	/**
	 * View a CDR.
	 * 
	 * @return void
	 * @access public
	 */
	public function view() {

		// retrieve CDR
		$cdr = new cdr();
		$cdr->load_by(array("uniqueid" => $this->get["uid"]));

		// extra information not returned by the standard model
		if ($cdr->uniqueid = $this->get["uid"]) {
			$cdr->duration_formatted = $this->db->GetOne("SELECT SEC_TO_TIME(duration) FROM ".DB_TABLE." WHERE uniqueid='{$this->get["uid"]}'");
			$cdr->billsecs_formatted = $this->db->GetOne("SELECT SEC_TO_TIME(billsec) FROM ".DB_TABLE." WHERE uniqueid='{$this->get["uid"]}'");
		}

		// render page
		$this->template->cdr = $cdr;
		$this->template->show("view");
		
	}

}

?>