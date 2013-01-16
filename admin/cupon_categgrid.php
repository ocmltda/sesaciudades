<?php

// Create page object
$cupon_categ_grid = new ccupon_categ_grid();
$MasterPage =& $Page;
$Page =& $cupon_categ_grid;

// Page init
$cupon_categ_grid->Page_Init();

// Page main
$cupon_categ_grid->Page_Main();
?>
<?php if ($cupon_categ->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cupon_categ_grid = new ew_Page("cupon_categ_grid");

// page properties
cupon_categ_grid.PageID = "grid"; // page ID
cupon_categ_grid.FormID = "fcupon_categgrid"; // form ID
var EW_PAGE_ID = cupon_categ_grid.PageID; // for backward compatibility

// extend page with ValidateForm function
cupon_categ_grid.ValidateForm = function(fobj) {
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
cupon_categ_grid.EmptyRow = function(fobj, infix) {
	if (ew_ValueChanged(fobj, infix, "cup_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cat_id", false)) return false;
	return true;
}

// extend page with Form_CustomValidate function
cupon_categ_grid.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cupon_categ_grid.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cupon_categ_grid.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cupon_categ_grid.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<?php } ?>
<?php $cupon_categ_grid->ShowPageHeader(); ?>
<?php
if ($cupon_categ->CurrentAction == "gridadd") {
	if ($cupon_categ->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$cupon_categ_grid->TotalRecs = $cupon_categ->SelectRecordCount();
			$cupon_categ_grid->Recordset = $cupon_categ_grid->LoadRecordset($cupon_categ_grid->StartRec-1, $cupon_categ_grid->DisplayRecs);
		} else {
			if ($cupon_categ_grid->Recordset = $cupon_categ_grid->LoadRecordset())
				$cupon_categ_grid->TotalRecs = $cupon_categ_grid->Recordset->RecordCount();
		}
		$cupon_categ_grid->StartRec = 1;
		$cupon_categ_grid->DisplayRecs = $cupon_categ_grid->TotalRecs;
	} else {
		$cupon_categ->CurrentFilter = "0=1";
		$cupon_categ_grid->StartRec = 1;
		$cupon_categ_grid->DisplayRecs = $cupon_categ->GridAddRowCount;
	}
	$cupon_categ_grid->TotalRecs = $cupon_categ_grid->DisplayRecs;
	$cupon_categ_grid->StopRec = $cupon_categ_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cupon_categ_grid->TotalRecs = $cupon_categ->SelectRecordCount();
	} else {
		if ($cupon_categ_grid->Recordset = $cupon_categ_grid->LoadRecordset())
			$cupon_categ_grid->TotalRecs = $cupon_categ_grid->Recordset->RecordCount();
	}
	$cupon_categ_grid->StartRec = 1;
	$cupon_categ_grid->DisplayRecs = $cupon_categ_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cupon_categ_grid->Recordset = $cupon_categ_grid->LoadRecordset($cupon_categ_grid->StartRec-1, $cupon_categ_grid->DisplayRecs);
}
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php if ($cupon_categ->CurrentMode == "add" || $cupon_categ->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($cupon_categ->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cupon_categ->TableCaption() ?></p>
</p>
<?php
$cupon_categ_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if (($cupon_categ->CurrentMode == "add" || $cupon_categ->CurrentMode == "copy" || $cupon_categ->CurrentMode == "edit") && $cupon_categ->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
<?php if ($cupon_categ->AllowAddDeleteRow) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><?php echo $Language->Phrase("AddBlankRow") ?></a>&nbsp;&nbsp;
</span>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
<div id="gmp_cupon_categ" class="ewGridMiddlePanel">
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $cupon_categ->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cupon_categ_grid->RenderListOptions();

// Render list options (header, left)
$cupon_categ_grid->ListOptions->Render("header", "left");
?>
<?php if ($cupon_categ->cct_id->Visible) { // cct_id ?>
	<?php if ($cupon_categ->SortUrl($cupon_categ->cct_id) == "") { ?>
		<td><?php echo $cupon_categ->cct_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon_categ->cct_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon_categ->cct_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon_categ->cct_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cupon_categ->cup_id->Visible) { // cup_id ?>
	<?php if ($cupon_categ->SortUrl($cupon_categ->cup_id) == "") { ?>
		<td><?php echo $cupon_categ->cup_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon_categ->cup_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon_categ->cup_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon_categ->cup_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cupon_categ->cat_id->Visible) { // cat_id ?>
	<?php if ($cupon_categ->SortUrl($cupon_categ->cat_id) == "") { ?>
		<td><?php echo $cupon_categ->cat_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div>
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon_categ->cat_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon_categ->cat_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon_categ->cat_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cupon_categ_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
$cupon_categ_grid->StartRec = 1;
$cupon_categ_grid->StopRec = $cupon_categ_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = 0;
	if ($objForm->HasValue("key_count") && ($cupon_categ->CurrentAction == "gridadd" || $cupon_categ->CurrentAction == "gridedit" || $cupon_categ->CurrentAction == "F")) {
		$cupon_categ_grid->KeyCount = $objForm->GetValue("key_count");
		$cupon_categ_grid->StopRec = $cupon_categ_grid->KeyCount;
	}
}
$cupon_categ_grid->RecCnt = $cupon_categ_grid->StartRec - 1;
if ($cupon_categ_grid->Recordset && !$cupon_categ_grid->Recordset->EOF) {
	$cupon_categ_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $cupon_categ_grid->StartRec > 1)
		$cupon_categ_grid->Recordset->Move($cupon_categ_grid->StartRec - 1);
} elseif (!$cupon_categ->AllowAddDeleteRow && $cupon_categ_grid->StopRec == 0) {
	$cupon_categ_grid->StopRec = $cupon_categ->GridAddRowCount;
}

// Initialize aggregate
$cupon_categ->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cupon_categ->ResetAttrs();
$cupon_categ_grid->RenderRow();
$cupon_categ_grid->RowCnt = 0;
if ($cupon_categ->CurrentAction == "gridadd")
	$cupon_categ_grid->RowIndex = 0;
if ($cupon_categ->CurrentAction == "gridedit")
	$cupon_categ_grid->RowIndex = 0;
while ($cupon_categ_grid->RecCnt < $cupon_categ_grid->StopRec) {
	$cupon_categ_grid->RecCnt++;
	if (intval($cupon_categ_grid->RecCnt) >= intval($cupon_categ_grid->StartRec)) {
		$cupon_categ_grid->RowCnt++;
		if ($cupon_categ->CurrentAction == "gridadd" || $cupon_categ->CurrentAction == "gridedit" || $cupon_categ->CurrentAction == "F")
			$cupon_categ_grid->RowIndex++;

		// Set up key count
		$cupon_categ_grid->KeyCount = $cupon_categ_grid->RowIndex;

		// Init row class and style
		$cupon_categ->ResetAttrs();
		$cupon_categ->CssClass = "";
		if ($cupon_categ->CurrentAction == "gridadd") {
			if ($cupon_categ->CurrentMode == "copy")
				$cupon_categ_grid->LoadRowValues($cupon_categ_grid->Recordset); // Load row values
			else
				$cupon_categ_grid->LoadDefaultValues(); // Load default values
		} else {
			$cupon_categ_grid->LoadRowValues($cupon_categ_grid->Recordset); // Load row values
		}
		$cupon_categ->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cupon_categ->CurrentAction == "gridadd") // Grid add
			$cupon_categ->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cupon_categ->CurrentAction == "gridadd" && $cupon_categ->EventCancelled) // Insert failed
			$cupon_categ_grid->RestoreCurrentRowFormValues($cupon_categ_grid->RowIndex); // Restore form values
		if ($cupon_categ->CurrentAction == "gridedit") { // Grid edit
			if ($cupon_categ->EventCancelled) {
				$cupon_categ_grid->RestoreCurrentRowFormValues($cupon_categ_grid->RowIndex); // Restore form values
			}
			if ($cupon_categ_grid->RowAction == "insert")
				$cupon_categ->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cupon_categ->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cupon_categ->CurrentAction == "gridedit" && ($cupon_categ->RowType == EW_ROWTYPE_EDIT || $cupon_categ->RowType == EW_ROWTYPE_ADD) && $cupon_categ->EventCancelled) // Update failed
			$cupon_categ_grid->RestoreCurrentRowFormValues($cupon_categ_grid->RowIndex); // Restore form values
		if ($cupon_categ->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cupon_categ_grid->EditRowCnt++;
		if ($cupon_categ->CurrentAction == "F") // Confirm row
			$cupon_categ_grid->RestoreCurrentRowFormValues($cupon_categ_grid->RowIndex); // Restore form values
		if ($cupon_categ->RowType == EW_ROWTYPE_ADD || $cupon_categ->RowType == EW_ROWTYPE_EDIT) { // Add / Edit row
			if ($cupon_categ->CurrentAction == "edit") {
				$cupon_categ->RowAttrs = array();
				$cupon_categ->CssClass = "ewTableEditRow";
			} else {
				$cupon_categ->RowAttrs = array();
			}
			if (!empty($cupon_categ_grid->RowIndex))
				$cupon_categ->RowAttrs = array_merge($cupon_categ->RowAttrs, array('data-rowindex'=>$cupon_categ_grid->RowIndex, 'id'=>'r' . $cupon_categ_grid->RowIndex . '_cupon_categ'));
		} else {
			$cupon_categ->RowAttrs = array();
		}

		// Render row
		$cupon_categ_grid->RenderRow();

		// Render list options
		$cupon_categ_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cupon_categ_grid->RowAction <> "delete" && $cupon_categ_grid->RowAction <> "insertdelete" && !($cupon_categ_grid->RowAction == "insert" && $cupon_categ->CurrentAction == "F" && $cupon_categ_grid->EmptyRow())) {
?>
	<tr<?php echo $cupon_categ->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cupon_categ_grid->ListOptions->Render("body", "left");
?>
	<?php if ($cupon_categ->cct_id->Visible) { // cct_id ?>
		<td<?php echo $cupon_categ->cct_id->CellAttributes() ?>>
<?php if ($cupon_categ->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $cupon_categ_grid->RowIndex ?>_cct_id" id="o<?php echo $cupon_categ_grid->RowIndex ?>_cct_id" value="<?php echo ew_HtmlEncode($cupon_categ->cct_id->OldValue) ?>">
<?php } ?>
<?php if ($cupon_categ->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div<?php echo $cupon_categ->cct_id->ViewAttributes() ?>><?php echo $cupon_categ->cct_id->EditValue ?></div>
<input type="hidden" name="x<?php echo $cupon_categ_grid->RowIndex ?>_cct_id" id="x<?php echo $cupon_categ_grid->RowIndex ?>_cct_id" value="<?php echo ew_HtmlEncode($cupon_categ->cct_id->CurrentValue) ?>">
<?php } ?>
<?php if ($cupon_categ->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cupon_categ->cct_id->ViewAttributes() ?>><?php echo $cupon_categ->cct_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $cupon_categ_grid->RowIndex ?>_cct_id" id="x<?php echo $cupon_categ_grid->RowIndex ?>_cct_id" value="<?php echo ew_HtmlEncode($cupon_categ->cct_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cupon_categ_grid->RowIndex ?>_cct_id" id="o<?php echo $cupon_categ_grid->RowIndex ?>_cct_id" value="<?php echo ew_HtmlEncode($cupon_categ->cct_id->OldValue) ?>">
<?php } ?>
<a name="<?php echo $cupon_categ_grid->PageObjName . "_row_" . $cupon_categ_grid->RowCnt ?>" id="<?php echo $cupon_categ_grid->PageObjName . "_row_" . $cupon_categ_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cupon_categ->cup_id->Visible) { // cup_id ?>
		<td<?php echo $cupon_categ->cup_id->CellAttributes() ?>>
<?php if ($cupon_categ->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cupon_categ->cup_id->getSessionValue() <> "") { ?>
<div<?php echo $cupon_categ->cup_id->ViewAttributes() ?>><?php echo $cupon_categ->cup_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" name="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_categ->cup_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" name="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id"<?php echo $cupon_categ->cup_id->EditAttributes() ?>>
<?php
if (is_array($cupon_categ->cup_id->EditValue)) {
	$arwrk = $cupon_categ->cup_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_categ->cup_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cupon_categ->cup_id->OldValue = "";
?>
</select>
<?php } ?>
<input type="hidden" name="o<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" id="o<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_categ->cup_id->OldValue) ?>">
<?php } ?>
<?php if ($cupon_categ->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cupon_categ->cup_id->getSessionValue() <> "") { ?>
<div<?php echo $cupon_categ->cup_id->ViewAttributes() ?>><?php echo $cupon_categ->cup_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" name="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_categ->cup_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" name="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id"<?php echo $cupon_categ->cup_id->EditAttributes() ?>>
<?php
if (is_array($cupon_categ->cup_id->EditValue)) {
	$arwrk = $cupon_categ->cup_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_categ->cup_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cupon_categ->cup_id->OldValue = "";
?>
</select>
<?php } ?>
<?php } ?>
<?php if ($cupon_categ->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cupon_categ->cup_id->ViewAttributes() ?>><?php echo $cupon_categ->cup_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" id="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_categ->cup_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" id="o<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_categ->cup_id->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cupon_categ->cat_id->Visible) { // cat_id ?>
		<td<?php echo $cupon_categ->cat_id->CellAttributes() ?>>
<?php if ($cupon_categ->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $cupon_categ_grid->RowIndex ?>_cat_id" name="x<?php echo $cupon_categ_grid->RowIndex ?>_cat_id"<?php echo $cupon_categ->cat_id->EditAttributes() ?>>
<?php
if (is_array($cupon_categ->cat_id->EditValue)) {
	$arwrk = $cupon_categ->cat_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_categ->cat_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cupon_categ->cat_id->OldValue = "";
?>
</select>
<input type="hidden" name="o<?php echo $cupon_categ_grid->RowIndex ?>_cat_id" id="o<?php echo $cupon_categ_grid->RowIndex ?>_cat_id" value="<?php echo ew_HtmlEncode($cupon_categ->cat_id->OldValue) ?>">
<?php } ?>
<?php if ($cupon_categ->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cupon_categ_grid->RowIndex ?>_cat_id" name="x<?php echo $cupon_categ_grid->RowIndex ?>_cat_id"<?php echo $cupon_categ->cat_id->EditAttributes() ?>>
<?php
if (is_array($cupon_categ->cat_id->EditValue)) {
	$arwrk = $cupon_categ->cat_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_categ->cat_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cupon_categ->cat_id->OldValue = "";
?>
</select>
<?php } ?>
<?php if ($cupon_categ->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cupon_categ->cat_id->ViewAttributes() ?>><?php echo $cupon_categ->cat_id->ListViewValue() ?></div>
<input type="hidden" name="x<?php echo $cupon_categ_grid->RowIndex ?>_cat_id" id="x<?php echo $cupon_categ_grid->RowIndex ?>_cat_id" value="<?php echo ew_HtmlEncode($cupon_categ->cat_id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cupon_categ_grid->RowIndex ?>_cat_id" id="o<?php echo $cupon_categ_grid->RowIndex ?>_cat_id" value="<?php echo ew_HtmlEncode($cupon_categ->cat_id->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cupon_categ_grid->ListOptions->Render("body", "right");
?>
	</tr>
<?php if ($cupon_categ->RowType == EW_ROWTYPE_ADD) { ?>
<?php } ?>
<?php if ($cupon_categ->RowType == EW_ROWTYPE_EDIT) { ?>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cupon_categ->CurrentAction <> "gridadd" || $cupon_categ->CurrentMode == "copy")
		if (!$cupon_categ_grid->Recordset->EOF) $cupon_categ_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cupon_categ->CurrentMode == "add" || $cupon_categ->CurrentMode == "copy" || $cupon_categ->CurrentMode == "edit") {
		$cupon_categ_grid->RowIndex = '$rowindex$';
		$cupon_categ_grid->LoadDefaultValues();

		// Set row properties
		$cupon_categ->ResetAttrs();
		$cupon_categ->RowAttrs = array();
		if (!empty($cupon_categ_grid->RowIndex))
			$cupon_categ->RowAttrs = array_merge($cupon_categ->RowAttrs, array('data-rowindex'=>$cupon_categ_grid->RowIndex, 'id'=>'r' . $cupon_categ_grid->RowIndex . '_cupon_categ'));
		$cupon_categ->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cupon_categ_grid->RenderRow();

		// Render list options
		$cupon_categ_grid->RenderListOptions();

		// Add id and class to the template row
		$cupon_categ->RowAttrs["id"] = "r0_cupon_categ";
		ew_AppendClass($cupon_categ->RowAttrs["class"], "ewTemplate");
?>
	<tr<?php echo $cupon_categ->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cupon_categ_grid->ListOptions->Render("body", "left");
?>
	<?php if ($cupon_categ->cct_id->Visible) { // cct_id ?>
		<td>&nbsp;</td>
	<?php } ?>
	<?php if ($cupon_categ->cup_id->Visible) { // cup_id ?>
		<td>
<?php if ($cupon_categ->cup_id->getSessionValue() <> "") { ?>
<div<?php echo $cupon_categ->cup_id->ViewAttributes() ?>><?php echo $cupon_categ->cup_id->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" name="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_categ->cup_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" name="x<?php echo $cupon_categ_grid->RowIndex ?>_cup_id"<?php echo $cupon_categ->cup_id->EditAttributes() ?>>
<?php
if (is_array($cupon_categ->cup_id->EditValue)) {
	$arwrk = $cupon_categ->cup_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_categ->cup_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cupon_categ->cup_id->OldValue = "";
?>
</select>
<?php } ?>
<input type="hidden" name="o<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" id="o<?php echo $cupon_categ_grid->RowIndex ?>_cup_id" value="<?php echo ew_HtmlEncode($cupon_categ->cup_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cupon_categ->cat_id->Visible) { // cat_id ?>
		<td>
<select id="x<?php echo $cupon_categ_grid->RowIndex ?>_cat_id" name="x<?php echo $cupon_categ_grid->RowIndex ?>_cat_id"<?php echo $cupon_categ->cat_id->EditAttributes() ?>>
<?php
if (is_array($cupon_categ->cat_id->EditValue)) {
	$arwrk = $cupon_categ->cat_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_categ->cat_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cupon_categ->cat_id->OldValue = "";
?>
</select>
<input type="hidden" name="o<?php echo $cupon_categ_grid->RowIndex ?>_cat_id" id="o<?php echo $cupon_categ_grid->RowIndex ?>_cat_id" value="<?php echo ew_HtmlEncode($cupon_categ->cat_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cupon_categ_grid->ListOptions->Render("body", "right");
?>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cupon_categ->CurrentMode == "add" || $cupon_categ->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cupon_categ_grid->KeyCount ?>">
<?php echo $cupon_categ_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cupon_categ->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cupon_categ_grid->KeyCount ?>">
<?php echo $cupon_categ_grid->MultiSelectKey ?>
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="cupon_categ_grid">
</div>
<?php

// Close recordset
if ($cupon_categ_grid->Recordset)
	$cupon_categ_grid->Recordset->Close();
?>
<?php if (($cupon_categ->CurrentMode == "add" || $cupon_categ->CurrentMode == "copy" || $cupon_categ->CurrentMode == "edit") && $cupon_categ->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridLowerPanel">
<?php if ($cupon_categ->AllowAddDeleteRow) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><?php echo $Language->Phrase("AddBlankRow") ?></a>&nbsp;&nbsp;
</span>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($cupon_categ->Export == "" && $cupon_categ->CurrentAction == "") { ?>
<?php } ?>
<?php
$cupon_categ_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$cupon_categ_grid->Page_Terminate();
$Page =& $MasterPage;
?>
