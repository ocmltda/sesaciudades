<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "localinfo.php" ?>
<?php include_once "empresainfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$local_view = new clocal_view();
$Page =& $local_view;

// Page init
$local_view->Page_Init();

// Page main
$local_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($local->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var local_view = new ew_Page("local_view");

// page properties
local_view.PageID = "view"; // page ID
local_view.FormID = "flocalview"; // form ID
var EW_PAGE_ID = local_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
local_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
local_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
local_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
local_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php $local_view->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $local->TableCaption() ?>
&nbsp;&nbsp;<?php $local_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($local->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $local_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $local_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $local_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $local_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $local_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php
$local_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($local->loc_id->Visible) { // loc_id ?>
	<tr id="r_loc_id"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->loc_id->FldCaption() ?></td>
		<td<?php echo $local->loc_id->CellAttributes() ?>>
<div<?php echo $local->loc_id->ViewAttributes() ?>><?php echo $local->loc_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($local->emp_id->Visible) { // emp_id ?>
	<tr id="r_emp_id"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->emp_id->FldCaption() ?></td>
		<td<?php echo $local->emp_id->CellAttributes() ?>>
<div<?php echo $local->emp_id->ViewAttributes() ?>><?php echo $local->emp_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($local->loc_nombre->Visible) { // loc_nombre ?>
	<tr id="r_loc_nombre"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->loc_nombre->FldCaption() ?></td>
		<td<?php echo $local->loc_nombre->CellAttributes() ?>>
<div<?php echo $local->loc_nombre->ViewAttributes() ?>><?php echo $local->loc_nombre->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($local->loc_direccion->Visible) { // loc_direccion ?>
	<tr id="r_loc_direccion"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->loc_direccion->FldCaption() ?></td>
		<td<?php echo $local->loc_direccion->CellAttributes() ?>>
<div<?php echo $local->loc_direccion->ViewAttributes() ?>><?php echo $local->loc_direccion->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($local->loc_googlemaps->Visible) { // loc_googlemaps ?>
	<tr id="r_loc_googlemaps"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->loc_googlemaps->FldCaption() ?></td>
		<td<?php echo $local->loc_googlemaps->CellAttributes() ?>>
<div<?php echo $local->loc_googlemaps->ViewAttributes() ?>><?php echo $local->loc_googlemaps->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($local->loc_vigente->Visible) { // loc_vigente ?>
	<tr id="r_loc_vigente"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->loc_vigente->FldCaption() ?></td>
		<td<?php echo $local->loc_vigente->CellAttributes() ?>>
<div<?php echo $local->loc_vigente->ViewAttributes() ?>><?php echo $local->loc_vigente->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($local->loc_comuna->Visible) { // loc_comuna ?>
	<tr id="r_loc_comuna"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->loc_comuna->FldCaption() ?></td>
		<td<?php echo $local->loc_comuna->CellAttributes() ?>>
<div<?php echo $local->loc_comuna->ViewAttributes() ?>><?php echo $local->loc_comuna->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($local->loc_ciudad->Visible) { // loc_ciudad ?>
	<tr id="r_loc_ciudad"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->loc_ciudad->FldCaption() ?></td>
		<td<?php echo $local->loc_ciudad->CellAttributes() ?>>
<div<?php echo $local->loc_ciudad->ViewAttributes() ?>><?php echo $local->loc_ciudad->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php
$local_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($local->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$local_view->Page_Terminate();
?>
<?php

//
// Page class
//
class clocal_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'local';

	// Page object name
	var $PageObjName = 'local_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $local;
		if ($local->UseTokenInUrl) $PageUrl .= "t=" . $local->TableVar . "&"; // Add page token
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
		global $objForm, $local;
		if ($local->UseTokenInUrl) {
			if ($objForm)
				return ($local->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($local->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function clocal_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (local)
		if (!isset($GLOBALS["local"])) {
			$GLOBALS["local"] = new clocal();
			$GLOBALS["Table"] =& $GLOBALS["local"];
		}
		$KeyUrl = "";
		if (@$_GET["loc_id"] <> "") {
			$this->RecKey["loc_id"] = $_GET["loc_id"];
			$KeyUrl .= "&loc_id=" . urlencode($this->RecKey["loc_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (empresa)
		if (!isset($GLOBALS['empresa'])) $GLOBALS['empresa'] = new cempresa();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'local', TRUE);

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
		global $local;

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
		global $Language, $local;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["loc_id"] <> "") {
				$local->loc_id->setQueryStringValue($_GET["loc_id"]);
				$this->RecKey["loc_id"] = $local->loc_id->QueryStringValue;
			} else {
				$sReturnUrl = "locallist.php"; // Return to list
			}

			// Get action
			$local->CurrentAction = "I"; // Display form
			switch ($local->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "locallist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "locallist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$local->RowType = EW_ROWTYPE_VIEW;
		$local->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $local;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$local->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$local->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $local->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$local->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$local->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$local->setStartRecordNumber($this->StartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $local;
		$sFilter = $local->KeyFilter();

		// Call Row Selecting event
		$local->Row_Selecting($sFilter);

		// Load SQL based on filter
		$local->CurrentFilter = $sFilter;
		$sSql = $local->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$local->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $local;
		if (!$rs || $rs->EOF) return;
		$local->loc_id->setDbValue($rs->fields('loc_id'));
		$local->emp_id->setDbValue($rs->fields('emp_id'));
		$local->loc_nombre->setDbValue($rs->fields('loc_nombre'));
		$local->loc_direccion->setDbValue($rs->fields('loc_direccion'));
		$local->loc_googlemaps->setDbValue($rs->fields('loc_googlemaps'));
		$local->loc_vigente->setDbValue($rs->fields('loc_vigente'));
		$local->loc_comuna->setDbValue($rs->fields('loc_comuna'));
		$local->loc_ciudad->setDbValue($rs->fields('loc_ciudad'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $local;

		// Initialize URLs
		$this->AddUrl = $local->AddUrl();
		$this->EditUrl = $local->EditUrl();
		$this->CopyUrl = $local->CopyUrl();
		$this->DeleteUrl = $local->DeleteUrl();
		$this->ListUrl = $local->ListUrl();

		// Call Row_Rendering event
		$local->Row_Rendering();

		// Common render codes for all row types
		// loc_id
		// emp_id
		// loc_nombre
		// loc_direccion
		// loc_googlemaps
		// loc_vigente
		// loc_comuna
		// loc_ciudad

		if ($local->RowType == EW_ROWTYPE_VIEW) { // View row

			// loc_id
			$local->loc_id->ViewValue = $local->loc_id->CurrentValue;
			$local->loc_id->ViewCustomAttributes = "";

			// emp_id
			if (strval($local->emp_id->CurrentValue) <> "") {
				$sFilterWrk = "`emp_id` = " . ew_AdjustSql($local->emp_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `emp_rut`, `emp_nomfantasia`, `emp_razonsocial` FROM `empresa`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `emp_rut` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$local->emp_id->ViewValue = $rswrk->fields('emp_rut');
					$local->emp_id->ViewValue .= ew_ValueSeparator(0,1,$local->emp_id) . $rswrk->fields('emp_nomfantasia');
					$local->emp_id->ViewValue .= ew_ValueSeparator(0,2,$local->emp_id) . $rswrk->fields('emp_razonsocial');
					$rswrk->Close();
				} else {
					$local->emp_id->ViewValue = $local->emp_id->CurrentValue;
				}
			} else {
				$local->emp_id->ViewValue = NULL;
			}
			$local->emp_id->ViewCustomAttributes = "";

			// loc_nombre
			$local->loc_nombre->ViewValue = $local->loc_nombre->CurrentValue;
			$local->loc_nombre->ViewCustomAttributes = "";

			// loc_direccion
			$local->loc_direccion->ViewValue = $local->loc_direccion->CurrentValue;
			$local->loc_direccion->ViewCustomAttributes = "";

			// loc_googlemaps
			$local->loc_googlemaps->ViewValue = $local->loc_googlemaps->CurrentValue;
			$local->loc_googlemaps->ViewCustomAttributes = "";

			// loc_vigente
			if (strval($local->loc_vigente->CurrentValue) <> "") {
				switch ($local->loc_vigente->CurrentValue) {
					case "1":
						$local->loc_vigente->ViewValue = $local->loc_vigente->FldTagCaption(1) <> "" ? $local->loc_vigente->FldTagCaption(1) : $local->loc_vigente->CurrentValue;
						break;
					case "0":
						$local->loc_vigente->ViewValue = $local->loc_vigente->FldTagCaption(2) <> "" ? $local->loc_vigente->FldTagCaption(2) : $local->loc_vigente->CurrentValue;
						break;
					default:
						$local->loc_vigente->ViewValue = $local->loc_vigente->CurrentValue;
				}
			} else {
				$local->loc_vigente->ViewValue = NULL;
			}
			$local->loc_vigente->ViewCustomAttributes = "";

			// loc_comuna
			$local->loc_comuna->ViewValue = $local->loc_comuna->CurrentValue;
			$local->loc_comuna->ViewCustomAttributes = "";

			// loc_ciudad
			$local->loc_ciudad->ViewValue = $local->loc_ciudad->CurrentValue;
			$local->loc_ciudad->ViewCustomAttributes = "";

			// loc_id
			$local->loc_id->LinkCustomAttributes = "";
			$local->loc_id->HrefValue = "";
			$local->loc_id->TooltipValue = "";

			// emp_id
			$local->emp_id->LinkCustomAttributes = "";
			$local->emp_id->HrefValue = "";
			$local->emp_id->TooltipValue = "";

			// loc_nombre
			$local->loc_nombre->LinkCustomAttributes = "";
			$local->loc_nombre->HrefValue = "";
			$local->loc_nombre->TooltipValue = "";

			// loc_direccion
			$local->loc_direccion->LinkCustomAttributes = "";
			$local->loc_direccion->HrefValue = "";
			$local->loc_direccion->TooltipValue = "";

			// loc_googlemaps
			$local->loc_googlemaps->LinkCustomAttributes = "";
			$local->loc_googlemaps->HrefValue = "";
			$local->loc_googlemaps->TooltipValue = "";

			// loc_vigente
			$local->loc_vigente->LinkCustomAttributes = "";
			$local->loc_vigente->HrefValue = "";
			$local->loc_vigente->TooltipValue = "";

			// loc_comuna
			$local->loc_comuna->LinkCustomAttributes = "";
			$local->loc_comuna->HrefValue = "";
			$local->loc_comuna->TooltipValue = "";

			// loc_ciudad
			$local->loc_ciudad->LinkCustomAttributes = "";
			$local->loc_ciudad->HrefValue = "";
			$local->loc_ciudad->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($local->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$local->Row_Rendered();
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
