<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "empresainfo.php" ?>
<?php include_once "localinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$empresa_list = new cempresa_list();
$Page =& $empresa_list;

// Page init
$empresa_list->Page_Init();

// Page main
$empresa_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($empresa->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var empresa_list = new ew_Page("empresa_list");

// page properties
empresa_list.PageID = "list"; // page ID
empresa_list.FormID = "fempresalist"; // form ID
var EW_PAGE_ID = empresa_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
empresa_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
empresa_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
empresa_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
empresa_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($empresa->Export == "") || (EW_EXPORT_MASTER_RECORD && $empresa->Export == "print")) { ?>
<?php } ?>
<?php $empresa_list->ShowPageHeader(); ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$empresa_list->TotalRecs = $empresa->SelectRecordCount();
	} else {
		if ($empresa_list->Recordset = $empresa_list->LoadRecordset())
			$empresa_list->TotalRecs = $empresa_list->Recordset->RecordCount();
	}
	$empresa_list->StartRec = 1;
	if ($empresa_list->DisplayRecs <= 0 || ($empresa->Export <> "" && $empresa->ExportAll)) // Display all records
		$empresa_list->DisplayRecs = $empresa_list->TotalRecs;
	if (!($empresa->Export <> "" && $empresa->ExportAll))
		$empresa_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$empresa_list->Recordset = $empresa_list->LoadRecordset($empresa_list->StartRec-1, $empresa_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $empresa->TableCaption() ?>
&nbsp;&nbsp;<?php $empresa_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($empresa->Export == "" && $empresa->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(empresa_list);" style="text-decoration: none;"><img id="empresa_list_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="empresa_list_SearchPanel">
<form name="fempresalistsrch" id="fempresalistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="empresa">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewCssTableRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($empresa->getSessionBasicSearchKeyword()) ?>">
	<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $empresa_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewCssTableRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($empresa->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($empresa->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($empresa->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
$empresa_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($empresa->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($empresa->CurrentAction <> "gridadd" && $empresa->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($empresa_list->Pager)) $empresa_list->Pager = new cPrevNextPager($empresa_list->StartRec, $empresa_list->DisplayRecs, $empresa_list->TotalRecs) ?>
<?php if ($empresa_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($empresa_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $empresa_list->PageUrl() ?>start=<?php echo $empresa_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($empresa_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $empresa_list->PageUrl() ?>start=<?php echo $empresa_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $empresa_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($empresa_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $empresa_list->PageUrl() ?>start=<?php echo $empresa_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($empresa_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $empresa_list->PageUrl() ?>start=<?php echo $empresa_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $empresa_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $empresa_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $empresa_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $empresa_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($empresa_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $empresa_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php if ($local->DetailAdd && $Security->IsLoggedIn()) { ?>
<a href="<?php echo $empresa->AddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=local" ?>"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $empresa->TableCaption() ?>/<?php echo $local->TableCaption() ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php if ($empresa_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fempresalist, '<?php echo $empresa_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fempresalist" id="fempresalist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="empresa">
<div id="gmp_empresa" class="ewGridMiddlePanel">
<?php if ($empresa_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $empresa->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$empresa_list->RenderListOptions();

// Render list options (header, left)
$empresa_list->ListOptions->Render("header", "left");
?>
<?php if ($empresa->emp_id->Visible) { // emp_id ?>
	<?php if ($empresa->SortUrl($empresa->emp_id) == "") { ?>
		<td><?php echo $empresa->emp_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $empresa->SortUrl($empresa->emp_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $empresa->emp_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($empresa->emp_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($empresa->emp_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($empresa->emp_nomfantasia->Visible) { // emp_nomfantasia ?>
	<?php if ($empresa->SortUrl($empresa->emp_nomfantasia) == "") { ?>
		<td><?php echo $empresa->emp_nomfantasia->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $empresa->SortUrl($empresa->emp_nomfantasia) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $empresa->emp_nomfantasia->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($empresa->emp_nomfantasia->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($empresa->emp_nomfantasia->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($empresa->emp_razonsocial->Visible) { // emp_razonsocial ?>
	<?php if ($empresa->SortUrl($empresa->emp_razonsocial) == "") { ?>
		<td><?php echo $empresa->emp_razonsocial->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $empresa->SortUrl($empresa->emp_razonsocial) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $empresa->emp_razonsocial->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($empresa->emp_razonsocial->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($empresa->emp_razonsocial->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($empresa->emp_rut->Visible) { // emp_rut ?>
	<?php if ($empresa->SortUrl($empresa->emp_rut) == "") { ?>
		<td><?php echo $empresa->emp_rut->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $empresa->SortUrl($empresa->emp_rut) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $empresa->emp_rut->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($empresa->emp_rut->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($empresa->emp_rut->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$empresa_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($empresa->ExportAll && $empresa->Export <> "") {
	$empresa_list->StopRec = $empresa_list->TotalRecs;
} else {

	// Set the last record to display
	if ($empresa_list->TotalRecs > $empresa_list->StartRec + $empresa_list->DisplayRecs - 1)
		$empresa_list->StopRec = $empresa_list->StartRec + $empresa_list->DisplayRecs - 1;
	else
		$empresa_list->StopRec = $empresa_list->TotalRecs;
}
$empresa_list->RecCnt = $empresa_list->StartRec - 1;
if ($empresa_list->Recordset && !$empresa_list->Recordset->EOF) {
	$empresa_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $empresa_list->StartRec > 1)
		$empresa_list->Recordset->Move($empresa_list->StartRec - 1);
} elseif (!$empresa->AllowAddDeleteRow && $empresa_list->StopRec == 0) {
	$empresa_list->StopRec = $empresa->GridAddRowCount;
}

// Initialize aggregate
$empresa->RowType = EW_ROWTYPE_AGGREGATEINIT;
$empresa->ResetAttrs();
$empresa_list->RenderRow();
$empresa_list->RowCnt = 0;
while ($empresa_list->RecCnt < $empresa_list->StopRec) {
	$empresa_list->RecCnt++;
	if (intval($empresa_list->RecCnt) >= intval($empresa_list->StartRec)) {
		$empresa_list->RowCnt++;

		// Set up key count
		$empresa_list->KeyCount = $empresa_list->RowIndex;

		// Init row class and style
		$empresa->ResetAttrs();
		$empresa->CssClass = "";
		if ($empresa->CurrentAction == "gridadd") {
			$empresa_list->LoadDefaultValues(); // Load default values
		} else {
			$empresa_list->LoadRowValues($empresa_list->Recordset); // Load row values
		}
		$empresa->RowType = EW_ROWTYPE_VIEW; // Render view
		$empresa->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$empresa_list->RenderRow();

		// Render list options
		$empresa_list->RenderListOptions();
?>
	<tr<?php echo $empresa->RowAttributes() ?>>
<?php

// Render list options (body, left)
$empresa_list->ListOptions->Render("body", "left");
?>
	<?php if ($empresa->emp_id->Visible) { // emp_id ?>
		<td<?php echo $empresa->emp_id->CellAttributes() ?>>
<div<?php echo $empresa->emp_id->ViewAttributes() ?>><?php echo $empresa->emp_id->ListViewValue() ?></div>
<a name="<?php echo $empresa_list->PageObjName . "_row_" . $empresa_list->RowCnt ?>" id="<?php echo $empresa_list->PageObjName . "_row_" . $empresa_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($empresa->emp_nomfantasia->Visible) { // emp_nomfantasia ?>
		<td<?php echo $empresa->emp_nomfantasia->CellAttributes() ?>>
<div<?php echo $empresa->emp_nomfantasia->ViewAttributes() ?>><?php echo $empresa->emp_nomfantasia->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($empresa->emp_razonsocial->Visible) { // emp_razonsocial ?>
		<td<?php echo $empresa->emp_razonsocial->CellAttributes() ?>>
<div<?php echo $empresa->emp_razonsocial->ViewAttributes() ?>><?php echo $empresa->emp_razonsocial->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($empresa->emp_rut->Visible) { // emp_rut ?>
		<td<?php echo $empresa->emp_rut->CellAttributes() ?>>
<div<?php echo $empresa->emp_rut->ViewAttributes() ?>><?php echo $empresa->emp_rut->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$empresa_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($empresa->CurrentAction <> "gridadd")
		$empresa_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($empresa_list->Recordset)
	$empresa_list->Recordset->Close();
?>
<?php if ($empresa_list->TotalRecs > 0) { ?>
<?php if ($empresa->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($empresa->CurrentAction <> "gridadd" && $empresa->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($empresa_list->Pager)) $empresa_list->Pager = new cPrevNextPager($empresa_list->StartRec, $empresa_list->DisplayRecs, $empresa_list->TotalRecs) ?>
<?php if ($empresa_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($empresa_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $empresa_list->PageUrl() ?>start=<?php echo $empresa_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($empresa_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $empresa_list->PageUrl() ?>start=<?php echo $empresa_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $empresa_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($empresa_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $empresa_list->PageUrl() ?>start=<?php echo $empresa_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($empresa_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $empresa_list->PageUrl() ?>start=<?php echo $empresa_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $empresa_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $empresa_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $empresa_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $empresa_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($empresa_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $empresa_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php if ($local->DetailAdd && $Security->IsLoggedIn()) { ?>
<a href="<?php echo $empresa->AddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=local" ?>"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $empresa->TableCaption() ?>/<?php echo $local->TableCaption() ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php if ($empresa_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fempresalist, '<?php echo $empresa_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($empresa->Export == "" && $empresa->CurrentAction == "") { ?>
<?php } ?>
<?php
$empresa_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($empresa->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$empresa_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cempresa_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'empresa';

	// Page object name
	var $PageObjName = 'empresa_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $empresa;
		if ($empresa->UseTokenInUrl) $PageUrl .= "t=" . $empresa->TableVar . "&"; // Add page token
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
		global $objForm, $empresa;
		if ($empresa->UseTokenInUrl) {
			if ($objForm)
				return ($empresa->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($empresa->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cempresa_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (empresa)
		if (!isset($GLOBALS["empresa"])) {
			$GLOBALS["empresa"] = new cempresa();
			$GLOBALS["Table"] =& $GLOBALS["empresa"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "empresaadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "empresadelete.php";
		$this->MultiUpdateUrl = "empresaupdate.php";

		// Table object (local)
		if (!isset($GLOBALS['local'])) $GLOBALS['local'] = new clocal();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'empresa', TRUE);

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
		global $empresa;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$empresa->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$empresa->Export = $_POST["exporttype"];
		} else {
			$empresa->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $empresa->Export; // Get export parameter, used in header
		$gsExportFile = $empresa->TableVar; // Get export file, used in header
		$Charset = (EW_CHARSET <> "") ? ";charset=" . EW_CHARSET : ""; // Charset used in header
		if ($empresa->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($empresa->Export == "word") {
			header('Content-Type: application/vnd.ms-word' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.doc');
		}
		if ($empresa->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$empresa->GridAddRowCount = $gridaddcnt;

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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $empresa;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Hide all options
			if ($empresa->Export <> "" ||
				$empresa->CurrentAction == "gridadd" ||
				$empresa->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$empresa->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($empresa->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $empresa->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$empresa->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$empresa->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$empresa->setStartRecordNumber($this->StartRec);
			}
		} else {
			$this->SearchWhere = $empresa->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$empresa->setSessionWhere($sFilter);
		$empresa->CurrentFilter = "";

		// Export data only
		if (in_array($empresa->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($empresa->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $empresa;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $empresa->emp_nomfantasia, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $empresa->emp_razonsocial, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $empresa->emp_rut, $Keyword);
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
		global $Security, $empresa;
		$sSearchStr = "";
		$sSearchKeyword = $empresa->BasicSearchKeyword;
		$sSearchType = $empresa->BasicSearchType;
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
			$empresa->setSessionBasicSearchKeyword($sSearchKeyword);
			$empresa->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $empresa;

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$empresa->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $empresa;
		$empresa->setSessionBasicSearchKeyword("");
		$empresa->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $empresa;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$empresa->BasicSearchKeyword = $empresa->getSessionBasicSearchKeyword();
			$empresa->BasicSearchType = $empresa->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $empresa;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$empresa->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$empresa->CurrentOrderType = @$_GET["ordertype"];
			$empresa->UpdateSort($empresa->emp_id); // emp_id
			$empresa->UpdateSort($empresa->emp_nomfantasia); // emp_nomfantasia
			$empresa->UpdateSort($empresa->emp_razonsocial); // emp_razonsocial
			$empresa->UpdateSort($empresa->emp_rut); // emp_rut
			$empresa->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $empresa;
		$sOrderBy = $empresa->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($empresa->SqlOrderBy() <> "") {
				$sOrderBy = $empresa->SqlOrderBy();
				$empresa->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $empresa;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$empresa->setSessionOrderBy($sOrderBy);
				$empresa->emp_id->setSort("");
				$empresa->emp_nomfantasia->setSort("");
				$empresa->emp_razonsocial->setSort("");
				$empresa->emp_rut->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$empresa->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $empresa;

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

		// "detail_local"
		$item =& $this->ListOptions->Add("detail_local");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;

		// "checkbox"
		$item =& $this->ListOptions->Add("checkbox");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"empresa_list.SelectAllKey(this);\">";
		$item->MoveTo(0);

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $empresa, $objForm;
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

		// "detail_local"
		$oListOpt =& $this->ListOptions->Items["detail_local"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = $Language->Phrase("DetailLink") . $Language->TablePhrase("local", "TblCaption");
			$oListOpt->Body = "<a href=\"locallist.php?" . EW_TABLE_SHOW_MASTER . "=empresa&emp_id=" . urlencode(strval($empresa->emp_id->CurrentValue)) . "\">" . $oListOpt->Body . "</a>";
			$links = "";
			if ($GLOBALS["local"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
				$links .= "<a href=\"" . $empresa->EditUrl(EW_TABLE_SHOW_DETAIL . "=local") . "\">" . $Language->Phrase("EditLink") . "</a>&nbsp;";
			if ($GLOBALS["local"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn())
				$links .= "<a href=\"" . $empresa->CopyUrl(EW_TABLE_SHOW_DETAIL . "=local") . "\">" . $Language->Phrase("CopyLink") . "</a>&nbsp;";
			if ($links <> "") $oListOpt->Body .= "<br>" . $links;
		}

		// "checkbox"
		$oListOpt =& $this->ListOptions->Items["checkbox"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible)
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($empresa->emp_id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $empresa;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $empresa;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$empresa->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$empresa->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $empresa->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$empresa->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$empresa->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$empresa->setStartRecordNumber($this->StartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $empresa;
		$empresa->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$empresa->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $empresa;

		// Call Recordset Selecting event
		$empresa->Recordset_Selecting($empresa->CurrentFilter);

		// Load List page SQL
		$sSql = $empresa->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$empresa->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $empresa;
		$sFilter = $empresa->KeyFilter();

		// Call Row Selecting event
		$empresa->Row_Selecting($sFilter);

		// Load SQL based on filter
		$empresa->CurrentFilter = $sFilter;
		$sSql = $empresa->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$empresa->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $empresa;
		if (!$rs || $rs->EOF) return;
		$empresa->emp_id->setDbValue($rs->fields('emp_id'));
		$empresa->emp_nomfantasia->setDbValue($rs->fields('emp_nomfantasia'));
		$empresa->emp_razonsocial->setDbValue($rs->fields('emp_razonsocial'));
		$empresa->emp_rut->setDbValue($rs->fields('emp_rut'));
	}

	// Load old record
	function LoadOldRecord() {
		global $empresa;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($empresa->getKey("emp_id")) <> "")
			$empresa->emp_id->CurrentValue = $empresa->getKey("emp_id"); // emp_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$empresa->CurrentFilter = $empresa->KeyFilter();
			$sSql = $empresa->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $empresa;

		// Initialize URLs
		$this->ViewUrl = $empresa->ViewUrl();
		$this->EditUrl = $empresa->EditUrl();
		$this->InlineEditUrl = $empresa->InlineEditUrl();
		$this->CopyUrl = $empresa->CopyUrl();
		$this->InlineCopyUrl = $empresa->InlineCopyUrl();
		$this->DeleteUrl = $empresa->DeleteUrl();

		// Call Row_Rendering event
		$empresa->Row_Rendering();

		// Common render codes for all row types
		// emp_id
		// emp_nomfantasia
		// emp_razonsocial
		// emp_rut

		if ($empresa->RowType == EW_ROWTYPE_VIEW) { // View row

			// emp_id
			$empresa->emp_id->ViewValue = $empresa->emp_id->CurrentValue;
			$empresa->emp_id->ViewCustomAttributes = "";

			// emp_nomfantasia
			$empresa->emp_nomfantasia->ViewValue = $empresa->emp_nomfantasia->CurrentValue;
			$empresa->emp_nomfantasia->ViewCustomAttributes = "";

			// emp_razonsocial
			$empresa->emp_razonsocial->ViewValue = $empresa->emp_razonsocial->CurrentValue;
			$empresa->emp_razonsocial->ViewCustomAttributes = "";

			// emp_rut
			$empresa->emp_rut->ViewValue = $empresa->emp_rut->CurrentValue;
			$empresa->emp_rut->ViewCustomAttributes = "";

			// emp_id
			$empresa->emp_id->LinkCustomAttributes = "";
			$empresa->emp_id->HrefValue = "";
			$empresa->emp_id->TooltipValue = "";

			// emp_nomfantasia
			$empresa->emp_nomfantasia->LinkCustomAttributes = "";
			$empresa->emp_nomfantasia->HrefValue = "";
			$empresa->emp_nomfantasia->TooltipValue = "";

			// emp_razonsocial
			$empresa->emp_razonsocial->LinkCustomAttributes = "";
			$empresa->emp_razonsocial->HrefValue = "";
			$empresa->emp_razonsocial->TooltipValue = "";

			// emp_rut
			$empresa->emp_rut->LinkCustomAttributes = "";
			$empresa->emp_rut->HrefValue = "";
			$empresa->emp_rut->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($empresa->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$empresa->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language, $empresa;

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
		$item->Body = "<a name=\"emf_empresa\" id=\"emf_empresa\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_empresa',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fempresalist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($empresa->Export <> "" ||
			$empresa->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $empresa;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $empresa->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($empresa->ExportAll) {
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
		if ($empresa->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($empresa, "h");
		}
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		if ($empresa->Export == "xml") {
			$empresa->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$empresa->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
			$sFooter = $this->PageFooter;
			$this->Page_DataRendered($sFooter);
			$ExportDoc->Text .= $sFooter;
		}

		// Close recordset
		$rs->Close();

		// Export header and footer
		if ($empresa->Export <> "xml") {
			$ExportDoc->ExportHeaderAndFooter();
		}

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($empresa->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($empresa->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($empresa->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($empresa->ExportReturnUrl());
		} elseif ($empresa->Export == "pdf") {
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
