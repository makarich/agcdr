{*

Smarty rendering template for use with the FormWizard class. Instructions for use:

1) Assign a FormWizard object to your template, e.g:	$this->view->set('formwizard',$wizard);	(in EGS)
							$smarty->assign('formwizard',$wizard);	(generic Smarty)
2) Include this template in the view's main template:	{include file='includes/shared/formwizard.tpl'}
3) Style accordingly in your stylesheet.

Please see the documentation in the FormWizard.php class file for full information on how to build FormWizard objects.
Please note that the Javascript in this template makes use of Modernizr in order to detect browser capbilities.

*}

<link rel="stylesheet" type="text/css" media="all" href="/css/formwizard-min.css" />

<table class="formwizard" summary="{$formwizard->title}" cellspacing="0">

	<thead>
		<tr>
			<th colspan="3">{$formwizard->title}</th>
		</tr>
	</thead>
	
	<tbody>
	
	{foreach from=$formwizard->items item=formitem}
	
		<tr>
			<td class="wizardlabel">
				{if $formitem->type ne "checkbox"}{if $formitem->type ne "radiogroup"}<label for="{$formitem->id}">{/if}{$formitem->label}{if $formitem->type ne "radiogroup"}</label>{/if}{/if}
				{if $formitem->type eq "checkbox" && $formitem->sidelabel}{$formitem->sidelabel}{/if}	
			</td>
			<td class="wizardelement" id="formwizard_required_{$formitem->id}">
				{if $formitem->type eq "number" || $formitem->type eq "range"}
					<div id="{$formitem->id}_container"></div>
				{else}
					{if $formitem->prefix}{$formitem->prefix}{/if}
					{$formitem->html}
					{if $formitem->suffix}{$formitem->suffix}{/if}
				{/if}
			</td>
			<td class="wizardrequired">
				{if $formitem->required}
					{assign var="required" value=true}
					<img src="/images/icons/asterisk_red.png" width="16" height="16" alt="required" />
				{/if}
			</td>
		</tr>
	
	{/foreach}
	
	</tbody>

	<tfoot>
		<tr>
			<th colspan="3" nowrap>
				{if $required}<span style="float: left;"><img src="/images/icons/asterisk_red.png" width="16" height="16" alt="red asterisk" align="top" /> indicates required field</span>{/if}
				{if $formwizard->back_action}<button type="button"  id="wizard_back" class="wizardbutton" onclick="{$formwizard->back_action}">{if $formwizard->back_icon}{icon name=$formwizard->back_icon} {/if}{$formwizard->back_label}</button>{/if}
				{if $formwizard->next}<button type="submit" id="wizard_next" name="wizard_action" class="wizardbutton" style="font-weight: bold;">{if $formwizard->next_icon}{icon name=$formwizard->next_icon} {/if}{$formwizard->next}</button>{/if}
			</th>
		</tr>
	</tfoot>

</table>

{* include any required jQuery code *}

{literal}
	
<script type="text/javascript">
	
( function($) {
	
$(document).ready(function() {

	{/literal}
	{if $formwizard->back_action}$('#wizard_back').button();{/if}
	{if $formwizard->next}$('#wizard_next').button();{/if}
	{literal}
	
	{/literal}{if $formwizard->jquery}{literal}
		
	//	$.rloader([
	//		{type:'js',src:'/app/js/lib/jquery/multiselect-1.6/jquery.multiselect.min.js'},
	//		{type:'css',src:'/app/js/lib/jquery/multiselect-1.6/jquery.multiselect.css'}
	//	]);
			
		{/literal}
		{foreach from=$formwizard->jquery item=jqline}
			{$jqline}
		{/foreach}
		{literal}

	{/literal}{/if}{literal}
	
});

} ) ( jQuery );

// render number and range elements depending on HTML5 support
function renderRangeElement(id,slider,prefix,suffix,html64,fallback_html64) {

	// determine element type from slider flag
	if (slider == "1") {
		var type = "range";
	} else {
		var type = "number";
	}
	
	if ((type == "range" && Modernizr.inputtypes.range) || (type == "number" && Modernizr.inputtypes.number)) {
		// HTML5 goodness detected, insert decoded HTML string into form
		var html = atob(html64);
	} else {
		// browser does not yet support the new form element types, so use the fallback HTML
		var html = atob(fallback_html64);
	}

	// add prefix and suffix
	if (prefix.length > 0) html = prefix+"&nbsp;"+html;
	if (suffix.length > 0) html += "&nbsp;"+suffix;
	
	// insert into container
	document.getElementById(id+"_container").innerHTML = html;

}

{/literal}
{foreach from=$formwizard->items item=formitem}
	{if $formitem->type eq "number" || $formitem->type eq "range"}
		renderRangeElement('{$formitem->id}','{$formitem->slider}','{$formitem->prefix}','{$formitem->suffix}','{$formitem->html_base64}','{$formitem->fallback_html_base64}');
	{/if}
{/foreach}
{literal}

// it'd be so nice to be able to use jQuery.toggle() here, but until we dump the
// competing JS libraries we're just going to have to do it the bastard hard way.

// position of the tooltip relative to the mouse in pixel
var offsetx = 12;
var offsety =  8;

function newelement(newid) { 
	if (document.createElement) { 
		var el = document.createElement('div'); 
		el.className = "formwizard_tooltip";
		el.id = newid;     
		with (el.style) { 
			display = 'none';
			position = 'absolute';
		} 
		el.innerHTML = '&nbsp;'; 
		document.body.appendChild(el); 
	} 
} 

var ie5 = (document.getElementById && document.all); 
var ns6 = (document.getElementById && !document.all); 
var ua = navigator.userAgent.toLowerCase();
var isapple = (ua.indexOf('applewebkit') != -1 ? 1 : 0);

function getmouseposition(e) {
	if (document.getElementById) {
		var iebody = (document.compatMode && document.compatMode != 'BackCompat') ? document.documentElement : document.body;
		pagex = (isapple == 1 ? 0:(ie5)?iebody.scrollLeft:window.pageXOffset);
		pagey = (isapple == 1 ? 0:(ie5)?iebody.scrollTop:window.pageYOffset);
		mousex = (ie5)?event.x:(ns6)?clientX = e.clientX:false;
		mousey = (ie5)?event.y:(ns6)?clientY = e.clientY:false;
		var lixlpixel_tooltip = document.getElementById('tooltip');
		lixlpixel_tooltip.style.left = (mousex+pagex+offsetx) + 'px';
		lixlpixel_tooltip.style.top = (mousey+pagey+offsety) + 'px';
	}
}

function openToolTip(tip) {
	if (!document.getElementById('tooltip')) newelement('tooltip');
	var lixlpixel_tooltip = document.getElementById('tooltip');
	lixlpixel_tooltip.innerHTML = tip;
	lixlpixel_tooltip.style.display = 'block';
	document.onmousemove = getmouseposition;
}

function closeToolTip() {
	document.getElementById('tooltip').style.display = 'none';
}

</script>
	
{/literal}
