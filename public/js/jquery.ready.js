
// AGCDR: jquery functions library (must be loaded at foot of each page)
// Copyright 2011 Stuart Benjamin Ford, all rights reserved

$(document).ready(function() {

	// apply button function to button elements, submit buttons and hyperlinks with 
	$(function() {
		$("input:submit, input:button", ".form").button();
		$("input:submit, input:button", ".buttonbar").button();
		$("button").button();
		$("a", ".button").click(function() { return false; });
	});
		
	// apply datepicker function to text fields with class "datepicker"
	$(function() {
		$("input.datepicker").datepicker();
	});
	
}); // ready function
