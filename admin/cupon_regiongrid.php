<?php

// Create page object
$cupon_region_grid = new ccupon_region_grid();
$MasterPage =& $Page;
$Page =& $cupon_region_grid;

// Page init
$cupon_region_grid->Page_Init();

// Page main
$cupon_region_grid->Page_Main();
?>
<?php if ($cupon_region->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cupon_region_grid = new ew_Page("cupon_region_grid");

// page properties
cupon_region_grid.PageID = "grid"; // page ID
cupon_region_grid.FormID = "fcupon_regiongrid"; // form ID
var EW_PAGE_ID = cupon_region_grid.PageID; // for backward compatibility

// extend page with ValidateForm function
cupon_region_grid.ValidateForm = function(fobj) {
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
cupon_region_grid.EmptyRow = function(fobj, infix) {
	if (ew_ValueChanged(fobj, infix, "cup_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "reg_id", false)) return false;
	return true;
}

// extend page with Form_CustomValidate function
cupon_region_grid.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cupon_region_grid.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cupon_region_grid.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cupon_region_grid.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<?php } ?>
<?php $cupon_region_grid->ShowPageHeader(); ?>
<?php
if ($cupon_region->CurrentAction == "gridadd") {
	if ($cupon_region->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$cupon_region_grid->TotalRecs = $cupon_region->SelectRecordCount();
			$cupon_region_grid->Recordset = $cupon_region_grid->LoadRecordset($cupon_region_grid->StartRec-1, $cupon_region_grid->DisplayRecs);
		} else {
			if ($cupon_region_grid->Recordset = $cupon_region_grid->LoadRecordset())
				$cupon_region_grid->TotalRecs = $cupon_region_grid->Recordset->RecordCount();
		}
		$cupon_region_grid->StartRec = 1;
		$cupon_region_grid->DisplayRecs = $cupon_region_grid->TotalRecs;
	} else {
		$cupon_region->CurrentFilter = "0=1";
		$cupon_region_grid->StartRec = 1;
		$cupon_region_grid->DisplayRecs = $cupon_region->GridAddRowCount;
	}
	$cupon_region_grid->TotalRecs = $cupon_region_grid->DisplayRecs;
	$cupon_region_grid->StopRec = $cupon_region_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cupon_region_grid->TotalRecs = $cupon_region->SelectRecordCount();
	} else {
		if ($cupon_region_grid->Recordset = $cupon_region_grid->LoadRecordset())
			$cupon_region_grid->TotalRecs = $cupon_region_grid->Recordset->RecordCount();
	}
	$cupon_region_grid->StartRec = 1;
	$cupon_region_grid->DisplayRecs = $cupon_region_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cupon_region_grid->Recordset = $cupon_region_grid->LoadRecordset($cupon_region_grid->StartRec-1, $cupon_region_grid->DisplayRecs);
}
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php if ($cupon_region->CurrentMode == "add" || $cupon_region->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($cupon_region->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cupon_region->TableCaption() ?></p>
</p>
<?php
$cupon_region_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if (($cupon_region->CurrentMode == "add" || $cupon_region->CurrentMode == "copy" || $cupon_region->CurrentMode == "edit") && $cupon_region->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
<?php if ($cupon_region->AllowAddDeleteRow) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><?php echo $Language->Phrase("AddBlankRow") ?></a>&nbsp;&nbsp;
</span>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
<div id="gmp_cupon_region" class="ewGridMiddlePanel">
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $cupon_region->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cupon_region_grid->RenderListOptions();

// Render list options (header, left)
$cupon_region_grid->ListOptions->Render("header", "left");
?>
<?php if ($cupon_region->crg_id->Visible) { // crg_id ?>
	<?php if ($cupon_region->SortUrl($cupon_region->crg_id) == "") { ?>
		<td><?php echo $cupon_region->crg_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon_region->crg_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon_region->crg_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon_region->crg_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cupon_region->cup_id->Visible) { // cup_id ?>
	<?php if ($cupon_region->SortUrl($cupon_region->cup_id) == "") { ?>
		<td><?php echo $cupon_region->cup_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon_region->cup_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon_region->cup_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon_region->cup_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cupon_region->reg_id->Visible) { // reg_id ?>
	<?php if ($cupon_region->SortUrl($cupon_region->reg_id) == "") { ?>
		<td><?php echo $cupon_region->reg_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon_region->reg_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon_region->reg_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon_region->reg_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cupon_region_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
$cupon_region_grid->StartRec = 1;
$cupon_region_grid->StopRec = $cupon_region_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = 0;
	if ($objForm->HasValue("key_count") && ($cupon_region->CurrentAction == "gridadd" || $cupon_region->CurrentAction == "gridedit" || $cupon_region->CurrentAction == "F")) {
		$cupon_region_grid->KeyCount = $objForm->GetValue("key_count");
		$cupon_region_grid->StopRec = $cupon_region_grid->KeyCount;
	}
}
$cupon_region_grid->RecCnt = $cupon_region_grid->StartRec - 1;
if ($cupon_region_grid->Recordset && !$cupon_region_grid->Recordset->EOF) {
	$cupon_region_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $cupon_region_grid->StartRec > 1)
		$cupon_region_grid->Recordset->Move($cupon_region_grid->StartRec - 1);
} elseif (!$cupon_region->AllowAddDeleteRow && $cupon_region_grid->StopRec == 0) {
	$cupon_region_grid->StopRec = $cupon_region->GridAddRowCount;
}

// Initialize aggregate
$cupon_region->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cupon_region->ResetAttrs();
$cupon_region_grid->RenderRow();
$cupon_region_grid->RowCnt = 0;
if ($cupon_region->CurrentAction == "gridadd")
	$cupon_region_grid->RowIndex = 0;
if ($cupon_region->CurrentAction == "gridedit")
	$cupon_region_grid->RowIndex = 0;
while ($cupon_region_grid->RecCnt < $cupon_region_grid->StopRec) {
	$cupon_region_grid->RecCnt++;
	if (intval($cupon_region_grid->RecCnt) >= intval($cupon_region_grid->StartRec)) {
		$cupon_region_grid->RowCnt++;
		if ($cupon_region->CurrentAction == "gridadd" || $cupon_region->CurrentAction == "gridedit" || $cupon_region->CurrentAction == "F")
			$cupon_region_grid->RowIndex++;

		// Set up key count
		$cupon_region_grid->KeyCount = $cupon_region_grid->RowIndex;

		// Init row class and style
		$cupon_region->ResetAttrs();
		$cupon_region->CssClass = "";
		if ($cupon_region->CurrentAction == "gridadd") {
			if ($cupon_region->CurrentMode == "copy")
				$cupon_region_grid->LoadRowValues($cupon_region_grid->Recordset); // Load row values
			else
				$cupon_region_grid->LoadDefaultValues(); // Load default values
		} else {
			$cupon_region_grid->LoadRowValues($cupon_region_grid->Recordset); // Load row values
		}
		$cupon_region->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cupon_region->CurrentAction == "gridadd") // Grid add
			$cupon_region->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cupon_region->CurrentAction == "gridadd" && $cupon_region->EventCancelled) // Insert failed
			$cupon_region_grid->RestoreCurrentRowFormValues($cupon_region_grid->RowIndex); // Restore form values
		if ($cupon_region->CurrentAction == "gridedit") { // Grid edit
			if ($cupon_region->EventCancelled) {
				$cupon_region_grid->RestoreCurrentRowFormValues($cupon_region_grid->RowIndex); // Restore form values
			}
			if ($cupon_region_grid->RowAction == "insert")
				$cupon_region->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cupon_region->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cupon_region->CurrentAction == "gridedit" && ($cupon_region->RowType == EW_ROWTYPE_EDIT || $cupon_region->RowType == EW_ROWTYPE_ADD) && $cupon_region->EventCancelled) // Update failed
			$cupon_region_grid->RestoreCurrentRowFormValues($cupon_region_grid->RowIndex); // Restore form values
		if ($cupon_region->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cupon_region_grid->EditRowCnt++;
		if ($cupon_region->CurrentAction == "F") // Confirm row
			$cupon_region_grid->RestoreCurrentRowFormValues($cupon_region_grid->RowIndex); // Restore form values
		if ($cupon_region->RowType == EW_ROWTYPE_ADD || $cupon_region->RowType == EW_ROWTYPE_EDIT) { // Add / Edit row
			if ($cupon_region->CurrentAction == "edit") {
				$cupon_region->RowAttrs = array();
				$cupon_region->CssClass = "ewTableEditRow";
			} else {
				$cupon_region->RowAttrs = array();
			}
			if (!empty($cupon_region_grid->RowIndex))
				$cupon_region->RowAttrs = array_merge($cupon_region->RowAttrs, array('data-rowindex'=>$cupon_region_grid->RowIndex, 'id'=>'r' . $cupon_region_grid->RowIndex . '_cupon_region'));
		} else {
			$cupon_region->RowAttrs = array();
		}

		// Render row
		$cupon_region_grid->RenderRow();

		// Render list options
		$cupon_region_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cupon_region_grid->RowAction <> "delete" && $cupon_region_grid->RowAction <> "insertdelete" && !($cupon_region_grid->RowAction == "insert" && $cupon_region->CurrentAction == "F" && $cupon_region_grid->EmptyRow())) {
?>
	<tr<?php echo $cupon_region->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cupon_region_grid->ListOptions->Render("body", "left");
?>
	<?php if ($cupon_region->crg_id->Visible) { // crg_id ?>
		<td<?php echo $cupon_region->crg_id->CellAttributes() ?>>
<?php if ($cupon_region->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $cupon_region_grid->RowIndex ?>_crg_id" id="o<?php echo $cupon_region_grid->RowIndex ?>_crg_id" value="<?php echo ew_HtmlEncode($cupon_region->crg_id->OldValue) ?>">
<?php } ?>
<?php if ($cupon_region->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div<?php echo $cupon_region->crg_id->ViewAttributes() ?>><?php echo $cupon_region->crg_id->EditValue ?></div>
<input type="hidden" name="x<?php echo $cupon_region_grid->RowIndex ?>_crg_id" id="x<?php echo $cupon_region_grid->RowIndex ?>_crg_id" value="<?php echo ew_HtmlEncode($cupon_region->crg_id->CurrentValue) ?>">
<?php } ?>
<?php if ($cupon_region->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cupon_region->crg_id->ViewAttributes() ?>><?php echo $cupon_region->crg_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $cupon_region_grid->RowIndex ?>_crg_id" id="x<?php echo $cupon_region_grid->RowIndex ?>_crg_id" value="<?php echo ew_HtmlEncode($cupon_region->crg_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cupon_region_grid->RowIndex ?>_crg_id" id="o<?php echo $cupon_region_grid->RowIndex ?>_crg_id" value="<?php echo ew_HtmlEncode($cupon_region->crg_id->OldValue) ?>">
<?php } ?>
<a name="<?php echo $cupon_region_grid->PageObjName . "_row_" . $cupon_region_grid->RowCnt ?>" id="<?php echo $cupon_region_grid->PageObjName . "_row_" . $cupon_region_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cupon_region->cup_id->Visible) { // cup_id ?>
		<td<?php echo $cupon_region->cup_id->CellAttributes() ?>>
<?php if ($cupon_region->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cupon_region->cup_id->getSessionValue() <> "") { ?>
<div<?php echo $cupon_region->cup_id->ViewAttributes() ?>><?php echo $cupon_region->cup_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id" name="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_region->cup_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id" name="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id"<?php echo $cupon_region->cup_id->EditAttributes() ?>>
<?php
if (is_array($cupon_region->cup_id->EditValue)) {
	$arwrk = $cupon_region->cup_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_region->cup_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cupon_region->cup_id->OldValue = "";
?>
</select>
<?php } ?>
<input type="hidden" name="o<?php echo $cupon_region_grid->RowIndex ?>_cup_id" id="o<?php echo $cupon_region_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_region->cup_id->OldValue) ?>">
<?php } ?>
<?php if ($cupon_region->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cupon_region->cup_id->getSessionValue() <> "") { ?>
<div<?php echo $cupon_region->cup_id->ViewAttributes() ?>><?php echo $cupon_region->cup_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id" name="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_region->cup_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id" name="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id"<?php echo $cupon_region->cup_id->EditAttributes() ?>>
<?php
if (is_array($cupon_region->cup_id->EditValue)) {
	$arwrk = $cupon_region->cup_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_region->cup_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cupon_region->cup_id->OldValue = "";
?>
</select>
<?php } ?>
<?php } ?>
<?php if ($cupon_region->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cupon_region->cup_id->ViewAttributes() ?>><?php echo $cupon_region->cup_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id" id="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_region->cup_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cupon_region_grid->RowIndex ?>_cup_id" id="o<?php echo $cupon_region_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_region->cup_id->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cupon_region->reg_id->Visible) { // reg_id ?>
		<td<?php echo $cupon_region->reg_id->CellAttributes() ?>>
<?php if ($cupon_region->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $cupon_region_grid->RowIndex ?>_reg_id" name="x<?php echo $cupon_region_grid->RowIndex ?>_reg_id"<?php echo $cupon_region->reg_id->EditAttributes() ?>>
<?php
if (is_array($cupon_region->reg_id->EditValue)) {
	$arwrk = $cupon_region->reg_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_region->reg_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cupon_region->reg_id->OldValue = "";
?>
</select>
<input type="hidden" name="o<?php echo $cupon_region_grid->RowIndex ?>_reg_id" id="o<?php echo $cupon_region_grid->RowIndex ?>_reg_id" value="<?php echo ew_HtmlEncode($cupon_region->reg_id->OldValue) ?>">
<?php } ?>
<?php if ($cupon_region->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cupon_region_grid->RowIndex ?>_reg_id" name="x<?php echo $cupon_region_grid->RowIndex ?>_reg_id"<?php echo $cupon_region->reg_id->EditAttributes() ?>>
<?php
if (is_array($cupon_region->reg_id->EditValue)) {
	$arwrk = $cupon_region->reg_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_region->reg_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cupon_region->reg_id->OldValue = "";
?>
</select>
<?php } ?>
<?php if ($cupon_region->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cupon_region->reg_id->ViewAttributes() ?>><?php echo $cupon_region->reg_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $cupon_region_grid->RowIndex ?>_reg_id" id="x<?php echo $cupon_region_grid->RowIndex ?>_reg_id" value="<?php echo ew_HtmlEncode($cupon_region->reg_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cupon_region_grid->RowIndex ?>_reg_id" id="o<?php echo $cupon_region_grid->RowIndex ?>_reg_id" value="<?php echo ew_HtmlEncode($cupon_region->reg_id->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cupon_region_grid->ListOptions->Render("body", "right");
?>
	</tr>
<?php if ($cupon_region->RowType == EW_ROWTYPE_ADD) { ?>
<?php } ?>
<?php if ($cupon_region->RowType == EW_ROWTYPE_EDIT) { ?>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cupon_region->CurrentAction <> "gridadd" || $cupon_region->CurrentMode == "copy")
		if (!$cupon_region_grid->Recordset->EOF) $cupon_region_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cupon_region->CurrentMode == "add" || $cupon_region->CurrentMode == "copy" || $cupon_region->CurrentMode == "edit") {
		$cupon_region_grid->RowIndex = '$rowindex$';
		$cupon_region_grid->LoadDefaultValues();

		// Set row properties
		$cupon_region->ResetAttrs();
		$cupon_region->RowAttrs = array();
		if (!empty($cupon_region_grid->RowIndex))
			$cupon_region->RowAttrs = array_merge($cupon_region->RowAttrs, array('data-rowindex'=>$cupon_region_grid->RowIndex, 'id'=>'r' . $cupon_region_grid->RowIndex . '_cupon_region'));
		$cupon_region->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cupon_region_grid->RenderRow();

		// Render list options
		$cupon_region_grid->RenderListOptions();

		// Add id and class to the template row
		$cupon_region->RowAttrs["id"] = "r0_cupon_region";
		ew_AppendClass($cupon_region->RowAttrs["class"], "ewTemplate");
?>
	<tr<?php echo $cupon_region->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cupon_region_grid->ListOptions->Render("body", "left");
?>
	<?php if ($cupon_region->crg_id->Visible) { // crg_id ?>
		<td>&nbsp;</td>
	<?php } ?>
	<?php if ($cupon_region->cup_id->Visible) { // cup_id ?>
		<td>
<?php if ($cupon_region->cup_id->getSessionValue() <> "") { ?>
<div<?php echo $cupon_region->cup_id->ViewAttributes() ?>><?php echo $cupon_region->cup_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id" name="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_region->cup_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id" name="x<?php echo $cupon_region_grid->RowIndex ?>_cup_id"<?php echo $cupon_region->cup_id->EditAttributes() ?>>
<?php
if (is_array($cupon_region->cup_id->EditValue)) {
	$arwrk = $cupon_region->cup_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_region->cup_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cupon_region->cup_id->OldValue = "";
?>
</select>
<?php } ?>
<input type="hidden" name="o<?php echo $cupon_region_grid->RowIndex ?>_cup_id" id="o<?php echo $cupon_region_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_region->cup_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cupon_region->reg_id->Visible) { // reg_id ?>
		<td>
<select id="x<?php echo $cupon_region_grid->RowIndex ?>_reg_id" name="x<?php echo $cupon_region_grid->RowIndex ?>_reg_id"<?php echo $cupon_region->reg_id->EditAttributes() ?>>
<?php
if (is_array($cupon_region->reg_id->EditValue)) {
	$arwrk = $cupon_region->reg_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_region->reg_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cupon_region->reg_id->OldValue = "";
?>
</select>
<input type="hidden" name="o<?php echo $cupon_region_grid->RowIndex ?>_reg_id" id="o<?php echo $cupon_region_grid->RowIndex ?>_reg_id" value="<?php echo ew_HtmlEncode($cupon_region->reg_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cupon_region_grid->ListOptions->Render("body", "right");
?>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cupon_region->CurrentMode == "add" || $cupon_region->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cupon_region_grid->KeyCount ?>">
<?php echo $cupon_region_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cupon_region->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cupon_region_grid->KeyCount ?>">
<?php echo $cupon_region_grid->MultiSelectKey ?>
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="cupon_region_grid">
</div>
<?php

// Close recordset
if ($cupon_region_grid->Recordset)
	$cupon_region_grid->Recordset->Close();
?>
<?php if (($cupon_region->CurrentMode == "add" || $cupon_region->CurrentMode == "copy" || $cupon_region->CurrentMode == "edit") && $cupon_region->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridLowerPanel">
<?php if ($cupon_region->AllowAddDeleteRow) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><?php echo $Language->Phrase("AddBlankRow") ?></a>&nbsp;&nbsp;
</span>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($cupon_region->Export == "" && $cupon_region->CurrentAction == "") { ?>
<?php } ?>
<?php
$cupon_region_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$cupon_region_grid->Page_Terminate();
$Page =& $MasterPage;
?>
