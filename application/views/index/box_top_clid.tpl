{* Overview box, loaded via AJAX *}

<div class="title">Top caller IDs</div>

<div class="content">

	{if $numbers|@count > 0}

		<table class="basicreport" width="100%">
		
			<thead><tr>
				<th>Caller ID</th>
				<th>Count</th>
			</tr></thead>
			
			<body>
			
			{foreach from=$numbers key=number item=count}
			
				<tr>
					<td>{$number}</td>
					<td align="center">{$count}</td>
				</tr>
			
			{/foreach}
			
			</body>
		
		</table>
		
	{else}
	
		<p>No statistics were returned by this overview.</p>
	
	{/if}

</div>
