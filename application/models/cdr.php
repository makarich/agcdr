<?php 

/**
 * Caller detail record model.
 * 
 * The fields in this model match the standard fields present in the table used
 * by the cdr_mysql module. You may have added further fields to this table for
 * your own purposes. This is fine, they will be simply ignored by this system.
 * 
 * @package	AGCDR
 * @author	SBF
 * @copyright	2011
 */

/**
 * cdr.
 */
class cdr extends Model {
	
	/**
	 * Call date and time.
	 * 
	 * @var string
	 * @access public
	 */
	public $calldate;
	
	/**
	 * Caller ID.
	 * 
	 * @var string
	 * @access public
	 */
	public $clid;
	
	/**
	 * Source.
	 * 
	 * @var string
	 * @access public
	 */
	public $src;
	
	/**
	 * Destination.
	 * 
	 * @var string
	 * @access public
	 */
	public $dst;
	
	/**
	 * Destination context.
	 * 
	 * @var string
	 * @access public
	 */
	public $dcontext;
	
	/**
	 * Channel.
	 * 
	 * @var string
	 * @access public
	 */
	public $channel;
	
	/**
	 * Destination channel.
	 * 
	 * @var string
	 * @access public
	 */
	public $dstchannel;
	
	/**
	 * Last application.
	 * 
	 * @var string
	 * @access public
	 */
	public $lastapp;
	
	/**
	 * Last data.
	 * 
	 * @var string
	 * @access public
	 */
	public $lastdata;
	
	/**
	 * Duration of call (seconds).
	 * 
	 * @var integer
	 * @access public
	 */
	public $duration;
	
	/**
	 * Billable duration of call (seconds).
	 * 
	 * @var integer
	 * @access public
	 */
	public $billsec;
	
	/**
	 * Call disposition.
	 * 
	 * @var string
	 * @access public
	 */
	public $disposition;
	
	/**
	 * Automated Message Accounting flags.
	 * 
	 * @var integer
	 * @access public
	 */
	public $amaflags;
	
	/**
	 * Account code.
	 * 
	 * @var string
	 * @access public
	 */
	public $accountcode;
	
	/**
	 * User field.
	 * 
	 * @var string
	 * @access public
	 */
	public $userfield;
	
	/**
	 * Unique ID.
	 * 
	 * @var string
	 * @access public
	 */
	public $uniqueid;
	
	/*

	CREATE TABLE IF NOT EXISTS `cdr` (
		`calldate` datetime NOT NULL default '0000-00-00 00:00:00',
		`clid` varchar(80) NOT NULL default '',
		`src` varchar(80) NOT NULL default '',
		`dst` varchar(80) NOT NULL default '',
		`dcontext` varchar(80) NOT NULL default '',
		`channel` varchar(80) NOT NULL default '',
		`dstchannel` varchar(80) NOT NULL default '',
		`lastapp` varchar(80) NOT NULL default '',
		`lastdata` varchar(80) NOT NULL default '',
		`duration` int(11) NOT NULL default '0',
		`billsec` int(11) NOT NULL default '0',
		`disposition` varchar(45) NOT NULL default '',
		`amaflags` int(11) NOT NULL default '0',
		`accountcode` varchar(20) NOT NULL default '',
		`userfield` varchar(255) NOT NULL default '',
		`uniqueid` varchar(32) NOT NULL default '',
		KEY `calldate` (`calldate`),
		KEY `dst` (`dst`),
		KEY `accountcode` (`accountcode`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;

	 */
	
	
}

?>