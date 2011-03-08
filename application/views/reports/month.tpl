{include file='shared/htmlheader.tpl'}

<div id="prevnext">
	<button type="button" onclick="window.location='/{$controller}/{$action}/?month={$prev_month}';">{icon name="control_rewind_blue"}&nbsp;&nbsp;{$prev_monthlabel}</button>
	<button type="button" onclick="window.location='/{$controller}/year/?year={$year}';">{$year}</button>
	<button type="button" onclick="window.location='/{$controller}/{$action}/?month={$next_month}';">{$next_monthlabel}&nbsp;&nbsp;{icon name="control_fastforward_blue"}</button>
</div>

<h2>{$monthlabel}</h2>

<div id="tabs">

	<ul>
		<li><a href="#tabs-overview">Overview</a></li>
		<li><a href="#tabs-calls">Calls per day</a></li>
		<li><a href="#tabs-mins">Minutes per day</a></li>
		<li><a href="/cdr/table/?month={$month}">Caller detail records</a></li>
	</ul>
	
	<div id="tabs-overview">
	
		<ul id="overviewgrid">
			{foreach from=$boxes item=box}
				<li id="box_{$box}">Loading box {$box} ...</li>
			{/foreach}
		</ul>
	
		<div style="clear: both;"></div>
	
	</div>
	
	<div id="tabs-calls">
	
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		
			<tr>
			
				<td align="left" valign="top">
					<img src="/images/charts/{$chart_calls}" class="greyborder" alt="Call per day chart" width="700" height="350"/>
				</td>
				
				<td align="left" valign="top" width="100%" class="statistics">
					<p>Total calls: <b>{$total_calls}</b></p>
					<p>Average calls per day: <b>{$average_calls}</b></p>
				</td>
			
			</tr>
		
		</table>
	
	</div>
	
	<div id="tabs-mins">
	
		<table border="0" cellpadding="0" cellspacing="0">
		
			<tr>
			
				<td align="left" valign="top">
					<img src="/images/charts/{$chart_mins}" class="greyborder" alt="Minutes per day chart" width="700" height="350"/>
				</td>
				
				<td align="left" valign="top" width="100%" class="statistics">
					<p>Total minutes: <b>{$total_mins}</b></p>
					<p>Average minutes per day: <b>{$average_mins}</b></p>
				</td>
			
			</tr>
		
		</table>
	
	</div>
	
	<div id="tabs-cdrs">
	
	
	
	</div>

</div>

{literal}

<script type="text/javascript">
	
	$(function() {

		// create tabbed section
		$("#tabs").tabs();

		// create sortable grid
		$("#overviewgrid").sortable();
		$("#overviewgrid").disableSelection();

		// set box list
		var allBoxes = new Array({/literal}{$boxlist}{literal});

		// load content into all boxes
		for (i=0; i<allBoxes.length; i++) {
			$("#box_"+allBoxes[i]).load('/reports/box/?box='+allBoxes[i]+"&month={/literal}{$month}{literal}");
		}
			
	});

</script>
	
{/literal}

{include file='shared/htmlfooter.tpl'}
