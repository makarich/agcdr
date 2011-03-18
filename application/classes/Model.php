<?php

/**
 * Model management class.
 * 
 * @package	AGCDR
 * @author	SBF
 * @copyright	2010-2011
 */

abstract class Model {
	
	/**
	 * Record ID.
	 * 
	 * @var integer
	 * @access public
	 */
	public $id;
	
	/**
	 * Construct.
	 * 
	 * @access public
	 */
	public function __construct($data=false) {
		
		if (is_array($data)) {
			
			// create object from data array
			foreach ($data as $key => $value) $this->$key = $value;
			
		} elseif (is_numeric($data)) {
		
			// load record if ID passed
			$this->id = $id;
			$this->load($id);
		
		}
		
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
	 * @return mixed
	 * @access public		- value of key
	 */
	public function __get($key) {
		
		if (property_exists($this,$key)) {
			return $this->$key;
		} else {
			 throw new Exception("Attempt to get a non-existant property: {$key}");
		}
		
	}
	
	/**
	 * Load a record from the database by ID and insert it into an object.
	 * 
	 * This is a shortcut wrapper for load_by() for records only loaded by ID.
	 * 
	 * @param integer $id		- record ID (table name is read from the object type)
	 * 
	 * @return boolean		- true, or false if record was not loaded
	 * @access public
	 */
	public function load($id) {

		// call load_by function to fulfill
		return $this->load_by(array("id" => $id));
		
	}
	
	/**
	 * Load a record from the database by a number of fields and insert it into an object.
	 * 
	 * @param array $fields		- associative array of table fields and values
	 * 
	 * @return boolean		- true, of false if record was not loaded
	 * @access public
	 */
	public function load_by($fields) {
		
		// initialise database
		$db = DB::Instance();

		// prepare SQL
		$conditions = array();
		foreach ($fields as $name => $value) array_push($conditions,"{$name}='{$value}'");
		$sql = "SELECT * FROM ".get_class($this)." WHERE ".implode(" AND ",$conditions).";";
		
		// retrieve record from database and set values in object
		if ($record = $db->GetRow($sql)) {
			foreach ($record as $key => $value) $this->$key = $value;
			return true;
		} else {
			return false;
		}
		
	}
	
	/**
	 * Save an object as a database record.
	 * 
	 * Creates a record if it doesn't already exist, otherwise updates an exising record.
	 * 
	 * @return integer		- record ID (existing or new), or false if there was an error
	 * @access public
	 */
	public function save() {

		// initialise database
		$db = DB::Instance();
		// $db->debug();
		
		// table name
		$table = get_class($this);

		if (!empty($this->id) && $db->GetOne("SELECT id FROM {$table} WHERE id={$this->id}")) {

			// update record
			$record = (array) $this;
			if (!$db->AutoExecute($table,$record,"UPDATE","id={$this->id}")) return false;

		} else {

			// create new record
			$this->id = $db->GetOne("SELECT (MAX(id)+1) AS next_id FROM {$table}");
			$record = (array) $this;
			if (!$db->AutoExecute($table,$record,"INSERT")) return false;
			
		}
		
		// return updated or created ID
		return $this->id;
		
	}
	
	/**
	 * Delete an object's record from the database and destroy the object.
	 * 
	 * @return void
	 * @access public
	 */
	public function delete() {
		
		// initialise database
		$db = DB::Instance();
		
		// delete database record
		$db->Execute("DELETE FROM ".get_class($this)." WHERE id={$this->id};");
		
		// destroy object
		unset($this);
		
	}
	
	/**
	 * Duplicate an existing object.
	 * 
	 * @param boolean $remove_id	- (optional) set to true to remove the "id" key from the new object (default true)
	 * 
	 * @return object		- new object
	 * @access public
	 */
	public function duplicate($remove_id=true) {
		
		// get object type
		$objtype = get_class($this);

		// create new object and copy data from existing object
		$newobj = new $objtype;
		foreach ($this as $key => $value) $newobj->$key = $value;
		
		// remove "id" key if required
		if ($remove_id) unset($newobj->id);
		
		// return new object
		return $newobj;
		
	}

	/**
	 * Convert object into serialised JSON data.
	 * 
	 * @return string		- JSON data, or false if json_encode function is not available.
	 * @access public
	 */
	public function toJSON() {
		
		if (function_exists("json_encode")) {
			return json_encode((array) $this);
		} else {
			return false;
		}
		
	}
	
}

?>