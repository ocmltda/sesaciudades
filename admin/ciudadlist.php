<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "ciudadinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$ciudad_list = new cciudad_list();
$Page =& $ciudad_list;

// Page init
$ciudad_list->Page_Init();

// Page main
$ciudad_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($ciudad->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var ciudad_list = new ew_Page("ciudad_list");

// page properties
ciudad_list.PageID = "list"; // page ID
ciudad_list.FormID = "fciudadlist"; // form ID
var EW_PAGE_ID = ciudad_list.PageID; // for backward compatibility

// extend page with validate function for search
ciudad_list.ValidateSearch = function(fobj) {
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
ciudad_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
ciudad_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
ciudad_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ciudad_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($ciudad->Export == "") || (EW_EXPORT_MASTER_RECORD && $ciudad->Export == "print")) { ?>
<?php } ?>
<?php $ciudad_list->ShowPageHeader(); ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$ciudad_list->TotalRecs = $ciudad->SelectRecordCount();
	} else {
		if ($ciudad_list->Recordset = $ciudad_list->LoadRecordset())
			$ciudad_list->TotalRecs = $ciudad_list->Recordset->RecordCount();
	}
	$ciudad_list->StartRec = 1;
	if ($ciudad_list->DisplayRecs <= 0 || ($ciudad->Export <> "" && $ciudad->ExportAll)) // Display all records
		$ciudad_list->DisplayRecs = $ciudad_list->TotalRecs;
	if (!($ciudad->Export <> "" && $ciudad->ExportAll))
		$ciudad_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$ciudad_list->Recordset = $ciudad_list->LoadRecordset($ciudad_list->StartRec-1, $ciudad_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ciudad->TableCaption() ?>
&nbsp;&nbsp;<?php $ciudad_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($ciudad->Export == "" && $ciudad->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(ciudad_list);" style="text-decoration: none;"><img id="ciudad_list_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="ciudad_list_SearchPanel">
<form name="fciudadlistsrch" id="fciudadlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return ciudad_list.ValidateSearch(this);">
<input type="hidden" id="t" name="t" value="ciudad">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$ciudad_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$ciudad->RowType = EW_ROWTYPE_SEARCH;

// Render row
$ciudad->ResetAttrs();
$ciudad_list->RenderRow();
?>
<div id="xsr_1" class="ewCssTableRow">
	<span id="xsc_reg_id" class="ewCssTableCell">
		<span class="ewSearchCaption"><?php echo $ciudad->reg_id->FldCaption() ?></span>
		<span class="ewSearchOprCell"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_reg_id" id="z_reg_id" value="="></span>
		<span class="ewSearchField">
<select id="x_reg_id" name="x_reg_id"<?php echo $ciudad->reg_id->EditAttributes() ?>>
<?php
if (is_array($ciudad->reg_id->EditValue)) {
	$arwrk = $ciudad->reg_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ciudad->reg_id->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,1,$ciudad->reg_id) ?><?php echo $arwrk[$rowcntwrk][2] ?>
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
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($ciudad->getSessionBasicSearchKeyword()) ?>">
	<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $ciudad_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_3" class="ewCssTableRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($ciudad->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($ciudad->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($ciudad->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
$ciudad_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($ciudad->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($ciudad->CurrentAction <> "gridadd" && $ciudad->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($ciudad_list->Pager)) $ciudad_list->Pager = new cPrevNextPager($ciudad_list->StartRec, $ciudad_list->DisplayRecs, $ciudad_list->TotalRecs) ?>
<?php if ($ciudad_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($ciudad_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $ciudad_list->PageUrl() ?>start=<?php echo $ciudad_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($ciudad_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $ciudad_list->PageUrl() ?>start=<?php echo $ciudad_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ciudad_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($ciudad_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $ciudad_list->PageUrl() ?>start=<?php echo $ciudad_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($ciudad_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $ciudad_list->PageUrl() ?>start=<?php echo $ciudad_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ciudad_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ciudad_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ciudad_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ciudad_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($ciudad_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $ciudad_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($ciudad_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fciudadlist, '<?php echo $ciudad_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fciudadlist" id="fciudadlist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="ciudad">
<div id="gmp_ciudad" class="ewGridMiddlePanel">
<?php if ($ciudad_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $ciudad->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$ciudad_list->RenderListOptions();

// Render list options (header, left)
$ciudad_list->ListOptions->Render("header", "left");
?>
<?php if ($ciudad->ciu_id->Visible) { // ciu_id ?>
	<?php if ($ciudad->SortUrl($ciudad->ciu_id) == "") { ?>
		<td><?php echo $ciudad->ciu_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ciudad->SortUrl($ciudad->ciu_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $ciudad->ciu_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($ciudad->ciu_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ciudad->ciu_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ciudad->reg_id->Visible) { // reg_id ?>
	<?php if ($ciudad->SortUrl($ciudad->reg_id) == "") { ?>
		<td><?php echo $ciudad->reg_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ciudad->SortUrl($ciudad->reg_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $ciudad->reg_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($ciudad->reg_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ciudad->reg_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ciudad->ciu_nombre->Visible) { // ciu_nombre ?>
	<?php if ($ciudad->SortUrl($ciudad->ciu_nombre) == "") { ?>
		<td><?php echo $ciudad->ciu_nombre->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ciudad->SortUrl($ciudad->ciu_nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $ciudad->ciu_nombre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($ciudad->ciu_nombre->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ciudad->ciu_nombre->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$ciudad_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($ciudad->ExportAll && $ciudad->Export <> "") {
	$ciudad_list->StopRec = $ciudad_list->TotalRecs;
} else {

	// Set the last record to display
	if ($ciudad_list->TotalRecs > $ciudad_list->StartRec + $ciudad_list->DisplayRecs - 1)
		$ciudad_list->StopRec = $ciudad_list->StartRec + $ciudad_list->DisplayRecs - 1;
	else
		$ciudad_list->StopRec = $ciudad_list->TotalRecs;
}
$ciudad_list->RecCnt = $ciudad_list->StartRec - 1;
if ($ciudad_list->Recordset && !$ciudad_list->Recordset->EOF) {
	$ciudad_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $ciudad_list->StartRec > 1)
		$ciudad_list->Recordset->Move($ciudad_list->StartRec - 1);
} elseif (!$ciudad->AllowAddDeleteRow && $ciudad_list->StopRec == 0) {
	$ciudad_list->StopRec = $ciudad->GridAddRowCount;
}

// Initialize aggregate
$ciudad->RowType = EW_ROWTYPE_AGGREGATEINIT;
$ciudad->ResetAttrs();
$ciudad_list->RenderRow();
$ciudad_list->RowCnt = 0;
while ($ciudad_list->RecCnt < $ciudad_list->StopRec) {
	$ciudad_list->RecCnt++;
	if (intval($ciudad_list->RecCnt) >= intval($ciudad_list->StartRec)) {
		$ciudad_list->RowCnt++;

		// Set up key count
		$ciudad_list->KeyCount = $ciudad_list->RowIndex;

		// Init row class and style
		$ciudad->ResetAttrs();
		$ciudad->CssClass = "";
		if ($ciudad->CurrentAction == "gridadd") {
			$ciudad_list->LoadDefaultValues(); // Load default values
		} else {
			$ciudad_list->LoadRowValues($ciudad_list->Recordset); // Load row values
		}
		$ciudad->RowType = EW_ROWTYPE_VIEW; // Render view
		$ciudad->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$ciudad_list->RenderRow();

		// Render list options
		$ciudad_list->RenderListOptions();
?>
	<tr<?php echo $ciudad->RowAttributes() ?>>
<?php

// Render list options (body, left)
$ciudad_list->ListOptions->Render("body", "left");
?>
	<?php if ($ciudad->ciu_id->Visible) { // ciu_id ?>
		<td<?php echo $ciudad->ciu_id->CellAttributes() ?>>
<div<?php echo $ciudad->ciu_id->ViewAttributes() ?>><?php echo $ciudad->ciu_id->ListViewValue() ?></div>
<a name="<?php echo $ciudad_list->PageObjName . "_row_" . $ciudad_list->RowCnt ?>" id="<?php echo $ciudad_list->PageObjName . "_row_" . $ciudad_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($ciudad->reg_id->Visible) { // reg_id ?>
		<td<?php echo $ciudad->reg_id->CellAttributes() ?>>
<div<?php echo $ciudad->reg_id->ViewAttributes() ?>><?php echo $ciudad->reg_id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($ciudad->ciu_nombre->Visible) { // ciu_nombre ?>
		<td<?php echo $ciudad->ciu_nombre->CellAttributes() ?>>
<div<?php echo $ciudad->ciu_nombre->ViewAttributes() ?>><?php echo $ciudad->ciu_nombre->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$ciudad_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($ciudad->CurrentAction <> "gridadd")
		$ciudad_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($ciudad_list->Recordset)
	$ciudad_list->Recordset->Close();
?>
<?php if ($ciudad_list->TotalRecs > 0) { ?>
<?php if ($ciudad->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($ciudad->CurrentAction <> "gridadd" && $ciudad->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($ciudad_list->Pager)) $ciudad_list->Pager = new cPrevNextPager($ciudad_list->StartRec, $ciudad_list->DisplayRecs, $ciudad_list->TotalRecs) ?>
<?php if ($ciudad_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($ciudad_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $ciudad_list->PageUrl() ?>start=<?php echo $ciudad_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($ciudad_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $ciudad_list->PageUrl() ?>start=<?php echo $ciudad_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ciudad_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($ciudad_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $ciudad_list->PageUrl() ?>start=<?php echo $ciudad_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($ciudad_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $ciudad_list->PageUrl() ?>start=<?php echo $ciudad_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ciudad_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ciudad_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ciudad_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ciudad_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($ciudad_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $ciudad_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($ciudad_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fciudadlist, '<?php echo $ciudad_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($ciudad->Export == "" && $ciudad->CurrentAction == "") { ?>
<?php } ?>
<?php
$ciudad_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($ciudad->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ciudad_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cciudad_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'ciudad';

	// Page object name
	var $PageObjName = 'ciudad_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $ciudad;
		if ($ciudad->UseTokenInUrl) $PageUrl .= "t=" . $ciudad->TableVar . "&"; // Add page token
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
		global $objForm, $ciudad;
		if ($ciudad->UseTokenInUrl) {
			if ($objForm)
				return ($ciudad->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($ciudad->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cciudad_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (ciudad)
		if (!isset($GLOBALS["ciudad"])) {
			$GLOBALS["ciudad"] = new cciudad();
			$GLOBALS["Table"] =& $GLOBALS["ciudad"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "ciudadadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "ciudaddelete.php";
		$this->MultiUpdateUrl = "ciudadupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ciudad', TRUE);

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
		global $ciudad;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$ciudad->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$ciudad->Export = $_POST["exporttype"];
		} else {
			$ciudad->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $ciudad->Export; // Get export parameter, used in header
		$gsExportFile = $ciudad->TableVar; // Get export file, used in header
		$Charset = (EW_CHARSET <> "") ? ";charset=" . EW_CHARSET : ""; // Charset used in header
		if ($ciudad->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($ciudad->Export == "word") {
			header('Content-Type: application/vnd.ms-word' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.doc');
		}
		if ($ciudad->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$ciudad->GridAddRowCount = $gridaddcnt;

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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $ciudad;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Hide all options
			if ($ciudad->Export <> "" ||
				$ciudad->CurrentAction == "gridadd" ||
				$ciudad->CurrentAction == "gridedit") {
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
			$ciudad->Recordset_SearchValidated();

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
		if ($ciudad->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $ciudad->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$ciudad->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			if ($sSrchAdvanced == "")
				$this->ResetAdvancedSearchParms();
			$ciudad->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$ciudad->setStartRecordNumber($this->StartRec);
			}
		} else {
			$this->SearchWhere = $ciudad->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$ciudad->setSessionWhere($sFilter);
		$ciudad->CurrentFilter = "";

		// Export data only
		if (in_array($ciudad->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($ciudad->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security, $ciudad;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $ciudad->ciu_id, FALSE); // ciu_id
		$this->BuildSearchSql($sWhere, $ciudad->reg_id, FALSE); // reg_id
		$this->BuildSearchSql($sWhere, $ciudad->ciu_nombre, FALSE); // ciu_nombre

		// Set up search parm
		if ($sWhere <> "") {
			$this->SetSearchParm($ciudad->ciu_id); // ciu_id
			$this->SetSearchParm($ciudad->reg_id); // reg_id
			$this->SetSearchParm($ciudad->ciu_nombre); // ciu_nombre
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
		global $ciudad;
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$ciudad->setAdvancedSearch("x_$FldParm", $FldVal);
		$ciudad->setAdvancedSearch("z_$FldParm", $Fld->AdvancedSearch->SearchOperator); // @$_GET["z_$FldParm"]
		$ciudad->setAdvancedSearch("v_$FldParm", $Fld->AdvancedSearch->SearchCondition); // @$_GET["v_$FldParm"]
		$ciudad->setAdvancedSearch("y_$FldParm", $FldVal2);
		$ciudad->setAdvancedSearch("w_$FldParm", $Fld->AdvancedSearch->SearchOperator2); // @$_GET["w_$FldParm"]
	}

	// Get search parameters
	function GetSearchParm(&$Fld) {
		global $ciudad;
		$FldParm = substr($Fld->FldVar, 2);
		$Fld->AdvancedSearch->SearchValue = $ciudad->GetAdvancedSearch("x_$FldParm");
		$Fld->AdvancedSearch->SearchOperator = $ciudad->GetAdvancedSearch("z_$FldParm");
		$Fld->AdvancedSearch->SearchCondition = $ciudad->GetAdvancedSearch("v_$FldParm");
		$Fld->AdvancedSearch->SearchValue2 = $ciudad->GetAdvancedSearch("y_$FldParm");
		$Fld->AdvancedSearch->SearchOperator2 = $ciudad->GetAdvancedSearch("w_$FldParm");
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
		global $ciudad;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $ciudad->ciu_nombre, $Keyword);
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
		global $Security, $ciudad;
		$sSearchStr = "";
		$sSearchKeyword = $ciudad->BasicSearchKeyword;
		$sSearchType = $ciudad->BasicSearchType;
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
			$ciudad->setSessionBasicSearchKeyword($sSearchKeyword);
			$ciudad->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $ciudad;

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$ciudad->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $ciudad;
		$ciudad->setSessionBasicSearchKeyword("");
		$ciudad->setSessionBasicSearchType("");
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		global $ciudad;
		$ciudad->setAdvancedSearch("x_ciu_id", "");
		$ciudad->setAdvancedSearch("x_reg_id", "");
		$ciudad->setAdvancedSearch("x_ciu_nombre", "");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $ciudad;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		if (@$_GET["x_ciu_id"] <> "") $bRestore = FALSE;
		if (@$_GET["x_reg_id"] <> "") $bRestore = FALSE;
		if (@$_GET["x_ciu_nombre"] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$ciudad->BasicSearchKeyword = $ciudad->getSessionBasicSearchKeyword();
			$ciudad->BasicSearchType = $ciudad->getSessionBasicSearchType();

			// Restore advanced search values
			$this->GetSearchParm($ciudad->ciu_id);
			$this->GetSearchParm($ciudad->reg_id);
			$this->GetSearchParm($ciudad->ciu_nombre);
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $ciudad;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$ciudad->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$ciudad->CurrentOrderType = @$_GET["ordertype"];
			$ciudad->UpdateSort($ciudad->ciu_id); // ciu_id
			$ciudad->UpdateSort($ciudad->reg_id); // reg_id
			$ciudad->UpdateSort($ciudad->ciu_nombre); // ciu_nombre
			$ciudad->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $ciudad;
		$sOrderBy = $ciudad->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($ciudad->SqlOrderBy() <> "") {
				$sOrderBy = $ciudad->SqlOrderBy();
				$ciudad->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $ciudad;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$ciudad->setSessionOrderBy($sOrderBy);
				$ciudad->ciu_id->setSort("");
				$ciudad->reg_id->setSort("");
				$ciudad->ciu_nombre->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$ciudad->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $ciudad;

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
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"ciudad_list.SelectAllKey(this);\">";
		$item->MoveTo(0);

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $ciudad, $objForm;
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
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($ciudad->ciu_id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $ciudad;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $ciudad;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$ciudad->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$ciudad->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $ciudad->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$ciudad->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$ciudad->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$ciudad->setStartRecordNumber($this->StartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $ciudad;
		$ciudad->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$ciudad->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm, $ciudad;

		// Load search values
		// ciu_id

		$ciudad->ciu_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_ciu_id"]);
		$ciudad->ciu_id->AdvancedSearch->SearchOperator = @$_GET["z_ciu_id"];

		// reg_id
		$ciudad->reg_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_reg_id"]);
		$ciudad->reg_id->AdvancedSearch->SearchOperator = @$_GET["z_reg_id"];

		// ciu_nombre
		$ciudad->ciu_nombre->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_ciu_nombre"]);
		$ciudad->ciu_nombre->AdvancedSearch->SearchOperator = @$_GET["z_ciu_nombre"];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $ciudad;

		// Call Recordset Selecting event
		$ciudad->Recordset_Selecting($ciudad->CurrentFilter);

		// Load List page SQL
		$sSql = $ciudad->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$ciudad->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $ciudad;
		$sFilter = $ciudad->KeyFilter();

		// Call Row Selecting event
		$ciudad->Row_Selecting($sFilter);

		// Load SQL based on filter
		$ciudad->CurrentFilter = $sFilter;
		$sSql = $ciudad->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$ciudad->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $ciudad;
		if (!$rs || $rs->EOF) return;
		$ciudad->ciu_id->setDbValue($rs->fields('ciu_id'));
		$ciudad->reg_id->setDbValue($rs->fields('reg_id'));
		$ciudad->ciu_nombre->setDbValue($rs->fields('ciu_nombre'));
	}

	// Load old record
	function LoadOldRecord() {
		global $ciudad;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($ciudad->getKey("ciu_id")) <> "")
			$ciudad->ciu_id->CurrentValue = $ciudad->getKey("ciu_id"); // ciu_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$ciudad->CurrentFilter = $ciudad->KeyFilter();
			$sSql = $ciudad->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $ciudad;

		// Initialize URLs
		$this->ViewUrl = $ciudad->ViewUrl();
		$this->EditUrl = $ciudad->EditUrl();
		$this->InlineEditUrl = $ciudad->InlineEditUrl();
		$this->CopyUrl = $ciudad->CopyUrl();
		$this->InlineCopyUrl = $ciudad->InlineCopyUrl();
		$this->DeleteUrl = $ciudad->DeleteUrl();

		// Call Row_Rendering event
		$ciudad->Row_Rendering();

		// Common render codes for all row types
		// ciu_id
		// reg_id
		// ciu_nombre

		if ($ciudad->RowType == EW_ROWTYPE_VIEW) { // View row

			// ciu_id
			$ciudad->ciu_id->ViewValue = $ciudad->ciu_id->CurrentValue;
			$ciudad->ciu_id->ViewCustomAttributes = "";

			// reg_id
			if (strval($ciudad->reg_id->CurrentValue) <> "") {
				$sFilterWrk = "`reg_id` = " . ew_AdjustSql($ciudad->reg_id->CurrentValue) . "";
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
					$ciudad->reg_id->ViewValue = $rswrk->fields('reg_num');
					$ciudad->reg_id->ViewValue .= ew_ValueSeparator(0,1,$ciudad->reg_id) . $rswrk->fields('reg_nombre');
					$rswrk->Close();
				} else {
					$ciudad->reg_id->ViewValue = $ciudad->reg_id->CurrentValue;
				}
			} else {
				$ciudad->reg_id->ViewValue = NULL;
			}
			$ciudad->reg_id->ViewCustomAttributes = "";

			// ciu_nombre
			$ciudad->ciu_nombre->ViewValue = $ciudad->ciu_nombre->CurrentValue;
			$ciudad->ciu_nombre->ViewCustomAttributes = "";

			// ciu_id
			$ciudad->ciu_id->LinkCustomAttributes = "";
			$ciudad->ciu_id->HrefValue = "";
			$ciudad->ciu_id->TooltipValue = "";

			// reg_id
			$ciudad->reg_id->LinkCustomAttributes = "";
			$ciudad->reg_id->HrefValue = "";
			$ciudad->reg_id->TooltipValue = "";

			// ciu_nombre
			$ciudad->ciu_nombre->LinkCustomAttributes = "";
			$ciudad->ciu_nombre->HrefValue = "";
			$ciudad->ciu_nombre->TooltipValue = "";
		} elseif ($ciudad->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// ciu_id
			$ciudad->ciu_id->EditCustomAttributes = "";
			$ciudad->ciu_id->EditValue = ew_HtmlEncode($ciudad->ciu_id->AdvancedSearch->SearchValue);

			// reg_id
			$ciudad->reg_id->EditCustomAttributes = "";
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
			$ciudad->reg_id->EditValue = $arwrk;

			// ciu_nombre
			$ciudad->ciu_nombre->EditCustomAttributes = "";
			$ciudad->ciu_nombre->EditValue = ew_HtmlEncode($ciudad->ciu_nombre->AdvancedSearch->SearchValue);
		}
		if ($ciudad->RowType == EW_ROWTYPE_ADD ||
			$ciudad->RowType == EW_ROWTYPE_EDIT ||
			$ciudad->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$ciudad->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($ciudad->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$ciudad->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $ciudad;

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
		global $ciudad;
		$ciudad->ciu_id->AdvancedSearch->SearchValue = $ciudad->getAdvancedSearch("x_ciu_id");
		$ciudad->reg_id->AdvancedSearch->SearchValue = $ciudad->getAdvancedSearch("x_reg_id");
		$ciudad->ciu_nombre->AdvancedSearch->SearchValue = $ciudad->getAdvancedSearch("x_ciu_nombre");
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language, $ciudad;

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
		$item->Body = "<a name=\"emf_ciudad\" id=\"emf_ciudad\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_ciudad',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fciudadlist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($ciudad->Export <> "" ||
			$ciudad->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $ciudad;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $ciudad->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($ciudad->ExportAll) {
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
		if ($ciudad->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($ciudad, "h");
		}
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		if ($ciudad->Export == "xml") {
			$ciudad->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$ciudad->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
			$sFooter = $this->PageFooter;
			$this->Page_DataRendered($sFooter);
			$ExportDoc->Text .= $sFooter;
		}

		// Close recordset
		$rs->Close();

		// Export header and footer
		if ($ciudad->Export <> "xml") {
			$ExportDoc->ExportHeaderAndFooter();
		}

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($ciudad->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($ciudad->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($ciudad->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($ciudad->ExportReturnUrl());
		} elseif ($ciudad->Export == "pdf") {
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
