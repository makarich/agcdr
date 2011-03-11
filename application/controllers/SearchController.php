<?php

/**
 * Search engine functions.
 * 
 * @package	AGCDR
 * @author	Various, SBF
 * @copyright	2011
 */

/**
 * SearchController.
 */
class SearchController extends BaseController {
	
	/**
	 * Construct via parent.
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct(get_class());	
	}
	
	/**
	 * Prepare and render advanced search form.
	 * 
	 * @return void
	 * @access public
	 */
	public function index() {

		// render page
		$this->template->show("index");
		
	}
	
	/**
	 * Perform search and return results.
	 * 
	 * @return void
	 * @access public
	 */
	public function results() {

		// is this a quick search?
		if (isset($_POST["quicksearch"])) {

			// check that keyword is at least 3 characters in length
			// this is checked by JavaScript, but need to check just in case
			if (strlen($_POST["quicksearch"]) < 3) return false;

			// build query
			
			foreach (array_keys(get_object_vars(new cdr())) as $field) {
				if ($field != "id") {
					$where[] = "{$field} LIKE '%{$_POST["quicksearch"]}%'";
				}
			}
			
			$sql = "SELECT	".DB_TABLE.".uniqueid, ".DB_TABLE.".*,
					SEC_TO_TIME(".DB_TABLE.".duration) AS formatted_duration,
					SEC_TO_TIME(".DB_TABLE.".billsec) AS formatted_billsec
				FROM ".DB_TABLE."
				WHERE ".implode(" OR ",$where)."
				ORDER BY calldate DESC;
			";

			// run query
			$results = $this->db->GetAssoc($sql);

			// set quick search string back in template
			$this->template->quicksearch = $_POST["quicksearch"];
			
		} else {
			
			// it's a proper search
			
			
			
		}
		
		// set results in template
		$this->template->results = $results;
		$this->template->menuoptions = $this->template->datatablesRecordCountMenu(count($results));
		
		// render page
		$this->template->show("results");
		
	}

	
}

?>