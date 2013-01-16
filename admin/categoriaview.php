<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "categoriainfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$categoria_view = new ccategoria_view();
$Page =& $categoria_view;

// Page init
$categoria_view->Page_Init();

// Page main
$categoria_view->Page_Main();
?>
<?php include_once "header.php" ?>
<?php if ($categoria->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var categoria_view = new ew_Page("categoria_view");

// page properties
categoria_view.PageID = "view"; // page ID
categoria_view.FormID = "fcategoriaview"; // form ID
var EW_PAGE_ID = categoria_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
categoria_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
categoria_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
categoria_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
categoria_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php $categoria_view->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $categoria->TableCaption() ?>
&nbsp;&nbsp;<?php $categoria_view->ExportOptions->Render("body"); ?>
</p>
<?php if ($categoria->Export == "") { ?>
<p class="phpmaker">
<a href="<?php echo $categoria_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $categoria_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $categoria_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $categoria_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $categoria_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php
$categoria_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($categoria->cat_id->Visible) { // cat_id ?>
	<tr id="r_cat_id"<?php echo $categoria->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $categoria->cat_id->FldCaption() ?></td>
		<td<?php echo $categoria->cat_id->CellAttributes() ?>>
<div<?php echo $categoria->cat_id->ViewAttributes() ?>><?php echo $categoria->cat_id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($categoria->cat_nombre->Visible) { // cat_nombre ?>
	<tr id="r_cat_nombre"<?php echo $categoria->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $categoria->cat_nombre->FldCaption() ?></td>
		<td<?php echo $categoria->cat_nombre->CellAttributes() ?>>
<div<?php echo $categoria->cat_nombre->ViewAttributes() ?>><?php echo $categoria->cat_nombre->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($categoria->cat_imagen_nombre->Visible) { // cat_imagen_nombre ?>
	<tr id="r_cat_imagen_nombre"<?php echo $categoria->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $categoria->cat_imagen_nombre->FldCaption() ?></td>
		<td<?php echo $categoria->cat_imagen_nombre->CellAttributes() ?>>
<?php if ($categoria->cat_imagen_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($categoria->cat_imagen_nombre->Upload->DbValue)) { ?>
<a<?php echo $categoria->cat_imagen_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $categoria->cat_imagen_nombre->UploadPath) . $categoria->cat_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $categoria->cat_imagen_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($categoria->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($categoria->cat_imagen_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $categoria->cat_imagen_nombre->UploadPath) . $categoria->cat_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $categoria->cat_imagen_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($categoria->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</td>
	</tr>
<?php } ?>
<?php if ($categoria->cat_imagen_tipo->Visible) { // cat_imagen_tipo ?>
	<tr id="r_cat_imagen_tipo"<?php echo $categoria->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $categoria->cat_imagen_tipo->FldCaption() ?></td>
		<td<?php echo $categoria->cat_imagen_tipo->CellAttributes() ?>>
<div<?php echo $categoria->cat_imagen_tipo->ViewAttributes() ?>><?php echo $categoria->cat_imagen_tipo->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($categoria->cat_imagen_ancho->Visible) { // cat_imagen_ancho ?>
	<tr id="r_cat_imagen_ancho"<?php echo $categoria->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $categoria->cat_imagen_ancho->FldCaption() ?></td>
		<td<?php echo $categoria->cat_imagen_ancho->CellAttributes() ?>>
<div<?php echo $categoria->cat_imagen_ancho->ViewAttributes() ?>><?php echo $categoria->cat_imagen_ancho->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($categoria->cat_imagen_alto->Visible) { // cat_imagen_alto ?>
	<tr id="r_cat_imagen_alto"<?php echo $categoria->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $categoria->cat_imagen_alto->FldCaption() ?></td>
		<td<?php echo $categoria->cat_imagen_alto->CellAttributes() ?>>
<div<?php echo $categoria->cat_imagen_alto->ViewAttributes() ?>><?php echo $categoria->cat_imagen_alto->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($categoria->cat_imagen_size->Visible) { // cat_imagen_size ?>
	<tr id="r_cat_imagen_size"<?php echo $categoria->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $categoria->cat_imagen_size->FldCaption() ?></td>
		<td<?php echo $categoria->cat_imagen_size->CellAttributes() ?>>
<div<?php echo $categoria->cat_imagen_size->ViewAttributes() ?>><?php echo $categoria->cat_imagen_size->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($categoria->cat_mostrar->Visible) { // cat_mostrar ?>
	<tr id="r_cat_mostrar"<?php echo $categoria->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $categoria->cat_mostrar->FldCaption() ?></td>
		<td<?php echo $categoria->cat_mostrar->CellAttributes() ?>>
<div<?php echo $categoria->cat_mostrar->ViewAttributes() ?>><?php echo $categoria->cat_mostrar->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php
$categoria_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($categoria->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$categoria_view->Page_Terminate();
?>
<?php

//
// Page class
//
class ccategoria_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'categoria';

	// Page object name
	var $PageObjName = 'categoria_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $categoria;
		if ($categoria->UseTokenInUrl) $PageUrl .= "t=" . $categoria->TableVar . "&"; // Add page token
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
		global $objForm, $categoria;
		if ($categoria->UseTokenInUrl) {
			if ($objForm)
				return ($categoria->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($categoria->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccategoria_view() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (categoria)
		if (!isset($GLOBALS["categoria"])) {
			$GLOBALS["categoria"] = new ccategoria();
			$GLOBALS["Table"] =& $GLOBALS["categoria"];
		}
		$KeyUrl = "";
		if (@$_GET["cat_id"] <> "") {
			$this->RecKey["cat_id"] = $_GET["cat_id"];
			$KeyUrl .= "&cat_id=" . urlencode($this->RecKey["cat_id"]);
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
			define("EW_TABLE_NAME", 'categoria', TRUE);

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
		global $categoria;

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
		global $Language, $categoria;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["cat_id"] <> "") {
				$categoria->cat_id->setQueryStringValue($_GET["cat_id"]);
				$this->RecKey["cat_id"] = $categoria->cat_id->QueryStringValue;
			} else {
				$sReturnUrl = "categorialist.php"; // Return to list
			}

			// Get action
			$categoria->CurrentAction = "I"; // Display form
			switch ($categoria->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "categorialist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "categorialist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$categoria->RowType = EW_ROWTYPE_VIEW;
		$categoria->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $categoria;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$categoria->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$categoria->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $categoria->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$categoria->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$categoria->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$categoria->setStartRecordNumber($this->StartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $categoria;
		$sFilter = $categoria->KeyFilter();

		// Call Row Selecting event
		$categoria->Row_Selecting($sFilter);

		// Load SQL based on filter
		$categoria->CurrentFilter = $sFilter;
		$sSql = $categoria->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$categoria->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $categoria;
		if (!$rs || $rs->EOF) return;
		$categoria->cat_id->setDbValue($rs->fields('cat_id'));
		$categoria->cat_nombre->setDbValue($rs->fields('cat_nombre'));
		$categoria->cat_imagen_nombre->Upload->DbValue = $rs->fields('cat_imagen_nombre');
		$categoria->cat_imagen_tipo->setDbValue($rs->fields('cat_imagen_tipo'));
		$categoria->cat_imagen_ancho->setDbValue($rs->fields('cat_imagen_ancho'));
		$categoria->cat_imagen_alto->setDbValue($rs->fields('cat_imagen_alto'));
		$categoria->cat_imagen_size->setDbValue($rs->fields('cat_imagen_size'));
		$categoria->cat_mostrar->setDbValue($rs->fields('cat_mostrar'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $categoria;

		// Initialize URLs
		$this->AddUrl = $categoria->AddUrl();
		$this->EditUrl = $categoria->EditUrl();
		$this->CopyUrl = $categoria->CopyUrl();
		$this->DeleteUrl = $categoria->DeleteUrl();
		$this->ListUrl = $categoria->ListUrl();

		// Call Row_Rendering event
		$categoria->Row_Rendering();

		// Common render codes for all row types
		// cat_id
		// cat_nombre
		// cat_imagen_nombre
		// cat_imagen_tipo
		// cat_imagen_ancho
		// cat_imagen_alto
		// cat_imagen_size
		// cat_mostrar

		if ($categoria->RowType == EW_ROWTYPE_VIEW) { // View row

			// cat_id
			$categoria->cat_id->ViewValue = $categoria->cat_id->CurrentValue;
			$categoria->cat_id->ViewCustomAttributes = "";

			// cat_nombre
			$categoria->cat_nombre->ViewValue = $categoria->cat_nombre->CurrentValue;
			$categoria->cat_nombre->ViewCustomAttributes = "";

			// cat_imagen_nombre
			if (!ew_Empty($categoria->cat_imagen_nombre->Upload->DbValue)) {
				$categoria->cat_imagen_nombre->ViewValue = $categoria->cat_imagen_nombre->Upload->DbValue;
				$categoria->cat_imagen_nombre->ImageWidth = 100;
				$categoria->cat_imagen_nombre->ImageHeight = 0;
				$categoria->cat_imagen_nombre->ImageAlt = $categoria->cat_imagen_nombre->FldAlt();
			} else {
				$categoria->cat_imagen_nombre->ViewValue = "";
			}
			$categoria->cat_imagen_nombre->ViewCustomAttributes = "";

			// cat_imagen_tipo
			$categoria->cat_imagen_tipo->ViewValue = $categoria->cat_imagen_tipo->CurrentValue;
			$categoria->cat_imagen_tipo->ViewCustomAttributes = "";

			// cat_imagen_ancho
			$categoria->cat_imagen_ancho->ViewValue = $categoria->cat_imagen_ancho->CurrentValue;
			$categoria->cat_imagen_ancho->ViewCustomAttributes = "";

			// cat_imagen_alto
			$categoria->cat_imagen_alto->ViewValue = $categoria->cat_imagen_alto->CurrentValue;
			$categoria->cat_imagen_alto->ViewCustomAttributes = "";

			// cat_imagen_size
			$categoria->cat_imagen_size->ViewValue = $categoria->cat_imagen_size->CurrentValue;
			$categoria->cat_imagen_size->ViewCustomAttributes = "";

			// cat_mostrar
			if (strval($categoria->cat_mostrar->CurrentValue) <> "") {
				switch ($categoria->cat_mostrar->CurrentValue) {
					case "1":
						$categoria->cat_mostrar->ViewValue = $categoria->cat_mostrar->FldTagCaption(1) <> "" ? $categoria->cat_mostrar->FldTagCaption(1) : $categoria->cat_mostrar->CurrentValue;
						break;
					case "0":
						$categoria->cat_mostrar->ViewValue = $categoria->cat_mostrar->FldTagCaption(2) <> "" ? $categoria->cat_mostrar->FldTagCaption(2) : $categoria->cat_mostrar->CurrentValue;
						break;
					default:
						$categoria->cat_mostrar->ViewValue = $categoria->cat_mostrar->CurrentValue;
				}
			} else {
				$categoria->cat_mostrar->ViewValue = NULL;
			}
			$categoria->cat_mostrar->ViewCustomAttributes = "";

			// cat_id
			$categoria->cat_id->LinkCustomAttributes = "";
			$categoria->cat_id->HrefValue = "";
			$categoria->cat_id->TooltipValue = "";

			// cat_nombre
			$categoria->cat_nombre->LinkCustomAttributes = "";
			$categoria->cat_nombre->HrefValue = "";
			$categoria->cat_nombre->TooltipValue = "";

			// cat_imagen_nombre
			$categoria->cat_imagen_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($categoria->cat_imagen_nombre->Upload->DbValue)) {
				$categoria->cat_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $categoria->cat_imagen_nombre->UploadPath) . ((!empty($categoria->cat_imagen_nombre->ViewValue)) ? $categoria->cat_imagen_nombre->ViewValue : $categoria->cat_imagen_nombre->CurrentValue); // Add prefix/suffix
				$categoria->cat_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($categoria->Export <> "") $categoria->cat_imagen_nombre->HrefValue = ew_ConvertFullUrl($categoria->cat_imagen_nombre->HrefValue);
			} else {
				$categoria->cat_imagen_nombre->HrefValue = "";
			}
			$categoria->cat_imagen_nombre->TooltipValue = "";

			// cat_imagen_tipo
			$categoria->cat_imagen_tipo->LinkCustomAttributes = "";
			$categoria->cat_imagen_tipo->HrefValue = "";
			$categoria->cat_imagen_tipo->TooltipValue = "";

			// cat_imagen_ancho
			$categoria->cat_imagen_ancho->LinkCustomAttributes = "";
			$categoria->cat_imagen_ancho->HrefValue = "";
			$categoria->cat_imagen_ancho->TooltipValue = "";

			// cat_imagen_alto
			$categoria->cat_imagen_alto->LinkCustomAttributes = "";
			$categoria->cat_imagen_alto->HrefValue = "";
			$categoria->cat_imagen_alto->TooltipValue = "";

			// cat_imagen_size
			$categoria->cat_imagen_size->LinkCustomAttributes = "";
			$categoria->cat_imagen_size->HrefValue = "";
			$categoria->cat_imagen_size->TooltipValue = "";

			// cat_mostrar
			$categoria->cat_mostrar->LinkCustomAttributes = "";
			$categoria->cat_mostrar->HrefValue = "";
			$categoria->cat_mostrar->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($categoria->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$categoria->Row_Rendered();
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
