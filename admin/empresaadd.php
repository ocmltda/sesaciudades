<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "empresainfo.php" ?>
<?php include_once "localinfo.php" ?>
<?php include_once "localgridcls.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$empresa_add = new cempresa_add();
$Page =& $empresa_add;

// Page init
$empresa_add->Page_Init();

// Page main
$empresa_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var empresa_add = new ew_Page("empresa_add");

// page properties
empresa_add.PageID = "add"; // page ID
empresa_add.FormID = "fempresaadd"; // form ID
var EW_PAGE_ID = empresa_add.PageID; // for backward compatibility

// extend page with ValidateForm function
empresa_add.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = 1;
	for (i=0; i<rowcnt; i++) {
		infix = "";
		elm = fobj.elements["x" + infix + "_emp_nomfantasia"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($empresa->emp_nomfantasia->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_emp_razonsocial"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($empresa->emp_razonsocial->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_emp_rut"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($empresa->emp_rut->FldCaption()) ?>");

		// Set up row object
		var row = {};
		row["index"] = infix;
		for (var j = 0; j < fobj.elements.length; j++) {
			var el = fobj.elements[j];
			var len = infix.length + 2;
			if (el.name.substr(0, len) == "x" + infix + "_") {
				var elname = "x_" + el.name.substr(len);
				if (ewLang.isObject(row[elname])) { // already exists
					if (ewLang.isArray(row[elname])) {
						row[elname][row[elname].length] = el; // add to array
					} else {
						row[elname] = [row[elname], el]; // convert to array
					}
				} else {
					row[elname] = el;
				}
			}
		}
		fobj.row = row;

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}

	// Process detail page
	var detailpage = (fobj.detailpage) ? fobj.detailpage.value : "";
	if (detailpage != "") {
		return eval(detailpage+".ValidateForm(fobj)");
	}
	return true;
}

// extend page with Form_CustomValidate function
empresa_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
empresa_add.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
empresa_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
empresa_add.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $empresa_add->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $empresa->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $empresa->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$empresa_add->ShowMessage();
?>
<form name="fempresaadd" id="fempresaadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return empresa_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="empresa">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($empresa->emp_nomfantasia->Visible) { // emp_nomfantasia ?>
	<tr id="r_emp_nomfantasia"<?php echo $empresa->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $empresa->emp_nomfantasia->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $empresa->emp_nomfantasia->CellAttributes() ?>><span id="el_emp_nomfantasia">
<input type="text" name="x_emp_nomfantasia" id="x_emp_nomfantasia" size="60" maxlength="64" value="<?php echo $empresa->emp_nomfantasia->EditValue ?>"<?php echo $empresa->emp_nomfantasia->EditAttributes() ?>>
</span><?php echo $empresa->emp_nomfantasia->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($empresa->emp_razonsocial->Visible) { // emp_razonsocial ?>
	<tr id="r_emp_razonsocial"<?php echo $empresa->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $empresa->emp_razonsocial->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $empresa->emp_razonsocial->CellAttributes() ?>><span id="el_emp_razonsocial">
<input type="text" name="x_emp_razonsocial" id="x_emp_razonsocial" size="60" maxlength="64" value="<?php echo $empresa->emp_razonsocial->EditValue ?>"<?php echo $empresa->emp_razonsocial->EditAttributes() ?>>
</span><?php echo $empresa->emp_razonsocial->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($empresa->emp_rut->Visible) { // emp_rut ?>
	<tr id="r_emp_rut"<?php echo $empresa->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $empresa->emp_rut->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $empresa->emp_rut->CellAttributes() ?>><span id="el_emp_rut">
<input type="text" name="x_emp_rut" id="x_emp_rut" size="20" maxlength="16" value="<?php echo $empresa->emp_rut->EditValue ?>"<?php echo $empresa->emp_rut->EditAttributes() ?>>
</span><?php echo $empresa->emp_rut->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($empresa->getCurrentDetailTable() == "local" && $local->DetailAdd) { ?>
<br>
<?php include_once "localgrid.php" ?>
<br>
<?php } ?>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<?php
$empresa_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include_once "footer.php" ?>
<?php
$empresa_add->Page_Terminate();
?>
<?php

//
// Page class
//
class cempresa_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'empresa';

	// Page object name
	var $PageObjName = 'empresa_add';

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
	function cempresa_add() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (empresa)
		if (!isset($GLOBALS["empresa"])) {
			$GLOBALS["empresa"] = new cempresa();
			$GLOBALS["Table"] =& $GLOBALS["empresa"];
		}

		// Table object (local)
		if (!isset($GLOBALS['local'])) $GLOBALS['local'] = new clocal();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'empresa', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
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

		// Create form object
		$objForm = new cFormObj();

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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $empresa;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$empresa->CurrentAction = $_POST["a_add"]; // Get form action
			$this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values

			// Set up detail parameters
			$this->SetUpDetailParms();

			// Validate form
			if (!$this->ValidateForm()) {
				$empresa->CurrentAction = "I"; // Form error, reset action
				$empresa->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back

			// Load key values from QueryString
			$bCopy = TRUE;
			if (@$_GET["emp_id"] != "") {
				$empresa->emp_id->setQueryStringValue($_GET["emp_id"]);
				$empresa->setKey("emp_id", $empresa->emp_id->CurrentValue); // Set up key
			} else {
				$empresa->setKey("emp_id", ""); // Clear key
				$bCopy = FALSE;
			}
			if ($bCopy) {
				$empresa->CurrentAction = "C"; // Copy record
			} else {
				$empresa->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up detail parameters
		$this->SetUpDetailParms();

		// Perform action based on action code
		switch ($empresa->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("empresalist.php"); // No matching record, return to list
				}
				break;
			case "A": // ' Add new record
				$empresa->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($empresa->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $empresa->getDetailUrl();
					else
						$sReturnUrl = $empresa->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "empresaview.php")
						$sReturnUrl = $empresa->ViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$empresa->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$empresa->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $empresa;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $empresa;
		$empresa->emp_nomfantasia->CurrentValue = NULL;
		$empresa->emp_nomfantasia->OldValue = $empresa->emp_nomfantasia->CurrentValue;
		$empresa->emp_razonsocial->CurrentValue = NULL;
		$empresa->emp_razonsocial->OldValue = $empresa->emp_razonsocial->CurrentValue;
		$empresa->emp_rut->CurrentValue = NULL;
		$empresa->emp_rut->OldValue = $empresa->emp_rut->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $empresa;
		if (!$empresa->emp_nomfantasia->FldIsDetailKey) {
			$empresa->emp_nomfantasia->setFormValue($objForm->GetValue("x_emp_nomfantasia"));
		}
		if (!$empresa->emp_razonsocial->FldIsDetailKey) {
			$empresa->emp_razonsocial->setFormValue($objForm->GetValue("x_emp_razonsocial"));
		}
		if (!$empresa->emp_rut->FldIsDetailKey) {
			$empresa->emp_rut->setFormValue($objForm->GetValue("x_emp_rut"));
		}
		$empresa->emp_id->setFormValue($objForm->GetValue("x_emp_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $empresa;
		$this->LoadOldRecord();
		$empresa->emp_id->CurrentValue = $empresa->emp_id->FormValue;
		$empresa->emp_nomfantasia->CurrentValue = $empresa->emp_nomfantasia->FormValue;
		$empresa->emp_razonsocial->CurrentValue = $empresa->emp_razonsocial->FormValue;
		$empresa->emp_rut->CurrentValue = $empresa->emp_rut->FormValue;
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

	// Load old record
	function LoadOldRecord() {
		global $empresa;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($empresa->getKey("emp_id")) <> "")
			$empresa->emp_id->CurrentValue = $empresa->getKey("emp_id"); // emp_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$empresa->CurrentFilter = $empresa->KeyFilter();
			$sSql = $empresa->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $empresa;

		// Initialize URLs
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
		} elseif ($empresa->RowType == EW_ROWTYPE_ADD) { // Add row

			// emp_nomfantasia
			$empresa->emp_nomfantasia->EditCustomAttributes = "";
			$empresa->emp_nomfantasia->EditValue = ew_HtmlEncode($empresa->emp_nomfantasia->CurrentValue);

			// emp_razonsocial
			$empresa->emp_razonsocial->EditCustomAttributes = "";
			$empresa->emp_razonsocial->EditValue = ew_HtmlEncode($empresa->emp_razonsocial->CurrentValue);

			// emp_rut
			$empresa->emp_rut->EditCustomAttributes = "";
			$empresa->emp_rut->EditValue = ew_HtmlEncode($empresa->emp_rut->CurrentValue);

			// Edit refer script
			// emp_nomfantasia

			$empresa->emp_nomfantasia->HrefValue = "";

			// emp_razonsocial
			$empresa->emp_razonsocial->HrefValue = "";

			// emp_rut
			$empresa->emp_rut->HrefValue = "";
		}
		if ($empresa->RowType == EW_ROWTYPE_ADD ||
			$empresa->RowType == EW_ROWTYPE_EDIT ||
			$empresa->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$empresa->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($empresa->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$empresa->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $empresa;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($empresa->emp_nomfantasia->FormValue) && $empresa->emp_nomfantasia->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $empresa->emp_nomfantasia->FldCaption());
		}
		if (!is_null($empresa->emp_razonsocial->FormValue) && $empresa->emp_razonsocial->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $empresa->emp_razonsocial->FldCaption());
		}
		if (!is_null($empresa->emp_rut->FormValue) && $empresa->emp_rut->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $empresa->emp_rut->FldCaption());
		}

		// Validate detail grid
		if ($empresa->getCurrentDetailTable() == "local" && $GLOBALS["local"]->DetailAdd) {
			$local_grid = new clocal_grid(); // get detail page object
			$local_grid->ValidateGridForm();
			$local_grid = NULL;
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security, $empresa;

		// Begin transaction
		if ($empresa->getCurrentDetailTable() <> "")
			$conn->BeginTrans();
		$rsnew = array();

		// emp_nomfantasia
		$empresa->emp_nomfantasia->SetDbValueDef($rsnew, $empresa->emp_nomfantasia->CurrentValue, "", FALSE);

		// emp_razonsocial
		$empresa->emp_razonsocial->SetDbValueDef($rsnew, $empresa->emp_razonsocial->CurrentValue, "", FALSE);

		// emp_rut
		$empresa->emp_rut->SetDbValueDef($rsnew, $empresa->emp_rut->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $empresa->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($empresa->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($empresa->CancelMessage <> "") {
				$this->setFailureMessage($empresa->CancelMessage);
				$empresa->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$empresa->emp_id->setDbValue($conn->Insert_ID());
			$rsnew['emp_id'] = $empresa->emp_id->DbValue;
		}

		// Add detail records
		if ($AddRow) {
			if ($empresa->getCurrentDetailTable() == "local" && $GLOBALS["local"]->DetailAdd) {
				$GLOBALS["local"]->emp_id->setSessionValue($empresa->emp_id->CurrentValue); // Set master key
				$local_grid = new clocal_grid(); // get detail page object
				$AddRow = $local_grid->GridInsert();
				$local_grid = NULL;
			}
		}

		// Commit/Rollback transaction
		if ($empresa->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$empresa->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {
		global $empresa;
		$bValidDetail = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$empresa->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $empresa->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			if ($sDetailTblVar == "local") {
				if (!isset($GLOBALS["local"]))
					$GLOBALS["local"] = new clocal;
				if ($GLOBALS["local"]->DetailAdd) {
					if ($empresa->CurrentAction == "C")
						$GLOBALS["local"]->CurrentMode = "copy";
					else
						$GLOBALS["local"]->CurrentMode = "add";
					$GLOBALS["local"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["local"]->setCurrentMasterTable($empresa->TableVar);
					$GLOBALS["local"]->setStartRecordNumber(1);
					$GLOBALS["local"]->emp_id->FldIsDetailKey = TRUE;
					$GLOBALS["local"]->emp_id->CurrentValue = $empresa->emp_id->CurrentValue;
					$GLOBALS["local"]->emp_id->setSessionValue($GLOBALS["local"]->emp_id->CurrentValue);
				}
			}
		}
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
