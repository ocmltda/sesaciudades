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
$comuna_add = new ccomuna_add();
$Page =& $comuna_add;

// Page init
$comuna_add->Page_Init();

// Page main
$comuna_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var comuna_add = new ew_Page("comuna_add");

// page properties
comuna_add.PageID = "add"; // page ID
comuna_add.FormID = "fcomunaadd"; // form ID
var EW_PAGE_ID = comuna_add.PageID; // for backward compatibility

// extend page with ValidateForm function
comuna_add.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = 1;
	for (i=0; i<rowcnt; i++) {
		infix = "";
		elm = fobj.elements["x" + infix + "_reg_id"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($comuna->reg_id->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_ciu_id"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($comuna->ciu_id->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_com_nombre"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($comuna->com_nombre->FldCaption()) ?>");

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
comuna_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
comuna_add.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
comuna_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
comuna_add.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $comuna_add->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $comuna->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $comuna->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$comuna_add->ShowMessage();
?>
<form name="fcomunaadd" id="fcomunaadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return comuna_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="comuna">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($comuna->reg_id->Visible) { // reg_id ?>
	<tr id="r_reg_id"<?php echo $comuna->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $comuna->reg_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $comuna->reg_id->CellAttributes() ?>><span id="el_reg_id">
<?php $comuna->reg_id->EditAttrs["onchange"] = "ew_UpdateOpt('x_ciu_id','x_reg_id',comuna_add.ar_x_ciu_id); " . @$comuna->reg_id->EditAttrs["onchange"]; ?>
<select id="x_reg_id" name="x_reg_id"<?php echo $comuna->reg_id->EditAttributes() ?>>
<?php
if (is_array($comuna->reg_id->EditValue)) {
	$arwrk = $comuna->reg_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($comuna->reg_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,1,$comuna->reg_id) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $comuna->reg_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comuna->ciu_id->Visible) { // ciu_id ?>
	<tr id="r_ciu_id"<?php echo $comuna->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $comuna->ciu_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $comuna->ciu_id->CellAttributes() ?>><span id="el_ciu_id">
<select id="x_ciu_id" name="x_ciu_id"<?php echo $comuna->ciu_id->EditAttributes() ?>>
<?php
if (is_array($comuna->ciu_id->EditValue)) {
	$arwrk = $comuna->ciu_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($comuna->ciu_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php
$jswrk = "";
if (is_array($comuna->ciu_id->EditValue)) {
	$arwrk = $comuna->ciu_id->EditValue;
	$arwrkcnt = count($arwrk);
	for ($rowcntwrk = 1; $rowcntwrk < $arwrkcnt; $rowcntwrk++) {
		if ($jswrk <> "") $jswrk .= ",";
		$jswrk .= "['" . ew_JsEncode($arwrk[$rowcntwrk][0]) . "',"; // Value
		$jswrk .= "'" . ew_JsEncode($arwrk[$rowcntwrk][1]) . "',"; // Display field 1
		$jswrk .= "'" . ew_JsEncode($arwrk[$rowcntwrk][2]) . "',"; // Display field 2
		$jswrk .= "'" . ew_JsEncode($arwrk[$rowcntwrk][3]) . "',"; // Display field 3
		$jswrk .= "'" . ew_JsEncode($arwrk[$rowcntwrk][4]) . "',"; // Display field 4
		$jswrk .= "'" . ew_JsEncode($arwrk[$rowcntwrk][5]) . "']"; // Filter field
	}
}
?>
<script type="text/javascript">
<!--
comuna_add.ar_x_ciu_id = [<?php echo $jswrk ?>];

//-->
</script>
</span><?php echo $comuna->ciu_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($comuna->com_nombre->Visible) { // com_nombre ?>
	<tr id="r_com_nombre"<?php echo $comuna->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $comuna->com_nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $comuna->com_nombre->CellAttributes() ?>><span id="el_com_nombre">
<input type="text" name="x_com_nombre" id="x_com_nombre" size="60" maxlength="32" value="<?php echo $comuna->com_nombre->EditValue ?>"<?php echo $comuna->com_nombre->EditAttributes() ?>>
</span><?php echo $comuna->com_nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--
ew_UpdateOpts([['x_ciu_id','x_reg_id',comuna_add.ar_x_ciu_id]]);

//-->
</script>
<?php
$comuna_add->ShowPageFooter();
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
$comuna_add->Page_Terminate();
?>
<?php

//
// Page class
//
class ccomuna_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'comuna';

	// Page object name
	var $PageObjName = 'comuna_add';

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
	function ccomuna_add() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (comuna)
		if (!isset($GLOBALS["comuna"])) {
			$GLOBALS["comuna"] = new ccomuna();
			$GLOBALS["Table"] =& $GLOBALS["comuna"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'comuna', TRUE);

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
		global $comuna;

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
		global $objForm, $Language, $gsFormError, $comuna;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$comuna->CurrentAction = $_POST["a_add"]; // Get form action
			$this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$comuna->CurrentAction = "I"; // Form error, reset action
				$comuna->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back

			// Load key values from QueryString
			$bCopy = TRUE;
			if (@$_GET["com_id"] != "") {
				$comuna->com_id->setQueryStringValue($_GET["com_id"]);
				$comuna->setKey("com_id", $comuna->com_id->CurrentValue); // Set up key
			} else {
				$comuna->setKey("com_id", ""); // Clear key
				$bCopy = FALSE;
			}
			if ($bCopy) {
				$comuna->CurrentAction = "C"; // Copy record
			} else {
				$comuna->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Perform action based on action code
		switch ($comuna->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("comunalist.php"); // No matching record, return to list
				}
				break;
			case "A": // ' Add new record
				$comuna->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $comuna->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "comunaview.php")
						$sReturnUrl = $comuna->ViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$comuna->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$comuna->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $comuna;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $comuna;
		$comuna->reg_id->CurrentValue = NULL;
		$comuna->reg_id->OldValue = $comuna->reg_id->CurrentValue;
		$comuna->ciu_id->CurrentValue = NULL;
		$comuna->ciu_id->OldValue = $comuna->ciu_id->CurrentValue;
		$comuna->com_nombre->CurrentValue = NULL;
		$comuna->com_nombre->OldValue = $comuna->com_nombre->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $comuna;
		if (!$comuna->reg_id->FldIsDetailKey) {
			$comuna->reg_id->setFormValue($objForm->GetValue("x_reg_id"));
		}
		if (!$comuna->ciu_id->FldIsDetailKey) {
			$comuna->ciu_id->setFormValue($objForm->GetValue("x_ciu_id"));
		}
		if (!$comuna->com_nombre->FldIsDetailKey) {
			$comuna->com_nombre->setFormValue($objForm->GetValue("x_com_nombre"));
		}
		$comuna->com_id->setFormValue($objForm->GetValue("x_com_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $comuna;
		$this->LoadOldRecord();
		$comuna->com_id->CurrentValue = $comuna->com_id->FormValue;
		$comuna->reg_id->CurrentValue = $comuna->reg_id->FormValue;
		$comuna->ciu_id->CurrentValue = $comuna->ciu_id->FormValue;
		$comuna->com_nombre->CurrentValue = $comuna->com_nombre->FormValue;
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

	// Load old record
	function LoadOldRecord() {
		global $comuna;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($comuna->getKey("com_id")) <> "")
			$comuna->com_id->CurrentValue = $comuna->getKey("com_id"); // com_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$comuna->CurrentFilter = $comuna->KeyFilter();
			$sSql = $comuna->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $comuna;

		// Initialize URLs
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
		} elseif ($comuna->RowType == EW_ROWTYPE_ADD) { // Add row

			// reg_id
			$comuna->reg_id->EditCustomAttributes = "";
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
			$comuna->reg_id->EditValue = $arwrk;

			// ciu_id
			$comuna->ciu_id->EditCustomAttributes = "";
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `ciu_id`, `ciu_nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `reg_id` AS `SelectFilterFld` FROM `ciudad`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `ciu_nombre` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$comuna->ciu_id->EditValue = $arwrk;

			// com_nombre
			$comuna->com_nombre->EditCustomAttributes = "";
			$comuna->com_nombre->EditValue = ew_HtmlEncode($comuna->com_nombre->CurrentValue);

			// Edit refer script
			// reg_id

			$comuna->reg_id->HrefValue = "";

			// ciu_id
			$comuna->ciu_id->HrefValue = "";

			// com_nombre
			$comuna->com_nombre->HrefValue = "";
		}
		if ($comuna->RowType == EW_ROWTYPE_ADD ||
			$comuna->RowType == EW_ROWTYPE_EDIT ||
			$comuna->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$comuna->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($comuna->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$comuna->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $comuna;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($comuna->reg_id->FormValue) && $comuna->reg_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $comuna->reg_id->FldCaption());
		}
		if (!is_null($comuna->ciu_id->FormValue) && $comuna->ciu_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $comuna->ciu_id->FldCaption());
		}
		if (!is_null($comuna->com_nombre->FormValue) && $comuna->com_nombre->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $comuna->com_nombre->FldCaption());
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
		global $conn, $Language, $Security, $comuna;
		$rsnew = array();

		// reg_id
		$comuna->reg_id->SetDbValueDef($rsnew, $comuna->reg_id->CurrentValue, NULL, FALSE);

		// ciu_id
		$comuna->ciu_id->SetDbValueDef($rsnew, $comuna->ciu_id->CurrentValue, NULL, FALSE);

		// com_nombre
		$comuna->com_nombre->SetDbValueDef($rsnew, $comuna->com_nombre->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $comuna->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($comuna->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($comuna->CancelMessage <> "") {
				$this->setFailureMessage($comuna->CancelMessage);
				$comuna->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$comuna->com_id->setDbValue($conn->Insert_ID());
			$rsnew['com_id'] = $comuna->com_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$comuna->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
