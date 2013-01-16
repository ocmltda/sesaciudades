<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "cupon_categinfo.php" ?>
<?php include_once "cuponinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$cupon_categ_list = new ccupon_categ_list();
$Page =& $cupon_categ_list;

// Page init
$cupon_categ_list->Page_Init();

// Page main
$cupon_categ_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cupon_categ->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cupon_categ_list = new ew_Page("cupon_categ_list");

// page properties
cupon_categ_list.PageID = "list"; // page ID
cupon_categ_list.FormID = "fcupon_categlist"; // form ID
var EW_PAGE_ID = cupon_categ_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cupon_categ_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cupon_categ_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cupon_categ_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cupon_categ_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($cupon_categ->Export == "") || (EW_EXPORT_MASTER_RECORD && $cupon_categ->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "cuponlist.php";
if ($cupon_categ_list->DbMasterFilter <> "" && $cupon_categ->getCurrentMasterTable() == "cupon") {
	if ($cupon_categ_list->MasterRecordExists) {
		if ($cupon_categ->getCurrentMasterTable() == $cupon_categ->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("MasterRecord") ?><?php echo $cupon->TableCaption() ?>
&nbsp;&nbsp;<?php $cupon_categ_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($cupon_categ->Export == "") { ?>
<p class="phpmaker"><a href="<?php echo $gsMasterReturnUrl ?>"><?php echo $Language->Phrase("BackToMasterPage") ?></a></p>
<?php } ?>
<?php include_once "cuponmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php $cupon_categ_list->ShowPageHeader(); ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cupon_categ_list->TotalRecs = $cupon_categ->SelectRecordCount();
	} else {
		if ($cupon_categ_list->Recordset = $cupon_categ_list->LoadRecordset())
			$cupon_categ_list->TotalRecs = $cupon_categ_list->Recordset->RecordCount();
	}
	$cupon_categ_list->StartRec = 1;
	if ($cupon_categ_list->DisplayRecs <= 0 || ($cupon_categ->Export <> "" && $cupon_categ->ExportAll)) // Display all records
		$cupon_categ_list->DisplayRecs = $cupon_categ_list->TotalRecs;
	if (!($cupon_categ->Export <> "" && $cupon_categ->ExportAll))
		$cupon_categ_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cupon_categ_list->Recordset = $cupon_categ_list->LoadRecordset($cupon_categ_list->StartRec-1, $cupon_categ_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cupon_categ->TableCaption() ?>
<?php if ($cupon_categ->getCurrentMasterTable() == "") { ?>
&nbsp;&nbsp;<?php $cupon_categ_list->ExportOptions->Render("body"); ?>
<?php } ?>
</p>
<?php
$cupon_categ_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cupon_categ->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cupon_categ->CurrentAction <> "gridadd" && $cupon_categ->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($cupon_categ_list->Pager)) $cupon_categ_list->Pager = new cPrevNextPager($cupon_categ_list->StartRec, $cupon_categ_list->DisplayRecs, $cupon_categ_list->TotalRecs) ?>
<?php if ($cupon_categ_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cupon_categ_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_categ_list->PageUrl() ?>start=<?php echo $cupon_categ_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cupon_categ_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_categ_list->PageUrl() ?>start=<?php echo $cupon_categ_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cupon_categ_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cupon_categ_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_categ_list->PageUrl() ?>start=<?php echo $cupon_categ_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cupon_categ_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_categ_list->PageUrl() ?>start=<?php echo $cupon_categ_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cupon_categ_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cupon_categ_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cupon_categ_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cupon_categ_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($cupon_categ_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $cupon_categ_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($cupon_categ_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fcupon_categlist, '<?php echo $cupon_categ_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcupon_categlist" id="fcupon_categlist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="cupon_categ">
<div id="gmp_cupon_categ" class="ewGridMiddlePanel">
<?php if ($cupon_categ_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $cupon_categ->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cupon_categ_list->RenderListOptions();

// Render list options (header, left)
$cupon_categ_list->ListOptions->Render("header", "left");
?>
<?php if ($cupon_categ->cct_id->Visible) { // cct_id ?>
	<?php if ($cupon_categ->SortUrl($cupon_categ->cct_id) == "") { ?>
		<td><?php echo $cupon_categ->cct_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cupon_categ->SortUrl($cupon_categ->cct_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon_categ->cct_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon_categ->cct_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon_categ->cct_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cupon_categ->cup_id->Visible) { // cup_id ?>
	<?php if ($cupon_categ->SortUrl($cupon_categ->cup_id) == "") { ?>
		<td><?php echo $cupon_categ->cup_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cupon_categ->SortUrl($cupon_categ->cup_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon_categ->cup_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon_categ->cup_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon_categ->cup_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cupon_categ->cat_id->Visible) { // cat_id ?>
	<?php if ($cupon_categ->SortUrl($cupon_categ->cat_id) == "") { ?>
		<td><?php echo $cupon_categ->cat_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cupon_categ->SortUrl($cupon_categ->cat_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cupon_categ->cat_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($cupon_categ->cat_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cupon_categ->cat_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cupon_categ_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($cupon_categ->ExportAll && $cupon_categ->Export <> "") {
	$cupon_categ_list->StopRec = $cupon_categ_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cupon_categ_list->TotalRecs > $cupon_categ_list->StartRec + $cupon_categ_list->DisplayRecs - 1)
		$cupon_categ_list->StopRec = $cupon_categ_list->StartRec + $cupon_categ_list->DisplayRecs - 1;
	else
		$cupon_categ_list->StopRec = $cupon_categ_list->TotalRecs;
}
$cupon_categ_list->RecCnt = $cupon_categ_list->StartRec - 1;
if ($cupon_categ_list->Recordset && !$cupon_categ_list->Recordset->EOF) {
	$cupon_categ_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $cupon_categ_list->StartRec > 1)
		$cupon_categ_list->Recordset->Move($cupon_categ_list->StartRec - 1);
} elseif (!$cupon_categ->AllowAddDeleteRow && $cupon_categ_list->StopRec == 0) {
	$cupon_categ_list->StopRec = $cupon_categ->GridAddRowCount;
}

// Initialize aggregate
$cupon_categ->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cupon_categ->ResetAttrs();
$cupon_categ_list->RenderRow();
$cupon_categ_list->RowCnt = 0;
while ($cupon_categ_list->RecCnt < $cupon_categ_list->StopRec) {
	$cupon_categ_list->RecCnt++;
	if (intval($cupon_categ_list->RecCnt) >= intval($cupon_categ_list->StartRec)) {
		$cupon_categ_list->RowCnt++;

		// Set up key count
		$cupon_categ_list->KeyCount = $cupon_categ_list->RowIndex;

		// Init row class and style
		$cupon_categ->ResetAttrs();
		$cupon_categ->CssClass = "";
		if ($cupon_categ->CurrentAction == "gridadd") {
			$cupon_categ_list->LoadDefaultValues(); // Load default values
		} else {
			$cupon_categ_list->LoadRowValues($cupon_categ_list->Recordset); // Load row values
		}
		$cupon_categ->RowType = EW_ROWTYPE_VIEW; // Render view
		$cupon_categ->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$cupon_categ_list->RenderRow();

		// Render list options
		$cupon_categ_list->RenderListOptions();
?>
	<tr<?php echo $cupon_categ->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cupon_categ_list->ListOptions->Render("body", "left");
?>
	<?php if ($cupon_categ->cct_id->Visible) { // cct_id ?>
		<td<?php echo $cupon_categ->cct_id->CellAttributes() ?>>
<div<?php echo $cupon_categ->cct_id->ViewAttributes() ?>><?php echo $cupon_categ->cct_id->ListViewValue() ?></div>
<a name="<?php echo $cupon_categ_list->PageObjName . "_row_" . $cupon_categ_list->RowCnt ?>" id="<?php echo $cupon_categ_list->PageObjName . "_row_" . $cupon_categ_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cupon_categ->cup_id->Visible) { // cup_id ?>
		<td<?php echo $cupon_categ->cup_id->CellAttributes() ?>>
<div<?php echo $cupon_categ->cup_id->ViewAttributes() ?>><?php echo $cupon_categ->cup_id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cupon_categ->cat_id->Visible) { // cat_id ?>
		<td<?php echo $cupon_categ->cat_id->CellAttributes() ?>>
<div<?php echo $cupon_categ->cat_id->ViewAttributes() ?>><?php echo $cupon_categ->cat_id->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cupon_categ_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($cupon_categ->CurrentAction <> "gridadd")
		$cupon_categ_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cupon_categ_list->Recordset)
	$cupon_categ_list->Recordset->Close();
?>
<?php if ($cupon_categ_list->TotalRecs > 0) { ?>
<?php if ($cupon_categ->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cupon_categ->CurrentAction <> "gridadd" && $cupon_categ->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($cupon_categ_list->Pager)) $cupon_categ_list->Pager = new cPrevNextPager($cupon_categ_list->StartRec, $cupon_categ_list->DisplayRecs, $cupon_categ_list->TotalRecs) ?>
<?php if ($cupon_categ_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cupon_categ_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_categ_list->PageUrl() ?>start=<?php echo $cupon_categ_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cupon_categ_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_categ_list->PageUrl() ?>start=<?php echo $cupon_categ_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cupon_categ_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cupon_categ_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_categ_list->PageUrl() ?>start=<?php echo $cupon_categ_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cupon_categ_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cupon_categ_list->PageUrl() ?>start=<?php echo $cupon_categ_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cupon_categ_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cupon_categ_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cupon_categ_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cupon_categ_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($cupon_categ_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $cupon_categ_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($cupon_categ_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fcupon_categlist, '<?php echo $cupon_categ_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($cupon_categ->Export == "" && $cupon_categ->CurrentAction == "") { ?>
<?php } ?>
<?php
$cupon_categ_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cupon_categ->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cupon_categ_list->Page_Terminate();
?>
<?php

//
// Page class
//
class ccupon_categ_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'cupon_categ';

	// Page object name
	var $PageObjName = 'cupon_categ_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cupon_categ;
		if ($cupon_categ->UseTokenInUrl) $PageUrl .= "t=" . $cupon_categ->TableVar . "&"; // Add page token
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
		global $objForm, $cupon_categ;
		if ($cupon_categ->UseTokenInUrl) {
			if ($objForm)
				return ($cupon_categ->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cupon_categ->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccupon_categ_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (cupon_categ)
		if (!isset($GLOBALS["cupon_categ"])) {
			$GLOBALS["cupon_categ"] = new ccupon_categ();
			$GLOBALS["Table"] =& $GLOBALS["cupon_categ"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cupon_categadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cupon_categdelete.php";
		$this->MultiUpdateUrl = "cupon_categupdate.php";

		// Table object (cupon)
		if (!isset($GLOBALS['cupon'])) $GLOBALS['cupon'] = new ccupon();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cupon_categ', TRUE);

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
		global $cupon_categ;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$cupon_categ->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$cupon_categ->Export = $_POST["exporttype"];
		} else {
			$cupon_categ->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $cupon_categ->Export; // Get export parameter, used in header
		$gsExportFile = $cupon_categ->TableVar; // Get export file, used in header
		$Charset = (EW_CHARSET <> "") ? ";charset=" . EW_CHARSET : ""; // Charset used in header
		if ($cupon_categ->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($cupon_categ->Export == "word") {
			header('Content-Type: application/vnd.ms-word' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.doc');
		}
		if ($cupon_categ->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$cupon_categ->GridAddRowCount = $gridaddcnt;

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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $cupon_categ;

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
			if ($cupon_categ->Export <> "" ||
				$cupon_categ->CurrentAction == "gridadd" ||
				$cupon_categ->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($cupon_categ->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $cupon_categ->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $cupon_categ->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $cupon_categ->getDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($cupon_categ->getMasterFilter() <> "" && $cupon_categ->getCurrentMasterTable() == "cupon") {
			global $cupon;
			$rsmaster = $cupon->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate($cupon_categ->getReturnUrl()); // Return to caller
			} else {
				$cupon->LoadListRowValues($rsmaster);
				$cupon->RowType = EW_ROWTYPE_MASTER; // Master row
				$cupon->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$cupon_categ->setSessionWhere($sFilter);
		$cupon_categ->CurrentFilter = "";

		// Export data only
		if (in_array($cupon_categ->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($cupon_categ->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $cupon_categ;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$cupon_categ->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$cupon_categ->CurrentOrderType = @$_GET["ordertype"];
			$cupon_categ->UpdateSort($cupon_categ->cct_id); // cct_id
			$cupon_categ->UpdateSort($cupon_categ->cup_id); // cup_id
			$cupon_categ->UpdateSort($cupon_categ->cat_id); // cat_id
			$cupon_categ->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $cupon_categ;
		$sOrderBy = $cupon_categ->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($cupon_categ->SqlOrderBy() <> "") {
				$sOrderBy = $cupon_categ->SqlOrderBy();
				$cupon_categ->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $cupon_categ;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset master/detail keys
			if (strtolower($sCmd) == "resetall") {
				$cupon_categ->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$cupon_categ->cup_id->setSessionValue("");
			}

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$cupon_categ->setSessionOrderBy($sOrderBy);
				$cupon_categ->cct_id->setSort("");
				$cupon_categ->cup_id->setSort("");
				$cupon_categ->cat_id->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$cupon_categ->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $cupon_categ;

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
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"cupon_categ_list.SelectAllKey(this);\">";
		$item->MoveTo(0);

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $cupon_categ, $objForm;
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
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($cupon_categ->cct_id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $cupon_categ;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $cupon_categ;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$cupon_categ->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$cupon_categ->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $cupon_categ->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$cupon_categ->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$cupon_categ->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$cupon_categ->setStartRecordNumber($this->StartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $cupon_categ;

		// Call Recordset Selecting event
		$cupon_categ->Recordset_Selecting($cupon_categ->CurrentFilter);

		// Load List page SQL
		$sSql = $cupon_categ->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$cupon_categ->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cupon_categ;
		$sFilter = $cupon_categ->KeyFilter();

		// Call Row Selecting event
		$cupon_categ->Row_Selecting($sFilter);

		// Load SQL based on filter
		$cupon_categ->CurrentFilter = $sFilter;
		$sSql = $cupon_categ->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$cupon_categ->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $cupon_categ;
		if (!$rs || $rs->EOF) return;
		$cupon_categ->cct_id->setDbValue($rs->fields('cct_id'));
		$cupon_categ->cup_id->setDbValue($rs->fields('cup_id'));
		$cupon_categ->cat_id->setDbValue($rs->fields('cat_id'));
	}

	// Load old record
	function LoadOldRecord() {
		global $cupon_categ;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($cupon_categ->getKey("cct_id")) <> "")
			$cupon_categ->cct_id->CurrentValue = $cupon_categ->getKey("cct_id"); // cct_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$cupon_categ->CurrentFilter = $cupon_categ->KeyFilter();
			$sSql = $cupon_categ->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $cupon_categ;

		// Initialize URLs
		$this->ViewUrl = $cupon_categ->ViewUrl();
		$this->EditUrl = $cupon_categ->EditUrl();
		$this->InlineEditUrl = $cupon_categ->InlineEditUrl();
		$this->CopyUrl = $cupon_categ->CopyUrl();
		$this->InlineCopyUrl = $cupon_categ->InlineCopyUrl();
		$this->DeleteUrl = $cupon_categ->DeleteUrl();

		// Call Row_Rendering event
		$cupon_categ->Row_Rendering();

		// Common render codes for all row types
		// cct_id
		// cup_id
		// cat_id

		if ($cupon_categ->RowType == EW_ROWTYPE_VIEW) { // View row

			// cct_id
			$cupon_categ->cct_id->ViewValue = $cupon_categ->cct_id->CurrentValue;
			$cupon_categ->cct_id->ViewCustomAttributes = "";

			// cup_id
			if (strval($cupon_categ->cup_id->CurrentValue) <> "") {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($cupon_categ->cup_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cup_nombre` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$cupon_categ->cup_id->ViewValue = $rswrk->fields('cup_nombre');
					$rswrk->Close();
				} else {
					$cupon_categ->cup_id->ViewValue = $cupon_categ->cup_id->CurrentValue;
				}
			} else {
				$cupon_categ->cup_id->ViewValue = NULL;
			}
			$cupon_categ->cup_id->ViewCustomAttributes = "";

			// cat_id
			if (strval($cupon_categ->cat_id->CurrentValue) <> "") {
				$sFilterWrk = "`cat_id` = " . ew_AdjustSql($cupon_categ->cat_id->CurrentValue) . "";
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
					$cupon_categ->cat_id->ViewValue = $rswrk->fields('cat_nombre');
					$rswrk->Close();
				} else {
					$cupon_categ->cat_id->ViewValue = $cupon_categ->cat_id->CurrentValue;
				}
			} else {
				$cupon_categ->cat_id->ViewValue = NULL;
			}
			$cupon_categ->cat_id->ViewCustomAttributes = "";

			// cct_id
			$cupon_categ->cct_id->LinkCustomAttributes = "";
			$cupon_categ->cct_id->HrefValue = "";
			$cupon_categ->cct_id->TooltipValue = "";

			// cup_id
			$cupon_categ->cup_id->LinkCustomAttributes = "";
			$cupon_categ->cup_id->HrefValue = "";
			$cupon_categ->cup_id->TooltipValue = "";

			// cat_id
			$cupon_categ->cat_id->LinkCustomAttributes = "";
			$cupon_categ->cat_id->HrefValue = "";
			$cupon_categ->cat_id->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($cupon_categ->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$cupon_categ->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language, $cupon_categ;

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
		$item->Visible = FALSE;

		// Export to Email
		$item =& $this->ExportOptions->Add("email");
		$item->Body = "<a name=\"emf_cupon_categ\" id=\"emf_cupon_categ\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_cupon_categ',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcupon_categlist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($cupon_categ->Export <> "" ||
			$cupon_categ->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $cupon_categ;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $cupon_categ->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($cupon_categ->ExportAll) {
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
		if ($cupon_categ->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($cupon_categ, "h");
		}
		$ParentTable = "";

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $cupon_categ->getMasterFilter() <> "" && $cupon_categ->getCurrentMasterTable() == "cupon") {
			global $cupon;
			$rsmaster = $cupon->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				if ($cupon_categ->Export == "xml") {
					$ParentTable = "cupon";
					$cupon->ExportXmlDocument($XmlDoc, '', $rsmaster, 1, 1);
				} else {
					$ExportStyle = $ExportDoc->Style;
					$ExportDoc->ChangeStyle("v"); // Change to vertical
					if ($cupon_categ->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
						$cupon->ExportDocument($ExportDoc, $rsmaster, 1, 1);
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
		if ($cupon_categ->Export == "xml") {
			$cupon_categ->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$cupon_categ->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
			$sFooter = $this->PageFooter;
			$this->Page_DataRendered($sFooter);
			$ExportDoc->Text .= $sFooter;
		}

		// Close recordset
		$rs->Close();

		// Export header and footer
		if ($cupon_categ->Export <> "xml") {
			$ExportDoc->ExportHeaderAndFooter();
		}

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($cupon_categ->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($cupon_categ->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($cupon_categ->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($cupon_categ->ExportReturnUrl());
		} elseif ($cupon_categ->Export == "pdf") {
			$this->ExportPDF($ExportDoc->Text);
		} else {
			echo $ExportDoc->Text;
		}
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		global $cupon_categ;
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (@$_GET[EW_TABLE_SHOW_MASTER] <> "") {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "cupon") {
				$bValidMaster = TRUE;
				if (@$_GET["cup_id"] <> "") {
					$GLOBALS["cupon"]->cup_id->setQueryStringValue($_GET["cup_id"]);
					$cupon_categ->cup_id->setQueryStringValue($GLOBALS["cupon"]->cup_id->QueryStringValue);
					$cupon_categ->cup_id->setSessionValue($cupon_categ->cup_id->QueryStringValue);
					if (!is_numeric($GLOBALS["cupon"]->cup_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$cupon_categ->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$cupon_categ->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "cupon") {
				if ($cupon_categ->cup_id->QueryStringValue == "") $cupon_categ->cup_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $cupon_categ->getMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $cupon_categ->getDetailFilter(); // Get detail filter
	}

	// Export PDF
	function ExportPDF($html) {
		global $gsExportFile;
		include_once "dompdf060b2/dompdf_config.inc.php";
		@ini_set("memory_limit", EW_PDF_MEMORY_LIMIT);
		set_time_limit(EW_PDF_TIME_LIMIT);
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper("a4", "portrait");
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
