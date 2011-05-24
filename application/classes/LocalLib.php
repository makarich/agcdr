<?php

/**
 * AGCDR-specific shared methods.
 * 
 * @package	AGCDR
 * @author	SBF
 * @copyright	2011
 */

/**
 * LocalLib.
 */
class LocalLib {

	/**
	 * Construct.
	 * 
	 * @access public
	 */
	public function __construct() {
		
	}
	
	/**
	 * Calculate the totals of the "duration" and "billsec" fields from
	 * a recordset of CDRs.
	 * 
	 * @param array $cdrs	- caller detail records returned from database
	 * 
	 * @return array	- associative array of total figures, or false if there was a problem
	 * @access public
	 */
	public static function calculate_duration_totals($cdrs) {
		
		// basic checks
		if (!is_array($cdrs)) return false;
		
		// create totals array
		$totals = array(
			"duration"		=> 0,
			"duration_formatted"	=> "",
			"billsec"		=> 0,
			"billsec_formatted"	=> ""
		);
		
		// total up each field
		foreach ($cdrs as $uid => $cdr) {
			$totals["duration"] += $cdr["duration"];	
			$totals["billsec"] += $cdr["billsec"];
		}
		
		// create formatted H:M:S strings
		foreach (array("duration","billsec") as $field) {
			$totals["{$field}_formatted"] = Utilities::seconds2hms($totals[$field]);
		}

		// return totals
		return $totals;
		
	}
	
}

?>