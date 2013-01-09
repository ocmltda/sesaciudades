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
$local_add = new clocal_add();
$Page =& $local_add;

// Page init
$local_add->Page_Init();

// Page main
$local_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var local_add = new ew_Page("local_add");

// page properties
local_add.PageID = "add"; // page ID
local_add.FormID = "flocaladd"; // form ID
var EW_PAGE_ID = local_add.PageID; // for backward compatibility

// extend page with ValidateForm function
local_add.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = 1;
	for (i=0; i<rowcnt; i++) {
		infix = "";
		elm = fobj.elements["x" + infix + "_loc_nombre"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($local->loc_nombre->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_loc_direccion"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($local->loc_direccion->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_loc_googlemaps"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($local->loc_googlemaps->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_loc_vigente"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($local->loc_vigente->FldCaption()) ?>");

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
local_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
local_add.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
local_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
local_add.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $local_add->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $local->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $local->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$local_add->ShowMessage();
?>
<form name="flocaladd" id="flocaladd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return local_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="local">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($local->com_id->Visible) { // com_id ?>
	<tr id="r_com_id"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->com_id->FldCaption() ?></td>
		<td<?php echo $local->com_id->CellAttributes() ?>><span id="el_com_id">
<select id="x_com_id" name="x_com_id"<?php echo $local->com_id->EditAttributes() ?>>
<?php
if (is_array($local->com_id->EditValue)) {
	$arwrk = $local->com_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($local->com_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $local->com_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($local->emp_id->Visible) { // emp_id ?>
	<tr id="r_emp_id"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->emp_id->FldCaption() ?></td>
		<td<?php echo $local->emp_id->CellAttributes() ?>><span id="el_emp_id">
<?php if ($local->emp_id->getSessionValue() <> "") { ?>
<div<?php echo $local->emp_id->ViewAttributes() ?>><?php echo $local->emp_id->ViewValue ?></div>
<input type="hidden" id="x_emp_id" name="x_emp_id" value="<?php echo ew_HtmlEncode($local->emp_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x_emp_id" name="x_emp_id"<?php echo $local->emp_id->EditAttributes() ?>>
<?php
if (is_array($local->emp_id->EditValue)) {
	$arwrk = $local->emp_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($local->emp_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,1,$local->emp_id) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][3] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,2,$local->emp_id) ?><?php echo $arwrk[$rowcntwrk][3] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php } ?>
</span><?php echo $local->emp_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($local->loc_nombre->Visible) { // loc_nombre ?>
	<tr id="r_loc_nombre"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->loc_nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $local->loc_nombre->CellAttributes() ?>><span id="el_loc_nombre">
<input type="text" name="x_loc_nombre" id="x_loc_nombre" size="60" maxlength="32" value="<?php echo $local->loc_nombre->EditValue ?>"<?php echo $local->loc_nombre->EditAttributes() ?>>
</span><?php echo $local->loc_nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($local->loc_direccion->Visible) { // loc_direccion ?>
	<tr id="r_loc_direccion"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->loc_direccion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $local->loc_direccion->CellAttributes() ?>><span id="el_loc_direccion">
<input type="text" name="x_loc_direccion" id="x_loc_direccion" size="60" maxlength="64" value="<?php echo $local->loc_direccion->EditValue ?>"<?php echo $local->loc_direccion->EditAttributes() ?>>
</span><?php echo $local->loc_direccion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($local->loc_googlemaps->Visible) { // loc_googlemaps ?>
	<tr id="r_loc_googlemaps"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->loc_googlemaps->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $local->loc_googlemaps->CellAttributes() ?>><span id="el_loc_googlemaps">
<textarea name="x_loc_googlemaps" id="x_loc_googlemaps" cols="59" rows="10"<?php echo $local->loc_googlemaps->EditAttributes() ?>><?php echo $local->loc_googlemaps->EditValue ?></textarea>
</span><?php echo $local->loc_googlemaps->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($local->loc_vigente->Visible) { // loc_vigente ?>
	<tr id="r_loc_vigente"<?php echo $local->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $local->loc_vigente->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $local->loc_vigente->CellAttributes() ?>><span id="el_loc_vigente">
<div id="tp_x_loc_vigente" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><label><input type="radio" name="x_loc_vigente" id="x_loc_vigente" value="{value}"<?php echo $local->loc_vigente->EditAttributes() ?>></label></div>
<div id="dsl_x_loc_vigente" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $local->loc_vigente->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($local->loc_vigente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_loc_vigente" id="x_loc_vigente" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $local->loc_vigente->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $local->loc_vigente->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<?php
$local_add->ShowPageFooter();
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
$local_add->Page_Terminate();
?>
<?php

//
// Page class
//
class clocal_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'local';

	// Page object name
	var $PageObjName = 'local_add';

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
	function clocal_add() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (local)
		if (!isset($GLOBALS["local"])) {
			$GLOBALS["local"] = new clocal();
			$GLOBALS["Table"] =& $GLOBALS["local"];
		}

		// Table object (empresa)
		if (!isset($GLOBALS['empresa'])) $GLOBALS['empresa'] = new cempresa();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'local', TRUE);

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
		global $local;

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
		global $objForm, $Language, $gsFormError, $local;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$local->CurrentAction = $_POST["a_add"]; // Get form action
			$this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$local->CurrentAction = "I"; // Form error, reset action
				$local->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back

			// Load key values from QueryString
			$bCopy = TRUE;
			if (@$_GET["loc_id"] != "") {
				$local->loc_id->setQueryStringValue($_GET["loc_id"]);
				$local->setKey("loc_id", $local->loc_id->CurrentValue); // Set up key
			} else {
				$local->setKey("loc_id", ""); // Clear key
				$bCopy = FALSE;
			}
			if ($bCopy) {
				$local->CurrentAction = "C"; // Copy record
			} else {
				$local->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Perform action based on action code
		switch ($local->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("locallist.php"); // No matching record, return to list
				}
				break;
			case "A": // ' Add new record
				$local->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $local->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "localview.php")
						$sReturnUrl = $local->ViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$local->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$local->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $local;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $local;
		$local->com_id->CurrentValue = NULL;
		$local->com_id->OldValue = $local->com_id->CurrentValue;
		$local->emp_id->CurrentValue = NULL;
		$local->emp_id->OldValue = $local->emp_id->CurrentValue;
		$local->loc_nombre->CurrentValue = NULL;
		$local->loc_nombre->OldValue = $local->loc_nombre->CurrentValue;
		$local->loc_direccion->CurrentValue = NULL;
		$local->loc_direccion->OldValue = $local->loc_direccion->CurrentValue;
		$local->loc_googlemaps->CurrentValue = NULL;
		$local->loc_googlemaps->OldValue = $local->loc_googlemaps->CurrentValue;
		$local->loc_vigente->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $local;
		if (!$local->com_id->FldIsDetailKey) {
			$local->com_id->setFormValue($objForm->GetValue("x_com_id"));
		}
		if (!$local->emp_id->FldIsDetailKey) {
			$local->emp_id->setFormValue($objForm->GetValue("x_emp_id"));
		}
		if (!$local->loc_nombre->FldIsDetailKey) {
			$local->loc_nombre->setFormValue($objForm->GetValue("x_loc_nombre"));
		}
		if (!$local->loc_direccion->FldIsDetailKey) {
			$local->loc_direccion->setFormValue($objForm->GetValue("x_loc_direccion"));
		}
		if (!$local->loc_googlemaps->FldIsDetailKey) {
			$local->loc_googlemaps->setFormValue($objForm->GetValue("x_loc_googlemaps"));
		}
		if (!$local->loc_vigente->FldIsDetailKey) {
			$local->loc_vigente->setFormValue($objForm->GetValue("x_loc_vigente"));
		}
		$local->loc_id->setFormValue($objForm->GetValue("x_loc_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $local;
		$this->LoadOldRecord();
		$local->loc_id->CurrentValue = $local->loc_id->FormValue;
		$local->com_id->CurrentValue = $local->com_id->FormValue;
		$local->emp_id->CurrentValue = $local->emp_id->FormValue;
		$local->loc_nombre->CurrentValue = $local->loc_nombre->FormValue;
		$local->loc_direccion->CurrentValue = $local->loc_direccion->FormValue;
		$local->loc_googlemaps->CurrentValue = $local->loc_googlemaps->FormValue;
		$local->loc_vigente->CurrentValue = $local->loc_vigente->FormValue;
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
		$local->com_id->setDbValue($rs->fields('com_id'));
		$local->emp_id->setDbValue($rs->fields('emp_id'));
		$local->loc_nombre->setDbValue($rs->fields('loc_nombre'));
		$local->loc_direccion->setDbValue($rs->fields('loc_direccion'));
		$local->loc_googlemaps->setDbValue($rs->fields('loc_googlemaps'));
		$local->loc_vigente->setDbValue($rs->fields('loc_vigente'));
	}

	// Load old record
	function LoadOldRecord() {
		global $local;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($local->getKey("loc_id")) <> "")
			$local->loc_id->CurrentValue = $local->getKey("loc_id"); // loc_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$local->CurrentFilter = $local->KeyFilter();
			$sSql = $local->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $local;

		// Initialize URLs
		// Call Row_Rendering event

		$local->Row_Rendering();

		// Common render codes for all row types
		// loc_id
		// com_id
		// emp_id
		// loc_nombre
		// loc_direccion
		// loc_googlemaps
		// loc_vigente

		if ($local->RowType == EW_ROWTYPE_VIEW) { // View row

			// loc_id
			$local->loc_id->ViewValue = $local->loc_id->CurrentValue;
			$local->loc_id->ViewCustomAttributes = "";

			// com_id
			if (strval($local->com_id->CurrentValue) <> "") {
				$sFilterWrk = "`com_id` = " . ew_AdjustSql($local->com_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `com_nombre` FROM `comuna`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `com_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$local->com_id->ViewValue = $rswrk->fields('com_nombre');
					$rswrk->Close();
				} else {
					$local->com_id->ViewValue = $local->com_id->CurrentValue;
				}
			} else {
				$local->com_id->ViewValue = NULL;
			}
			$local->com_id->ViewCustomAttributes = "";

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

			// com_id
			$local->com_id->LinkCustomAttributes = "";
			$local->com_id->HrefValue = "";
			$local->com_id->TooltipValue = "";

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
		} elseif ($local->RowType == EW_ROWTYPE_ADD) { // Add row

			// com_id
			$local->com_id->EditCustomAttributes = "";
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `com_id`, `com_nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld` FROM `comuna`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `com_nombre` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$local->com_id->EditValue = $arwrk;

			// emp_id
			$local->emp_id->EditCustomAttributes = "";
			if ($local->emp_id->getSessionValue() <> "") {
				$local->emp_id->CurrentValue = $local->emp_id->getSessionValue();
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
			} else {
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `emp_id`, `emp_rut` AS `DispFld`, `emp_nomfantasia` AS `Disp2Fld`, `emp_razonsocial` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld` FROM `empresa`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `emp_rut` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", ""));
			$local->emp_id->EditValue = $arwrk;
			}

			// loc_nombre
			$local->loc_nombre->EditCustomAttributes = "";
			$local->loc_nombre->EditValue = ew_HtmlEncode($local->loc_nombre->CurrentValue);

			// loc_direccion
			$local->loc_direccion->EditCustomAttributes = "";
			$local->loc_direccion->EditValue = ew_HtmlEncode($local->loc_direccion->CurrentValue);

			// loc_googlemaps
			$local->loc_googlemaps->EditCustomAttributes = "";
			$local->loc_googlemaps->EditValue = ew_HtmlEncode($local->loc_googlemaps->CurrentValue);

			// loc_vigente
			$local->loc_vigente->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("1", $local->loc_vigente->FldTagCaption(1) <> "" ? $local->loc_vigente->FldTagCaption(1) : "1");
			$arwrk[] = array("0", $local->loc_vigente->FldTagCaption(2) <> "" ? $local->loc_vigente->FldTagCaption(2) : "0");
			$local->loc_vigente->EditValue = $arwrk;

			// Edit refer script
			// com_id

			$local->com_id->HrefValue = "";

			// emp_id
			$local->emp_id->HrefValue = "";

			// loc_nombre
			$local->loc_nombre->HrefValue = "";

			// loc_direccion
			$local->loc_direccion->HrefValue = "";

			// loc_googlemaps
			$local->loc_googlemaps->HrefValue = "";

			// loc_vigente
			$local->loc_vigente->HrefValue = "";
		}
		if ($local->RowType == EW_ROWTYPE_ADD ||
			$local->RowType == EW_ROWTYPE_EDIT ||
			$local->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$local->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($local->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$local->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $local;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($local->loc_nombre->FormValue) && $local->loc_nombre->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $local->loc_nombre->FldCaption());
		}
		if (!is_null($local->loc_direccion->FormValue) && $local->loc_direccion->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $local->loc_direccion->FldCaption());
		}
		if (!is_null($local->loc_googlemaps->FormValue) && $local->loc_googlemaps->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $local->loc_googlemaps->FldCaption());
		}
		if ($local->loc_vigente->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $local->loc_vigente->FldCaption());
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
		global $conn, $Language, $Security, $local;
		$rsnew = array();

		// com_id
		$local->com_id->SetDbValueDef($rsnew, $local->com_id->CurrentValue, NULL, FALSE);

		// emp_id
		$local->emp_id->SetDbValueDef($rsnew, $local->emp_id->CurrentValue, NULL, FALSE);

		// loc_nombre
		$local->loc_nombre->SetDbValueDef($rsnew, $local->loc_nombre->CurrentValue, "", FALSE);

		// loc_direccion
		$local->loc_direccion->SetDbValueDef($rsnew, $local->loc_direccion->CurrentValue, "", FALSE);

		// loc_googlemaps
		$local->loc_googlemaps->SetDbValueDef($rsnew, $local->loc_googlemaps->CurrentValue, "", FALSE);

		// loc_vigente
		$local->loc_vigente->SetDbValueDef($rsnew, $local->loc_vigente->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $local->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($local->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($local->CancelMessage <> "") {
				$this->setFailureMessage($local->CancelMessage);
				$local->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$local->loc_id->setDbValue($conn->Insert_ID());
			$rsnew['loc_id'] = $local->loc_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$local->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		global $local;
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (@$_GET[EW_TABLE_SHOW_MASTER] <> "") {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "empresa") {
				$bValidMaster = TRUE;
				if (@$_GET["emp_id"] <> "") {
					$GLOBALS["empresa"]->emp_id->setQueryStringValue($_GET["emp_id"]);
					$local->emp_id->setQueryStringValue($GLOBALS["empresa"]->emp_id->QueryStringValue);
					$local->emp_id->setSessionValue($local->emp_id->QueryStringValue);
					if (!is_numeric($GLOBALS["empresa"]->emp_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$local->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$local->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "empresa") {
				if ($local->emp_id->QueryStringValue == "") $local->emp_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $local->getMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $local->getDetailFilter(); // Get detail filter
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
