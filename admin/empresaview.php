<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "empresainfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$empresa_view = new cempresa_view();
$Page =& $empresa_view;

// Page init
$empresa_view->Page_Init();

// Page main
$empresa_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($empresa->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var empresa_view = new ew_Page("empresa_view");

// page properties
empresa_view.PageID = "view"; // page ID
empresa_view.FormID = "fempresaview"; // form ID
var EW_PAGE_ID = empresa_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
empresa_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
empresa_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
empresa_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
empresa_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php $empresa_view->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $empresa->TableCaption() ?>
&nbsp;&nbsp;<?php $empresa_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($empresa->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $empresa_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $empresa_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $empresa_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $empresa_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $empresa_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="locallist.php?<?php echo EW_TABLE_SHOW_MASTER ?>=empresa&emp_id=<?php echo urlencode(strval($empresa->emp_id->CurrentValue)) ?>"><?php echo $Language->Phrase("ViewPageDetailLink") ?><?php echo $Language->TablePhrase("local", "TblCaption") ?>
</a>
&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php
$empresa_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($empresa->emp_id->Visible) { // emp_id ?>
	<tr id="r_emp_id"<?php echo $empresa->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $empresa->emp_id->FldCaption() ?></td>
		<td<?php echo $empresa->emp_id->CellAttributes() ?>>
<div<?php echo $empresa->emp_id->ViewAttributes() ?>><?php echo $empresa->emp_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($empresa->emp_nomfantasia->Visible) { // emp_nomfantasia ?>
	<tr id="r_emp_nomfantasia"<?php echo $empresa->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $empresa->emp_nomfantasia->FldCaption() ?></td>
		<td<?php echo $empresa->emp_nomfantasia->CellAttributes() ?>>
<div<?php echo $empresa->emp_nomfantasia->ViewAttributes() ?>><?php echo $empresa->emp_nomfantasia->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($empresa->emp_razonsocial->Visible) { // emp_razonsocial ?>
	<tr id="r_emp_razonsocial"<?php echo $empresa->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $empresa->emp_razonsocial->FldCaption() ?></td>
		<td<?php echo $empresa->emp_razonsocial->CellAttributes() ?>>
<div<?php echo $empresa->emp_razonsocial->ViewAttributes() ?>><?php echo $empresa->emp_razonsocial->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($empresa->emp_rut->Visible) { // emp_rut ?>
	<tr id="r_emp_rut"<?php echo $empresa->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $empresa->emp_rut->FldCaption() ?></td>
		<td<?php echo $empresa->emp_rut->CellAttributes() ?>>
<div<?php echo $empresa->emp_rut->ViewAttributes() ?>><?php echo $empresa->emp_rut->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php
$empresa_view->ShowPageFooter();
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
$empresa_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cempresa_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'empresa';

	// Page object name
	var $PageObjName = 'empresa_view';

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
	function cempresa_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (empresa)
		if (!isset($GLOBALS["empresa"])) {
			$GLOBALS["empresa"] = new cempresa();
			$GLOBALS["Table"] =& $GLOBALS["empresa"];
		}
		$KeyUrl = "";
		if (@$_GET["emp_id"] <> "") {
			$this->RecKey["emp_id"] = $_GET["emp_id"];
			$KeyUrl .= "&emp_id=" . urlencode($this->RecKey["emp_id"]);
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
			define("EW_TABLE_NAME", 'empresa', TRUE);

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
		global $empresa;

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
		global $Language, $empresa;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["emp_id"] <> "") {
				$empresa->emp_id->setQueryStringValue($_GET["emp_id"]);
				$this->RecKey["emp_id"] = $empresa->emp_id->QueryStringValue;
			} else {
				$sReturnUrl = "empresalist.php"; // Return to list
			}

			// Get action
			$empresa->CurrentAction = "I"; // Display form
			switch ($empresa->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "empresalist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "empresalist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$empresa->RowType = EW_ROWTYPE_VIEW;
		$empresa->ResetAttrs();
		$this->RenderRow();
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

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $empresa;

		// Initialize URLs
		$this->AddUrl = $empresa->AddUrl();
		$this->EditUrl = $empresa->EditUrl();
		$this->CopyUrl = $empresa->CopyUrl();
		$this->DeleteUrl = $empresa->DeleteUrl();
		$this->ListUrl = $empresa->ListUrl();

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
