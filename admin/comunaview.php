<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "comunainfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$comuna_view = new ccomuna_view();
$Page =& $comuna_view;

// Page init
$comuna_view->Page_Init();

// Page main
$comuna_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($comuna->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var comuna_view = new ew_Page("comuna_view");

// page properties
comuna_view.PageID = "view"; // page ID
comuna_view.FormID = "fcomunaview"; // form ID
var EW_PAGE_ID = comuna_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
comuna_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
comuna_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
comuna_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
comuna_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php $comuna_view->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $comuna->TableCaption() ?>
&nbsp;&nbsp;<?php $comuna_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($comuna->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $comuna_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $comuna_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $comuna_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $comuna_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $comuna_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php
$comuna_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($comuna->com_id->Visible) { // com_id ?>
	<tr id="r_com_id"<?php echo $comuna->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $comuna->com_id->FldCaption() ?></td>
		<td<?php echo $comuna->com_id->CellAttributes() ?>>
<div<?php echo $comuna->com_id->ViewAttributes() ?>><?php echo $comuna->com_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($comuna->reg_id->Visible) { // reg_id ?>
	<tr id="r_reg_id"<?php echo $comuna->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $comuna->reg_id->FldCaption() ?></td>
		<td<?php echo $comuna->reg_id->CellAttributes() ?>>
<div<?php echo $comuna->reg_id->ViewAttributes() ?>><?php echo $comuna->reg_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($comuna->ciu_id->Visible) { // ciu_id ?>
	<tr id="r_ciu_id"<?php echo $comuna->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $comuna->ciu_id->FldCaption() ?></td>
		<td<?php echo $comuna->ciu_id->CellAttributes() ?>>
<div<?php echo $comuna->ciu_id->ViewAttributes() ?>><?php echo $comuna->ciu_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($comuna->com_nombre->Visible) { // com_nombre ?>
	<tr id="r_com_nombre"<?php echo $comuna->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $comuna->com_nombre->FldCaption() ?></td>
		<td<?php echo $comuna->com_nombre->CellAttributes() ?>>
<div<?php echo $comuna->com_nombre->ViewAttributes() ?>><?php echo $comuna->com_nombre->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php
$comuna_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($comuna->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$comuna_view->Page_Terminate();
?>
<?php

//
// Page class
//
class ccomuna_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'comuna';

	// Page object name
	var $PageObjName = 'comuna_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $comuna;
		if ($comuna->UseTokenInUrl) $PageUrl .= "t=" . $comuna->TableVar . "&"; // Add page token
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
		global $objForm, $comuna;
		if ($comuna->UseTokenInUrl) {
			if ($objForm)
				return ($comuna->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($comuna->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccomuna_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (comuna)
		if (!isset($GLOBALS["comuna"])) {
			$GLOBALS["comuna"] = new ccomuna();
			$GLOBALS["Table"] =& $GLOBALS["comuna"];
		}
		$KeyUrl = "";
		if (@$_GET["com_id"] <> "") {
			$this->RecKey["com_id"] = $_GET["com_id"];
			$KeyUrl .= "&com_id=" . urlencode($this->RecKey["com_id"]);
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
			define("EW_TABLE_NAME", 'comuna', TRUE);

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
		global $comuna;

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
		global $Language, $comuna;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["com_id"] <> "") {
				$comuna->com_id->setQueryStringValue($_GET["com_id"]);
				$this->RecKey["com_id"] = $comuna->com_id->QueryStringValue;
			} else {
				$sReturnUrl = "comunalist.php"; // Return to list
			}

			// Get action
			$comuna->CurrentAction = "I"; // Display form
			switch ($comuna->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "comunalist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "comunalist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$comuna->RowType = EW_ROWTYPE_VIEW;
		$comuna->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $comuna;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$comuna->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$comuna->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $comuna->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$comuna->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$comuna->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$comuna->setStartRecordNumber($this->StartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $comuna;
		$sFilter = $comuna->KeyFilter();

		// Call Row Selecting event
		$comuna->Row_Selecting($sFilter);

		// Load SQL based on filter
		$comuna->CurrentFilter = $sFilter;
		$sSql = $comuna->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$comuna->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $comuna;
		if (!$rs || $rs->EOF) return;
		$comuna->com_id->setDbValue($rs->fields('com_id'));
		$comuna->reg_id->setDbValue($rs->fields('reg_id'));
		$comuna->ciu_id->setDbValue($rs->fields('ciu_id'));
		$comuna->com_nombre->setDbValue($rs->fields('com_nombre'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $comuna;

		// Initialize URLs
		$this->AddUrl = $comuna->AddUrl();
		$this->EditUrl = $comuna->EditUrl();
		$this->CopyUrl = $comuna->CopyUrl();
		$this->DeleteUrl = $comuna->DeleteUrl();
		$this->ListUrl = $comuna->ListUrl();

		// Call Row_Rendering event
		$comuna->Row_Rendering();

		// Common render codes for all row types
		// com_id
		// reg_id
		// ciu_id
		// com_nombre

		if ($comuna->RowType == EW_ROWTYPE_VIEW) { // View row

			// com_id
			$comuna->com_id->ViewValue = $comuna->com_id->CurrentValue;
			$comuna->com_id->ViewCustomAttributes = "";

			// reg_id
			if (strval($comuna->reg_id->CurrentValue) <> "") {
				$sFilterWrk = "`reg_id` = " . ew_AdjustSql($comuna->reg_id->CurrentValue) . "";
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
					$comuna->reg_id->ViewValue = $rswrk->fields('reg_num');
					$comuna->reg_id->ViewValue .= ew_ValueSeparator(0,1,$comuna->reg_id) . $rswrk->fields('reg_nombre');
					$rswrk->Close();
				} else {
					$comuna->reg_id->ViewValue = $comuna->reg_id->CurrentValue;
				}
			} else {
				$comuna->reg_id->ViewValue = NULL;
			}
			$comuna->reg_id->ViewCustomAttributes = "";

			// ciu_id
			if (strval($comuna->ciu_id->CurrentValue) <> "") {
				$sFilterWrk = "`ciu_id` = " . ew_AdjustSql($comuna->ciu_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `ciu_nombre` FROM `ciudad`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `ciu_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$comuna->ciu_id->ViewValue = $rswrk->fields('ciu_nombre');
					$rswrk->Close();
				} else {
					$comuna->ciu_id->ViewValue = $comuna->ciu_id->CurrentValue;
				}
			} else {
				$comuna->ciu_id->ViewValue = NULL;
			}
			$comuna->ciu_id->ViewCustomAttributes = "";

			// com_nombre
			$comuna->com_nombre->ViewValue = $comuna->com_nombre->CurrentValue;
			$comuna->com_nombre->ViewCustomAttributes = "";

			// com_id
			$comuna->com_id->LinkCustomAttributes = "";
			$comuna->com_id->HrefValue = "";
			$comuna->com_id->TooltipValue = "";

			// reg_id
			$comuna->reg_id->LinkCustomAttributes = "";
			$comuna->reg_id->HrefValue = "";
			$comuna->reg_id->TooltipValue = "";

			// ciu_id
			$comuna->ciu_id->LinkCustomAttributes = "";
			$comuna->ciu_id->HrefValue = "";
			$comuna->ciu_id->TooltipValue = "";

			// com_nombre
			$comuna->com_nombre->LinkCustomAttributes = "";
			$comuna->com_nombre->HrefValue = "";
			$comuna->com_nombre->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($comuna->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$comuna->Row_Rendered();
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
