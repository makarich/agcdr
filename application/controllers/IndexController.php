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
		"most_recent",
		"summary_day",
		"summary_week",
		"top_src",
		"top_dst",
		"top_clid"
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
			
			case "most_recent":

				// most recent calls
				
				$recent = $this->db->GetAssoc("
					SELECT uniqueid,calldate,src,dst,SEC_TO_TIME(duration) AS formatted_duration
					FROM ".DB_TABLE."
					ORDER BY calldate DESC LIMIT 13;
				");
				$this->template->cdrs = $recent;
				
				break;
				
			case "summary_day":
				
				// summary for the current day
				
				$barchart = new BarChart(date("l jS F Y")." (minutes)");
				$barchart->dimensions = "300x265";
				$barchart->x_labels = range(0,23);
				$barchart->margins = array(25,5,5,5);
				$barchart->barwidth = 6;
				$barchart->palette = CHART_PALETTE;
				
				foreach ($barchart->x_labels as $hour) {
				
					$from = sprintf(date("Y-m-d")." %02d:00:00",$hour);
					$to = sprintf(date("Y-m-d")." %02d:59:59",$hour);
					
					$sql = "SELECT COALESCE(SUM(duration),0) FROM ".DB_TABLE." WHERE calldate >= '{$from}' AND calldate <= '{$to}'";
					$minutes = round($this->db->getOne($sql)/60);
					
					$barchart->values[] = $minutes;
				
				}

				$this->template->chart = $barchart->saveFile(CHART_CACHE);
				
				break;
				
			case "summary_week":
				
				// summary for the current week
				
				if (date("l") == "Monday") {
					$mm = strtotime("today");
				} else {
					$mm = strtotime("last Monday");
				}
				
				$barchart = new BarChart("W/B ".date("l jS F Y",$mm)." (minutes)");
				$barchart->dimensions = "300x265";
				$barchart->x_labels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
				$barchart->margins = array(25,5,5,5);
				$barchart->barwidth = 25;
				$barchart->palette = CHART_PALETTE;
				
				for ($i=0; $i<=6; $i++) {
					
					$ts = $mm + (86400*$i);
					$from = sprintf(date("Y-m-d",$ts)." 00:00:00");
					$to = sprintf(date("Y-m-d",$ts)." 23:59:59");

					$sql = "SELECT COALESCE(SUM(duration),0) FROM ".DB_TABLE." WHERE calldate >= '{$from}' AND calldate <= '{$to}'";
					$minutes = round($this->db->getOne($sql)/60);
					$barchart->values[] = $minutes;
				
				}

				$this->template->chart = $barchart->saveFile(CHART_CACHE);
				
				break;
				
			case "top_src":
				
				// most popular sources
				
				$popular = $this->db->GetAssoc("
					SELECT src, COUNT(*) AS count
					FROM ".DB_TABLE."
					WHERE src IS NOT NULL AND src != ''
					GROUP BY src
					ORDER BY count DESC LIMIT 13;
				");
				$this->template->numbers = $popular;
				
				break;
				
			case "top_dst":
				
				// most popular destinations

				$popular = $this->db->GetAssoc("
					SELECT dst, COUNT(*) AS count
					FROM ".DB_TABLE."
					WHERE dst IS NOT NULL AND dst != ''
					GROUP BY dst
					ORDER BY count DESC LIMIT 13;
				");
				$this->template->numbers = $popular;
				
				break;
				
			case "top_clid":
				
				// most popular caller IDs

				$popular = $this->db->GetAssoc("
					SELECT clid, COUNT(*) AS count
					FROM ".DB_TABLE."
					WHERE clid IS NOT NULL AND clid != ''
					GROUP BY clid
					ORDER BY count DESC LIMIT 13;
				");
				$this->template->numbers = $popular;
				
				break;
			
		}
		
		// render box template
		$this->template->show("box_".$this->get["box"]);
		
	}

}

?>