<?php

/**
 * Main reporting functions.
 * 
 * @package	AGCDR
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
	 * There is no index for this controller but we have to define the method
	 * because the abstract class demands it.
	 * 
	 * @return void
	 * @access public
	 */
	public function index() { }

	/**
	 * Detailed month report.
	 * 
	 * @return void
	 * @access public
	 */
	public function month() {
		
		// which month?
		if (isset($this->get["month"])) {
			$month = $this->get["month"];
		} else {
			$month = strftime("%Y-%m",time());	
		}
		
		// list of overview boxes to render (in order).
		$boxes = array(
			"general_stats",
			"top_src",
			"top_dst",
			"top_clid",
		);
		
		// set list of boxes to render
		$this->template->boxes = $boxes;
		$this->template->boxlist = "'".implode("','",$boxes)."'";
		
		// calculate previous and next months
		$dobj = new DateTime("{$month}-01");
		$dobj->sub(new DateInterval("P1M"));
		$prev_month = $dobj->format("Y-m");
		$dobj = new DateTime("{$month}-01");
		$dobj->add(new DateInterval("P1M"));
		$next_month = $dobj->format("Y-m");
		
		// set month and year information in template
		$this->template->month = $month;
		$this->template->year = substr($month,0,4);
		$this->template->prev_month = $prev_month;
		$this->template->next_month = $next_month;
		$monthlabel = strftime("%B %Y",strtotime("{$month}-01"));
		$this->template->monthlabel = $monthlabel;
		$this->template->prev_monthlabel = strftime("%B %Y",strtotime("{$prev_month}-01"));
		$this->template->next_monthlabel = strftime("%B %Y",strtotime("{$next_month}-01"));
		
		// create calls chart
		$chart_calls = new BarChart("Calls per day ({$monthlabel})");
		$chart_calls->dimensions = "700x350";
		$chart_calls->margins = array(35,35,35,35);
		$chart_calls->barwidth = 16;
		$chart_calls->palette = CHART_PALETTE;
		$chart_calls->x_labels = range(1,date("t",strtotime("{$month}-01")));
		
		// create minutes chart
		$chart_mins = new BarChart("Minutes per day ({$monthlabel})");
		$chart_mins->dimensions = "700x350";
		$chart_mins->margins = array(35,35,35,35);
		$chart_mins->barwidth = 16;
		$chart_mins->palette = CHART_PALETTE;
		$chart_mins->x_labels = range(1,date("t",strtotime("{$month}-01")));

		// calculate daily statistics
		foreach (range(1,date("t",strtotime("{$month}-01"))) as $day) {
			
			$day = sprintf("%02d",$day);
			
			$stat = $this->db->GetRow("
				SELECT	COUNT(*) AS calls,
					SUM(duration) AS seconds
				FROM ".DB_TABLE."
				WHERE 	calldate >= '{$month}-{$day} 00:00:00'
					AND CALLDATE <= '{$month}-{$day} 23:59:59';
			");

			$chart_calls->values[] = $stat["calls"];
			$chart_mins->values[] = round($stat["seconds"]/60);

		}

		// assign chart URLs to template
		$this->template->chart_calls = $chart_calls->saveFile(CHART_CACHE);
		$this->template->chart_mins = $chart_mins->saveFile(CHART_CACHE);
		
		// assign statistics to template
		$this->template->total_calls = array_sum($chart_calls->values);
		$this->template->average_calls = round(array_sum($chart_calls->values)/count($chart_calls->values));
		$this->template->total_mins = array_sum($chart_mins->values);
		$this->template->average_mins = round(array_sum($chart_mins->values)/count($chart_mins->values));
		
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
		
		// which year?
		if (isset($this->get["year"])) {
			$year = $this->get["year"];
		} else {
			$year = strftime("%Y",time());	
		}
		
		// list of overview boxes to render (in order).
		$boxes = array(
			"general_stats",
			"top_src",
			"top_dst",
			"top_clid",
		);
		
		// set list of boxes to render
		$this->template->boxes = $boxes;
		$this->template->boxlist = "'".implode("','",$boxes)."'";

		// set month and year information in template
		$this->template->year = $year;
		
		// array of month names for chart X axis
		$monthnames = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
		
		// create calls chart
		$chart_calls = new BarChart("Calls per month ({$year})");
		$chart_calls->dimensions = "700x350";
		$chart_calls->margins = array(35,35,35,35);
		$chart_calls->barwidth = 45;
		$chart_calls->palette = CHART_PALETTE;
		$chart_calls->x_labels = $monthnames;
		
		// create minutes chart
		$chart_mins = new BarChart("Minutes per month ({$year})");
		$chart_mins->dimensions = "700x350";
		$chart_mins->margins = array(35,35,35,35);
		$chart_mins->barwidth = 45;
		$chart_mins->palette = CHART_PALETTE;
		$chart_mins->x_labels = $monthnames;

		// calculate daily statistics
		foreach (range(1,12) as $month) {
			
			$month = sprintf("%02d",$month);
			
			$stat = $this->db->GetRow("
				SELECT	COUNT(*) AS calls,
					SUM(duration) AS seconds
				FROM ".DB_TABLE."
				WHERE 	calldate >= '{$year}-{$month}-01 00:00:00'
					AND CALLDATE < DATE_ADD('{$year}-{$month}-01 00:00:00', INTERVAL 1 MONTH);
			");

			$chart_calls->values[] = $stat["calls"];
			$chart_mins->values[] = round($stat["seconds"]/60);

		}

		// assign chart URLs to template
		$this->template->chart_calls = $chart_calls->saveFile(CHART_CACHE);
		$this->template->chart_mins = $chart_mins->saveFile(CHART_CACHE);
		
		// assign statistics to template
		$this->template->total_calls = array_sum($chart_calls->values);
		$this->template->average_calls_month = round(array_sum($chart_calls->values)/12);
		$this->template->average_calls_week = round(array_sum($chart_calls->values)/52);
		$this->template->total_mins = array_sum($chart_mins->values);
		$this->template->average_mins_month = round(array_sum($chart_mins->values)/12);
		$this->template->average_mins_week = round(array_sum($chart_mins->values)/22);
		
		// render page
		$this->template->show("year");
		
	}

	/**
	 * Load overview box content.
	 * 
	 * These boxes are based on those that appear in the main overview
	 * with the exception that they limit themselves to data from a
	 * particular month.
	 * 
	 * @return void
	 * @access public
	 */
	public function box() {

		// determine dates
		if (isset($this->get["year"])) {
			
			// calculate overview for year
			$from = "'{$this->get['year']}-01-01 00:00:00'";
			$to = "DATE_ADD('{$this->get['year']}-01-01 00:00:00', INTERVAL 1 YEAR)";
			
		} else if (isset($this->get["month"])) {
			
			// calculate overview for month
			$from = "'{$this->get['month']}-01 00:00:00'";
			$to = "DATE_ADD('{$this->get['month']}-01 00:00:00', INTERVAL 1 MONTH)";
			
		} else {
			
			// no date data passed, just do today
			$today = date("Y-m-d");
			$from = "'{$today} 00:00:00'";
			$to = "DATE_ADD('{$tody} 00:00:00', INTERVAL 1 DAY)";
			
		}
		
		// prepare box data
		switch ($this->get["box"]) {

			case "general_stats":
				
				// general statistics
				
				
				
				break;
			
			case "top_src":
				
				// most popular sources
				
				$popular = $this->db->GetAssoc("
					SELECT src, COUNT(*) AS count
					FROM ".DB_TABLE."
					WHERE	src IS NOT NULL AND src != ''
						AND calldate >= {$from} AND calldate < {$to}
					GROUP BY src
					ORDER BY count DESC LIMIT 12;
				");
				$this->template->numbers = $popular;
				
				break;
				
			case "top_dst":
				
				// most popular destinations

				$popular = $this->db->GetAssoc("
					SELECT dst, COUNT(*) AS count
					FROM ".DB_TABLE."
					WHERE	dst IS NOT NULL AND dst != ''
						AND calldate >= {$from} AND calldate < {$to}
					GROUP BY dst
					ORDER BY count DESC LIMIT 12;
				");
				$this->template->numbers = $popular;
				
				break;
				
			case "top_clid":
				
				// most popular caller IDs

				$popular = $this->db->GetAssoc("
					SELECT clid, COUNT(*) AS count
					FROM ".DB_TABLE."
					WHERE	clid IS NOT NULL AND clid != ''
						AND calldate >= {$from} AND calldate < {$to}
					GROUP BY clid
					ORDER BY count DESC LIMIT 12;
				");
				$this->template->numbers = $popular;
				
				break;
			
		}
		
		// render box template
		$this->template->show("box_".$this->get["box"]);
		
	}
	
}

?>