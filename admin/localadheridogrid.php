<?php

// Create page object
$localadherido_grid = new clocaladherido_grid();
$MasterPage =& $Page;
$Page =& $localadherido_grid;

// Page init
$localadherido_grid->Page_Init();

// Page main
$localadherido_grid->Page_Main();
?>
<?php if ($localadherido->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var localadherido_grid = new ew_Page("localadherido_grid");

// page properties
localadherido_grid.PageID = "grid"; // page ID
localadherido_grid.FormID = "flocaladheridogrid"; // form ID
var EW_PAGE_ID = localadherido_grid.PageID; // for backward compatibility

// extend page with ValidateForm function
localadherido_grid.ValidateForm = function(fobj) {
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
localadherido_grid.EmptyRow = function(fobj, infix) {
	if (ew_ValueChanged(fobj, infix, "cup_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "emp_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "loc_id", false)) return false;
	return true;
}

// extend page with Form_CustomValidate function
localadherido_grid.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
localadherido_grid.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
localadherido_grid.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
localadherido_grid.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<?php } ?>
<?php $localadherido_grid->ShowPageHeader(); ?>
<?php
if ($localadherido->CurrentAction == "gridadd") {
	if ($localadherido->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$localadherido_grid->TotalRecs = $localadherido->SelectRecordCount();
			$localadherido_grid->Recordset = $localadherido_grid->LoadRecordset($localadherido_grid->StartRec-1, $localadherido_grid->DisplayRecs);
		} else {
			if ($localadherido_grid->Recordset = $localadherido_grid->LoadRecordset())
				$localadherido_grid->TotalRecs = $localadherido_grid->Recordset->RecordCount();
		}
		$localadherido_grid->StartRec = 1;
		$localadherido_grid->DisplayRecs = $localadherido_grid->TotalRecs;
	} else {
		$localadherido->CurrentFilter = "0=1";
		$localadherido_grid->StartRec = 1;
		$localadherido_grid->DisplayRecs = $localadherido->GridAddRowCount;
	}
	$localadherido_grid->TotalRecs = $localadherido_grid->DisplayRecs;
	$localadherido_grid->StopRec = $localadherido_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$localadherido_grid->TotalRecs = $localadherido->SelectRecordCount();
	} else {
		if ($localadherido_grid->Recordset = $localadherido_grid->LoadRecordset())
			$localadherido_grid->TotalRecs = $localadherido_grid->Recordset->RecordCount();
	}
	$localadherido_grid->StartRec = 1;
	$localadherido_grid->DisplayRecs = $localadherido_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$localadherido_grid->Recordset = $localadherido_grid->LoadRecordset($localadherido_grid->StartRec-1, $localadherido_grid->DisplayRecs);
}
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php if ($localadherido->CurrentMode == "add" || $localadherido->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($localadherido->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $localadherido->TableCaption() ?></p>
</p>
<?php
$localadherido_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if (($localadherido->CurrentMode == "add" || $localadherido->CurrentMode == "copy" || $localadherido->CurrentMode == "edit") && $localadherido->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
<?php if ($localadherido->AllowAddDeleteRow) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><?php echo $Language->Phrase("AddBlankRow") ?></a>&nbsp;&nbsp;
</span>
<?php } ?>
</div>
<?php } ?>
<div id="gmp_localadherido" class="ewGridMiddlePanel">
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $localadherido->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$localadherido_grid->RenderListOptions();

// Render list options (header, left)
$localadherido_grid->ListOptions->Render("header", "left");
?>
<?php if ($localadherido->lad_id->Visible) { // lad_id ?>
	<?php if ($localadherido->SortUrl($localadherido->lad_id) == "") { ?>
		<td><?php echo $localadherido->lad_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $localadherido->lad_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($localadherido->lad_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($localadherido->lad_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($localadherido->cup_id->Visible) { // cup_id ?>
	<?php if ($localadherido->SortUrl($localadherido->cup_id) == "") { ?>
		<td><?php echo $localadherido->cup_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $localadherido->cup_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($localadherido->cup_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($localadherido->cup_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($localadherido->emp_id->Visible) { // emp_id ?>
	<?php if ($localadherido->SortUrl($localadherido->emp_id) == "") { ?>
		<td><?php echo $localadherido->emp_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $localadherido->emp_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($localadherido->emp_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($localadherido->emp_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($localadherido->loc_id->Visible) { // loc_id ?>
	<?php if ($localadherido->SortUrl($localadherido->loc_id) == "") { ?>
		<td><?php echo $localadherido->loc_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $localadherido->loc_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($localadherido->loc_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($localadherido->loc_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$localadherido_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
$localadherido_grid->StartRec = 1;
$localadherido_grid->StopRec = $localadherido_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = 0;
	if ($objForm->HasValue("key_count") && ($localadherido->CurrentAction == "gridadd" || $localadherido->CurrentAction == "gridedit" || $localadherido->CurrentAction == "F")) {
		$localadherido_grid->KeyCount = $objForm->GetValue("key_count");
		$localadherido_grid->StopRec = $localadherido_grid->KeyCount;
	}
}
$localadherido_grid->RecCnt = $localadherido_grid->StartRec - 1;
if ($localadherido_grid->Recordset && !$localadherido_grid->Recordset->EOF) {
	$localadherido_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $localadherido_grid->StartRec > 1)
		$localadherido_grid->Recordset->Move($localadherido_grid->StartRec - 1);
} elseif (!$localadherido->AllowAddDeleteRow && $localadherido_grid->StopRec == 0) {
	$localadherido_grid->StopRec = $localadherido->GridAddRowCount;
}

// Initialize aggregate
$localadherido->RowType = EW_ROWTYPE_AGGREGATEINIT;
$localadherido->ResetAttrs();
$localadherido_grid->RenderRow();
$localadherido_grid->RowCnt = 0;
if ($localadherido->CurrentAction == "gridadd")
	$localadherido_grid->RowIndex = 0;
if ($localadherido->CurrentAction == "gridedit")
	$localadherido_grid->RowIndex = 0;
while ($localadherido_grid->RecCnt < $localadherido_grid->StopRec) {
	$localadherido_grid->RecCnt++;
	if (intval($localadherido_grid->RecCnt) >= intval($localadherido_grid->StartRec)) {
		$localadherido_grid->RowCnt++;
		if ($localadherido->CurrentAction == "gridadd" || $localadherido->CurrentAction == "gridedit" || $localadherido->CurrentAction == "F")
			$localadherido_grid->RowIndex++;

		// Set up key count
		$localadherido_grid->KeyCount = $localadherido_grid->RowIndex;

		// Init row class and style
		$localadherido->ResetAttrs();
		$localadherido->CssClass = "";
		if ($localadherido->CurrentAction == "gridadd") {
			if ($localadherido->CurrentMode == "copy")
				$localadherido_grid->LoadRowValues($localadherido_grid->Recordset); // Load row values
			else
				$localadherido_grid->LoadDefaultValues(); // Load default values
		} else {
			$localadherido_grid->LoadRowValues($localadherido_grid->Recordset); // Load row values
		}
		$localadherido->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($localadherido->CurrentAction == "gridadd") // Grid add
			$localadherido->RowType = EW_ROWTYPE_ADD; // Render add
		if ($localadherido->CurrentAction == "gridadd" && $localadherido->EventCancelled) // Insert failed
			$localadherido_grid->RestoreCurrentRowFormValues($localadherido_grid->RowIndex); // Restore form values
		if ($localadherido->CurrentAction == "gridedit") { // Grid edit
			if ($localadherido->EventCancelled) {
				$localadherido_grid->RestoreCurrentRowFormValues($localadherido_grid->RowIndex); // Restore form values
			}
			if ($localadherido_grid->RowAction == "insert")
				$localadherido->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$localadherido->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($localadherido->CurrentAction == "gridedit" && ($localadherido->RowType == EW_ROWTYPE_EDIT || $localadherido->RowType == EW_ROWTYPE_ADD) && $localadherido->EventCancelled) // Update failed
			$localadherido_grid->RestoreCurrentRowFormValues($localadherido_grid->RowIndex); // Restore form values
		if ($localadherido->RowType == EW_ROWTYPE_EDIT) // Edit row
			$localadherido_grid->EditRowCnt++;
		if ($localadherido->CurrentAction == "F") // Confirm row
			$localadherido_grid->RestoreCurrentRowFormValues($localadherido_grid->RowIndex); // Restore form values
		if ($localadherido->RowType == EW_ROWTYPE_ADD || $localadherido->RowType == EW_ROWTYPE_EDIT) { // Add / Edit row
			if ($localadherido->CurrentAction == "edit") {
				$localadherido->RowAttrs = array();
				$localadherido->CssClass = "ewTableEditRow";
			} else {
				$localadherido->RowAttrs = array();
			}
			if (!empty($localadherido_grid->RowIndex))
				$localadherido->RowAttrs = array_merge($localadherido->RowAttrs, array('data-rowindex'=>$localadherido_grid->RowIndex, 'id'=>'r' . $localadherido_grid->RowIndex . '_localadherido'));
		} else {
			$localadherido->RowAttrs = array();
		}

		// Render row
		$localadherido_grid->RenderRow();

		// Render list options
		$localadherido_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($localadherido_grid->RowAction <> "delete" && $localadherido_grid->RowAction <> "insertdelete" && !($localadherido_grid->RowAction == "insert" && $localadherido->CurrentAction == "F" && $localadherido_grid->EmptyRow())) {
?>
	<tr<?php echo $localadherido->RowAttributes() ?>>
<?php

// Render list options (body, left)
$localadherido_grid->ListOptions->Render("body", "left");
?>
	<?php if ($localadherido->lad_id->Visible) { // lad_id ?>
		<td<?php echo $localadherido->lad_id->CellAttributes() ?>>
<?php if ($localadherido->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $localadherido_grid->RowIndex ?>_lad_id" id="o<?php echo $localadherido_grid->RowIndex ?>_lad_id" value="<?php echo ew_HtmlEncode($localadherido->lad_id->OldValue) ?>">
<?php } ?>
<?php if ($localadherido->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div<?php echo $localadherido->lad_id->ViewAttributes() ?>><?php echo $localadherido->lad_id->EditValue ?></div>
<input type="hidden" name="x<?php echo $localadherido_grid->RowIndex ?>_lad_id" id="x<?php echo $localadherido_grid->RowIndex ?>_lad_id" value="<?php echo ew_HtmlEncode($localadherido->lad_id->CurrentValue) ?>">
<?php } ?>
<?php if ($localadherido->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $localadherido->lad_id->ViewAttributes() ?>><?php echo $localadherido->lad_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $localadherido_grid->RowIndex ?>_lad_id" id="x<?php echo $localadherido_grid->RowIndex ?>_lad_id" value="<?php echo ew_HtmlEncode($localadherido->lad_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $localadherido_grid->RowIndex ?>_lad_id" id="o<?php echo $localadherido_grid->RowIndex ?>_lad_id" value="<?php echo ew_HtmlEncode($localadherido->lad_id->OldValue) ?>">
<?php } ?>
<a name="<?php echo $localadherido_grid->PageObjName . "_row_" . $localadherido_grid->RowCnt ?>" id="<?php echo $localadherido_grid->PageObjName . "_row_" . $localadherido_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($localadherido->cup_id->Visible) { // cup_id ?>
		<td<?php echo $localadherido->cup_id->CellAttributes() ?>>
<?php if ($localadherido->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($localadherido->cup_id->getSessionValue() <> "") { ?>
<div<?php echo $localadherido->cup_id->ViewAttributes() ?>><?php echo $localadherido->cup_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $localadherido_grid->RowIndex ?>_cup_id" name="x<?php echo $localadherido_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($localadherido->cup_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $localadherido_grid->RowIndex ?>_cup_id" name="x<?php echo $localadherido_grid->RowIndex ?>_cup_id"<?php echo $localadherido->cup_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->cup_id->EditValue)) {
	$arwrk = $localadherido->cup_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->cup_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $localadherido->cup_id->OldValue = "";
?>
</select>
<?php } ?>
<input type="hidden" name="o<?php echo $localadherido_grid->RowIndex ?>_cup_id" id="o<?php echo $localadherido_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($localadherido->cup_id->OldValue) ?>">
<?php } ?>
<?php if ($localadherido->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($localadherido->cup_id->getSessionValue() <> "") { ?>
<div<?php echo $localadherido->cup_id->ViewAttributes() ?>><?php echo $localadherido->cup_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $localadherido_grid->RowIndex ?>_cup_id" name="x<?php echo $localadherido_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($localadherido->cup_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $localadherido_grid->RowIndex ?>_cup_id" name="x<?php echo $localadherido_grid->RowIndex ?>_cup_id"<?php echo $localadherido->cup_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->cup_id->EditValue)) {
	$arwrk = $localadherido->cup_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->cup_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $localadherido->cup_id->OldValue = "";
?>
</select>
<?php } ?>
<?php } ?>
<?php if ($localadherido->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $localadherido->cup_id->ViewAttributes() ?>><?php echo $localadherido->cup_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $localadherido_grid->RowIndex ?>_cup_id" id="x<?php echo $localadherido_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($localadherido->cup_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $localadherido_grid->RowIndex ?>_cup_id" id="o<?php echo $localadherido_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($localadherido->cup_id->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($localadherido->emp_id->Visible) { // emp_id ?>
		<td<?php echo $localadherido->emp_id->CellAttributes() ?>>
<?php if ($localadherido->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $localadherido_grid->RowIndex ?>_emp_id" name="x<?php echo $localadherido_grid->RowIndex ?>_emp_id"<?php echo $localadherido->emp_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->emp_id->EditValue)) {
	$arwrk = $localadherido->emp_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->emp_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $localadherido->emp_id->OldValue = "";
?>
</select>
<input type="hidden" name="o<?php echo $localadherido_grid->RowIndex ?>_emp_id" id="o<?php echo $localadherido_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($localadherido->emp_id->OldValue) ?>">
<?php } ?>
<?php if ($localadherido->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $localadherido_grid->RowIndex ?>_emp_id" name="x<?php echo $localadherido_grid->RowIndex ?>_emp_id"<?php echo $localadherido->emp_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->emp_id->EditValue)) {
	$arwrk = $localadherido->emp_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->emp_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $localadherido->emp_id->OldValue = "";
?>
</select>
<?php } ?>
<?php if ($localadherido->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $localadherido->emp_id->ViewAttributes() ?>><?php echo $localadherido->emp_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $localadherido_grid->RowIndex ?>_emp_id" id="x<?php echo $localadherido_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($localadherido->emp_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $localadherido_grid->RowIndex ?>_emp_id" id="o<?php echo $localadherido_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($localadherido->emp_id->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($localadherido->loc_id->Visible) { // loc_id ?>
		<td<?php echo $localadherido->loc_id->CellAttributes() ?>>
<?php if ($localadherido->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $localadherido_grid->RowIndex ?>_loc_id" name="x<?php echo $localadherido_grid->RowIndex ?>_loc_id"<?php echo $localadherido->loc_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->loc_id->EditValue)) {
	$arwrk = $localadherido->loc_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->loc_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $localadherido->loc_id->OldValue = "";
?>
</select>
<input type="hidden" name="o<?php echo $localadherido_grid->RowIndex ?>_loc_id" id="o<?php echo $localadherido_grid->RowIndex ?>_loc_id" value="<?php echo ew_HtmlEncode($localadherido->loc_id->OldValue) ?>">
<?php } ?>
<?php if ($localadherido->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $localadherido_grid->RowIndex ?>_loc_id" name="x<?php echo $localadherido_grid->RowIndex ?>_loc_id"<?php echo $localadherido->loc_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->loc_id->EditValue)) {
	$arwrk = $localadherido->loc_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->loc_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $localadherido->loc_id->OldValue = "";
?>
</select>
<?php } ?>
<?php if ($localadherido->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $localadherido->loc_id->ViewAttributes() ?>><?php echo $localadherido->loc_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $localadherido_grid->RowIndex ?>_loc_id" id="x<?php echo $localadherido_grid->RowIndex ?>_loc_id" value="<?php echo ew_HtmlEncode($localadherido->loc_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $localadherido_grid->RowIndex ?>_loc_id" id="o<?php echo $localadherido_grid->RowIndex ?>_loc_id" value="<?php echo ew_HtmlEncode($localadherido->loc_id->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$localadherido_grid->ListOptions->Render("body", "right");
?>
	</tr>
<?php if ($localadherido->RowType == EW_ROWTYPE_ADD) { ?>
<?php } ?>
<?php if ($localadherido->RowType == EW_ROWTYPE_EDIT) { ?>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($localadherido->CurrentAction <> "gridadd" || $localadherido->CurrentMode == "copy")
		if (!$localadherido_grid->Recordset->EOF) $localadherido_grid->Recordset->MoveNext();
}
?>
<?php
	if ($localadherido->CurrentMode == "add" || $localadherido->CurrentMode == "copy" || $localadherido->CurrentMode == "edit") {
		$localadherido_grid->RowIndex = '$rowindex$';
		$localadherido_grid->LoadDefaultValues();

		// Set row properties
		$localadherido->ResetAttrs();
		$localadherido->RowAttrs = array();
		if (!empty($localadherido_grid->RowIndex))
			$localadherido->RowAttrs = array_merge($localadherido->RowAttrs, array('data-rowindex'=>$localadherido_grid->RowIndex, 'id'=>'r' . $localadherido_grid->RowIndex . '_localadherido'));
		$localadherido->RowType = EW_ROWTYPE_ADD;

		// Render row
		$localadherido_grid->RenderRow();

		// Render list options
		$localadherido_grid->RenderListOptions();

		// Add id and class to the template row
		$localadherido->RowAttrs["id"] = "r0_localadherido";
		ew_AppendClass($localadherido->RowAttrs["class"], "ewTemplate");
?>
	<tr<?php echo $localadherido->RowAttributes() ?>>
<?php

// Render list options (body, left)
$localadherido_grid->ListOptions->Render("body", "left");
?>
	<?php if ($localadherido->lad_id->Visible) { // lad_id ?>
		<td>&nbsp;</td>
	<?php } ?>
	<?php if ($localadherido->cup_id->Visible) { // cup_id ?>
		<td>
<?php if ($localadherido->cup_id->getSessionValue() <> "") { ?>
<div<?php echo $localadherido->cup_id->ViewAttributes() ?>><?php echo $localadherido->cup_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $localadherido_grid->RowIndex ?>_cup_id" name="x<?php echo $localadherido_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($localadherido->cup_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $localadherido_grid->RowIndex ?>_cup_id" name="x<?php echo $localadherido_grid->RowIndex ?>_cup_id"<?php echo $localadherido->cup_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->cup_id->EditValue)) {
	$arwrk = $localadherido->cup_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->cup_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $localadherido->cup_id->OldValue = "";
?>
</select>
<?php } ?>
<input type="hidden" name="o<?php echo $localadherido_grid->RowIndex ?>_cup_id" id="o<?php echo $localadherido_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($localadherido->cup_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($localadherido->emp_id->Visible) { // emp_id ?>
		<td>
<select id="x<?php echo $localadherido_grid->RowIndex ?>_emp_id" name="x<?php echo $localadherido_grid->RowIndex ?>_emp_id"<?php echo $localadherido->emp_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->emp_id->EditValue)) {
	$arwrk = $localadherido->emp_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->emp_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $localadherido->emp_id->OldValue = "";
?>
</select>
<input type="hidden" name="o<?php echo $localadherido_grid->RowIndex ?>_emp_id" id="o<?php echo $localadherido_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($localadherido->emp_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($localadherido->loc_id->Visible) { // loc_id ?>
		<td>
<select id="x<?php echo $localadherido_grid->RowIndex ?>_loc_id" name="x<?php echo $localadherido_grid->RowIndex ?>_loc_id"<?php echo $localadherido->loc_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->loc_id->EditValue)) {
	$arwrk = $localadherido->loc_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->loc_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $localadherido->loc_id->OldValue = "";
?>
</select>
<input type="hidden" name="o<?php echo $localadherido_grid->RowIndex ?>_loc_id" id="o<?php echo $localadherido_grid->RowIndex ?>_loc_id" value="<?php echo ew_HtmlEncode($localadherido->loc_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$localadherido_grid->ListOptions->Render("body", "right");
?>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($localadherido->CurrentMode == "add" || $localadherido->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $localadherido_grid->KeyCount ?>">
<?php echo $localadherido_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($localadherido->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $localadherido_grid->KeyCount ?>">
<?php echo $localadherido_grid->MultiSelectKey ?>
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="localadherido_grid">
</div>
<?php

// Close recordset
if ($localadherido_grid->Recordset)
	$localadherido_grid->Recordset->Close();
?>
<?php if (($localadherido->CurrentMode == "add" || $localadherido->CurrentMode == "copy" || $localadherido->CurrentMode == "edit") && $localadherido->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridLowerPanel">
<?php if ($localadherido->AllowAddDeleteRow) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><?php echo $Language->Phrase("AddBlankRow") ?></a>&nbsp;&nbsp;
</span>
<?php } ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($localadherido->Export == "" && $localadherido->CurrentAction == "") { ?>
<?php } ?>
<?php
$localadherido_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$localadherido_grid->Page_Terminate();
$Page =& $MasterPage;
?>
