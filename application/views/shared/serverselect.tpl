{* Server selection menu *}

<div id="serverselect">

	<form method="POST" action="/" name="serverswitch">

	Database server:

	<select name="switchto" id="switchto" onchange="document.serverswitch.submit();" {if $smarty.session.servers|@count <= 1}disabled{/if}>
	{foreach from=$smarty.session.servers key=hostname item=server}
		<option value="{$hostname}" {if $hostname eq $smarty.session.server}selected{/if}>{$server.description}</option>
	{/foreach}
	</select>
	
	</form>

</div>
