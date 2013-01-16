<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "regioninfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$region_list = new cregion_list();
$Page =& $region_list;

// Page init
$region_list->Page_Init();

// Page main
$region_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($region->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var region_list = new ew_Page("region_list");

// page properties
region_list.PageID = "list"; // page ID
region_list.FormID = "fregionlist"; // form ID
var EW_PAGE_ID = region_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
region_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
region_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
region_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
region_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($region->Export == "") || (EW_EXPORT_MASTER_RECORD && $region->Export == "print")) { ?>
<?php } ?>
<?php $region_list->ShowPageHeader(); ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$region_list->TotalRecs = $region->SelectRecordCount();
	} else {
		if ($region_list->Recordset = $region_list->LoadRecordset())
			$region_list->TotalRecs = $region_list->Recordset->RecordCount();
	}
	$region_list->StartRec = 1;
	if ($region_list->DisplayRecs <= 0 || ($region->Export <> "" && $region->ExportAll)) // Display all records
		$region_list->DisplayRecs = $region_list->TotalRecs;
	if (!($region->Export <> "" && $region->ExportAll))
		$region_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$region_list->Recordset = $region_list->LoadRecordset($region_list->StartRec-1, $region_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $region->TableCaption() ?>
&nbsp;&nbsp;<?php $region_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($region->Export == "" && $region->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(region_list);" style="text-decoration: none;"><img id="region_list_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="region_list_SearchPanel">
<form name="fregionlistsrch" id="fregionlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="region">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewCssTableRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($region->getSessionBasicSearchKeyword()) ?>">
	<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $region_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewCssTableRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($region->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($region->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($region->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
$region_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($region->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($region->CurrentAction <> "gridadd" && $region->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($region_list->Pager)) $region_list->Pager = new cPrevNextPager($region_list->StartRec, $region_list->DisplayRecs, $region_list->TotalRecs) ?>
<?php if ($region_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($region_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $region_list->PageUrl() ?>start=<?php echo $region_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($region_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $region_list->PageUrl() ?>start=<?php echo $region_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $region_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($region_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $region_list->PageUrl() ?>start=<?php echo $region_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($region_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $region_list->PageUrl() ?>start=<?php echo $region_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $region_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $region_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $region_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $region_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($region_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $region_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($region_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fregionlist, '<?php echo $region_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fregionlist" id="fregionlist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="region">
<div id="gmp_region" class="ewGridMiddlePanel">
<?php if ($region_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $region->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$region_list->RenderListOptions();

// Render list options (header, left)
$region_list->ListOptions->Render("header", "left");
?>
<?php if ($region->reg_id->Visible) { // reg_id ?>
	<?php if ($region->SortUrl($region->reg_id) == "") { ?>
		<td><?php echo $region->reg_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $region->SortUrl($region->reg_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $region->reg_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($region->reg_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($region->reg_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($region->reg_num->Visible) { // reg_num ?>
	<?php if ($region->SortUrl($region->reg_num) == "") { ?>
		<td><?php echo $region->reg_num->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $region->SortUrl($region->reg_num) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $region->reg_num->FldCaption() ?></td><td style="width: 10px;"><?php if ($region->reg_num->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($region->reg_num->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($region->reg_cod->Visible) { // reg_cod ?>
	<?php if ($region->SortUrl($region->reg_cod) == "") { ?>
		<td><?php echo $region->reg_cod->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $region->SortUrl($region->reg_cod) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $region->reg_cod->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($region->reg_cod->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($region->reg_cod->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($region->reg_nombre->Visible) { // reg_nombre ?>
	<?php if ($region->SortUrl($region->reg_nombre) == "") { ?>
		<td><?php echo $region->reg_nombre->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $region->SortUrl($region->reg_nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $region->reg_nombre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($region->reg_nombre->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($region->reg_nombre->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($region->reg_alias->Visible) { // reg_alias ?>
	<?php if ($region->SortUrl($region->reg_alias) == "") { ?>
		<td><?php echo $region->reg_alias->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $region->SortUrl($region->reg_alias) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $region->reg_alias->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($region->reg_alias->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($region->reg_alias->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($region->reg_ordenmapa->Visible) { // reg_ordenmapa ?>
	<?php if ($region->SortUrl($region->reg_ordenmapa) == "") { ?>
		<td><?php echo $region->reg_ordenmapa->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $region->SortUrl($region->reg_ordenmapa) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $region->reg_ordenmapa->FldCaption() ?></td><td style="width: 10px;"><?php if ($region->reg_ordenmapa->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($region->reg_ordenmapa->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$region_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($region->ExportAll && $region->Export <> "") {
	$region_list->StopRec = $region_list->TotalRecs;
} else {

	// Set the last record to display
	if ($region_list->TotalRecs > $region_list->StartRec + $region_list->DisplayRecs - 1)
		$region_list->StopRec = $region_list->StartRec + $region_list->DisplayRecs - 1;
	else
		$region_list->StopRec = $region_list->TotalRecs;
}
$region_list->RecCnt = $region_list->StartRec - 1;
if ($region_list->Recordset && !$region_list->Recordset->EOF) {
	$region_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $region_list->StartRec > 1)
		$region_list->Recordset->Move($region_list->StartRec - 1);
} elseif (!$region->AllowAddDeleteRow && $region_list->StopRec == 0) {
	$region_list->StopRec = $region->GridAddRowCount;
}

// Initialize aggregate
$region->RowType = EW_ROWTYPE_AGGREGATEINIT;
$region->ResetAttrs();
$region_list->RenderRow();
$region_list->RowCnt = 0;
while ($region_list->RecCnt < $region_list->StopRec) {
	$region_list->RecCnt++;
	if (intval($region_list->RecCnt) >= intval($region_list->StartRec)) {
		$region_list->RowCnt++;

		// Set up key count
		$region_list->KeyCount = $region_list->RowIndex;

		// Init row class and style
		$region->ResetAttrs();
		$region->CssClass = "";
		if ($region->CurrentAction == "gridadd") {
			$region_list->LoadDefaultValues(); // Load default values
		} else {
			$region_list->LoadRowValues($region_list->Recordset); // Load row values
		}
		$region->RowType = EW_ROWTYPE_VIEW; // Render view
		$region->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$region_list->RenderRow();

		// Render list options
		$region_list->RenderListOptions();
?>
	<tr<?php echo $region->RowAttributes() ?>>
<?php

// Render list options (body, left)
$region_list->ListOptions->Render("body", "left");
?>
	<?php if ($region->reg_id->Visible) { // reg_id ?>
		<td<?php echo $region->reg_id->CellAttributes() ?>>
<div<?php echo $region->reg_id->ViewAttributes() ?>><?php echo $region->reg_id->ListViewValue() ?></div>
<a name="<?php echo $region_list->PageObjName . "_row_" . $region_list->RowCnt ?>" id="<?php echo $region_list->PageObjName . "_row_" . $region_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($region->reg_num->Visible) { // reg_num ?>
		<td<?php echo $region->reg_num->CellAttributes() ?>>
<div<?php echo $region->reg_num->ViewAttributes() ?>><?php echo $region->reg_num->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($region->reg_cod->Visible) { // reg_cod ?>
		<td<?php echo $region->reg_cod->CellAttributes() ?>>
<div<?php echo $region->reg_cod->ViewAttributes() ?>><?php echo $region->reg_cod->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($region->reg_nombre->Visible) { // reg_nombre ?>
		<td<?php echo $region->reg_nombre->CellAttributes() ?>>
<div<?php echo $region->reg_nombre->ViewAttributes() ?>><?php echo $region->reg_nombre->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($region->reg_alias->Visible) { // reg_alias ?>
		<td<?php echo $region->reg_alias->CellAttributes() ?>>
<div<?php echo $region->reg_alias->ViewAttributes() ?>><?php echo $region->reg_alias->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($region->reg_ordenmapa->Visible) { // reg_ordenmapa ?>
		<td<?php echo $region->reg_ordenmapa->CellAttributes() ?>>
<div<?php echo $region->reg_ordenmapa->ViewAttributes() ?>><?php echo $region->reg_ordenmapa->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$region_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($region->CurrentAction <> "gridadd")
		$region_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($region_list->Recordset)
	$region_list->Recordset->Close();
?>
<?php if ($region_list->TotalRecs > 0) { ?>
<?php if ($region->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($region->CurrentAction <> "gridadd" && $region->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($region_list->Pager)) $region_list->Pager = new cPrevNextPager($region_list->StartRec, $region_list->DisplayRecs, $region_list->TotalRecs) ?>
<?php if ($region_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($region_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $region_list->PageUrl() ?>start=<?php echo $region_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($region_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $region_list->PageUrl() ?>start=<?php echo $region_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $region_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($region_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $region_list->PageUrl() ?>start=<?php echo $region_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($region_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $region_list->PageUrl() ?>start=<?php echo $region_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $region_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $region_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $region_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $region_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($region_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $region_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($region_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fregionlist, '<?php echo $region_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($region->Export == "" && $region->CurrentAction == "") { ?>
<?php } ?>
<?php
$region_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($region->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$region_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cregion_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'region';

	// Page object name
	var $PageObjName = 'region_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $region;
		if ($region->UseTokenInUrl) $PageUrl .= "t=" . $region->TableVar . "&"; // Add page token
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
		global $objForm, $region;
		if ($region->UseTokenInUrl) {
			if ($objForm)
				return ($region->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($region->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cregion_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (region)
		if (!isset($GLOBALS["region"])) {
			$GLOBALS["region"] = new cregion();
			$GLOBALS["Table"] =& $GLOBALS["region"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "regionadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "regiondelete.php";
		$this->MultiUpdateUrl = "regionupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'region', TRUE);

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
		global $region;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$region->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$region->Export = $_POST["exporttype"];
		} else {
			$region->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $region->Export; // Get export parameter, used in header
		$gsExportFile = $region->TableVar; // Get export file, used in header
		$Charset = (EW_CHARSET <> "") ? ";charset=" . EW_CHARSET : ""; // Charset used in header
		if ($region->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($region->Export == "word") {
			header('Content-Type: application/vnd.ms-word' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.doc');
		}
		if ($region->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$region->GridAddRowCount = $gridaddcnt;

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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $region;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Hide all options
			if ($region->Export <> "" ||
				$region->CurrentAction == "gridadd" ||
				$region->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$region->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($region->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $region->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$region->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$region->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$region->setStartRecordNumber($this->StartRec);
			}
		} else {
			$this->SearchWhere = $region->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$region->setSessionWhere($sFilter);
		$region->CurrentFilter = "";

		// Export data only
		if (in_array($region->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($region->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $region;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $region->reg_cod, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $region->reg_nombre, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $region->reg_alias, $Keyword);
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
		global $Security, $region;
		$sSearchStr = "";
		$sSearchKeyword = $region->BasicSearchKeyword;
		$sSearchType = $region->BasicSearchType;
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
			$region->setSessionBasicSearchKeyword($sSearchKeyword);
			$region->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $region;

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$region->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $region;
		$region->setSessionBasicSearchKeyword("");
		$region->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $region;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$region->BasicSearchKeyword = $region->getSessionBasicSearchKeyword();
			$region->BasicSearchType = $region->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $region;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$region->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$region->CurrentOrderType = @$_GET["ordertype"];
			$region->UpdateSort($region->reg_id); // reg_id
			$region->UpdateSort($region->reg_num); // reg_num
			$region->UpdateSort($region->reg_cod); // reg_cod
			$region->UpdateSort($region->reg_nombre); // reg_nombre
			$region->UpdateSort($region->reg_alias); // reg_alias
			$region->UpdateSort($region->reg_ordenmapa); // reg_ordenmapa
			$region->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $region;
		$sOrderBy = $region->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($region->SqlOrderBy() <> "") {
				$sOrderBy = $region->SqlOrderBy();
				$region->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $region;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$region->setSessionOrderBy($sOrderBy);
				$region->reg_id->setSort("");
				$region->reg_num->setSort("");
				$region->reg_cod->setSort("");
				$region->reg_nombre->setSort("");
				$region->reg_alias->setSort("");
				$region->reg_ordenmapa->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$region->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $region;

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
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"region_list.SelectAllKey(this);\">";
		$item->MoveTo(0);

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $region, $objForm;
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
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($region->reg_id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $region;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $region;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$region->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$region->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $region->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$region->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$region->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$region->setStartRecordNumber($this->StartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $region;
		$region->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$region->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $region;

		// Call Recordset Selecting event
		$region->Recordset_Selecting($region->CurrentFilter);

		// Load List page SQL
		$sSql = $region->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$region->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $region;
		$sFilter = $region->KeyFilter();

		// Call Row Selecting event
		$region->Row_Selecting($sFilter);

		// Load SQL based on filter
		$region->CurrentFilter = $sFilter;
		$sSql = $region->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$region->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $region;
		if (!$rs || $rs->EOF) return;
		$region->reg_id->setDbValue($rs->fields('reg_id'));
		$region->reg_num->setDbValue($rs->fields('reg_num'));
		$region->reg_cod->setDbValue($rs->fields('reg_cod'));
		$region->reg_nombre->setDbValue($rs->fields('reg_nombre'));
		$region->reg_alias->setDbValue($rs->fields('reg_alias'));
		$region->reg_ordenmapa->setDbValue($rs->fields('reg_ordenmapa'));
	}

	// Load old record
	function LoadOldRecord() {
		global $region;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($region->getKey("reg_id")) <> "")
			$region->reg_id->CurrentValue = $region->getKey("reg_id"); // reg_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$region->CurrentFilter = $region->KeyFilter();
			$sSql = $region->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $region;

		// Initialize URLs
		$this->ViewUrl = $region->ViewUrl();
		$this->EditUrl = $region->EditUrl();
		$this->InlineEditUrl = $region->InlineEditUrl();
		$this->CopyUrl = $region->CopyUrl();
		$this->InlineCopyUrl = $region->InlineCopyUrl();
		$this->DeleteUrl = $region->DeleteUrl();

		// Call Row_Rendering event
		$region->Row_Rendering();

		// Common render codes for all row types
		// reg_id
		// reg_num
		// reg_cod
		// reg_nombre
		// reg_alias
		// reg_ordenmapa

		if ($region->RowType == EW_ROWTYPE_VIEW) { // View row

			// reg_id
			$region->reg_id->ViewValue = $region->reg_id->CurrentValue;
			$region->reg_id->ViewCustomAttributes = "";

			// reg_num
			$region->reg_num->ViewValue = $region->reg_num->CurrentValue;
			$region->reg_num->ViewCustomAttributes = "";

			// reg_cod
			$region->reg_cod->ViewValue = $region->reg_cod->CurrentValue;
			$region->reg_cod->ViewCustomAttributes = "";

			// reg_nombre
			$region->reg_nombre->ViewValue = $region->reg_nombre->CurrentValue;
			$region->reg_nombre->ViewCustomAttributes = "";

			// reg_alias
			$region->reg_alias->ViewValue = $region->reg_alias->CurrentValue;
			$region->reg_alias->ViewCustomAttributes = "";

			// reg_ordenmapa
			$region->reg_ordenmapa->ViewValue = $region->reg_ordenmapa->CurrentValue;
			$region->reg_ordenmapa->ViewCustomAttributes = "";

			// reg_id
			$region->reg_id->LinkCustomAttributes = "";
			$region->reg_id->HrefValue = "";
			$region->reg_id->TooltipValue = "";

			// reg_num
			$region->reg_num->LinkCustomAttributes = "";
			$region->reg_num->HrefValue = "";
			$region->reg_num->TooltipValue = "";

			// reg_cod
			$region->reg_cod->LinkCustomAttributes = "";
			$region->reg_cod->HrefValue = "";
			$region->reg_cod->TooltipValue = "";

			// reg_nombre
			$region->reg_nombre->LinkCustomAttributes = "";
			$region->reg_nombre->HrefValue = "";
			$region->reg_nombre->TooltipValue = "";

			// reg_alias
			$region->reg_alias->LinkCustomAttributes = "";
			$region->reg_alias->HrefValue = "";
			$region->reg_alias->TooltipValue = "";

			// reg_ordenmapa
			$region->reg_ordenmapa->LinkCustomAttributes = "";
			$region->reg_ordenmapa->HrefValue = "";
			$region->reg_ordenmapa->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($region->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$region->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language, $region;

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
		$item->Body = "<a name=\"emf_region\" id=\"emf_region\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_region',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fregionlist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($region->Export <> "" ||
			$region->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $region;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $region->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($region->ExportAll) {
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
		if ($region->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($region, "h");
		}
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		if ($region->Export == "xml") {
			$region->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$region->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
			$sFooter = $this->PageFooter;
			$this->Page_DataRendered($sFooter);
			$ExportDoc->Text .= $sFooter;
		}

		// Close recordset
		$rs->Close();

		// Export header and footer
		if ($region->Export <> "xml") {
			$ExportDoc->ExportHeaderAndFooter();
		}

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($region->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($region->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($region->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($region->ExportReturnUrl());
		} elseif ($region->Export == "pdf") {
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
