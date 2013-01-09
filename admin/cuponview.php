<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "cuponinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$cupon_view = new ccupon_view();
$Page =& $cupon_view;

// Page init
$cupon_view->Page_Init();

// Page main
$cupon_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($cupon->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cupon_view = new ew_Page("cupon_view");

// page properties
cupon_view.PageID = "view"; // page ID
cupon_view.FormID = "fcuponview"; // form ID
var EW_PAGE_ID = cupon_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cupon_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cupon_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cupon_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cupon_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php $cupon_view->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cupon->TableCaption() ?>
&nbsp;&nbsp;<?php $cupon_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($cupon->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $cupon_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $cupon_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $cupon_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $cupon_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $cupon_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php
$cupon_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cupon->cup_id->Visible) { // cup_id ?>
	<tr id="r_cup_id"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_id->FldCaption() ?></td>
		<td<?php echo $cupon->cup_id->CellAttributes() ?>>
<div<?php echo $cupon->cup_id->ViewAttributes() ?>><?php echo $cupon->cup_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon->emp_id->Visible) { // emp_id ?>
	<tr id="r_emp_id"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->emp_id->FldCaption() ?></td>
		<td<?php echo $cupon->emp_id->CellAttributes() ?>>
<div<?php echo $cupon->emp_id->ViewAttributes() ?>><?php echo $cupon->emp_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon->cat_id->Visible) { // cat_id ?>
	<tr id="r_cat_id"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cat_id->FldCaption() ?></td>
		<td<?php echo $cupon->cat_id->CellAttributes() ?>>
<div<?php echo $cupon->cat_id->ViewAttributes() ?>><?php echo $cupon->cat_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_nombre->Visible) { // cup_nombre ?>
	<tr id="r_cup_nombre"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_nombre->FldCaption() ?></td>
		<td<?php echo $cupon->cup_nombre->CellAttributes() ?>>
<div<?php echo $cupon->cup_nombre->ViewAttributes() ?>><?php echo $cupon->cup_nombre->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_preview_nombre->Visible) { // cup_preview_nombre ?>
	<tr id="r_cup_preview_nombre"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_preview_nombre->FldCaption() ?></td>
		<td<?php echo $cupon->cup_preview_nombre->CellAttributes() ?>>
<?php if ($cupon->cup_preview_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($cupon->cup_preview_nombre->Upload->DbValue)) { ?>
<a<?php echo $cupon->cup_preview_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_preview_nombre->UploadPath) . $cupon->cup_preview_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_preview_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($cupon->cup_preview_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_preview_nombre->UploadPath) . $cupon->cup_preview_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_preview_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_preview_tipo->Visible) { // cup_preview_tipo ?>
	<tr id="r_cup_preview_tipo"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_preview_tipo->FldCaption() ?></td>
		<td<?php echo $cupon->cup_preview_tipo->CellAttributes() ?>>
<div<?php echo $cupon->cup_preview_tipo->ViewAttributes() ?>><?php echo $cupon->cup_preview_tipo->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_preview_ancho->Visible) { // cup_preview_ancho ?>
	<tr id="r_cup_preview_ancho"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_preview_ancho->FldCaption() ?></td>
		<td<?php echo $cupon->cup_preview_ancho->CellAttributes() ?>>
<div<?php echo $cupon->cup_preview_ancho->ViewAttributes() ?>><?php echo $cupon->cup_preview_ancho->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_preview_alto->Visible) { // cup_preview_alto ?>
	<tr id="r_cup_preview_alto"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_preview_alto->FldCaption() ?></td>
		<td<?php echo $cupon->cup_preview_alto->CellAttributes() ?>>
<div<?php echo $cupon->cup_preview_alto->ViewAttributes() ?>><?php echo $cupon->cup_preview_alto->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_preview_size->Visible) { // cup_preview_size ?>
	<tr id="r_cup_preview_size"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_preview_size->FldCaption() ?></td>
		<td<?php echo $cupon->cup_preview_size->CellAttributes() ?>>
<div<?php echo $cupon->cup_preview_size->ViewAttributes() ?>><?php echo $cupon->cup_preview_size->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_imagen_nombre->Visible) { // cup_imagen_nombre ?>
	<tr id="r_cup_imagen_nombre"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_imagen_nombre->FldCaption() ?></td>
		<td<?php echo $cupon->cup_imagen_nombre->CellAttributes() ?>>
<?php if ($cupon->cup_imagen_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($cupon->cup_imagen_nombre->Upload->DbValue)) { ?>
<a<?php echo $cupon->cup_imagen_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_imagen_nombre->UploadPath) . $cupon->cup_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_imagen_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($cupon->cup_imagen_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_imagen_nombre->UploadPath) . $cupon->cup_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_imagen_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_imagen_tipo->Visible) { // cup_imagen_tipo ?>
	<tr id="r_cup_imagen_tipo"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_imagen_tipo->FldCaption() ?></td>
		<td<?php echo $cupon->cup_imagen_tipo->CellAttributes() ?>>
<div<?php echo $cupon->cup_imagen_tipo->ViewAttributes() ?>><?php echo $cupon->cup_imagen_tipo->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_imagen_ancho->Visible) { // cup_imagen_ancho ?>
	<tr id="r_cup_imagen_ancho"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_imagen_ancho->FldCaption() ?></td>
		<td<?php echo $cupon->cup_imagen_ancho->CellAttributes() ?>>
<div<?php echo $cupon->cup_imagen_ancho->ViewAttributes() ?>><?php echo $cupon->cup_imagen_ancho->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_imagen_alto->Visible) { // cup_imagen_alto ?>
	<tr id="r_cup_imagen_alto"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_imagen_alto->FldCaption() ?></td>
		<td<?php echo $cupon->cup_imagen_alto->CellAttributes() ?>>
<div<?php echo $cupon->cup_imagen_alto->ViewAttributes() ?>><?php echo $cupon->cup_imagen_alto->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_imagen_size->Visible) { // cup_imagen_size ?>
	<tr id="r_cup_imagen_size"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_imagen_size->FldCaption() ?></td>
		<td<?php echo $cupon->cup_imagen_size->CellAttributes() ?>>
<div<?php echo $cupon->cup_imagen_size->ViewAttributes() ?>><?php echo $cupon->cup_imagen_size->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_vigente->Visible) { // cup_vigente ?>
	<tr id="r_cup_vigente"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_vigente->FldCaption() ?></td>
		<td<?php echo $cupon->cup_vigente->CellAttributes() ?>>
<div<?php echo $cupon->cup_vigente->ViewAttributes() ?>><?php echo $cupon->cup_vigente->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php
$cupon_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cupon->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cupon_view->Page_Terminate();
?>
<?php

//
// Page class
//
class ccupon_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'cupon';

	// Page object name
	var $PageObjName = 'cupon_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cupon;
		if ($cupon->UseTokenInUrl) $PageUrl .= "t=" . $cupon->TableVar . "&"; // Add page token
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
		global $objForm, $cupon;
		if ($cupon->UseTokenInUrl) {
			if ($objForm)
				return ($cupon->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cupon->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccupon_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (cupon)
		if (!isset($GLOBALS["cupon"])) {
			$GLOBALS["cupon"] = new ccupon();
			$GLOBALS["Table"] =& $GLOBALS["cupon"];
		}
		$KeyUrl = "";
		if (@$_GET["cup_id"] <> "") {
			$this->RecKey["cup_id"] = $_GET["cup_id"];
			$KeyUrl .= "&cup_id=" . urlencode($this->RecKey["cup_id"]);
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
			define("EW_TABLE_NAME", 'cupon', TRUE);

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
		global $cupon;

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
		global $Language, $cupon;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["cup_id"] <> "") {
				$cupon->cup_id->setQueryStringValue($_GET["cup_id"]);
				$this->RecKey["cup_id"] = $cupon->cup_id->QueryStringValue;
			} else {
				$sReturnUrl = "cuponlist.php"; // Return to list
			}

			// Get action
			$cupon->CurrentAction = "I"; // Display form
			switch ($cupon->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "cuponlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "cuponlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$cupon->RowType = EW_ROWTYPE_VIEW;
		$cupon->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $cupon;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$cupon->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$cupon->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $cupon->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$cupon->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$cupon->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$cupon->setStartRecordNumber($this->StartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cupon;
		$sFilter = $cupon->KeyFilter();

		// Call Row Selecting event
		$cupon->Row_Selecting($sFilter);

		// Load SQL based on filter
		$cupon->CurrentFilter = $sFilter;
		$sSql = $cupon->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$cupon->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $cupon;
		if (!$rs || $rs->EOF) return;
		$cupon->cup_id->setDbValue($rs->fields('cup_id'));
		$cupon->emp_id->setDbValue($rs->fields('emp_id'));
		$cupon->cat_id->setDbValue($rs->fields('cat_id'));
		$cupon->cup_nombre->setDbValue($rs->fields('cup_nombre'));
		$cupon->cup_preview_nombre->Upload->DbValue = $rs->fields('cup_preview_nombre');
		$cupon->cup_preview_tipo->setDbValue($rs->fields('cup_preview_tipo'));
		$cupon->cup_preview_ancho->setDbValue($rs->fields('cup_preview_ancho'));
		$cupon->cup_preview_alto->setDbValue($rs->fields('cup_preview_alto'));
		$cupon->cup_preview_size->setDbValue($rs->fields('cup_preview_size'));
		$cupon->cup_imagen_nombre->Upload->DbValue = $rs->fields('cup_imagen_nombre');
		$cupon->cup_imagen_tipo->setDbValue($rs->fields('cup_imagen_tipo'));
		$cupon->cup_imagen_ancho->setDbValue($rs->fields('cup_imagen_ancho'));
		$cupon->cup_imagen_alto->setDbValue($rs->fields('cup_imagen_alto'));
		$cupon->cup_imagen_size->setDbValue($rs->fields('cup_imagen_size'));
		$cupon->cup_vigente->setDbValue($rs->fields('cup_vigente'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $cupon;

		// Initialize URLs
		$this->AddUrl = $cupon->AddUrl();
		$this->EditUrl = $cupon->EditUrl();
		$this->CopyUrl = $cupon->CopyUrl();
		$this->DeleteUrl = $cupon->DeleteUrl();
		$this->ListUrl = $cupon->ListUrl();

		// Call Row_Rendering event
		$cupon->Row_Rendering();

		// Common render codes for all row types
		// cup_id
		// emp_id
		// cat_id
		// cup_nombre
		// cup_preview_nombre
		// cup_preview_tipo
		// cup_preview_ancho
		// cup_preview_alto
		// cup_preview_size
		// cup_imagen_nombre
		// cup_imagen_tipo
		// cup_imagen_ancho
		// cup_imagen_alto
		// cup_imagen_size
		// cup_vigente

		if ($cupon->RowType == EW_ROWTYPE_VIEW) { // View row

			// cup_id
			$cupon->cup_id->ViewValue = $cupon->cup_id->CurrentValue;
			$cupon->cup_id->ViewCustomAttributes = "";

			// emp_id
			if (strval($cupon->emp_id->CurrentValue) <> "") {
				$sFilterWrk = "`emp_id` = " . ew_AdjustSql($cupon->emp_id->CurrentValue) . "";
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
					$cupon->emp_id->ViewValue = $rswrk->fields('emp_rut');
					$cupon->emp_id->ViewValue .= ew_ValueSeparator(0,1,$cupon->emp_id) . $rswrk->fields('emp_nomfantasia');
					$cupon->emp_id->ViewValue .= ew_ValueSeparator(0,2,$cupon->emp_id) . $rswrk->fields('emp_razonsocial');
					$rswrk->Close();
				} else {
					$cupon->emp_id->ViewValue = $cupon->emp_id->CurrentValue;
				}
			} else {
				$cupon->emp_id->ViewValue = NULL;
			}
			$cupon->emp_id->ViewCustomAttributes = "";

			// cat_id
			if (strval($cupon->cat_id->CurrentValue) <> "") {
				$sFilterWrk = "`cat_id` = " . ew_AdjustSql($cupon->cat_id->CurrentValue) . "";
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
					$cupon->cat_id->ViewValue = $rswrk->fields('cat_nombre');
					$rswrk->Close();
				} else {
					$cupon->cat_id->ViewValue = $cupon->cat_id->CurrentValue;
				}
			} else {
				$cupon->cat_id->ViewValue = NULL;
			}
			$cupon->cat_id->ViewCustomAttributes = "";

			// cup_nombre
			$cupon->cup_nombre->ViewValue = $cupon->cup_nombre->CurrentValue;
			$cupon->cup_nombre->ViewCustomAttributes = "";

			// cup_preview_nombre
			if (!ew_Empty($cupon->cup_preview_nombre->Upload->DbValue)) {
				$cupon->cup_preview_nombre->ViewValue = $cupon->cup_preview_nombre->Upload->DbValue;
				$cupon->cup_preview_nombre->ImageWidth = 100;
				$cupon->cup_preview_nombre->ImageHeight = 0;
				$cupon->cup_preview_nombre->ImageAlt = $cupon->cup_preview_nombre->FldAlt();
			} else {
				$cupon->cup_preview_nombre->ViewValue = "";
			}
			$cupon->cup_preview_nombre->ViewCustomAttributes = "";

			// cup_preview_tipo
			$cupon->cup_preview_tipo->ViewValue = $cupon->cup_preview_tipo->CurrentValue;
			$cupon->cup_preview_tipo->ViewCustomAttributes = "";

			// cup_preview_ancho
			$cupon->cup_preview_ancho->ViewValue = $cupon->cup_preview_ancho->CurrentValue;
			$cupon->cup_preview_ancho->ViewValue = ew_FormatNumber($cupon->cup_preview_ancho->ViewValue, 0, -2, -2, -2);
			$cupon->cup_preview_ancho->ViewCustomAttributes = "";

			// cup_preview_alto
			$cupon->cup_preview_alto->ViewValue = $cupon->cup_preview_alto->CurrentValue;
			$cupon->cup_preview_alto->ViewValue = ew_FormatNumber($cupon->cup_preview_alto->ViewValue, 0, -2, -2, -2);
			$cupon->cup_preview_alto->ViewCustomAttributes = "";

			// cup_preview_size
			$cupon->cup_preview_size->ViewValue = $cupon->cup_preview_size->CurrentValue;
			$cupon->cup_preview_size->ViewValue = ew_FormatNumber($cupon->cup_preview_size->ViewValue, 0, -2, -2, -2);
			$cupon->cup_preview_size->ViewCustomAttributes = "";

			// cup_imagen_nombre
			if (!ew_Empty($cupon->cup_imagen_nombre->Upload->DbValue)) {
				$cupon->cup_imagen_nombre->ViewValue = $cupon->cup_imagen_nombre->Upload->DbValue;
				$cupon->cup_imagen_nombre->ImageWidth = 100;
				$cupon->cup_imagen_nombre->ImageHeight = 0;
				$cupon->cup_imagen_nombre->ImageAlt = $cupon->cup_imagen_nombre->FldAlt();
			} else {
				$cupon->cup_imagen_nombre->ViewValue = "";
			}
			$cupon->cup_imagen_nombre->ViewCustomAttributes = "";

			// cup_imagen_tipo
			$cupon->cup_imagen_tipo->ViewValue = $cupon->cup_imagen_tipo->CurrentValue;
			$cupon->cup_imagen_tipo->ViewCustomAttributes = "";

			// cup_imagen_ancho
			$cupon->cup_imagen_ancho->ViewValue = $cupon->cup_imagen_ancho->CurrentValue;
			$cupon->cup_imagen_ancho->ViewValue = ew_FormatNumber($cupon->cup_imagen_ancho->ViewValue, 0, -2, -2, -2);
			$cupon->cup_imagen_ancho->ViewCustomAttributes = "";

			// cup_imagen_alto
			$cupon->cup_imagen_alto->ViewValue = $cupon->cup_imagen_alto->CurrentValue;
			$cupon->cup_imagen_alto->ViewValue = ew_FormatNumber($cupon->cup_imagen_alto->ViewValue, 0, -2, -2, -2);
			$cupon->cup_imagen_alto->ViewCustomAttributes = "";

			// cup_imagen_size
			$cupon->cup_imagen_size->ViewValue = $cupon->cup_imagen_size->CurrentValue;
			$cupon->cup_imagen_size->ViewValue = ew_FormatNumber($cupon->cup_imagen_size->ViewValue, 0, -2, -2, -2);
			$cupon->cup_imagen_size->ViewCustomAttributes = "";

			// cup_vigente
			if (strval($cupon->cup_vigente->CurrentValue) <> "") {
				switch ($cupon->cup_vigente->CurrentValue) {
					case "1":
						$cupon->cup_vigente->ViewValue = $cupon->cup_vigente->FldTagCaption(1) <> "" ? $cupon->cup_vigente->FldTagCaption(1) : $cupon->cup_vigente->CurrentValue;
						break;
					case "0":
						$cupon->cup_vigente->ViewValue = $cupon->cup_vigente->FldTagCaption(2) <> "" ? $cupon->cup_vigente->FldTagCaption(2) : $cupon->cup_vigente->CurrentValue;
						break;
					default:
						$cupon->cup_vigente->ViewValue = $cupon->cup_vigente->CurrentValue;
				}
			} else {
				$cupon->cup_vigente->ViewValue = NULL;
			}
			$cupon->cup_vigente->ViewCustomAttributes = "";

			// cup_id
			$cupon->cup_id->LinkCustomAttributes = "";
			$cupon->cup_id->HrefValue = "";
			$cupon->cup_id->TooltipValue = "";

			// emp_id
			$cupon->emp_id->LinkCustomAttributes = "";
			$cupon->emp_id->HrefValue = "";
			$cupon->emp_id->TooltipValue = "";

			// cat_id
			$cupon->cat_id->LinkCustomAttributes = "";
			$cupon->cat_id->HrefValue = "";
			$cupon->cat_id->TooltipValue = "";

			// cup_nombre
			$cupon->cup_nombre->LinkCustomAttributes = "";
			$cupon->cup_nombre->HrefValue = "";
			$cupon->cup_nombre->TooltipValue = "";

			// cup_preview_nombre
			$cupon->cup_preview_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($cupon->cup_preview_nombre->Upload->DbValue)) {
				$cupon->cup_preview_nombre->HrefValue = ew_UploadPathEx(FALSE, $cupon->cup_preview_nombre->UploadPath) . ((!empty($cupon->cup_preview_nombre->ViewValue)) ? $cupon->cup_preview_nombre->ViewValue : $cupon->cup_preview_nombre->CurrentValue); // Add prefix/suffix
				$cupon->cup_preview_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($cupon->Export <> "") $cupon->cup_preview_nombre->HrefValue = ew_ConvertFullUrl($cupon->cup_preview_nombre->HrefValue);
			} else {
				$cupon->cup_preview_nombre->HrefValue = "";
			}
			$cupon->cup_preview_nombre->TooltipValue = "";

			// cup_preview_tipo
			$cupon->cup_preview_tipo->LinkCustomAttributes = "";
			$cupon->cup_preview_tipo->HrefValue = "";
			$cupon->cup_preview_tipo->TooltipValue = "";

			// cup_preview_ancho
			$cupon->cup_preview_ancho->LinkCustomAttributes = "";
			$cupon->cup_preview_ancho->HrefValue = "";
			$cupon->cup_preview_ancho->TooltipValue = "";

			// cup_preview_alto
			$cupon->cup_preview_alto->LinkCustomAttributes = "";
			$cupon->cup_preview_alto->HrefValue = "";
			$cupon->cup_preview_alto->TooltipValue = "";

			// cup_preview_size
			$cupon->cup_preview_size->LinkCustomAttributes = "";
			$cupon->cup_preview_size->HrefValue = "";
			$cupon->cup_preview_size->TooltipValue = "";

			// cup_imagen_nombre
			$cupon->cup_imagen_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($cupon->cup_imagen_nombre->Upload->DbValue)) {
				$cupon->cup_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $cupon->cup_imagen_nombre->UploadPath) . ((!empty($cupon->cup_imagen_nombre->ViewValue)) ? $cupon->cup_imagen_nombre->ViewValue : $cupon->cup_imagen_nombre->CurrentValue); // Add prefix/suffix
				$cupon->cup_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($cupon->Export <> "") $cupon->cup_imagen_nombre->HrefValue = ew_ConvertFullUrl($cupon->cup_imagen_nombre->HrefValue);
			} else {
				$cupon->cup_imagen_nombre->HrefValue = "";
			}
			$cupon->cup_imagen_nombre->TooltipValue = "";

			// cup_imagen_tipo
			$cupon->cup_imagen_tipo->LinkCustomAttributes = "";
			$cupon->cup_imagen_tipo->HrefValue = "";
			$cupon->cup_imagen_tipo->TooltipValue = "";

			// cup_imagen_ancho
			$cupon->cup_imagen_ancho->LinkCustomAttributes = "";
			$cupon->cup_imagen_ancho->HrefValue = "";
			$cupon->cup_imagen_ancho->TooltipValue = "";

			// cup_imagen_alto
			$cupon->cup_imagen_alto->LinkCustomAttributes = "";
			$cupon->cup_imagen_alto->HrefValue = "";
			$cupon->cup_imagen_alto->TooltipValue = "";

			// cup_imagen_size
			$cupon->cup_imagen_size->LinkCustomAttributes = "";
			$cupon->cup_imagen_size->HrefValue = "";
			$cupon->cup_imagen_size->TooltipValue = "";

			// cup_vigente
			$cupon->cup_vigente->LinkCustomAttributes = "";
			$cupon->cup_vigente->HrefValue = "";
			$cupon->cup_vigente->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($cupon->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$cupon->Row_Rendered();
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
