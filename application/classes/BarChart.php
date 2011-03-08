<?php

/**
 * Google Bar Chart class.
 * 
 * See the abstract class GoogleChart.php for further information.
 * 
 * @package	GoogleChart
 * @author	Stuart Benjamin Ford <stuartford@me.com>
 * @copyright	08/03/2011
 */

/**
 * BarChart.
 */
class BarChart extends GoogleChart {
	
	/**
	 * Set Google chart type.
	 * 
	 * @var string
	 * @access protected
	 */
	protected $type = "bvs";
	
	/**
	 * Horizontal mode.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $horizontal = false;
	
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
	 * Generated automatically from the values if not specified directly.
	 * 
	 * @var array
	 * @access public
	 */
	public $y_labels;
	
	/**
	 * Bar values (in same order as x-axis labels).
	 * 
	 * Supports only a single series (in contrast to the equivalent
	 * property in LineChart).
	 * 
	 * @var array
	 * @access public
	 */
	public $values;
	
	/**
	 * Bar width (pixels).
	 * 
	 * @var integer
	 * @access public
	 */
	public $barwidth = 23;
	
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

		// change the chart type if horizontal is switched on
		if ($this->horizontal) $this->type = "bhs";
		
		// set scale minimum
		if (min($this->values) < 0) {
			$minimum = min($this->values);
		} else {
			$minimum = 0;
		}
		
		// if there are no Y labels then make them from the values
		if (!isset($this->y_labels)) {
			
			$this->y_labels = array($minimum,max($this->values));
			
			$step = ($this->y_labels[1] - $this->y_labels[0])/8;
			for ($i=($this->y_labels[0]+$step); $i<$this->y_labels[1]; $i=$i+$step) {
				$this->y_labels[] = round($i);
			}
			
			//$this->y_labels = array_unique($this->values);
			//if (!in_array($minimum,$this->y_labels)) $this->y_labels[] = $minimum;
			
			sort($this->y_labels);
			
		}
		
		// create options array
		$options = array(
			"chxt"		=> "x,y",
			"chbh"		=> $this->barwidth,
			"chd"		=> "t:".implode(",",$this->values),
			"chds"		=> "{$minimum},".max($this->values)
		);
		
		// add data
		switch ($this->type) {
			case "bvs":
				$options["chxl"] = "0:|".implode("|",$this->x_labels)."|1:|".implode("|",$this->y_labels);
				break;
			case "bhs":
				$options["chxl"] = "0:|".implode("|",$this->y_labels)."|1:|".implode("|",$this->x_labels);
				break;
		}

		// call parent
		return parent::getURL($options);
		
	}
	
}

?>