<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "ciudadinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$ciudad_view = new cciudad_view();
$Page =& $ciudad_view;

// Page init
$ciudad_view->Page_Init();

// Page main
$ciudad_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($ciudad->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var ciudad_view = new ew_Page("ciudad_view");

// page properties
ciudad_view.PageID = "view"; // page ID
ciudad_view.FormID = "fciudadview"; // form ID
var EW_PAGE_ID = ciudad_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
ciudad_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
ciudad_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
ciudad_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ciudad_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php $ciudad_view->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ciudad->TableCaption() ?>
&nbsp;&nbsp;<?php $ciudad_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($ciudad->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $ciudad_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ciudad_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ciudad_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ciudad_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $ciudad_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php
$ciudad_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($ciudad->ciu_id->Visible) { // ciu_id ?>
	<tr id="r_ciu_id"<?php echo $ciudad->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ciudad->ciu_id->FldCaption() ?></td>
		<td<?php echo $ciudad->ciu_id->CellAttributes() ?>>
<div<?php echo $ciudad->ciu_id->ViewAttributes() ?>><?php echo $ciudad->ciu_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($ciudad->reg_id->Visible) { // reg_id ?>
	<tr id="r_reg_id"<?php echo $ciudad->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ciudad->reg_id->FldCaption() ?></td>
		<td<?php echo $ciudad->reg_id->CellAttributes() ?>>
<div<?php echo $ciudad->reg_id->ViewAttributes() ?>><?php echo $ciudad->reg_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($ciudad->ciu_nombre->Visible) { // ciu_nombre ?>
	<tr id="r_ciu_nombre"<?php echo $ciudad->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ciudad->ciu_nombre->FldCaption() ?></td>
		<td<?php echo $ciudad->ciu_nombre->CellAttributes() ?>>
<div<?php echo $ciudad->ciu_nombre->ViewAttributes() ?>><?php echo $ciudad->ciu_nombre->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php
$ciudad_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($ciudad->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ciudad_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cciudad_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'ciudad';

	// Page object name
	var $PageObjName = 'ciudad_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $ciudad;
		if ($ciudad->UseTokenInUrl) $PageUrl .= "t=" . $ciudad->TableVar . "&"; // Add page token
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
		global $objForm, $ciudad;
		if ($ciudad->UseTokenInUrl) {
			if ($objForm)
				return ($ciudad->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($ciudad->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cciudad_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (ciudad)
		if (!isset($GLOBALS["ciudad"])) {
			$GLOBALS["ciudad"] = new cciudad();
			$GLOBALS["Table"] =& $GLOBALS["ciudad"];
		}
		$KeyUrl = "";
		if (@$_GET["ciu_id"] <> "") {
			$this->RecKey["ciu_id"] = $_GET["ciu_id"];
			$KeyUrl .= "&ciu_id=" . urlencode($this->RecKey["ciu_id"]);
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
			define("EW_TABLE_NAME", 'ciudad', TRUE);

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
		global $ciudad;

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
		global $Language, $ciudad;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["ciu_id"] <> "") {
				$ciudad->ciu_id->setQueryStringValue($_GET["ciu_id"]);
				$this->RecKey["ciu_id"] = $ciudad->ciu_id->QueryStringValue;
			} else {
				$sReturnUrl = "ciudadlist.php"; // Return to list
			}

			// Get action
			$ciudad->CurrentAction = "I"; // Display form
			switch ($ciudad->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "ciudadlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "ciudadlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$ciudad->RowType = EW_ROWTYPE_VIEW;
		$ciudad->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $ciudad;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$ciudad->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$ciudad->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $ciudad->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$ciudad->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$ciudad->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$ciudad->setStartRecordNumber($this->StartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $ciudad;
		$sFilter = $ciudad->KeyFilter();

		// Call Row Selecting event
		$ciudad->Row_Selecting($sFilter);

		// Load SQL based on filter
		$ciudad->CurrentFilter = $sFilter;
		$sSql = $ciudad->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$ciudad->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $ciudad;
		if (!$rs || $rs->EOF) return;
		$ciudad->ciu_id->setDbValue($rs->fields('ciu_id'));
		$ciudad->reg_id->setDbValue($rs->fields('reg_id'));
		$ciudad->ciu_nombre->setDbValue($rs->fields('ciu_nombre'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $ciudad;

		// Initialize URLs
		$this->AddUrl = $ciudad->AddUrl();
		$this->EditUrl = $ciudad->EditUrl();
		$this->CopyUrl = $ciudad->CopyUrl();
		$this->DeleteUrl = $ciudad->DeleteUrl();
		$this->ListUrl = $ciudad->ListUrl();

		// Call Row_Rendering event
		$ciudad->Row_Rendering();

		// Common render codes for all row types
		// ciu_id
		// reg_id
		// ciu_nombre

		if ($ciudad->RowType == EW_ROWTYPE_VIEW) { // View row

			// ciu_id
			$ciudad->ciu_id->ViewValue = $ciudad->ciu_id->CurrentValue;
			$ciudad->ciu_id->ViewCustomAttributes = "";

			// reg_id
			if (strval($ciudad->reg_id->CurrentValue) <> "") {
				$sFilterWrk = "`reg_id` = " . ew_AdjustSql($ciudad->reg_id->CurrentValue) . "";
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
					$ciudad->reg_id->ViewValue = $rswrk->fields('reg_num');
					$ciudad->reg_id->ViewValue .= ew_ValueSeparator(0,1,$ciudad->reg_id) . $rswrk->fields('reg_nombre');
					$rswrk->Close();
				} else {
					$ciudad->reg_id->ViewValue = $ciudad->reg_id->CurrentValue;
				}
			} else {
				$ciudad->reg_id->ViewValue = NULL;
			}
			$ciudad->reg_id->ViewCustomAttributes = "";

			// ciu_nombre
			$ciudad->ciu_nombre->ViewValue = $ciudad->ciu_nombre->CurrentValue;
			$ciudad->ciu_nombre->ViewCustomAttributes = "";

			// ciu_id
			$ciudad->ciu_id->LinkCustomAttributes = "";
			$ciudad->ciu_id->HrefValue = "";
			$ciudad->ciu_id->TooltipValue = "";

			// reg_id
			$ciudad->reg_id->LinkCustomAttributes = "";
			$ciudad->reg_id->HrefValue = "";
			$ciudad->reg_id->TooltipValue = "";

			// ciu_nombre
			$ciudad->ciu_nombre->LinkCustomAttributes = "";
			$ciudad->ciu_nombre->HrefValue = "";
			$ciudad->ciu_nombre->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($ciudad->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$ciudad->Row_Rendered();
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
