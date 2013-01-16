<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "cupon_regioninfo.php" ?>
<?php include_once "cuponinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$cupon_region_view = new ccupon_region_view();
$Page =& $cupon_region_view;

// Page init
$cupon_region_view->Page_Init();

// Page main
$cupon_region_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cupon_region->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cupon_region_view = new ew_Page("cupon_region_view");

// page properties
cupon_region_view.PageID = "view"; // page ID
cupon_region_view.FormID = "fcupon_regionview"; // form ID
var EW_PAGE_ID = cupon_region_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cupon_region_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cupon_region_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cupon_region_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cupon_region_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php $cupon_region_view->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cupon_region->TableCaption() ?>
&nbsp;&nbsp;<?php $cupon_region_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($cupon_region->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $cupon_region_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $cupon_region_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $cupon_region_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $cupon_region_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $cupon_region_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php
$cupon_region_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cupon_region->crg_id->Visible) { // crg_id ?>
	<tr id="r_crg_id"<?php echo $cupon_region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon_region->crg_id->FldCaption() ?></td>
		<td<?php echo $cupon_region->crg_id->CellAttributes() ?>>
<div<?php echo $cupon_region->crg_id->ViewAttributes() ?>><?php echo $cupon_region->crg_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon_region->cup_id->Visible) { // cup_id ?>
	<tr id="r_cup_id"<?php echo $cupon_region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon_region->cup_id->FldCaption() ?></td>
		<td<?php echo $cupon_region->cup_id->CellAttributes() ?>>
<div<?php echo $cupon_region->cup_id->ViewAttributes() ?>><?php echo $cupon_region->cup_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon_region->reg_id->Visible) { // reg_id ?>
	<tr id="r_reg_id"<?php echo $cupon_region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon_region->reg_id->FldCaption() ?></td>
		<td<?php echo $cupon_region->reg_id->CellAttributes() ?>>
<div<?php echo $cupon_region->reg_id->ViewAttributes() ?>><?php echo $cupon_region->reg_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php
$cupon_region_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cupon_region->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cupon_region_view->Page_Terminate();
?>
<?php

//
// Page class
//
class ccupon_region_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'cupon_region';

	// Page object name
	var $PageObjName = 'cupon_region_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cupon_region;
		if ($cupon_region->UseTokenInUrl) $PageUrl .= "t=" . $cupon_region->TableVar . "&"; // Add page token
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
		global $objForm, $cupon_region;
		if ($cupon_region->UseTokenInUrl) {
			if ($objForm)
				return ($cupon_region->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cupon_region->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccupon_region_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (cupon_region)
		if (!isset($GLOBALS["cupon_region"])) {
			$GLOBALS["cupon_region"] = new ccupon_region();
			$GLOBALS["Table"] =& $GLOBALS["cupon_region"];
		}
		$KeyUrl = "";
		if (@$_GET["crg_id"] <> "") {
			$this->RecKey["crg_id"] = $_GET["crg_id"];
			$KeyUrl .= "&crg_id=" . urlencode($this->RecKey["crg_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (cupon)
		if (!isset($GLOBALS['cupon'])) $GLOBALS['cupon'] = new ccupon();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cupon_region', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

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
		global $cupon_region;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

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
	var $ExportOptions; // Export options
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $cupon_region;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["crg_id"] <> "") {
				$cupon_region->crg_id->setQueryStringValue($_GET["crg_id"]);
				$this->RecKey["crg_id"] = $cupon_region->crg_id->QueryStringValue;
			} else {
				$sReturnUrl = "cupon_regionlist.php"; // Return to list
			}

			// Get action
			$cupon_region->CurrentAction = "I"; // Display form
			switch ($cupon_region->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "cupon_regionlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "cupon_regionlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$cupon_region->RowType = EW_ROWTYPE_VIEW;
		$cupon_region->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $cupon_region;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$cupon_region->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$cupon_region->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $cupon_region->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$cupon_region->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$cupon_region->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$cupon_region->setStartRecordNumber($this->StartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cupon_region;
		$sFilter = $cupon_region->KeyFilter();

		// Call Row Selecting event
		$cupon_region->Row_Selecting($sFilter);

		// Load SQL based on filter
		$cupon_region->CurrentFilter = $sFilter;
		$sSql = $cupon_region->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$cupon_region->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $cupon_region;
		if (!$rs || $rs->EOF) return;
		$cupon_region->crg_id->setDbValue($rs->fields('crg_id'));
		$cupon_region->cup_id->setDbValue($rs->fields('cup_id'));
		$cupon_region->reg_id->setDbValue($rs->fields('reg_id'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $cupon_region;

		// Initialize URLs
		$this->AddUrl = $cupon_region->AddUrl();
		$this->EditUrl = $cupon_region->EditUrl();
		$this->CopyUrl = $cupon_region->CopyUrl();
		$this->DeleteUrl = $cupon_region->DeleteUrl();
		$this->ListUrl = $cupon_region->ListUrl();

		// Call Row_Rendering event
		$cupon_region->Row_Rendering();

		// Common render codes for all row types
		// crg_id
		// cup_id
		// reg_id

		if ($cupon_region->RowType == EW_ROWTYPE_VIEW) { // View row

			// crg_id
			$cupon_region->crg_id->ViewValue = $cupon_region->crg_id->CurrentValue;
			$cupon_region->crg_id->ViewCustomAttributes = "";

			// cup_id
			if (strval($cupon_region->cup_id->CurrentValue) <> "") {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($cupon_region->cup_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cup_nombre` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$cupon_region->cup_id->ViewValue = $rswrk->fields('cup_nombre');
					$rswrk->Close();
				} else {
					$cupon_region->cup_id->ViewValue = $cupon_region->cup_id->CurrentValue;
				}
			} else {
				$cupon_region->cup_id->ViewValue = NULL;
			}
			$cupon_region->cup_id->ViewCustomAttributes = "";

			// reg_id
			if (strval($cupon_region->reg_id->CurrentValue) <> "") {
				$sFilterWrk = "`reg_id` = " . ew_AdjustSql($cupon_region->reg_id->CurrentValue) . "";
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
					$cupon_region->reg_id->ViewValue = $rswrk->fields('reg_num');
					$cupon_region->reg_id->ViewValue .= ew_ValueSeparator(0,1,$cupon_region->reg_id) . $rswrk->fields('reg_nombre');
					$rswrk->Close();
				} else {
					$cupon_region->reg_id->ViewValue = $cupon_region->reg_id->CurrentValue;
				}
			} else {
				$cupon_region->reg_id->ViewValue = NULL;
			}
			$cupon_region->reg_id->ViewCustomAttributes = "";

			// crg_id
			$cupon_region->crg_id->LinkCustomAttributes = "";
			$cupon_region->crg_id->HrefValue = "";
			$cupon_region->crg_id->TooltipValue = "";

			// cup_id
			$cupon_region->cup_id->LinkCustomAttributes = "";
			$cupon_region->cup_id->HrefValue = "";
			$cupon_region->cup_id->TooltipValue = "";

			// reg_id
			$cupon_region->reg_id->LinkCustomAttributes = "";
			$cupon_region->reg_id->HrefValue = "";
			$cupon_region->reg_id->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($cupon_region->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$cupon_region->Row_Rendered();
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
}
?>
