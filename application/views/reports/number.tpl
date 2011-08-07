{* Specific report template *}

{include file='shared/htmlheader.tpl'}

{if $report}

	<h2>{$report.number}</h2>
	
	<div id="tabs">
	
		<ul>
			<li><a href="#tabs-overview">Overview</a></li>
			<li><a href="#tabs-minutes">Minutes breakdown</a></li>
			<li><a href="/cdr/table/?number={$report.number}">Caller detail records</a></li>
		</ul>
		
		<div id="tabs-overview">
		
			<ul id="overviewgrid">
			{foreach from=$boxes item=box}
				<li id="box_{$box}">{boxloader box=$box}</li>
			{/foreach}
			</ul>
		
			<div style="clear: both;"></div>
		
		</div>
		
		<div id="tabs-minutes">
		
		
		
		</div>

	</div>

{else}

	<form method="GET" action="/reports/number/">
	{include file='shared/formwizard.tpl'}
	</form>

{/if}

<script type="text/javascript">
	
$(function() {

	// create tabbed section
	$("#tabs").tabs();

	// create sortable grid
	$("#overviewgrid").sortable();
	$("#overviewgrid").disableSelection();

	// set box list
	var allBoxes = new Array({$boxlist});

	// load content into all boxes
	for (i=0; i<allBoxes.length; i++) {
		$("#box_"+allBoxes[i]).load('/reports/box/?box='+allBoxes[i]+"&number={$report.number}");
	}
	
});

</script>
	

{include file='shared/htmlfooter.tpl'}
