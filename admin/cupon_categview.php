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
$cupon_categ_view = new ccupon_categ_view();
$Page =& $cupon_categ_view;

// Page init
$cupon_categ_view->Page_Init();

// Page main
$cupon_categ_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cupon_categ->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cupon_categ_view = new ew_Page("cupon_categ_view");

// page properties
cupon_categ_view.PageID = "view"; // page ID
cupon_categ_view.FormID = "fcupon_categview"; // form ID
var EW_PAGE_ID = cupon_categ_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cupon_categ_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cupon_categ_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cupon_categ_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cupon_categ_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php $cupon_categ_view->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cupon_categ->TableCaption() ?>
&nbsp;&nbsp;<?php $cupon_categ_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($cupon_categ->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $cupon_categ_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $cupon_categ_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $cupon_categ_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $cupon_categ_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $cupon_categ_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php
$cupon_categ_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cupon_categ->cct_id->Visible) { // cct_id ?>
	<tr id="r_cct_id"<?php echo $cupon_categ->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon_categ->cct_id->FldCaption() ?></td>
		<td<?php echo $cupon_categ->cct_id->CellAttributes() ?>>
<div<?php echo $cupon_categ->cct_id->ViewAttributes() ?>><?php echo $cupon_categ->cct_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon_categ->cup_id->Visible) { // cup_id ?>
	<tr id="r_cup_id"<?php echo $cupon_categ->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon_categ->cup_id->FldCaption() ?></td>
		<td<?php echo $cupon_categ->cup_id->CellAttributes() ?>>
<div<?php echo $cupon_categ->cup_id->ViewAttributes() ?>><?php echo $cupon_categ->cup_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon_categ->cat_id->Visible) { // cat_id ?>
	<tr id="r_cat_id"<?php echo $cupon_categ->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon_categ->cat_id->FldCaption() ?></td>
		<td<?php echo $cupon_categ->cat_id->CellAttributes() ?>>
<div<?php echo $cupon_categ->cat_id->ViewAttributes() ?>><?php echo $cupon_categ->cat_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php
$cupon_categ_view->ShowPageFooter();
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
$cupon_categ_view->Page_Terminate();
?>
<?php

//
// Page class
//
class ccupon_categ_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'cupon_categ';

	// Page object name
	var $PageObjName = 'cupon_categ_view';

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
	function ccupon_categ_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (cupon_categ)
		if (!isset($GLOBALS["cupon_categ"])) {
			$GLOBALS["cupon_categ"] = new ccupon_categ();
			$GLOBALS["Table"] =& $GLOBALS["cupon_categ"];
		}
		$KeyUrl = "";
		if (@$_GET["cct_id"] <> "") {
			$this->RecKey["cct_id"] = $_GET["cct_id"];
			$KeyUrl .= "&cct_id=" . urlencode($this->RecKey["cct_id"]);
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
			define("EW_TABLE_NAME", 'cupon_categ', TRUE);

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
		global $cupon_categ;

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
		global $Language, $cupon_categ;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["cct_id"] <> "") {
				$cupon_categ->cct_id->setQueryStringValue($_GET["cct_id"]);
				$this->RecKey["cct_id"] = $cupon_categ->cct_id->QueryStringValue;
			} else {
				$sReturnUrl = "cupon_categlist.php"; // Return to list
			}

			// Get action
			$cupon_categ->CurrentAction = "I"; // Display form
			switch ($cupon_categ->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "cupon_categlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "cupon_categlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$cupon_categ->RowType = EW_ROWTYPE_VIEW;
		$cupon_categ->ResetAttrs();
		$this->RenderRow();
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

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $cupon_categ;

		// Initialize URLs
		$this->AddUrl = $cupon_categ->AddUrl();
		$this->EditUrl = $cupon_categ->EditUrl();
		$this->CopyUrl = $cupon_categ->CopyUrl();
		$this->DeleteUrl = $cupon_categ->DeleteUrl();
		$this->ListUrl = $cupon_categ->ListUrl();

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
