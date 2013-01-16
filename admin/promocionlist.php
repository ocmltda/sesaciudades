<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "promocioninfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$promocion_list = new cpromocion_list();
$Page =& $promocion_list;

// Page init
$promocion_list->Page_Init();

// Page main
$promocion_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($promocion->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var promocion_list = new ew_Page("promocion_list");

// page properties
promocion_list.PageID = "list"; // page ID
promocion_list.FormID = "fpromocionlist"; // form ID
var EW_PAGE_ID = promocion_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
promocion_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
promocion_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
promocion_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
promocion_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($promocion->Export == "") || (EW_EXPORT_MASTER_RECORD && $promocion->Export == "print")) { ?>
<?php } ?>
<?php $promocion_list->ShowPageHeader(); ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$promocion_list->TotalRecs = $promocion->SelectRecordCount();
	} else {
		if ($promocion_list->Recordset = $promocion_list->LoadRecordset())
			$promocion_list->TotalRecs = $promocion_list->Recordset->RecordCount();
	}
	$promocion_list->StartRec = 1;
	if ($promocion_list->DisplayRecs <= 0 || ($promocion->Export <> "" && $promocion->ExportAll)) // Display all records
		$promocion_list->DisplayRecs = $promocion_list->TotalRecs;
	if (!($promocion->Export <> "" && $promocion->ExportAll))
		$promocion_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$promocion_list->Recordset = $promocion_list->LoadRecordset($promocion_list->StartRec-1, $promocion_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $promocion->TableCaption() ?>
&nbsp;&nbsp;<?php $promocion_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($promocion->Export == "" && $promocion->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(promocion_list);" style="text-decoration: none;"><img id="promocion_list_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="promocion_list_SearchPanel">
<form name="fpromocionlistsrch" id="fpromocionlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="promocion">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewCssTableRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($promocion->getSessionBasicSearchKeyword()) ?>">
	<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $promocion_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewCssTableRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($promocion->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($promocion->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($promocion->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
$promocion_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($promocion->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($promocion->CurrentAction <> "gridadd" && $promocion->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($promocion_list->Pager)) $promocion_list->Pager = new cPrevNextPager($promocion_list->StartRec, $promocion_list->DisplayRecs, $promocion_list->TotalRecs) ?>
<?php if ($promocion_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($promocion_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $promocion_list->PageUrl() ?>start=<?php echo $promocion_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($promocion_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $promocion_list->PageUrl() ?>start=<?php echo $promocion_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $promocion_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($promocion_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $promocion_list->PageUrl() ?>start=<?php echo $promocion_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($promocion_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $promocion_list->PageUrl() ?>start=<?php echo $promocion_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $promocion_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $promocion_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $promocion_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $promocion_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($promocion_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $promocion_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($promocion_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fpromocionlist, '<?php echo $promocion_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fpromocionlist" id="fpromocionlist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="promocion">
<div id="gmp_promocion" class="ewGridMiddlePanel">
<?php if ($promocion_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $promocion->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$promocion_list->RenderListOptions();

// Render list options (header, left)
$promocion_list->ListOptions->Render("header", "left");
?>
<?php if ($promocion->pro_id->Visible) { // pro_id ?>
	<?php if ($promocion->SortUrl($promocion->pro_id) == "") { ?>
		<td><?php echo $promocion->pro_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $promocion->SortUrl($promocion->pro_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $promocion->pro_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($promocion->pro_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($promocion->pro_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($promocion->pro_titulo->Visible) { // pro_titulo ?>
	<?php if ($promocion->SortUrl($promocion->pro_titulo) == "") { ?>
		<td><?php echo $promocion->pro_titulo->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $promocion->SortUrl($promocion->pro_titulo) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $promocion->pro_titulo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($promocion->pro_titulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($promocion->pro_titulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($promocion->pro_imagen_nombre->Visible) { // pro_imagen_nombre ?>
	<?php if ($promocion->SortUrl($promocion->pro_imagen_nombre) == "") { ?>
		<td><?php echo $promocion->pro_imagen_nombre->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $promocion->SortUrl($promocion->pro_imagen_nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $promocion->pro_imagen_nombre->FldCaption() ?></td><td style="width: 10px;"><?php if ($promocion->pro_imagen_nombre->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($promocion->pro_imagen_nombre->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($promocion->pro_vigente->Visible) { // pro_vigente ?>
	<?php if ($promocion->SortUrl($promocion->pro_vigente) == "") { ?>
		<td><?php echo $promocion->pro_vigente->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $promocion->SortUrl($promocion->pro_vigente) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $promocion->pro_vigente->FldCaption() ?></td><td style="width: 10px;"><?php if ($promocion->pro_vigente->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($promocion->pro_vigente->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$promocion_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($promocion->ExportAll && $promocion->Export <> "") {
	$promocion_list->StopRec = $promocion_list->TotalRecs;
} else {

	// Set the last record to display
	if ($promocion_list->TotalRecs > $promocion_list->StartRec + $promocion_list->DisplayRecs - 1)
		$promocion_list->StopRec = $promocion_list->StartRec + $promocion_list->DisplayRecs - 1;
	else
		$promocion_list->StopRec = $promocion_list->TotalRecs;
}
$promocion_list->RecCnt = $promocion_list->StartRec - 1;
if ($promocion_list->Recordset && !$promocion_list->Recordset->EOF) {
	$promocion_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $promocion_list->StartRec > 1)
		$promocion_list->Recordset->Move($promocion_list->StartRec - 1);
} elseif (!$promocion->AllowAddDeleteRow && $promocion_list->StopRec == 0) {
	$promocion_list->StopRec = $promocion->GridAddRowCount;
}

// Initialize aggregate
$promocion->RowType = EW_ROWTYPE_AGGREGATEINIT;
$promocion->ResetAttrs();
$promocion_list->RenderRow();
$promocion_list->RowCnt = 0;
while ($promocion_list->RecCnt < $promocion_list->StopRec) {
	$promocion_list->RecCnt++;
	if (intval($promocion_list->RecCnt) >= intval($promocion_list->StartRec)) {
		$promocion_list->RowCnt++;

		// Set up key count
		$promocion_list->KeyCount = $promocion_list->RowIndex;

		// Init row class and style
		$promocion->ResetAttrs();
		$promocion->CssClass = "";
		if ($promocion->CurrentAction == "gridadd") {
			$promocion_list->LoadDefaultValues(); // Load default values
		} else {
			$promocion_list->LoadRowValues($promocion_list->Recordset); // Load row values
		}
		$promocion->RowType = EW_ROWTYPE_VIEW; // Render view
		$promocion->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$promocion_list->RenderRow();

		// Render list options
		$promocion_list->RenderListOptions();
?>
	<tr<?php echo $promocion->RowAttributes() ?>>
<?php

// Render list options (body, left)
$promocion_list->ListOptions->Render("body", "left");
?>
	<?php if ($promocion->pro_id->Visible) { // pro_id ?>
		<td<?php echo $promocion->pro_id->CellAttributes() ?>>
<div<?php echo $promocion->pro_id->ViewAttributes() ?>><?php echo $promocion->pro_id->ListViewValue() ?></div>
<a name="<?php echo $promocion_list->PageObjName . "_row_" . $promocion_list->RowCnt ?>" id="<?php echo $promocion_list->PageObjName . "_row_" . $promocion_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($promocion->pro_titulo->Visible) { // pro_titulo ?>
		<td<?php echo $promocion->pro_titulo->CellAttributes() ?>>
<div<?php echo $promocion->pro_titulo->ViewAttributes() ?>><?php echo $promocion->pro_titulo->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($promocion->pro_imagen_nombre->Visible) { // pro_imagen_nombre ?>
		<td<?php echo $promocion->pro_imagen_nombre->CellAttributes() ?>>
<?php if ($promocion->pro_imagen_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($promocion->pro_imagen_nombre->Upload->DbValue)) { ?>
<a<?php echo $promocion->pro_imagen_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $promocion->pro_imagen_nombre->UploadPath) . $promocion->pro_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $promocion->pro_imagen_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($promocion->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($promocion->pro_imagen_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $promocion->pro_imagen_nombre->UploadPath) . $promocion->pro_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $promocion->pro_imagen_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($promocion->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($promocion->pro_vigente->Visible) { // pro_vigente ?>
		<td<?php echo $promocion->pro_vigente->CellAttributes() ?>>
<div<?php echo $promocion->pro_vigente->ViewAttributes() ?>><?php echo $promocion->pro_vigente->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$promocion_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($promocion->CurrentAction <> "gridadd")
		$promocion_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($promocion_list->Recordset)
	$promocion_list->Recordset->Close();
?>
<?php if ($promocion_list->TotalRecs > 0) { ?>
<?php if ($promocion->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($promocion->CurrentAction <> "gridadd" && $promocion->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($promocion_list->Pager)) $promocion_list->Pager = new cPrevNextPager($promocion_list->StartRec, $promocion_list->DisplayRecs, $promocion_list->TotalRecs) ?>
<?php if ($promocion_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($promocion_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $promocion_list->PageUrl() ?>start=<?php echo $promocion_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($promocion_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $promocion_list->PageUrl() ?>start=<?php echo $promocion_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $promocion_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($promocion_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $promocion_list->PageUrl() ?>start=<?php echo $promocion_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($promocion_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $promocion_list->PageUrl() ?>start=<?php echo $promocion_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $promocion_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $promocion_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $promocion_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $promocion_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($promocion_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $promocion_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($promocion_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fpromocionlist, '<?php echo $promocion_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($promocion->Export == "" && $promocion->CurrentAction == "") { ?>
<?php } ?>
<?php
$promocion_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($promocion->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$promocion_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cpromocion_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'promocion';

	// Page object name
	var $PageObjName = 'promocion_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $promocion;
		if ($promocion->UseTokenInUrl) $PageUrl .= "t=" . $promocion->TableVar . "&"; // Add page token
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
		global $objForm, $promocion;
		if ($promocion->UseTokenInUrl) {
			if ($objForm)
				return ($promocion->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($promocion->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cpromocion_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (promocion)
		if (!isset($GLOBALS["promocion"])) {
			$GLOBALS["promocion"] = new cpromocion();
			$GLOBALS["Table"] =& $GLOBALS["promocion"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "promocionadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "promociondelete.php";
		$this->MultiUpdateUrl = "promocionupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'promocion', TRUE);

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
		global $promocion;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$promocion->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$promocion->Export = $_POST["exporttype"];
		} else {
			$promocion->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $promocion->Export; // Get export parameter, used in header
		$gsExportFile = $promocion->TableVar; // Get export file, used in header
		$Charset = (EW_CHARSET <> "") ? ";charset=" . EW_CHARSET : ""; // Charset used in header
		if ($promocion->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($promocion->Export == "word") {
			header('Content-Type: application/vnd.ms-word' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.doc');
		}
		if ($promocion->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$promocion->GridAddRowCount = $gridaddcnt;

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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $promocion;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Hide all options
			if ($promocion->Export <> "" ||
				$promocion->CurrentAction == "gridadd" ||
				$promocion->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$promocion->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($promocion->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $promocion->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$promocion->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$promocion->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$promocion->setStartRecordNumber($this->StartRec);
			}
		} else {
			$this->SearchWhere = $promocion->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$promocion->setSessionWhere($sFilter);
		$promocion->CurrentFilter = "";

		// Export data only
		if (in_array($promocion->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($promocion->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $promocion;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $promocion->pro_titulo, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $promocion->pro_texto, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $promocion->pro_imagen_nombre, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $promocion->pro_imagen_tipo, $Keyword);
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
		global $Security, $promocion;
		$sSearchStr = "";
		$sSearchKeyword = $promocion->BasicSearchKeyword;
		$sSearchType = $promocion->BasicSearchType;
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
			$promocion->setSessionBasicSearchKeyword($sSearchKeyword);
			$promocion->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $promocion;

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$promocion->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $promocion;
		$promocion->setSessionBasicSearchKeyword("");
		$promocion->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $promocion;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$promocion->BasicSearchKeyword = $promocion->getSessionBasicSearchKeyword();
			$promocion->BasicSearchType = $promocion->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $promocion;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$promocion->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$promocion->CurrentOrderType = @$_GET["ordertype"];
			$promocion->UpdateSort($promocion->pro_id); // pro_id
			$promocion->UpdateSort($promocion->pro_titulo); // pro_titulo
			$promocion->UpdateSort($promocion->pro_imagen_nombre); // pro_imagen_nombre
			$promocion->UpdateSort($promocion->pro_vigente); // pro_vigente
			$promocion->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $promocion;
		$sOrderBy = $promocion->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($promocion->SqlOrderBy() <> "") {
				$sOrderBy = $promocion->SqlOrderBy();
				$promocion->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $promocion;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$promocion->setSessionOrderBy($sOrderBy);
				$promocion->pro_id->setSort("");
				$promocion->pro_titulo->setSort("");
				$promocion->pro_imagen_nombre->setSort("");
				$promocion->pro_vigente->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$promocion->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $promocion;

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
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"promocion_list.SelectAllKey(this);\">";
		$item->MoveTo(0);

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $promocion, $objForm;
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
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($promocion->pro_id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $promocion;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $promocion;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$promocion->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$promocion->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $promocion->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$promocion->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$promocion->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$promocion->setStartRecordNumber($this->StartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $promocion;
		$promocion->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$promocion->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $promocion;

		// Call Recordset Selecting event
		$promocion->Recordset_Selecting($promocion->CurrentFilter);

		// Load List page SQL
		$sSql = $promocion->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$promocion->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $promocion;
		$sFilter = $promocion->KeyFilter();

		// Call Row Selecting event
		$promocion->Row_Selecting($sFilter);

		// Load SQL based on filter
		$promocion->CurrentFilter = $sFilter;
		$sSql = $promocion->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$promocion->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $promocion;
		if (!$rs || $rs->EOF) return;
		$promocion->pro_id->setDbValue($rs->fields('pro_id'));
		$promocion->pro_titulo->setDbValue($rs->fields('pro_titulo'));
		$promocion->pro_texto->setDbValue($rs->fields('pro_texto'));
		$promocion->pro_imagen_nombre->Upload->DbValue = $rs->fields('pro_imagen_nombre');
		$promocion->pro_imagen_tipo->setDbValue($rs->fields('pro_imagen_tipo'));
		$promocion->pro_imagen_ancho->setDbValue($rs->fields('pro_imagen_ancho'));
		$promocion->pro_imagen_alto->setDbValue($rs->fields('pro_imagen_alto'));
		$promocion->pro_imagen_size->setDbValue($rs->fields('pro_imagen_size'));
		$promocion->pro_vigente->setDbValue($rs->fields('pro_vigente'));
	}

	// Load old record
	function LoadOldRecord() {
		global $promocion;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($promocion->getKey("pro_id")) <> "")
			$promocion->pro_id->CurrentValue = $promocion->getKey("pro_id"); // pro_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$promocion->CurrentFilter = $promocion->KeyFilter();
			$sSql = $promocion->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $promocion;

		// Initialize URLs
		$this->ViewUrl = $promocion->ViewUrl();
		$this->EditUrl = $promocion->EditUrl();
		$this->InlineEditUrl = $promocion->InlineEditUrl();
		$this->CopyUrl = $promocion->CopyUrl();
		$this->InlineCopyUrl = $promocion->InlineCopyUrl();
		$this->DeleteUrl = $promocion->DeleteUrl();

		// Call Row_Rendering event
		$promocion->Row_Rendering();

		// Common render codes for all row types
		// pro_id
		// pro_titulo
		// pro_texto
		// pro_imagen_nombre
		// pro_imagen_tipo
		// pro_imagen_ancho
		// pro_imagen_alto
		// pro_imagen_size
		// pro_vigente

		if ($promocion->RowType == EW_ROWTYPE_VIEW) { // View row

			// pro_id
			$promocion->pro_id->ViewValue = $promocion->pro_id->CurrentValue;
			$promocion->pro_id->ViewCustomAttributes = "";

			// pro_titulo
			$promocion->pro_titulo->ViewValue = $promocion->pro_titulo->CurrentValue;
			$promocion->pro_titulo->ViewCustomAttributes = "";

			// pro_imagen_nombre
			if (!ew_Empty($promocion->pro_imagen_nombre->Upload->DbValue)) {
				$promocion->pro_imagen_nombre->ViewValue = $promocion->pro_imagen_nombre->Upload->DbValue;
				$promocion->pro_imagen_nombre->ImageWidth = 100;
				$promocion->pro_imagen_nombre->ImageHeight = 0;
				$promocion->pro_imagen_nombre->ImageAlt = $promocion->pro_imagen_nombre->FldAlt();
			} else {
				$promocion->pro_imagen_nombre->ViewValue = "";
			}
			$promocion->pro_imagen_nombre->ViewCustomAttributes = "";

			// pro_imagen_ancho
			$promocion->pro_imagen_ancho->ViewValue = $promocion->pro_imagen_ancho->CurrentValue;
			$promocion->pro_imagen_ancho->ViewValue = ew_FormatNumber($promocion->pro_imagen_ancho->ViewValue, 0, -2, -2, -2);
			$promocion->pro_imagen_ancho->ViewCustomAttributes = "";

			// pro_imagen_alto
			$promocion->pro_imagen_alto->ViewValue = $promocion->pro_imagen_alto->CurrentValue;
			$promocion->pro_imagen_alto->ViewValue = ew_FormatNumber($promocion->pro_imagen_alto->ViewValue, 0, -2, -2, -2);
			$promocion->pro_imagen_alto->ViewCustomAttributes = "";

			// pro_vigente
			if (strval($promocion->pro_vigente->CurrentValue) <> "") {
				switch ($promocion->pro_vigente->CurrentValue) {
					case "1":
						$promocion->pro_vigente->ViewValue = $promocion->pro_vigente->FldTagCaption(1) <> "" ? $promocion->pro_vigente->FldTagCaption(1) : $promocion->pro_vigente->CurrentValue;
						break;
					case "0":
						$promocion->pro_vigente->ViewValue = $promocion->pro_vigente->FldTagCaption(2) <> "" ? $promocion->pro_vigente->FldTagCaption(2) : $promocion->pro_vigente->CurrentValue;
						break;
					default:
						$promocion->pro_vigente->ViewValue = $promocion->pro_vigente->CurrentValue;
				}
			} else {
				$promocion->pro_vigente->ViewValue = NULL;
			}
			$promocion->pro_vigente->ViewCustomAttributes = "";

			// pro_id
			$promocion->pro_id->LinkCustomAttributes = "";
			$promocion->pro_id->HrefValue = "";
			$promocion->pro_id->TooltipValue = "";

			// pro_titulo
			$promocion->pro_titulo->LinkCustomAttributes = "";
			$promocion->pro_titulo->HrefValue = "";
			$promocion->pro_titulo->TooltipValue = "";

			// pro_imagen_nombre
			$promocion->pro_imagen_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($promocion->pro_imagen_nombre->Upload->DbValue)) {
				$promocion->pro_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $promocion->pro_imagen_nombre->UploadPath) . ((!empty($promocion->pro_imagen_nombre->ViewValue)) ? $promocion->pro_imagen_nombre->ViewValue : $promocion->pro_imagen_nombre->CurrentValue); // Add prefix/suffix
				$promocion->pro_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($promocion->Export <> "") $promocion->pro_imagen_nombre->HrefValue = ew_ConvertFullUrl($promocion->pro_imagen_nombre->HrefValue);
			} else {
				$promocion->pro_imagen_nombre->HrefValue = "";
			}
			$promocion->pro_imagen_nombre->TooltipValue = "";

			// pro_vigente
			$promocion->pro_vigente->LinkCustomAttributes = "";
			$promocion->pro_vigente->HrefValue = "";
			$promocion->pro_vigente->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($promocion->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$promocion->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language, $promocion;

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
		$item->Body = "<a name=\"emf_promocion\" id=\"emf_promocion\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_promocion',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fpromocionlist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($promocion->Export <> "" ||
			$promocion->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $promocion;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $promocion->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($promocion->ExportAll) {
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
		if ($promocion->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($promocion, "h");
		}
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		if ($promocion->Export == "xml") {
			$promocion->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$promocion->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
			$sFooter = $this->PageFooter;
			$this->Page_DataRendered($sFooter);
			$ExportDoc->Text .= $sFooter;
		}

		// Close recordset
		$rs->Close();

		// Export header and footer
		if ($promocion->Export <> "xml") {
			$ExportDoc->ExportHeaderAndFooter();
		}

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($promocion->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($promocion->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($promocion->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($promocion->ExportReturnUrl());
		} elseif ($promocion->Export == "pdf") {
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
