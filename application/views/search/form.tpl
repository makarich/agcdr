{* Designed to be included in other templates *}

<form method="POST" action="/search/results/" onsubmit="return validateAdvancedSearch();">

<table class="form" width="100%" id="advancedsearch">

	<tbody>

	<tr id="daterow">
		<td class="label">Date range</td>
		<td class="value">
			<input type="text" class="datepicker" name="date_from" size="10" value="{$smarty.now|date_format:"%m/%d/%Y"}" readonly />
			to
			<input type="text" class="datepicker" name="date_to" size="10" value="{$smarty.now|date_format:"%m/%d/%Y"}" readonly />
		</td>
	</tr>
	
	</tbody>
	
	<tfoot>
		<tr>
			<td class="buttonbar" colspan="2">
				<button type="button" onclick="addCriteriaRow();">{icon name="add"}&nbsp;&nbsp;Add criteria</button>
				<button type="submit">{icon name="search"}&nbsp;&nbsp;Search</button>
			</td>
		</tr>
	</tfoot>

</table>

</form>

{literal}

<script type="text/javascript">

// table field array (excluding date/time)
var cdrFields = {
	"clid"		: "Caller ID",
	"src"		: "Source",
	"dst"		: "Destination",
	"dcontext"	: "Context",
	"channel"	: "Channel",
	"dstchannel"	: "Destination channel",
	"lastapp"	: "Last application",
	"lastdata"	: "Last data",
	"duration"	: "Duration",
	"billsec"	: "Billsec",
	"disposition"	: "Disposition",
	"amaflags"	: "AMA flags",
	"accountcode"	: "Account code",
	"userfield"	: "User field",
	"uniqueid"	: "Unique ID"
};

// add a criteria row
function addCriteriaRow() {

	// increment row count
	totalRows = totalRows + 1;

	// create row object
	newRow = $('<tr></tr>');

	// add label cell
	$(newRow).append($('<td class="label">Criteria '+totalRows+'</td>'));

	// create new cell
	newCell = $('<td class="value"></td>');

	// build field menu
	fieldMenu = $('<select name="field_'+totalRows+'"></select>');
	for (var field in cdrFields) {
		$(fieldMenu).append($('<option value="'+field+'">'+cdrFields[field]+'</option>'));
	}
	$(newCell).append(fieldMenu);

	// build operator menu
	opMenu = $('<select name="operator_'+totalRows+'"></select>');
	$(opMenu).append($('<option value="contains">contains</option>'));
	$(opMenu).append($('<option value="equals">exactly equals</option>'));
	$(opMenu).append($('<option value="ltet">is less than or equal to</option>'));
	$(opMenu).append($('<option value="gtet">is greater than or equal to</option>'));
	$(newCell).append(opMenu);

	// add text field
	textField = $('<input type="text" name="criteria_'+totalRows+'" size="20" />');
	$(newCell).append(textField);
	
	// add cell to row and row to table
	$(newRow).append(newCell);
	$("#advancedsearch").append(newRow);

}

// validate form
function validateAdvancedSearch() {

	return false;

}

// add initial criteria row
var totalRows = 0;
addCriteriaRow();

</script>

{/literal}
