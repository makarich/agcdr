{* Navigation include *}

<ul id="navigation">
	<li {if $controller eq "index"}class="selected"{/if}><a href="/">Overview</a></li>
	<li {if $controller eq "reports" && $action eq "month"}class="selected"{/if}><a href="/reports/month/">Month Report</a></li>
	<li {if $controller eq "reports" && $action eq "year"}class="selected"{/if}><a href="/reports/year/">Year Report</a></li>
	<li {if $controller eq "reports" && $action eq "quick_search"}class="selected"{/if}><a href="/reports/quick_search/">Quick Search</a></li>
	<li {if $controller eq "reports" && $action eq "advanced_search"}class="selected"{/if}><a href="/reports/advanced_search/">Advanced Search</a></li>
	<li {if $controller eq "help" && $action eq "index"}class="selected"{/if}><a href="/help/index/">Help & Support</a></li>
</ul>
