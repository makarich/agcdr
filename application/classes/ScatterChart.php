<?php

/**
 * Google Scatter Chart class.
 * 
 * See the abstract class GoogleChart.php for further information.
 * 
 * @package	GoogleChart
 * @author	Stuart Benjamin Ford <stuartford@me.com>
 * @copyright	23/02/2011
 */

/**
 * ScatterChart.
 */
class ScatterChart extends GoogleChart {
	
	/**
	 * Set Google chart type.
	 * 
	 * @var string
	 * @access protected
	 */
	protected $type = "s";

	/**
	 * Scatter chart data.
	 * 
	 * Do not manipulate directly, use the add_point() method to add points.
	 * 
	 * @var array
	 * @access public
	 */
	private $data;
	
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
	 * Enable grid lines.
	 * 
	 * Density of grid is based on the "density" of the chart data.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $grid = false;
	
	/**
	 * Use a single colour for all the points.
	 * 
	 * Either pass a hex RGB reference (without leading #) or simply set to
	 * true to use the first colour from the chosen palette.
	 * 
	 * @var mixed
	 * @access public
	 */
	public $single_colour = true;
	
	/**
	 * Construct via parent, adding chart title if passed.
	 * 
	 * Also create data array structure.
	 * 
	 * @param string $title		- chart title
	 * 
	 * @access public
	 */
	public function __construct($title=false) {
		
		parent::__construct($title);
		
		$this->data = array(
			"x"	=> array(),
			"y"	=> array(),
			"size"	=> array()
		);
		
	}
	
	/**
	 * Prepare chart-specific options and generate URL via parent.
	 * 
	 * @return string		- fully qualified Google Charts URL
	 * @access public
	 */
	public function getURL() {

		// this chart type is pretty dependent on having some data present to do much at all
		if (count($this->data) == 0) throw new Exception("No data present for scatter chart.");
		
		// if either axis labels are absent then automatically generate them from the data
		if (!isset($this->x_labels)) $this->x_labels = $this->generate_axis_labels("x");
		if (!isset($this->y_labels)) $this->y_labels = $this->generate_axis_labels("y");

		// create options array
		$options = array(
			"chxt"		=> "x,y",
			"chxl"		=> "0:|".implode("|",$this->x_labels)."|1:|".implode("|",$this->y_labels)
		);		

		// add grid?
		if ($this->grid) {
			$options["chg"] = round(100/count($this->x_labels)).",".round(100/count($this->y_labels));
		}
		
		// add chart data
		$options["chd"] = "t:".implode(",",$this->data["x"])."|".implode(",",$this->data["y"])."|".implode(",",$this->data["size"]);
		
		// use single colour?
		if ($this->single_colour) {
			if (preg_match("/[A-Fa-z0-9][A-Fa-z0-9][A-Fa-z0-9][A-Fa-z0-9][A-Fa-z0-9][A-Fa-z0-9]/",$this->single_colour)) {
				$this->palette = "{$this->single_colour},{$this->single_colour}";
			} else {
				$colour = $this->colour_palettes[$this->palette][0];
				$this->palette = "{$colour},{$colour}";
			}
		}
		
		// call parent
		return parent::getURL($options);
		
	}
	
	/**
	 * Add a scatter point to the chart.
	 * 
	 * @param float $x		- X coordinate
	 * @param float $y		- Y coordinate
	 * @param float $size		- (optional) point size (default 50)
	 * 
	 * @return void
	 * @access public
	 */
	public function add_point($x,$y,$size=50) {

		array_push($this->data["x"],$x);
		array_push($this->data["y"],$y);
		array_push($this->data["size"],$size);
		
	}
	
	/**
	 * Generate set of axis labels from chart data.
	 * 
	 * @param string $axis		- x or y
	 * 
	 * @return array		- generated labels
	 * @access private
	 */
	private function generate_axis_labels($axis) {
		
		$labels = array(0);
		foreach ($this->data[$axis] as $point) $labels[] = $point;
		$labels = array_unique($labels);
		sort($labels);
		
		return $labels;
		
	}
	
}

?>