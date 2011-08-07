{* Overview box, loaded via AJAX *}

<div class="title">Recent calls <b>to</b> {$number}</div>

<div class="content">

	{if $cdrs|@count > 0}

		<table class="basicreport" width="100%">
		
			<thead><tr>
				<th>Date/Time</th>
				<th>Source</th>
				<th>Last app.</th>
				<th>Duration</th>
			</tr></thead>
			
			<body>
			
			{foreach from=$cdrs key=uniqueid item=cdr}
			
				<tr onmouseover="$(this).toggleClass('grey');" onmouseout="$(this).toggleClass('grey');" onclick="window.location='/cdr/view/?uid={$uniqueid}';">
					<td>{$cdr.calldate|strtotime|date_format:"%d/%m %H:%M"}</td>
					<td>{$cdr.numfield}</td>
					<td>{$cdr.lastapp}</td>
					<td>{$cdr.formatted_duration}</td>
				</tr>
			
			{/foreach}
			
			</body>
		
		</table>
		
	{else}
		
		<div class="formwizard_message_info">
			<div class="em_severity">No calls</div>
			<div class="em_message">There are no calls to {$number} in the CDR database.</div>
		</div>
	
	{/if}

</div>
