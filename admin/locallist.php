<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "localinfo.php" ?>
<?php include_once "empresainfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$local_list = new clocal_list();
$Page =& $local_list;

// Page init
$local_list->Page_Init();

// Page main
$local_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($local->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var local_list = new ew_Page("local_list");

// page properties
local_list.PageID = "list"; // page ID
local_list.FormID = "flocallist"; // form ID
var EW_PAGE_ID = local_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
local_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
local_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
local_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
local_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($local->Export == "") || (EW_EXPORT_MASTER_RECORD && $local->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "empresalist.php";
if ($local_list->DbMasterFilter <> "" && $local->getCurrentMasterTable() == "empresa") {
	if ($local_list->MasterRecordExists) {
		if ($local->getCurrentMasterTable() == $local->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("MasterRecord") ?><?php echo $empresa->TableCaption() ?>
&nbsp;&nbsp;<?php $local_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($local->Export == "") { ?>
<p class="phpmaker"><a href="<?php echo $gsMasterReturnUrl ?>"><?php echo $Language->Phrase("BackToMasterPage") ?></a></p>
<?php } ?>
<?php include_once "empresamaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php $local_list->ShowPageHeader(); ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$local_list->TotalRecs = $local->SelectRecordCount();
	} else {
		if ($local_list->Recordset = $local_list->LoadRecordset())
			$local_list->TotalRecs = $local_list->Recordset->RecordCount();
	}
	$local_list->StartRec = 1;
	if ($local_list->DisplayRecs <= 0 || ($local->Export <> "" && $local->ExportAll)) // Display all records
		$local_list->DisplayRecs = $local_list->TotalRecs;
	if (!($local->Export <> "" && $local->ExportAll))
		$local_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$local_list->Recordset = $local_list->LoadRecordset($local_list->StartRec-1, $local_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $local->TableCaption() ?>
<?php if ($local->getCurrentMasterTable() == "") { ?>
&nbsp;&nbsp;<?php $local_list->ExportOptions->Render("body"); ?>
<?php } ?>
</p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($local->Export == "" && $local->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(local_list);" style="text-decoration: none;"><img id="local_list_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="local_list_SearchPanel">
<form name="flocallistsrch" id="flocallistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="local">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewCssTableRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($local->getSessionBasicSearchKeyword()) ?>">
	<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $local_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewCssTableRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($local->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($local->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($local->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
$local_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($local->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($local->CurrentAction <> "gridadd" && $local->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($local_list->Pager)) $local_list->Pager = new cPrevNextPager($local_list->StartRec, $local_list->DisplayRecs, $local_list->TotalRecs) ?>
<?php if ($local_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($local_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $local_list->PageUrl() ?>start=<?php echo $local_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($local_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $local_list->PageUrl() ?>start=<?php echo $local_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $local_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($local_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $local_list->PageUrl() ?>start=<?php echo $local_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($local_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $local_list->PageUrl() ?>start=<?php echo $local_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $local_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $local_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $local_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $local_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($local_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $local_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($local_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.flocallist, '<?php echo $local_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="flocallist" id="flocallist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="local">
<div id="gmp_local" class="ewGridMiddlePanel">
<?php if ($local_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $local->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$local_list->RenderListOptions();

// Render list options (header, left)
$local_list->ListOptions->Render("header", "left");
?>
<?php if ($local->loc_id->Visible) { // loc_id ?>
	<?php if ($local->SortUrl($local->loc_id) == "") { ?>
		<td><?php echo $local->loc_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $local->SortUrl($local->loc_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $local->loc_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($local->loc_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($local->loc_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($local->com_id->Visible) { // com_id ?>
	<?php if ($local->SortUrl($local->com_id) == "") { ?>
		<td><?php echo $local->com_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $local->SortUrl($local->com_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $local->com_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($local->com_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($local->com_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($local->emp_id->Visible) { // emp_id ?>
	<?php if ($local->SortUrl($local->emp_id) == "") { ?>
		<td><?php echo $local->emp_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $local->SortUrl($local->emp_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $local->emp_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($local->emp_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($local->emp_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($local->loc_nombre->Visible) { // loc_nombre ?>
	<?php if ($local->SortUrl($local->loc_nombre) == "") { ?>
		<td><?php echo $local->loc_nombre->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $local->SortUrl($local->loc_nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $local->loc_nombre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($local->loc_nombre->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($local->loc_nombre->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($local->loc_direccion->Visible) { // loc_direccion ?>
	<?php if ($local->SortUrl($local->loc_direccion) == "") { ?>
		<td><?php echo $local->loc_direccion->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $local->SortUrl($local->loc_direccion) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $local->loc_direccion->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($local->loc_direccion->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($local->loc_direccion->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($local->loc_vigente->Visible) { // loc_vigente ?>
	<?php if ($local->SortUrl($local->loc_vigente) == "") { ?>
		<td><?php echo $local->loc_vigente->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $local->SortUrl($local->loc_vigente) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $local->loc_vigente->FldCaption() ?></td><td style="width: 10px;"><?php if ($local->loc_vigente->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($local->loc_vigente->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$local_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($local->ExportAll && $local->Export <> "") {
	$local_list->StopRec = $local_list->TotalRecs;
} else {

	// Set the last record to display
	if ($local_list->TotalRecs > $local_list->StartRec + $local_list->DisplayRecs - 1)
		$local_list->StopRec = $local_list->StartRec + $local_list->DisplayRecs - 1;
	else
		$local_list->StopRec = $local_list->TotalRecs;
}
$local_list->RecCnt = $local_list->StartRec - 1;
if ($local_list->Recordset && !$local_list->Recordset->EOF) {
	$local_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $local_list->StartRec > 1)
		$local_list->Recordset->Move($local_list->StartRec - 1);
} elseif (!$local->AllowAddDeleteRow && $local_list->StopRec == 0) {
	$local_list->StopRec = $local->GridAddRowCount;
}

// Initialize aggregate
$local->RowType = EW_ROWTYPE_AGGREGATEINIT;
$local->ResetAttrs();
$local_list->RenderRow();
$local_list->RowCnt = 0;
while ($local_list->RecCnt < $local_list->StopRec) {
	$local_list->RecCnt++;
	if (intval($local_list->RecCnt) >= intval($local_list->StartRec)) {
		$local_list->RowCnt++;

		// Set up key count
		$local_list->KeyCount = $local_list->RowIndex;

		// Init row class and style
		$local->ResetAttrs();
		$local->CssClass = "";
		if ($local->CurrentAction == "gridadd") {
			$local_list->LoadDefaultValues(); // Load default values
		} else {
			$local_list->LoadRowValues($local_list->Recordset); // Load row values
		}
		$local->RowType = EW_ROWTYPE_VIEW; // Render view
		$local->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$local_list->RenderRow();

		// Render list options
		$local_list->RenderListOptions();
?>
	<tr<?php echo $local->RowAttributes() ?>>
<?php

// Render list options (body, left)
$local_list->ListOptions->Render("body", "left");
?>
	<?php if ($local->loc_id->Visible) { // loc_id ?>
		<td<?php echo $local->loc_id->CellAttributes() ?>>
<div<?php echo $local->loc_id->ViewAttributes() ?>><?php echo $local->loc_id->ListViewValue() ?></div>
<a name="<?php echo $local_list->PageObjName . "_row_" . $local_list->RowCnt ?>" id="<?php echo $local_list->PageObjName . "_row_" . $local_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($local->com_id->Visible) { // com_id ?>
		<td<?php echo $local->com_id->CellAttributes() ?>>
<div<?php echo $local->com_id->ViewAttributes() ?>><?php echo $local->com_id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($local->emp_id->Visible) { // emp_id ?>
		<td<?php echo $local->emp_id->CellAttributes() ?>>
<div<?php echo $local->emp_id->ViewAttributes() ?>><?php echo $local->emp_id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($local->loc_nombre->Visible) { // loc_nombre ?>
		<td<?php echo $local->loc_nombre->CellAttributes() ?>>
<div<?php echo $local->loc_nombre->ViewAttributes() ?>><?php echo $local->loc_nombre->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($local->loc_direccion->Visible) { // loc_direccion ?>
		<td<?php echo $local->loc_direccion->CellAttributes() ?>>
<div<?php echo $local->loc_direccion->ViewAttributes() ?>><?php echo $local->loc_direccion->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($local->loc_vigente->Visible) { // loc_vigente ?>
		<td<?php echo $local->loc_vigente->CellAttributes() ?>>
<div<?php echo $local->loc_vigente->ViewAttributes() ?>><?php echo $local->loc_vigente->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$local_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($local->CurrentAction <> "gridadd")
		$local_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($local_list->Recordset)
	$local_list->Recordset->Close();
?>
<?php if ($local_list->TotalRecs > 0) { ?>
<?php if ($local->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($local->CurrentAction <> "gridadd" && $local->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($local_list->Pager)) $local_list->Pager = new cPrevNextPager($local_list->StartRec, $local_list->DisplayRecs, $local_list->TotalRecs) ?>
<?php if ($local_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($local_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $local_list->PageUrl() ?>start=<?php echo $local_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($local_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $local_list->PageUrl() ?>start=<?php echo $local_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $local_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($local_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $local_list->PageUrl() ?>start=<?php echo $local_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($local_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $local_list->PageUrl() ?>start=<?php echo $local_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $local_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $local_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $local_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $local_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($local_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $local_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($local_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.flocallist, '<?php echo $local_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($local->Export == "" && $local->CurrentAction == "") { ?>
<?php } ?>
<?php
$local_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($local->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$local_list->Page_Terminate();
?>
<?php

//
// Page class
//
class clocal_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'local';

	// Page object name
	var $PageObjName = 'local_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $local;
		if ($local->UseTokenInUrl) $PageUrl .= "t=" . $local->TableVar . "&"; // Add page token
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
		global $objForm, $local;
		if ($local->UseTokenInUrl) {
			if ($objForm)
				return ($local->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($local->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function clocal_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (local)
		if (!isset($GLOBALS["local"])) {
			$GLOBALS["local"] = new clocal();
			$GLOBALS["Table"] =& $GLOBALS["local"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "localadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "localdelete.php";
		$this->MultiUpdateUrl = "localupdate.php";

		// Table object (empresa)
		if (!isset($GLOBALS['empresa'])) $GLOBALS['empresa'] = new cempresa();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'local', TRUE);

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
		global $local;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$local->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$local->Export = $_POST["exporttype"];
		} else {
			$local->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $local->Export; // Get export parameter, used in header
		$gsExportFile = $local->TableVar; // Get export file, used in header
		$Charset = (EW_CHARSET <> "") ? ";charset=" . EW_CHARSET : ""; // Charset used in header
		if ($local->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($local->Export == "word") {
			header('Content-Type: application/vnd.ms-word' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.doc');
		}
		if ($local->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$local->GridAddRowCount = $gridaddcnt;

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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $local;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set up master detail parameters
			$this->SetUpMasterParms();

			// Hide all options
			if ($local->Export <> "" ||
				$local->CurrentAction == "gridadd" ||
				$local->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$local->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($local->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $local->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$local->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$local->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$local->setStartRecordNumber($this->StartRec);
			}
		} else {
			$this->SearchWhere = $local->getSearchWhere();
		}

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $local->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $local->getDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($local->getMasterFilter() <> "" && $local->getCurrentMasterTable() == "empresa") {
			global $empresa;
			$rsmaster = $empresa->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate($local->getReturnUrl()); // Return to caller
			} else {
				$empresa->LoadListRowValues($rsmaster);
				$empresa->RowType = EW_ROWTYPE_MASTER; // Master row
				$empresa->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$local->setSessionWhere($sFilter);
		$local->CurrentFilter = "";

		// Export data only
		if (in_array($local->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($local->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $local;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $local->loc_nombre, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $local->loc_direccion, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $local->loc_googlemaps, $Keyword);
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
		global $Security, $local;
		$sSearchStr = "";
		$sSearchKeyword = $local->BasicSearchKeyword;
		$sSearchType = $local->BasicSearchType;
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
			$local->setSessionBasicSearchKeyword($sSearchKeyword);
			$local->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $local;

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$local->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $local;
		$local->setSessionBasicSearchKeyword("");
		$local->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $local;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$local->BasicSearchKeyword = $local->getSessionBasicSearchKeyword();
			$local->BasicSearchType = $local->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $local;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$local->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$local->CurrentOrderType = @$_GET["ordertype"];
			$local->UpdateSort($local->loc_id); // loc_id
			$local->UpdateSort($local->com_id); // com_id
			$local->UpdateSort($local->emp_id); // emp_id
			$local->UpdateSort($local->loc_nombre); // loc_nombre
			$local->UpdateSort($local->loc_direccion); // loc_direccion
			$local->UpdateSort($local->loc_vigente); // loc_vigente
			$local->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $local;
		$sOrderBy = $local->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($local->SqlOrderBy() <> "") {
				$sOrderBy = $local->SqlOrderBy();
				$local->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $local;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset master/detail keys
			if (strtolower($sCmd) == "resetall") {
				$local->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$local->emp_id->setSessionValue("");
			}

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$local->setSessionOrderBy($sOrderBy);
				$local->loc_id->setSort("");
				$local->com_id->setSort("");
				$local->emp_id->setSort("");
				$local->loc_nombre->setSort("");
				$local->loc_direccion->setSort("");
				$local->loc_vigente->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$local->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $local;

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
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"local_list.SelectAllKey(this);\">";
		$item->MoveTo(0);

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $local, $objForm;
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
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($local->loc_id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $local;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $local;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$local->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$local->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $local->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$local->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$local->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$local->setStartRecordNumber($this->StartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $local;
		$local->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$local->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $local;

		// Call Recordset Selecting event
		$local->Recordset_Selecting($local->CurrentFilter);

		// Load List page SQL
		$sSql = $local->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$local->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $local;
		$sFilter = $local->KeyFilter();

		// Call Row Selecting event
		$local->Row_Selecting($sFilter);

		// Load SQL based on filter
		$local->CurrentFilter = $sFilter;
		$sSql = $local->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$local->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $local;
		if (!$rs || $rs->EOF) return;
		$local->loc_id->setDbValue($rs->fields('loc_id'));
		$local->com_id->setDbValue($rs->fields('com_id'));
		$local->emp_id->setDbValue($rs->fields('emp_id'));
		$local->loc_nombre->setDbValue($rs->fields('loc_nombre'));
		$local->loc_direccion->setDbValue($rs->fields('loc_direccion'));
		$local->loc_googlemaps->setDbValue($rs->fields('loc_googlemaps'));
		$local->loc_vigente->setDbValue($rs->fields('loc_vigente'));
	}

	// Load old record
	function LoadOldRecord() {
		global $local;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($local->getKey("loc_id")) <> "")
			$local->loc_id->CurrentValue = $local->getKey("loc_id"); // loc_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$local->CurrentFilter = $local->KeyFilter();
			$sSql = $local->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $local;

		// Initialize URLs
		$this->ViewUrl = $local->ViewUrl();
		$this->EditUrl = $local->EditUrl();
		$this->InlineEditUrl = $local->InlineEditUrl();
		$this->CopyUrl = $local->CopyUrl();
		$this->InlineCopyUrl = $local->InlineCopyUrl();
		$this->DeleteUrl = $local->DeleteUrl();

		// Call Row_Rendering event
		$local->Row_Rendering();

		// Common render codes for all row types
		// loc_id
		// com_id
		// emp_id
		// loc_nombre
		// loc_direccion
		// loc_googlemaps
		// loc_vigente

		if ($local->RowType == EW_ROWTYPE_VIEW) { // View row

			// loc_id
			$local->loc_id->ViewValue = $local->loc_id->CurrentValue;
			$local->loc_id->ViewCustomAttributes = "";

			// com_id
			if (strval($local->com_id->CurrentValue) <> "") {
				$sFilterWrk = "`com_id` = " . ew_AdjustSql($local->com_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `com_nombre` FROM `comuna`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `com_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$local->com_id->ViewValue = $rswrk->fields('com_nombre');
					$rswrk->Close();
				} else {
					$local->com_id->ViewValue = $local->com_id->CurrentValue;
				}
			} else {
				$local->com_id->ViewValue = NULL;
			}
			$local->com_id->ViewCustomAttributes = "";

			// emp_id
			if (strval($local->emp_id->CurrentValue) <> "") {
				$sFilterWrk = "`emp_id` = " . ew_AdjustSql($local->emp_id->CurrentValue) . "";
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
					$local->emp_id->ViewValue = $rswrk->fields('emp_rut');
					$local->emp_id->ViewValue .= ew_ValueSeparator(0,1,$local->emp_id) . $rswrk->fields('emp_nomfantasia');
					$local->emp_id->ViewValue .= ew_ValueSeparator(0,2,$local->emp_id) . $rswrk->fields('emp_razonsocial');
					$rswrk->Close();
				} else {
					$local->emp_id->ViewValue = $local->emp_id->CurrentValue;
				}
			} else {
				$local->emp_id->ViewValue = NULL;
			}
			$local->emp_id->ViewCustomAttributes = "";

			// loc_nombre
			$local->loc_nombre->ViewValue = $local->loc_nombre->CurrentValue;
			$local->loc_nombre->ViewCustomAttributes = "";

			// loc_direccion
			$local->loc_direccion->ViewValue = $local->loc_direccion->CurrentValue;
			$local->loc_direccion->ViewCustomAttributes = "";

			// loc_vigente
			if (strval($local->loc_vigente->CurrentValue) <> "") {
				switch ($local->loc_vigente->CurrentValue) {
					case "1":
						$local->loc_vigente->ViewValue = $local->loc_vigente->FldTagCaption(1) <> "" ? $local->loc_vigente->FldTagCaption(1) : $local->loc_vigente->CurrentValue;
						break;
					case "0":
						$local->loc_vigente->ViewValue = $local->loc_vigente->FldTagCaption(2) <> "" ? $local->loc_vigente->FldTagCaption(2) : $local->loc_vigente->CurrentValue;
						break;
					default:
						$local->loc_vigente->ViewValue = $local->loc_vigente->CurrentValue;
				}
			} else {
				$local->loc_vigente->ViewValue = NULL;
			}
			$local->loc_vigente->ViewCustomAttributes = "";

			// loc_id
			$local->loc_id->LinkCustomAttributes = "";
			$local->loc_id->HrefValue = "";
			$local->loc_id->TooltipValue = "";

			// com_id
			$local->com_id->LinkCustomAttributes = "";
			$local->com_id->HrefValue = "";
			$local->com_id->TooltipValue = "";

			// emp_id
			$local->emp_id->LinkCustomAttributes = "";
			$local->emp_id->HrefValue = "";
			$local->emp_id->TooltipValue = "";

			// loc_nombre
			$local->loc_nombre->LinkCustomAttributes = "";
			$local->loc_nombre->HrefValue = "";
			$local->loc_nombre->TooltipValue = "";

			// loc_direccion
			$local->loc_direccion->LinkCustomAttributes = "";
			$local->loc_direccion->HrefValue = "";
			$local->loc_direccion->TooltipValue = "";

			// loc_vigente
			$local->loc_vigente->LinkCustomAttributes = "";
			$local->loc_vigente->HrefValue = "";
			$local->loc_vigente->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($local->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$local->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language, $local;

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
		$item->Body = "<a name=\"emf_local\" id=\"emf_local\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_local',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.flocallist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($local->Export <> "" ||
			$local->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $local;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $local->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($local->ExportAll) {
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
		if ($local->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($local, "h");
		}
		$ParentTable = "";

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $local->getMasterFilter() <> "" && $local->getCurrentMasterTable() == "empresa") {
			global $empresa;
			$rsmaster = $empresa->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				if ($local->Export == "xml") {
					$ParentTable = "empresa";
					$empresa->ExportXmlDocument($XmlDoc, '', $rsmaster, 1, 1);
				} else {
					$ExportStyle = $ExportDoc->Style;
					$ExportDoc->ChangeStyle("v"); // Change to vertical
					if ($local->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
						$empresa->ExportDocument($ExportDoc, $rsmaster, 1, 1);
						$ExportDoc->ExportEmptyLine();
					}
					$ExportDoc->ChangeStyle($ExportStyle); // Restore
				}
				$rsmaster->Close();
			}
		}
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		if ($local->Export == "xml") {
			$local->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$local->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
			$sFooter = $this->PageFooter;
			$this->Page_DataRendered($sFooter);
			$ExportDoc->Text .= $sFooter;
		}

		// Close recordset
		$rs->Close();

		// Export header and footer
		if ($local->Export <> "xml") {
			$ExportDoc->ExportHeaderAndFooter();
		}

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($local->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($local->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($local->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($local->ExportReturnUrl());
		} elseif ($local->Export == "pdf") {
			$this->ExportPDF($ExportDoc->Text);
		} else {
			echo $ExportDoc->Text;
		}
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		global $local;
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (@$_GET[EW_TABLE_SHOW_MASTER] <> "") {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "empresa") {
				$bValidMaster = TRUE;
				if (@$_GET["emp_id"] <> "") {
					$GLOBALS["empresa"]->emp_id->setQueryStringValue($_GET["emp_id"]);
					$local->emp_id->setQueryStringValue($GLOBALS["empresa"]->emp_id->QueryStringValue);
					$local->emp_id->setSessionValue($local->emp_id->QueryStringValue);
					if (!is_numeric($GLOBALS["empresa"]->emp_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$local->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$local->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "empresa") {
				if ($local->emp_id->QueryStringValue == "") $local->emp_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $local->getMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $local->getDetailFilter(); // Get detail filter
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
