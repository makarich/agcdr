{* Overview box, loaded via AJAX *}

<div class="title">Most recent calls</div>

<div class="content">

	{if $cdrs|@count > 0}

		<table class="basicreport" width="100%">
		
			<thead><tr>
				<th>Time</th>
				<th>Source</th>
				<th>Destination</th>
				<th>Duration</th>
			</tr></thead>
			
			<body>
			
			{foreach from=$cdrs key=uniqueid item=cdr}
			
				<tr onmouseover="$(this).toggleClass('grey');" onmouseout="$(this).toggleClass('grey');" onclick="window.location='/cdr/view/?uid={$uniqueid}';">
					<td>{$cdr.calldate|strtotime|date_format:"%H:%M"}</td>
					<td>{$cdr.src}</td>
					<td>{$cdr.dst}</td>
					<td>{$cdr.formatted_duration}</td>
				</tr>
			
			{/foreach}
			
			</body>
		
		</table>
		
	{else}
	
		<p>There are no CDRs present in the database.</p>
	
	{/if}

</div>
