<?php

/**
 * Google Meter Chart class. Also known as a Google-O-Meter.
 * 
 * See the abstract class GoogleChart.php for further information.
 * 
 * @package	GoogleChart
 * @author	Stuart Benjamin Ford <stuartford@me.com>
 * @copyright	23/02/2011
 */

/**
 * MeterChart.
 */
class MeterChart extends GoogleChart {
	
	/**
	 * Set Google chart type.
	 * 
	 * @var string
	 * @access protected
	 */
	protected $type = "gom";
	
	/**
	 * Meter value (0 to 100).
	 * 
	 * Values lower or higher than 0 or 100 will be rounded up or down
	 * to 0 or 100 as appropriate.
	 * 
	 * @var integer
	 * @access public
	 */
	public $value;
	
	/**
	 * Label for arrow.
	 * 
	 * @var string
	 * @access public
	 */
	public $arrow_label;
	
	/**
	 * Labels for meter.
	 * 
	 * @var array
	 * @access public
	 */
	public $meter_labels;
	
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
	
		// if label arrow is missing then set it to the value
		if (empty($this->arrow_label)) $this->arrow_label = $this->value;
		
		// create options array
		$options = array(
			"chd"		=> "t:{$this->value}",
			"chxt"		=> "x,y",
			"chxl"		=> "0:|{$this->arrow_label}|1:|".implode("|",$this->meter_labels)
		);
		
		// call parent
		return parent::getURL($options);
		
	}
	
}

?>