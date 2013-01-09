<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "localadheridoinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$localadherido_list = new clocaladherido_list();
$Page =& $localadherido_list;

// Page init
$localadherido_list->Page_Init();

// Page main
$localadherido_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($localadherido->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var localadherido_list = new ew_Page("localadherido_list");

// page properties
localadherido_list.PageID = "list"; // page ID
localadherido_list.FormID = "flocaladheridolist"; // form ID
var EW_PAGE_ID = localadherido_list.PageID; // for backward compatibility

// extend page with validate function for search
localadherido_list.ValidateSearch = function(fobj) {
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
localadherido_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
localadherido_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
localadherido_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
localadherido_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($localadherido->Export == "") || (EW_EXPORT_MASTER_RECORD && $localadherido->Export == "print")) { ?>
<?php } ?>
<?php $localadherido_list->ShowPageHeader(); ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$localadherido_list->TotalRecs = $localadherido->SelectRecordCount();
	} else {
		if ($localadherido_list->Recordset = $localadherido_list->LoadRecordset())
			$localadherido_list->TotalRecs = $localadherido_list->Recordset->RecordCount();
	}
	$localadherido_list->StartRec = 1;
	if ($localadherido_list->DisplayRecs <= 0 || ($localadherido->Export <> "" && $localadherido->ExportAll)) // Display all records
		$localadherido_list->DisplayRecs = $localadherido_list->TotalRecs;
	if (!($localadherido->Export <> "" && $localadherido->ExportAll))
		$localadherido_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$localadherido_list->Recordset = $localadherido_list->LoadRecordset($localadherido_list->StartRec-1, $localadherido_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $localadherido->TableCaption() ?>
&nbsp;&nbsp;<?php $localadherido_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($localadherido->Export == "" && $localadherido->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(localadherido_list);" style="text-decoration: none;"><img id="localadherido_list_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="localadherido_list_SearchPanel">
<form name="flocaladheridolistsrch" id="flocaladheridolistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>" onsubmit="return localadherido_list.ValidateSearch(this);">
<input type="hidden" id="t" name="t" value="localadherido">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$localadherido_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$localadherido->RowType = EW_ROWTYPE_SEARCH;

// Render row
$localadherido->ResetAttrs();
$localadherido_list->RenderRow();
?>
<div id="xsr_1" class="ewCssTableRow">
	<span id="xsc_emp_id" class="ewCssTableCell">
		<span class="ewSearchCaption"><?php echo $localadherido->emp_id->FldCaption() ?></span>
		<span class="ewSearchOprCell"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_emp_id" id="z_emp_id" value="="></span>
		<span class="ewSearchField">
<?php $localadherido->emp_id->EditAttrs["onchange"] = "ew_UpdateOpt('x_cup_id','x_emp_id',true); " . @$localadherido->emp_id->EditAttrs["onchange"]; ?>
<select id="x_emp_id" name="x_emp_id"<?php echo $localadherido->emp_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->emp_id->EditValue)) {
	$arwrk = $localadherido->emp_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->emp_id->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,1,$localadherido->emp_id) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `emp_id`, `emp_nomfantasia` AS `DispFld`, `emp_rut` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `emp_nomfantasia` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x_emp_id" id="s_x_emp_id" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x_emp_id" id="lft_x_emp_id" value="">
</span>
	</span>
</div>
<div id="xsr_2" class="ewCssTableRow">
	<span id="xsc_cup_id" class="ewCssTableCell">
		<span class="ewSearchCaption"><?php echo $localadherido->cup_id->FldCaption() ?></span>
		<span class="ewSearchOprCell"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_cup_id" id="z_cup_id" value="="></span>
		<span class="ewSearchField">
<select id="x_cup_id" name="x_cup_id"<?php echo $localadherido->cup_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->cup_id->EditValue)) {
	$arwrk = $localadherido->cup_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->cup_id->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `cup_id`, `cup_nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cupon`";
$sWhereWrk = "`emp_id` IN ({filter_value})";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `cup_nombre` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x_cup_id" id="s_x_cup_id" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x_cup_id" id="lft_x_cup_id" value="1">
</span>
	</span>
</div>
<div id="xsr_3" class="ewCssTableRow">
	<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $localadherido_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
</div>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
$localadherido_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($localadherido->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($localadherido->CurrentAction <> "gridadd" && $localadherido->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($localadherido_list->Pager)) $localadherido_list->Pager = new cPrevNextPager($localadherido_list->StartRec, $localadherido_list->DisplayRecs, $localadherido_list->TotalRecs) ?>
<?php if ($localadherido_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($localadherido_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $localadherido_list->PageUrl() ?>start=<?php echo $localadherido_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($localadherido_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $localadherido_list->PageUrl() ?>start=<?php echo $localadherido_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $localadherido_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($localadherido_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $localadherido_list->PageUrl() ?>start=<?php echo $localadherido_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($localadherido_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $localadherido_list->PageUrl() ?>start=<?php echo $localadherido_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $localadherido_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $localadherido_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $localadherido_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $localadherido_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($localadherido_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $localadherido_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($localadherido_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.flocaladheridolist, '<?php echo $localadherido_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="flocaladheridolist" id="flocaladheridolist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="localadherido">
<div id="gmp_localadherido" class="ewGridMiddlePanel">
<?php if ($localadherido_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $localadherido->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$localadherido_list->RenderListOptions();

// Render list options (header, left)
$localadherido_list->ListOptions->Render("header", "left");
?>
<?php if ($localadherido->lad_id->Visible) { // lad_id ?>
	<?php if ($localadherido->SortUrl($localadherido->lad_id) == "") { ?>
		<td><?php echo $localadherido->lad_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $localadherido->SortUrl($localadherido->lad_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $localadherido->lad_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($localadherido->lad_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($localadherido->lad_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($localadherido->emp_id->Visible) { // emp_id ?>
	<?php if ($localadherido->SortUrl($localadherido->emp_id) == "") { ?>
		<td><?php echo $localadherido->emp_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $localadherido->SortUrl($localadherido->emp_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $localadherido->emp_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($localadherido->emp_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($localadherido->emp_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($localadherido->cup_id->Visible) { // cup_id ?>
	<?php if ($localadherido->SortUrl($localadherido->cup_id) == "") { ?>
		<td><?php echo $localadherido->cup_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $localadherido->SortUrl($localadherido->cup_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $localadherido->cup_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($localadherido->cup_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($localadherido->cup_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($localadherido->loc_id->Visible) { // loc_id ?>
	<?php if ($localadherido->SortUrl($localadherido->loc_id) == "") { ?>
		<td><?php echo $localadherido->loc_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $localadherido->SortUrl($localadherido->loc_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $localadherido->loc_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($localadherido->loc_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($localadherido->loc_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$localadherido_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($localadherido->ExportAll && $localadherido->Export <> "") {
	$localadherido_list->StopRec = $localadherido_list->TotalRecs;
} else {

	// Set the last record to display
	if ($localadherido_list->TotalRecs > $localadherido_list->StartRec + $localadherido_list->DisplayRecs - 1)
		$localadherido_list->StopRec = $localadherido_list->StartRec + $localadherido_list->DisplayRecs - 1;
	else
		$localadherido_list->StopRec = $localadherido_list->TotalRecs;
}
$localadherido_list->RecCnt = $localadherido_list->StartRec - 1;
if ($localadherido_list->Recordset && !$localadherido_list->Recordset->EOF) {
	$localadherido_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $localadherido_list->StartRec > 1)
		$localadherido_list->Recordset->Move($localadherido_list->StartRec - 1);
} elseif (!$localadherido->AllowAddDeleteRow && $localadherido_list->StopRec == 0) {
	$localadherido_list->StopRec = $localadherido->GridAddRowCount;
}

// Initialize aggregate
$localadherido->RowType = EW_ROWTYPE_AGGREGATEINIT;
$localadherido->ResetAttrs();
$localadherido_list->RenderRow();
$localadherido_list->RowCnt = 0;
while ($localadherido_list->RecCnt < $localadherido_list->StopRec) {
	$localadherido_list->RecCnt++;
	if (intval($localadherido_list->RecCnt) >= intval($localadherido_list->StartRec)) {
		$localadherido_list->RowCnt++;

		// Set up key count
		$localadherido_list->KeyCount = $localadherido_list->RowIndex;

		// Init row class and style
		$localadherido->ResetAttrs();
		$localadherido->CssClass = "";
		if ($localadherido->CurrentAction == "gridadd") {
			$localadherido_list->LoadDefaultValues(); // Load default values
		} else {
			$localadherido_list->LoadRowValues($localadherido_list->Recordset); // Load row values
		}
		$localadherido->RowType = EW_ROWTYPE_VIEW; // Render view
		$localadherido->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$localadherido_list->RenderRow();

		// Render list options
		$localadherido_list->RenderListOptions();
?>
	<tr<?php echo $localadherido->RowAttributes() ?>>
<?php

// Render list options (body, left)
$localadherido_list->ListOptions->Render("body", "left");
?>
	<?php if ($localadherido->lad_id->Visible) { // lad_id ?>
		<td<?php echo $localadherido->lad_id->CellAttributes() ?>>
<div<?php echo $localadherido->lad_id->ViewAttributes() ?>><?php echo $localadherido->lad_id->ListViewValue() ?></div>
<a name="<?php echo $localadherido_list->PageObjName . "_row_" . $localadherido_list->RowCnt ?>" id="<?php echo $localadherido_list->PageObjName . "_row_" . $localadherido_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($localadherido->emp_id->Visible) { // emp_id ?>
		<td<?php echo $localadherido->emp_id->CellAttributes() ?>>
<div<?php echo $localadherido->emp_id->ViewAttributes() ?>><?php echo $localadherido->emp_id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($localadherido->cup_id->Visible) { // cup_id ?>
		<td<?php echo $localadherido->cup_id->CellAttributes() ?>>
<div<?php echo $localadherido->cup_id->ViewAttributes() ?>><?php echo $localadherido->cup_id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($localadherido->loc_id->Visible) { // loc_id ?>
		<td<?php echo $localadherido->loc_id->CellAttributes() ?>>
<div<?php echo $localadherido->loc_id->ViewAttributes() ?>><?php echo $localadherido->loc_id->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$localadherido_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($localadherido->CurrentAction <> "gridadd")
		$localadherido_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($localadherido_list->Recordset)
	$localadherido_list->Recordset->Close();
?>
<?php if ($localadherido_list->TotalRecs > 0) { ?>
<?php if ($localadherido->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($localadherido->CurrentAction <> "gridadd" && $localadherido->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($localadherido_list->Pager)) $localadherido_list->Pager = new cPrevNextPager($localadherido_list->StartRec, $localadherido_list->DisplayRecs, $localadherido_list->TotalRecs) ?>
<?php if ($localadherido_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($localadherido_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $localadherido_list->PageUrl() ?>start=<?php echo $localadherido_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($localadherido_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $localadherido_list->PageUrl() ?>start=<?php echo $localadherido_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $localadherido_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($localadherido_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $localadherido_list->PageUrl() ?>start=<?php echo $localadherido_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($localadherido_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $localadherido_list->PageUrl() ?>start=<?php echo $localadherido_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $localadherido_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $localadherido_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $localadherido_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $localadherido_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($localadherido_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $localadherido_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($localadherido_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.flocaladheridolist, '<?php echo $localadherido_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($localadherido->Export == "" && $localadherido->CurrentAction == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--
ew_UpdateOpts([['x_cup_id','x_emp_id',false],
['x_emp_id','x_emp_id',false]]);

//-->
</script>
<?php } ?>
<?php
$localadherido_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($localadherido->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$localadherido_list->Page_Terminate();
?>
<?php

//
// Page class
//
class clocaladherido_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'localadherido';

	// Page object name
	var $PageObjName = 'localadherido_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $localadherido;
		if ($localadherido->UseTokenInUrl) $PageUrl .= "t=" . $localadherido->TableVar . "&"; // Add page token
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
		global $objForm, $localadherido;
		if ($localadherido->UseTokenInUrl) {
			if ($objForm)
				return ($localadherido->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($localadherido->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function clocaladherido_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (localadherido)
		if (!isset($GLOBALS["localadherido"])) {
			$GLOBALS["localadherido"] = new clocaladherido();
			$GLOBALS["Table"] =& $GLOBALS["localadherido"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "localadheridoadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "localadheridodelete.php";
		$this->MultiUpdateUrl = "localadheridoupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'localadherido', TRUE);

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
		global $localadherido;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$localadherido->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$localadherido->Export = $_POST["exporttype"];
		} else {
			$localadherido->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $localadherido->Export; // Get export parameter, used in header
		$gsExportFile = $localadherido->TableVar; // Get export file, used in header
		$Charset = (EW_CHARSET <> "") ? ";charset=" . EW_CHARSET : ""; // Charset used in header
		if ($localadherido->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($localadherido->Export == "word") {
			header('Content-Type: application/vnd.ms-word' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.doc');
		}
		if ($localadherido->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$localadherido->GridAddRowCount = $gridaddcnt;

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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $localadherido;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Hide all options
			if ($localadherido->Export <> "" ||
				$localadherido->CurrentAction == "gridadd" ||
				$localadherido->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$localadherido->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($localadherido->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $localadherido->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$localadherido->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchAdvanced == "")
				$this->ResetAdvancedSearchParms();
			$localadherido->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$localadherido->setStartRecordNumber($this->StartRec);
			}
		} else {
			$this->SearchWhere = $localadherido->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$localadherido->setSessionWhere($sFilter);
		$localadherido->CurrentFilter = "";

		// Export data only
		if (in_array($localadherido->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($localadherido->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security, $localadherido;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $localadherido->lad_id, FALSE); // lad_id
		$this->BuildSearchSql($sWhere, $localadherido->emp_id, FALSE); // emp_id
		$this->BuildSearchSql($sWhere, $localadherido->cup_id, FALSE); // cup_id
		$this->BuildSearchSql($sWhere, $localadherido->loc_id, FALSE); // loc_id

		// Set up search parm
		if ($sWhere <> "") {
			$this->SetSearchParm($localadherido->lad_id); // lad_id
			$this->SetSearchParm($localadherido->emp_id); // emp_id
			$this->SetSearchParm($localadherido->cup_id); // cup_id
			$this->SetSearchParm($localadherido->loc_id); // loc_id
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
		global $localadherido;
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$localadherido->setAdvancedSearch("x_$FldParm", $FldVal);
		$localadherido->setAdvancedSearch("z_$FldParm", $Fld->AdvancedSearch->SearchOperator); // @$_GET["z_$FldParm"]
		$localadherido->setAdvancedSearch("v_$FldParm", $Fld->AdvancedSearch->SearchCondition); // @$_GET["v_$FldParm"]
		$localadherido->setAdvancedSearch("y_$FldParm", $FldVal2);
		$localadherido->setAdvancedSearch("w_$FldParm", $Fld->AdvancedSearch->SearchOperator2); // @$_GET["w_$FldParm"]
	}

	// Get search parameters
	function GetSearchParm(&$Fld) {
		global $localadherido;
		$FldParm = substr($Fld->FldVar, 2);
		$Fld->AdvancedSearch->SearchValue = $localadherido->GetAdvancedSearch("x_$FldParm");
		$Fld->AdvancedSearch->SearchOperator = $localadherido->GetAdvancedSearch("z_$FldParm");
		$Fld->AdvancedSearch->SearchCondition = $localadherido->GetAdvancedSearch("v_$FldParm");
		$Fld->AdvancedSearch->SearchValue2 = $localadherido->GetAdvancedSearch("y_$FldParm");
		$Fld->AdvancedSearch->SearchOperator2 = $localadherido->GetAdvancedSearch("w_$FldParm");
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

	// Clear all search parameters
	function ResetSearchParms() {
		global $localadherido;

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$localadherido->setSearchWhere($this->SearchWhere);

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		global $localadherido;
		$localadherido->setAdvancedSearch("x_lad_id", "");
		$localadherido->setAdvancedSearch("x_emp_id", "");
		$localadherido->setAdvancedSearch("x_cup_id", "");
		$localadherido->setAdvancedSearch("x_loc_id", "");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $localadherido;
		$bRestore = TRUE;
		if (@$_GET["x_lad_id"] <> "") $bRestore = FALSE;
		if (@$_GET["x_emp_id"] <> "") $bRestore = FALSE;
		if (@$_GET["x_cup_id"] <> "") $bRestore = FALSE;
		if (@$_GET["x_loc_id"] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore advanced search values
			$this->GetSearchParm($localadherido->lad_id);
			$this->GetSearchParm($localadherido->emp_id);
			$this->GetSearchParm($localadherido->cup_id);
			$this->GetSearchParm($localadherido->loc_id);
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $localadherido;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$localadherido->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$localadherido->CurrentOrderType = @$_GET["ordertype"];
			$localadherido->UpdateSort($localadherido->lad_id); // lad_id
			$localadherido->UpdateSort($localadherido->emp_id); // emp_id
			$localadherido->UpdateSort($localadherido->cup_id); // cup_id
			$localadherido->UpdateSort($localadherido->loc_id); // loc_id
			$localadherido->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $localadherido;
		$sOrderBy = $localadherido->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($localadherido->SqlOrderBy() <> "") {
				$sOrderBy = $localadherido->SqlOrderBy();
				$localadherido->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $localadherido;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$localadherido->setSessionOrderBy($sOrderBy);
				$localadherido->lad_id->setSort("");
				$localadherido->emp_id->setSort("");
				$localadherido->cup_id->setSort("");
				$localadherido->loc_id->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$localadherido->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $localadherido;

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
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"localadherido_list.SelectAllKey(this);\">";
		$item->MoveTo(0);

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $localadherido, $objForm;
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
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($localadherido->lad_id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $localadherido;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $localadherido;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$localadherido->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$localadherido->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $localadherido->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$localadherido->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$localadherido->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$localadherido->setStartRecordNumber($this->StartRec);
		}
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm, $localadherido;

		// Load search values
		// lad_id

		$localadherido->lad_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_lad_id"]);
		$localadherido->lad_id->AdvancedSearch->SearchOperator = @$_GET["z_lad_id"];

		// emp_id
		$localadherido->emp_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_emp_id"]);
		$localadherido->emp_id->AdvancedSearch->SearchOperator = @$_GET["z_emp_id"];

		// cup_id
		$localadherido->cup_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cup_id"]);
		$localadherido->cup_id->AdvancedSearch->SearchOperator = @$_GET["z_cup_id"];

		// loc_id
		$localadherido->loc_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_loc_id"]);
		$localadherido->loc_id->AdvancedSearch->SearchOperator = @$_GET["z_loc_id"];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $localadherido;

		// Call Recordset Selecting event
		$localadherido->Recordset_Selecting($localadherido->CurrentFilter);

		// Load List page SQL
		$sSql = $localadherido->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$localadherido->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $localadherido;
		$sFilter = $localadherido->KeyFilter();

		// Call Row Selecting event
		$localadherido->Row_Selecting($sFilter);

		// Load SQL based on filter
		$localadherido->CurrentFilter = $sFilter;
		$sSql = $localadherido->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$localadherido->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $localadherido;
		if (!$rs || $rs->EOF) return;
		$localadherido->lad_id->setDbValue($rs->fields('lad_id'));
		$localadherido->emp_id->setDbValue($rs->fields('emp_id'));
		$localadherido->cup_id->setDbValue($rs->fields('cup_id'));
		$localadherido->loc_id->setDbValue($rs->fields('loc_id'));
	}

	// Load old record
	function LoadOldRecord() {
		global $localadherido;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($localadherido->getKey("lad_id")) <> "")
			$localadherido->lad_id->CurrentValue = $localadherido->getKey("lad_id"); // lad_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$localadherido->CurrentFilter = $localadherido->KeyFilter();
			$sSql = $localadherido->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $localadherido;

		// Initialize URLs
		$this->ViewUrl = $localadherido->ViewUrl();
		$this->EditUrl = $localadherido->EditUrl();
		$this->InlineEditUrl = $localadherido->InlineEditUrl();
		$this->CopyUrl = $localadherido->CopyUrl();
		$this->InlineCopyUrl = $localadherido->InlineCopyUrl();
		$this->DeleteUrl = $localadherido->DeleteUrl();

		// Call Row_Rendering event
		$localadherido->Row_Rendering();

		// Common render codes for all row types
		// lad_id
		// emp_id
		// cup_id
		// loc_id

		if ($localadherido->RowType == EW_ROWTYPE_VIEW) { // View row

			// lad_id
			$localadherido->lad_id->ViewValue = $localadherido->lad_id->CurrentValue;
			$localadherido->lad_id->ViewCustomAttributes = "";

			// emp_id
			if (strval($localadherido->emp_id->CurrentValue) <> "") {
				$sFilterWrk = "`emp_id` = " . ew_AdjustSql($localadherido->emp_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `emp_nomfantasia`, `emp_rut` FROM `empresa`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `emp_nomfantasia` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$localadherido->emp_id->ViewValue = $rswrk->fields('emp_nomfantasia');
					$localadherido->emp_id->ViewValue .= ew_ValueSeparator(0,1,$localadherido->emp_id) . $rswrk->fields('emp_rut');
					$rswrk->Close();
				} else {
					$localadherido->emp_id->ViewValue = $localadherido->emp_id->CurrentValue;
				}
			} else {
				$localadherido->emp_id->ViewValue = NULL;
			}
			$localadherido->emp_id->ViewCustomAttributes = "";

			// cup_id
			if (strval($localadherido->cup_id->CurrentValue) <> "") {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($localadherido->cup_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cup_nombre` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `cup_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$localadherido->cup_id->ViewValue = $rswrk->fields('cup_nombre');
					$rswrk->Close();
				} else {
					$localadherido->cup_id->ViewValue = $localadherido->cup_id->CurrentValue;
				}
			} else {
				$localadherido->cup_id->ViewValue = NULL;
			}
			$localadherido->cup_id->ViewCustomAttributes = "";

			// loc_id
			if (strval($localadherido->loc_id->CurrentValue) <> "") {
				$sFilterWrk = "`loc_id` = " . ew_AdjustSql($localadherido->loc_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `loc_nombre`, `loc_direccion` FROM `local`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `loc_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$localadherido->loc_id->ViewValue = $rswrk->fields('loc_nombre');
					$localadherido->loc_id->ViewValue .= ew_ValueSeparator(0,1,$localadherido->loc_id) . $rswrk->fields('loc_direccion');
					$rswrk->Close();
				} else {
					$localadherido->loc_id->ViewValue = $localadherido->loc_id->CurrentValue;
				}
			} else {
				$localadherido->loc_id->ViewValue = NULL;
			}
			$localadherido->loc_id->ViewCustomAttributes = "";

			// lad_id
			$localadherido->lad_id->LinkCustomAttributes = "";
			$localadherido->lad_id->HrefValue = "";
			$localadherido->lad_id->TooltipValue = "";

			// emp_id
			$localadherido->emp_id->LinkCustomAttributes = "";
			$localadherido->emp_id->HrefValue = "";
			$localadherido->emp_id->TooltipValue = "";

			// cup_id
			$localadherido->cup_id->LinkCustomAttributes = "";
			$localadherido->cup_id->HrefValue = "";
			$localadherido->cup_id->TooltipValue = "";

			// loc_id
			$localadherido->loc_id->LinkCustomAttributes = "";
			$localadherido->loc_id->HrefValue = "";
			$localadherido->loc_id->TooltipValue = "";
		} elseif ($localadherido->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// lad_id
			$localadherido->lad_id->EditCustomAttributes = "";
			$localadherido->lad_id->EditValue = ew_HtmlEncode($localadherido->lad_id->AdvancedSearch->SearchValue);

			// emp_id
			$localadherido->emp_id->EditCustomAttributes = "";
			if (trim(strval($localadherido->emp_id->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`emp_id` = " . ew_AdjustSql($localadherido->emp_id->AdvancedSearch->SearchValue) . "";
			}
			$sSqlWrk = "SELECT `emp_id`, `emp_nomfantasia` AS `DispFld`, `emp_rut` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld` FROM `empresa`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `emp_nomfantasia` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$localadherido->emp_id->EditValue = $arwrk;

			// cup_id
			$localadherido->cup_id->EditCustomAttributes = "";
			if (trim(strval($localadherido->cup_id->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($localadherido->cup_id->AdvancedSearch->SearchValue) . "";
			}
			$sSqlWrk = "SELECT `cup_id`, `cup_nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `emp_id` AS `SelectFilterFld` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `cup_nombre` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$localadherido->cup_id->EditValue = $arwrk;

			// loc_id
			$localadherido->loc_id->EditCustomAttributes = "";
		}
		if ($localadherido->RowType == EW_ROWTYPE_ADD ||
			$localadherido->RowType == EW_ROWTYPE_EDIT ||
			$localadherido->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$localadherido->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($localadherido->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$localadherido->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $localadherido;

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
		global $localadherido;
		$localadherido->lad_id->AdvancedSearch->SearchValue = $localadherido->getAdvancedSearch("x_lad_id");
		$localadherido->emp_id->AdvancedSearch->SearchValue = $localadherido->getAdvancedSearch("x_emp_id");
		$localadherido->cup_id->AdvancedSearch->SearchValue = $localadherido->getAdvancedSearch("x_cup_id");
		$localadherido->loc_id->AdvancedSearch->SearchValue = $localadherido->getAdvancedSearch("x_loc_id");
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language, $localadherido;

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
		$item->Body = "<a name=\"emf_localadherido\" id=\"emf_localadherido\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_localadherido',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.flocaladheridolist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($localadherido->Export <> "" ||
			$localadherido->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $localadherido;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $localadherido->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($localadherido->ExportAll) {
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
		if ($localadherido->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($localadherido, "h");
		}
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		if ($localadherido->Export == "xml") {
			$localadherido->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$localadherido->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
			$sFooter = $this->PageFooter;
			$this->Page_DataRendered($sFooter);
			$ExportDoc->Text .= $sFooter;
		}

		// Close recordset
		$rs->Close();

		// Export header and footer
		if ($localadherido->Export <> "xml") {
			$ExportDoc->ExportHeaderAndFooter();
		}

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($localadherido->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($localadherido->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($localadherido->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($localadherido->ExportReturnUrl());
		} elseif ($localadherido->Export == "pdf") {
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
