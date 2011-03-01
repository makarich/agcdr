<?php

/**
 * Google Pie Chart class.
 * 
 * See the abstract class GoogleChart.php for further information.
 * 
 * @package	GoogleChart
 * @author	Stuart Benjamin Ford <stuartford@me.com>
 * @copyright	21/02/2011
 */

/**
 * PieChart.
 */
class PieChart extends GoogleChart {
	
	/**
	 * Set Google chart type.
	 * 
	 * @var string
	 * @access protected
	 */
	protected $type = "p";
	
	/**
	 * Pie chart segments.
	 * 
	 * Associative array with labels as keys and percentage values.
	 * 
	 * @var array
	 * @access public
	 */
	public $segments;
	
	/**
	 * Rotation (radians).
	 * 
	 * @var float
	 * @access public
	 */
	public $rotation = 0;
	
	/**
	 * Use perspective (3D mode).
	 * 
	 * @var boolean
	 * @access public
	 */
	public $perspective = false;

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
		
		// change the chart type if perspective is switched on
		if ($this->perspective) $this->type = "p3";
		
		// create options array
		$options = array(
			"chl"		=> implode("|",array_keys($this->segments)),
			"chd"		=> "t:".implode(",",array_values($this->segments)),
			"chp"		=> $this->rotation
		);
		
		// call parent
		return parent::getURL($options);
		
	}
	
}

?>