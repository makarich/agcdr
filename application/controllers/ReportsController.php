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
					AND calldate <= '{$month}-{$day} 23:59:59';
			");

			$chart_calls->values[] = $stat["calls"];
			$chart_mins->values[] = round($stat["seconds"]/60);

		}

		// create time of day breakdown chart
		$chart_todb = new BarChart("Time of day breakdown (number of calls) ({$monthlabel})");
		$chart_todb->dimensions = "700x350";
		$chart_todb->margins = array(35,35,35,35);
		$chart_todb->barwidth = 16;
		$chart_todb->palette = CHART_PALETTE;
		$chart_todb->x_labels = range(0,23);
		
		// calculate time of day breakdown
		$hours = array();
		foreach (range(0,23) as $hour) {
			
			$stat = $this->db->GetOne(sprintf("
				SELECT COUNT(*) AS calls
				FROM ".DB_TABLE."
				WHERE	calldate LIKE '{$month}%%'
					AND calldate LIKE '%% %02d:%%'
			",$hour));
			
			$chart_todb->values[] = $stat;
			
		}

		// assign chart URLs to template
		$this->template->chart_calls = $chart_calls->saveFile(CHART_CACHE);
		$this->template->chart_mins = $chart_mins->saveFile(CHART_CACHE);
		$this->template->chart_todb = $chart_todb->saveFile(CHART_CACHE);

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
					AND calldate < DATE_ADD('{$year}-{$month}-01 00:00:00', INTERVAL 1 MONTH);
			");

			$chart_calls->values[] = $stat["calls"];
			$chart_mins->values[] = round($stat["seconds"]/60);

		}

		// create time of day breakdown chart
		$chart_todb = new BarChart("Time of day breakdown (number of calls) ({$year})");
		$chart_todb->dimensions = "700x350";
		$chart_todb->margins = array(35,35,35,35);
		$chart_todb->barwidth = 16;
		$chart_todb->palette = CHART_PALETTE;
		$chart_todb->x_labels = range(0,23);
		
		// calculate time of day breakdown
		$hours = array();
		foreach (range(0,23) as $hour) {
			
			$stat = $this->db->GetOne(sprintf("
				SELECT COUNT(*) AS calls
				FROM ".DB_TABLE."
				WHERE	calldate LIKE '{$year}%%'
					AND calldate LIKE '%% %02d:%%'
			",$hour));
			
			$chart_todb->values[] = $stat;
			
		}
		
		// assign chart URLs to template
		$this->template->chart_calls = $chart_calls->saveFile(CHART_CACHE);
		$this->template->chart_mins = $chart_mins->saveFile(CHART_CACHE);
		$this->template->chart_todb = $chart_todb->saveFile(CHART_CACHE);
		
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
			
		} else if (isset($this->get["number"])) {
			
			// box is for a specific number, so use the date range in which that number appears
			$number = $this->get["number"];

			$numdates = $this->db->GetRow("
				SELECT MIN(calldate) AS min_date, MAX(calldate) AS max_date
				FROM ".DB_TABLE."
				WHERE clid = '{$number}' OR src = '{$number}' OR dst = '{$number}';
			");

			$from = "'".$numdates['min_date']."'";
			$to = "'".$numdates['max_date']."'";
			
		} else {
			
			// no date data passed, just do today
			$today = date("Y-m-d");
			$from = "'{$today} 00:00:00'";
			$to = "DATE_ADD('{$today} 00:00:00', INTERVAL 1 DAY)";
			
		}
		
		// prepare box data
		switch ($this->get["box"]) {

			case "general_stats":
				
				// general statistics

				// calculate number of days in period concerned
				$days = $this->db->GetOne("SELECT TO_DAYS({$to}) - TO_DAYS({$from})");
				
				// if we are part of the way through the month or year concerned then we
				// need to reduce the number of days otherwise the averages won't be accurate
				if (isset($this->get["year"]) && $this->get["year"] == date("Y")) {
					$days = $this->db->GetOne("SELECT TO_DAYS(NOW()) - TO_DAYS('{$this->get["year"]}-01-01')");
				} else if (isset($this->get["month"]) && $this->get["month"] == date("Y-m")) {
					$days = $days - ($days - intval(date("d")));
				}

				// restrict search by number?
				if (isset($number)) {
					$number_clause = "AND (clid='{$number}' OR src='{$number}' OR dst='{$number}')";
					$this->template->number = $number;
				}
				
				// perform database calculations
				$calc = $this->db->GetRow("
					SELECT	COUNT(*) AS total_calls,
						SUM(duration) AS total_seconds,
						SEC_TO_TIME(SUM(duration)) AS total_time
					FROM ".DB_TABLE."
					WHERE calldate >= {$from} AND calldate < {$to} {$number_clause};
				");
				
				// calculate total minutes
				$total_minutes = round($calc["total_seconds"]/60,0);
				
				// format data array
				$statistics = array(
					"Days in report period"		=> $days,
					"Total calls"			=> $calc["total_calls"],
					"Total minutes"			=> $total_minutes,
					"Total time"			=> $calc["total_time"],
					"Average calls per day"		=> number_format($calc["total_calls"]/$days,1),
					"Average minutes per day"	=> number_format($total_minutes/$days,1),
					"Average calls per week"	=> number_format(($calc["total_calls"]/$days)*7,1),
					"Average minutes per week"	=> number_format(($total_minutes/$days)*7,1)
				);
				
				// extras for year reports
				if (isset($this->get["year"])) {
					$statistics["Average calls per month"] = number_format(($calc["total_calls"]/$days)*(365/12),1);
					$statistics["Average minutes per month"] = number_format(($total_minutes/$days)*(365/12),1);
				}
				
				// apply to template
				$this->template->statistics = $statistics;
				
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
				
			case "recent_to":
			case "recent_from":
				
				// recent calls to or from a particular number

				$numfield = ($this->get["box"] == "recent_to") ? "dst" : "src";
				$dspfield = ($numfield == "dst") ? "src" : "dst";
						
				$recent = $this->db->GetAssoc("
					SELECT uniqueid,calldate,{$dspfield} AS numfield,lastapp,SEC_TO_TIME(duration) AS formatted_duration
					FROM ".DB_TABLE."
					WHERE ({$numfield}='{$number}')
					ORDER BY calldate DESC LIMIT 12;
				");

				$this->template->cdrs = $recent;
				$this->template->number = $number;
				
				break;
			
		}
		
		// render box template
		$this->template->show("box_".$this->get["box"]);
		
	}
	
	/**
	 * Specific number report.
	 * 
	 * @return void
	 * @access public
	 */
	public function number() {
		
		if (isset($this->get["number"])) {

			// remove spaces from number
			$number = preg_replace("/ /","",$this->get["number"]);
			
			// create report data array
			$report = array("number" => $number);
			
			// list of overview boxes to render (in order).
			$boxes = array(
				"general_stats",
				"recent_from",
				"recent_to"
			);
			
			// set list of boxes to render
			$this->template->boxes = $boxes;
			$this->template->boxlist = "'".implode("','",$boxes)."'";
			
			// assign report data to template
			$this->template->report = $report;
			
		} else {
			
			// create wizard
			$wizard = new FormWizard("Specify number");
			$wizard->next = "Analyse number";
			
			$message = new WizardErrorMessage(
				"This report provides detailed information on calls to or from a specific telephone or extension number. Reports can also be generated by clicking on numbers in caller detail record tables in other reports or search results",
				"info"
			);
			$message->add_to($wizard);
			
			$number = new WizardTextBox("number");
			$number->label = "Number to examine";
			$number->size = 15;
			$number->add_to($wizard);
			
			// add to template
			$this->template->formwizard = $wizard;
			
		}
		
		// render page
		$this->template->show("number");
		
	}
	
}

?>