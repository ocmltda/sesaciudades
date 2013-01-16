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
$region_view = new cregion_view();
$Page =& $region_view;

// Page init
$region_view->Page_Init();

// Page main
$region_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($region->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var region_view = new ew_Page("region_view");

// page properties
region_view.PageID = "view"; // page ID
region_view.FormID = "fregionview"; // form ID
var EW_PAGE_ID = region_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
region_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
region_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
region_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
region_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php $region_view->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $region->TableCaption() ?>
&nbsp;&nbsp;<?php $region_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($region->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $region_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $region_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $region_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $region_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $region_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php
$region_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($region->reg_id->Visible) { // reg_id ?>
	<tr id="r_reg_id"<?php echo $region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $region->reg_id->FldCaption() ?></td>
		<td<?php echo $region->reg_id->CellAttributes() ?>>
<div<?php echo $region->reg_id->ViewAttributes() ?>><?php echo $region->reg_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($region->reg_num->Visible) { // reg_num ?>
	<tr id="r_reg_num"<?php echo $region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $region->reg_num->FldCaption() ?></td>
		<td<?php echo $region->reg_num->CellAttributes() ?>>
<div<?php echo $region->reg_num->ViewAttributes() ?>><?php echo $region->reg_num->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($region->reg_cod->Visible) { // reg_cod ?>
	<tr id="r_reg_cod"<?php echo $region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $region->reg_cod->FldCaption() ?></td>
		<td<?php echo $region->reg_cod->CellAttributes() ?>>
<div<?php echo $region->reg_cod->ViewAttributes() ?>><?php echo $region->reg_cod->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($region->reg_nombre->Visible) { // reg_nombre ?>
	<tr id="r_reg_nombre"<?php echo $region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $region->reg_nombre->FldCaption() ?></td>
		<td<?php echo $region->reg_nombre->CellAttributes() ?>>
<div<?php echo $region->reg_nombre->ViewAttributes() ?>><?php echo $region->reg_nombre->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($region->reg_alias->Visible) { // reg_alias ?>
	<tr id="r_reg_alias"<?php echo $region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $region->reg_alias->FldCaption() ?></td>
		<td<?php echo $region->reg_alias->CellAttributes() ?>>
<div<?php echo $region->reg_alias->ViewAttributes() ?>><?php echo $region->reg_alias->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($region->reg_ordenmapa->Visible) { // reg_ordenmapa ?>
	<tr id="r_reg_ordenmapa"<?php echo $region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $region->reg_ordenmapa->FldCaption() ?></td>
		<td<?php echo $region->reg_ordenmapa->CellAttributes() ?>>
<div<?php echo $region->reg_ordenmapa->ViewAttributes() ?>><?php echo $region->reg_ordenmapa->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php
$region_view->ShowPageFooter();
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
$region_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cregion_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'region';

	// Page object name
	var $PageObjName = 'region_view';

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
	function cregion_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (region)
		if (!isset($GLOBALS["region"])) {
			$GLOBALS["region"] = new cregion();
			$GLOBALS["Table"] =& $GLOBALS["region"];
		}
		$KeyUrl = "";
		if (@$_GET["reg_id"] <> "") {
			$this->RecKey["reg_id"] = $_GET["reg_id"];
			$KeyUrl .= "&reg_id=" . urlencode($this->RecKey["reg_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'region', TRUE);

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
		global $region;

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
		global $Language, $region;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["reg_id"] <> "") {
				$region->reg_id->setQueryStringValue($_GET["reg_id"]);
				$this->RecKey["reg_id"] = $region->reg_id->QueryStringValue;
			} else {
				$sReturnUrl = "regionlist.php"; // Return to list
			}

			// Get action
			$region->CurrentAction = "I"; // Display form
			switch ($region->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "regionlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "regionlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$region->RowType = EW_ROWTYPE_VIEW;
		$region->ResetAttrs();
		$this->RenderRow();
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

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $region;

		// Initialize URLs
		$this->AddUrl = $region->AddUrl();
		$this->EditUrl = $region->EditUrl();
		$this->CopyUrl = $region->CopyUrl();
		$this->DeleteUrl = $region->DeleteUrl();
		$this->ListUrl = $region->ListUrl();

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
}
?>
