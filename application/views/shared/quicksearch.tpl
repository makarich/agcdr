{* Quick search box *}

<form method="POST" action="/search/results/" onsubmit="return quickSearch();">

<div id="quicksearch">
	Quick search:
	<input type="text" name="quicksearch" id="quicksearchstr" size="25" value="{$quicksearch}" placeholder="Quick search" />
</div>

</form>

{literal}

<script type="text/javascript">

// check that quick search keywords are sane before submitting
function quickSearch() {
	
	var searchStr = document.getElementById('quicksearchstr').value;
	
	if (searchStr.length < 3) {
		alert("Quick search keyword must be at least three characters in length.");
		return false;
	}
	
	return true;
	
}

</script>

{/literal}
