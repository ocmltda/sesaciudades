<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "cupon_regioninfo.php" ?>
<?php include_once "cuponinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$cupon_region_add = new ccupon_region_add();
$Page =& $cupon_region_add;

// Page init
$cupon_region_add->Page_Init();

// Page main
$cupon_region_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var cupon_region_add = new ew_Page("cupon_region_add");

// page properties
cupon_region_add.PageID = "add"; // page ID
cupon_region_add.FormID = "fcupon_regionadd"; // form ID
var EW_PAGE_ID = cupon_region_add.PageID; // for backward compatibility

// extend page with ValidateForm function
cupon_region_add.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = 1;
	for (i=0; i<rowcnt; i++) {
		infix = "";

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
cupon_region_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cupon_region_add.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cupon_region_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cupon_region_add.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $cupon_region_add->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cupon_region->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $cupon_region->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$cupon_region_add->ShowMessage();
?>
<form name="fcupon_regionadd" id="fcupon_regionadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return cupon_region_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="cupon_region">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cupon_region->cup_id->Visible) { // cup_id ?>
	<tr id="r_cup_id"<?php echo $cupon_region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon_region->cup_id->FldCaption() ?></td>
		<td<?php echo $cupon_region->cup_id->CellAttributes() ?>><span id="el_cup_id">
<?php if ($cupon_region->cup_id->getSessionValue() <> "") { ?>
<div<?php echo $cupon_region->cup_id->ViewAttributes() ?>><?php echo $cupon_region->cup_id->ViewValue ?></div>
<input type="hidden" id="x_cup_id" name="x_cup_id" value="<?php echo ew_HtmlEncode($cupon_region->cup_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x_cup_id" name="x_cup_id"<?php echo $cupon_region->cup_id->EditAttributes() ?>>
<?php
if (is_array($cupon_region->cup_id->EditValue)) {
	$arwrk = $cupon_region->cup_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_region->cup_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php } ?>
</span><?php echo $cupon_region->cup_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cupon_region->reg_id->Visible) { // reg_id ?>
	<tr id="r_reg_id"<?php echo $cupon_region->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon_region->reg_id->FldCaption() ?></td>
		<td<?php echo $cupon_region->reg_id->CellAttributes() ?>><span id="el_reg_id">
<select id="x_reg_id" name="x_reg_id"<?php echo $cupon_region->reg_id->EditAttributes() ?>>
<?php
if (is_array($cupon_region->reg_id->EditValue)) {
	$arwrk = $cupon_region->reg_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_region->reg_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,1,$cupon_region->reg_id) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $cupon_region->reg_id->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<?php
$cupon_region_add->ShowPageFooter();
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
$cupon_region_add->Page_Terminate();
?>
<?php

//
// Page class
//
class ccupon_region_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'cupon_region';

	// Page object name
	var $PageObjName = 'cupon_region_add';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cupon_region;
		if ($cupon_region->UseTokenInUrl) $PageUrl .= "t=" . $cupon_region->TableVar . "&"; // Add page token
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
		global $objForm, $cupon_region;
		if ($cupon_region->UseTokenInUrl) {
			if ($objForm)
				return ($cupon_region->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cupon_region->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccupon_region_add() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (cupon_region)
		if (!isset($GLOBALS["cupon_region"])) {
			$GLOBALS["cupon_region"] = new ccupon_region();
			$GLOBALS["Table"] =& $GLOBALS["cupon_region"];
		}

		// Table object (cupon)
		if (!isset($GLOBALS['cupon'])) $GLOBALS['cupon'] = new ccupon();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cupon_region', TRUE);

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
		global $cupon_region;

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
		global $objForm, $Language, $gsFormError, $cupon_region;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$cupon_region->CurrentAction = $_POST["a_add"]; // Get form action
			$this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$cupon_region->CurrentAction = "I"; // Form error, reset action
				$cupon_region->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back

			// Load key values from QueryString
			$bCopy = TRUE;
			if (@$_GET["crg_id"] != "") {
				$cupon_region->crg_id->setQueryStringValue($_GET["crg_id"]);
				$cupon_region->setKey("crg_id", $cupon_region->crg_id->CurrentValue); // Set up key
			} else {
				$cupon_region->setKey("crg_id", ""); // Clear key
				$bCopy = FALSE;
			}
			if ($bCopy) {
				$cupon_region->CurrentAction = "C"; // Copy record
			} else {
				$cupon_region->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Perform action based on action code
		switch ($cupon_region->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("cupon_regionlist.php"); // No matching record, return to list
				}
				break;
			case "A": // ' Add new record
				$cupon_region->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $cupon_region->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cupon_regionview.php")
						$sReturnUrl = $cupon_region->ViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$cupon_region->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$cupon_region->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $cupon_region;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $cupon_region;
		$cupon_region->cup_id->CurrentValue = NULL;
		$cupon_region->cup_id->OldValue = $cupon_region->cup_id->CurrentValue;
		$cupon_region->reg_id->CurrentValue = NULL;
		$cupon_region->reg_id->OldValue = $cupon_region->reg_id->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $cupon_region;
		if (!$cupon_region->cup_id->FldIsDetailKey) {
			$cupon_region->cup_id->setFormValue($objForm->GetValue("x_cup_id"));
		}
		if (!$cupon_region->reg_id->FldIsDetailKey) {
			$cupon_region->reg_id->setFormValue($objForm->GetValue("x_reg_id"));
		}
		$cupon_region->crg_id->setFormValue($objForm->GetValue("x_crg_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $cupon_region;
		$this->LoadOldRecord();
		$cupon_region->crg_id->CurrentValue = $cupon_region->crg_id->FormValue;
		$cupon_region->cup_id->CurrentValue = $cupon_region->cup_id->FormValue;
		$cupon_region->reg_id->CurrentValue = $cupon_region->reg_id->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cupon_region;
		$sFilter = $cupon_region->KeyFilter();

		// Call Row Selecting event
		$cupon_region->Row_Selecting($sFilter);

		// Load SQL based on filter
		$cupon_region->CurrentFilter = $sFilter;
		$sSql = $cupon_region->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$cupon_region->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $cupon_region;
		if (!$rs || $rs->EOF) return;
		$cupon_region->crg_id->setDbValue($rs->fields('crg_id'));
		$cupon_region->cup_id->setDbValue($rs->fields('cup_id'));
		$cupon_region->reg_id->setDbValue($rs->fields('reg_id'));
	}

	// Load old record
	function LoadOldRecord() {
		global $cupon_region;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($cupon_region->getKey("crg_id")) <> "")
			$cupon_region->crg_id->CurrentValue = $cupon_region->getKey("crg_id"); // crg_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$cupon_region->CurrentFilter = $cupon_region->KeyFilter();
			$sSql = $cupon_region->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $cupon_region;

		// Initialize URLs
		// Call Row_Rendering event

		$cupon_region->Row_Rendering();

		// Common render codes for all row types
		// crg_id
		// cup_id
		// reg_id

		if ($cupon_region->RowType == EW_ROWTYPE_VIEW) { // View row

			// crg_id
			$cupon_region->crg_id->ViewValue = $cupon_region->crg_id->CurrentValue;
			$cupon_region->crg_id->ViewCustomAttributes = "";

			// cup_id
			if (strval($cupon_region->cup_id->CurrentValue) <> "") {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($cupon_region->cup_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cup_nombre` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$cupon_region->cup_id->ViewValue = $rswrk->fields('cup_nombre');
					$rswrk->Close();
				} else {
					$cupon_region->cup_id->ViewValue = $cupon_region->cup_id->CurrentValue;
				}
			} else {
				$cupon_region->cup_id->ViewValue = NULL;
			}
			$cupon_region->cup_id->ViewCustomAttributes = "";

			// reg_id
			if (strval($cupon_region->reg_id->CurrentValue) <> "") {
				$sFilterWrk = "`reg_id` = " . ew_AdjustSql($cupon_region->reg_id->CurrentValue) . "";
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
					$cupon_region->reg_id->ViewValue = $rswrk->fields('reg_num');
					$cupon_region->reg_id->ViewValue .= ew_ValueSeparator(0,1,$cupon_region->reg_id) . $rswrk->fields('reg_nombre');
					$rswrk->Close();
				} else {
					$cupon_region->reg_id->ViewValue = $cupon_region->reg_id->CurrentValue;
				}
			} else {
				$cupon_region->reg_id->ViewValue = NULL;
			}
			$cupon_region->reg_id->ViewCustomAttributes = "";

			// cup_id
			$cupon_region->cup_id->LinkCustomAttributes = "";
			$cupon_region->cup_id->HrefValue = "";
			$cupon_region->cup_id->TooltipValue = "";

			// reg_id
			$cupon_region->reg_id->LinkCustomAttributes = "";
			$cupon_region->reg_id->HrefValue = "";
			$cupon_region->reg_id->TooltipValue = "";
		} elseif ($cupon_region->RowType == EW_ROWTYPE_ADD) { // Add row

			// cup_id
			$cupon_region->cup_id->EditCustomAttributes = "";
			if ($cupon_region->cup_id->getSessionValue() <> "") {
				$cupon_region->cup_id->CurrentValue = $cupon_region->cup_id->getSessionValue();
			if (strval($cupon_region->cup_id->CurrentValue) <> "") {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($cupon_region->cup_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cup_nombre` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$cupon_region->cup_id->ViewValue = $rswrk->fields('cup_nombre');
					$rswrk->Close();
				} else {
					$cupon_region->cup_id->ViewValue = $cupon_region->cup_id->CurrentValue;
				}
			} else {
				$cupon_region->cup_id->ViewValue = NULL;
			}
			$cupon_region->cup_id->ViewCustomAttributes = "";
			} else {
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `cup_id`, `cup_nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$cupon_region->cup_id->EditValue = $arwrk;
			}

			// reg_id
			$cupon_region->reg_id->EditCustomAttributes = "";
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
			$cupon_region->reg_id->EditValue = $arwrk;

			// Edit refer script
			// cup_id

			$cupon_region->cup_id->HrefValue = "";

			// reg_id
			$cupon_region->reg_id->HrefValue = "";
		}
		if ($cupon_region->RowType == EW_ROWTYPE_ADD ||
			$cupon_region->RowType == EW_ROWTYPE_EDIT ||
			$cupon_region->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$cupon_region->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($cupon_region->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$cupon_region->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $cupon_region;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");

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
		global $conn, $Language, $Security, $cupon_region;
		$rsnew = array();

		// cup_id
		$cupon_region->cup_id->SetDbValueDef($rsnew, $cupon_region->cup_id->CurrentValue, NULL, FALSE);

		// reg_id
		$cupon_region->reg_id->SetDbValueDef($rsnew, $cupon_region->reg_id->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $cupon_region->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($cupon_region->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($cupon_region->CancelMessage <> "") {
				$this->setFailureMessage($cupon_region->CancelMessage);
				$cupon_region->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$cupon_region->crg_id->setDbValue($conn->Insert_ID());
			$rsnew['crg_id'] = $cupon_region->crg_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$cupon_region->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		global $cupon_region;
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (@$_GET[EW_TABLE_SHOW_MASTER] <> "") {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "cupon") {
				$bValidMaster = TRUE;
				if (@$_GET["cup_id"] <> "") {
					$GLOBALS["cupon"]->cup_id->setQueryStringValue($_GET["cup_id"]);
					$cupon_region->cup_id->setQueryStringValue($GLOBALS["cupon"]->cup_id->QueryStringValue);
					$cupon_region->cup_id->setSessionValue($cupon_region->cup_id->QueryStringValue);
					if (!is_numeric($GLOBALS["cupon"]->cup_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$cupon_region->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$cupon_region->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "cupon") {
				if ($cupon_region->cup_id->QueryStringValue == "") $cupon_region->cup_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $cupon_region->getMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $cupon_region->getDetailFilter(); // Get detail filter
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
