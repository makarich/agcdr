{include file='shared/htmlheader.tpl'}

{if $cdr->uniqueid}

	<h2>Call {$cdr->uniqueid}</h2>
	
	<table class="form">
	
		<tr>
			<td class="label" nowrap>Date and time</td>
			<td class="value">{$cdr->calldate|strtotime|date_format:"%d/%m/%Y %H:%M:%S"}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Caller ID</td>
			<td class="value">{$cdr->clid}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Source</td>
			<td class="value">{$cdr->src}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Destination</td>
			<td class="value">{$cdr->dst}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Context</td>
			<td class="value">{$cdr->dcontext}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Channel</td>
			<td class="value">{$cdr->channel}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Destination channel</td>
			<td class="value">{$cdr->dstchannel}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Last application</td>
			<td class="value">{$cdr->lastapp}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Last data</td>
			<td class="value">{$cdr->lastdata}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Disposition</td>
			<td class="value">{$cdr->disposition}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Duration</td>
			<td class="value">{$cdr->duration_formatted}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Billable duration</td>
			<td class="value">{$cdr->billsecs_formatted}</td>
		</tr>
		<tr>
			<td class="label" nowrap>Account code</td>
			<td class="value">{$cdr->accountcode}</td>
		</tr>
		<tr>
			<td class="label" nowrap>AMA flags</td>
			<td class="value">{$cdr->amaflags}</td>
		</tr>
		<tr>
			<td class="label" nowrap>User field</td>
			<td class="value">{$cdr->userfield}</td>
		</tr>
	
	</table>
	
{else}

	<p class="ui-state-error ui-corner-all warning">The referenced caller detail record unique ID is invalid.</p>

{/if}

{include file='shared/htmlfooter.tpl'}