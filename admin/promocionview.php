<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "promocioninfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$promocion_view = new cpromocion_view();
$Page =& $promocion_view;

// Page init
$promocion_view->Page_Init();

// Page main
$promocion_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($promocion->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var promocion_view = new ew_Page("promocion_view");

// page properties
promocion_view.PageID = "view"; // page ID
promocion_view.FormID = "fpromocionview"; // form ID
var EW_PAGE_ID = promocion_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
promocion_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
promocion_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
promocion_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
promocion_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php $promocion_view->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $promocion->TableCaption() ?>
&nbsp;&nbsp;<?php $promocion_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($promocion->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $promocion_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $promocion_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $promocion_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $promocion_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $promocion_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php
$promocion_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($promocion->pro_id->Visible) { // pro_id ?>
	<tr id="r_pro_id"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_id->FldCaption() ?></td>
		<td<?php echo $promocion->pro_id->CellAttributes() ?>>
<div<?php echo $promocion->pro_id->ViewAttributes() ?>><?php echo $promocion->pro_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($promocion->pro_titulo->Visible) { // pro_titulo ?>
	<tr id="r_pro_titulo"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_titulo->FldCaption() ?></td>
		<td<?php echo $promocion->pro_titulo->CellAttributes() ?>>
<div<?php echo $promocion->pro_titulo->ViewAttributes() ?>><?php echo $promocion->pro_titulo->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($promocion->pro_texto->Visible) { // pro_texto ?>
	<tr id="r_pro_texto"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_texto->FldCaption() ?></td>
		<td<?php echo $promocion->pro_texto->CellAttributes() ?>>
<div<?php echo $promocion->pro_texto->ViewAttributes() ?>><?php echo $promocion->pro_texto->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($promocion->pro_imagen_nombre->Visible) { // pro_imagen_nombre ?>
	<tr id="r_pro_imagen_nombre"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_imagen_nombre->FldCaption() ?></td>
		<td<?php echo $promocion->pro_imagen_nombre->CellAttributes() ?>>
<?php if ($promocion->pro_imagen_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($promocion->pro_imagen_nombre->Upload->DbValue)) { ?>
<a<?php echo $promocion->pro_imagen_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $promocion->pro_imagen_nombre->UploadPath) . $promocion->pro_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $promocion->pro_imagen_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($promocion->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($promocion->pro_imagen_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $promocion->pro_imagen_nombre->UploadPath) . $promocion->pro_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $promocion->pro_imagen_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($promocion->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</td>
	</tr>
<?php } ?>
<?php if ($promocion->pro_imagen_tipo->Visible) { // pro_imagen_tipo ?>
	<tr id="r_pro_imagen_tipo"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_imagen_tipo->FldCaption() ?></td>
		<td<?php echo $promocion->pro_imagen_tipo->CellAttributes() ?>>
<div<?php echo $promocion->pro_imagen_tipo->ViewAttributes() ?>><?php echo $promocion->pro_imagen_tipo->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($promocion->pro_imagen_ancho->Visible) { // pro_imagen_ancho ?>
	<tr id="r_pro_imagen_ancho"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_imagen_ancho->FldCaption() ?></td>
		<td<?php echo $promocion->pro_imagen_ancho->CellAttributes() ?>>
<div<?php echo $promocion->pro_imagen_ancho->ViewAttributes() ?>><?php echo $promocion->pro_imagen_ancho->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($promocion->pro_imagen_alto->Visible) { // pro_imagen_alto ?>
	<tr id="r_pro_imagen_alto"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_imagen_alto->FldCaption() ?></td>
		<td<?php echo $promocion->pro_imagen_alto->CellAttributes() ?>>
<div<?php echo $promocion->pro_imagen_alto->ViewAttributes() ?>><?php echo $promocion->pro_imagen_alto->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($promocion->pro_imagen_size->Visible) { // pro_imagen_size ?>
	<tr id="r_pro_imagen_size"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_imagen_size->FldCaption() ?></td>
		<td<?php echo $promocion->pro_imagen_size->CellAttributes() ?>>
<div<?php echo $promocion->pro_imagen_size->ViewAttributes() ?>><?php echo $promocion->pro_imagen_size->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($promocion->pro_vigente->Visible) { // pro_vigente ?>
	<tr id="r_pro_vigente"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_vigente->FldCaption() ?></td>
		<td<?php echo $promocion->pro_vigente->CellAttributes() ?>>
<div<?php echo $promocion->pro_vigente->ViewAttributes() ?>><?php echo $promocion->pro_vigente->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php
$promocion_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($promocion->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$promocion_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cpromocion_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'promocion';

	// Page object name
	var $PageObjName = 'promocion_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $promocion;
		if ($promocion->UseTokenInUrl) $PageUrl .= "t=" . $promocion->TableVar . "&"; // Add page token
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
		global $objForm, $promocion;
		if ($promocion->UseTokenInUrl) {
			if ($objForm)
				return ($promocion->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($promocion->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cpromocion_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (promocion)
		if (!isset($GLOBALS["promocion"])) {
			$GLOBALS["promocion"] = new cpromocion();
			$GLOBALS["Table"] =& $GLOBALS["promocion"];
		}
		$KeyUrl = "";
		if (@$_GET["pro_id"] <> "") {
			$this->RecKey["pro_id"] = $_GET["pro_id"];
			$KeyUrl .= "&pro_id=" . urlencode($this->RecKey["pro_id"]);
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
			define("EW_TABLE_NAME", 'promocion', TRUE);

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
		global $promocion;

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
		global $Language, $promocion;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["pro_id"] <> "") {
				$promocion->pro_id->setQueryStringValue($_GET["pro_id"]);
				$this->RecKey["pro_id"] = $promocion->pro_id->QueryStringValue;
			} else {
				$sReturnUrl = "promocionlist.php"; // Return to list
			}

			// Get action
			$promocion->CurrentAction = "I"; // Display form
			switch ($promocion->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "promocionlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "promocionlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$promocion->RowType = EW_ROWTYPE_VIEW;
		$promocion->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $promocion;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$promocion->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$promocion->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $promocion->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$promocion->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$promocion->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$promocion->setStartRecordNumber($this->StartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $promocion;
		$sFilter = $promocion->KeyFilter();

		// Call Row Selecting event
		$promocion->Row_Selecting($sFilter);

		// Load SQL based on filter
		$promocion->CurrentFilter = $sFilter;
		$sSql = $promocion->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$promocion->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $promocion;
		if (!$rs || $rs->EOF) return;
		$promocion->pro_id->setDbValue($rs->fields('pro_id'));
		$promocion->pro_titulo->setDbValue($rs->fields('pro_titulo'));
		$promocion->pro_texto->setDbValue($rs->fields('pro_texto'));
		$promocion->pro_imagen_nombre->Upload->DbValue = $rs->fields('pro_imagen_nombre');
		$promocion->pro_imagen_tipo->setDbValue($rs->fields('pro_imagen_tipo'));
		$promocion->pro_imagen_ancho->setDbValue($rs->fields('pro_imagen_ancho'));
		$promocion->pro_imagen_alto->setDbValue($rs->fields('pro_imagen_alto'));
		$promocion->pro_imagen_size->setDbValue($rs->fields('pro_imagen_size'));
		$promocion->pro_vigente->setDbValue($rs->fields('pro_vigente'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $promocion;

		// Initialize URLs
		$this->AddUrl = $promocion->AddUrl();
		$this->EditUrl = $promocion->EditUrl();
		$this->CopyUrl = $promocion->CopyUrl();
		$this->DeleteUrl = $promocion->DeleteUrl();
		$this->ListUrl = $promocion->ListUrl();

		// Call Row_Rendering event
		$promocion->Row_Rendering();

		// Common render codes for all row types
		// pro_id
		// pro_titulo
		// pro_texto
		// pro_imagen_nombre
		// pro_imagen_tipo
		// pro_imagen_ancho
		// pro_imagen_alto
		// pro_imagen_size
		// pro_vigente

		if ($promocion->RowType == EW_ROWTYPE_VIEW) { // View row

			// pro_id
			$promocion->pro_id->ViewValue = $promocion->pro_id->CurrentValue;
			$promocion->pro_id->ViewCustomAttributes = "";

			// pro_titulo
			$promocion->pro_titulo->ViewValue = $promocion->pro_titulo->CurrentValue;
			$promocion->pro_titulo->ViewCustomAttributes = "";

			// pro_texto
			$promocion->pro_texto->ViewValue = $promocion->pro_texto->CurrentValue;
			$promocion->pro_texto->ViewCustomAttributes = "";

			// pro_imagen_nombre
			if (!ew_Empty($promocion->pro_imagen_nombre->Upload->DbValue)) {
				$promocion->pro_imagen_nombre->ViewValue = $promocion->pro_imagen_nombre->Upload->DbValue;
				$promocion->pro_imagen_nombre->ImageWidth = 100;
				$promocion->pro_imagen_nombre->ImageHeight = 0;
				$promocion->pro_imagen_nombre->ImageAlt = $promocion->pro_imagen_nombre->FldAlt();
			} else {
				$promocion->pro_imagen_nombre->ViewValue = "";
			}
			$promocion->pro_imagen_nombre->ViewCustomAttributes = "";

			// pro_imagen_tipo
			$promocion->pro_imagen_tipo->ViewValue = $promocion->pro_imagen_tipo->CurrentValue;
			$promocion->pro_imagen_tipo->ViewCustomAttributes = "";

			// pro_imagen_ancho
			$promocion->pro_imagen_ancho->ViewValue = $promocion->pro_imagen_ancho->CurrentValue;
			$promocion->pro_imagen_ancho->ViewValue = ew_FormatNumber($promocion->pro_imagen_ancho->ViewValue, 0, -2, -2, -2);
			$promocion->pro_imagen_ancho->ViewCustomAttributes = "";

			// pro_imagen_alto
			$promocion->pro_imagen_alto->ViewValue = $promocion->pro_imagen_alto->CurrentValue;
			$promocion->pro_imagen_alto->ViewValue = ew_FormatNumber($promocion->pro_imagen_alto->ViewValue, 0, -2, -2, -2);
			$promocion->pro_imagen_alto->ViewCustomAttributes = "";

			// pro_imagen_size
			$promocion->pro_imagen_size->ViewValue = $promocion->pro_imagen_size->CurrentValue;
			$promocion->pro_imagen_size->ViewValue = ew_FormatNumber($promocion->pro_imagen_size->ViewValue, 0, -2, -2, -2);
			$promocion->pro_imagen_size->ViewCustomAttributes = "";

			// pro_vigente
			if (strval($promocion->pro_vigente->CurrentValue) <> "") {
				switch ($promocion->pro_vigente->CurrentValue) {
					case "1":
						$promocion->pro_vigente->ViewValue = $promocion->pro_vigente->FldTagCaption(1) <> "" ? $promocion->pro_vigente->FldTagCaption(1) : $promocion->pro_vigente->CurrentValue;
						break;
					case "0":
						$promocion->pro_vigente->ViewValue = $promocion->pro_vigente->FldTagCaption(2) <> "" ? $promocion->pro_vigente->FldTagCaption(2) : $promocion->pro_vigente->CurrentValue;
						break;
					default:
						$promocion->pro_vigente->ViewValue = $promocion->pro_vigente->CurrentValue;
				}
			} else {
				$promocion->pro_vigente->ViewValue = NULL;
			}
			$promocion->pro_vigente->ViewCustomAttributes = "";

			// pro_id
			$promocion->pro_id->LinkCustomAttributes = "";
			$promocion->pro_id->HrefValue = "";
			$promocion->pro_id->TooltipValue = "";

			// pro_titulo
			$promocion->pro_titulo->LinkCustomAttributes = "";
			$promocion->pro_titulo->HrefValue = "";
			$promocion->pro_titulo->TooltipValue = "";

			// pro_texto
			$promocion->pro_texto->LinkCustomAttributes = "";
			$promocion->pro_texto->HrefValue = "";
			$promocion->pro_texto->TooltipValue = "";

			// pro_imagen_nombre
			$promocion->pro_imagen_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($promocion->pro_imagen_nombre->Upload->DbValue)) {
				$promocion->pro_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $promocion->pro_imagen_nombre->UploadPath) . ((!empty($promocion->pro_imagen_nombre->ViewValue)) ? $promocion->pro_imagen_nombre->ViewValue : $promocion->pro_imagen_nombre->CurrentValue); // Add prefix/suffix
				$promocion->pro_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($promocion->Export <> "") $promocion->pro_imagen_nombre->HrefValue = ew_ConvertFullUrl($promocion->pro_imagen_nombre->HrefValue);
			} else {
				$promocion->pro_imagen_nombre->HrefValue = "";
			}
			$promocion->pro_imagen_nombre->TooltipValue = "";

			// pro_imagen_tipo
			$promocion->pro_imagen_tipo->LinkCustomAttributes = "";
			$promocion->pro_imagen_tipo->HrefValue = "";
			$promocion->pro_imagen_tipo->TooltipValue = "";

			// pro_imagen_ancho
			$promocion->pro_imagen_ancho->LinkCustomAttributes = "";
			$promocion->pro_imagen_ancho->HrefValue = "";
			$promocion->pro_imagen_ancho->TooltipValue = "";

			// pro_imagen_alto
			$promocion->pro_imagen_alto->LinkCustomAttributes = "";
			$promocion->pro_imagen_alto->HrefValue = "";
			$promocion->pro_imagen_alto->TooltipValue = "";

			// pro_imagen_size
			$promocion->pro_imagen_size->LinkCustomAttributes = "";
			$promocion->pro_imagen_size->HrefValue = "";
			$promocion->pro_imagen_size->TooltipValue = "";

			// pro_vigente
			$promocion->pro_vigente->LinkCustomAttributes = "";
			$promocion->pro_vigente->HrefValue = "";
			$promocion->pro_vigente->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($promocion->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$promocion->Row_Rendered();
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
