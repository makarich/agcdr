{include file='shared/htmlheader.tpl'}

<ul id="overviewgrid">
	{foreach from=$boxes item=box}
		<li id="box_{$box}">Loading box {$box} ...</li>
	{/foreach}
</ul>

<div style="clear: both;"></div>

{literal}

<script type="text/javascript">
	
	$(function() {

		// create sortable grid
		$("#overviewgrid").sortable();
		$("#overviewgrid").disableSelection();

		// set box list
		var allBoxes = new Array({/literal}{$boxlist}{literal});

		// load content into all boxes
		for (i=0; i<allBoxes.length; i++) {
			$("#box_"+allBoxes[i]).load('/index/box/?box='+allBoxes[i]);
		}
			
	});

</script>
	
{/literal}

{include file='shared/htmlfooter.tpl'}