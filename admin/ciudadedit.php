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
$ciudad_edit = new cciudad_edit();
$Page =& $ciudad_edit;

// Page init
$ciudad_edit->Page_Init();

// Page main
$ciudad_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var ciudad_edit = new ew_Page("ciudad_edit");

// page properties
ciudad_edit.PageID = "edit"; // page ID
ciudad_edit.FormID = "fciudadedit"; // form ID
var EW_PAGE_ID = ciudad_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
ciudad_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = 1;
	for (i=0; i<rowcnt; i++) {
		infix = "";
		elm = fobj.elements["x" + infix + "_ciu_nombre"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ciudad->ciu_nombre->FldCaption()) ?>");

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
ciudad_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
ciudad_edit.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
ciudad_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ciudad_edit.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $ciudad_edit->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ciudad->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $ciudad->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$ciudad_edit->ShowMessage();
?>
<form name="fciudadedit" id="fciudadedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ciudad_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="ciudad">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($ciudad->ciu_id->Visible) { // ciu_id ?>
	<tr id="r_ciu_id"<?php echo $ciudad->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ciudad->ciu_id->FldCaption() ?></td>
		<td<?php echo $ciudad->ciu_id->CellAttributes() ?>><span id="el_ciu_id">
<div<?php echo $ciudad->ciu_id->ViewAttributes() ?>><?php echo $ciudad->ciu_id->EditValue ?></div>
<input type="hidden" name="x_ciu_id" id="x_ciu_id" value="<?php echo ew_HtmlEncode($ciudad->ciu_id->CurrentValue) ?>">
</span><?php echo $ciudad->ciu_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ciudad->reg_id->Visible) { // reg_id ?>
	<tr id="r_reg_id"<?php echo $ciudad->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ciudad->reg_id->FldCaption() ?></td>
		<td<?php echo $ciudad->reg_id->CellAttributes() ?>><span id="el_reg_id">
<select id="x_reg_id" name="x_reg_id"<?php echo $ciudad->reg_id->EditAttributes() ?>>
<?php
if (is_array($ciudad->reg_id->EditValue)) {
	$arwrk = $ciudad->reg_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ciudad->reg_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,1,$ciudad->reg_id) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $ciudad->reg_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ciudad->ciu_nombre->Visible) { // ciu_nombre ?>
	<tr id="r_ciu_nombre"<?php echo $ciudad->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ciudad->ciu_nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $ciudad->ciu_nombre->CellAttributes() ?>><span id="el_ciu_nombre">
<input type="text" name="x_ciu_nombre" id="x_ciu_nombre" size="60" maxlength="32" value="<?php echo $ciudad->ciu_nombre->EditValue ?>"<?php echo $ciudad->ciu_nombre->EditAttributes() ?>>
</span><?php echo $ciudad->ciu_nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<?php
$ciudad_edit->ShowPageFooter();
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
$ciudad_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cciudad_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'ciudad';

	// Page object name
	var $PageObjName = 'ciudad_edit';

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
	function cciudad_edit() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (ciudad)
		if (!isset($GLOBALS["ciudad"])) {
			$GLOBALS["ciudad"] = new cciudad();
			$GLOBALS["Table"] =& $GLOBALS["ciudad"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ciudad', TRUE);

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
		global $ciudad;

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
		global $objForm, $Language, $gsFormError, $ciudad;

		// Load key from QueryString
		if (@$_GET["ciu_id"] <> "")
			$ciudad->ciu_id->setQueryStringValue($_GET["ciu_id"]);
		if (@$_POST["a_edit"] <> "") {
			$ciudad->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$ciudad->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$ciudad->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$ciudad->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($ciudad->ciu_id->CurrentValue == "")
			$this->Page_Terminate("ciudadlist.php"); // Invalid key, return to list
		switch ($ciudad->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("ciudadlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$ciudad->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $ciudad->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$ciudad->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$ciudad->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$ciudad->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $ciudad;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $ciudad;
		if (!$ciudad->ciu_id->FldIsDetailKey) {
			$ciudad->ciu_id->setFormValue($objForm->GetValue("x_ciu_id"));
		}
		if (!$ciudad->reg_id->FldIsDetailKey) {
			$ciudad->reg_id->setFormValue($objForm->GetValue("x_reg_id"));
		}
		if (!$ciudad->ciu_nombre->FldIsDetailKey) {
			$ciudad->ciu_nombre->setFormValue($objForm->GetValue("x_ciu_nombre"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $ciudad;
		$this->LoadRow();
		$ciudad->ciu_id->CurrentValue = $ciudad->ciu_id->FormValue;
		$ciudad->reg_id->CurrentValue = $ciudad->reg_id->FormValue;
		$ciudad->ciu_nombre->CurrentValue = $ciudad->ciu_nombre->FormValue;
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
		} elseif ($ciudad->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// ciu_id
			$ciudad->ciu_id->EditCustomAttributes = "";
			$ciudad->ciu_id->EditValue = $ciudad->ciu_id->CurrentValue;
			$ciudad->ciu_id->ViewCustomAttributes = "";

			// reg_id
			$ciudad->reg_id->EditCustomAttributes = "";
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `reg_id`, `reg_num` AS `DispFld`, `reg_nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld` FROM `region`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `reg_num` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$ciudad->reg_id->EditValue = $arwrk;

			// ciu_nombre
			$ciudad->ciu_nombre->EditCustomAttributes = "";
			$ciudad->ciu_nombre->EditValue = ew_HtmlEncode($ciudad->ciu_nombre->CurrentValue);

			// Edit refer script
			// ciu_id

			$ciudad->ciu_id->HrefValue = "";

			// reg_id
			$ciudad->reg_id->HrefValue = "";

			// ciu_nombre
			$ciudad->ciu_nombre->HrefValue = "";
		}
		if ($ciudad->RowType == EW_ROWTYPE_ADD ||
			$ciudad->RowType == EW_ROWTYPE_EDIT ||
			$ciudad->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$ciudad->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($ciudad->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$ciudad->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $ciudad;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($ciudad->ciu_nombre->FormValue) && $ciudad->ciu_nombre->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $ciudad->ciu_nombre->FldCaption());
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
		global $conn, $Security, $Language, $ciudad;
		$sFilter = $ciudad->KeyFilter();
			if ($ciudad->ciu_nombre->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`ciu_nombre` = '" . ew_AdjustSql($ciudad->ciu_nombre->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$ciudad->CurrentFilter = $sFilterChk;
			$sSqlChk = $ciudad->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", 'ciu_nombre', $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $ciudad->ciu_nombre->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
		$ciudad->CurrentFilter = $sFilter;
		$sSql = $ciudad->SQL();
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

			// reg_id
			$ciudad->reg_id->SetDbValueDef($rsnew, $ciudad->reg_id->CurrentValue, NULL, FALSE);

			// ciu_nombre
			$ciudad->ciu_nombre->SetDbValueDef($rsnew, $ciudad->ciu_nombre->CurrentValue, "", FALSE);

			// Call Row Updating event
			$bUpdateRow = $ciudad->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $conn->Execute($ciudad->UpdateSQL($rsnew));
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($ciudad->CancelMessage <> "") {
					$this->setFailureMessage($ciudad->CancelMessage);
					$ciudad->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$ciudad->Row_Updated($rsold, $rsnew);
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
