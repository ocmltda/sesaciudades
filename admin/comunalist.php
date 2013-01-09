<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "comunainfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$comuna_list = new ccomuna_list();
$Page =& $comuna_list;

// Page init
$comuna_list->Page_Init();

// Page main
$comuna_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($comuna->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var comuna_list = new ew_Page("comuna_list");

// page properties
comuna_list.PageID = "list"; // page ID
comuna_list.FormID = "fcomunalist"; // form ID
var EW_PAGE_ID = comuna_list.PageID; // for backward compatibility

// extend page with validate function for search
comuna_list.ValidateSearch = function(fobj) {
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
comuna_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
comuna_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
comuna_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
comuna_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($comuna->Export == "") || (EW_EXPORT_MASTER_RECORD && $comuna->Export == "print")) { ?>
<?php } ?>
<?php $comuna_list->ShowPageHeader(); ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$comuna_list->TotalRecs = $comuna->SelectRecordCount();
	} else {
		if ($comuna_list->Recordset = $comuna_list->LoadRecordset())
			$comuna_list->TotalRecs = $comuna_list->Recordset->RecordCount();
	}
	$comuna_list->StartRec = 1;
	if ($comuna_list->DisplayRecs <= 0 || ($comuna->Export <> "" && $comuna->ExportAll)) // Display all records
		$comuna_list->DisplayRecs = $comuna_list->TotalRecs;
	if (!($comuna->Export <> "" && $comuna->ExportAll))
		$comuna_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$comuna_list->Recordset = $comuna_list->LoadRecordset($comuna_list->StartRec-1, $comuna_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $comuna->TableCaption() ?>
&nbsp;&nbsp;<?php $comuna_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($comuna->Export == "" && $comuna->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(comuna_list);" style="text-decoration: none;"><img id="comuna_list_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="comuna_list_SearchPanel">
<form name="fcomunalistsrch" id="fcomunalistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return comuna_list.ValidateSearch(this);">
<input type="hidden" id="t" name="t" value="comuna">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$comuna_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$comuna->RowType = EW_ROWTYPE_SEARCH;

// Render row
$comuna->ResetAttrs();
$comuna_list->RenderRow();
?>
<div id="xsr_1" class="ewCssTableRow">
	<span id="xsc_reg_id" class="ewCssTableCell">
		<span class="ewSearchCaption"><?php echo $comuna->reg_id->FldCaption() ?></span>
		<span class="ewSearchOprCell"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_reg_id" id="z_reg_id" value="="></span>
		<span class="ewSearchField">
<?php $comuna->reg_id->EditAttrs["onchange"] = "ew_UpdateOpt('x_ciu_id','x_reg_id',comuna_list.ar_x_ciu_id); " . @$comuna->reg_id->EditAttrs["onchange"]; ?>
<select id="x_reg_id" name="x_reg_id"<?php echo $comuna->reg_id->EditAttributes() ?>>
<?php
if (is_array($comuna->reg_id->EditValue)) {
	$arwrk = $comuna->reg_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($comuna->reg_id->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,1,$comuna->reg_id) ?><?php echo $arwrk[$rowcntwrk][2] ?>
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
	<span id="xsc_ciu_id" class="ewCssTableCell">
		<span class="ewSearchCaption"><?php echo $comuna->ciu_id->FldCaption() ?></span>
		<span class="ewSearchOprCell"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_ciu_id" id="z_ciu_id" value="="></span>
		<span class="ewSearchField">
<select id="x_ciu_id" name="x_ciu_id"<?php echo $comuna->ciu_id->EditAttributes() ?>>
<?php
if (is_array($comuna->ciu_id->EditValue)) {
	$arwrk = $comuna->ciu_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($comuna->ciu_id->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php
$jswrk = "";
if (is_array($comuna->ciu_id->EditValue)) {
	$arwrk = $comuna->ciu_id->EditValue;
	$arwrkcnt = count($arwrk);
	for ($rowcntwrk = 1; $rowcntwrk < $arwrkcnt; $rowcntwrk++) {
		if ($jswrk <> "") $jswrk .= ",";
		$jswrk .= "['" . ew_JsEncode($arwrk[$rowcntwrk][0]) . "',"; // Value
		$jswrk .= "'" . ew_JsEncode($arwrk[$rowcntwrk][1]) . "',"; // Display field 1
		$jswrk .= "'" . ew_JsEncode($arwrk[$rowcntwrk][2]) . "',"; // Display field 2
		$jswrk .= "'" . ew_JsEncode($arwrk[$rowcntwrk][3]) . "',"; // Display field 3
		$jswrk .= "'" . ew_JsEncode($arwrk[$rowcntwrk][4]) . "',"; // Display field 4
		$jswrk .= "'" . ew_JsEncode($arwrk[$rowcntwrk][5]) . "']"; // Filter field
	}
}
?>
<script type="text/javascript">
<!--
comuna_list.ar_x_ciu_id = [<?php echo $jswrk ?>];

//-->
</script>
</span>
	</span>
</div>
<div id="xsr_3" class="ewCssTableRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($comuna->getSessionBasicSearchKeyword()) ?>">
	<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $comuna_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_4" class="ewCssTableRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($comuna->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($comuna->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($comuna->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
$comuna_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($comuna->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($comuna->CurrentAction <> "gridadd" && $comuna->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($comuna_list->Pager)) $comuna_list->Pager = new cPrevNextPager($comuna_list->StartRec, $comuna_list->DisplayRecs, $comuna_list->TotalRecs) ?>
<?php if ($comuna_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($comuna_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $comuna_list->PageUrl() ?>start=<?php echo $comuna_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($comuna_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $comuna_list->PageUrl() ?>start=<?php echo $comuna_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $comuna_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($comuna_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $comuna_list->PageUrl() ?>start=<?php echo $comuna_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($comuna_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $comuna_list->PageUrl() ?>start=<?php echo $comuna_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $comuna_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $comuna_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $comuna_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $comuna_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($comuna_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $comuna_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($comuna_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fcomunalist, '<?php echo $comuna_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcomunalist" id="fcomunalist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="comuna">
<div id="gmp_comuna" class="ewGridMiddlePanel">
<?php if ($comuna_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $comuna->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$comuna_list->RenderListOptions();

// Render list options (header, left)
$comuna_list->ListOptions->Render("header", "left");
?>
<?php if ($comuna->com_id->Visible) { // com_id ?>
	<?php if ($comuna->SortUrl($comuna->com_id) == "") { ?>
		<td><?php echo $comuna->com_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $comuna->SortUrl($comuna->com_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $comuna->com_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($comuna->com_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($comuna->com_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($comuna->reg_id->Visible) { // reg_id ?>
	<?php if ($comuna->SortUrl($comuna->reg_id) == "") { ?>
		<td><?php echo $comuna->reg_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $comuna->SortUrl($comuna->reg_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $comuna->reg_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($comuna->reg_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($comuna->reg_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($comuna->ciu_id->Visible) { // ciu_id ?>
	<?php if ($comuna->SortUrl($comuna->ciu_id) == "") { ?>
		<td><?php echo $comuna->ciu_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $comuna->SortUrl($comuna->ciu_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $comuna->ciu_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($comuna->ciu_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($comuna->ciu_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($comuna->com_nombre->Visible) { // com_nombre ?>
	<?php if ($comuna->SortUrl($comuna->com_nombre) == "") { ?>
		<td><?php echo $comuna->com_nombre->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $comuna->SortUrl($comuna->com_nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $comuna->com_nombre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($comuna->com_nombre->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($comuna->com_nombre->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$comuna_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($comuna->ExportAll && $comuna->Export <> "") {
	$comuna_list->StopRec = $comuna_list->TotalRecs;
} else {

	// Set the last record to display
	if ($comuna_list->TotalRecs > $comuna_list->StartRec + $comuna_list->DisplayRecs - 1)
		$comuna_list->StopRec = $comuna_list->StartRec + $comuna_list->DisplayRecs - 1;
	else
		$comuna_list->StopRec = $comuna_list->TotalRecs;
}
$comuna_list->RecCnt = $comuna_list->StartRec - 1;
if ($comuna_list->Recordset && !$comuna_list->Recordset->EOF) {
	$comuna_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $comuna_list->StartRec > 1)
		$comuna_list->Recordset->Move($comuna_list->StartRec - 1);
} elseif (!$comuna->AllowAddDeleteRow && $comuna_list->StopRec == 0) {
	$comuna_list->StopRec = $comuna->GridAddRowCount;
}

// Initialize aggregate
$comuna->RowType = EW_ROWTYPE_AGGREGATEINIT;
$comuna->ResetAttrs();
$comuna_list->RenderRow();
$comuna_list->RowCnt = 0;
while ($comuna_list->RecCnt < $comuna_list->StopRec) {
	$comuna_list->RecCnt++;
	if (intval($comuna_list->RecCnt) >= intval($comuna_list->StartRec)) {
		$comuna_list->RowCnt++;

		// Set up key count
		$comuna_list->KeyCount = $comuna_list->RowIndex;

		// Init row class and style
		$comuna->ResetAttrs();
		$comuna->CssClass = "";
		if ($comuna->CurrentAction == "gridadd") {
			$comuna_list->LoadDefaultValues(); // Load default values
		} else {
			$comuna_list->LoadRowValues($comuna_list->Recordset); // Load row values
		}
		$comuna->RowType = EW_ROWTYPE_VIEW; // Render view
		$comuna->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$comuna_list->RenderRow();

		// Render list options
		$comuna_list->RenderListOptions();
?>
	<tr<?php echo $comuna->RowAttributes() ?>>
<?php

// Render list options (body, left)
$comuna_list->ListOptions->Render("body", "left");
?>
	<?php if ($comuna->com_id->Visible) { // com_id ?>
		<td<?php echo $comuna->com_id->CellAttributes() ?>>
<div<?php echo $comuna->com_id->ViewAttributes() ?>><?php echo $comuna->com_id->ListViewValue() ?></div>
<a name="<?php echo $comuna_list->PageObjName . "_row_" . $comuna_list->RowCnt ?>" id="<?php echo $comuna_list->PageObjName . "_row_" . $comuna_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($comuna->reg_id->Visible) { // reg_id ?>
		<td<?php echo $comuna->reg_id->CellAttributes() ?>>
<div<?php echo $comuna->reg_id->ViewAttributes() ?>><?php echo $comuna->reg_id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($comuna->ciu_id->Visible) { // ciu_id ?>
		<td<?php echo $comuna->ciu_id->CellAttributes() ?>>
<div<?php echo $comuna->ciu_id->ViewAttributes() ?>><?php echo $comuna->ciu_id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($comuna->com_nombre->Visible) { // com_nombre ?>
		<td<?php echo $comuna->com_nombre->CellAttributes() ?>>
<div<?php echo $comuna->com_nombre->ViewAttributes() ?>><?php echo $comuna->com_nombre->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$comuna_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($comuna->CurrentAction <> "gridadd")
		$comuna_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($comuna_list->Recordset)
	$comuna_list->Recordset->Close();
?>
<?php if ($comuna_list->TotalRecs > 0) { ?>
<?php if ($comuna->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($comuna->CurrentAction <> "gridadd" && $comuna->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($comuna_list->Pager)) $comuna_list->Pager = new cPrevNextPager($comuna_list->StartRec, $comuna_list->DisplayRecs, $comuna_list->TotalRecs) ?>
<?php if ($comuna_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($comuna_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $comuna_list->PageUrl() ?>start=<?php echo $comuna_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($comuna_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $comuna_list->PageUrl() ?>start=<?php echo $comuna_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $comuna_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($comuna_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $comuna_list->PageUrl() ?>start=<?php echo $comuna_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($comuna_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $comuna_list->PageUrl() ?>start=<?php echo $comuna_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $comuna_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $comuna_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $comuna_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $comuna_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($comuna_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $comuna_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($comuna_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fcomunalist, '<?php echo $comuna_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($comuna->Export == "" && $comuna->CurrentAction == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--
ew_UpdateOpts([['x_ciu_id','x_reg_id',comuna_list.ar_x_ciu_id]]);

//-->
</script>
<?php } ?>
<?php
$comuna_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($comuna->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$comuna_list->Page_Terminate();
?>
<?php

//
// Page class
//
class ccomuna_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'comuna';

	// Page object name
	var $PageObjName = 'comuna_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $comuna;
		if ($comuna->UseTokenInUrl) $PageUrl .= "t=" . $comuna->TableVar . "&"; // Add page token
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
		global $objForm, $comuna;
		if ($comuna->UseTokenInUrl) {
			if ($objForm)
				return ($comuna->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($comuna->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccomuna_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (comuna)
		if (!isset($GLOBALS["comuna"])) {
			$GLOBALS["comuna"] = new ccomuna();
			$GLOBALS["Table"] =& $GLOBALS["comuna"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "comunaadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "comunadelete.php";
		$this->MultiUpdateUrl = "comunaupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'comuna', TRUE);

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
		global $comuna;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$comuna->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$comuna->Export = $_POST["exporttype"];
		} else {
			$comuna->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $comuna->Export; // Get export parameter, used in header
		$gsExportFile = $comuna->TableVar; // Get export file, used in header
		$Charset = (EW_CHARSET <> "") ? ";charset=" . EW_CHARSET : ""; // Charset used in header
		if ($comuna->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($comuna->Export == "word") {
			header('Content-Type: application/vnd.ms-word' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.doc');
		}
		if ($comuna->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$comuna->GridAddRowCount = $gridaddcnt;

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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $comuna;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Hide all options
			if ($comuna->Export <> "" ||
				$comuna->CurrentAction == "gridadd" ||
				$comuna->CurrentAction == "gridedit") {
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
			$comuna->Recordset_SearchValidated();

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
		if ($comuna->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $comuna->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$comuna->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			if ($sSrchAdvanced == "")
				$this->ResetAdvancedSearchParms();
			$comuna->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$comuna->setStartRecordNumber($this->StartRec);
			}
		} else {
			$this->SearchWhere = $comuna->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$comuna->setSessionWhere($sFilter);
		$comuna->CurrentFilter = "";

		// Export data only
		if (in_array($comuna->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($comuna->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security, $comuna;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $comuna->com_id, FALSE); // com_id
		$this->BuildSearchSql($sWhere, $comuna->reg_id, FALSE); // reg_id
		$this->BuildSearchSql($sWhere, $comuna->ciu_id, FALSE); // ciu_id
		$this->BuildSearchSql($sWhere, $comuna->com_nombre, FALSE); // com_nombre

		// Set up search parm
		if ($sWhere <> "") {
			$this->SetSearchParm($comuna->com_id); // com_id
			$this->SetSearchParm($comuna->reg_id); // reg_id
			$this->SetSearchParm($comuna->ciu_id); // ciu_id
			$this->SetSearchParm($comuna->com_nombre); // com_nombre
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
		global $comuna;
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$comuna->setAdvancedSearch("x_$FldParm", $FldVal);
		$comuna->setAdvancedSearch("z_$FldParm", $Fld->AdvancedSearch->SearchOperator); // @$_GET["z_$FldParm"]
		$comuna->setAdvancedSearch("v_$FldParm", $Fld->AdvancedSearch->SearchCondition); // @$_GET["v_$FldParm"]
		$comuna->setAdvancedSearch("y_$FldParm", $FldVal2);
		$comuna->setAdvancedSearch("w_$FldParm", $Fld->AdvancedSearch->SearchOperator2); // @$_GET["w_$FldParm"]
	}

	// Get search parameters
	function GetSearchParm(&$Fld) {
		global $comuna;
		$FldParm = substr($Fld->FldVar, 2);
		$Fld->AdvancedSearch->SearchValue = $comuna->GetAdvancedSearch("x_$FldParm");
		$Fld->AdvancedSearch->SearchOperator = $comuna->GetAdvancedSearch("z_$FldParm");
		$Fld->AdvancedSearch->SearchCondition = $comuna->GetAdvancedSearch("v_$FldParm");
		$Fld->AdvancedSearch->SearchValue2 = $comuna->GetAdvancedSearch("y_$FldParm");
		$Fld->AdvancedSearch->SearchOperator2 = $comuna->GetAdvancedSearch("w_$FldParm");
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
		global $comuna;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $comuna->com_nombre, $Keyword);
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
		global $Security, $comuna;
		$sSearchStr = "";
		$sSearchKeyword = $comuna->BasicSearchKeyword;
		$sSearchType = $comuna->BasicSearchType;
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
			$comuna->setSessionBasicSearchKeyword($sSearchKeyword);
			$comuna->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $comuna;

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$comuna->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $comuna;
		$comuna->setSessionBasicSearchKeyword("");
		$comuna->setSessionBasicSearchType("");
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		global $comuna;
		$comuna->setAdvancedSearch("x_com_id", "");
		$comuna->setAdvancedSearch("x_reg_id", "");
		$comuna->setAdvancedSearch("x_ciu_id", "");
		$comuna->setAdvancedSearch("x_com_nombre", "");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $comuna;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		if (@$_GET["x_com_id"] <> "") $bRestore = FALSE;
		if (@$_GET["x_reg_id"] <> "") $bRestore = FALSE;
		if (@$_GET["x_ciu_id"] <> "") $bRestore = FALSE;
		if (@$_GET["x_com_nombre"] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$comuna->BasicSearchKeyword = $comuna->getSessionBasicSearchKeyword();
			$comuna->BasicSearchType = $comuna->getSessionBasicSearchType();

			// Restore advanced search values
			$this->GetSearchParm($comuna->com_id);
			$this->GetSearchParm($comuna->reg_id);
			$this->GetSearchParm($comuna->ciu_id);
			$this->GetSearchParm($comuna->com_nombre);
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $comuna;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$comuna->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$comuna->CurrentOrderType = @$_GET["ordertype"];
			$comuna->UpdateSort($comuna->com_id); // com_id
			$comuna->UpdateSort($comuna->reg_id); // reg_id
			$comuna->UpdateSort($comuna->ciu_id); // ciu_id
			$comuna->UpdateSort($comuna->com_nombre); // com_nombre
			$comuna->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $comuna;
		$sOrderBy = $comuna->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($comuna->SqlOrderBy() <> "") {
				$sOrderBy = $comuna->SqlOrderBy();
				$comuna->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $comuna;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$comuna->setSessionOrderBy($sOrderBy);
				$comuna->com_id->setSort("");
				$comuna->reg_id->setSort("");
				$comuna->ciu_id->setSort("");
				$comuna->com_nombre->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$comuna->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $comuna;

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
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"comuna_list.SelectAllKey(this);\">";
		$item->MoveTo(0);

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $comuna, $objForm;
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
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($comuna->com_id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $comuna;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $comuna;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$comuna->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$comuna->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $comuna->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$comuna->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$comuna->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$comuna->setStartRecordNumber($this->StartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $comuna;
		$comuna->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$comuna->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm, $comuna;

		// Load search values
		// com_id

		$comuna->com_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_com_id"]);
		$comuna->com_id->AdvancedSearch->SearchOperator = @$_GET["z_com_id"];

		// reg_id
		$comuna->reg_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_reg_id"]);
		$comuna->reg_id->AdvancedSearch->SearchOperator = @$_GET["z_reg_id"];

		// ciu_id
		$comuna->ciu_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_ciu_id"]);
		$comuna->ciu_id->AdvancedSearch->SearchOperator = @$_GET["z_ciu_id"];

		// com_nombre
		$comuna->com_nombre->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_com_nombre"]);
		$comuna->com_nombre->AdvancedSearch->SearchOperator = @$_GET["z_com_nombre"];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $comuna;

		// Call Recordset Selecting event
		$comuna->Recordset_Selecting($comuna->CurrentFilter);

		// Load List page SQL
		$sSql = $comuna->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$comuna->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $comuna;
		$sFilter = $comuna->KeyFilter();

		// Call Row Selecting event
		$comuna->Row_Selecting($sFilter);

		// Load SQL based on filter
		$comuna->CurrentFilter = $sFilter;
		$sSql = $comuna->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$comuna->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $comuna;
		if (!$rs || $rs->EOF) return;
		$comuna->com_id->setDbValue($rs->fields('com_id'));
		$comuna->reg_id->setDbValue($rs->fields('reg_id'));
		$comuna->ciu_id->setDbValue($rs->fields('ciu_id'));
		$comuna->com_nombre->setDbValue($rs->fields('com_nombre'));
	}

	// Load old record
	function LoadOldRecord() {
		global $comuna;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($comuna->getKey("com_id")) <> "")
			$comuna->com_id->CurrentValue = $comuna->getKey("com_id"); // com_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$comuna->CurrentFilter = $comuna->KeyFilter();
			$sSql = $comuna->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $comuna;

		// Initialize URLs
		$this->ViewUrl = $comuna->ViewUrl();
		$this->EditUrl = $comuna->EditUrl();
		$this->InlineEditUrl = $comuna->InlineEditUrl();
		$this->CopyUrl = $comuna->CopyUrl();
		$this->InlineCopyUrl = $comuna->InlineCopyUrl();
		$this->DeleteUrl = $comuna->DeleteUrl();

		// Call Row_Rendering event
		$comuna->Row_Rendering();

		// Common render codes for all row types
		// com_id
		// reg_id
		// ciu_id
		// com_nombre

		if ($comuna->RowType == EW_ROWTYPE_VIEW) { // View row

			// com_id
			$comuna->com_id->ViewValue = $comuna->com_id->CurrentValue;
			$comuna->com_id->ViewCustomAttributes = "";

			// reg_id
			if (strval($comuna->reg_id->CurrentValue) <> "") {
				$sFilterWrk = "`reg_id` = " . ew_AdjustSql($comuna->reg_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `reg_num`, `reg_nombre` FROM `region`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `reg_num` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$comuna->reg_id->ViewValue = $rswrk->fields('reg_num');
					$comuna->reg_id->ViewValue .= ew_ValueSeparator(0,1,$comuna->reg_id) . $rswrk->fields('reg_nombre');
					$rswrk->Close();
				} else {
					$comuna->reg_id->ViewValue = $comuna->reg_id->CurrentValue;
				}
			} else {
				$comuna->reg_id->ViewValue = NULL;
			}
			$comuna->reg_id->ViewCustomAttributes = "";

			// ciu_id
			if (strval($comuna->ciu_id->CurrentValue) <> "") {
				$sFilterWrk = "`ciu_id` = " . ew_AdjustSql($comuna->ciu_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `ciu_nombre` FROM `ciudad`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `ciu_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$comuna->ciu_id->ViewValue = $rswrk->fields('ciu_nombre');
					$rswrk->Close();
				} else {
					$comuna->ciu_id->ViewValue = $comuna->ciu_id->CurrentValue;
				}
			} else {
				$comuna->ciu_id->ViewValue = NULL;
			}
			$comuna->ciu_id->ViewCustomAttributes = "";

			// com_nombre
			$comuna->com_nombre->ViewValue = $comuna->com_nombre->CurrentValue;
			$comuna->com_nombre->ViewCustomAttributes = "";

			// com_id
			$comuna->com_id->LinkCustomAttributes = "";
			$comuna->com_id->HrefValue = "";
			$comuna->com_id->TooltipValue = "";

			// reg_id
			$comuna->reg_id->LinkCustomAttributes = "";
			$comuna->reg_id->HrefValue = "";
			$comuna->reg_id->TooltipValue = "";

			// ciu_id
			$comuna->ciu_id->LinkCustomAttributes = "";
			$comuna->ciu_id->HrefValue = "";
			$comuna->ciu_id->TooltipValue = "";

			// com_nombre
			$comuna->com_nombre->LinkCustomAttributes = "";
			$comuna->com_nombre->HrefValue = "";
			$comuna->com_nombre->TooltipValue = "";
		} elseif ($comuna->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// com_id
			$comuna->com_id->EditCustomAttributes = "";
			$comuna->com_id->EditValue = ew_HtmlEncode($comuna->com_id->AdvancedSearch->SearchValue);

			// reg_id
			$comuna->reg_id->EditCustomAttributes = "";
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `reg_id`, `reg_num` AS `DispFld`, `reg_nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld` FROM `region`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `reg_num` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$comuna->reg_id->EditValue = $arwrk;

			// ciu_id
			$comuna->ciu_id->EditCustomAttributes = "";
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `ciu_id`, `ciu_nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `reg_id` AS `SelectFilterFld` FROM `ciudad`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `ciu_nombre` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$comuna->ciu_id->EditValue = $arwrk;

			// com_nombre
			$comuna->com_nombre->EditCustomAttributes = "";
			$comuna->com_nombre->EditValue = ew_HtmlEncode($comuna->com_nombre->AdvancedSearch->SearchValue);
		}
		if ($comuna->RowType == EW_ROWTYPE_ADD ||
			$comuna->RowType == EW_ROWTYPE_EDIT ||
			$comuna->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$comuna->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($comuna->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$comuna->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $comuna;

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
		global $comuna;
		$comuna->com_id->AdvancedSearch->SearchValue = $comuna->getAdvancedSearch("x_com_id");
		$comuna->reg_id->AdvancedSearch->SearchValue = $comuna->getAdvancedSearch("x_reg_id");
		$comuna->ciu_id->AdvancedSearch->SearchValue = $comuna->getAdvancedSearch("x_ciu_id");
		$comuna->com_nombre->AdvancedSearch->SearchValue = $comuna->getAdvancedSearch("x_com_nombre");
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language, $comuna;

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
		$item->Body = "<a name=\"emf_comuna\" id=\"emf_comuna\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_comuna',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcomunalist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($comuna->Export <> "" ||
			$comuna->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $comuna;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $comuna->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($comuna->ExportAll) {
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
		if ($comuna->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($comuna, "h");
		}
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		if ($comuna->Export == "xml") {
			$comuna->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$comuna->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
			$sFooter = $this->PageFooter;
			$this->Page_DataRendered($sFooter);
			$ExportDoc->Text .= $sFooter;
		}

		// Close recordset
		$rs->Close();

		// Export header and footer
		if ($comuna->Export <> "xml") {
			$ExportDoc->ExportHeaderAndFooter();
		}

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($comuna->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($comuna->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($comuna->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($comuna->ExportReturnUrl());
		} elseif ($comuna->Export == "pdf") {
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
