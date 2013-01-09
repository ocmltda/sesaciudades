<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "categoriainfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$categoria_list = new ccategoria_list();
$Page =& $categoria_list;

// Page init
$categoria_list->Page_Init();

// Page main
$categoria_list->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($categoria->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var categoria_list = new ew_Page("categoria_list");

// page properties
categoria_list.PageID = "list"; // page ID
categoria_list.FormID = "fcategorialist"; // form ID
var EW_PAGE_ID = categoria_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
categoria_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
categoria_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
categoria_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
categoria_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if (($categoria->Export == "") || (EW_EXPORT_MASTER_RECORD && $categoria->Export == "print")) { ?>
<?php } ?>
<?php $categoria_list->ShowPageHeader(); ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$categoria_list->TotalRecs = $categoria->SelectRecordCount();
	} else {
		if ($categoria_list->Recordset = $categoria_list->LoadRecordset())
			$categoria_list->TotalRecs = $categoria_list->Recordset->RecordCount();
	}
	$categoria_list->StartRec = 1;
	if ($categoria_list->DisplayRecs <= 0 || ($categoria->Export <> "" && $categoria->ExportAll)) // Display all records
		$categoria_list->DisplayRecs = $categoria_list->TotalRecs;
	if (!($categoria->Export <> "" && $categoria->ExportAll))
		$categoria_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$categoria_list->Recordset = $categoria_list->LoadRecordset($categoria_list->StartRec-1, $categoria_list->DisplayRecs);
?>
<p class="phpmaker ewTitle" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $categoria->TableCaption() ?>
&nbsp;&nbsp;<?php $categoria_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($categoria->Export == "" && $categoria->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(categoria_list);" style="text-decoration: none;"><img id="categoria_list_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="categoria_list_SearchPanel">
<form name="fcategorialistsrch" id="fcategorialistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="categoria">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewCssTableRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($categoria->getSessionBasicSearchKeyword()) ?>">
	<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $categoria_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewCssTableRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($categoria->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($categoria->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($categoria->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
$categoria_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($categoria->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($categoria->CurrentAction <> "gridadd" && $categoria->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($categoria_list->Pager)) $categoria_list->Pager = new cPrevNextPager($categoria_list->StartRec, $categoria_list->DisplayRecs, $categoria_list->TotalRecs) ?>
<?php if ($categoria_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($categoria_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $categoria_list->PageUrl() ?>start=<?php echo $categoria_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($categoria_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $categoria_list->PageUrl() ?>start=<?php echo $categoria_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $categoria_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($categoria_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $categoria_list->PageUrl() ?>start=<?php echo $categoria_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($categoria_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $categoria_list->PageUrl() ?>start=<?php echo $categoria_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $categoria_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $categoria_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $categoria_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $categoria_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($categoria_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $categoria_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($categoria_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fcategorialist, '<?php echo $categoria_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcategorialist" id="fcategorialist" class="ewForm" action="" method="post">
<input type="hidden" name="t" id="t" value="categoria">
<div id="gmp_categoria" class="ewGridMiddlePanel">
<?php if ($categoria_list->TotalRecs > 0) { ?>
<table cellspacing="0" data-rowhighlightclass="ewTableHighlightRow" data-rowselectclass="ewTableSelectRow" data-roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $categoria->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$categoria_list->RenderListOptions();

// Render list options (header, left)
$categoria_list->ListOptions->Render("header", "left");
?>
<?php if ($categoria->cat_id->Visible) { // cat_id ?>
	<?php if ($categoria->SortUrl($categoria->cat_id) == "") { ?>
		<td><?php echo $categoria->cat_id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $categoria->SortUrl($categoria->cat_id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $categoria->cat_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($categoria->cat_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($categoria->cat_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($categoria->cat_nombre->Visible) { // cat_nombre ?>
	<?php if ($categoria->SortUrl($categoria->cat_nombre) == "") { ?>
		<td><?php echo $categoria->cat_nombre->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $categoria->SortUrl($categoria->cat_nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $categoria->cat_nombre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($categoria->cat_nombre->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($categoria->cat_nombre->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($categoria->cat_imagen_nombre->Visible) { // cat_imagen_nombre ?>
	<?php if ($categoria->SortUrl($categoria->cat_imagen_nombre) == "") { ?>
		<td><?php echo $categoria->cat_imagen_nombre->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $categoria->SortUrl($categoria->cat_imagen_nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $categoria->cat_imagen_nombre->FldCaption() ?></td><td style="width: 10px;"><?php if ($categoria->cat_imagen_nombre->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($categoria->cat_imagen_nombre->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($categoria->cat_imagen_tipo->Visible) { // cat_imagen_tipo ?>
	<?php if ($categoria->SortUrl($categoria->cat_imagen_tipo) == "") { ?>
		<td><?php echo $categoria->cat_imagen_tipo->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $categoria->SortUrl($categoria->cat_imagen_tipo) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $categoria->cat_imagen_tipo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($categoria->cat_imagen_tipo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($categoria->cat_imagen_tipo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($categoria->cat_imagen_ancho->Visible) { // cat_imagen_ancho ?>
	<?php if ($categoria->SortUrl($categoria->cat_imagen_ancho) == "") { ?>
		<td><?php echo $categoria->cat_imagen_ancho->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $categoria->SortUrl($categoria->cat_imagen_ancho) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $categoria->cat_imagen_ancho->FldCaption() ?></td><td style="width: 10px;"><?php if ($categoria->cat_imagen_ancho->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($categoria->cat_imagen_ancho->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($categoria->cat_imagen_alto->Visible) { // cat_imagen_alto ?>
	<?php if ($categoria->SortUrl($categoria->cat_imagen_alto) == "") { ?>
		<td><?php echo $categoria->cat_imagen_alto->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $categoria->SortUrl($categoria->cat_imagen_alto) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $categoria->cat_imagen_alto->FldCaption() ?></td><td style="width: 10px;"><?php if ($categoria->cat_imagen_alto->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($categoria->cat_imagen_alto->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($categoria->cat_imagen_size->Visible) { // cat_imagen_size ?>
	<?php if ($categoria->SortUrl($categoria->cat_imagen_size) == "") { ?>
		<td><?php echo $categoria->cat_imagen_size->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $categoria->SortUrl($categoria->cat_imagen_size) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $categoria->cat_imagen_size->FldCaption() ?></td><td style="width: 10px;"><?php if ($categoria->cat_imagen_size->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($categoria->cat_imagen_size->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($categoria->cat_mostrar->Visible) { // cat_mostrar ?>
	<?php if ($categoria->SortUrl($categoria->cat_mostrar) == "") { ?>
		<td><?php echo $categoria->cat_mostrar->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $categoria->SortUrl($categoria->cat_mostrar) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $categoria->cat_mostrar->FldCaption() ?></td><td style="width: 10px;"><?php if ($categoria->cat_mostrar->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($categoria->cat_mostrar->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$categoria_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($categoria->ExportAll && $categoria->Export <> "") {
	$categoria_list->StopRec = $categoria_list->TotalRecs;
} else {

	// Set the last record to display
	if ($categoria_list->TotalRecs > $categoria_list->StartRec + $categoria_list->DisplayRecs - 1)
		$categoria_list->StopRec = $categoria_list->StartRec + $categoria_list->DisplayRecs - 1;
	else
		$categoria_list->StopRec = $categoria_list->TotalRecs;
}
$categoria_list->RecCnt = $categoria_list->StartRec - 1;
if ($categoria_list->Recordset && !$categoria_list->Recordset->EOF) {
	$categoria_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $categoria_list->StartRec > 1)
		$categoria_list->Recordset->Move($categoria_list->StartRec - 1);
} elseif (!$categoria->AllowAddDeleteRow && $categoria_list->StopRec == 0) {
	$categoria_list->StopRec = $categoria->GridAddRowCount;
}

// Initialize aggregate
$categoria->RowType = EW_ROWTYPE_AGGREGATEINIT;
$categoria->ResetAttrs();
$categoria_list->RenderRow();
$categoria_list->RowCnt = 0;
while ($categoria_list->RecCnt < $categoria_list->StopRec) {
	$categoria_list->RecCnt++;
	if (intval($categoria_list->RecCnt) >= intval($categoria_list->StartRec)) {
		$categoria_list->RowCnt++;

		// Set up key count
		$categoria_list->KeyCount = $categoria_list->RowIndex;

		// Init row class and style
		$categoria->ResetAttrs();
		$categoria->CssClass = "";
		if ($categoria->CurrentAction == "gridadd") {
			$categoria_list->LoadDefaultValues(); // Load default values
		} else {
			$categoria_list->LoadRowValues($categoria_list->Recordset); // Load row values
		}
		$categoria->RowType = EW_ROWTYPE_VIEW; // Render view
		$categoria->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');

		// Render row
		$categoria_list->RenderRow();

		// Render list options
		$categoria_list->RenderListOptions();
?>
	<tr<?php echo $categoria->RowAttributes() ?>>
<?php

// Render list options (body, left)
$categoria_list->ListOptions->Render("body", "left");
?>
	<?php if ($categoria->cat_id->Visible) { // cat_id ?>
		<td<?php echo $categoria->cat_id->CellAttributes() ?>>
<div<?php echo $categoria->cat_id->ViewAttributes() ?>><?php echo $categoria->cat_id->ListViewValue() ?></div>
<a name="<?php echo $categoria_list->PageObjName . "_row_" . $categoria_list->RowCnt ?>" id="<?php echo $categoria_list->PageObjName . "_row_" . $categoria_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($categoria->cat_nombre->Visible) { // cat_nombre ?>
		<td<?php echo $categoria->cat_nombre->CellAttributes() ?>>
<div<?php echo $categoria->cat_nombre->ViewAttributes() ?>><?php echo $categoria->cat_nombre->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($categoria->cat_imagen_nombre->Visible) { // cat_imagen_nombre ?>
		<td<?php echo $categoria->cat_imagen_nombre->CellAttributes() ?>>
<?php if ($categoria->cat_imagen_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($categoria->cat_imagen_nombre->Upload->DbValue)) { ?>
<a<?php echo $categoria->cat_imagen_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $categoria->cat_imagen_nombre->UploadPath) . $categoria->cat_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $categoria->cat_imagen_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($categoria->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($categoria->cat_imagen_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $categoria->cat_imagen_nombre->UploadPath) . $categoria->cat_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $categoria->cat_imagen_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($categoria->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($categoria->cat_imagen_tipo->Visible) { // cat_imagen_tipo ?>
		<td<?php echo $categoria->cat_imagen_tipo->CellAttributes() ?>>
<div<?php echo $categoria->cat_imagen_tipo->ViewAttributes() ?>><?php echo $categoria->cat_imagen_tipo->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($categoria->cat_imagen_ancho->Visible) { // cat_imagen_ancho ?>
		<td<?php echo $categoria->cat_imagen_ancho->CellAttributes() ?>>
<div<?php echo $categoria->cat_imagen_ancho->ViewAttributes() ?>><?php echo $categoria->cat_imagen_ancho->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($categoria->cat_imagen_alto->Visible) { // cat_imagen_alto ?>
		<td<?php echo $categoria->cat_imagen_alto->CellAttributes() ?>>
<div<?php echo $categoria->cat_imagen_alto->ViewAttributes() ?>><?php echo $categoria->cat_imagen_alto->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($categoria->cat_imagen_size->Visible) { // cat_imagen_size ?>
		<td<?php echo $categoria->cat_imagen_size->CellAttributes() ?>>
<div<?php echo $categoria->cat_imagen_size->ViewAttributes() ?>><?php echo $categoria->cat_imagen_size->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($categoria->cat_mostrar->Visible) { // cat_mostrar ?>
		<td<?php echo $categoria->cat_mostrar->CellAttributes() ?>>
<div<?php echo $categoria->cat_mostrar->ViewAttributes() ?>><?php echo $categoria->cat_mostrar->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$categoria_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($categoria->CurrentAction <> "gridadd")
		$categoria_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($categoria_list->Recordset)
	$categoria_list->Recordset->Close();
?>
<?php if ($categoria_list->TotalRecs > 0) { ?>
<?php if ($categoria->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($categoria->CurrentAction <> "gridadd" && $categoria->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($categoria_list->Pager)) $categoria_list->Pager = new cPrevNextPager($categoria_list->StartRec, $categoria_list->DisplayRecs, $categoria_list->TotalRecs) ?>
<?php if ($categoria_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($categoria_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $categoria_list->PageUrl() ?>start=<?php echo $categoria_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($categoria_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $categoria_list->PageUrl() ?>start=<?php echo $categoria_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $categoria_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($categoria_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $categoria_list->PageUrl() ?>start=<?php echo $categoria_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($categoria_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $categoria_list->PageUrl() ?>start=<?php echo $categoria_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $categoria_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $categoria_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $categoria_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $categoria_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($categoria_list->SearchWhere == "0=101") { ?>
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
<a href="<?php echo $categoria_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($categoria_list->TotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fcategorialist, '<?php echo $categoria_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($categoria->Export == "" && $categoria->CurrentAction == "") { ?>
<?php } ?>
<?php
$categoria_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($categoria->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$categoria_list->Page_Terminate();
?>
<?php

//
// Page class
//
class ccategoria_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'categoria';

	// Page object name
	var $PageObjName = 'categoria_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $categoria;
		if ($categoria->UseTokenInUrl) $PageUrl .= "t=" . $categoria->TableVar . "&"; // Add page token
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
		global $objForm, $categoria;
		if ($categoria->UseTokenInUrl) {
			if ($objForm)
				return ($categoria->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($categoria->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccategoria_list() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (categoria)
		if (!isset($GLOBALS["categoria"])) {
			$GLOBALS["categoria"] = new ccategoria();
			$GLOBALS["Table"] =& $GLOBALS["categoria"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "categoriaadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "categoriadelete.php";
		$this->MultiUpdateUrl = "categoriaupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'categoria', TRUE);

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
		global $categoria;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$categoria->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$categoria->Export = $_POST["exporttype"];
		} else {
			$categoria->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $categoria->Export; // Get export parameter, used in header
		$gsExportFile = $categoria->TableVar; // Get export file, used in header
		$Charset = (EW_CHARSET <> "") ? ";charset=" . EW_CHARSET : ""; // Charset used in header
		if ($categoria->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($categoria->Export == "word") {
			header('Content-Type: application/vnd.ms-word' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.doc');
		}
		if ($categoria->Export == "csv") {
			header('Content-Type: application/csv' . $Charset);
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$categoria->GridAddRowCount = $gridaddcnt;

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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $categoria;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Hide all options
			if ($categoria->Export <> "" ||
				$categoria->CurrentAction == "gridadd" ||
				$categoria->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$categoria->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($categoria->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $categoria->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$categoria->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$categoria->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$categoria->setStartRecordNumber($this->StartRec);
			}
		} else {
			$this->SearchWhere = $categoria->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$categoria->setSessionWhere($sFilter);
		$categoria->CurrentFilter = "";

		// Export data only
		if (in_array($categoria->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			if ($categoria->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $categoria;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $categoria->cat_nombre, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $categoria->cat_imagen_nombre, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $categoria->cat_imagen_tipo, $Keyword);
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
		global $Security, $categoria;
		$sSearchStr = "";
		$sSearchKeyword = $categoria->BasicSearchKeyword;
		$sSearchType = $categoria->BasicSearchType;
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
			$categoria->setSessionBasicSearchKeyword($sSearchKeyword);
			$categoria->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $categoria;

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$categoria->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $categoria;
		$categoria->setSessionBasicSearchKeyword("");
		$categoria->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $categoria;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$categoria->BasicSearchKeyword = $categoria->getSessionBasicSearchKeyword();
			$categoria->BasicSearchType = $categoria->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $categoria;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$categoria->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$categoria->CurrentOrderType = @$_GET["ordertype"];
			$categoria->UpdateSort($categoria->cat_id); // cat_id
			$categoria->UpdateSort($categoria->cat_nombre); // cat_nombre
			$categoria->UpdateSort($categoria->cat_imagen_nombre); // cat_imagen_nombre
			$categoria->UpdateSort($categoria->cat_imagen_tipo); // cat_imagen_tipo
			$categoria->UpdateSort($categoria->cat_imagen_ancho); // cat_imagen_ancho
			$categoria->UpdateSort($categoria->cat_imagen_alto); // cat_imagen_alto
			$categoria->UpdateSort($categoria->cat_imagen_size); // cat_imagen_size
			$categoria->UpdateSort($categoria->cat_mostrar); // cat_mostrar
			$categoria->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $categoria;
		$sOrderBy = $categoria->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($categoria->SqlOrderBy() <> "") {
				$sOrderBy = $categoria->SqlOrderBy();
				$categoria->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $categoria;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$categoria->setSessionOrderBy($sOrderBy);
				$categoria->cat_id->setSort("");
				$categoria->cat_nombre->setSort("");
				$categoria->cat_imagen_nombre->setSort("");
				$categoria->cat_imagen_tipo->setSort("");
				$categoria->cat_imagen_ancho->setSort("");
				$categoria->cat_imagen_alto->setSort("");
				$categoria->cat_imagen_size->setSort("");
				$categoria->cat_mostrar->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$categoria->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $categoria;

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
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"categoria_list.SelectAllKey(this);\">";
		$item->MoveTo(0);

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $categoria, $objForm;
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
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($categoria->cat_id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $categoria;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $categoria;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$categoria->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$categoria->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $categoria->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$categoria->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$categoria->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$categoria->setStartRecordNumber($this->StartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $categoria;
		$categoria->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$categoria->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $categoria;

		// Call Recordset Selecting event
		$categoria->Recordset_Selecting($categoria->CurrentFilter);

		// Load List page SQL
		$sSql = $categoria->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$categoria->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $categoria;
		$sFilter = $categoria->KeyFilter();

		// Call Row Selecting event
		$categoria->Row_Selecting($sFilter);

		// Load SQL based on filter
		$categoria->CurrentFilter = $sFilter;
		$sSql = $categoria->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$categoria->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $categoria;
		if (!$rs || $rs->EOF) return;
		$categoria->cat_id->setDbValue($rs->fields('cat_id'));
		$categoria->cat_nombre->setDbValue($rs->fields('cat_nombre'));
		$categoria->cat_imagen_nombre->Upload->DbValue = $rs->fields('cat_imagen_nombre');
		$categoria->cat_imagen_tipo->setDbValue($rs->fields('cat_imagen_tipo'));
		$categoria->cat_imagen_ancho->setDbValue($rs->fields('cat_imagen_ancho'));
		$categoria->cat_imagen_alto->setDbValue($rs->fields('cat_imagen_alto'));
		$categoria->cat_imagen_size->setDbValue($rs->fields('cat_imagen_size'));
		$categoria->cat_mostrar->setDbValue($rs->fields('cat_mostrar'));
	}

	// Load old record
	function LoadOldRecord() {
		global $categoria;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($categoria->getKey("cat_id")) <> "")
			$categoria->cat_id->CurrentValue = $categoria->getKey("cat_id"); // cat_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$categoria->CurrentFilter = $categoria->KeyFilter();
			$sSql = $categoria->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $categoria;

		// Initialize URLs
		$this->ViewUrl = $categoria->ViewUrl();
		$this->EditUrl = $categoria->EditUrl();
		$this->InlineEditUrl = $categoria->InlineEditUrl();
		$this->CopyUrl = $categoria->CopyUrl();
		$this->InlineCopyUrl = $categoria->InlineCopyUrl();
		$this->DeleteUrl = $categoria->DeleteUrl();

		// Call Row_Rendering event
		$categoria->Row_Rendering();

		// Common render codes for all row types
		// cat_id
		// cat_nombre
		// cat_imagen_nombre
		// cat_imagen_tipo
		// cat_imagen_ancho
		// cat_imagen_alto
		// cat_imagen_size
		// cat_mostrar

		if ($categoria->RowType == EW_ROWTYPE_VIEW) { // View row

			// cat_id
			$categoria->cat_id->ViewValue = $categoria->cat_id->CurrentValue;
			$categoria->cat_id->ViewCustomAttributes = "";

			// cat_nombre
			$categoria->cat_nombre->ViewValue = $categoria->cat_nombre->CurrentValue;
			$categoria->cat_nombre->ViewCustomAttributes = "";

			// cat_imagen_nombre
			if (!ew_Empty($categoria->cat_imagen_nombre->Upload->DbValue)) {
				$categoria->cat_imagen_nombre->ViewValue = $categoria->cat_imagen_nombre->Upload->DbValue;
				$categoria->cat_imagen_nombre->ImageWidth = 100;
				$categoria->cat_imagen_nombre->ImageHeight = 0;
				$categoria->cat_imagen_nombre->ImageAlt = $categoria->cat_imagen_nombre->FldAlt();
			} else {
				$categoria->cat_imagen_nombre->ViewValue = "";
			}
			$categoria->cat_imagen_nombre->ViewCustomAttributes = "";

			// cat_imagen_tipo
			$categoria->cat_imagen_tipo->ViewValue = $categoria->cat_imagen_tipo->CurrentValue;
			$categoria->cat_imagen_tipo->ViewCustomAttributes = "";

			// cat_imagen_ancho
			$categoria->cat_imagen_ancho->ViewValue = $categoria->cat_imagen_ancho->CurrentValue;
			$categoria->cat_imagen_ancho->ViewCustomAttributes = "";

			// cat_imagen_alto
			$categoria->cat_imagen_alto->ViewValue = $categoria->cat_imagen_alto->CurrentValue;
			$categoria->cat_imagen_alto->ViewCustomAttributes = "";

			// cat_imagen_size
			$categoria->cat_imagen_size->ViewValue = $categoria->cat_imagen_size->CurrentValue;
			$categoria->cat_imagen_size->ViewCustomAttributes = "";

			// cat_mostrar
			if (strval($categoria->cat_mostrar->CurrentValue) <> "") {
				switch ($categoria->cat_mostrar->CurrentValue) {
					case "1":
						$categoria->cat_mostrar->ViewValue = $categoria->cat_mostrar->FldTagCaption(1) <> "" ? $categoria->cat_mostrar->FldTagCaption(1) : $categoria->cat_mostrar->CurrentValue;
						break;
					case "0":
						$categoria->cat_mostrar->ViewValue = $categoria->cat_mostrar->FldTagCaption(2) <> "" ? $categoria->cat_mostrar->FldTagCaption(2) : $categoria->cat_mostrar->CurrentValue;
						break;
					default:
						$categoria->cat_mostrar->ViewValue = $categoria->cat_mostrar->CurrentValue;
				}
			} else {
				$categoria->cat_mostrar->ViewValue = NULL;
			}
			$categoria->cat_mostrar->ViewCustomAttributes = "";

			// cat_id
			$categoria->cat_id->LinkCustomAttributes = "";
			$categoria->cat_id->HrefValue = "";
			$categoria->cat_id->TooltipValue = "";

			// cat_nombre
			$categoria->cat_nombre->LinkCustomAttributes = "";
			$categoria->cat_nombre->HrefValue = "";
			$categoria->cat_nombre->TooltipValue = "";

			// cat_imagen_nombre
			$categoria->cat_imagen_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($categoria->cat_imagen_nombre->Upload->DbValue)) {
				$categoria->cat_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $categoria->cat_imagen_nombre->UploadPath) . ((!empty($categoria->cat_imagen_nombre->ViewValue)) ? $categoria->cat_imagen_nombre->ViewValue : $categoria->cat_imagen_nombre->CurrentValue); // Add prefix/suffix
				$categoria->cat_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($categoria->Export <> "") $categoria->cat_imagen_nombre->HrefValue = ew_ConvertFullUrl($categoria->cat_imagen_nombre->HrefValue);
			} else {
				$categoria->cat_imagen_nombre->HrefValue = "";
			}
			$categoria->cat_imagen_nombre->TooltipValue = "";

			// cat_imagen_tipo
			$categoria->cat_imagen_tipo->LinkCustomAttributes = "";
			$categoria->cat_imagen_tipo->HrefValue = "";
			$categoria->cat_imagen_tipo->TooltipValue = "";

			// cat_imagen_ancho
			$categoria->cat_imagen_ancho->LinkCustomAttributes = "";
			$categoria->cat_imagen_ancho->HrefValue = "";
			$categoria->cat_imagen_ancho->TooltipValue = "";

			// cat_imagen_alto
			$categoria->cat_imagen_alto->LinkCustomAttributes = "";
			$categoria->cat_imagen_alto->HrefValue = "";
			$categoria->cat_imagen_alto->TooltipValue = "";

			// cat_imagen_size
			$categoria->cat_imagen_size->LinkCustomAttributes = "";
			$categoria->cat_imagen_size->HrefValue = "";
			$categoria->cat_imagen_size->TooltipValue = "";

			// cat_mostrar
			$categoria->cat_mostrar->LinkCustomAttributes = "";
			$categoria->cat_mostrar->HrefValue = "";
			$categoria->cat_mostrar->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($categoria->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$categoria->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language, $categoria;

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
		$item->Body = "<a name=\"emf_categoria\" id=\"emf_categoria\" href=\"javascript:void(0);\" onclick=\"ew_EmailDialogShow({lnk:'emf_categoria',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fcategorialist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Hide options for export/action
		if ($categoria->Export <> "" ||
			$categoria->CurrentAction <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		global $categoria;
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $categoria->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($categoria->ExportAll) {
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
		if ($categoria->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
		} else {
			$ExportDoc = new cExportDocument($categoria, "h");
		}
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		if ($categoria->Export == "xml") {
			$categoria->ExportXmlDocument($XmlDoc, ($ParentTable <> ""), $rs, $StartRec, $StopRec, "");
		} else {
			$sHeader = $this->PageHeader;
			$this->Page_DataRendering($sHeader);
			$ExportDoc->Text .= $sHeader;
			$categoria->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
			$sFooter = $this->PageFooter;
			$this->Page_DataRendered($sFooter);
			$ExportDoc->Text .= $sFooter;
		}

		// Close recordset
		$rs->Close();

		// Export header and footer
		if ($categoria->Export <> "xml") {
			$ExportDoc->ExportHeaderAndFooter();
		}

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($categoria->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($categoria->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($categoria->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($categoria->ExportReturnUrl());
		} elseif ($categoria->Export == "pdf") {
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
