{* Overview box, loaded via AJAX *}

<div class="title">General statistics{if $number} for {$number}{/if}</div>

<div class="content">

	<table class="basicreport" width="100%">
	
		<thead><tr>
			<th>Item</th>
			<th>Value</th>
		</tr></thead>
		
		<body>
		
		{foreach from=$statistics key=label item=statistic}
		
			<tr>
				<td>{$label}</td>
				<td align="center">{$statistic}</td>
			</tr>
		
		{/foreach}
		
		</body>
	
	</table>
		
</div>
