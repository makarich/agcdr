{include file='shared/htmlheader.tpl'}

{* when making changes to this template please also make equivalent changes in cdr/table.tpl *}

{if $results|@count ne 0}
	<div id="rightbuttons">
		<button type="button" onclick="downloadCSV();">{icon name="csv"}&nbsp;&nbsp;Export CSV file</button>
	</div>
{/if}

<h2>Search Results</h2>

{if $results|@count eq 0}

	<p class="ui-state-highlight ui-corner-all highlight">No CDRs matched your query.</p>

{else}

	<table class="display" id="resultstable">
	
		<thead>
			<tr>
				<th>Unique ID</th>
				<th>Date</th>
				<th>Time</th>
				<th>Caller ID</th>
				<th>Source</th>
				<th>Destination</th>
				<th>Context</th>
				<th>Last app.</th>
				<th>Duration</th>
				<th>Billable</th>
				<th>Disposition</th>
			</tr>
		</thead>
		
		<tbody>
		
		{foreach from=$results key=uniqueid item=cdr}
		
			<tr>
				<td><a href="/cdr/view/?uid={$uniqueid}">{$uniqueid}</a></td>
				<td>{$cdr.calldate|strtotime|date_format:"%d/%m/%Y"}</td>
				<td>{$cdr.calldate|strtotime|date_format:"%H:%M:%S"}</td>
				<td>{$cdr.clid}</td>
				<td>{$cdr.src}</td>
				<td>{$cdr.dst}</td>
				<td>{$cdr.dcontext}</td>
				<td>{$cdr.lastapp}</td>
				<td>{$cdr.formatted_duration}</td>
				<td>{$cdr.formatted_billsec}</td>
				<td>{$cdr.disposition}</td>
			</tr>
		
		{/foreach}
		
		</tbody>
	
	</table>
	
	<script type="text/javascript">
	
	// apply DataTables plugin to results table
	$('#resultstable').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bProcessing": true,
		"iDisplayLength": 25,
		"oLanguage": {
			"sInfo": "Showing _START_ to _END_ of _TOTAL_ CDRs.",
			"sLengthMenu": 'Display <select>{/literal}{$menuoptions}{literal}</select> CDRs'
		},
                "aoColumns": [
			{"bSortable": false},
			{"bSortable": true, "sType": "uk_date"},
			{"bSortable": false},
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true}
		]
	});

	// handle CSV download request
	function downloadCSV() {
		postwith("/search/results/",{/literal}{$csvjson}{literal});
	}
	
	</script>
	
{/if}

{if !$single_day_search}
	{include file='search/form.tpl'}
	<p>You may alter your search parameters using the form opposite and re-submit your search.</p>
{/if}

<div style="clear: both;"></div>

{include file='shared/htmlfooter.tpl'}
