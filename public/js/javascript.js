
// AGCDR: General Javascript functions library
// Copyright 2011 Stuart Benjamin Ford, all rights reserved

function postwith (to,p) {
	
	// POST data between pages (instead of passing data in a GET query)
	// Credit due to http://mentaljetsam.wordpress.com/2008/06/02/using-javascript-to-post-data-between-pages/
	
	var myForm = document.createElement("form");
	myForm.method="post" ;
	myForm.action = to ;
	
	for (var k in p) {
		var myInput = document.createElement("input") ;
		myInput.setAttribute("name", k) ;
		myInput.setAttribute("value", p[k]);
		myForm.appendChild(myInput) ;
	}
	
	document.body.appendChild(myForm) ;
	myForm.submit() ;
	document.body.removeChild(myForm) ;
	
}
