
// jQuery Datatables plugin extensions
// See http://www.datatables.net/plug-ins/api and http://www.datatables.net/plug-ins/sorting for more information

// This file must be loaded after the jQuery and Datatables libraries, but
// *before* any Datatables are initialised.

// UK date format sorting. Use the following in aoColumns on applicable columns:
// {"bSortable": true, "sType": "uk_date"},

jQuery.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {

	// sort by dates in UK format, ascending
	
	var ukDatea = a.split('/');
	var ukDateb = b.split('/');

	var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
	var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;

	return ((x < y) ? -1 : ((x > y) ?  1 : 0));

};

jQuery.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {

	// sort by dates in UK format, descending
	
	var ukDatea = a.split('/');
	var ukDateb = b.split('/');

	var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
	var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;

	return ((x < y) ? 1 : ((x > y) ?  -1 : 0));

};

// Percentage sorting. Use the following in aoColumns on applicable columns:
// {"bSortable": true, "sType": "percent"},

jQuery.fn.dataTableExt.oSort['percent-asc']  = function(a,b) {
	
	// sort by percentage, ascending
	
	var x = (a == "-") ? 0 : a.replace( /%/, "" );
	var y = (b == "-") ? 0 : b.replace( /%/, "" );
	
	x = parseFloat( x );
	y = parseFloat( y );
	
	return ((x < y) ? -1 : ((x > y) ?  1 : 0));
	
};

jQuery.fn.dataTableExt.oSort['percent-desc'] = function(a,b) {
	
	// sort by percentage, descending
	
	var x = (a == "-") ? 0 : a.replace( /%/, "" );
	var y = (b == "-") ? 0 : b.replace( /%/, "" );
	
	x = parseFloat( x );
	y = parseFloat( y );
	
	return ((x < y) ?  1 : ((x > y) ? -1 : 0));
	
};

// Currency field sorting. Use the following in aoColumns on applicable columns:
// {"bSortable": true, "sType": "currency"},

jQuery.fn.dataTableExt.oSort['currency-asc'] = function(a,b) {

	// sort currency field, ascending
	
	var x = a == "-" ? 0 : a.replace( /,/g, "" );
	var y = b == "-" ? 0 : b.replace( /,/g, "" );
	
	x = x.substring( 1 );
	y = y.substring( 1 );
	
	x = parseFloat( x );
	y = parseFloat( y );
	
	return x - y;
	
};

jQuery.fn.dataTableExt.oSort['currency-desc'] = function(a,b) {

	// sort currency field, descending
	
	var x = a == "-" ? 0 : a.replace( /,/g, "" );
	var y = b == "-" ? 0 : b.replace( /,/g, "" );
	
	x = x.substring( 1 );
	y = y.substring( 1 );
	
	x = parseFloat( x );
	y = parseFloat( y );
	
	return y - x;
	
};

// Euro date format (dd/mm/YYY hh:ii:ss) sorting. Use the following in aoColumns on applicable columns:
// {"bSortable": true, "sType": "date-euro"},

function trim(str) {
	str = str.replace(/^\s+/, '');
	for (var i = str.length - 1; i >= 0; i--) {
		if (/\S/.test(str.charAt(i))) {
			str = str.substring(0, i + 1);
			break;
		}
	}
	return str;
}

jQuery.fn.dataTableExt.oSort['date-euro-asc'] = function(a, b) {
	
	if (trim(a) != '') {
		var frDatea = trim(a).split(' ');
		var frTimea = frDatea[1].split(':');
		var frDatea2 = frDatea[0].split('/');
		var x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1] + frTimea[2]) * 1;
	} else {
		var x = 10000000000000; // = l'an 1000 ...
	}

	if (trim(b) != '') {
		var frDateb = trim(b).split(' ');
		var frTimeb = frDateb[1].split(':');
		frDateb = frDateb[0].split('/');
		var y = (frDateb[2] + frDateb[1] + frDateb[0] + frTimeb[0] + frTimeb[1] + frTimeb[2]) * 1;		                
	} else {
		var y = 10000000000000;		                
	}
	
	var z = ((x < y) ? -1 : ((x > y) ? 1 : 0));
	return z;
	
};

jQuery.fn.dataTableExt.oSort['date-euro-desc'] = function(a, b) {
	
	if (trim(a) != '') {
		var frDatea = trim(a).split(' ');
		var frTimea = frDatea[1].split(':');
		var frDatea2 = frDatea[0].split('/');
		var x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1] + frTimea[2]) * 1;		                
	} else {
		var x = 10000000000000;		                
	}

	if (trim(b) != '') {
		var frDateb = trim(b).split(' ');
		var frTimeb = frDateb[1].split(':');
		frDateb = frDateb[0].split('/');
		var y = (frDateb[2] + frDateb[1] + frDateb[0] + frTimeb[0] + frTimeb[1] + frTimeb[2]) * 1;		                
	} else {
		var y = 10000000000000;		                
	}
	
	var z = ((x < y) ? 1 : ((x > y) ? -1 : 0));		            
	return z;
	
};

// Natural sorting. Use the following in aoColumns on applicable columns:
// {"bSortable": true, "sType": "natural"},

function naturalSort(a, b) {
	
	// setup temp-scope variables for comparison evauluation
	var re = /(^[0-9]+\.?[0-9]*[df]?e?[0-9]?$|^0x[0-9a-f]+$|[0-9]+)/gi,
		sre = /(^[ ]*|[ ]*$)/g,
		hre = /^0x[0-9a-f]+$/i,
		ore = /^0/,
		// convert all to strings and trim()
		x = a.toString().replace(sre, '') || '',
		y = b.toString().replace(sre, '') || '',
		// chunk/tokenize
		xN = x.replace(re, '\0$1\0').replace(/\0$/,'').replace(/^\0/,'').split('\0'),
		yN = y.replace(re, '\0$1\0').replace(/\0$/,'').replace(/^\0/,'').split('\0'),
		// hex or date detection
		xD = parseInt(x.match(hre)) || (new Date(x)).getTime(),
		yD = parseInt(y.match(hre)) || xD && (new Date(y)).getTime() || null;
	
	// natural sorting of hex or dates - prevent '1.2.3' valid date
	if ( y.indexOf('.') < 0 && yD )
		if ( xD < yD ) return -1;
		else if ( xD > yD )	return 1;
	
	// natural sorting through split numeric strings and default strings
	for(var cLoc=0, numS=Math.max(xN.length, yN.length); cLoc < numS; cLoc++) {
		// find floats not starting with '0', string or 0 if not defined (Clint Priest)
		oFxNcL = !(xN[cLoc] || '').match(ore) && parseFloat(xN[cLoc]) || xN[cLoc] || 0;
		oFyNcL = !(yN[cLoc] || '').match(ore) && parseFloat(yN[cLoc]) || yN[cLoc] || 0;
		// handle numeric vs string comparison - number < string - (Kyle Adams)
		if (isNaN(oFxNcL) !== isNaN(oFyNcL)) return (isNaN(oFxNcL)) ? 1 : -1; 
		// rely on string comparison if different types - i.e. '02' < 2 != '02' < '2'
		else if (typeof oFxNcL !== typeof oFyNcL) {
			oFxNcL += ''; 
			oFyNcL += ''; 
		}
		if (oFxNcL < oFyNcL) return -1;
		if (oFxNcL > oFyNcL) return 1;
	}
	
	return 0;
	
}

jQuery.fn.dataTableExt.oSort['natural-asc']  = function(a,b) {
	return naturalSort(a,b);
};

jQuery.fn.dataTableExt.oSort['natural-desc'] = function(a,b) {
	return naturalSort(a,b) * -1;
};