<?php

/**
 * Wizard-style form builder system.
 * 
 * Requires jQuery and jQuery-UI libraries to be installed if non-standard form
 * elements such as date pickers, auto-complete options, number ranges, sliders,
 * multi-select menus or button sets are to be used. See PhpDoc for requirements.
 * 
 * This system is designed in order that you can process the objects it generates
 * generates in any way you want in order to suit your application. All form
 * element objects have HTML generated but also include the original parameters
 * from which the HTML was generated if you wish to use them directly.
 * 
 * An example of how a FormWizard object can be used is provided in a Smarty
 * include, "formwizard.tpl". It should be relatively straightforward to implement
 * similar templates in other templating systems, or if you don't want to use
 * a templating system you can just use the generated HTML directly in PHP scripts.
 * 
 * @package		SBF-Classlib
 * @author		Stuart Benjamin Ford <stuartford@me.com>
 * @copyright		24/03/2011
 */

/**
 * Wizard form object.
 */
class FormWizard {
	
	/**
	 * Title of wizard step.
	 * 
	 * @var string
	 * @access public
	 */
	public $title;
	
	/**
	 * Wizard step form items.
	 * 
	 * @var array
	 * @access public
	 */
	public $items;
	
	/**
	 * Label for "back" button.
	 * 
	 * @var string
	 * @access public
	 */
	public $back_label = "Back";
	
	/**
	 * Name of icon file for "back" button.
	 * 
	 * @var string
	 * @access public
	 */
	public $back_icon = false;
	
	/**
	 * Action for "back" button. This is required for the back button to be rendered.
	 * 
	 * @var string
	 * @access public
	 */
	public $back_action;
	
	/**
	 * Label for "next" (submit) button.
	 * 
	 * @var string
	 * @access public
	 */
	public $next = "Next";
	
	/**
	 * Set to true to disable the Next button.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $next_disabled = false;
	
	/**
	 * Text for pop-up help text (accessible from an icon on the title bar if set).
	 * 
	 * @var string
	 * @access public
	 */
	public $helptext;
	
	/**
	 * Name of icon file for "next" (submit) button.
	 * 
	 * @var string
	 * @access public
	 */
	public $next_icon = false;
	
	/**
	 * Container for jQuery script.
	 * 
	 * @var array
	 * @access public
	 */
	public $jquery;
	
	/**
	 * Construct.
	 * 
	 * Form objects can be constructed using an existing set of items if passed, otherwise they are created with an empty items array.
	 * 
	 * @param string $title		- wizard form title
	 * @param array $items		- (optional) array of existing form item objects (default false)
	 * 
	 * @access public
	 */
	public function __construct($title,$items=false) {
		
		// set title
		$this->title = $title;
		
		// create items array
		if ($items) {
			$this->items = $items;
		} else {
			$this->items = array();
		}
		
		// create jQuery script array
		$this->jquery = array();
		
	}
	
	/**
	 * Generic setter method.
	 * 
	 * @param mixed $key		- property name
	 * @param mixed $var		- property value
	 * 
	 * @return void
	 * @access public
	 */
	public function __set($key,$var) {
		$this->$key = $var;
	}

	/**
	 * Generic getter method.
	 * 
	 * @param mixed $key		- property name
	 * 
	 * @return mixed		- property value
	 * @access public
	 */
	public function __get($key) {
		
		if (property_exists($this,$key)) {
			return $this->$key;
		} else {
			 throw new Exception("Attempt to get a non-existant property: {$key}");
		}
		
	}
	
}

/**
 * Abstract wizard form item object.
 */
abstract class WizardFormItem {
	
	/**
	 * Form item type. This is set by the instance classes.
	 * 
	 * @var string
	 * @access public
	 */
	public $type;
	
	/**
	 * "name" attribute.
	 * 
	 * @var string
	 * @access public
	 */
	public $name;
	
	/**
	 * "id" attribute
	 * 
	 * @var string
	 * @access public
	 */
	public $id;
	
	/**
	 * Form item label.
	 * 
	 * @var string
	 * @access public
	 */
	public $label;
	
	/**
	 * Set to true to mark the field as required.
	 * 
	 * Please note that this class does not produce form validation code, this you must
	 * add yourself according to your particular requirements. This is a marker only.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $required = false;
	
	/**
	 * Form element prefix text.
	 * 
	 * @var string
	 * @access public
	 */
	public $prefix;
	
	/**
	 * Form element suffix text.
	 * 
	 * @var string
	 * @access public
	 */
	public $suffix;
	
	/**
	 * CSS class name to apply to element.
	 * 
	 * @var string
	 * @access public
	 */
	public $cssclass;
	
	/**
	 * Tool-tip text to show when the element is hovered-over (whichever is appropriate).
	 * 
	 * Whichever rendering method used will need to implement the Javascript functions
	 * openToolTip() and closeToolTip accordingly - see formwizard.tpl for an example.
	 * 
	 * @var string
	 * @access public
	 */
	public $tooltip;
	
	/**
	 * Set to true to make element use the full width of its container (if it can, does not apply to all types).
	 * 
	 * @var boolean
	 * @access public
	 */
	public $fullwidth = false;
	
	/**
	 * "onclick" action attribute.
	 * 
	 * This does not apply to radio groups, date pickers, fixed fields or menus when in multi-select mode.
	 * 
	 * @var string
	 * @access public
	 */
	public $onclick;
	
	/**
	 * Container for rendered HTML.
	 * 
	 * @var string
	 * @access public
	 */
	public $html;
	
	/**
	 * Container for base64-encoded rendered HTML.
	 * 
	 * This is used in order that the HTML can be passed as an argument to a
	 * Javascript function if required by the page rendering engine.
	 * 
	 * @var string
	 * @access public
	 */
	public $html_base64;
	
	/**
	 * Container for rendered fallback HTML.
	 * 
	 * This may be used by some classes to generate alternative HTML for browsers
	 * which do not yet support the HTML generated by its main generation function,
	 * for example HTML5 elements, in order that they may gracefully degrade.
	 * 
	 * @var string
	 * @access public
	 */
	public $fallback_html;
	
	/**
	 * Container for base64-encoded rendered fallback HTML.
	 * 
	 * This is used in order that the fallback HTML can be passed as an argument
	 * to a Javascript function if required by the page rendering engine.
	 * 
	 * @var string
	 * @access public
	 */
	public $fallback_html_base64;
	
	/**
	 * jQuery initialisation code.
	 * 
	 * @var array
	 * @access public
	 */
	public $jquery;
	
	/**
	 * Construct.
	 * 
	 * Objects are constructed with given names and IDs if passed, but they can
	 * also be set manually. If a name is passed without an ID, the name is also
	 * used for the item's ID.
	 * 
	 * @param string $name		- form element name
	 * @param string $id		- form element ID
	 * 
	 * @access public
	 */
	public function __construct($name=false,$id=false) {
		
		if ($name) $this->name = $name;
		
		if ($id) {
			$this->id = $id;
		} elseif ($name) {
			$this->id = $name;
		}
		
		$this->jquery = array();
		
	}
	
	/**
	 * Generic setter method.
	 * 
	 * @param mixed $key
	 * @param mixed $var
	 * 
	 * @return void
	 * @access public
	 */
	public function __set($key,$var) {
		$this->$key = $var;
	}

	/**
	 * Generic getter method.
	 * 
	 * @param mixed $key
	 * 
	 * @return mixed		- value of key
	 * @access public
	 */
	public function __get($key) {
		
		if (property_exists($this,$key)) {
			return $this->$key;
		} else {
			 throw new Exception("Attempt to get a non-existant property: {$key}");
		}
		
	}
	
	/**
	 * Add item to a wizard.
	 * 
	 * @param object $wizard	- FormWizard object
	 * 
	 * @return void
	 * @access public
	 */
	public function add_to($wizard) {
		
		// generate HTML from properties
		$this->__set("html",$this->generate_html());
		$this->__set("html_base64",base64_encode($this->html));
		
		// generate fallback HTML if method exists
		if (method_exists($this,"generate_fallback_html")) {
			$this->__set("fallback_html",$this->generate_fallback_html());
			$this->__set("fallback_html_base64",base64_encode($this->fallback_html));
		}
		
		// add to wizard
		array_push($wizard->items,$this);
		
		// add any jQuery code to the wizard
		if (count($this->jquery) > 0) {
			foreach ($this->jquery as $statement) {
				array_push($wizard->jquery,$statement);
			}
		}

	}
	
}

/**
 * Error message object.
 * 
 * Not actually a form item but behaves like one as far as the wizard is concerned.
 */
class WizardErrorMessage extends WizardFormItem {
	
	/**
	 * Error message text
	 * 
	 * @var string
	 * @access public
	 */
	public $message;
	
	/**
	 * Error message severity, either "info", "notice", "warning" or "error"
	 * 
	 * @var string
	 * @access public
	 */
	public $severity;
	
	/**
	 * This object has a separate construct and does not construct via parent since it's not a real form object.
	 * 
	 * @param string $message		- (optional) message text
	 * @param string $severity		- (optional) message severity, either "info", "notice", "warning" or "error"
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct($message=false,$severity="error") {
		
		// check and set severity
		if (in_array($severity,array("info","notice","warning","error"))) {
			$this->severity = $severity;
		} else {
			throw new Exception("Invalid error message severity: {$severity}");	
		}
		
		// set message if passed
		if ($message) $this->message = $message;
	
	}
	
	/**
	 * Create error message HTML.
	 * 
	 * @return string		- HTML markup
	 * @access public
	 */
	public function generate_html() {
		
		$html = "<div class=\"formwizard_message_{$this->severity}\">";
		$html .= "<div class=\"em_severity\">".ucfirst($this->severity)."</div>";
		$html .= "<div class=\"em_message\">{$this->message}</div>";
		$html .= "</div>";
		
		return $html;
		
	}
	
}

/**
 * Text box form item object.
 */
class WizardTextbox extends WizardFormItem {
	
	/**
	 * Text box value.
	 * 
	 * @var string
	 * @access public
	 */
	public $value;
	
	/**
	 * Placeholder text (supports HTML5 browsers only).
	 * 
	 * If not set and $tooltip is set then the tooltip text is used in the placeholder.
	 * 
	 * @var string
	 * @access public
	 */
	public $placeholder;
	
	/**
	 * Size of text box.
	 * 
	 * @var integer
	 * @access public
	 */
	public $size = 20;
	
	/**
	 * List of auto-complete items.
	 * 
	 * @var array
	 * @access public
	 */
	public $autocomplete;
	
	/**
	 * "onkeyup" action attribute.
	 *
	 * @var string
	 * @access public
	 */
	public $onkeyup;
	
	/**
	 * Construct via parent and add form element type.
	 * 
	 * @access public
	 */
	public function __construct($name=false,$id=false) {
		parent::__construct($name,$id);
		$this->type = "text";	
	}
	
	/**
	 * Create text box HTML and jQuery.
	 * 
	 * @return string		- HTML markup
	 * @access public
	 */
	public function generate_html() {
		
		// construct text input element
		$html = "<input type=\"text\" name=\"{$this->name}\" id=\"{$this->id}\" size=\"{$this->size}\"";
		if (isset($this->value)) $html .= " value=\"{$this->value}\"";
		if (!isset($this->placeholder) && isset($this->tooltip)) $this->placeholder = $this->tooltip;
		if (isset($this->placeholder)) $html .= " placeholder=\"{$this->placeholder}\"";
		if (isset($this->cssclass)) $html .= " class=\"{$this->cssclass}\"";
		if (isset($this->onclick)) $html .= " onclick=\"{$this->onclick}\"";
		if (isset($this->onkeyup)) $html .= " onkeyup=\"{$this->onkeyup}\"";
		if (isset($this->tooltip)) $html .= " onmouseover=\"openToolTip('{$this->tooltip}');\" onmouseout=\"closeToolTip();\"";
		if ($this->fullwidth) $html .= " style=\"width: 99%;\"";
		$html .= " />";
		
		// construct jQuery if auto-complete is needed
		if (isset($this->autocomplete)) {
			$this->jquery[] = "var {$this->name}AutoComplete = [\"".implode("\",\"",$this->autocomplete)."\"];";
			$this->jquery[] = "\$(\"#{$this->id}\").autocomplete({ source: {$this->name}AutoComplete });";
		}

		return $html;
		
	}
	
}


/**
 * Text area form item object.
 */
class WizardTextarea extends WizardFormItem {
	
	/**
	 * Text area contents.
	 * 
	 * @var string
	 * @access public
	 */
	public $contents;
	
	/**
	 * Placeholder text (supports HTML5 browsers only).
	 * 
	 * If not set and $tooltip is set then the tooltip text is used in the placeholder.
	 * 
	 * @var string
	 * @access public
	 */
	public $placeholder;
	
	/**
	 * Number of rows.
	 * 
	 * @var integer
	 * @access public
	 */
	public $rows = 5;
	
	/**
	 * Number of columns.
	 * 
	 * @var integer
	 * @access public
	 */
	public $columns = 40;
	
	/**
	 * Construct via parent and add form element type.
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct($name=false,$id=false) {
		parent::__construct($name,$id);
		$this->type = "textarea";	
	}
	
	/**
	 * Create text area HTML.
	 * 
	 * @return string		- HTML markup
	 * @access public
	 */
	public function generate_html() {

		$html = "<textarea name=\"{$this->name}\" id=\"{$this->id}\" rows=\"{$this->rows}\" cols=\"{$this->columns}\"";
		if (isset($this->cssclass)) $html .= " class=\"{$this->cssclass}\"";
		if (isset($this->onclick)) $html .= " onclick=\"{$this->onclick}\"";
		if ($this->fullwidth) $html .= " style=\"width: 99%;\"";
		if (isset($this->tooltip)) $html .= " onmouseover=\"openToolTip('{$this->tooltip}');\" onmouseout=\"closeToolTip();\"";
		if (!isset($this->placeholder) && isset($this->tooltip)) $this->placeholder = $this->tooltip;
		if (isset($this->placeholder)) $html .= " placeholder=\"{$this->placeholder}\"";
		$html .= ">";
		if (isset($this->contents)) $html .= $this->contents;
		$html .= "</textarea>";
		
		return $html;
		
	}
	
}

/**
 * Checkbox form item object.
 */
class WizardCheckbox extends WizardFormItem {
	
	/**
	 * Checkbox value.
	 * 
	 * @var string
	 * @access public
	 */
	public $value = "on";
	
	/**
	 * Checked status.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $checked = false;

	/**
	 * Disabled status.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $disabled = false;
	
	/**
	 * Unlike other form item types, checkbox labels are put to the right of the checkbox.
	 * 
	 * Use this variable to specify text to appear in the left column in addition.
	 * 
	 * @var string
	 * @access public
	 */
	public $sidelabel;
	
	/**
	 * Construct via parent and add form element type.
	 * 
	 * @access public
	 */
	public function __construct($name=false,$id=false) {
		parent::__construct($name,$id);
		$this->type = "checkbox";	
	}
	
	/**
	 * Create checkbox HTML.
	 * 
	 * @return string		- HTML markup
	 * @access public
	 */
	public function generate_html() {

		$html = "<input type=\"checkbox\" name=\"{$this->name}\" id=\"{$this->id}\" value=\"{$this->value}\"";
		if (isset($this->cssclass)) $html .= " class=\"{$this->cssclass}\"";
		if (isset($this->onclick)) $html .= " onclick=\"{$this->onclick}\"";
		if ($this->checked) $html .= " checked";
		if ($this->disabled) $html .= " disabled";
		if (isset($this->tooltip)) $html .= " onmouseover=\"openToolTip('{$this->tooltip}');\" onmouseout=\"closeToolTip();\"";
		$html .= " /> <label for=\"{$this->id}\"";
		if (isset($this->tooltip)) $html .= " onmouseover=\"openToolTip('{$this->tooltip}');\" onmouseout=\"closeToolTip();\"";
		$html .= ">{$this->label}</label>";
		
		return $html;
		
	}
	
}

/**
 * Select (menu) form item object.
 */
class WizardSelect extends WizardFormItem {
	
	/**
	 * Menu options (associative).
	 * 
	 * @var array
	 * @access public
	 */
	public $options;
	
	/**
	 * Selected item.
	 * 
	 * @var string
	 * @access public
	 */
	public $selected;
	
	/**
	 * Menu height (does not apply to multi-select menus)
	 * 
	 * @var integer
	 * @access public
	 */
	public $size = 1;
	
	/**
	 * Enable multiple selections
	 * 
	 * @var boolean
	 * @access public
	 */
	public $multiple = false;
	
	/**
	 * Enable multi-select mode (requires Multiselect jQuery plugin to be loaded).
	 * 
	 * Using this option will disable the abstract "fullwidth" property. It will
	 * also mean that any assigned tooltip will not show as jQuery replaces the element.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $multiselect = false;
	
	/**
	 * "onchange" action attribute.
	 * 
	 * This does not apply when in multi-select mode.
	 * 
	 * @var string
	 * @access public
	 */
	public $onchange;
	
	/**
	 * Construct via parent and add form element type.
	 * 
	 * @access public
	 */
	public function __construct($name=false,$id=false) {
		parent::__construct($name,$id);
		$this->type = "select";	
	}
	
	/**
	 * Create menu HTML and jQuery.
	 * 
	 * @return string		- HTML markup
	 * @access public
	 */
	public function generate_html() {

		// start menu HTML
		$html = "<select name=\"{$this->name}\" id=\"{$this->id}\" size=\"{$this->size}\"";
		if (isset($this->cssclass)) $html .= " class=\"{$this->cssclass}\"";
		if ($this->multiple) $html .= " multiple";
		if (!$this->multiselect) {
			if (isset($this->onclick)) $html .= " onclick=\"{$this->onclick}\"";
			if (isset($this->onchange)) $html .= " onchange=\"{$this->onchange}\"";
			if ($this->fullwidth) $html .= " style=\"width: 99%;\"";
			if (isset($this->tooltip)) $html .= " onmouseover=\"openToolTip('{$this->tooltip}');\" onmouseout=\"closeToolTip();\"";
		}
		$html .= ">";
		
		// add items to menu
		foreach ($this->options as $optval => $optlab) {
			if ($this->multiselect) $optlab = "&nbsp;{$optlab}";
			$html .= "<option value=\"{$optval}\"";
			if ((isset($this->selected) && $optval == $this->selected) || (!isset($this->selected) && !isset($selected))) {
				$html .= " selected";
				$selected = true;
			}
			$html .= ">{$optlab}</option>";
		}
		
		// close menu
		$html .= "</select>";
		
		// construct jQuery if required
		if ($this->multiselect) {
			$this->jquery[] = "\$(\"#{$this->id}\").multiselect({ selectedText: \"# of # selected\", height: \"auto\" });";	
		}
		
		return $html;
		
	}
	
}

/**
 * Radio group form item object.
 */
class WizardRadioGroup extends WizardFormItem {
	
	/**
	 * Selected item.
	 * 
	 * @var string
	 * @access public
	 */
	public $selected;

	/**
	 * Radio group options (associative).
	 * 
	 * @var array
	 * @access public
	 */
	public $options;
	
	/**
	 * Set to true to render radio group inline instead of in a list.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $inline = false;
	
	/**
	 * Construct via parent and add form element type.
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct($name=false,$id=false) {
		parent::__construct($name,$id);
		$this->type = "radiogroup";	
	}
	
	/**
	 * Create radio group HTML.
	 * 
	 * @return string		- HTML markup
	 * @access public
	 */
	public function generate_html() {

		// start HTML
		$html = "";
		if (isset($this->tooltip)) $html .= "<div onmouseover=\"openToolTip('{$this->tooltip}');\" onmouseout=\"closeToolTip();\">";
		
		// IDs are extended with a sequential integer in radio groups
		$i = 0;
		
		foreach ($this->options as $optval => $optlab) {
			$html .= "<input type=\"radio\" name=\"{$this->name}\" id=\"{$this->id}_{$i}\" value=\"{$optval}\"";
			if (!isset($this->selected) && $i == 0) $html .= " checked";
			if (isset($this->selected) && $optval == $this->selected) $html .= " checked";
			$html .= " /> <label for=\"{$this->id}_{$i}\">{$optlab}</label>&nbsp;&nbsp;";
			if (!$this->inline) $html .= "<br/>";
			$i++;
		}
		
		// trim and complete HTML
		if (!$this->inline) $html = substr($html,0,-5);
		if (isset($this->tooltip)) $html .= "</div>";
		
		return $html;
		
	}
	
}

/**
 * Date picker form item object.
 */
class WizardDatePicker extends WizardFormItem {
	
	/**
	 * Pre-selected date.
	 * 
	 * @var string
	 * @access public
	 */
	public $date;
	
	/**
	 * Disable manual editing (force use of calendar).
	 * 
	 * @var boolean
	 * @access public
	 */
	public $disable_manual_editing = true;
	
	/**
         * Include time drop-downs. jQuery datepicker does not support time.
         *
         * Field names/ids will be the date field name/id with "_hour" and "_minute" appended.
         * Set to true to pre-set the menus to "now".
         * Pass an array with hour and minute to pre-set otherwise.
         * Leave false to omit.
         *
         * @var mixed
         * @access public
         */
        public $time = false;
	
	/**
	 * Construct via parent and add form element type.
	 * 
	 * @access public
	 */
	public function __construct($name=false,$id=false) {
		parent::__construct($name,$id);
		$this->type = "datepicker";	
	}
	
	/**
	 * Create date picker HTML and jQuery.
	 * 
	 * @return string		- HTML markup
	 * @access public
	 */
        public function generate_html() {
               
                // construct HTML
                $html = "<input type=\"text\" name=\"{$this->name}\" id=\"{$this->id}\" size=\"10\"";
                if (isset($this->date)) $html .= " value=\"{$this->date}\"";
                if ($this->disable_manual_editing) $html .= " readonly";
                if (isset($this->tooltip)) $html .= " onmouseover=\"openToolTip('{$this->tooltip}');\" onmouseout=\"closeToolTip();\"";
                $html .= " />";
               
                // add time menus if required
                if ($this->time != false) {

                        // determine preselection to now if not passed
                        if (!is_array($this->time)) $this->time = array(date("H"),date("i"));
                       
                        // hour menu
                        $html .= "&nbsp;<select name=\"{$this->name}_hour\" id=\"{$this->id}_hour\">";
                        for ($i=0; $i<=23; $i++) {
                                $html .= "<option value=\"".sprintf("%02d",$i)."\"";
                                if ($this->time[0] == $i) $html .= " selected";
                                $html .= ">".sprintf("%02d",$i)."</option>";   
                        }
                        $html .= "</select>";
                       
                        // minute menu
                        $html .= "&nbsp;:&nbsp;<select name=\"{$this->name}_minute\" id=\"{$this->id}_minute\">";
                        for ($i=0; $i<=55; $i=$i+5) {
                                $html .= "<option value=\"".sprintf("%02d",$i)."\"";
                                if ($this->time[1] == $i) $html .= " selected";
                                $html .= ">".sprintf("%02d",$i)."</option>";   
                        }
                        $html .= "</select>";
                       
                }
               
                // construct jQuery
                $this->jquery[] = "\$(\"#{$this->id}\").datepicker({ showWeek: true, firstDay: 1, changeMonth: true, dateFormat: \"dd/mm/yy\", showAnim: \"fadeIn\" });";
               
                return $html;
               
        }
	
}

/**
 * Wrapper class that uses WizardDatePicker to show two date fields on the same line.
 */
class WizardDualDatePicker extends WizardFormItem {
	
	/**
	 * First pre-selected date.
	 * 
	 * @var string
	 * @access public
	 */
	public $date1;
	
	/**
	 * First date prefix.
	 * 
	 * @var string
	 * @access public
	 */
	public $prefix1;
	
	/**
	 * Second pre-selected date.
	 * 
	 * @var string
	 * @access public
	 */
	public $date2;
	
	/**
	 * Second date prefix.
	 * 
	 * @var string
	 * @access public
	 */
	public $prefix2;
	
	/**
	 * Construct via parent and add form element type.
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct($name=false,$id=false) {
		parent::__construct($name,$id);
		$this->type = "dualdatepicker";	
	}
	
	/**
	 * Create date picker HTML and jQuery.
	 * 
	 * @return string		- HTML markup
	 * @access public
	 */
	public function generate_html() {
		
		// create normal date picker objects for each date
		$date1 = new WizardDatePicker("{$this->name}_1","{$this->id}_1");
		$date2 = new WizardDatePicker("{$this->name}_2","{$this->id}_2");

		// build HTML
		$html = "";
		if (isset($this->prefix1)) $html .= "{$this->prefix1}&nbsp;";
		$html .= $date1->generate_html()."&nbsp;";
		if (isset($this->prefix2)) $html .= "&nbsp;{$this->prefix2} ";
		$html .= $date2->generate_html();
		
		// merge jQuery
		$this->jquery = array_merge($this->jquery,$date1->jquery);
		$this->jquery = array_merge($this->jquery,$date2->jquery);
		
		return $html;
		
	}
	
}

/**
 * Number range form item object.
 */
class WizardNumberRange extends WizardFormItem {
	
	/**
	 * Minimum value.
	 * 
	 * @var integer
	 * @access public
	 */
	public $minimum = 1;
	
	/**
	 * Maximum value.
	 * 
	 * @var integer
	 * @access public
	 */
	public $maximum = 10;
	
	/**
	 * Step increment
	 * 
	 * @var integer
	 * @access public
	 */
	public $step = 1;
	
	/**
	 * Pre-set value.
	 * 
	 * @var integer
	 * @access public
	 */
	public $value;
	
	/**
	 * Use slider instead of text box with controls.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $slider = false;
	
	/**
	 * Construct via parent and add form element type.
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct($name=false,$id=false) {
		parent::__construct($name,$id);
		$this->type = "range";
		if (!isset($this->value)) $this->value = $this->minimum;
	}
	
	/**
	 * Create number range HTML (for HTML5 browers).
	 * 
	 * @return string		- HTML markup
	 * @access public
	 */
	public function generate_html() {
		
		// determine input type
		if ($this->slider) {
			$type = "range";
		} else {
			$type = "number";
		}
		
		// construct HTML
		$html = "<input type=\"{$type}\" name=\"{$this->name}\" id=\"{$this->id}\" min=\"{$this->minimum}\" max=\"{$this->maximum}\" step=\"{$this->step}\"";
		if (isset($this->value)) $html .= " value=\"{$this->value}\"";
		if (isset($this->cssclass)) $html .= " class=\"{$this->cssclass}\"";
		if (isset($this->onclick)) $html .= " onclick=\"{$this->onclick}\"";
		if ($this->fullwidth) $html .= " style=\"width: 99%;\"";
		if (isset($this->tooltip)) $html .= " onmouseover=\"openToolTip('{$this->tooltip}');\" onmouseout=\"closeToolTip();\"";
		$html .= " />";
		
		return $html;
		
	}
	
	/**
	 * Create number range HTML (for non-HTML5 browers).
	 * 
	 * @return string		- HTML markup
	 * @access public
	 */
	public function generate_fallback_html() {
		
		// create menu item object
		$menu = new WizardSelect($this->id);

		// copy any common properties to menu object
		foreach (array_keys(get_object_vars($menu)) as $property) {
			if (property_exists($this,$property) && property_exists($menu,$property)) {
				$menu->__set($property,$this->$property);		
			}
		}
		
		// add options
		$menu->selected = $this->value;
		$menu->options = array();
		for ($i=$this->minimum; $i<=$this->maximum; $i=$i+$this->step) {
			$menu->options[$i] = $i;
		}

		return $menu->generate_html();
		
	}
	
}

/**
 * Fixed form item object.
 */
class WizardFixedField extends WizardFormItem {
	
	/**
	 * Field value.
	 * 
	 * @var string
	 * @access public
	 */
	public $value;
	
	/**
	 * Text to display (if not set, value is displayed)
	 * 
	 * @var string
	 * @access public
	 */
	public $text;
	
	/**
	 * Construct via parent and add form element type.
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct($name=false,$id=false) {
		parent::__construct($name,$id);
		$this->type = "fixed";	
	}
	
	/**
	 * Create text box HTML and jQuery.
	 * 
	 * @return string		- HTML markup
	 * @access public
	 */
	public function generate_html() {
		
		// construct HTML
		if (!isset($this->text)) $this->text = $this->value;
		$html = "<input type=\"hidden\" name=\"{$this->name}\" id=\"{$this->id}\" value=\"{$this->value}\" />{$this->text}";
		
		return $html;
		
	}
	
}

/**
 * Button set form item object.
 */
class WizardButtonSet extends WizardFormItem {
	
	/**
	 * Selected item.
	 * 
	 * @var string
	 * @access public
	 */
	public $selected;

	/**
	 * Button set options (associative).
	 * 
	 * @var array
	 * @access public
	 */
	public $options;
	
	/**
	 * Mutually exclusive mode
	 * 
	 * Set to true to render a set of buttons where only one can be selected.
	 * Set to false to render a set of buttons where any number can be selected.
	 * 
	 * @var boolean
	 * @access public
	 */
	public $exclusive = true;

	/**
	 * Construct via parent and add form element type.
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct($name=false,$id=false) {
		parent::__construct($name,$id);
		$this->type = "buttonset";	
	}
	
	/**
	 * Create button set HTML and jQuery.
	 * 
	 * @return string		- HTML markup
	 * @access public
	 */
	public function generate_html() {

		// start HTML
		$html = "<span id=\"{$this->id}\" ";
		if (isset($this->tooltip)) $html .= " onmouseover=\"openToolTip('{$this->tooltip}');\" onmouseout=\"closeToolTip();\"";
		$html .= ">";
		
		// IDs are extended with a sequential integer
		$i = 0;
		
		if ($this->exclusive) {
		
			// exclusive mode (use radios)
			
			foreach ($this->options as $optval => $optlab) {
				$html .= "<input type=\"radio\" name=\"{$this->name}\" id=\"{$this->id}_{$i}\" value=\"{$optval}\"";
				if (!isset($this->selected) && $i == 0) $html .= " checked";
				if (isset($this->selected) && $optval == $this->selected) $html .= " checked";
				$html .= " /> <label for=\"{$this->id}_{$i}\">{$optlab}</label>";
				$i++;
			}
			
			// construct jQuery
			$this->jquery[] = "\$(\"#{$this->id}\").buttonset();";	
		
		} else {
			
			// non-exclusive mode (use checkboxes)
			
			foreach ($this->options as $optval => $optlab) {
				$html .= "<input type=\"checkbox\" name=\"{$this->id}_{$i}\" id=\"{$this->id}_{$i}\" value=\"{$optval}\" />";
				$html .= "<label for=\"{$this->id}_{$i}\">{$optlab}</label> ";
				$this->jquery[] = "\$(\"#{$this->id}_{$i}\").button();";
				$i++;
			}
			
		}

		return "{$html}</span>";
		
	}
	
}

?>