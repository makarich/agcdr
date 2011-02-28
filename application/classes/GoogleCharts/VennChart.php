<?php

/**
 * Google Venn Chart class. Also known as a Venn Diagram.
 * 
 * See the abstract class GoogleChart.php for further information.
 * 
 * @package	GoogleChart
 * @author	Stuart Benjamin Ford <stuartford@me.com>
 * @copyright	23/02/2011
 */

/**
 * VennChart.
 */
class VennChart extends GoogleChart {
	
	/**
	 * Set Google chart type.
	 * 
	 * @var string
	 * @access protected
	 */
	protected $type = "v";
		
	/**
	 * Venn values.
	 * 
	 * As per the Google documentation for Venn charts, these values should
	 * be ordered as follows:
	 * 
	 * For two-circle venns (e.g. 100,100,0,50):
	 * Circle A size, circle B size, 0, A/B intersection size
	 * 
	 * For three-circle venns (e.g. 100,80,60,30,30,30,10):
	 * Circle A size, circle B size, circle C size, A/B intersection size,
	 * A/C intersection size, B/C intersection size, A/B/C intersection size
	 * 
	 * @var array
	 * @access public
	 */
	public $values;
	
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
	
		// check that the values property is valid
		if (count($this->values) != 4 && count($this->values) != 7) {
			throw new Exception("Venn chart values property has incorrect number of elements.");	
		}
		if (count($this->values) == 4 && $this->values[2] != 0) {
			throw new Exception("Two-circle venn chart values property must have '0' as third element.");	
		}
		
		// create options array
		$options = array(
			"chd"		=> "t:".implode(",",$this->values)
		);

		// call parent
		return parent::getURL($options);
		
	}
	
}

?>