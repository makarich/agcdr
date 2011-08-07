{* Overview box, loaded via AJAX *}

<div class="title">Top sources</div>

<div class="content">

	{if $numbers|@count > 0}

		<table class="basicreport" width="100%">
		
			<thead><tr>
				<th>Source</th>
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
	
		<div class="formwizard_message_info">
			<div class="em_severity">No data</div>
			<div class="em_message">No statistics were returned by this overview.</div>
		</div>

	{/if}

</div>
