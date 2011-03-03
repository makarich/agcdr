<?php

/**
 * Google Charts API class.
 * 
 * This is an abstract class which provides common properties and methods to
 * the classes inside the "GoogleCharts" directory. A combined file containing
 * this class and all the sub-classes can be found in the root of this project.
 * 
 * Please see the documentation under "docs" for project information an usage
 * documentation, specifically "readme.html", "examples.html" and the main
 * class documentation "phpdoc/index.html".
 * 
 * @package	GoogleChart
 * @version	0.990 (beta)
 * @author	Stuart Benjamin Ford <stuartford@me.com>
 * @copyright	03/03/2011
 */

/**
 * GoogleChart.
 */
abstract class GoogleChart {
		
	/**
	 * Chart type.
	 * 
	 * @var string
	 * @access protected
	 */
	protected $type;
	
	/**
	 * Chart title.
	 * 
	 * @var string
	 * @access public
	 */
	public $title;
	
	/**
	 * Chart title style.
	 * 
	 * String, RGB colour and font size, separated by comma.
	 * Default: Black, 10pt.
	 * 
	 * @var string
	 * @access public
	 */
	public $title_style = "000000,12";
	
	/**
	 * Chart margins.
	 * 
	 * Array (in pixels) left, right, top, bottom
	 * 
	 * @var array
	 * @access public
	 */
	public $margins = array(25,25,25,25);
	
	/**
	 * Chart dimensions (WxH).
	 * 
	 * @var string
	 * @access public
	 */
	public $dimensions = "500x300";
	
	/**
	 * Chart legend.
	 * 
	 * @var array
	 * @access public
	 */
	public $legend;
	
	/**
	 * Colour palette to use.
	 * 
	 * Either use a named palette or provide a list of comma separated
	 * hex RGB values (without leading #) to specify a custom palette.
	 * 
	 * With pie and meter type charts you can specify just two colours and
	 * a range of colours will be automatically created for all the segments
	 * required.
	 * 
	 * Define named colour palettes in the $palettes property.
	 * 
	 * @var array
	 * @access public
	 */
	public $palette = "primary";
	
	/**
	 * Define colour palettes.
	 * 
	 * Each element of the array is another array, containing a set of hex
	 * RGB values (without leading #). Specify which palette to use in the
	 * $colours property.
	 * 
	 * @var array
	 * @access public
	 */
	public $colour_palettes = array(
		"primary" => array(
			"FEFE83",
			"FB9902",
			"FE2712",
			"8601AF",
			"0247FE",
			"66B032"
		),
		"meter" => array(
			"00EE00",
			"EEEE00",
			"EE0000"
		),
		"pastel" => array(
			"B3C6FF",
			"C6B3FF",
			"ECB3FF",
			"FFB3EC",
			"FFB3C6",
			"FFC6B3",
			"FFECB3",
			"ECFFB3",
			"C6FFB3",
			"B3FFC6",
			"B3FFEC",
			"B3ECFF",
			"7598FF",
			"386AFF",
			"FFDD75",
			"FFCD38"
		)
	);
	
	/**
	 * Randomise the order of the colours on each generation.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $randomise_colours = false;
	
	/**
	 * Reverse the order of the colours.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $reverse_colours = false;
	
	/**
	 * Google Chart API URL.
	 * 
	 * @var string
	 * @access private
	 */
	private $apiurl = "https://chart.googleapis.com/chart";
	
	/**
	 * Construct using optional initial parameters.
	 * 
	 * @param string $title		- chart title
	 * 
	 * @access public
	 */
	public function __construct($title=false) {
		if ($title) $this->title = $title;
	}

	/**
	 * Generate a Google Chart API URL to render a chart.
	 * 
	 * @param array $options	- (optional) associative array of chart-specific options
	 * 
	 * @return string		- fully qualified Google Charts URL
	 * @access public
	 */
	public function getURL($options=false) {

		// do some basic sanity checks
		if (empty($this->type)) {
			throw new Exception("No chart type set in \$type property.");	
		}
		
		// start URL with chart type
		$url = "{$this->apiurl}?cht={$this->type}&";
		
		// add title
		$url .= "chtt=".urlencode($this->title)."&chts={$this->title_style}&";
		
		// add dimensions and margins
		$url .= "chs={$this->dimensions}&";
		$url .= "chma=".implode(",",$this->margins)."&";
		
		// prepare colour palette
		if (preg_match("/,/",$this->palette)) {
			$palette = explode(",",$this->palette);
		} else {
			$palette = $this->colour_palettes[$this->palette];
		}
		
		// randomise or reverse colours if requested
		if ($this->randomise_colours) {
			shuffle($palette);
		} else if ($this->reverse_colours) {
			$palette = array_reverse($palette);
		}
		
		// add colours (most chart types use commas to separate, but some use pipes (see array))
		if (in_array($this->type,array("bvs","bhs","s"))) {
			$url .= "chco=".implode("|",$palette)."&";
		} else {
			$url .= "chco=".implode(",",$palette)."&";
		}
		
		// add legend
		if (is_array($this->legend)) $url .= "chdl=".urlencode(implode("|",$this->legend))."&";
		
		// add chart specific options
		if ($options) {
			foreach ($options as $key => $value) {
				$url .= "{$key}={$value}&";
			}
		}
		
		// return completed URL
		return $url;
		
	}
	
	/**
	 * Retrieve chart image data from Google Chart API.
	 * 
	 * @return string		- PNG data
	 * @access public
	 */
	public function getImageData() {
		
		// generate URL
		$url = $this->getURL();
		
		// set up CURL process
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

		// submit to Google and retrieve buffer
		$buffer = curl_exec($curl);
		curl_close($curl);
	
		// return image data
		return $buffer;
		
	}
	
	/**
	 * Create inline image data for embedding in IMG tags.
	 * 
	 * @return string		- inline image data
	 * @access public
	 */
	public function getInlineImage() {
		
		// retrieve image data
		if (!$image = $this->getImageData()) return false;
		
		// convert image data to base64 and format for inserting in IMG tag
		$imgb64 = base64_encode($image);
		$src = "data:image/png;base64,{$imgb64}";
		
		// return IMG src
		return $src;
		
	}

	/**
	 * Generate an MD5 hash with which the chart can be uniquely identified.
	 * 
	 * This is useful, for example, if you would like to save the generated
	 * chart image and cache it in order that it doesn't need to be
	 * generated each time it is viewed.
	 * 
	 * @return string		- 32 character MD5
	 * @access public
	 */
	public function makeHash() {
		return md5($this->getURL());
	}
	
	/**
	 * Generate chart image data and save to a given directory.
	 * 
	 * Charts will be named <md5 hash>.png within the directory.
	 * 
	 * @param string $dir		- path to directory
	 * 
	 * @return string		- image filename
	 * @access public
	 */
	public function saveFile($dir) {
		
		// generate image data
		$image = $this->getImageData();
		
		// generate filename
		$filename = $this->makeHash().".png";
		
		// save file
		file_put_contents("{$dir}/{$filename}",$image);
		
		// return filename
		return $filename;
		
	}
	
}

?>