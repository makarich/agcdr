<?php

/**
 * Google Radar Chart class.
 * 
 * See the abstract class GoogleChart.php for further information.
 * 
 * @package	GoogleChart
 * @author	Stuart Benjamin Ford <stuartford@me.com>
 * @copyright	25/02/2011
 */

/**
 * RadarChart.
 */
class RadarChart extends GoogleChart {
	
	/**
	 * Set Google chart type.
	 * 
	 * @var string
	 * @access protected
	 */
	protected $type = "r";
		
	/**
	 * Line values.
	 * 
	 * Each element of the array is another array containing the series
	 * values, with one sub-array per series.
	 * 
	 * @var array
	 * @access public
	 */
	public $values;
	
	/**
	 * Data points.
	 * 
	 * @var array
	 * @access public
	 */
	public $points;
	
	/**
	 * Enable Y axis (show concentric circles).
	 * 
	 * @var boolean
	 * @access public
	 */
	public $y_axis = false;
	
	/**
	 * Enable grid lines.
	 * 
	 * Density of grid is based on the "density" of the chart data.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $grid = false;
	
	/**
	 * Enable fill of area beneath the lines.
	 * 
	 * This will disable colour randomisation if set. May not work correctly
	 * on charts with more than one series.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $fill = false;
	
	/**
	 * Use curves instead of straight lines.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $curves = false;
	
	/**
	 * Enable point markers.
	 * 
	 * Different shapes will be used for each series.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $markers = false;
	
	/**
	 * Construct via parent, adding chart title if passed.
	 * 
	 * @param string $title		- chart title
	 * 
	 * @access public
	 */
	public function __construct($title=false) {
		parent::__construct($title);
	}
	
	/**
	 * Prepare chart-specific options and generate URL via parent.
	 * 
	 * @return string		- fully qualified Google Charts URL
	 * @access public
	 */
	public function getURL() {

		// change the chart type if curves are switched on
		if ($this->curves) $this->type = "rs";
		
		// create options array
		$options = array();
		
		// add x-axis points and labels
		if (is_array($this->points)) {
			$options["chxt"] = "x";
			$options["chxl"] = "0:|".implode("|",$this->points);	
		}
		
		// add y-axis?
		if ($this->y_axis) {
			if ($options["chxt"] == "x") { 
				$options["chxt"] = "x,y";
			} else {
				$options["chxt"] = "y";
			}
		}
		
		// add series
		$options["chd"] = "t:";
		foreach ($this->values as $series) {
			$options["chd"] .= implode(",",$series);
			$options["chd"] .= "|";
		}
		$options["chd"] = rtrim($options["chd"],"|");
		
		// add grid?
		if ($this->grid) {
			$options["chg"] = round(100/count($this->points)).",".round(100/count($this->points));
		}
		
		// add fill?
		if ($this->fill) {
			$chm = array();
			foreach ($this->values as $id => $series) $chm[] = "B,{$this->colour_palettes[$this->palette][$id]},0,0,0";
			$options["chm"] = implode("|",$chm);
			$this->randomise_colours = false;
		}
		
		// add point markers?
		if ($this->markers) {
			
			$shapes = array("o","s","d");
			$s = 0;
			
			for ($i=0; $i<count($this->values); $i++) {
				$tmp[] = "{$shapes[$s]},404040,{$i},-1,5";
				$s++;
				if ($s >= count($shapes)) $s = 0;
			}
			
			$options["chm"] = implode("|",$tmp);
			
		}		
		
		// call parent
		return parent::getURL($options);
		
	}
	
}

?>