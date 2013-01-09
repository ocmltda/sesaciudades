<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "cuponinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$cupon_list = new ccupon_list();
$Page =& $cupon_list;

// Page init
$cupon_list->Page_Init();

// Page main
$cupon_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cupon->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cupon_list = new ew_Page("cupon_list");

// page properties
cupon_list.PageID = "list"; // page ID
cupon_list.FormID = "fcuponlist"; // form ID
var EW_PAGE_ID = cupon_list.PageID; // for backward compatibility

// extend page with validate function for search
cupon_list.ValidateSearch = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (this.ValidateRequired) {
		var infix = "";

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	for (var i=0; i<fobj.elements.length; i++) {
		var elem = fobj.elements[i];
		if (elem.name.substring(0,2) == "s_" || elem.name.substring(0,3) == "sv_")
			elem.value = "";
	}
	return true;
}

// extend page with Form_CustomValidate function
cupon_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cupon_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cupon_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cupon_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($cupon->Export == "") || (EW_EXPORT_MASTER_RECORD && $cupon->Export == "print")) { ?>
<?php } ?>
<?php $cupon_list->ShowPageHeader(); ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cupon_list->TotalRecs = $cupon->SelectRecordCount();
	} else {
		if ($cupon_list->Recordset = $cupon_list->LoadRecordset())
			$cupon_list->TotalRecs = $cupon_list->Recordset->RecordCount();
	}
	$cupon_list->StartRec = 1;
	if ($cupon_list->DisplayRecs <= 0 || ($cupon->Export <> "" && $cupon->ExportAll)) // Display all records
		$cupon_list->DisplayRecs = $cupon_list->TotalRecs;
	if (!($cupon->Export <> "" && $cupon->ExportAll))
		$cupon_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cupon_list->Recordset = $cupon_list->LoadRecordset($cupon_list->StartRec-1, $cupon_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cupon->TableCaption() ?>
&nbsp;&nbsp;<?php $cupon_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($cupon->Export == "" && $cupon->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(cupon_list);" style="text-decoration: none;"><img id="cupon_list_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="cupon_list_SearchPanel">
<form name="fcuponlistsrch" id="fcuponlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return cupon_list.ValidateSearch(this);">
<input type="hidden" id="t" name="t" value="cupon">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$cupon_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$cupon->RowType = EW_ROWTYPE_SEARCH;

// Render row
$cupon->ResetAttrs();
$cupon_list->RenderRow();
?>
<div id="xsr_1" class="ewCssTableRow">
	<span id="xsc_emp_id" class="ewCssTableCell">
		<span class="ewSearchCaption"><?php echo $cupon->emp_id->FldCaption() ?></span>
		<span class="ewSearchOprCell"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_emp_id" id="z_emp_id" value="="></span>
		<span class="ewSearchField">
<select id="x_emp_id" name="x_emp_id"<?php echo $cupon->emp_id->EditAttributes() ?>>
<?php
if (is_array($cupon->emp_id->EditValue)) {
	$arwrk = $cupon->emp_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon->emp_id->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,1,$cupon->emp_id) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][3] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,2,$cupon->emp_id) ?><?php echo $arwrk[$rowcntwrk][3] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
</span>
	</span>
</div>
<div id="xsr_2" class="ewCssTableRow">
	<span id="xsc_cat_id" class="ewCssTableCell">
		<span class="ewSearchCaption"><?php echo $cupon->cat_id->FldCaption() ?></span>
		<span class="ewSearchOprCell"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_cat_id" id="z_cat_id" value="="></span>
		<span class="ewSearchField">
<select id="x_cat_id" name="x_cat_id"<?php echo $cupon->cat_id->EditAttributes() ?>>
<?php
if (is_array($cupon->cat_id->EditValue)) {
	$arwrk = $cupon->cat_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon->cat_id->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span>
	</span>
</div>
<div id="xsr_3" class="ewCssTableRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($cupon->getSessionBasicSearchKeyword()) ?>">
	<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $cupon_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_4" class="ewCssTableRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($cupon->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($cupon->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($cupon->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
$cupon_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cupon->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cupon->CurrentAction <> "gridadd" && $cupon->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($cupon_list->Pager)) $cupon_list->Pager = new cPrevNextPager($cupon_list->StartRec, $cupon_list->DisplayRecs, $cupon_list->TotalRecs) ?>
<?php if ($cupon_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cupon_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_list->PageUrl() ?>start=<?php echo $cupon_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cupon_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_list->PageUrl() ?>start=<?php echo $cupon_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cupon_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cupon_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_list->PageUrl() ?>start=<?php echo $cupon_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cupon_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_list->PageUrl() ?>start=<?php echo $cupon_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cupon_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cupon_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cupon_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cupon_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($cupon_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $cupon_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($cupon_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fcuponlist, '<?php echo $cupon_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcuponlist" id="fcuponlist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="cupon">
<div id="gmp_cupon" class="ewGridMiddlePanel">
<?php if ($cupon_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $cupon->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cupon_list->RenderListOptions();

// Render list options (header, left)
$cupon_list->ListOptions->Render("header", "left");
?>
<?php if ($cupon->cup_id->Visible) { // cup_id ?>
	<?php if ($cupon->SortUrl($cupon->cup_id) == "") { ?>
		<td><?php echo $cupon->cup_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cupon->SortUrl($cupon->cup_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon->cup_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon->cup_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon->cup_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cupon->emp_id->Visible) { // emp_id ?>
	<?php if ($cupon->SortUrl($cupon->emp_id) == "") { ?>
		<td><?php echo $cupon->emp_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cupon->SortUrl($cupon->emp_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon->emp_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon->emp_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon->emp_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cupon->cat_id->Visible) { // cat_id ?>
	<?php if ($cupon->SortUrl($cupon->cat_id) == "") { ?>
		<td><?php echo $cupon->cat_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cupon->SortUrl($cupon->cat_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon->cat_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon->cat_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon->cat_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cupon->cup_nombre->Visible) { // cup_nombre ?>
	<?php if ($cupon->SortUrl($cupon->cup_nombre) == "") { ?>
		<td><?php echo $cupon->cup_nombre->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cupon->SortUrl($cupon->cup_nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon->cup_nombre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($cupon->cup_nombre->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon->cup_nombre->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cupon->cup_preview_nombre->Visible) { // cup_preview_nombre ?>
	<?php if ($cupon->SortUrl($cupon->cup_preview_nombre) == "") { ?>
		<td><?php echo $cupon->cup_preview_nombre->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cupon->SortUrl($cupon->cup_preview_nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon->cup_preview_nombre->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon->cup_preview_nombre->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon->cup_preview_nombre->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cupon->cup_imagen_nombre->Visible) { // cup_imagen_nombre ?>
	<?php if ($cupon->SortUrl($cupon->cup_imagen_nombre) == "") { ?>
		<td><?php echo $cupon->cup_imagen_nombre->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cupon->SortUrl($cupon->cup_imagen_nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon->cup_imagen_nombre->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon->cup_imagen_nombre->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon->cup_imagen_nombre->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cupon->cup_vigente->Visible) { // cup_vigente ?>
	<?php if ($cupon->SortUrl($cupon->cup_vigente) == "") { ?>
		<td><?php echo $cupon->cup_vigente->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cupon->SortUrl($cupon->cup_vigente) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon->cup_vigente->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon->cup_vigente->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon->cup_vigente->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cupon_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($cupon->ExportAll && $cupon->Export <> "") {
	$cupon_list->StopRec = $cupon_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cupon_list->TotalRecs > $cupon_list->StartRec + $cupon_list->DisplayRecs - 1)
		$cupon_list->StopRec = $cupon_list->StartRec + $cupon_list->DisplayRecs - 1;
	else
		$cupon_list->StopRec = $cupon_list->TotalRecs;
}
$cupon_list->RecCnt = $cupon_list->StartRec - 1;
if ($cupon_list->Recordset && !$cupon_list->Recordset->EOF) {
	$cupon_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cupon_list->StartRec > 1)
		$cupon_list->Recordset->Move($cupon_list->StartRec - 1);
} elseif (!$cupon->AllowAddDeleteRow && $cupon_list->StopRec == 0) {
	$cupon_list->StopRec = $cupon->GridAddRowCount;
}

// Initialize aggregate
$cupon->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cupon->ResetAttrs();
$cupon_list->RenderRow();
$cupon_list->RowCnt = 0;
while ($cupon_list->RecCnt < $cupon_list->StopRec) {
	$cupon_list->RecCnt++;
	if (intval($cupon_list->RecCnt) >= intval($cupon_list->StartRec)) {
		$cupon_list->RowCnt++;

		// Set up key count
		$cupon_list->KeyCount = $cupon_list->RowIndex;

		// Init row class and style
		$cupon->ResetAttrs();
		$cupon->CssClass = "";
		if ($cupon->CurrentAction == "gridadd") {
			$cupon_list->LoadDefaultValues(); // Load default values
		} else {
			$cupon_list->LoadRowValues($cupon_list->Recordset); // Load row values
		}
		$cupon->RowType = EW_ROWTYPE_VIEW; // Render view
		$cupon->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$cupon_list->RenderRow();

		// Render list options
		$cupon_list->RenderListOptions();
?>
	<tr<?php echo $cupon->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cupon_list->ListOptions->Render("body", "left");
?>
	<?php if ($cupon->cup_id->Visible) { // cup_id ?>
		<td<?php echo $cupon->cup_id->CellAttributes() ?>>
<div<?php echo $cupon->cup_id->ViewAttributes() ?>><?php echo $cupon->cup_id->ListViewValue() ?></div>
<a name="<?php echo $cupon_list->PageObjName . "_row_" . $cupon_list->RowCnt ?>" id="<?php echo $cupon_list->PageObjName . "_row_" . $cupon_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cupon->emp_id->Visible) { // emp_id ?>
		<td<?php echo $cupon->emp_id->CellAttributes() ?>>
<div<?php echo $cupon->emp_id->ViewAttributes() ?>><?php echo $cupon->emp_id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cupon->cat_id->Visible) { // cat_id ?>
		<td<?php echo $cupon->cat_id->CellAttributes() ?>>
<div<?php echo $cupon->cat_id->ViewAttributes() ?>><?php echo $cupon->cat_id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cupon->cup_nombre->Visible) { // cup_nombre ?>
		<td<?php echo $cupon->cup_nombre->CellAttributes() ?>>
<div<?php echo $cupon->cup_nombre->ViewAttributes() ?>><?php echo $cupon->cup_nombre->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cupon->cup_preview_nombre->Visible) { // cup_preview_nombre ?>
		<td<?php echo $cupon->cup_preview_nombre->CellAttributes() ?>>
<?php if ($cupon->cup_preview_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($cupon->cup_preview_nombre->Upload->DbValue)) { ?>
<a<?php echo $cupon->cup_preview_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_preview_nombre->UploadPath) . $cupon->cup_preview_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_preview_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($cupon->cup_preview_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_preview_nombre->UploadPath) . $cupon->cup_preview_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_preview_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cupon->cup_imagen_nombre->Visible) { // cup_imagen_nombre ?>
		<td<?php echo $cupon->cup_imagen_nombre->CellAttributes() ?>>
<?php if ($cupon->cup_imagen_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($cupon->cup_imagen_nombre->Upload->DbValue)) { ?>
<a<?php echo $cupon->cup_imagen_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_imagen_nombre->UploadPath) . $cupon->cup_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_imagen_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($cupon->cup_imagen_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_imagen_nombre->UploadPath) . $cupon->cup_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_imagen_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cupon->cup_vigente->Visible) { // cup_vigente ?>
		<td<?php echo $cupon->cup_vigente->CellAttributes() ?>>
<div<?php echo $cupon->cup_vigente->ViewAttributes() ?>><?php echo $cupon->cup_vigente->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cupon_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($cupon->CurrentAction <> "gridadd")
		$cupon_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cupon_list->Recordset)
	$cupon_list->Recordset->Close();
?>
<?php if ($cupon_list->TotalRecs > 0) { ?>
<?php if ($cupon->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cupon->CurrentAction <> "gridadd" && $cupon->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($cupon_list->Pager)) $cupon_list->Pager = new cPrevNextPager($cupon_list->StartRec, $cupon_list->DisplayRecs, $cupon_list->TotalRecs) ?>
<?php if ($cupon_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cupon_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_list->PageUrl() ?>start=<?php echo $cupon_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cupon_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_list->PageUrl() ?>start=<?php echo $cupon_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cupon_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cupon_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_list->PageUrl() ?>start=<?php echo $cupon_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cupon_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_list->PageUrl() ?>start=<?php echo $cupon_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cupon_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cupon_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cupon_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cupon_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($cupon_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $cupon_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($cupon_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fcuponlist, '<?php echo $cupon_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cupon->Export == "" && $cupon->CurrentAction == "") { ?>
<?php } ?>
<?php
$cupon_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cupon->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cupon_list->Page_Terminate();
?>
<?php

//
// Page class
//
class ccupon_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'cupon';

	// Page object name
	var $PageObjName = 'cupon_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cupon;
		if ($cupon->UseTokenInUrl) $PageUrl .= "t=" . $cupon->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			echo "<p class=\"ewMessage\">" . $sMessage . "</p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			echo "<p class=\"ewSuccessMessage\">" . $sSuccessMessage . "</p>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			echo "<p class=\"ewErrorMessage\">" . $sErrorMessage . "</p>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p class=\"phpmaker\">" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Fotoer exists, display
			echo "<p class=\"phpmaker\">" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm, $cupon;
		if ($cupon->UseTokenInUrl) {
			if ($objForm)
				return ($cupon->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cupon->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccupon_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (cupon)
		if (!isset($GLOBALS["cupon"])) {
			$GLOBALS["cupon"] = new ccupon();
			$GLOBALS["Table"] =& $GLOBALS["cupon"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cuponadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cupondelete.php";
		$this->MultiUpdateUrl = "cuponupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cupon', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->Separator = "&nbsp;&nbsp;";
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $cupon;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$cupon->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$cupon->Export = $_POST["exporttype"];
		} else {
			$cupon->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $cupon->Export; // Get export parameter, used in header
		$gsExportFile = $cupon->TableVar; // Get export file, used in header
		$Charset = (EW_CHARSET <> "") ? ";charset=" . EW_CHARSET : ""; // Charset used in header
		if ($cupon->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($cupon->Export == "word") {
			header('Content-Type: application/vnd.ms-word' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.doc');
		}
		if ($cupon->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$cupon->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		$this->Page_Redirecting($url);
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $RowCnt;
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RecPerRow = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $RestoreSearch;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $cupon;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Hide all options
			if ($cupon->Export <> "" ||
				$cupon->CurrentAction == "gridadd" ||
				$cupon->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$cupon->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($cupon->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $cupon->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$cupon->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			if ($sSrchAdvanced == "")
				$this->ResetAdvancedSearchParms();
			$cupon->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$cupon->setStartRecordNumber($this->StartRec);
			}
		} else {
			$this->SearchWhere = $cupon->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$cupon->setSessionWhere($sFilter);
		$cupon->CurrentFilter = "";

		// Export data only
		if (in_array($cupon->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($cupon->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security, $cupon;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $cupon->cup_id, FALSE); // cup_id
		$this->BuildSearchSql($sWhere, $cupon->emp_id, FALSE); // emp_id
		$this->BuildSearchSql($sWhere, $cupon->cat_id, FALSE); // cat_id
		$this->BuildSearchSql($sWhere, $cupon->cup_nombre, FALSE); // cup_nombre
		$this->BuildSearchSql($sWhere, $cupon->cup_preview_tipo, FALSE); // cup_preview_tipo
		$this->BuildSearchSql($sWhere, $cupon->cup_preview_ancho, FALSE); // cup_preview_ancho
		$this->BuildSearchSql($sWhere, $cupon->cup_preview_alto, FALSE); // cup_preview_alto
		$this->BuildSearchSql($sWhere, $cupon->cup_preview_size, FALSE); // cup_preview_size
		$this->BuildSearchSql($sWhere, $cupon->cup_imagen_tipo, FALSE); // cup_imagen_tipo
		$this->BuildSearchSql($sWhere, $cupon->cup_imagen_ancho, FALSE); // cup_imagen_ancho
		$this->BuildSearchSql($sWhere, $cupon->cup_imagen_alto, FALSE); // cup_imagen_alto
		$this->BuildSearchSql($sWhere, $cupon->cup_imagen_size, FALSE); // cup_imagen_size
		$this->BuildSearchSql($sWhere, $cupon->cup_vigente, FALSE); // cup_vigente

		// Set up search parm
		if ($sWhere <> "") {
			$this->SetSearchParm($cupon->cup_id); // cup_id
			$this->SetSearchParm($cupon->emp_id); // emp_id
			$this->SetSearchParm($cupon->cat_id); // cat_id
			$this->SetSearchParm($cupon->cup_nombre); // cup_nombre
			$this->SetSearchParm($cupon->cup_preview_tipo); // cup_preview_tipo
			$this->SetSearchParm($cupon->cup_preview_ancho); // cup_preview_ancho
			$this->SetSearchParm($cupon->cup_preview_alto); // cup_preview_alto
			$this->SetSearchParm($cupon->cup_preview_size); // cup_preview_size
			$this->SetSearchParm($cupon->cup_imagen_tipo); // cup_imagen_tipo
			$this->SetSearchParm($cupon->cup_imagen_ancho); // cup_imagen_ancho
			$this->SetSearchParm($cupon->cup_imagen_alto); // cup_imagen_alto
			$this->SetSearchParm($cupon->cup_imagen_size); // cup_imagen_size
			$this->SetSearchParm($cupon->cup_vigente); // cup_vigente
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);		
		$FldVal = $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldVal) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldVal2) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Set search parameters
	function SetSearchParm(&$Fld) {
		global $cupon;
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$cupon->setAdvancedSearch("x_$FldParm", $FldVal);
		$cupon->setAdvancedSearch("z_$FldParm", $Fld->AdvancedSearch->SearchOperator); // @$_GET["z_$FldParm"]
		$cupon->setAdvancedSearch("v_$FldParm", $Fld->AdvancedSearch->SearchCondition); // @$_GET["v_$FldParm"]
		$cupon->setAdvancedSearch("y_$FldParm", $FldVal2);
		$cupon->setAdvancedSearch("w_$FldParm", $Fld->AdvancedSearch->SearchOperator2); // @$_GET["w_$FldParm"]
	}

	// Get search parameters
	function GetSearchParm(&$Fld) {
		global $cupon;
		$FldParm = substr($Fld->FldVar, 2);
		$Fld->AdvancedSearch->SearchValue = $cupon->GetAdvancedSearch("x_$FldParm");
		$Fld->AdvancedSearch->SearchOperator = $cupon->GetAdvancedSearch("z_$FldParm");
		$Fld->AdvancedSearch->SearchCondition = $cupon->GetAdvancedSearch("v_$FldParm");
		$Fld->AdvancedSearch->SearchValue2 = $cupon->GetAdvancedSearch("y_$FldParm");
		$Fld->AdvancedSearch->SearchOperator2 = $cupon->GetAdvancedSearch("w_$FldParm");
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $cupon;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $cupon->cup_nombre, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $cupon->cup_preview_nombre, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $cupon->cup_preview_tipo, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $cupon->cup_imagen_nombre, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $cupon->cup_imagen_tipo, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		$sFldExpression = ($Fld->FldVirtualExpression <> "") ? $Fld->FldVirtualExpression : $Fld->FldExpression;
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($lFldDataType == EW_DATATYPE_NUMBER) {
			$sWrk = $sFldExpression . " = " . ew_QuotedValue($Keyword, $lFldDataType);
		} else {
			$sWrk = $sFldExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", $lFldDataType));
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $cupon;
		$sSearchStr = "";
		$sSearchKeyword = $cupon->BasicSearchKeyword;
		$sSearchType = $cupon->BasicSearchType;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
		}
		if ($sSearchKeyword <> "") {
			$cupon->setSessionBasicSearchKeyword($sSearchKeyword);
			$cupon->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $cupon;

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$cupon->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $cupon;
		$cupon->setSessionBasicSearchKeyword("");
		$cupon->setSessionBasicSearchType("");
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		global $cupon;
		$cupon->setAdvancedSearch("x_cup_id", "");
		$cupon->setAdvancedSearch("x_emp_id", "");
		$cupon->setAdvancedSearch("x_cat_id", "");
		$cupon->setAdvancedSearch("x_cup_nombre", "");
		$cupon->setAdvancedSearch("x_cup_preview_tipo", "");
		$cupon->setAdvancedSearch("x_cup_preview_ancho", "");
		$cupon->setAdvancedSearch("x_cup_preview_alto", "");
		$cupon->setAdvancedSearch("x_cup_preview_size", "");
		$cupon->setAdvancedSearch("x_cup_imagen_tipo", "");
		$cupon->setAdvancedSearch("x_cup_imagen_ancho", "");
		$cupon->setAdvancedSearch("x_cup_imagen_alto", "");
		$cupon->setAdvancedSearch("x_cup_imagen_size", "");
		$cupon->setAdvancedSearch("x_cup_vigente", "");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $cupon;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		if (@$_GET["x_cup_id"] <> "") $bRestore = FALSE;
		if (@$_GET["x_emp_id"] <> "") $bRestore = FALSE;
		if (@$_GET["x_cat_id"] <> "") $bRestore = FALSE;
		if (@$_GET["x_cup_nombre"] <> "") $bRestore = FALSE;
		if (@$_GET["x_cup_preview_tipo"] <> "") $bRestore = FALSE;
		if (@$_GET["x_cup_preview_ancho"] <> "") $bRestore = FALSE;
		if (@$_GET["x_cup_preview_alto"] <> "") $bRestore = FALSE;
		if (@$_GET["x_cup_preview_size"] <> "") $bRestore = FALSE;
		if (@$_GET["x_cup_imagen_tipo"] <> "") $bRestore = FALSE;
		if (@$_GET["x_cup_imagen_ancho"] <> "") $bRestore = FALSE;
		if (@$_GET["x_cup_imagen_alto"] <> "") $bRestore = FALSE;
		if (@$_GET["x_cup_imagen_size"] <> "") $bRestore = FALSE;
		if (@$_GET["x_cup_vigente"] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$cupon->BasicSearchKeyword = $cupon->getSessionBasicSearchKeyword();
			$cupon->BasicSearchType = $cupon->getSessionBasicSearchType();

			// Restore advanced search values
			$this->GetSearchParm($cupon->cup_id);
			$this->GetSearchParm($cupon->emp_id);
			$this->GetSearchParm($cupon->cat_id);
			$this->GetSearchParm($cupon->cup_nombre);
			$this->GetSearchParm($cupon->cup_preview_tipo);
			$this->GetSearchParm($cupon->cup_preview_ancho);
			$this->GetSearchParm($cupon->cup_preview_alto);
			$this->GetSearchParm($cupon->cup_preview_size);
			$this->GetSearchParm($cupon->cup_imagen_tipo);
			$this->GetSearchParm($cupon->cup_imagen_ancho);
			$this->GetSearchParm($cupon->cup_imagen_alto);
			$this->GetSearchParm($cupon->cup_imagen_size);
			$this->GetSearchParm($cupon->cup_vigente);
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $cupon;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$cupon->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$cupon->CurrentOrderType = @$_GET["ordertype"];
			$cupon->UpdateSort($cupon->cup_id); // cup_id
			$cupon->UpdateSort($cupon->emp_id); // emp_id
			$cupon->UpdateSort($cupon->cat_id); // cat_id
			$cupon->UpdateSort($cupon->cup_nombre); // cup_nombre
			$cupon->UpdateSort($cupon->cup_preview_nombre); // cup_preview_nombre
			$cupon->UpdateSort($cupon->cup_imagen_nombre); // cup_imagen_nombre
			$cupon->UpdateSort($cupon->cup_vigente); // cup_vigente
			$cupon->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $cupon;
		$sOrderBy = $cupon->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($cupon->SqlOrderBy() <> "") {
				$sOrderBy = $cupon->SqlOrderBy();
				$cupon->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $cupon;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$cupon->setSessionOrderBy($sOrderBy);
				$cupon->cup_id->setSort("");
				$cupon->emp_id->setSort("");
				$cupon->cat_id->setSort("");
				$cupon->cup_nombre->setSort("");
				$cupon->cup_preview_nombre->setSort("");
				$cupon->cup_imagen_nombre->setSort("");
				$cupon->cup_vigente->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$cupon->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $cupon;

		// "view"
		$item =& $this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;

		// "edit"
		$item =& $this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;

		// "copy"
		$item =& $this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;

		// "checkbox"
		$item =& $this->ListOptions->Add("checkbox");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"cupon_list.SelectAllKey(this);\">";
		$item->MoveTo(0);

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $cupon, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt =& $this->ListOptions->Items["view"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible)
			$oListOpt->Body = "<a href=\"" . $this->ViewUrl . "\">" . $Language->Phrase("ViewLink") . "</a>";

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->EditUrl . "\">" . $Language->Phrase("EditLink") . "</a>";
		}

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->CopyUrl . "\">" . $Language->Phrase("CopyLink") . "</a>";
		}

		// "checkbox"
		$oListOpt =& $this->ListOptions->Items["checkbox"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible)
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($cupon->cup_id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $cupon;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $cupon;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$cupon->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$cupon->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $cupon->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$cupon->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$cupon->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$cupon->setStartRecordNumber($this->StartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $cupon;
		$cupon->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$cupon->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm, $cupon;

		// Load search values
		// cup_id

		$cupon->cup_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cup_id"]);
		$cupon->cup_id->AdvancedSearch->SearchOperator = @$_GET["z_cup_id"];

		// emp_id
		$cupon->emp_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_emp_id"]);
		$cupon->emp_id->AdvancedSearch->SearchOperator = @$_GET["z_emp_id"];

		// cat_id
		$cupon->cat_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cat_id"]);
		$cupon->cat_id->AdvancedSearch->SearchOperator = @$_GET["z_cat_id"];

		// cup_nombre
		$cupon->cup_nombre->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cup_nombre"]);
		$cupon->cup_nombre->AdvancedSearch->SearchOperator = @$_GET["z_cup_nombre"];

		// cup_preview_tipo
		$cupon->cup_preview_tipo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cup_preview_tipo"]);
		$cupon->cup_preview_tipo->AdvancedSearch->SearchOperator = @$_GET["z_cup_preview_tipo"];

		// cup_preview_ancho
		$cupon->cup_preview_ancho->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cup_preview_ancho"]);
		$cupon->cup_preview_ancho->AdvancedSearch->SearchOperator = @$_GET["z_cup_preview_ancho"];

		// cup_preview_alto
		$cupon->cup_preview_alto->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cup_preview_alto"]);
		$cupon->cup_preview_alto->AdvancedSearch->SearchOperator = @$_GET["z_cup_preview_alto"];

		// cup_preview_size
		$cupon->cup_preview_size->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cup_preview_size"]);
		$cupon->cup_preview_size->AdvancedSearch->SearchOperator = @$_GET["z_cup_preview_size"];

		// cup_imagen_tipo
		$cupon->cup_imagen_tipo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cup_imagen_tipo"]);
		$cupon->cup_imagen_tipo->AdvancedSearch->SearchOperator = @$_GET["z_cup_imagen_tipo"];

		// cup_imagen_ancho
		$cupon->cup_imagen_ancho->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cup_imagen_ancho"]);
		$cupon->cup_imagen_ancho->AdvancedSearch->SearchOperator = @$_GET["z_cup_imagen_ancho"];

		// cup_imagen_alto
		$cupon->cup_imagen_alto->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cup_imagen_alto"]);
		$cupon->cup_imagen_alto->AdvancedSearch->SearchOperator = @$_GET["z_cup_imagen_alto"];

		// cup_imagen_size
		$cupon->cup_imagen_size->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cup_imagen_size"]);
		$cupon->cup_imagen_size->AdvancedSearch->SearchOperator = @$_GET["z_cup_imagen_size"];

		// cup_vigente
		$cupon->cup_vigente->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cup_vigente"]);
		$cupon->cup_vigente->AdvancedSearch->SearchOperator = @$_GET["z_cup_vigente"];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $cupon;

		// Call Recordset Selecting event
		$cupon->Recordset_Selecting($cupon->CurrentFilter);

		// Load List page SQL
		$sSql = $cupon->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$cupon->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cupon;
		$sFilter = $cupon->KeyFilter();

		// Call Row Selecting event
		$cupon->Row_Selecting($sFilter);

		// Load SQL based on filter
		$cupon->CurrentFilter = $sFilter;
		$sSql = $cupon->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$cupon->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $cupon;
		if (!$rs || $rs->EOF) return;
		$cupon->cup_id->setDbValue($rs->fields('cup_id'));
		$cupon->emp_id->setDbValue($rs->fields('emp_id'));
		$cupon->cat_id->setDbValue($rs->fields('cat_id'));
		$cupon->cup_nombre->setDbValue($rs->fields('cup_nombre'));
		$cupon->cup_preview_nombre->Upload->DbValue = $rs->fields('cup_preview_nombre');
		$cupon->cup_preview_tipo->setDbValue($rs->fields('cup_preview_tipo'));
		$cupon->cup_preview_ancho->setDbValue($rs->fields('cup_preview_ancho'));
		$cupon->cup_preview_alto->setDbValue($rs->fields('cup_preview_alto'));
		$cupon->cup_preview_size->setDbValue($rs->fields('cup_preview_size'));
		$cupon->cup_imagen_nombre->Upload->DbValue = $rs->fields('cup_imagen_nombre');
		$cupon->cup_imagen_tipo->setDbValue($rs->fields('cup_imagen_tipo'));
		$cupon->cup_imagen_ancho->setDbValue($rs->fields('cup_imagen_ancho'));
		$cupon->cup_imagen_alto->setDbValue($rs->fields('cup_imagen_alto'));
		$cupon->cup_imagen_size->setDbValue($rs->fields('cup_imagen_size'));
		$cupon->cup_vigente->setDbValue($rs->fields('cup_vigente'));
	}

	// Load old record
	function LoadOldRecord() {
		global $cupon;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($cupon->getKey("cup_id")) <> "")
			$cupon->cup_id->CurrentValue = $cupon->getKey("cup_id"); // cup_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$cupon->CurrentFilter = $cupon->KeyFilter();
			$sSql = $cupon->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $cupon;

		// Initialize URLs
		$this->ViewUrl = $cupon->ViewUrl();
		$this->EditUrl = $cupon->EditUrl();
		$this->InlineEditUrl = $cupon->InlineEditUrl();
		$this->CopyUrl = $cupon->CopyUrl();
		$this->InlineCopyUrl = $cupon->InlineCopyUrl();
		$this->DeleteUrl = $cupon->DeleteUrl();

		// Call Row_Rendering event
		$cupon->Row_Rendering();

		// Common render codes for all row types
		// cup_id
		// emp_id
		// cat_id
		// cup_nombre
		// cup_preview_nombre
		// cup_preview_tipo
		// cup_preview_ancho
		// cup_preview_alto
		// cup_preview_size
		// cup_imagen_nombre
		// cup_imagen_tipo
		// cup_imagen_ancho
		// cup_imagen_alto
		// cup_imagen_size
		// cup_vigente

		if ($cupon->RowType == EW_ROWTYPE_VIEW) { // View row

			// cup_id
			$cupon->cup_id->ViewValue = $cupon->cup_id->CurrentValue;
			$cupon->cup_id->ViewCustomAttributes = "";

			// emp_id
			if (strval($cupon->emp_id->CurrentValue) <> "") {
				$sFilterWrk = "`emp_id` = " . ew_AdjustSql($cupon->emp_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `emp_rut`, `emp_nomfantasia`, `emp_razonsocial` FROM `empresa`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `emp_rut` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$cupon->emp_id->ViewValue = $rswrk->fields('emp_rut');
					$cupon->emp_id->ViewValue .= ew_ValueSeparator(0,1,$cupon->emp_id) . $rswrk->fields('emp_nomfantasia');
					$cupon->emp_id->ViewValue .= ew_ValueSeparator(0,2,$cupon->emp_id) . $rswrk->fields('emp_razonsocial');
					$rswrk->Close();
				} else {
					$cupon->emp_id->ViewValue = $cupon->emp_id->CurrentValue;
				}
			} else {
				$cupon->emp_id->ViewValue = NULL;
			}
			$cupon->emp_id->ViewCustomAttributes = "";

			// cat_id
			if (strval($cupon->cat_id->CurrentValue) <> "") {
				$sFilterWrk = "`cat_id` = " . ew_AdjustSql($cupon->cat_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cat_nombre` FROM `categoria`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `cat_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$cupon->cat_id->ViewValue = $rswrk->fields('cat_nombre');
					$rswrk->Close();
				} else {
					$cupon->cat_id->ViewValue = $cupon->cat_id->CurrentValue;
				}
			} else {
				$cupon->cat_id->ViewValue = NULL;
			}
			$cupon->cat_id->ViewCustomAttributes = "";

			// cup_nombre
			$cupon->cup_nombre->ViewValue = $cupon->cup_nombre->CurrentValue;
			$cupon->cup_nombre->ViewCustomAttributes = "";

			// cup_preview_nombre
			if (!ew_Empty($cupon->cup_preview_nombre->Upload->DbValue)) {
				$cupon->cup_preview_nombre->ViewValue = $cupon->cup_preview_nombre->Upload->DbValue;
				$cupon->cup_preview_nombre->ImageWidth = 100;
				$cupon->cup_preview_nombre->ImageHeight = 0;
				$cupon->cup_preview_nombre->ImageAlt = $cupon->cup_preview_nombre->FldAlt();
			} else {
				$cupon->cup_preview_nombre->ViewValue = "";
			}
			$cupon->cup_preview_nombre->ViewCustomAttributes = "";

			// cup_preview_ancho
			$cupon->cup_preview_ancho->ViewValue = $cupon->cup_preview_ancho->CurrentValue;
			$cupon->cup_preview_ancho->ViewValue = ew_FormatNumber($cupon->cup_preview_ancho->ViewValue, 0, -2, -2, -2);
			$cupon->cup_preview_ancho->ViewCustomAttributes = "";

			// cup_preview_alto
			$cupon->cup_preview_alto->ViewValue = $cupon->cup_preview_alto->CurrentValue;
			$cupon->cup_preview_alto->ViewValue = ew_FormatNumber($cupon->cup_preview_alto->ViewValue, 0, -2, -2, -2);
			$cupon->cup_preview_alto->ViewCustomAttributes = "";

			// cup_imagen_nombre
			if (!ew_Empty($cupon->cup_imagen_nombre->Upload->DbValue)) {
				$cupon->cup_imagen_nombre->ViewValue = $cupon->cup_imagen_nombre->Upload->DbValue;
				$cupon->cup_imagen_nombre->ImageWidth = 100;
				$cupon->cup_imagen_nombre->ImageHeight = 0;
				$cupon->cup_imagen_nombre->ImageAlt = $cupon->cup_imagen_nombre->FldAlt();
			} else {
				$cupon->cup_imagen_nombre->ViewValue = "";
			}
			$cupon->cup_imagen_nombre->ViewCustomAttributes = "";

			// cup_imagen_ancho
			$cupon->cup_imagen_ancho->ViewValue = $cupon->cup_imagen_ancho->CurrentValue;
			$cupon->cup_imagen_ancho->ViewValue = ew_FormatNumber($cupon->cup_imagen_ancho->ViewValue, 0, -2, -2, -2);
			$cupon->cup_imagen_ancho->ViewCustomAttributes = "";

			// cup_imagen_alto
			$cupon->cup_imagen_alto->ViewValue = $cupon->cup_imagen_alto->CurrentValue;
			$cupon->cup_imagen_alto->ViewValue = ew_FormatNumber($cupon->cup_imagen_alto->ViewValue, 0, -2, -2, -2);
			$cupon->cup_imagen_alto->ViewCustomAttributes = "";

			// cup_vigente
			if (strval($cupon->cup_vigente->CurrentValue) <> "") {
				switch ($cupon->cup_vigente->CurrentValue) {
					case "1":
						$cupon->cup_vigente->ViewValue = $cupon->cup_vigente->FldTagCaption(1) <> "" ? $cupon->cup_vigente->FldTagCaption(1) : $cupon->cup_vigente->CurrentValue;
						break;
					case "0":
						$cupon->cup_vigente->ViewValue = $cupon->cup_vigente->FldTagCaption(2) <> "" ? $cupon->cup_vigente->FldTagCaption(2) : $cupon->cup_vigente->CurrentValue;
						break;
					default:
						$cupon->cup_vigente->ViewValue = $cupon->cup_vigente->CurrentValue;
				}
			} else {
				$cupon->cup_vigente->ViewValue = NULL;
			}
			$cupon->cup_vigente->ViewCustomAttributes = "";

			// cup_id
			$cupon->cup_id->LinkCustomAttributes = "";
			$cupon->cup_id->HrefValue = "";
			$cupon->cup_id->TooltipValue = "";

			// emp_id
			$cupon->emp_id->LinkCustomAttributes = "";
			$cupon->emp_id->HrefValue = "";
			$cupon->emp_id->TooltipValue = "";

			// cat_id
			$cupon->cat_id->LinkCustomAttributes = "";
			$cupon->cat_id->HrefValue = "";
			$cupon->cat_id->TooltipValue = "";

			// cup_nombre
			$cupon->cup_nombre->LinkCustomAttributes = "";
			$cupon->cup_nombre->HrefValue = "";
			$cupon->cup_nombre->TooltipValue = "";

			// cup_preview_nombre
			$cupon->cup_preview_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($cupon->cup_preview_nombre->Upload->DbValue)) {
				$cupon->cup_preview_nombre->HrefValue = ew_UploadPathEx(FALSE, $cupon->cup_preview_nombre->UploadPath) . ((!empty($cupon->cup_preview_nombre->ViewValue)) ? $cupon->cup_preview_nombre->ViewValue : $cupon->cup_preview_nombre->CurrentValue); // Add prefix/suffix
				$cupon->cup_preview_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($cupon->Export <> "") $cupon->cup_preview_nombre->HrefValue = ew_ConvertFullUrl($cupon->cup_preview_nombre->HrefValue);
			} else {
				$cupon->cup_preview_nombre->HrefValue = "";
			}
			$cupon->cup_preview_nombre->TooltipValue = "";

			// cup_imagen_nombre
			$cupon->cup_imagen_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($cupon->cup_imagen_nombre->Upload->DbValue)) {
				$cupon->cup_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $cupon->cup_imagen_nombre->UploadPath) . ((!empty($cupon->cup_imagen_nombre->ViewValue)) ? $cupon->cup_imagen_nombre->ViewValue : $cupon->cup_imagen_nombre->CurrentValue); // Add prefix/suffix
				$cupon->cup_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($cupon->Export <> "") $cupon->cup_imagen_nombre->HrefValue = ew_ConvertFullUrl($cupon->cup_imagen_nombre->HrefValue);
			} else {
				$cupon->cup_imagen_nombre->HrefValue = "";
			}
			$cupon->cup_imagen_nombre->TooltipValue = "";

			// cup_vigente
			$cupon->cup_vigente->LinkCustomAttributes = "";
			$cupon->cup_vigente->HrefValue = "";
			$cupon->cup_vigente->TooltipValue = "";
		} elseif ($cupon->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// cup_id
			$cupon->cup_id->EditCustomAttributes = "";
			$cupon->cup_id->EditValue = ew_HtmlEncode($cupon->cup_id->AdvancedSearch->SearchValue);

			// emp_id
			$cupon->emp_id->EditCustomAttributes = "";
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `emp_id`, `emp_rut` AS `DispFld`, `emp_nomfantasia` AS `Disp2Fld`, `emp_razonsocial` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld` FROM `empresa`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `emp_rut` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", ""));
			$cupon->emp_id->EditValue = $arwrk;

			// cat_id
			$cupon->cat_id->EditCustomAttributes = "";
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `cat_id`, `cat_nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld` FROM `categoria`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `cat_nombre` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$cupon->cat_id->EditValue = $arwrk;

			// cup_nombre
			$cupon->cup_nombre->EditCustomAttributes = "";
			$cupon->cup_nombre->EditValue = ew_HtmlEncode($cupon->cup_nombre->AdvancedSearch->SearchValue);

			// cup_preview_nombre
			$cupon->cup_preview_nombre->EditCustomAttributes = "";
			if (!ew_Empty($cupon->cup_preview_nombre->Upload->DbValue)) {
				$cupon->cup_preview_nombre->EditValue = $cupon->cup_preview_nombre->Upload->DbValue;
				$cupon->cup_preview_nombre->ImageWidth = 100;
				$cupon->cup_preview_nombre->ImageHeight = 0;
				$cupon->cup_preview_nombre->ImageAlt = $cupon->cup_preview_nombre->FldAlt();
			} else {
				$cupon->cup_preview_nombre->EditValue = "";
			}

			// cup_imagen_nombre
			$cupon->cup_imagen_nombre->EditCustomAttributes = "";
			if (!ew_Empty($cupon->cup_imagen_nombre->Upload->DbValue)) {
				$cupon->cup_imagen_nombre->EditValue = $cupon->cup_imagen_nombre->Upload->DbValue;
				$cupon->cup_imagen_nombre->ImageWidth = 100;
				$cupon->cup_imagen_nombre->ImageHeight = 0;
				$cupon->cup_imagen_nombre->ImageAlt = $cupon->cup_imagen_nombre->FldAlt();
			} else {
				$cupon->cup_imagen_nombre->EditValue = "";
			}

			// cup_vigente
			$cupon->cup_vigente->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("1", $cupon->cup_vigente->FldTagCaption(1) <> "" ? $cupon->cup_vigente->FldTagCaption(1) : "1");
			$arwrk[] = array("0", $cupon->cup_vigente->FldTagCaption(2) <> "" ? $cupon->cup_vigente->FldTagCaption(2) : "0");
			$cupon->cup_vigente->EditValue = $arwrk;
		}
		if ($cupon->RowType == EW_ROWTYPE_ADD ||
			$cupon->RowType == EW_ROWTYPE_EDIT ||
			$cupon->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$cupon->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($cupon->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$cupon->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $cupon;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		global $cupon;
		$cupon->cup_id->AdvancedSearch->SearchValue = $cupon->getAdvancedSearch("x_cup_id");
		$cupon->emp_id->AdvancedSearch->SearchValue = $cupon->getAdvancedSearch("x_emp_id");
		$cupon->cat_id->AdvancedSearch->SearchValue = $cupon->getAdvancedSearch("x_cat_id");
		$cupon->cup_nombre->AdvancedSearch->SearchValue = $cupon->getAdvancedSearch("x_cup_nombre");
		$cupon->cup_preview_tipo->AdvancedSearch->SearchValue = $cupon->getAdvancedSearch("x_cup_preview_tipo");
		$cupon->cup_preview_ancho->AdvancedSearch->SearchValue = $cupon->getAdvancedSearch("x_cup_preview_ancho");
		$cupon->cup_preview_alto->AdvancedSearch->SearchValue = $cupon->getAdvancedSearch("x_cup_preview_alto");
		$cupon->cup_preview_size->AdvancedSearch->SearchValue = $cupon->getAdvancedSearch("x_cup_preview_size");
		$cupon->cup_imagen_tipo->AdvancedSearch->SearchValue = $cupon->getAdvancedSearch("x_cup_imagen_tipo");
		$cupon->cup_imagen_ancho->AdvancedSearch->SearchValue = $cupon->getAdvancedSearch("x_cup_imagen_ancho");
		$cupon->cup_imagen_alto->AdvancedSearch->SearchValue = $cupon->getAdvancedSearch("x_cup_imagen_alto");
		$cupon->cup_imagen_size->AdvancedSearch->SearchValue = $cupon->getAdvancedSearch("x_cup_imagen_size");
		$cupon->cup_vigente->AdvancedSearch->SearchValue = $cupon->getAdvancedSearch("x_cup_vigente");
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language, $cupon;

		// Printer friendly
		$item =& $this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item =& $this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item =& $this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item =& $this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item =& $this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item =& $this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item =& $this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item =& $this->ExportOptions->Add("email");
		$item->Body = "<a name=\"emf_cupon\" id=\"emf_cupon\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cupon',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcuponlist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($cupon->Export <> "" ||
			$cupon->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $cupon;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $cupon->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($cupon->ExportAll) {
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs < 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		if ($cupon->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($cupon, "h");
		}
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		if ($cupon->Export == "xml") {
			$cupon->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$cupon->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
			$sFooter = $this->PageFooter;
			$this->Page_DataRendered($sFooter);
			$ExportDoc->Text .= $sFooter;
		}

		// Close recordset
		$rs->Close();

		// Export header and footer
		if ($cupon->Export <> "xml") {
			$ExportDoc->ExportHeaderAndFooter();
		}

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($cupon->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($cupon->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($cupon->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($cupon->ExportReturnUrl());
		} elseif ($cupon->Export == "pdf") {
			$this->ExportPDF($ExportDoc->Text);
		} else {
			echo $ExportDoc->Text;
		}
	}

	// Export PDF
	function ExportPDF($html) {
		global $gsExportFile;
		include_once "dompdf060b2/dompdf_config.inc.php";
		@ini_set("memory_limit", EW_PDF_MEMORY_LIMIT);
		set_time_limit(EW_PDF_TIME_LIMIT);
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper("letter", "portrait");
		$dompdf->render();
		ob_end_clean();
		ew_DeleteTmpImages();
		$dompdf->stream($gsExportFile . ".pdf", array("Attachment" => 1)); // 0 to open in browser, 1 to download

//		exit();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt =& $this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>
