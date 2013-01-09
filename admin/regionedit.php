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
$region_edit = new cregion_edit();
$Page =& $region_edit;

// Page init
$region_edit->Page_Init();

// Page main
$region_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var region_edit = new ew_Page("region_edit");

// page properties
region_edit.PageID = "edit"; // page ID
region_edit.FormID = "fregionedit"; // form ID
var EW_PAGE_ID = region_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
region_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = 1;
	for (i=0; i<rowcnt; i++) {
		infix = "";
		elm = fobj.elements["x" + infix + "_reg_num"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($region->reg_num->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_reg_num"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($region->reg_num->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_reg_cod"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($region->reg_cod->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_reg_nombre"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($region->reg_nombre->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_reg_alias"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($region->reg_alias->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_reg_ordenmapa"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($region->reg_ordenmapa->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_reg_ordenmapa"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($region->reg_ordenmapa->FldErrMsg()) ?>");

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
region_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
region_edit.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
region_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
region_edit.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $region_edit->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $region->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $region->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$region_edit->ShowMessage();
?>
<form name="fregionedit" id="fregionedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return region_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="region">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($region->reg_id->Visible) { // reg_id ?>
	<tr id="r_reg_id"<?php echo $region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $region->reg_id->FldCaption() ?></td>
		<td<?php echo $region->reg_id->CellAttributes() ?>><span id="el_reg_id">
<div<?php echo $region->reg_id->ViewAttributes() ?>><?php echo $region->reg_id->EditValue ?></div>
<input type="hidden" name="x_reg_id" id="x_reg_id" value="<?php echo ew_HtmlEncode($region->reg_id->CurrentValue) ?>">
</span><?php echo $region->reg_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($region->reg_num->Visible) { // reg_num ?>
	<tr id="r_reg_num"<?php echo $region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $region->reg_num->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $region->reg_num->CellAttributes() ?>><span id="el_reg_num">
<input type="text" name="x_reg_num" id="x_reg_num" size="5" maxlength="2" value="<?php echo $region->reg_num->EditValue ?>"<?php echo $region->reg_num->EditAttributes() ?>>
</span><?php echo $region->reg_num->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($region->reg_cod->Visible) { // reg_cod ?>
	<tr id="r_reg_cod"<?php echo $region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $region->reg_cod->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $region->reg_cod->CellAttributes() ?>><span id="el_reg_cod">
<input type="text" name="x_reg_cod" id="x_reg_cod" size="5" maxlength="4" value="<?php echo $region->reg_cod->EditValue ?>"<?php echo $region->reg_cod->EditAttributes() ?>>
</span><?php echo $region->reg_cod->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($region->reg_nombre->Visible) { // reg_nombre ?>
	<tr id="r_reg_nombre"<?php echo $region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $region->reg_nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $region->reg_nombre->CellAttributes() ?>><span id="el_reg_nombre">
<input type="text" name="x_reg_nombre" id="x_reg_nombre" size="60" maxlength="64" value="<?php echo $region->reg_nombre->EditValue ?>"<?php echo $region->reg_nombre->EditAttributes() ?>>
</span><?php echo $region->reg_nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($region->reg_alias->Visible) { // reg_alias ?>
	<tr id="r_reg_alias"<?php echo $region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $region->reg_alias->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $region->reg_alias->CellAttributes() ?>><span id="el_reg_alias">
<input type="text" name="x_reg_alias" id="x_reg_alias" size="60" maxlength="32" value="<?php echo $region->reg_alias->EditValue ?>"<?php echo $region->reg_alias->EditAttributes() ?>>
</span><?php echo $region->reg_alias->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($region->reg_ordenmapa->Visible) { // reg_ordenmapa ?>
	<tr id="r_reg_ordenmapa"<?php echo $region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $region->reg_ordenmapa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $region->reg_ordenmapa->CellAttributes() ?>><span id="el_reg_ordenmapa">
<input type="text" name="x_reg_ordenmapa" id="x_reg_ordenmapa" size="30" value="<?php echo $region->reg_ordenmapa->EditValue ?>"<?php echo $region->reg_ordenmapa->EditAttributes() ?>>
</span><?php echo $region->reg_ordenmapa->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<?php
$region_edit->ShowPageFooter();
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
$region_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cregion_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'region';

	// Page object name
	var $PageObjName = 'region_edit';

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
	function cregion_edit() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (region)
		if (!isset($GLOBALS["region"])) {
			$GLOBALS["region"] = new cregion();
			$GLOBALS["Table"] =& $GLOBALS["region"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'region', TRUE);

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
		global $region;

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
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $region;

		// Load key from QueryString
		if (@$_GET["reg_id"] <> "")
			$region->reg_id->setQueryStringValue($_GET["reg_id"]);
		if (@$_POST["a_edit"] <> "") {
			$region->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$region->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$region->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$region->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($region->reg_id->CurrentValue == "")
			$this->Page_Terminate("regionlist.php"); // Invalid key, return to list
		switch ($region->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("regionlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$region->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $region->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$region->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$region->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$region->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $region;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $region;
		if (!$region->reg_id->FldIsDetailKey) {
			$region->reg_id->setFormValue($objForm->GetValue("x_reg_id"));
		}
		if (!$region->reg_num->FldIsDetailKey) {
			$region->reg_num->setFormValue($objForm->GetValue("x_reg_num"));
		}
		if (!$region->reg_cod->FldIsDetailKey) {
			$region->reg_cod->setFormValue($objForm->GetValue("x_reg_cod"));
		}
		if (!$region->reg_nombre->FldIsDetailKey) {
			$region->reg_nombre->setFormValue($objForm->GetValue("x_reg_nombre"));
		}
		if (!$region->reg_alias->FldIsDetailKey) {
			$region->reg_alias->setFormValue($objForm->GetValue("x_reg_alias"));
		}
		if (!$region->reg_ordenmapa->FldIsDetailKey) {
			$region->reg_ordenmapa->setFormValue($objForm->GetValue("x_reg_ordenmapa"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $region;
		$this->LoadRow();
		$region->reg_id->CurrentValue = $region->reg_id->FormValue;
		$region->reg_num->CurrentValue = $region->reg_num->FormValue;
		$region->reg_cod->CurrentValue = $region->reg_cod->FormValue;
		$region->reg_nombre->CurrentValue = $region->reg_nombre->FormValue;
		$region->reg_alias->CurrentValue = $region->reg_alias->FormValue;
		$region->reg_ordenmapa->CurrentValue = $region->reg_ordenmapa->FormValue;
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
		} elseif ($region->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// reg_id
			$region->reg_id->EditCustomAttributes = "";
			$region->reg_id->EditValue = $region->reg_id->CurrentValue;
			$region->reg_id->ViewCustomAttributes = "";

			// reg_num
			$region->reg_num->EditCustomAttributes = "";
			$region->reg_num->EditValue = ew_HtmlEncode($region->reg_num->CurrentValue);

			// reg_cod
			$region->reg_cod->EditCustomAttributes = "";
			$region->reg_cod->EditValue = ew_HtmlEncode($region->reg_cod->CurrentValue);

			// reg_nombre
			$region->reg_nombre->EditCustomAttributes = "";
			$region->reg_nombre->EditValue = ew_HtmlEncode($region->reg_nombre->CurrentValue);

			// reg_alias
			$region->reg_alias->EditCustomAttributes = "";
			$region->reg_alias->EditValue = ew_HtmlEncode($region->reg_alias->CurrentValue);

			// reg_ordenmapa
			$region->reg_ordenmapa->EditCustomAttributes = "";
			$region->reg_ordenmapa->EditValue = ew_HtmlEncode($region->reg_ordenmapa->CurrentValue);

			// Edit refer script
			// reg_id

			$region->reg_id->HrefValue = "";

			// reg_num
			$region->reg_num->HrefValue = "";

			// reg_cod
			$region->reg_cod->HrefValue = "";

			// reg_nombre
			$region->reg_nombre->HrefValue = "";

			// reg_alias
			$region->reg_alias->HrefValue = "";

			// reg_ordenmapa
			$region->reg_ordenmapa->HrefValue = "";
		}
		if ($region->RowType == EW_ROWTYPE_ADD ||
			$region->RowType == EW_ROWTYPE_EDIT ||
			$region->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$region->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($region->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$region->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $region;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($region->reg_num->FormValue) && $region->reg_num->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $region->reg_num->FldCaption());
		}
		if (!ew_CheckInteger($region->reg_num->FormValue)) {
			ew_AddMessage($gsFormError, $region->reg_num->FldErrMsg());
		}
		if (!is_null($region->reg_cod->FormValue) && $region->reg_cod->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $region->reg_cod->FldCaption());
		}
		if (!is_null($region->reg_nombre->FormValue) && $region->reg_nombre->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $region->reg_nombre->FldCaption());
		}
		if (!is_null($region->reg_alias->FormValue) && $region->reg_alias->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $region->reg_alias->FldCaption());
		}
		if (!is_null($region->reg_ordenmapa->FormValue) && $region->reg_ordenmapa->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $region->reg_ordenmapa->FldCaption());
		}
		if (!ew_CheckInteger($region->reg_ordenmapa->FormValue)) {
			ew_AddMessage($gsFormError, $region->reg_ordenmapa->FldErrMsg());
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $region;
		$sFilter = $region->KeyFilter();
			if ($region->reg_nombre->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`reg_nombre` = '" . ew_AdjustSql($region->reg_nombre->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$region->CurrentFilter = $sFilterChk;
			$sSqlChk = $region->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", 'reg_nombre', $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $region->reg_nombre->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
		$region->CurrentFilter = $sFilter;
		$sSql = $region->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// reg_num
			$region->reg_num->SetDbValueDef($rsnew, $region->reg_num->CurrentValue, 0, FALSE);

			// reg_cod
			$region->reg_cod->SetDbValueDef($rsnew, $region->reg_cod->CurrentValue, "", FALSE);

			// reg_nombre
			$region->reg_nombre->SetDbValueDef($rsnew, $region->reg_nombre->CurrentValue, "", FALSE);

			// reg_alias
			$region->reg_alias->SetDbValueDef($rsnew, $region->reg_alias->CurrentValue, "", FALSE);

			// reg_ordenmapa
			$region->reg_ordenmapa->SetDbValueDef($rsnew, $region->reg_ordenmapa->CurrentValue, 0, FALSE);

			// Call Row Updating event
			$bUpdateRow = $region->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $conn->Execute($region->UpdateSQL($rsnew));
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($region->CancelMessage <> "") {
					$this->setFailureMessage($region->CancelMessage);
					$region->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$region->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
