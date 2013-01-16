<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "cupon_categinfo.php" ?>
<?php include_once "cuponinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$cupon_categ_add = new ccupon_categ_add();
$Page =& $cupon_categ_add;

// Page init
$cupon_categ_add->Page_Init();

// Page main
$cupon_categ_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var cupon_categ_add = new ew_Page("cupon_categ_add");

// page properties
cupon_categ_add.PageID = "add"; // page ID
cupon_categ_add.FormID = "fcupon_categadd"; // form ID
var EW_PAGE_ID = cupon_categ_add.PageID; // for backward compatibility

// extend page with ValidateForm function
cupon_categ_add.ValidateForm = function(fobj) {
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
cupon_categ_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cupon_categ_add.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cupon_categ_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cupon_categ_add.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $cupon_categ_add->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cupon_categ->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $cupon_categ->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$cupon_categ_add->ShowMessage();
?>
<form name="fcupon_categadd" id="fcupon_categadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return cupon_categ_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="cupon_categ">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cupon_categ->cup_id->Visible) { // cup_id ?>
	<tr id="r_cup_id"<?php echo $cupon_categ->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon_categ->cup_id->FldCaption() ?></td>
		<td<?php echo $cupon_categ->cup_id->CellAttributes() ?>><span id="el_cup_id">
<?php if ($cupon_categ->cup_id->getSessionValue() <> "") { ?>
<div<?php echo $cupon_categ->cup_id->ViewAttributes() ?>><?php echo $cupon_categ->cup_id->ViewValue ?></div>
<input type="hidden" id="x_cup_id" name="x_cup_id" value="<?php echo ew_HtmlEncode($cupon_categ->cup_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x_cup_id" name="x_cup_id"<?php echo $cupon_categ->cup_id->EditAttributes() ?>>
<?php
if (is_array($cupon_categ->cup_id->EditValue)) {
	$arwrk = $cupon_categ->cup_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_categ->cup_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $cupon_categ->cup_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cupon_categ->cat_id->Visible) { // cat_id ?>
	<tr id="r_cat_id"<?php echo $cupon_categ->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon_categ->cat_id->FldCaption() ?></td>
		<td<?php echo $cupon_categ->cat_id->CellAttributes() ?>><span id="el_cat_id">
<select id="x_cat_id" name="x_cat_id"<?php echo $cupon_categ->cat_id->EditAttributes() ?>>
<?php
if (is_array($cupon_categ->cat_id->EditValue)) {
	$arwrk = $cupon_categ->cat_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon_categ->cat_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $cupon_categ->cat_id->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<?php
$cupon_categ_add->ShowPageFooter();
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
$cupon_categ_add->Page_Terminate();
?>
<?php

//
// Page class
//
class ccupon_categ_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'cupon_categ';

	// Page object name
	var $PageObjName = 'cupon_categ_add';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cupon_categ;
		if ($cupon_categ->UseTokenInUrl) $PageUrl .= "t=" . $cupon_categ->TableVar . "&"; // Add page token
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
		global $objForm, $cupon_categ;
		if ($cupon_categ->UseTokenInUrl) {
			if ($objForm)
				return ($cupon_categ->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cupon_categ->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccupon_categ_add() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (cupon_categ)
		if (!isset($GLOBALS["cupon_categ"])) {
			$GLOBALS["cupon_categ"] = new ccupon_categ();
			$GLOBALS["Table"] =& $GLOBALS["cupon_categ"];
		}

		// Table object (cupon)
		if (!isset($GLOBALS['cupon'])) $GLOBALS['cupon'] = new ccupon();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cupon_categ', TRUE);

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
		global $cupon_categ;

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
		global $objForm, $Language, $gsFormError, $cupon_categ;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$cupon_categ->CurrentAction = $_POST["a_add"]; // Get form action
			$this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$cupon_categ->CurrentAction = "I"; // Form error, reset action
				$cupon_categ->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back

			// Load key values from QueryString
			$bCopy = TRUE;
			if (@$_GET["cct_id"] != "") {
				$cupon_categ->cct_id->setQueryStringValue($_GET["cct_id"]);
				$cupon_categ->setKey("cct_id", $cupon_categ->cct_id->CurrentValue); // Set up key
			} else {
				$cupon_categ->setKey("cct_id", ""); // Clear key
				$bCopy = FALSE;
			}
			if ($bCopy) {
				$cupon_categ->CurrentAction = "C"; // Copy record
			} else {
				$cupon_categ->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Perform action based on action code
		switch ($cupon_categ->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("cupon_categlist.php"); // No matching record, return to list
				}
				break;
			case "A": // ' Add new record
				$cupon_categ->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $cupon_categ->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cupon_categview.php")
						$sReturnUrl = $cupon_categ->ViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$cupon_categ->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$cupon_categ->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $cupon_categ;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $cupon_categ;
		$cupon_categ->cup_id->CurrentValue = NULL;
		$cupon_categ->cup_id->OldValue = $cupon_categ->cup_id->CurrentValue;
		$cupon_categ->cat_id->CurrentValue = NULL;
		$cupon_categ->cat_id->OldValue = $cupon_categ->cat_id->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $cupon_categ;
		if (!$cupon_categ->cup_id->FldIsDetailKey) {
			$cupon_categ->cup_id->setFormValue($objForm->GetValue("x_cup_id"));
		}
		if (!$cupon_categ->cat_id->FldIsDetailKey) {
			$cupon_categ->cat_id->setFormValue($objForm->GetValue("x_cat_id"));
		}
		$cupon_categ->cct_id->setFormValue($objForm->GetValue("x_cct_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $cupon_categ;
		$this->LoadOldRecord();
		$cupon_categ->cct_id->CurrentValue = $cupon_categ->cct_id->FormValue;
		$cupon_categ->cup_id->CurrentValue = $cupon_categ->cup_id->FormValue;
		$cupon_categ->cat_id->CurrentValue = $cupon_categ->cat_id->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cupon_categ;
		$sFilter = $cupon_categ->KeyFilter();

		// Call Row Selecting event
		$cupon_categ->Row_Selecting($sFilter);

		// Load SQL based on filter
		$cupon_categ->CurrentFilter = $sFilter;
		$sSql = $cupon_categ->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$cupon_categ->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $cupon_categ;
		if (!$rs || $rs->EOF) return;
		$cupon_categ->cct_id->setDbValue($rs->fields('cct_id'));
		$cupon_categ->cup_id->setDbValue($rs->fields('cup_id'));
		$cupon_categ->cat_id->setDbValue($rs->fields('cat_id'));
	}

	// Load old record
	function LoadOldRecord() {
		global $cupon_categ;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($cupon_categ->getKey("cct_id")) <> "")
			$cupon_categ->cct_id->CurrentValue = $cupon_categ->getKey("cct_id"); // cct_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$cupon_categ->CurrentFilter = $cupon_categ->KeyFilter();
			$sSql = $cupon_categ->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $cupon_categ;

		// Initialize URLs
		// Call Row_Rendering event

		$cupon_categ->Row_Rendering();

		// Common render codes for all row types
		// cct_id
		// cup_id
		// cat_id

		if ($cupon_categ->RowType == EW_ROWTYPE_VIEW) { // View row

			// cct_id
			$cupon_categ->cct_id->ViewValue = $cupon_categ->cct_id->CurrentValue;
			$cupon_categ->cct_id->ViewCustomAttributes = "";

			// cup_id
			if (strval($cupon_categ->cup_id->CurrentValue) <> "") {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($cupon_categ->cup_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cup_nombre` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$cupon_categ->cup_id->ViewValue = $rswrk->fields('cup_nombre');
					$rswrk->Close();
				} else {
					$cupon_categ->cup_id->ViewValue = $cupon_categ->cup_id->CurrentValue;
				}
			} else {
				$cupon_categ->cup_id->ViewValue = NULL;
			}
			$cupon_categ->cup_id->ViewCustomAttributes = "";

			// cat_id
			if (strval($cupon_categ->cat_id->CurrentValue) <> "") {
				$sFilterWrk = "`cat_id` = " . ew_AdjustSql($cupon_categ->cat_id->CurrentValue) . "";
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
					$cupon_categ->cat_id->ViewValue = $rswrk->fields('cat_nombre');
					$rswrk->Close();
				} else {
					$cupon_categ->cat_id->ViewValue = $cupon_categ->cat_id->CurrentValue;
				}
			} else {
				$cupon_categ->cat_id->ViewValue = NULL;
			}
			$cupon_categ->cat_id->ViewCustomAttributes = "";

			// cup_id
			$cupon_categ->cup_id->LinkCustomAttributes = "";
			$cupon_categ->cup_id->HrefValue = "";
			$cupon_categ->cup_id->TooltipValue = "";

			// cat_id
			$cupon_categ->cat_id->LinkCustomAttributes = "";
			$cupon_categ->cat_id->HrefValue = "";
			$cupon_categ->cat_id->TooltipValue = "";
		} elseif ($cupon_categ->RowType == EW_ROWTYPE_ADD) { // Add row

			// cup_id
			$cupon_categ->cup_id->EditCustomAttributes = "";
			if ($cupon_categ->cup_id->getSessionValue() <> "") {
				$cupon_categ->cup_id->CurrentValue = $cupon_categ->cup_id->getSessionValue();
			if (strval($cupon_categ->cup_id->CurrentValue) <> "") {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($cupon_categ->cup_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cup_nombre` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$cupon_categ->cup_id->ViewValue = $rswrk->fields('cup_nombre');
					$rswrk->Close();
				} else {
					$cupon_categ->cup_id->ViewValue = $cupon_categ->cup_id->CurrentValue;
				}
			} else {
				$cupon_categ->cup_id->ViewValue = NULL;
			}
			$cupon_categ->cup_id->ViewCustomAttributes = "";
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
			$cupon_categ->cup_id->EditValue = $arwrk;
			}

			// cat_id
			$cupon_categ->cat_id->EditCustomAttributes = "";
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `cat_id`, `cat_nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld` FROM `categoria`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `cat_nombre` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$cupon_categ->cat_id->EditValue = $arwrk;

			// Edit refer script
			// cup_id

			$cupon_categ->cup_id->HrefValue = "";

			// cat_id
			$cupon_categ->cat_id->HrefValue = "";
		}
		if ($cupon_categ->RowType == EW_ROWTYPE_ADD ||
			$cupon_categ->RowType == EW_ROWTYPE_EDIT ||
			$cupon_categ->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$cupon_categ->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($cupon_categ->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$cupon_categ->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $cupon_categ;

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
		global $conn, $Language, $Security, $cupon_categ;
		$rsnew = array();

		// cup_id
		$cupon_categ->cup_id->SetDbValueDef($rsnew, $cupon_categ->cup_id->CurrentValue, NULL, FALSE);

		// cat_id
		$cupon_categ->cat_id->SetDbValueDef($rsnew, $cupon_categ->cat_id->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $cupon_categ->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($cupon_categ->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($cupon_categ->CancelMessage <> "") {
				$this->setFailureMessage($cupon_categ->CancelMessage);
				$cupon_categ->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$cupon_categ->cct_id->setDbValue($conn->Insert_ID());
			$rsnew['cct_id'] = $cupon_categ->cct_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$cupon_categ->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		global $cupon_categ;
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
					$cupon_categ->cup_id->setQueryStringValue($GLOBALS["cupon"]->cup_id->QueryStringValue);
					$cupon_categ->cup_id->setSessionValue($cupon_categ->cup_id->QueryStringValue);
					if (!is_numeric($GLOBALS["cupon"]->cup_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$cupon_categ->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$cupon_categ->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "cupon") {
				if ($cupon_categ->cup_id->QueryStringValue == "") $cupon_categ->cup_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $cupon_categ->getMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $cupon_categ->getDetailFilter(); // Get detail filter
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
