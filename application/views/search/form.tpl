{* Designed to be included in other templates *}

<form method="POST" action="/search/results/" onsubmit="return validateAdvancedSearch();">

<table class="form" id="advancedsearch">

	<tbody>

		<tr id="daterow">
			<td class="label">Date range</td>
			<td class="value" nowrap>
				<input type="text" class="datepicker" name="date_from" size="12" value="{$date_from}" readonly />
				to
				<input type="text" class="datepicker" name="date_to" size="12" value="{$date_to}" readonly />
			</td>
		</tr>
	
	</tbody>
	
	<tfoot>
	
		<tr>
			<td class="buttonbar" colspan="2" nowrap>
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
	newRow = $('<tr id="criteria_row_'+totalRows+'"></tr>');

	// add label cell
	$(newRow).append($('<td class="label" nowrap>Criteria '+totalRows+'</td>'));

	// create new cell
	newCell = $('<td class="value" nowrap></td>');

	// build field menu
	fieldMenu = $('<select id="field_'+totalRows+'" name="field_'+totalRows+'"></select>');
	for (var field in cdrFields) {
		$(fieldMenu).append($('<option value="'+field+'">'+cdrFields[field]+'</option>'));
	}
	$(newCell).append(fieldMenu);

	// build operator menu
	opMenu = $('<select id="operator_'+totalRows+'" name="operator_'+totalRows+'"></select>');
	$(opMenu).append($('<option value="contains">contains</option>'));
	$(opMenu).append($('<option value="equals">exactly equals</option>'));
	$(opMenu).append($('<option value="ltet">is less than or equal to</option>'));
	$(opMenu).append($('<option value="gtet">is greater than or equal to</option>'));
	$(newCell).append(opMenu);

	// add text field
	textField = $('<input type="text" id="criteria_'+totalRows+'" name="criteria_'+totalRows+'" size="20" />');
	$(newCell).append(textField);

	// add row delete button
	if (totalRows > 1) {
		cancelButton = $('<a href="javascript:void(0);" onclick="deleteCriteriaRow('+totalRows+');"><img src="/images/icons/delete.png" width="16" height="16" border="0" alt="Delete criteria" valign="top" /></a>');
		$(newCell).append(cancelButton);
	}
	
	// add cell to row and row to table
	$(newRow).append(newCell);
	$("#advancedsearch").append(newRow);

}

// delete a criteria row
function deleteCriteriaRow(rowID) {
	if (document.getElementById('criteria_row_'+rowID)) {
		$('#criteria_row_'+rowID).remove();
	}
}

// validate form
function validateAdvancedSearch() {

	// check that criteria boxes each have at least 3 characters
	for (i=1; i<=totalRows; i++) {
		if (document.getElementById('criteria_'+i)) {
			criteria = document.getElementById('criteria_'+i).value;
			if (criteria.length < 3) {
				alert("Criteria "+totalRows+" must be at least three characters in length.");
				return false;
			}
		}
	}
	
	return true;

}

{/literal}

// start total rows count
var totalRows = 0;

{if $criteria}

	// add initial criteria rows and pre-populate

	for (i=0; i<{$criteria|@count}; i++) {
		addCriteriaRow();
	}

	{foreach from=$criteria key=id item=crit}
		document.getElementById('field_{$id+1}').value = '{$crit.field}';
		document.getElementById('operator_{$id+1}').value = '{$crit.operator}';
		document.getElementById('criteria_{$id+1}').value = '{$crit.keywords}';
	{/foreach}
	
{else}

	// add initial criteria row
	addCriteriaRow();
	
{/if}

</script>
