{* Main navigation include *}

<ul id="navigation">
	<li {if $controller eq "index"}class="selected"{/if}><a href="/">Overview</a></li>
	<li {if $controller eq "reports" && $action eq "month"}class="selected"{/if}><a href="/reports/month/">Month Report</a></li>
	<li {if $controller eq "reports" && $action eq "year"}class="selected"{/if}><a href="/reports/year/">Year Report</a></li>
	<li {if $controller eq "reports" && $action eq "number"}class="selected"{/if}><a href="/reports/number/">Number Report</a></li>
	<li {if $controller eq "search"}class="selected"{/if}><a href="/search/index/">Advanced Search</a></li>
</ul>
