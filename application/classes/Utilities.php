<?php

/**
 * General utility function class.
 * 
 * Some functions require DB class for database access.
 * 
 * @package	SBF-Classlib
 * @author	Stuart Benjamin Ford <stuartford@me.com>
 * @copyright	10/05/2011
 */

/**
 * Dependent classes
 */
if (!class_exists("DB")) require_once("DB.php");

/**
 * Utilities.
 */
class Utilities {

	/**
	 * UK county information (correct as of 2008).
	 * 
	 * @var array
	 * @access public
	 */
	public $uk_counties = array(
		"Aberdeenshire",
		"Anglesey",
		"Angus",
		"Argyll",
		"Ayrshire",
		"Banffshire",
		"Bedfordshire",
		"Berwickshire",
		"Breconshire",
		"Buckinghamshire",
		"Bute",
		"Caernarvonshire",
		"Caithness",
		"Cambridgeshire",
		"Cardiganshire",
		"Carmarthenshire",
		"Cheshire",
		"Clackmannanshire",
		"Cornwall and Isles of Scilly",
		"Cumbria",
		"Denbighshire",
		"Derbyshire",
		"Devon",
		"Dorset",
		"Dumbartonshire",
		"Dumfriesshire",
		"Durham",
		"East Lothian",
		"East Sussex",
		"Essex",
		"Fife",
		"Flintshire",
		"Glamorgan",
		"Gloucestershire",
		"Greater London",
		"Greater Manchester",
		"Hampshire",
		"Hertfordshire",
		"Inverness",
		"Kent",
		"Kincardineshire",
		"Kinross-shire",
		"Kirkcudbrightshire",
		"Lanarkshire",
		"Lancashire",
		"Leicestershire",
		"Lincolnshire",
		"London",
		"Merionethshire",
		"Merseyside",
		"Midlothian",
		"Monmouthshire",
		"Montgomeryshire",
		"Moray",
		"Nairnshire",
		"Norfolk",
		"North Yorkshire",
		"Northamptonshire",
		"Northumberland",
		"Nottinghamshire",
		"Orkney",
		"Oxfordshire",
		"Peebleshire",
		"Pembrokeshire",
		"Perthshire",
		"Radnorshire",
		"Renfrewshire",
		"Ross & Cromarty",
		"Roxburghshire",
		"Selkirkshire",
		"Shetland",
		"Shropshire",
		"Somerset",
		"South Yorkshire",
		"Staffordshire",
		"Stirlingshire",
		"Suffolk",
		"Surrey",
		"Sutherland",
		"Tyne and Wear",
		"Warwickshire",
		"West Lothian",
		"West Midlands",
		"West Sussex",
		"West Yorkshire",
		"Wigtownshire",
		"Wiltshire",
		"Worcestershire"
		);

	/**
	 * Path to timezone information CSV file.
	 * 
	 * @var string
	 * @access private
	 */
	private $tzi_path;

	/**
	 * Construct.
	 * 
	 * @access public
	 */
	public function __construct() {
		if (defined('TZI_PATH')) $this->tzi_path = TZI_PATH;	
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
	
	/**
	 * Return country information (correct as of 2008).
	 * 
	 * @return array		- associative array of country information
	 * @access public
	 */
	public function country_database() {
		
		return array(
			"Afghanistan"				=> array("AFG","AF","Afghanistan","AFA","Afghanis","non-EU"),
			"Albania"				=> array("ALB","AL","Albania","ALL","Leke","non-EU"),
			"Algeria"				=> array("DZA","DZ","Algeria","DZD","Algeria Dinars","non-EU"),
			"American Samoa"			=> array("ASM","AS","American Samoa","Unknown","Unknown","non-EU"),
			"Andorra"				=> array("AND","AD","Andorra","Unknown","Unknown","non-EU"),
			"Angola"				=> array("AGO","AO","Angola","AOA","Kwanza","non-EU"),
			"Anguilla"				=> array("AIA","AI","Anguilla","Unknown","Unknown","non-EU"),
			"Antigua and Barbuda"			=> array("ATG","AG","Antigua and Barbuda","Unknown","Unknown","non-EU"),
			"Argentina"				=> array("ARG","AR","Argentina","ARS","Pesos","non-EU"),
			"Armenia"				=> array("ARM","AM","Armenia","AMD","Drams","non-EU"),
			"Aruba"					=> array("ABW","AW","Aruba","AWG","Guilders (also called Florins)","non-EU"),
			"Australia"				=> array("AUS","AU","Australia","AUD","Dollars","non-EU"),
			"Austria"				=> array("AUT","AT","Austria","Unknown","Unknown","EU"),
			"Azerbaijan"				=> array("AZE","AZ","Azerbaijan","AZM","Manats","non-EU"),
			"Bahamas"				=> array("BHS","BS","Bahamas","BSD","Dollars","non-EU"),
			"Bahrain"				=> array("BHR","BH","Bahrain","BHD","Dinars","non-EU"),
			"Bangladesh"				=> array("BGD","BD","Bangladesh","BDT","Taka","non-EU"),
			"Barbados"				=> array("BRB","BB","Barbados","BBD","Dollars","non-EU"),
			"Belarus"				=> array("BLR","BY","Belarus","BYR","Rubles","non-EU"),
			"Belgium"				=> array("BEL","BE","Belgium","Unknown","Unknown","EU"),
			"Belize"				=> array("BLZ","BZ","Belize","BZD","Dollars","non-EU"),
			"Benin"					=> array("BEN","BJ","Benin","Unknown","Unknown","non-EU"),
			"Bermuda"				=> array("BMU","BM","Bermuda","BMD","Dollars","non-EU"),
			"Bhutan"				=> array("BTN","BT","Bhutan","BTN","Ngultrum","non-EU"),
			"Bolivia"				=> array("BOL","BO","Bolivia","BOB","Bolivianos","non-EU"),
			"Bosnia and Herzegovina"		=> array("BIH","BA","Bosnia and Herzegovina","BAM","Convertible Marka","non-EU"),
			"Botswana"				=> array("BWA","BW","Botswana","BWP","Pulas","non-EU"),
			"Bouvet Island"				=> array("BVT","BV","Bouvet Island","Unknown","Unknown","non-EU"),
			"Brazil"				=> array("BRA","BR","Brazil","BRL","Brazil Real","non-EU"),
			"British Indian Ocean Territory"	=> array("IOT","IO","British Indian Ocean Territory","Unknown","Unknown","non-EU"),
			"British Virgin Islands"		=> array("VGB","Unknown","British Virgin Islands","Unknown","Unknown","non-EU"),
			"Brunei Darussalam"			=> array("BRN","BN","Brunei Darussalam","BND","Dollars","non-EU"),
			"Bulgaria"				=> array("BGR","BG","Bulgaria","BGN","Leva","non-EU"),
			"Burkina Faso"				=> array("BFA","BF","Burkina Faso","Unknown","Unknown","non-EU"),
			"Burundi"				=> array("BDI","BI","Burundi","BIF","Francs","non-EU"),
			"Caicos and Turks Islands"		=> array("TCA","Unknown","Caicos and Turks Islands","Unknown","Unknown","non-EU"),
			"Cambodia"				=> array("KHM","KH","Cambodia","KHR","Riels","non-EU"),
			"Cameroon"				=> array("CMR","CM","Cameroon","Unknown","Unknown","non-EU"),
			"Canada"				=> array("CAN","CA","Canada","CAD","Dollars","non-EU"),
			"Cape Verde"				=> array("CPV","CV","Cape Verde","CVE","Escudos","non-EU"),
			"Cayman Islands"			=> array("CYM","KY","Cayman Islands","KYD","Dollars","non-EU"),
			"Central African Republic"		=> array("CAF","CF","Central African Republic","Unknown","Unknown","non-EU"),
			"Chad"					=> array("TCD","TD","Chad","Unknown","Unknown","non-EU"),
			"Chile"					=> array("CHL","CL","Chile","CLP","Pesos","non-EU"),
			"China"					=> array("CHN","CN","China","CNY","Yuan Renminbi","non-EU"),
			"Christmas Island"			=> array("CXR","CX","Christmas Island","Unknown","Unknown","non-EU"),
			"Cocos (Keeling) Islands"		=> array("CCK","CC","Cocos (Keeling) Islands","Unknown","Unknown","non-EU"),
			"Colombia"				=> array("COL","CO","Colombia","COP","Pesos","non-EU"),
			"Comoros"				=> array("COM","KM","Comoros","KMF","Francs","non-EU"),
			"Congo"					=> array("COG","CD","CG","Congo","CDF","Congo/Kinshasa, Congolese Francs"),
			"Cook Islands"				=> array("COK","CK","Cook Islands","Unknown","Unknown","non-EU"),
			"Costa Rica"				=> array("CRI","CR","Costa Rica","CRC","Colones","non-EU"),
			"Cote D'Ivoire"				=> array("CIV","Unknown","Cote D'Ivoire","Unknown","Unknown","non-EU"),
			"Croatia"				=> array("HRV","Unknown","Croatia","HRK","Kuna","non-EU"),
			"Cuba"					=> array("CUB","CU","Cuba","CUP","Pesos","non-EU"),
			"Cyprus"				=> array("CYP","CY","Cyprus","CYP","Pounds","EU"),
			"Czech Republic"			=> array("CZE","CZ","Czech Republic","CZK","Koruny","EU"),
			"Denmark"				=> array("DNK","DK","Denmark","DKK","Kroner","EU"),
			"Djibouti"				=> array("DJI","DJ","Djibouti","DJF","Francs","non-EU"),
			"Dominica"				=> array("DMA","DM","Dominica","DOP","Dominican Republic, Pesos","non-EU"),
			"Dominican Republic"			=> array("DOM","DO","Dominican Republic","DOP","Pesos","non-EU"),
			"East Timor"				=> array("TMP","TP","East Timor","Unknown","Unknown","non-EU"),
			"Ecuador"				=> array("ECU","EC","Ecuador","Unknown","Unknown","non-EU"),
			"Egypt"					=> array("EGY","EG","Egypt","EGP","Pounds","non-EU"),
			"Eire (Ireland)"			=> array("IRL","Unknown","Eire (Ireland)","Unknown","Unknown","EU"),
			"El Salvador"				=> array("SLV","SV","El Salvador","SVC","Colones","non-EU"),
			"Equatorial Guinea"			=> array("GNQ","GQ","Equatorial Guinea","Unknown","Unknown","non-EU"),
			"Eritrea"				=> array("ERI","ER","Eritrea","ERN","Nakfa","non-EU"),
			"Estonia"				=> array("EST","EE","Estonia","EEK","Krooni","EU"),
			"Ethiopia"				=> array("ETH","ET","Ethiopia","ETB","Birr","non-EU"),
			"Falkland Islands (Malvinas)"		=> array("FLK","FK","Falkland Islands (Malvinas)","Unknown","Unknown","non-EU"),
			"Faroe Islands"				=> array("FRO","FO","Faroe Islands","Unknown","Unknown","non-EU"),
			"Fiji"					=> array("FJI","FJ","Fiji","FJD","Dollars","non-EU"),
			"Finland"				=> array("FIN","FI","Finland","Unknown","Unknown","EU"),
			"France"				=> array("FRA","FR","France","Unknown","Unknown","EU"),
			"French Guiana"				=> array("GUF","GF","French Guiana","Unknown","Unknown","non-EU"),
			"French Polynesia"			=> array("PYF","PF","French Polynesia","Unknown","Unknown","non-EU"),
			"French Southern Territories"		=> array("ATF","TF","French Southern Territories","Unknown","Unknown","non-EU"),
			"Gabon"					=> array("GAB","GA","Gabon","Unknown","Unknown","non-EU"),
			"Gambia"				=> array("GMB","GM","Gambia","GMD","Dalasi","non-EU"),
			"Georgia"				=> array("GEO","GE","Georgia","GEL","Lari","non-EU"),
			"Germany"				=> array("DEU","DE","Germany","Unknown","Unknown","EU"),
			"Ghana"					=> array("GHA","GH","Ghana","GHC","Cedis","non-EU"),
			"Gibraltar"				=> array("GIB","GI","Gibraltar","GIP","Pounds","non-EU"),
			"Greece"				=> array("GRC","GR","Greece","Unknown","Unknown","EU"),
			"Greenland"				=> array("GRL","GL","Greenland","Unknown","Unknown","non-EU"),
			"Grenada"				=> array("GRD","GD","Grenada","Unknown","Unknown","non-EU"),
			"Guadeloupe"				=> array("GLP","GP","Guadeloupe","Unknown","Unknown","non-EU"),
			"Guam"					=> array("GUM","GU","Guam","Unknown","Unknown","non-EU"),
			"Guatemala"				=> array("GTM","GT","Guatemala","GTQ","Quetzales","non-EU"),
			"Guinea"				=> array("GIN","GN","Guinea","GNF","PGK","Francs"),
			"Guinea-Bissau"				=> array("GNB","GW","Guinea-Bissau","Unknown","Unknown","non-EU"),
			"Guyana"				=> array("GUY","GY","Guyana","GYD","Dollars","non-EU"),
			"Haiti"					=> array("HTI","HT","Haiti","HTG","Gourdes","non-EU"),
			"Heard Island & McDonald Islands"	=> array("HMD","Unknown","Heard Island & McDonald Islands","Unknown","Unknown","non-EU"),
			"Honduras"				=> array("HND","HN","Honduras","HNL","Lempiras","non-EU"),
			"Hong Kong"				=> array("HKG","HK","Hong Kong","HKD","Dollars","non-EU"),
			"Hungary"				=> array("HUN","HU","Hungary","HUF","Forint","EU"),
			"Iceland"				=> array("ISL","IS","Iceland","ISK","Kronur","non-EU"),
			"India"					=> array("IND","IN","India","INR","Rupees","non-EU"),
			"Indonesia"				=> array("IDN","ID","Indonesia","IDR","Rupiahs","non-EU"),
			"Iran"					=> array("IRN","Unknown","Iran","IRR","Rials","non-EU"),
			"Iraq"					=> array("IRQ","IQ","Iraq","IQD","Dinars","non-EU"),
			"Israel"				=> array("ISR","IL","Israel","ILS","New Shekels","non-EU"),
			"Italy"					=> array("ITA","IT","Italy","Unknown","Unknown","EU"),
			"Jamaica"				=> array("JAM","JM","Jamaica","JMD","Dollars","non-EU"),
			"Jan Mayen and Svalbard"		=> array("SJM","Unknown","Jan Mayen and Svalbard","Unknown","Unknown","non-EU"),
			"Japan"					=> array("JPN","JP","Japan","JPY","Yen","non-EU"),
			"Jordan"				=> array("JOR","JO","Jordan","JOD","Dinars","non-EU"),
			"Kazakstan"				=> array("KAZ","Unknown","Kazakstan","Unknown","Unknown","non-EU"),
			"Kenya"					=> array("KEN","KE","Kenya","KES","Shillings","non-EU"),
			"Kiribati"				=> array("KIR","KI","Kiribati","Unknown","Unknown","non-EU"),
			"Korea (North)"				=> array("PKR","Unknown","Korea (North)","Unknown","Unknown","non-EU"),
			"Korea (South)"				=> array("KOR","Unknown","Korea (South)","Unknown","Unknown","non-EU"),
			"Kuwait"				=> array("KWT","KW","Kuwait","KWD","Dinars","non-EU"),
			"Kyrgyzstan"				=> array("KGZ","KG","Kyrgyzstan","KGS","Soms","non-EU"),
			"Laos"					=> array("LAO","Unknown","Laos","LAK","Kips","non-EU"),
			"Latvia"				=> array("LVA","LV","Latvia","LVL","Lati","EU"),
			"Lebanon"				=> array("LBN","LB","Lebanon","LBP","Pounds","non-EU"),
			"Lesotho"				=> array("LSO","LS","Lesotho","LSL","Maloti","non-EU"),
			"Liberia"				=> array("LBR","LR","Liberia","LRD","Dollars","non-EU"),
			"Libya"					=> array("LBY","Unknown","Libya","LYD","Dinars","non-EU"),
			"Liechtenstein"				=> array("LIE","LI","Liechtenstein","Unknown","Unknown","non-EU"),
			"Lithuania"				=> array("LTU","LT","Lithuania","LTL","Litai","EU"),
			"Luxembourg"				=> array("LUX","LU","Luxembourg","Unknown","Unknown","EU"),
			"Macau"					=> array("MAC","MO","Macau","MOP","Patacas","non-EU"),
			"Macedonia"				=> array("MKD","MK","Macedonia","MKD","Denars","non-EU"),
			"Madagascar"				=> array("MDG","MG","Madagascar","MGA","Ariary","non-EU"),
			"Malawi"				=> array("MWI","MW","Malawi","MWK","Kwachas","non-EU"),
			"Malaysia"				=> array("MYS","MY","Malaysia","MYR","Ringgits","non-EU"),
			"Maldives (Maldive Islands)"		=> array("MDV","Unknown","Maldives (Maldive Islands)","Unknown","Unknown","non-EU"),
			"Mali"					=> array("MLI","ML","Mali","SOS","Somalia, Shillings","non-EU"),
			"Malta"					=> array("MLT","MT","Malta","MTL","Liri","EU"),
			"Marshall Islands"			=> array("MHL","MH","Marshall Islands","Unknown","Unknown","non-EU"),
			"Martinique"				=> array("MTQ","MQ","Martinique","Unknown","Unknown","non-EU"),
			"Mauritania"				=> array("MRT","MR","Mauritania","MRO","Ouguiyas","non-EU"),
			"Mauritius"				=> array("MUS","MU","Mauritius","MUR","Rupees","non-EU"),
			"Mayotte"				=> array("MYT","YT","Mayotte","Unknown","Unknown","non-EU"),
			"Mexico"				=> array("MEX","MX","Mexico","MXN","Pesos","non-EU"),
			"Micronesia (Federated States of)"	=> array("FSM","Unknown","Micronesia (Federated States of)","Unknown","Unknown","non-EU"),
			"Moldova"				=> array("MDA","MD","Moldova","MDL","Lei","non-EU"),
			"Monaco"				=> array("MCO","MC","Monaco","Unknown","Unknown","non-EU"),
			"Mongolia"				=> array("MNG","MN","Mongolia","MNT","Tugriks","non-EU"),
			"Montserrat"				=> array("MSR","MS","Montserrat","Unknown","Unknown","non-EU"),
			"Morocco"				=> array("MAR","MA","Morocco","MAD","Dirhams","non-EU"),
			"Mozambique"				=> array("MOZ","MZ","Mozambique","MZM","Meticais","non-EU"),
			"Myanmar (Burma)"			=> array("MMR","Unknown","Myanmar (Burma)","Unknown","Unknown","non-EU"),
			"Namibia"				=> array("NAM","NA","Namibia","NAD","Dollars","non-EU"),
			"Nauru"					=> array("NRU","NR","Nauru","Unknown","Unknown","non-EU"),
			"Nepal"					=> array("NPL","NP","Nepal","NPR","Nepal Rupees","non-EU"),
			"Netherlands (The)"			=> array("NLD","Unknown","Netherlands (The)","Unknown","Unknown","EU"),
			"Netherlands Antilles"			=> array("ANT","AN","Netherlands Antilles","ANG","Guilders (also called Florins)","non-EU"),
			"New Caledonia"				=> array("NCL","NC","New Caledonia","Unknown","Unknown","non-EU"),
			"New Zealand"				=> array("NZL","NZ","New Zealand","NZD","Dollars","non-EU"),
			"Nicaragua"				=> array("NIC","NI","Nicaragua","NIO","Cordobas","non-EU"),
			"Niger"					=> array("NER","NE","Niger","NGN","Nigeria, Nairas","non-EU"),
			"Nigeria"				=> array("NGA","NG","Nigeria","NGN","Nairas","non-EU"),
			"Niue"					=> array("NIU","NU","Niue","Unknown","Unknown","non-EU"),
			"Norfolk Island"			=> array("NFK","NF","Norfolk Island","Unknown","Unknown","non-EU"),
			"Northern Mariana Islands"		=> array("MNP","MP","Northern Mariana Islands","Unknown","Unknown","non-EU"),
			"Norway"				=> array("NOR","NO","Norway","NOK","Krone","non-EU"),
			"Oman"					=> array("OMN","OM","Oman","OMR","RON","Rials"),
			"Pakistan"				=> array("PAK","PK","Pakistan","PKR","Rupees","non-EU"),
			"Palau"					=> array("PLW","PW","Palau","Unknown","Unknown","non-EU"),
			"Panama"				=> array("PAN","PA","Panama","PAB","Balboa","non-EU"),
			"Papua New Guinea"			=> array("PNG","PG","Papua New Guinea","PGK","Kina","non-EU"),
			"Paraguay"				=> array("PRY","PY","Paraguay","PYG","Guarani","non-EU"),
			"Peru"					=> array("PER","PE","Peru","PEN","Nuevos Soles","non-EU"),
			"Philippines"				=> array("PHL","PH","Philippines","PHP","Pesos","non-EU"),
			"Pitcairn Islands"			=> array("PCN","Unknown","Pitcairn Islands","Unknown","Unknown","non-EU"),
			"Poland"				=> array("POL","PL","Poland","PLN","Zlotych","EU"),
			"Portugal"				=> array("PRT","PT","Portugal","Unknown","Unknown","EU"),
			"Sao Tome and Principe"			=> array("STP","Unknown","Sao Tome and Principe","Unknown","Unknown","non-EU"),
			"Puerto Rico"				=> array("PRI","PR","Puerto Rico","Unknown","Unknown","non-EU"),
			"Qatar"					=> array("QAT","QA","Qatar","QAR","Rials","non-EU"),
			"Reunion"				=> array("REU","RE","Reunion","Unknown","Unknown","non-EU"),
			"Romania"				=> array("ROM","RO","Romania","RON","New Lei","non-EU"),
			"Russian Federation"			=> array("RUS","RU","Russian Federation","Unknown","Unknown","non-EU"),
			"Rwanda"				=> array("RWA","RW","Rwanda","RWF","Rwanda Francs","non-EU"),
			"Sahara (Western)"			=> array("ESH","Unknown","Sahara (Western)","Unknown","Unknown","non-EU"),
			"Saint Helena"				=> array("SHN","SH","Saint Helena","SHP","Pounds","non-EU"),
			"Saint Kitts and Nevis"			=> array("KNA","Unknown","Saint Kitts and Nevis","Unknown","Unknown","non-EU"),
			"Saint Lucia"				=> array("LCA","LC","Saint Lucia","Unknown","Unknown","non-EU"),
			"Saint Pierre and Miquelon"		=> array("SPM","PM","Saint Pierre and Miquelon","Unknown","Unknown","non-EU"),
			"Saint Vincent and The Grenadines"	=> array("VCT","Unknown","Saint Vincent and The Grenadines","Unknown","Unknown","non-EU"),
			"San Marino"				=> array("SMR","SM","San Marino","Unknown","Unknown","non-EU"),
			"Saudi Arabia"				=> array("SAU","SA","Saudi Arabia","SAR","Riyals","non-EU"),
			"Senegal"				=> array("SEN","SN","Senegal","Unknown","Unknown","non-EU"),
			"Seychelles"				=> array("SYC","SC","Seychelles","SCR","Rupees","non-EU"),
			"Sierra Leone"				=> array("SLE","SL","Sierra Leone","SLL","Leones","non-EU"),
			"Singapore"				=> array("SGP","SG","Singapore","SGD","Dollars","non-EU"),
			"Slovakia"				=> array("SVK","Unknown","Slovakia","SKK","Koruny","EU"),
			"Slovenia"				=> array("SVN","SI","Slovenia","SIT","Tolars","EU"),
			"Solomon Islands"			=> array("SLB","SB","Solomon Islands","SBD","Dollars","non-EU"),
			"Somalia"				=> array("SOM","SO","Somalia","SOS","Shillings","non-EU"),
			"South Africa"				=> array("ZAF","ZA","South Africa","ZAR","Rand","non-EU"),
			"South Sandwich Islands"		=> array("SGS","Unknown","South Sandwich Islands","Unknown","Unknown","non-EU"),
			"Spain"					=> array("ESP","ES","Spain","Unknown","Unknown","EU"),
			"Sri Lanka"				=> array("LKA","LK","Sri Lanka","LKR","Rupees","non-EU"),
			"Sudan"					=> array("SDN","SD","Sudan","SDD","Dinars","non-EU"),
			"Suriname"				=> array("SUR","SR","Suriname","SRD","Dollars","non-EU"),
			"Swaziland"				=> array("SWZ","SZ","Swaziland","SZL","Emalangeni","non-EU"),
			"Sweden"				=> array("SWE","SE","Sweden","SEK","Kronor","EU"),
			"Switzerland"				=> array("CHE","CH","Switzerland","CHF","Francs","non-EU"),
			"Syria"					=> array("SYR","Unknown","Syria","SYP","Pounds","non-EU"),
			"Taiwan"				=> array("TWN","TW","Taiwan","TWD","New Dollars","non-EU"),
			"Tajikistan"				=> array("TJK","TJ","Tajikistan","TJS","Somoni","non-EU"),
			"Tanzania"				=> array("TZA","TZ","Tanzania","TZS","Shillings","non-EU"),
			"Thailand"				=> array("THA","TH","Thailand","THB","Baht","non-EU"),
			"Trinidad and Tobago"			=> array("TTO","Unknown","Trinidad and Tobago","TTD","Dollars","non-EU"),
			"Togo"					=> array("TGO","TG","Togo","Unknown","Unknown","non-EU"),
			"Tokelau"				=> array("TKL","TK","Tokelau","Unknown","Unknown","non-EU"),
			"Tonga"					=> array("TON","TO","Tonga","TOP","Pa'anga","non-EU"),
			"Tunisia"				=> array("TUN","TN","Tunisia","TND","Dinars","non-EU"),
			"Turkey"				=> array("TUR","TR","Turkey","TRL","TRY","Liras [being phased out]"),
			"Turkmenistan"				=> array("TKM","TM","Turkmenistan","TMM","Manats","non-EU"),
			"Tuvalu"				=> array("TUV","TV","Tuvalu","TVD","Tuvalu Dollars","non-EU"),
			"Uganda"				=> array("UGA","UG","Uganda","UGX","Shillings","non-EU"),
			"Ukraine"				=> array("UKR","UA","Ukraine","UAH","Hryvnia","non-EU"),
			"United Arab Emirates"			=> array("ARE","AE","United Arab Emirates","AED","Dirhams","non-EU"),
			"United Kingdom"			=> array("GBR","GB","United Kingdom","GBP","Pounds","non-EU"),
			"United States Minor Outlying Islands"	=> array("UMI","UM","United States Minor Outlying Islands","Unknown","Unknown","non-EU"),
			"United States of America"		=> array("USA","Unknown","United States of America","USD","Dollars","non-EU"),
			"Uruguay"				=> array("URY","UY","Uruguay","UYU","Pesos","non-EU"),
			"US Virgin Islands"			=> array("VIR","Unknown","US Virgin Islands","Unknown","Unknown","non-EU"),
			"Uzbekistan"				=> array("UZB","UZ","Uzbekistan","UZS","Sums","non-EU"),
			"Vanuatu"				=> array("VUT","VU","Vanuatu","VUV","Vatu","non-EU"),
			"Vatican City (The Holy See)"		=> array("VAT","Unknown","Vatican City (The Holy See)","Unknown","Unknown","non-EU"),
			"Venezuela"				=> array("VEN","VE","Venezuela","VEB","Bolivares","non-EU"),
			"Viet Nam"				=> array("VNM","VN","Viet Nam","VND","Dong","non-EU"),
			"Wallis and Futuna Islands"		=> array("WLF","Unknown","Wallis and Futuna Islands","Unknown","Unknown","non-EU"),
			"Western Samoa"				=> array("WSM","Unknown","Western Samoa","Unknown","Unknown","non-EU"),
			"Yemen"					=> array("YEM","YE","Yemen","YER","Rials","non-EU"),
			"Yugoslavia"				=> array("YUG","YU","Yugoslavia","Unknown","Unknown","non-EU"),
			"Zambia"				=> array("ZMB","ZM","Zambia","ZMK","Kwacha","non-EU"),
			"Zimbabwe"				=> array("ZWE","ZW","Zimbabwe","ZWD","Zimbabwe Dollars","non-EU"),
		);
		
	}
	
	/**
	 * Read timezone information from data file and present as associative array.
	 * 
	 * This function requires the timezones.csv data file, the path to which
	 * must be set in $this->tzi_path before being called
	 * 
	 * @return mixed		- associative array of timezone information, or false if the data file path was invalid
	 * @access public
	 */
	public function timezone_info() {

		// check that path to data is valid
		if (!is_file($this->tzi_path)) return false;

		// open data file
		$csv = fopen($this->tzi_path,"r");

		// create timezones array
		$timezones = array();
		
		// ordered list of field names
		$fields = array(
			"continent","city","offset","shortname","dstshortname","longname","dstlongname","st_offset",
			"st_startmonth","st_startday","st_starttime","st_endmonth","st_endday","st_endtime"
		);

		while (($data = fgetcsv($csv)) !== false) {
			
			$id = array_shift($data);
			$tz = array();
			
			for ($i=0; $i<count($fields); $i++) {
				$tz[$fields{$i}] = $data[$i];
			}
			
			$timezones[$id] = $tz;
			
		}

		// close data file
		fclose($csv);

		// return information array
		return $timezones;
		
	}
	
	/**
	 * Dump superglobal arrays.
	 * 
	 * @param string $file		- (optional) dump superglobals to a file instead of stdout (pass path to file)
	 * 
	 * @return string		- dump data
	 * @access public
	 */
	public function dump_superglobals($file=false) {

		// generate dump
		$dump	= "POST: ".print_r($_POST,true)."\n";
		$dump .= "GET: ".print_r($_GET,true)."\n";
		$dump .= "SERVER: ".print_r($_SERVER,true)."\n";
		$dump .= "SESSION: ".print_r($_SESSION,true)."\n";
		
		if ($file) {
			
			// dump to a file
			$fh = fopen($file,"w");
			fwrite($fh,$dump);
			fclose($fh);
		
		} else {
			
			// dump normally
			return $dump;
			
		}
		
	}
	
	/**
	 * Format XML document for easier reading.
	 * 
	 * @param string $xml			- XML code
	 * @param boolean $html_output		- (optional) set to true to produce HTML output
	 * 
	 * @return string			- formatted XML document
	 * @access public
	 */
	public function format_XML($xml,$html_output=false) {
		
		$xml_obj = new SimpleXMLElement($xml);
		$level = 8;
		$indent = 0; // current indentation level
		$pretty = array();
		
		// get an array containing each XML element
		$xml = explode("\n", preg_replace('/>\s*</', ">\n<", $xml_obj->asXML()));
	
		// shift off opening XML tag if present
		if (count($xml) && preg_match('/^<\?\s*xml/', $xml[0])) {
			$pretty[] = array_shift($xml);
		}
	
		foreach ($xml as $el) {
			if (preg_match('/^<([\w])+[^>\/]*>$/U', $el)) {
				// opening tag, increase indent
				$pretty[] = str_repeat(' ', $indent) . $el;
				$indent += $level;
				} else {
				if (preg_match('/^<\/.+>$/', $el)) {			
					$indent -= $level;	// closing tag, decrease indent
				}
				if ($indent < 0) {
					$indent += $level;
				}
				$pretty[] = str_repeat(' ', $indent) . $el;
			}
		}
		
		$xml = implode("\n", $pretty);	 
		
		if ($html_output) {
			return htmlentities($xml);
		} else {
			return $xml;
		}

	}

	/**
	 * Convert a multi-dimensional array into an XML document.
	 *
	 * @param array $data			- array to convert
	 * @param string $rootnodename		- (optional) root node name to be (default "data")
	 * @param SimpleXMLElement $xml		- used for recursion
	 * 
	 * @return string			- formatted XML document
	 * @access public
	 */
	public function array2xml($data,$rootnodename="data",$xml=null) {
		
		// turn off compatibility mode otherwise SimpleXML will not work properly
		if (ini_get('zend.ze1_compatibility_mode') == 1) ini_set ('zend.ze1_compatibility_mode', 0);
		
		// begin XML document
		if ($xml == null) $xml = simplexml_load_string("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<$rootnodename />");
		
		// loop through the data passed in
		foreach ($data as $key => $value) {

			// cannot have numeric keys in XML
			if (is_numeric($key)) $key = "id_". (string) $key;
			
			// replace anything non-alpha-numeric (except underscores)
			$key = preg_replace("/[^a-z0-9_]/i","",$key);
			
			// if there is another array found, recurse
			if (is_array($value)) {
				$node = $xml->addChild($key);
				$this->array2xml($value,$rootnodename,$node);
			} else 	{
				// add single node.
				$value = htmlentities($value);
				$xml->addChild($key,$value);
			}
			
		}
		
		// return formatted XML document
		return $this->format_XML($xml->asXML());
		
	}
	
	/**
	 * Converts XML document into an array.
	 * 
	 * @param string $contents		- XML code
	 * @param boolean $get_attributes	- (optional) set to false to not include attributes
	 * 
	 * @return array			- data structure
	 * @access public
	 */
	public function xml2array($contents,$get_attributes=true) {
		
		// check we have what we need
		if (!$contents) return false;
		if(!function_exists('xml_parser_create')) return false;
		
		// get the XML parser of PHP - PHP must have this module for the parser to work
		$parser = xml_parser_create();
		xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
		xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
		xml_parse_into_struct($parser,$contents,$xml_values);
		xml_parser_free($parser);
		if (!$xml_values) return false;
	
		// initializations
		$xml_array = array();
		$parents = array();
		$opened_tags = array();
		$arr = array();
		$current = &$xml_array;
	
		// process the tags
		foreach ($xml_values as $data) {
			
			// remove existing values, or there will be trouble
			unset($attributes,$value);
	
			// this command will extract these variables into the foreach scope
			// tag(string), type(string), level(int), attributes(array).
			extract($data);
	
			$result = '';
			
			if ($get_attributes) {
				
				$result = array();
				if (isset($value)) $result['value'] = $value;
	
				// set the attributes too
				if (isset($attributes)) {
					foreach ($attributes as $attr => $val) {
						if ($get_attributes) {
							// set all the attributes in a array called '@attributes'
							$result['@attributes'][$attr] = $val; 
						}
					}
				}
				
			} elseif (isset($value)) {
				
				$result = $value;
				
			}
	
			// see tag status and do the needed.
			if ($type == "open") {
				
				$parent[$level-1] = &$current;
	
				if (!is_array($current) or (!in_array($tag, array_keys($current)))) {
					
					// unsert New tag
					$current[$tag] = $result;
					$current = &$current[$tag];
	
				} else {
					
					// there was another element with the same tag name
					if (isset($current[$tag][0])) {
						array_push($current[$tag], $result);
					} else {
						$current[$tag] = array($current[$tag],$result);
					}
					
					$last = count($current[$tag]) - 1;
					$current = &$current[$tag][$last];
					
				}
	
			} elseif ($type == "complete") {

				// tags that ends in 1 line '<tag />'
				
				// see if the key is already taken.
				if (!isset($current[$tag])) {
					
					// new Key
					$current[$tag] = $result;
	
				} else {
					
					// if taken, put all things inside a list(array)
					if ((is_array($current[$tag]) and !$get_attributes)
							or (isset($current[$tag][0]) and is_array($current[$tag][0]) and $get_attributes)) {
						array_push($current[$tag],$result);
					} else {
						// make it an array using using the existing value and the new value
						$current[$tag] = array($current[$tag],$result); 
					}
					
				}
	
			} elseif ($type == 'close') {
				
				// end of tag '</tag>'
				$current = &$parent[$level-1];
				
			}
		}
	
		// return array
		return($xml_array);
		
	}

	/**
	 * Converts a given ascii string to hexidecimal.
	 * 
	 * @param string $str			- string to convert
	 * 
	 * @return string			- hexidecimal data
	 * @access public
	 */
	public function asc2hex($str) {
		for ($i=0; $i<strlen($str); $i++) $data .= sprintf("%02x",ord(substr($str,$i,1)));
		return $data;
	}
	
	/**
	 * Converts a given hexidecimal string to ascii.
	 * 
	 * @param string $hex			- hexidecimal data
	 * 
	 * @return string			- ascii string
	 * @access public
	 */
	public function hex2asc($hex) {
		for ($i=0; $i<strlen($hex); $i+=2) $data .= chr(hexdec(substr($hex,$i,2)));
		return $data;
	}

	/**
	 * Calculates a rough "match percentage" between a list of keywords and a string of text.
	 * 
	 * @param string/array $keywords	- keywords (if an array is passed it's flattenened out to a space-separated string)
	 * @param string $text			- comparison text
	 * 
	 * @return integer			- percentage, or false if there was a problem
	 * @access public
	 */
	public function calculate_match_percentage($keywords,$text) {
		
		// check input
		if (!$keywords || !$text) {
			return false;
		}
		
		// flatten string of keywords if necessary
		if (is_array($keywords)) {
			$keywords = implode(" ",$keywords);
		}
		
		// calculate match percentage using PHP's built-in function
		$sim = similar_text(strtolower($keywords),strtolower($text),$pc);
		$simpc = sprintf("%0d",$pc);
		
		// return percentage
		return $simpc;
		
	}

	/**
	 * Validates a password against a set of standard rules.
	 * 
	 * @param string $password		- the password to validate
	 * @param boolean $confirm		- (optional) if a password confirmation was demanded, pass the confirmed password here, if omitted then confirmation comparison will not be performed
	 * 
	 * @return boolean			- false if the password was valid, otherwise an array of reasons why it was invalid
	 * @access public
	 */
	public function invalid_password($password,$confirm=false) {

		// create array for failure reasons
		$fails = array();
	
		// check confirmation
		if ($confirm) {
			if ($password != $confirm) {
				array_push($fails,"The two passwords you have entered do not match. You must enter the same password into the confirmation box.");
			}
		}
		
		// check length
		if (strlen($password) < 6) {
			array_push($fails,"The password you have entered is too short.");	
		}
		
		// add general advice if there are fails
		if (count($fails) > 0) {
			array_push($fails,"Passwords must be at least six characters in length.");
			array_push($fails,"Passwords are case sensitive. Ensure that you do not have your 'caps lock' switched on before typing your password.");	
		}
		
		// return verdict
		if (count($fails) > 0) {
			return $fails;
		} else {
			return false;
		}
		
	}

	/**
	 * Checks list of tables for the presence of a given e-mail address.
	 * 
	 * @param array $tables			- array of table names to check
	 * @param array $email			- e-mail address to check
	 * @param array $field			- (optional) field name to check (defaults to "email")
	 * 
	 * @return boolean			- true if the e-mail address is not present, and therefore unique, or false otherwise
	 * @access public
	 */
	public function check_unique_email($tables,$email,$field="email") {
		
		// initialise database
		$db = DB::Instance();

		// check array of user tables to check - each must have an "email" field
		if (count($tables) == 0) return false;
		
		// ensure it's an e-mail address that's been passed
		if (!$this->is_email_address($email)) return false;
		
		// scan each table
		foreach ($tables as $table) {
			if ($db->GetOne("SELECT {$field} FROM {$table} WHERE {$field} = '{$email}';")) {
				return false;
			}
		}
		
		// seems to be unique across all tables
		return true;
		
	}
	
	/**
	 * Determines whether a given string is an e-mail address.
	 * 
	 * @param string $string		- string to check
	 * 
	 * @return boolean			- true if it's an e-mail address, otherwise false
	 * @access public
	 */
	public function is_email_address($string) {

		// check that there's one @ symbol, and that the lengths in each section are correct
		if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/",$string)) return false;

		// split the address into sections
		$email_array = explode("@",$string);
		$local_array = explode(".",$email_array[0]);

		for ($i=0; $i<count($local_array); $i++) {
			if (preg_match("/^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/",$local_array[$i])) {
				return false;
			}
		}

		if (!preg_match("/^\[?[0-9\.]+\]?$/",$email_array[1])) {
			
			// check if domain is IP, if not, it should be valid domain name
			$domain_array = explode(".", $email_array[1]);

			// must be at least two parts to the domain
			if (count($domain_array) < 2) return false;

			for ($i=0; $i<count($domain_array); $i++) {
				if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/",$domain_array[$i])) {
					return false;
				}
			}

		}

		return true;
		
	}	
	
	/**
	 * Determines whether a given string is a valid MAC address.
	 * 
	 * @param string $mac			- MAC address to validate
	 * 
	 * @return boolean			- true if valid, otherwise false
	 * @access public
	 */
	public function is_mac_address($mac) {
		if (preg_match('/[A-Z]{4}[0-9]{7,9}\/[A-Z]{2}[0-9]{2}[A-Z]$/',$mac)) return true;
		return false;
	}
	
	/**
	 * Determines whether a given string is a valid UK mobile number.
	 *
	 * @param string $mobile		- mobile number to check
	 * 
	 * @return boolean			- true if valid, otherwise false
	 * @access public
	 */
	public function is_uk_mobile($mobile) {
		$mobile = preg_replace("/ /","",$mobile);
		if (preg_match('/^((\+447)|07|00447)[0-9]{9}$/',$mobile)) return true;
		return false;
	}
	
	/**
	 * Generates a menu of countries.
	 * 
	 * @param string $name			- name and ID of form field
	 * @param string $codelength		- set to "ISO2" to use two letter country codes in the option values, or "ISO3" to use three letter ISO codes
	 * @param string $presel		- (optional) country to which menu should be pre-selected, omit to use GBR
	 * @param string $cssclass		- (optional) CSS class to apply to the form element
	 * @param string $onchange		- (optional) Javascript code to insert into "onchange" attribute, if required
	 * 
	 * @return string			- HTML code for menu
	 * @access public
	 */
	public function country_menu($name,$codelength,$presel=false,$cssclass=false,$onchange=false) {

		// set default preselection
		if (!$presel) {
			if ($codelength == "ISO2") $presel = "GB";
			if ($codelength == "ISO3") $presel = "GBR";
		}
		
		// begin HTML
		$html = "<select name=\"$name\" id=\"$name\" ";
		if ($cssclass) $html .= "class=\"{$cssclass}\"";
		if ($onchange) $html .= "onchange=\"{$onchange}\"";
		$html .= ">\n";
		
		foreach ($this->country_database() as $countryname => $countryinfo) {
			
			if ($codelength == "ISO2") {
				$code = $countryinfo[1];
			} else {
				$code = $countryinfo[0];
			}
			
			$html .= "<option value=\"$code\"";
			if ($code == $presel) $html .= " selected";
			$html .= ">$countryname</option>\n";	
		}
		
		// return HTML
		return $html."</select>\n";
		
	}
	
	/**
	 * Generates a menu of UK counties.
	 * 
	 * @param string $name			- name and ID of form element
	 * @param string $presel		- (optional) county to which menu should be pre-selected
	 * @param string $cssclass		- (optional) CSS class to apply to the form element
	 * @param string $onchange		- (optional) Javascript code to insert into "onchange" attribute, if required
	 * 
	 * @return string			- HTML code for menu
	 * @access public
	 */
	public function county_menu($name,$presel=false,$cssclass=false,$onchange=false) {
	
		// begin HTML
		$html = "<select name=\"$name\" id=\"$name\" ";
		if ($cssclass) $html .= "class=\"{$cssclass}\"";
		if ($onchange) $html .= "onchange=\"{$onchange}\"";
		$html .= ">\n";
		
		// add non-county options
		$html .= "<option value=\"\">Please select ...</option>\n";
		$html .= "<option value=\"OUK\">Outside United Kingdom</option>\n";
		
		// add counties
		foreach ($this->uk_counties as $countyname) {
			
			$html .= "<option value=\"$countyname\"";
			if ($countyname == $presel) $html .= " selected";
			$html .= ">$countyname</option>\n";
			
		}
		
		// return HTML
		return $html."</select>\n";
		
	}

	/**
	 * Retrieves country information from either 2 or 3 letter country code.
	 * 
	 * @param string $code			- 2 or 3 letter country code
	 * 
	 * @return array			- array of country information, or false if not found
	 * @access public
	 */
	public function country_info($code) {

		// check input
		if (strlen($code) < 2 && strlen($code) > 3) return false;
		
		// search for country data
		foreach ($this->country_database() as $name => $data) {
			if (strlen($code) == 2 && $data[1] == $code) { return $data; }	
			if (strlen($code) == 3 && $data[0] == $code) { return $data; }	
		}
		
		// no data found, invalid code
		return false;
		
	}
	
	/**
	 * Generates a password.
	 * 
	 * @return string			- generated password
	 * @access public
	 */
	public function generate_password() {

		$salt = "abcdefghjkmnpqrstuvwxyz0123456789";
		srand((double)microtime()*1000000);
		
		$i = 0;
		while ($i <= 7) {
			$num = rand() % 33;
			$tmp = substr($salt, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		
		return $pass;
		
	}
	
	/**
	 * Adds the correct suffix ("st", "nd", "rd" or "th") to a day of the month.
	 * 
	 * @param integer $day			- (optional) the day of the month (1 to 31), omit to use today's date
	 * 
	 * @return string			- formatted day number
	 * @access public
	 */
	public function day_suffix($day=false) {
		
		if (!$day) $day = date("d");

		if (substr($day,strlen($day)-1) == "1") return $day."st";
		if (substr($day,strlen($day)-1) == "2") return $day."nd";
		if (substr($day,strlen($day)-1) == "3") return $day."rd";
			
		return $day."th";
		
	}

	/**
	 * Converts a hexidecimal colour reference to separate RGB values.
	 * 
	 * @param string $hexcol		- hexidecimal colour reference, with or without preceding #
	 * 
	 * @return array			- array of elements (in order) red, green, blue
	 * @access public
	 */
	public function hex2rgb($hexcol) {
		
		$hexcol = preg_replace("/\#/","",$hexcol);
		$rgb = array();
	
		$rgb[0] = hexdec(substr($hexcol,0,2));
		$rgb[1] = hexdec(substr($hexcol,2,2));
		$rgb[2] = hexdec(substr($hexcol,4,2));
	
		return $rgb;
	
	}
	
	/**
	 * Determines whether a given string is an ISO date (YYYY-MM-DD).
	 * 
	 * @param string $string		- string to check
	 * @param boolean $withtime		- (optional) set to true to check for time in addition (YYYY-MM-DD HH:MM:SS)
	 * 
	 * @return boolean			- true if it's an ISO date [and time], otherwise false
	 * @access public
	 */
	public function is_iso_date($string,$withtime=false) {
		
		if ($withtime) {
			$regexp = "/^[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9] [0-9][0-9]:[0-9][0-9]:[0-9][0-9]/";
		} else {
			$regexp = "/^[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]/";
		}
		
		if (preg_match($regexp,$string)) {
			return true;
		} else {
			return false;	
		} 
		
	}
	
	/**
	 * Translate a formatted date (dd/mm/yyyy) to an ISO date (yyyy-mm-dd).
	 * 
	 * This function will NOT validate your input.
	 * 
	 * @param string $formatted_date	- dd/mm/yyyy format date
	 * 
	 * @return string			- yyyy-mm-dd format date
	 * @access public
	 */
	public function iso_date($formatted_date) {
		$dp = explode("/",$formatted_date);
		return "{$dp[2]}-{$dp[1]}-{$dp[0]}";
	}
	
	/**
	 * Translate an ISO date (yyyy-mm-dd) to a human date (dd/mm/yyyy).
	 * 
	 * This function will NOT validate your input.
	 * 
	 * @param string $iso_date	- yyyy-mm-dd format date
	 * @param boolean $american	- (optional) set to true to return the date in silly American mm/dd/yyyy format (default false)
	 * 
	 * @return string		- dd/mm/yyyy format date, or mm/dd/yyyy if $american set to true
	 * @access public
	 */
	public function human_date($iso_date,$american=false) {
		
		$dp = explode("-",$iso_date);
		
		if ($american) {
			return "{$dp[1]}/{$dp[2]}/{$dp[0]}";
		} else {
			return "{$dp[2]}/{$dp[1]}/{$dp[0]}";
		}
		
	}
	
	/**
	 * Perform date calculations.
	 * 
	 * Essentially a shortcut to the cumbersome multiple lines of code that
	 * are required to do what should be simple date calculations.
	 * 
	 * @see http://www.php.net/manual/en/class.dateinterval.php
	 * 
	 * @param string $date		- date (ISO format)
	 * @param string $operator	- operator, either "add" or "sub"
	 * @param string $interval	- interval (see URL above)
	 * @param boolean $format	- (optional) set to true to return the calculated date in dd/mm/yyyy format
	 * 
	 * @return string		- calculated date (ISO format), or false if input was invalid
	 * @access public
	 */
	public function date_calculation($date,$operator,$interval,$format=false) {
		
		// check input
		if (!self::is_iso_date($date)) return false;
		if (!in_array($operator,array("add","sub"))) return false;
		
		// perform calculation
		$dt = new DateTime($date);
		$dt->$operator(new DateInterval($interval));
		
		// return date
		if ($format) {
			return $dt->format("d/m/Y");
		} else {
			return $dt->format("Y-m-d");
		}
		
	}
	
	/**
	 * Converts a number of minutes to the corresponding number of hours and minutes.
	 * 
	 * @param integer $mins			- number of minutes
	 * 
	 * @return array			- array, first element is the number of hours, second element is the number of minutes
	 * @access public
	 */
	public function mins2hours_and_mins($mins) {
		
		if ($mins < 0) {
			$min = abs($mins);
		} else {
			$min = $mins;
		}
		
		$H = floor($min / 60);
		$M = ($min - ($H * 60)) / 100;
		
		$hours = $H + $M;
		if ($mins < 0) $hours = $hours * (-1);
		
		$expl = explode(".", $hours);
		$H = $expl[0];
		
		if (empty($expl[1])) $expl[1] = 00;
		
		$M = $expl[1];
		if (strlen($M) < 2) $M = $M."0";
		
		return array(intval($H),intval($M));
	
	}
	
	/**
	 * Convert seconds to a string with hours, minutes and seconds.
	 * 
	 * Credit due to Jon Haworth.
	 * @see http://www.laughing-buddha.net/php/lib/sec2hms/
	 * 
	 * @param integer $sec			- seconds
	 * @param boolean $padhours		- (optional) pad hours with leading zero (default true)
	 * 
	 * @return string			- H:M:S string
	 * @access public
	 */
	public function seconds2hms($sec,$padhours=true) {
	
		// start with a blank string
		$hms = "";
		
		// do the hours first: there are 3600 seconds in an hour, so if we divide
		// the total number of seconds by 3600 and throw away the remainder, we're
		// left with the number of hours in those seconds
		$hours = intval(intval($sec) / 3600); 
	
		// add hours to $hms (with a leading 0 if asked for)
		$hms .= ($padhours) ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":" : $hours.":";
		
		// dividing the total seconds by 60 will give us the number of minutes
		// in total, but we're interested in *minutes past the hour* and to get
		// this, we have to divide by 60 again and then use the remainder
		$minutes = intval(($sec / 60) % 60); 
	
		// add minutes to $hms (with a leading 0 if needed)
		$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";
	
		// seconds past the minute are found by dividing the total number of seconds
		// by 60 and using the remainder
		$seconds = intval($sec % 60); 
	
		// add seconds to $hms (with a leading 0 if needed)
		$hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
	
		// done!
		return $hms;

	}
	
	/**
	 * Calculates number of months between two ISO format dates.
	 * 
	 * @param string $date_from		- start date (YYYY-MM-DD)
	 * @param string $date_to		- end date (YYYY-MM-DD)
	 * 
	 * @return integer			- number of months
	 * @access public
	 */
	public function months_in_date_range($date_from, $date_to) {

		$tmp_arr = explode("-",$date_from);
		$from_month = $tmp_arr[1];
		$from_year = $tmp_arr[0];
			
		$tmp_arr = explode("-",$date_to);
		$to_month = $tmp_arr[1];
		$to_year = $tmp_arr[0];
			
		// check the from year, if less than the to year then need to take this into account as it will affect number of months
		if ($from_year < $to_year) {
				
			// work out how many months till end of from_year and from start of to_year
			$monthsleft = (12 - $from_month);
				
			// possibility of more than 1 year difference so take this into account
			$year_gap = $to_year - $from_year;
				
			if ($year_gap > 1) {
				$months = (12*($year_gap-1)) + $monthsleft;
			} else {
				$months = $monthsleft;
			}
				
			// finally add the value of to_month to the months total
			$months += $to_month;
				
		} else {
				
			// same year so just work out the difference between the two months
			$months = ($to_month-$from_month) + 1;
				
		}
		
		return $months;
			
	}

	/**
	 * Creates XML to form an RSS feed. Remember to set the content type before calling.
	 * 
	 * @param string $title			- title
	 * @param string $description		- description of feed
	 * @param string $link			- general link to parent website
	 * @param string $editor		- managing editor (name and/or e-mail address (in brackets if name also used))
	 * @param string $feedlink		- URL of feed to be rendered
	 * @param array $items			- RSS items. Each element is an associative array containing the following fields: timestamp, category, title, description, link, author. Note that the item's content is passed in "description"
	 * 
	 * @return string			- RSS XML
	 * @access public
	 */
	public function create_rss_feed($title,$description,$link,$editor,$feedlink,$items) {
			
		// check input
		if (!$items || count($items) == 0) {
			return false;
		}
	
		// XML header
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$xml .= "<rss xmlns:atom='http://www.w3.org/2005/Atom' xmlns:openSearch='http://a9.com/-/spec/opensearchrss/1.0/' xmlns:georss='http://www.georss.org/georss' version='2.0'>";
		
		// define channel
		$xml .= "<channel>";
		$xml .= "<lastBuildDate>".strftime("%a, %d %b %Y %H:%M:%S +0000",time())."</lastBuildDate>";
		$xml .= "<title>{$title}</title>";
		$xml .= "<description>{$description}</description>";
		$xml .= "<link>{$link}</link>";
		$xml .= "<managingEditor>{$editor}</managingEditor>";
		$xml .= "<generator>RSSCreateFeed</generator>";
		$xml .= "<openSearch:totalResults>".count($items)."</openSearch:totalResults>";
		$xml .= "<openSearch:startIndex>1</openSearch:startIndex>";
		$xml .= "<openSearch:itemsPerPage>".count($items)."</openSearch:itemsPerPage>";
		$xml .= "<atom:link href=\"{$feedlink}\" rel=\"self\" type=\"application/rss+xml\"/>";
		
		// add items
		foreach ($items as $item) {
			$xml .= "<item>";
			$xml .= "<guid isPermaLink='false'>".md5("{$title}{$item['timestamp']}{$item['title']}")."</guid>";
			$xml .= "<pubDate>".strftime("%a, %d %b %Y %H:%M:%S +0000",$item["timestamp"])."</pubDate>";
			$xml .= "<atom:updated>".strftime("%Y-%m-%dT%H:%M:%S.0+00:00",$item["timestamp"])."</atom:updated>";
			$xml .= "<category domain='http://www.blogger.com/atom/ns#'>{$item["category"]}</category>";
			$xml .= "<title>{$item["title"]}</title>";
			$xml .= "<description>{$item["description"]}</description>";
			$xml .= "<link>{$item["link"]}</link>";
			$xml .= "<author>{$item["author"]}</author>";
			$xml .= "<thr:total xmlns:thr='http://purl.org/syndication/thread/1.0'>0</thr:total>";
			$xml .= "</item>";
		}
				
		// complete XML
		$xml .= "</channel>";
		$xml .= "</rss>";

		// return formatted XML
		return $this->format_XML($xml);
		
	}

	/**
	 * Generates a menu of timezones with values as UTC offsets.
	 * 
	 * @param string $name			- name and ID of form element
	 * @param string $presel		- (optional) timezone (record ID) to which menu should be pre-selected, If not passed then Europe/London is used
	 * @param string $cssclass		- (optional) set to true to apply the "wide" CSS class to the form element. Disregarded in DHTML mode
	 * 
	 * @return string			- HTML code for menu
	 * @access public
	 */
	public function timezone_menu($name,$presel=false,$cssclass=false) {
			
		// set default preselection
		if (!$presel) $presel = 419;

		// begin HTML
		$html = "<select name=\"$name\" id=\"$name\" ";
		if ($cssclass) $html .= "class=\"{$cssclass}\"";
		$html .= ">\n";
			
		// add timezones
		foreach ($this->timezone_info() as $id => $tzd) {
				
			// build label
			$label = sprintf("%s: %s (GMT+%d)",$tzd["continent"],$tzd["city"],($tzd["offset"]/3600000));
				
			// add menu option
			$html .= "<option value=\"{$id}\"";
			if ($id == $presel) $html .= " selected";
			$html .= ">$label</option>\n";
				
		}
		
		// complete HTML
		$html .= "</select>";
	
		// return menu code
		return $html;	
		
	}
	
	/**
	 * Count the number of pages in a PDF document.
	 * 
	 * @param string $fullpdfpath		- path to PDF document
	 * 
	 * @return integer			- number of pages in document, or false if file wasn't found or there weren't any pages
	 * @access public
	 */
	public function count_pdf_pages($fullpdfpath) {
		
		if (file_exists($fullpdfpath)) {
						
			// open the file for reading
			if ($handle = fopen($fullpdfpath, "rb")) {
				
				$count = 0;
				$i = 0;
				
				while (!feof($handle)) {
					
					if ($i > 0) {
						
						$contents .= fread($handle,8152);
						
					} else {
						
						// In some pdf files, there is an N tag containing the number of
						// of pages. This doesn't seem to be a result of the PDF version.
						// Saves reading the whole file if it's present.
						
						$contents = fread($handle, 1000);
				 		
						if (preg_match("/\/N\s+([0-9]+)/", $contents, $found)) return $found[1];
						
					}
					
					$i++;
					
				}
				
				fclose($handle);
				
				// get all the trees with 'pages' and 'count'. the biggest number
				// is the total number of pages, if we couldn't find the /N switch above.
								 
				if (preg_match_all("/Count\s+([0-9]+)/", $contents, $capture, PREG_SET_ORDER)) {
					
					foreach ($capture as $c) {
						if ($c[1] > $count) {
							$count = $c[1];
						}
					}
					
					return $count;	 
									 
				}
				
			}
			
		}
		
		// unable to determine the number of pages, or there simply isn't any
		return false;
			
	}

	/**
	 * Given a number of bytes, return the most appropriate representation of it in B, KB, MB, GB or TB.
	 * 
	 * @param unknown_type $number		- number to sizify
	 * 
	 * @return string			- suffixed number of bytes, kilobytes, megabytes, gigabytes or terabytes, or false if argument passed wasn't a number
	 * @access public
	 */
	public function data_sizify($number) {
		
		// check that argument is numeric
		if (!is_numeric($number)) return $number;
		
		if ($number < 1024) {
			return $number."B";
		} else if ($number < (1024*1024)) {
			return floor($number/1024)."KB";
		} else if ($number < (1024*1024*1024)) {
			return number_format($number/(1024*1024),2)."MB";
		} else if ($number < (1024*1024*1024*1024)) {
			return number_format($number/(1024*1024*1024),2)."TB";
		} else {
			return number_format($number/(1024*1024*1024*1024),2)."GB";
		}
		
	}
	
	/**
	 * Recursively build a multidimensional array representing a directory tree structure.
	 * 
	 * @param string $path			- path to directory
	 * @param boolean $ignore_rcs		- ignore revision control system directories (currently supports CVS and SVN)
	 * 
	 * @return array			- recursive associative array of files (with file sizes) and subdirectories, or false if path not found
	 * @access public
	 */
	public function directory_tree($path,$ignore_rcs=true) {
		
		// check that path exists
		if (!is_dir($path)) return false;
		
		$fso = array();
		$dh = opendir($path);
		
		// list of banned object names
		$banned_names = array(".","..","Thumbs.db");
		if ($ignore_rcs) {
			$rcs_files = array(".svn",".cvsignore");
			$banned_names = array_merge($banned_names,$rcs_files);	
		}
		
		// scan directory and recurse if necessary
		while (($file = readdir($dh) ) !== false) {
			if (!in_array($file,$banned_names)) {
				if (is_dir("$path/$file")) {
					$fso[$file] = $this->directory_tree("$path/$file",$ignore_rcs);
				} else {
					$fso[$file] = filesize("$path/$file");
				}
			}
		}
		
		closedir($dh);
		
		// return array
		return $fso;
		
	}
	
	/**
	 * Create a tag cloud.
	 * 
	 * @param array $data			- associative array of labels and importance integers
	 * @param string $baselink		- (optional) base hyperlink (default "#")
	 * @param string $cssclass		- (optional) CSS class apply (default "tag_cloud")
	 * @param integer $minfontsize		- (optional) minimum font size (default 10)
	 * @param integer $maxfontsize		- (optional) maximum font size (default 30)
	 * 
	 * @return string			- tag cloud HTML
	 * @access public
	 */
	public function tag_cloud($data = array(),$baselink="#",$cssclass="tag_cloud",$minfontsize=10,$maxfontsize=30) {
	
		// check data
		if (!is_array($data) || count($data) == 0) return false;
		
		$mincount = min($data);
		$maxcount = max($data);
		$spread = $maxcount-$mincount;
		$spread == 0 && $spread = 1;

		$cloudtags = array();
	
		foreach ($data as $tag => $count) {
			$size = $minfontsize + ($count-$mincount) * ($maxfontsize-$minfontsize) / $spread;
			$tag = htmlspecialchars(stripslashes($tag));
			$cloudtags[] = '<a style="font-size: '.floor($size).'px;" class="'.$cssclass.'" href="'.$baselink.$tag.'" title="\''.$tag.'\' returned a count of '.$count.'">'.$tag.'</a>';
		}
	
		// return combined array
		return join("\n",$cloudtags)."\n";
		
	}

	/**
	 * Add anchor HTML to URLs in a string.
	 * 
	 * This functions deserves credit to the fine folks at phpbb.com 
	 * 
	 * @param string $text			- text string
	 * 
	 * @return string			- text string with hyperlinks
	 * @access public
	 */
	public function clickable_links($text) {

		$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", $text);
		
		// pad it with a space so we can match things at the start of the 1st line.
		$ret = ' '.$text;
		
		// matches an "xxxx://yyyy" URL at the start of a line, or after a space.
		// xxxx can only be alpha characters.
		// yyyy is anything up to the first space, newline, comma, double quote or <
		$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is","\\1<a href=\"\\2\" target=\"_blank\">\\2</a>",$ret);
		
		// matches a "www|ftp.xxxx.yyyy[/zzzz]" kinda lazy URL thing
		// must contain at least 2 dots. xxxx contains either alphanum, or "-"
		// zzzz is optional, will contain everything up to the first space, newline, comma, double quote or <.
		$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is","\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>",$ret);
		
		// matches an email@domain type address at the start of a line, or after a space.
		// note: only the followed chars are valid; alphanums, "-", "_" and or ".".
		$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i","\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>",$ret);
		
		// remove our padding and return
		$ret = substr($ret,1);
		return $ret; 

	}

	/**
	 * Validate credit card number and return card type.
	 * 
	 * Optionally you can validate if it is a specific type.
	 *
	 * @param string $ccnumber		- credit card number
	 * @param string $cardtype		- (optional) credit card type to verify (see array list)
	 * @param string $allowtest		- (optional) allow test card number 411111111111111 (default false)
	 * 
	 * @return array			- associate array of card information, including its validity
	 * @access public
	 */
	public function validate_creditcard($ccnumber,$cardtype="",$allowtest=false) {
		
		// check for test card number
		if ($allowtest == false && $ccnumber == "4111111111111111") return false;
 
		// Strip non-numeric characters
		$ccnumber = preg_replace("/[^0-9]/","",$ccnumber);
 
		// array of card types and matching regular expressions
		$creditcard = array(
			'visa'		=>	"/^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/",
			'mastercard'	=>	"/^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/",
			'discover'	=>	"/^6011-?\d{4}-?\d{4}-?\d{4}$/",
			'amex'		=>	"/^3[4,7]\d{13}$/",
			'diners'	=>	"/^3[0,6,8]\d{12}$/",
			'bankcard'	=>	"/^5610-?\d{4}-?\d{4}-?\d{4}$/",
			'jcb'		=>	"/^[3088|3096|3112|3158|3337|3528]\d{12}$/",
			'enroute'	=>	"/^[2014|2149]\d{11}$/",
			'switch'	=>	"/^[4903|4911|4936|5641|6333|6759|6334|6767]\d{12}$/"
		);
 
		if (empty($cardtype)) {
			
			$match = false;
			foreach ($creditcard as $cardtype => $pattern) {
				if (preg_match($pattern,$ccnumber) ==1 ) {
					$match = true;
					break;
				}
			}
			
			if (!$match) return false;
			
		} elseif (preg_match($creditcard[strtolower(trim($cardtype))],$ccnumber) == 0) {
			
			return false;
			
		}		
 
		// build return array
		$return['valid'] = $this->luhn_check($ccnumber);
		$return['ccnum'] = $ccnumber;
		$return['type']	= $cardtype;
		
		return $return;
		
	}
 
	/**
	 * Perform a modulus 10 (Luhn algorithm) check.
	 * 
	 * More information on this algorithim can be found at:
	 * http://blog.phpkemist.com/2007/03/22/modulus-10-checking-with-php-programming/
	 *
	 * @param string $ccnum			- credit card number
	 * 
	 * @return boolean			- true if valid, otherwise false
	 * @access public
	 */
	public function luhn_check($ccnum) {
		
		$checksum = 0;
		for ($i=(2-(strlen($ccnum) % 2)); $i<=strlen($ccnum); $i+=2) {
			$checksum += (int)($ccnum{$i-1});
		}
 
		// analyze odd digits in even length strings or even digits in odd length strings
		for ($i=(strlen($ccnum) % 2)+1; $i<strlen($ccnum); $i+=2){ 
			$digit = (int)($ccnum{$i-1}) * 2;
			if ($digit < 10) {
				$checksum += $digit;
			} else {
				$checksum += ($digit-9);
			}
		}
 
		if (($checksum % 10) == 0) {
			return true; 
		} else {
			return false;
		}
		
	}

	/**
	 * Takes two or more arguments and returns the value of the first non-NULL argument.
	 * 
	 * If all the arguments evaluate to NULL, NULL is returned. One of those
	 * functions that should be part of PHP, so will be deleted from this
	 * library when it eventually makes it.
	 * 
	 * @param mixed $args			- two or more arguments
	 * 
	 * @return string			- coalesced string, or null
	 * @access public
	 */
	public function coalesce() {
	
		foreach (func_get_args() as $arg) {
			if (!empty($arg)) {
				return $arg;
			}
		}
		
		return null;
		
	}

	/**
	 * Calculate the date $interval working days from a date, not including bank holidays or weekends.
	 * 
	 * Recursive function with comprehensive United Kingdom bank holiday checker.
	 * Do not use stupidly large intervals!
	 * 
	 * @param integer $day			- day of start date
	 * @param integer $month		- month of start date
	 * @param integer $year			- year of start date
	 * @param integer $interval		- number of days
	 * 
	 * @return string			- calculated date
	 * @access public
	 */
	public function working_days_from($day,$month,$year,$interval) {
		
		// get date + 1 day
		$date = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year)+60*60*24);
		
		// array for bank holidays
		$bankhols = array();
		
		// New year's day
		switch (date("w", strtotime("$year-01-01 12:00:00"))) {
			case 6:
				$bankhols[] = "$year-01-03";
				break;
			case 0:
				$bankhols[] = "$year-01-02";
				break;
			default:
				$bankhols[] = "$year-01-01";
				break;
		}
		
		// Good Friday
		$bankhols[] = date("Y-m-d",strtotime( "+".(easter_days($year) - 2)." days",strtotime("$year-03-21 12:00:00")));
		
		// Easter Monday
		$bankhols[] = date("Y-m-d",strtotime( "+".(easter_days($year) + 1)." days",strtotime("$year-03-21 12:00:00")));
		
		// May Day
		if ($year == 1995) {
			// VE day 50th anniversary year exception
			$bankhols[] = "1995-05-08";
		} else {
			switch (date("w",strtotime("$year-05-01 12:00:00"))) {
			case 0:
				$bankhols[] = "$year-05-02";
				break;
			case 1:
				$bankhols[] = "$year-05-01";
				break;
			case 2:
				$bankhols[] = "$year-05-07";
				break;
			case 3:
				$bankhols[] = "$year-05-06";
				break;
			case 4:
				$bankhols[] = "$year-05-05";
				break;
			case 5:
				$bankhols[] = "$year-05-04";
				break;
			case 6:
				$bankhols[] = "$year-05-03";
				break;
			}
		}
		
		// Whitsun
		if ($year == 2002) {
			// exception year
			$bankhols[] = "2002-06-03";
			$bankhols[] = "2002-06-04";
		} else {
			switch (date("w",strtotime("$year-05-31 12:00:00"))) {
			case 0:
				$bankhols[] = "$year-05-25";
				break;
			case 1:
				$bankhols[] = "$year-05-31";
				break;
			case 2:
				$bankhols[] = "$year-05-30";
				break;
			case 3:
				$bankhols[] = "$year-05-29";
				break;
			case 4:
				$bankhols[] = "$year-05-28";
				break;
			case 5:
				$bankhols[] = "$year-05-27";
				break;
			case 6:
				$bankhols[] = "$year-05-26";
				break;
			}
		}
		
		// Summer Bank Holiday:
		switch (date("w", strtotime("$year-08-31 12:00:00"))) {
			case 0:
				$bankhols[] = "$year-08-25";
				break;
			case 1:
				$bankhols[] = "$year-08-31";
				break;
			case 2:
				$bankhols[] = "$year-08-30";
				break;
			case 3:
				$bankhols[] = "$year-08-29";
				break;
			case 4:
				$bankhols[] = "$year-08-28";
				break;
			case 5:
				$bankhols[] = "$year-08-27";
				break;
			case 6:
				$bankhols[] = "$year-08-26";
				break;
		}
		
		// Christmas
		switch (date("w", strtotime("$year-12-25 12:00:00"))) {
			case 5:
				$bankhols[] = "$year-12-25";
				$bankhols[] = "$year-12-28";
				break;
			case 6:
				$bankhols[] = "$year-12-27";
				$bankhols[] = "$year-12-28";
				break;
			case 0:
				$bankhols[] = "$year-12-26";
				$bankhols[] = "$year-12-27";
				break;
			default:
				$bankhols[] = "$year-12-25";
				$bankhols[] = "$year-12-26";
		}
		
		// Millenium eve
		if ($year == 1999) $bankhols[] = "1999-12-31";
		
		// William and Kate royal wedding
		if ($year == 2011) $bankhols[] = "2011-04-29";
		
		// Queen golden jubilee
		if ($year == 2002) $bankhols[] = "2002-06-03";
		
		// Queen diamond jubilee
		if ($year == 2012) $bankhols[] = "2012-06-05";
		
		if (date("l", mktime(0, 0, 0, $month, $day, $year)+60*60*24) == "Saturday" || date("l", mktime(0, 0, 0, $month, $day, $year)+60*60*24) == "Sunday") {
			// day is weekend, do not count as working day
			null;
		} elseif (in_array($date,$bankhols)) {
			// day is bank holiday, do not count
			null;
		} else {
			// this is a working day and counts towards the goal date
			$interval = $interval - 1;
		}

		if ($interval == 0) {
			// goal reached, return this date
			return $date;
		} else {
			// try the next date
			$nday = date("d",mktime(0, 0, 0, $month, $day, $year)+60*60*24);
			$nmonth = date("m",mktime(0, 0, 0, $month, $day, $year)+60*60*24);
			$nyear = date("Y",mktime(0, 0, 0, $month, $day, $year)+60*60*24);
			$date = $this->working_days_from($nday,$nmonth,$nyear,$interval);
		}
		
		// return calculated date
		return $date;
		
	}

	/**
	 * Convert objects into array.
	 *
	 * @param array $arrObjData		- object data
	 * @param array $arrSkipIndices		- used internally for recursion, do not pass
	 * 
	 * @return array			- converted array
	 * @access public
	 */
	public function object2array($arrObjData,$arrSkipIndices = array()) {

		$arrData = array();
		 
		// if input is object, convert into array
		if (is_object($arrObjData)) {
			$arrObjData = get_object_vars($arrObjData);
		}
		 
		if (is_array($arrObjData)) {
			foreach ($arrObjData as $index => $value) {
				if (is_object($value) || is_array($value)) {
					$value = $this->object2array($value, $arrSkipIndices); // recursive call
				}
				if (in_array($index, $arrSkipIndices)) continue;
				$arrData[$index] = $value;
			}
		}

		return $arrData;

	}

	/**
	 * Translate English text into Facebook drivel.
	 * 
	 * @param string $english		- English text, with proper spelling and punctuation, to translate.
	 * 
	 * @return string			- Translate text, or false if no text passed.
	 * @access public
	 */
	public function translate_to_facebook($english) {

		// setup
		$fb = stripslashes($english);
		
		// trap empty queries
		if (strlen($fb) == 0) return false;
		
		// remove all commas and apostrophes
		$fb = preg_replace("/\,/"," ",$fb);
		$fb = preg_replace("/\'/","",$fb);
		
		// replace all full stops with a couple of exclamation marks
		$fb = preg_replace("/\./","!! ",$fb);
		
		// simple word translations
		$fb = preg_replace("/ your /i"," ur ",$fb);
		$fb = preg_replace("/ you /i"," u ",$fb);
		$fb = preg_replace("/ to /i"," 2 ",$fb);
		$fb = preg_replace("/ this /i"," dis ",$fb);
		$fb = preg_replace("/ their /i"," there ",$fb);
		$fb = preg_replace("/ the /i"," teh ",$fb);
		$fb = preg_replace("/ theyre /i"," their ",$fb);
		$fb = preg_replace("/ are /i"," r ",$fb);
		$fb = preg_replace("/facebook/i","face book",$fb);
		$fb = preg_replace("/ some /i"," sum ",$fb);
		$fb = preg_replace("/ because /i"," cuz ",$fb);
		$fb = preg_replace("/ youre /i"," your ",$fb);
		
		// remove "g" from all words ending in "ing"
		$fb = preg_replace("/ing /i","in ",$fb);
	
		// replace all number words with numbers
		$fb = preg_replace("/ one /i"," 1 ",$fb);
		$fb = preg_replace("/ two /i"," 2 ",$fb);
		$fb = preg_replace("/ three /i"," 3 ",$fb);
		$fb = preg_replace("/ four /i"," 4 ",$fb);
		$fb = preg_replace("/ five /i"," 5 ",$fb);
		$fb = preg_replace("/ six /i"," 6 ",$fb);
		$fb = preg_replace("/ seven /i"," 7 ",$fb);
		$fb = preg_replace("/ eight /i"," 8 ",$fb);
		$fb = preg_replace("/ nine /i"," 9 ",$fb);
		$fb = preg_replace("/ ten /i"," 10 ",$fb);
		
		// similarly, replace all number-th words with numeric abbreviations
		$fb = preg_replace("/ first /i"," 1st ",$fb);
		$fb = preg_replace("/ second /i"," 2nd ",$fb);
		$fb = preg_replace("/ third /i"," 3rd ",$fb);
		$fb = preg_replace("/ fourth /i"," 4th ",$fb);
		$fb = preg_replace("/ fifth /i"," 5th ",$fb);
		$fb = preg_replace("/ sixth /i"," 6th ",$fb);
		$fb = preg_replace("/ seventh /i"," 7th ",$fb);
		$fb = preg_replace("/ eighth /i"," 8th ",$fb);
		$fb = preg_replace("/ nineth /i"," 9th ",$fb);
		$fb = preg_replace("/ tenth /i"," 10th ",$fb);
	
		// remove trailing space(s) and double spaces
		$fb = preg_replace("/	/"," ",$fb);
		$fb = rtrim($fb);
		
		// add random number of exclamation marks
		for ($i=1; $i<=rand(1,8); $i++) $fb = $fb."!";
		
		// and then a few 1s
		for ($i=1; $i<=rand(1,3); $i++) $fb = $fb."1";
		
		// and the compulsory LOL and kisses
		$fb = $fb." LOL xx";
	
		// lastly, convert to either all uppercase or all lowercase
		if (rand(1,4) <= 2) {
			$fb = strtoupper($fb);
		} else {
			$fb = strtolower($fb);
		}
		
		// replace ampersands
		$fb = preg_replace("/ and /"," &amp; ",$fb);
		
		// return translated
		return $fb;
	
	}

	/**
	 * Export an array of data as a CSV file.
	 * 
	 * @param array $data		- array of data, each element to be an associative array representing a row
	 * @param string filename	- (optional) file name, if omitted, one will be generated randomly
	 * @param boolean $header	- (optional) include header row (default true)
	 * @param boolean $http_headers	- (optional) send HTTP headers (default true)
	 * 
	 * @return void
	 * @access public
	 */
	public function alt_export($data,$filename=false,$header=true,$http_headers=true) {
		
		// create temporary filename
		$tmpname = "data-".time().".".rand(100000,999999).".csv";
		
		// create temporary CSV file
		$csv = fopen("/tmp/{$tmpname}","w");
		
		// add header row
		if ($header) {
			$egrow = array_shift($data);
			array_unshift($data,$egrow);
			fwrite($csv,implode(",",array_keys($egrow))."\n");
		}
		
		// add rows and close file
		foreach ($data as $id => $row) fwrite($csv,"\"".implode("\",\"",$row)."\"\n");
		fclose($csv);
		
		// set filename if one wasn't passed
		if (!$filename) $filename = $tmpname;
		
		// send HTTP headers
		if ($http_headers) {
			ob_start();
			header('Pragma: private');
			header('Content-Transfer-Encoding: binary');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-type: text/csv');
			header('Content-Disposition: attachment; filename='.$filename);
			header("Content-length: ".filesize("/tmp/{$tmpname}"));
			ob_end_flush();
		}
		
		// send CSV data
		print file_get_contents("/tmp/{$tmpname}");
		
		// remove temporary file
		unlink("/tmp/{$tmpname}");
		// remove temporary file
		unlink("/tmp/{$tmpname}");
		
	}
	
	/**
	 * Checks if a string is a valid UK postcode.
	 * 
	 * This function checks the value of the parameter for a valid postcode format. The 
	 * space between the inward part and the outward part is optional, although is 
	 * inserted if not there as it is part of the official postcode.
	 * 
	 * The functions returns a value of false if the postcode is in an invalid format, 
	 * and a value of true if it is in a valid format. If the postcode is valid, the 
	 * parameter is loaded up with the postcode in capitals, and a space between the 
	 * outward and the inward code to conform to the correct format.
	 * 
	 * Credit due to John Gardner.
	 * @see http://www.braemoor.co.uk/software/postcodes.shtml
	 * 
	 * @param string $toCheck	- postcode to check
	 * 
	 * @return boolean		- true if postcode is valid, otherwise false
	 * @access public
	 */
	public function is_uk_postcode (&$toCheck) {
	
		// Permitted letters depend upon their position in the postcode.
		$alpha1 = "[abcdefghijklmnoprstuwyz]";	// Character 1
		$alpha2 = "[abcdefghklmnopqrstuvwxy]";	// Character 2
		$alpha3 = "[abcdefghjkpmnrstuvwxy]";	// Character 3
		$alpha4 = "[abehmnprvwxy]";		// Character 4
		$alpha5 = "[abdefghjlnpqrstuwxyz]";	// Character 5
		
		// Expression for postcodes: AN NAA, ANN NAA, AAN NAA, and AANN NAA with a space
		$pcexp[0] = '^('.$alpha1.'{1}'.$alpha2.'{0,1}[0-9]{1,2})([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$';
	
		// Expression for postcodes: ANA NAA
		$pcexp[1] = '^('.$alpha1.'{1}[0-9]{1}'.$alpha3.'{1})([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$';
	
		// Expression for postcodes: AANA NAA
		$pcexp[2] = '^('.$alpha1.'{1}'.$alpha2.'{1}[0-9]{1}'.$alpha4.')([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$';
		
		// Exception for the special postcode GIR 0AA
		$pcexp[3] = '^(gir)(0aa)$';
		
		// Standard BFPO numbers
		$pcexp[4] = '^(bfpo)([0-9]{1,4})$';
		
		// c/o BFPO numbers
		$pcexp[5] = '^(bfpo)(c\/o[0-9]{1,3})$';
		
		// Overseas Territories
		$pcexp[6] = '^([a-z]{4})(1zz)$/i';
	
		// Load up the string to check, converting into lowercase
		$postcode = strtolower($toCheck);
	
		// Assume we are not going to find a valid postcode
		$valid = false;
		
		// Check the string against the six types of postcodes
		foreach ($pcexp as $regexp) {
		
			if (ereg($regexp,$postcode, $matches)) {
				
				// Load new postcode back into the form element	
				$postcode = strtoupper ($matches[1] . ' ' . $matches [3]);
				
				// Take account of the special BFPO c/o format
				$postcode = ereg_replace ('C\/O', 'c/o ', $postcode);
				
				// Remember that we have found that the code is valid and break from loop
				$valid = true;
				break;
			}
		}
			
		// Return with the reformatted valid postcode in uppercase if the postcode was valid
		if ($valid){
			$toCheck = $postcode; 
			return true;
		} else {
			return false;
		}
		
	}
	
	/**
	 * Checks if a string is a valid UK telephone number.
	 * 
	 * This routine checks the value of the string variable specified by the parameter
	 * for a valid UK telphone number. It returns true for a valid number and false for 
	 * an invalid number.
	 * 
	 * The definition of a valid telephone number has been taken from:
	 * 	http://www.ofcom.org.uk/telecoms/ioi/numbers/numplan310507.pdf
	 * 	http://www.ofcom.org.uk/telecoms/ioi/numbers/num_drama
	 * 
	 * All inappropriate telephone numbers are disallowed (e.g. premium lines, sex 
	 * lines, radio-paging services etc.)
	 * 
	 * Credit due to John Gardner.
	 * @see http://www.braemoor.co.uk/software/telnumbers.shtml
	 * 
	 * @param string $strTelephoneNumber	- telephone number to check
	 * @param integer $intError		- variable into which error numbers will be inserted upon error
	 * @param string $strError		- variable into which error messages will be inserted upon error
	 * 
	 * @return boolean		- true if postcode is valid, otherwise false
	 * @access public
	 */
	public function is_uk_telephone (&$strTelephoneNumber,&$intError,&$strError) {
		
		// Copy the parameter and strip out the spaces
		$strTelephoneNumberCopy = str_replace (' ', '', $strTelephoneNumber);
	
		// Convert into a string and check that we were provided with something
		if (empty($strTelephoneNumberCopy)) {
			$intError = 1;
			$strError = 'Telephone number not provided';
			return false;
		}
		
		// Don't allow country codes to be included (assumes a leading "+") 
		if (ereg('^(\+)[\s]*(.*)$',$strTelephoneNumberCopy)) {
			$intError = 2;
			$strError = 'UK telephone number without the country code, please';
			return false;
		}
		
		// Remove hyphens - they are not part of a telephine number
		$strTelephoneNumberCopy = str_replace ('-', '', $strTelephoneNumberCopy);
		
		// Now check that all the characters are digits
		if (!ereg('^[0-9]{10,11}$',$strTelephoneNumberCopy)) {
			$intError = 3;
			$strError = 'UK telephone numbers should contain 10 or 11 digits';
			return false;
		}
		
		// Now check that the first digit is 0
		if (!ereg('^0[0-9]{9,10}$',$strTelephoneNumberCopy)) {
			$intError = 4;
			$strError = 'The telephone number should start with a 0';
			return false;
		}		
		
		// Check the string against the numbers allocated for dramas
		$tnexp[0] = '^(0113|0114|0115|0116|0117|0118|0121|0131|0141|0151|0161)(4960)[0-9]{3}$';
		$tnexp[1] = '^02079460[0-9]{3}$';
		$tnexp[2] = '^01914980[0-9]{3}$';
		$tnexp[3] = '^02890180[0-9]{3}$';
		$tnexp[4] = '^02920180[0-9]{3}$';
		$tnexp[5] = '^01632960[0-9]{3}$';
		$tnexp[6] = '^07700900[0-9]{3}$';
		$tnexp[7] = '^08081570[0-9]{3}$';
		$tnexp[8] = '^09098790[0-9]{3}$';
		$tnexp[9] = '^03069990[0-9]{3}$';
		
		foreach ($tnexp as $regexp) {	
			if (ereg($regexp,$strTelephoneNumberCopy, $matches)) {
				$intError = 5;
				$strError = 'The telephone number is either invalid or inappropriate';
				return false;
			}
		}
		
		// Finally, check that the telephone number is appropriate.
		if (!ereg('^(01|02|03|05|070|071|072|073|074|075|07624|077|078|079)[0-9]+$',$strTelephoneNumberCopy)) {
			$intError = 5;
			$strError = 'The telephone number is either invalid or inappropriate';
			return false;
		}
		
		// Seems to be valid - return the stripped telephone number
		$strTelephoneNumberCopy = $strTelephoneNumberCopy;
		$intError = 0;
		$strError = '';
		return true;
		
	}

}
	
?>