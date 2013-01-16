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
$localadherido_view = new clocaladherido_view();
$Page =& $localadherido_view;

// Page init
$localadherido_view->Page_Init();

// Page main
$localadherido_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($localadherido->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var localadherido_view = new ew_Page("localadherido_view");

// page properties
localadherido_view.PageID = "view"; // page ID
localadherido_view.FormID = "flocaladheridoview"; // form ID
var EW_PAGE_ID = localadherido_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
localadherido_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
localadherido_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
localadherido_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
localadherido_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php $localadherido_view->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $localadherido->TableCaption() ?>
&nbsp;&nbsp;<?php $localadherido_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($localadherido->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $localadherido_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $localadherido_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $localadherido_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $localadherido_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $localadherido_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php
$localadherido_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($localadherido->lad_id->Visible) { // lad_id ?>
	<tr id="r_lad_id"<?php echo $localadherido->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $localadherido->lad_id->FldCaption() ?></td>
		<td<?php echo $localadherido->lad_id->CellAttributes() ?>>
<div<?php echo $localadherido->lad_id->ViewAttributes() ?>><?php echo $localadherido->lad_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($localadherido->emp_id->Visible) { // emp_id ?>
	<tr id="r_emp_id"<?php echo $localadherido->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $localadherido->emp_id->FldCaption() ?></td>
		<td<?php echo $localadherido->emp_id->CellAttributes() ?>>
<div<?php echo $localadherido->emp_id->ViewAttributes() ?>><?php echo $localadherido->emp_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($localadherido->cup_id->Visible) { // cup_id ?>
	<tr id="r_cup_id"<?php echo $localadherido->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $localadherido->cup_id->FldCaption() ?></td>
		<td<?php echo $localadherido->cup_id->CellAttributes() ?>>
<div<?php echo $localadherido->cup_id->ViewAttributes() ?>><?php echo $localadherido->cup_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($localadherido->loc_id->Visible) { // loc_id ?>
	<tr id="r_loc_id"<?php echo $localadherido->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $localadherido->loc_id->FldCaption() ?></td>
		<td<?php echo $localadherido->loc_id->CellAttributes() ?>>
<div<?php echo $localadherido->loc_id->ViewAttributes() ?>><?php echo $localadherido->loc_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php
$localadherido_view->ShowPageFooter();
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
$localadherido_view->Page_Terminate();
?>
<?php

//
// Page class
//
class clocaladherido_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'localadherido';

	// Page object name
	var $PageObjName = 'localadherido_view';

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
	function clocaladherido_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (localadherido)
		if (!isset($GLOBALS["localadherido"])) {
			$GLOBALS["localadherido"] = new clocaladherido();
			$GLOBALS["Table"] =& $GLOBALS["localadherido"];
		}
		$KeyUrl = "";
		if (@$_GET["lad_id"] <> "") {
			$this->RecKey["lad_id"] = $_GET["lad_id"];
			$KeyUrl .= "&lad_id=" . urlencode($this->RecKey["lad_id"]);
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
			define("EW_TABLE_NAME", 'localadherido', TRUE);

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
		global $localadherido;

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
		global $Language, $localadherido;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["lad_id"] <> "") {
				$localadherido->lad_id->setQueryStringValue($_GET["lad_id"]);
				$this->RecKey["lad_id"] = $localadherido->lad_id->QueryStringValue;
			} else {
				$sReturnUrl = "localadheridolist.php"; // Return to list
			}

			// Get action
			$localadherido->CurrentAction = "I"; // Display form
			switch ($localadherido->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "localadheridolist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "localadheridolist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$localadherido->RowType = EW_ROWTYPE_VIEW;
		$localadherido->ResetAttrs();
		$this->RenderRow();
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

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $localadherido;

		// Initialize URLs
		$this->AddUrl = $localadherido->AddUrl();
		$this->EditUrl = $localadherido->EditUrl();
		$this->CopyUrl = $localadherido->CopyUrl();
		$this->DeleteUrl = $localadherido->DeleteUrl();
		$this->ListUrl = $localadherido->ListUrl();

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
		}

		// Call Row Rendered event
		if ($localadherido->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$localadherido->Row_Rendered();
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
