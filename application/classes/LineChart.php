<?php

/**
 * Google Line Chart class.
 * 
 * See the abstract class GoogleChart.php for further information.
 * 
 * @package	GoogleChart
 * @author	Stuart Benjamin Ford <stuartford@me.com>
 * @copyright	25/02/2011
 */

/**
 * LineChart.
 */
class LineChart extends GoogleChart {
	
	/**
	 * Set Google chart type.
	 * 
	 * @var string
	 * @access protected
	 */
	protected $type = "lc";
	
	/**
	 * X-axis labels.
	 * 
	 * @var array
	 * @access public
	 */
	public $x_labels;
	
	/**
	 * Y-axis labels.
	 * 
	 * @var array
	 * @access public
	 */
	public $y_labels;
	
	/**
	 * Line values (in same order as x-axis labels).
	 * 
	 * Support multiple series. Each element of the array is another array
	 * containing the series values, with one sub-array per series.
	 * 
	 * @var array
	 * @access public
	 */
	public $values;
	
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
	 * Enable point markers.
	 * 
	 * Different shapes will be used for each series.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $markers = false;
	
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

		// determine minimum and maximum from series arrays
		$maximum = 0;
		$minimum = 0;
		foreach ($this->values as $series) {
			foreach ($series as $value) {
				if ($value > $maximum) $maximum = $value;
				if ($value < $minimum) $minimum = $value;
			}
		}
		
		// if there are no Y labels then make them from the values
		if (!isset($this->y_labels)) {
			
			foreach ($this->values as $series) {
				foreach ($series as $value) $this->y_labels[] = $value;
			}
			
			$this->y_labels = array_unique($this->y_labels);
			$this->y_labels[] = $minimum;
			sort($this->y_labels);
			
		}
		
		// create options array
		$options = array(
			"chxl"		=> "0:|".implode("|",$this->x_labels)."|1:|".implode("|",$this->y_labels),
			"chxt"		=> "x,y",
			"chds"		=> "{$minimum},{$maximum}"
		);
		
		// add series
		$options["chd"] = "t:";
		foreach ($this->values as $series) {
			$options["chd"] .= implode(",",$series);
			$options["chd"] .= "|";
		}
		$options["chd"] = rtrim($options["chd"],"|");

		// add grid?
		if ($this->grid) {
			$options["chg"] = round(100/count($this->x_labels)).",".round(100/count($this->y_labels));
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