{include file='shared/htmlheader.tpl'}

<div id="prevnext">
	<button type="button" onclick="history.back(-1);">{icon name="back"} Return</button>
</div>

{if $cdr->uniqueid}

	<h2>Call {$cdr->uniqueid}</h2>
	
	<table class="form" width="100%">
	
		<tr>
			<td class="label" nowrap>Date and time</td>
			<td class="value"><a href="javascript:void(0);" onclick="advancedSearch('date','{$cdr->calldate|strtotime|date_format:"%Y-%m-%d"}');">{$cdr->calldate|strtotime|date_format:"%d/%m/%Y %H:%M:%S"}</a></td>
			<td class="label" nowrap>Channel</td>
			<td class="value">{$cdr->channel}</td>
			<td class="label" nowrap>Duration</td>
			<td class="value">{$cdr->duration_formatted}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Caller ID</td>
			<td class="value"><a href="javascript:void(0);" onclick="advancedSearch('clid','{$cdr->clid}');">{$cdr->clid}</a></td>
			<td class="label" nowrap>Destination channel</td>
			<td class="value">{$cdr->dstchannel}</td>
			<td class="label" nowrap>Billable duration</td>
			<td class="value">{$cdr->billsecs_formatted}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Source</td>
			<td class="value"><a href="javascript:void(0);" onclick="advancedSearch('src','{$cdr->src}');">{$cdr->src}</a></td>
			<td class="label" nowrap>Last application</td>
			<td class="value">{$cdr->lastapp}</td>
			<td class="label" nowrap>Account code</td>
			<td class="value">{$cdr->accountcode}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Destination</td>
			<td class="value"><a href="javascript:void(0);" onclick="advancedSearch('dst','{$cdr->dst}');">{$cdr->dst}</a></td>
			<td class="label" nowrap>Last data</td>
			<td class="value">{$cdr->lastdata}</td>
			<td class="label" nowrap>AMA flags</td>
			<td class="value">{$cdr->amaflags}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Context</td>
			<td class="value">{$cdr->dcontext}</td>
			<td class="label" nowrap>Disposition</td>
			<td class="value">{$cdr->disposition}</td>
			<td class="label" nowrap>User field</td>
			<td class="value">{$cdr->userfield}</td>
		</tr>
		
	</table>
	
	{literal}
	
	<script type="text/javascript">

	function advancedSearch(fieldName,fieldValue) {
		
		if (fieldName == 'date') {
			postwith("/search/results/",{field_1:'calldate',operator_1:'starts',criteria_1:fieldValue});
		} else {
			postwith("/search/results/",{date_from:'1970-01-01',date_to:'{/literal}{$smarty.now|date_format:"%Y-%m-%d"}{literal}',field_1:fieldName,operator_1:'equals',criteria_1:fieldValue});
		}
		
	}

	</script>
	
	{/literal}
	
{else}

	<p class="ui-state-error ui-corner-all warning">The referenced caller detail record unique ID is invalid.</p>

{/if}

{include file='shared/htmlfooter.tpl'}