<?php

// Create page object
$local_grid = new clocal_grid();
$MasterPage =& $Page;
$Page =& $local_grid;

// Page init
$local_grid->Page_Init();

// Page main
$local_grid->Page_Main();
?>
<?php if ($local->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var local_grid = new ew_Page("local_grid");

// page properties
local_grid.PageID = "grid"; // page ID
local_grid.FormID = "flocalgrid"; // form ID
var EW_PAGE_ID = local_grid.PageID; // for backward compatibility

// extend page with ValidateForm function
local_grid.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	var addcnt = 0;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		var chkthisrow = true;
		if (fobj.a_list && fobj.a_list.value == "gridinsert")
			chkthisrow = !(this.EmptyRow(fobj, infix));
		else
			chkthisrow = true;
		if (chkthisrow) {
			addcnt += 1;
		elm = fobj.elements["x" + infix + "_loc_nombre"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($local->loc_nombre->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_loc_direccion"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($local->loc_direccion->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_loc_vigente"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($local->loc_vigente->FldCaption()) ?>");

		// Set up row object
		var row = {};
		row["index"] = infix;
		for (var j = 0; j < fobj.elements.length; j++) {
			var el = fobj.elements[j];
			var len = infix.length + 2;
			if (el.name.substr(0, len) == "x" + infix + "_") {
				var elname = "x_" + el.name.substr(len);
				if (ewLang.isObject(row[elname])) { // already exists
					if (ewLang.isArray(row[elname])) {
						row[elname][row[elname].length] = el; // add to array
					} else {
						row[elname] = [row[elname], el]; // convert to array
					}
				} else {
					row[elname] = el;
				}
			}
		}
		fobj.row = row;

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
		} // End Grid Add checking
	}
	return true;
}

// Extend page with empty row check
local_grid.EmptyRow = function(fobj, infix) {
	if (ew_ValueChanged(fobj, infix, "emp_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "loc_nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "loc_direccion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "loc_vigente", false)) return false;
	if (ew_ValueChanged(fobj, infix, "loc_comuna", false)) return false;
	if (ew_ValueChanged(fobj, infix, "loc_ciudad", false)) return false;
	return true;
}

// extend page with Form_CustomValidate function
local_grid.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
local_grid.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
local_grid.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
local_grid.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<?php } ?>
<?php $local_grid->ShowPageHeader(); ?>
<?php
if ($local->CurrentAction == "gridadd") {
	if ($local->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$local_grid->TotalRecs = $local->SelectRecordCount();
			$local_grid->Recordset = $local_grid->LoadRecordset($local_grid->StartRec-1, $local_grid->DisplayRecs);
		} else {
			if ($local_grid->Recordset = $local_grid->LoadRecordset())
				$local_grid->TotalRecs = $local_grid->Recordset->RecordCount();
		}
		$local_grid->StartRec = 1;
		$local_grid->DisplayRecs = $local_grid->TotalRecs;
	} else {
		$local->CurrentFilter = "0=1";
		$local_grid->StartRec = 1;
		$local_grid->DisplayRecs = $local->GridAddRowCount;
	}
	$local_grid->TotalRecs = $local_grid->DisplayRecs;
	$local_grid->StopRec = $local_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$local_grid->TotalRecs = $local->SelectRecordCount();
	} else {
		if ($local_grid->Recordset = $local_grid->LoadRecordset())
			$local_grid->TotalRecs = $local_grid->Recordset->RecordCount();
	}
	$local_grid->StartRec = 1;
	$local_grid->DisplayRecs = $local_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$local_grid->Recordset = $local_grid->LoadRecordset($local_grid->StartRec-1, $local_grid->DisplayRecs);
}
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php if ($local->CurrentMode == "add" || $local->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($local->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $local->TableCaption() ?></p>
</p>
<?php
$local_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if (($local->CurrentMode == "add" || $local->CurrentMode == "copy" || $local->CurrentMode == "edit") && $local->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
<?php if ($local->AllowAddDeleteRow) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><?php echo $Language->Phrase("AddBlankRow") ?></a>&nbsp;&nbsp;
</span>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
<div id="gmp_local" class="ewGridMiddlePanel">
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $local->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$local_grid->RenderListOptions();

// Render list options (header, left)
$local_grid->ListOptions->Render("header", "left");
?>
<?php if ($local->loc_id->Visible) { // loc_id ?>
	<?php if ($local->SortUrl($local->loc_id) == "") { ?>
		<td><?php echo $local->loc_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $local->loc_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($local->loc_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($local->loc_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($local->emp_id->Visible) { // emp_id ?>
	<?php if ($local->SortUrl($local->emp_id) == "") { ?>
		<td><?php echo $local->emp_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $local->emp_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($local->emp_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($local->emp_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($local->loc_nombre->Visible) { // loc_nombre ?>
	<?php if ($local->SortUrl($local->loc_nombre) == "") { ?>
		<td><?php echo $local->loc_nombre->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $local->loc_nombre->FldCaption() ?></td><td style="width: 10px;"><?php if ($local->loc_nombre->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($local->loc_nombre->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($local->loc_direccion->Visible) { // loc_direccion ?>
	<?php if ($local->SortUrl($local->loc_direccion) == "") { ?>
		<td><?php echo $local->loc_direccion->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $local->loc_direccion->FldCaption() ?></td><td style="width: 10px;"><?php if ($local->loc_direccion->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($local->loc_direccion->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($local->loc_vigente->Visible) { // loc_vigente ?>
	<?php if ($local->SortUrl($local->loc_vigente) == "") { ?>
		<td><?php echo $local->loc_vigente->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $local->loc_vigente->FldCaption() ?></td><td style="width: 10px;"><?php if ($local->loc_vigente->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($local->loc_vigente->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($local->loc_comuna->Visible) { // loc_comuna ?>
	<?php if ($local->SortUrl($local->loc_comuna) == "") { ?>
		<td><?php echo $local->loc_comuna->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $local->loc_comuna->FldCaption() ?></td><td style="width: 10px;"><?php if ($local->loc_comuna->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($local->loc_comuna->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($local->loc_ciudad->Visible) { // loc_ciudad ?>
	<?php if ($local->SortUrl($local->loc_ciudad) == "") { ?>
		<td><?php echo $local->loc_ciudad->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $local->loc_ciudad->FldCaption() ?></td><td style="width: 10px;"><?php if ($local->loc_ciudad->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($local->loc_ciudad->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$local_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
$local_grid->StartRec = 1;
$local_grid->StopRec = $local_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = 0;
	if ($objForm->HasValue("key_count") && ($local->CurrentAction == "gridadd" || $local->CurrentAction == "gridedit" || $local->CurrentAction == "F")) {
		$local_grid->KeyCount = $objForm->GetValue("key_count");
		$local_grid->StopRec = $local_grid->KeyCount;
	}
}
$local_grid->RecCnt = $local_grid->StartRec - 1;
if ($local_grid->Recordset && !$local_grid->Recordset->EOF) {
	$local_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $local_grid->StartRec > 1)
		$local_grid->Recordset->Move($local_grid->StartRec - 1);
} elseif (!$local->AllowAddDeleteRow && $local_grid->StopRec == 0) {
	$local_grid->StopRec = $local->GridAddRowCount;
}

// Initialize aggregate
$local->RowType = EW_ROWTYPE_AGGREGATEINIT;
$local->ResetAttrs();
$local_grid->RenderRow();
$local_grid->RowCnt = 0;
if ($local->CurrentAction == "gridadd")
	$local_grid->RowIndex = 0;
if ($local->CurrentAction == "gridedit")
	$local_grid->RowIndex = 0;
while ($local_grid->RecCnt < $local_grid->StopRec) {
	$local_grid->RecCnt++;
	if (intval($local_grid->RecCnt) >= intval($local_grid->StartRec)) {
		$local_grid->RowCnt++;
		if ($local->CurrentAction == "gridadd" || $local->CurrentAction == "gridedit" || $local->CurrentAction == "F")
			$local_grid->RowIndex++;

		// Set up key count
		$local_grid->KeyCount = $local_grid->RowIndex;

		// Init row class and style
		$local->ResetAttrs();
		$local->CssClass = "";
		if ($local->CurrentAction == "gridadd") {
			if ($local->CurrentMode == "copy")
				$local_grid->LoadRowValues($local_grid->Recordset); // Load row values
			else
				$local_grid->LoadDefaultValues(); // Load default values
		} else {
			$local_grid->LoadRowValues($local_grid->Recordset); // Load row values
		}
		$local->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($local->CurrentAction == "gridadd") // Grid add
			$local->RowType = EW_ROWTYPE_ADD; // Render add
		if ($local->CurrentAction == "gridadd" && $local->EventCancelled) // Insert failed
			$local_grid->RestoreCurrentRowFormValues($local_grid->RowIndex); // Restore form values
		if ($local->CurrentAction == "gridedit") { // Grid edit
			if ($local->EventCancelled) {
				$local_grid->RestoreCurrentRowFormValues($local_grid->RowIndex); // Restore form values
			}
			if ($local_grid->RowAction == "insert")
				$local->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$local->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($local->CurrentAction == "gridedit" && ($local->RowType == EW_ROWTYPE_EDIT || $local->RowType == EW_ROWTYPE_ADD) && $local->EventCancelled) // Update failed
			$local_grid->RestoreCurrentRowFormValues($local_grid->RowIndex); // Restore form values
		if ($local->RowType == EW_ROWTYPE_EDIT) // Edit row
			$local_grid->EditRowCnt++;
		if ($local->CurrentAction == "F") // Confirm row
			$local_grid->RestoreCurrentRowFormValues($local_grid->RowIndex); // Restore form values
		if ($local->RowType == EW_ROWTYPE_ADD || $local->RowType == EW_ROWTYPE_EDIT) { // Add / Edit row
			if ($local->CurrentAction == "edit") {
				$local->RowAttrs = array();
				$local->CssClass = "ewTableEditRow";
			} else {
				$local->RowAttrs = array();
			}
			if (!empty($local_grid->RowIndex))
				$local->RowAttrs = array_merge($local->RowAttrs, array('data-rowindex'=>$local_grid->RowIndex, 'id'=>'r' . $local_grid->RowIndex . '_local'));
		} else {
			$local->RowAttrs = array();
		}

		// Render row
		$local_grid->RenderRow();

		// Render list options
		$local_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($local_grid->RowAction <> "delete" && $local_grid->RowAction <> "insertdelete" && !($local_grid->RowAction == "insert" && $local->CurrentAction == "F" && $local_grid->EmptyRow())) {
?>
	<tr<?php echo $local->RowAttributes() ?>>
<?php

// Render list options (body, left)
$local_grid->ListOptions->Render("body", "left");
?>
	<?php if ($local->loc_id->Visible) { // loc_id ?>
		<td<?php echo $local->loc_id->CellAttributes() ?>>
<?php if ($local->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_id" id="o<?php echo $local_grid->RowIndex ?>_loc_id" value="<?php echo ew_HtmlEncode($local->loc_id->OldValue) ?>">
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div<?php echo $local->loc_id->ViewAttributes() ?>><?php echo $local->loc_id->EditValue ?></div>
<input type="hidden" name="x<?php echo $local_grid->RowIndex ?>_loc_id" id="x<?php echo $local_grid->RowIndex ?>_loc_id" value="<?php echo ew_HtmlEncode($local->loc_id->CurrentValue) ?>">
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $local->loc_id->ViewAttributes() ?>><?php echo $local->loc_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $local_grid->RowIndex ?>_loc_id" id="x<?php echo $local_grid->RowIndex ?>_loc_id" value="<?php echo ew_HtmlEncode($local->loc_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_id" id="o<?php echo $local_grid->RowIndex ?>_loc_id" value="<?php echo ew_HtmlEncode($local->loc_id->OldValue) ?>">
<?php } ?>
<a name="<?php echo $local_grid->PageObjName . "_row_" . $local_grid->RowCnt ?>" id="<?php echo $local_grid->PageObjName . "_row_" . $local_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($local->emp_id->Visible) { // emp_id ?>
		<td<?php echo $local->emp_id->CellAttributes() ?>>
<?php if ($local->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($local->emp_id->getSessionValue() <> "") { ?>
<div<?php echo $local->emp_id->ViewAttributes() ?>><?php echo $local->emp_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $local_grid->RowIndex ?>_emp_id" name="x<?php echo $local_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($local->emp_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $local_grid->RowIndex ?>_emp_id" name="x<?php echo $local_grid->RowIndex ?>_emp_id"<?php echo $local->emp_id->EditAttributes() ?>>
<?php
if (is_array($local->emp_id->EditValue)) {
	$arwrk = $local->emp_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($local->emp_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $local->emp_id->OldValue = "";
?>
</select>
<?php } ?>
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_emp_id" id="o<?php echo $local_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($local->emp_id->OldValue) ?>">
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($local->emp_id->getSessionValue() <> "") { ?>
<div<?php echo $local->emp_id->ViewAttributes() ?>><?php echo $local->emp_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $local_grid->RowIndex ?>_emp_id" name="x<?php echo $local_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($local->emp_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $local_grid->RowIndex ?>_emp_id" name="x<?php echo $local_grid->RowIndex ?>_emp_id"<?php echo $local->emp_id->EditAttributes() ?>>
<?php
if (is_array($local->emp_id->EditValue)) {
	$arwrk = $local->emp_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($local->emp_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $local->emp_id->OldValue = "";
?>
</select>
<?php } ?>
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $local->emp_id->ViewAttributes() ?>><?php echo $local->emp_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $local_grid->RowIndex ?>_emp_id" id="x<?php echo $local_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($local->emp_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_emp_id" id="o<?php echo $local_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($local->emp_id->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($local->loc_nombre->Visible) { // loc_nombre ?>
		<td<?php echo $local->loc_nombre->CellAttributes() ?>>
<?php if ($local->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $local_grid->RowIndex ?>_loc_nombre" id="x<?php echo $local_grid->RowIndex ?>_loc_nombre" size="60" maxlength="32" value="<?php echo $local->loc_nombre->EditValue ?>"<?php echo $local->loc_nombre->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_nombre" id="o<?php echo $local_grid->RowIndex ?>_loc_nombre" value="<?php echo ew_HtmlEncode($local->loc_nombre->OldValue) ?>">
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $local_grid->RowIndex ?>_loc_nombre" id="x<?php echo $local_grid->RowIndex ?>_loc_nombre" size="60" maxlength="32" value="<?php echo $local->loc_nombre->EditValue ?>"<?php echo $local->loc_nombre->EditAttributes() ?>>
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $local->loc_nombre->ViewAttributes() ?>><?php echo $local->loc_nombre->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $local_grid->RowIndex ?>_loc_nombre" id="x<?php echo $local_grid->RowIndex ?>_loc_nombre" value="<?php echo ew_HtmlEncode($local->loc_nombre->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_nombre" id="o<?php echo $local_grid->RowIndex ?>_loc_nombre" value="<?php echo ew_HtmlEncode($local->loc_nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($local->loc_direccion->Visible) { // loc_direccion ?>
		<td<?php echo $local->loc_direccion->CellAttributes() ?>>
<?php if ($local->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $local_grid->RowIndex ?>_loc_direccion" id="x<?php echo $local_grid->RowIndex ?>_loc_direccion" size="60" maxlength="64" value="<?php echo $local->loc_direccion->EditValue ?>"<?php echo $local->loc_direccion->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_direccion" id="o<?php echo $local_grid->RowIndex ?>_loc_direccion" value="<?php echo ew_HtmlEncode($local->loc_direccion->OldValue) ?>">
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $local_grid->RowIndex ?>_loc_direccion" id="x<?php echo $local_grid->RowIndex ?>_loc_direccion" size="60" maxlength="64" value="<?php echo $local->loc_direccion->EditValue ?>"<?php echo $local->loc_direccion->EditAttributes() ?>>
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $local->loc_direccion->ViewAttributes() ?>><?php echo $local->loc_direccion->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $local_grid->RowIndex ?>_loc_direccion" id="x<?php echo $local_grid->RowIndex ?>_loc_direccion" value="<?php echo ew_HtmlEncode($local->loc_direccion->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_direccion" id="o<?php echo $local_grid->RowIndex ?>_loc_direccion" value="<?php echo ew_HtmlEncode($local->loc_direccion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($local->loc_vigente->Visible) { // loc_vigente ?>
		<td<?php echo $local->loc_vigente->CellAttributes() ?>>
<?php if ($local->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<div id="tp_x<?php echo $local_grid->RowIndex ?>_loc_vigente" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><label><input type="radio" name="x<?php echo $local_grid->RowIndex ?>_loc_vigente" id="x<?php echo $local_grid->RowIndex ?>_loc_vigente" value="{value}"<?php echo $local->loc_vigente->EditAttributes() ?>></label></div>
<div id="dsl_x<?php echo $local_grid->RowIndex ?>_loc_vigente" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $local->loc_vigente->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($local->loc_vigente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $local_grid->RowIndex ?>_loc_vigente" id="x<?php echo $local_grid->RowIndex ?>_loc_vigente" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $local->loc_vigente->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $local->loc_vigente->OldValue = "";
?>
</div>
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_vigente" id="o<?php echo $local_grid->RowIndex ?>_loc_vigente" value="<?php echo ew_HtmlEncode($local->loc_vigente->OldValue) ?>">
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="tp_x<?php echo $local_grid->RowIndex ?>_loc_vigente" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><label><input type="radio" name="x<?php echo $local_grid->RowIndex ?>_loc_vigente" id="x<?php echo $local_grid->RowIndex ?>_loc_vigente" value="{value}"<?php echo $local->loc_vigente->EditAttributes() ?>></label></div>
<div id="dsl_x<?php echo $local_grid->RowIndex ?>_loc_vigente" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $local->loc_vigente->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($local->loc_vigente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $local_grid->RowIndex ?>_loc_vigente" id="x<?php echo $local_grid->RowIndex ?>_loc_vigente" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $local->loc_vigente->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $local->loc_vigente->OldValue = "";
?>
</div>
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $local->loc_vigente->ViewAttributes() ?>><?php echo $local->loc_vigente->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $local_grid->RowIndex ?>_loc_vigente" id="x<?php echo $local_grid->RowIndex ?>_loc_vigente" value="<?php echo ew_HtmlEncode($local->loc_vigente->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_vigente" id="o<?php echo $local_grid->RowIndex ?>_loc_vigente" value="<?php echo ew_HtmlEncode($local->loc_vigente->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($local->loc_comuna->Visible) { // loc_comuna ?>
		<td<?php echo $local->loc_comuna->CellAttributes() ?>>
<?php if ($local->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $local_grid->RowIndex ?>_loc_comuna" id="x<?php echo $local_grid->RowIndex ?>_loc_comuna" size="30" maxlength="32" value="<?php echo $local->loc_comuna->EditValue ?>"<?php echo $local->loc_comuna->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_comuna" id="o<?php echo $local_grid->RowIndex ?>_loc_comuna" value="<?php echo ew_HtmlEncode($local->loc_comuna->OldValue) ?>">
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $local_grid->RowIndex ?>_loc_comuna" id="x<?php echo $local_grid->RowIndex ?>_loc_comuna" size="30" maxlength="32" value="<?php echo $local->loc_comuna->EditValue ?>"<?php echo $local->loc_comuna->EditAttributes() ?>>
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $local->loc_comuna->ViewAttributes() ?>><?php echo $local->loc_comuna->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $local_grid->RowIndex ?>_loc_comuna" id="x<?php echo $local_grid->RowIndex ?>_loc_comuna" value="<?php echo ew_HtmlEncode($local->loc_comuna->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_comuna" id="o<?php echo $local_grid->RowIndex ?>_loc_comuna" value="<?php echo ew_HtmlEncode($local->loc_comuna->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($local->loc_ciudad->Visible) { // loc_ciudad ?>
		<td<?php echo $local->loc_ciudad->CellAttributes() ?>>
<?php if ($local->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $local_grid->RowIndex ?>_loc_ciudad" id="x<?php echo $local_grid->RowIndex ?>_loc_ciudad" size="30" maxlength="10" value="<?php echo $local->loc_ciudad->EditValue ?>"<?php echo $local->loc_ciudad->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_ciudad" id="o<?php echo $local_grid->RowIndex ?>_loc_ciudad" value="<?php echo ew_HtmlEncode($local->loc_ciudad->OldValue) ?>">
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $local_grid->RowIndex ?>_loc_ciudad" id="x<?php echo $local_grid->RowIndex ?>_loc_ciudad" size="30" maxlength="10" value="<?php echo $local->loc_ciudad->EditValue ?>"<?php echo $local->loc_ciudad->EditAttributes() ?>>
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $local->loc_ciudad->ViewAttributes() ?>><?php echo $local->loc_ciudad->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $local_grid->RowIndex ?>_loc_ciudad" id="x<?php echo $local_grid->RowIndex ?>_loc_ciudad" value="<?php echo ew_HtmlEncode($local->loc_ciudad->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_ciudad" id="o<?php echo $local_grid->RowIndex ?>_loc_ciudad" value="<?php echo ew_HtmlEncode($local->loc_ciudad->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$local_grid->ListOptions->Render("body", "right");
?>
	</tr>
<?php if ($local->RowType == EW_ROWTYPE_ADD) { ?>
<?php } ?>
<?php if ($local->RowType == EW_ROWTYPE_EDIT) { ?>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($local->CurrentAction <> "gridadd" || $local->CurrentMode == "copy")
		if (!$local_grid->Recordset->EOF) $local_grid->Recordset->MoveNext();
}
?>
<?php
	if ($local->CurrentMode == "add" || $local->CurrentMode == "copy" || $local->CurrentMode == "edit") {
		$local_grid->RowIndex = '$rowindex$';
		$local_grid->LoadDefaultValues();

		// Set row properties
		$local->ResetAttrs();
		$local->RowAttrs = array();
		if (!empty($local_grid->RowIndex))
			$local->RowAttrs = array_merge($local->RowAttrs, array('data-rowindex'=>$local_grid->RowIndex, 'id'=>'r' . $local_grid->RowIndex . '_local'));
		$local->RowType = EW_ROWTYPE_ADD;

		// Render row
		$local_grid->RenderRow();

		// Render list options
		$local_grid->RenderListOptions();

		// Add id and class to the template row
		$local->RowAttrs["id"] = "r0_local";
		ew_AppendClass($local->RowAttrs["class"], "ewTemplate");
?>
	<tr<?php echo $local->RowAttributes() ?>>
<?php

// Render list options (body, left)
$local_grid->ListOptions->Render("body", "left");
?>
	<?php if ($local->loc_id->Visible) { // loc_id ?>
		<td>&nbsp;</td>
	<?php } ?>
	<?php if ($local->emp_id->Visible) { // emp_id ?>
		<td>
<?php if ($local->emp_id->getSessionValue() <> "") { ?>
<div<?php echo $local->emp_id->ViewAttributes() ?>><?php echo $local->emp_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $local_grid->RowIndex ?>_emp_id" name="x<?php echo $local_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($local->emp_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $local_grid->RowIndex ?>_emp_id" name="x<?php echo $local_grid->RowIndex ?>_emp_id"<?php echo $local->emp_id->EditAttributes() ?>>
<?php
if (is_array($local->emp_id->EditValue)) {
	$arwrk = $local->emp_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($local->emp_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $local->emp_id->OldValue = "";
?>
</select>
<?php } ?>
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_emp_id" id="o<?php echo $local_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($local->emp_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($local->loc_nombre->Visible) { // loc_nombre ?>
		<td>
<input type="text" name="x<?php echo $local_grid->RowIndex ?>_loc_nombre" id="x<?php echo $local_grid->RowIndex ?>_loc_nombre" size="60" maxlength="32" value="<?php echo $local->loc_nombre->EditValue ?>"<?php echo $local->loc_nombre->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_nombre" id="o<?php echo $local_grid->RowIndex ?>_loc_nombre" value="<?php echo ew_HtmlEncode($local->loc_nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($local->loc_direccion->Visible) { // loc_direccion ?>
		<td>
<input type="text" name="x<?php echo $local_grid->RowIndex ?>_loc_direccion" id="x<?php echo $local_grid->RowIndex ?>_loc_direccion" size="60" maxlength="64" value="<?php echo $local->loc_direccion->EditValue ?>"<?php echo $local->loc_direccion->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_direccion" id="o<?php echo $local_grid->RowIndex ?>_loc_direccion" value="<?php echo ew_HtmlEncode($local->loc_direccion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($local->loc_vigente->Visible) { // loc_vigente ?>
		<td>
<div id="tp_x<?php echo $local_grid->RowIndex ?>_loc_vigente" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><label><input type="radio" name="x<?php echo $local_grid->RowIndex ?>_loc_vigente" id="x<?php echo $local_grid->RowIndex ?>_loc_vigente" value="{value}"<?php echo $local->loc_vigente->EditAttributes() ?>></label></div>
<div id="dsl_x<?php echo $local_grid->RowIndex ?>_loc_vigente" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $local->loc_vigente->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($local->loc_vigente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x<?php echo $local_grid->RowIndex ?>_loc_vigente" id="x<?php echo $local_grid->RowIndex ?>_loc_vigente" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $local->loc_vigente->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $local->loc_vigente->OldValue = "";
?>
</div>
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_vigente" id="o<?php echo $local_grid->RowIndex ?>_loc_vigente" value="<?php echo ew_HtmlEncode($local->loc_vigente->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($local->loc_comuna->Visible) { // loc_comuna ?>
		<td>
<input type="text" name="x<?php echo $local_grid->RowIndex ?>_loc_comuna" id="x<?php echo $local_grid->RowIndex ?>_loc_comuna" size="30" maxlength="32" value="<?php echo $local->loc_comuna->EditValue ?>"<?php echo $local->loc_comuna->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_comuna" id="o<?php echo $local_grid->RowIndex ?>_loc_comuna" value="<?php echo ew_HtmlEncode($local->loc_comuna->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($local->loc_ciudad->Visible) { // loc_ciudad ?>
		<td>
<input type="text" name="x<?php echo $local_grid->RowIndex ?>_loc_ciudad" id="x<?php echo $local_grid->RowIndex ?>_loc_ciudad" size="30" maxlength="10" value="<?php echo $local->loc_ciudad->EditValue ?>"<?php echo $local->loc_ciudad->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $local_grid->RowIndex ?>_loc_ciudad" id="o<?php echo $local_grid->RowIndex ?>_loc_ciudad" value="<?php echo ew_HtmlEncode($local->loc_ciudad->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$local_grid->ListOptions->Render("body", "right");
?>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($local->CurrentMode == "add" || $local->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $local_grid->KeyCount ?>">
<?php echo $local_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($local->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $local_grid->KeyCount ?>">
<?php echo $local_grid->MultiSelectKey ?>
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="local_grid">
</div>
<?php

// Close recordset
if ($local_grid->Recordset)
	$local_grid->Recordset->Close();
?>
<?php if (($local->CurrentMode == "add" || $local->CurrentMode == "copy" || $local->CurrentMode == "edit") && $local->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridLowerPanel">
<?php if ($local->AllowAddDeleteRow) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><?php echo $Language->Phrase("AddBlankRow") ?></a>&nbsp;&nbsp;
</span>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($local->Export == "" && $local->CurrentAction == "") { ?>
<?php } ?>
<?php
$local_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$local_grid->Page_Terminate();
$Page =& $MasterPage;
?>
