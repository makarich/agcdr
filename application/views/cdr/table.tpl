{* Designed to be loaded into a tab or a dialogue window *}

{if $cdrs|@count eq 0}

	<p class="ui-state-highlight ui-corner-all highlight">There are no CDRs in the database for this period.</p>

{else}

	<table class="display" id="cdrlist">
	
		<thead>
			<tr>
				<th>Date/time<th>
			</tr>
		</thead>
		
		<tbody>
		
		{foreach from=$cdrs key=uniqueid item=cdr}
		
			<tr onmouseover="$(this).toggleClass('grey');" onmouseout="$(this).toggleClass('grey');" onclick="window.location='/cdr/view/?uid={$uniqueid}';">
				<td>{$cdr.calldate|strtotime|date_format:"%H:%M:%S"}</td>
			</tr>
		
		{/foreach}
		
		</tbody>
	
	</table>
	
	{literal}
	
	<script type="text/javascript">
	
	// apply DataTables plugin to cdry list
	$('#cdrlist').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bProcessing": true,
		"iDisplayLength": 25,
		"oLanguage": {
			"sInfo": "Showing _START_ to _END_ of _TOTAL_ CDRs.",
			"sLengthMenu": 'Display <select>{/literal}{$menuoptions}{literal}</select> CDRs'
		},
                "aoColumns": [
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true, "sType": "uk_date"},
			{"bSortable": true},
			{"bSortable": false}
		]
	});
	
	</script>
	
	{/literal}

{/if}
