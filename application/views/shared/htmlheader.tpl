<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	
<html lang="en">

<head>

	<title>{if $title}{$title}{/if}</title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="version" name="{$smarty.const.VERSION}" />
	
	<!-- General CSS and javascript -->
	<link rel="stylesheet" type="text/css" media="all" href="/css/stylesheet-min.css" />
	<link rel="stylesheet" type="text/css" media="print" href="/css/print-min.css" />
	<script type="text/javascript" src="/js/javascript-min.js"></script>
	<script type="text/javascript" src="/js/modernizr-1.6-min.js"></script>
	
	<!-- jQuery -->
	<link rel="stylesheet" type="text/css" href="/libraries/jquery-ui-1.8.10.custom/css/cupertino/jquery-ui-1.8.10.custom.css"/>
	<script type="text/javascript" src="/libraries/jquery-ui-1.8.10.custom/js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="/libraries/jquery-ui-1.8.10.custom/js/jquery-ui-1.8.10.custom.min.js"></script>
	<script type="text/javascript" src="/libraries/DataTables-1.7.5/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="/js/jquery.dataTables.extensions-min.js"></script>
	<link rel="stylesheet" type="text/css" href="/css/demo_table_jui-min.css"/>
	
	<!-- Superfish navigation -->
	<link rel="stylesheet" media="screen" href="/css/superfish-min.css" /> 
	<link rel="stylesheet" media="screen" href="/css/superfish-navbar-min.css" />
	<script type="text/javascript" src="/libraries/superfish-1.4.8/js/superfish.js"></script>
	<script type="text/javascript" src="/libraries/superfish-1.4.8/js/hoverIntent.js"></script>

</head>

<body>

{if "DEVINFO"|defined}<div id="devinfo" onclick="this.style.display='none';">{$smarty.const.DEVINFO}</div>{/if}

<div id="frame">

<h1>{$smarty.const.LONG_TITLE}</h1>

{include file='shared/navigation.tpl'}
