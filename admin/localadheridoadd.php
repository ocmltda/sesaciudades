<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "localadheridoinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$localadherido_add = new clocaladherido_add();
$Page =& $localadherido_add;

// Page init
$localadherido_add->Page_Init();

// Page main
$localadherido_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var localadherido_add = new ew_Page("localadherido_add");

// page properties
localadherido_add.PageID = "add"; // page ID
localadherido_add.FormID = "flocaladheridoadd"; // form ID
var EW_PAGE_ID = localadherido_add.PageID; // for backward compatibility

// extend page with ValidateForm function
localadherido_add.ValidateForm = function(fobj) {
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
localadherido_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
localadherido_add.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
localadherido_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
localadherido_add.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $localadherido_add->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $localadherido->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $localadherido->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$localadherido_add->ShowMessage();
?>
<form name="flocaladheridoadd" id="flocaladheridoadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return localadherido_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="localadherido">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($localadherido->emp_id->Visible) { // emp_id ?>
	<tr id="r_emp_id"<?php echo $localadherido->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $localadherido->emp_id->FldCaption() ?></td>
		<td<?php echo $localadherido->emp_id->CellAttributes() ?>><span id="el_emp_id">
<?php $localadherido->emp_id->EditAttrs["onchange"] = "ew_UpdateOpt('x_cup_id','x_emp_id',true);ew_UpdateOpt('x_loc_id','x_emp_id',true); " . @$localadherido->emp_id->EditAttrs["onchange"]; ?>
<select id="x_emp_id" name="x_emp_id"<?php echo $localadherido->emp_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->emp_id->EditValue)) {
	$arwrk = $localadherido->emp_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->emp_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,1,$localadherido->emp_id) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `emp_id`, `emp_nomfantasia` AS `DispFld`, `emp_rut` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `emp_nomfantasia` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x_emp_id" id="s_x_emp_id" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x_emp_id" id="lft_x_emp_id" value="">
</span><?php echo $localadherido->emp_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($localadherido->cup_id->Visible) { // cup_id ?>
	<tr id="r_cup_id"<?php echo $localadherido->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $localadherido->cup_id->FldCaption() ?></td>
		<td<?php echo $localadherido->cup_id->CellAttributes() ?>><span id="el_cup_id">
<select id="x_cup_id" name="x_cup_id"<?php echo $localadherido->cup_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->cup_id->EditValue)) {
	$arwrk = $localadherido->cup_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->cup_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `cup_id`, `cup_nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cupon`";
$sWhereWrk = "`emp_id` IN ({filter_value})";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `cup_nombre` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x_cup_id" id="s_x_cup_id" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x_cup_id" id="lft_x_cup_id" value="1">
</span><?php echo $localadherido->cup_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($localadherido->loc_id->Visible) { // loc_id ?>
	<tr id="r_loc_id"<?php echo $localadherido->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $localadherido->loc_id->FldCaption() ?></td>
		<td<?php echo $localadherido->loc_id->CellAttributes() ?>><span id="el_loc_id">
<select id="x_loc_id" name="x_loc_id"<?php echo $localadherido->loc_id->EditAttributes() ?>>
<?php
if (is_array($localadherido->loc_id->EditValue)) {
	$arwrk = $localadherido->loc_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($localadherido->loc_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,1,$localadherido->loc_id) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `loc_id`, `loc_nombre` AS `DispFld`, `loc_direccion` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `local`";
$sWhereWrk = "`emp_id` IN ({filter_value})";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `loc_nombre` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x_loc_id" id="s_x_loc_id" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x_loc_id" id="lft_x_loc_id" value="1">
</span><?php echo $localadherido->loc_id->CustomMsg ?></td>
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
ew_UpdateOpts([['x_cup_id','x_emp_id',false],
['x_loc_id','x_emp_id',false],
['x_emp_id','x_emp_id',false]]);

//-->
</script>
<?php
$localadherido_add->ShowPageFooter();
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
$localadherido_add->Page_Terminate();
?>
<?php

//
// Page class
//
class clocaladherido_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'localadherido';

	// Page object name
	var $PageObjName = 'localadherido_add';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $localadherido;
		if ($localadherido->UseTokenInUrl) $PageUrl .= "t=" . $localadherido->TableVar . "&"; // Add page token
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
		global $objForm, $localadherido;
		if ($localadherido->UseTokenInUrl) {
			if ($objForm)
				return ($localadherido->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($localadherido->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function clocaladherido_add() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (localadherido)
		if (!isset($GLOBALS["localadherido"])) {
			$GLOBALS["localadherido"] = new clocaladherido();
			$GLOBALS["Table"] =& $GLOBALS["localadherido"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'localadherido', TRUE);

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
		global $localadherido;

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
		global $objForm, $Language, $gsFormError, $localadherido;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$localadherido->CurrentAction = $_POST["a_add"]; // Get form action
			$this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$localadherido->CurrentAction = "I"; // Form error, reset action
				$localadherido->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back

			// Load key values from QueryString
			$bCopy = TRUE;
			if (@$_GET["lad_id"] != "") {
				$localadherido->lad_id->setQueryStringValue($_GET["lad_id"]);
				$localadherido->setKey("lad_id", $localadherido->lad_id->CurrentValue); // Set up key
			} else {
				$localadherido->setKey("lad_id", ""); // Clear key
				$bCopy = FALSE;
			}
			if ($bCopy) {
				$localadherido->CurrentAction = "C"; // Copy record
			} else {
				$localadherido->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Perform action based on action code
		switch ($localadherido->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("localadheridolist.php"); // No matching record, return to list
				}
				break;
			case "A": // ' Add new record
				$localadherido->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $localadherido->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "localadheridoview.php")
						$sReturnUrl = $localadherido->ViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$localadherido->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$localadherido->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $localadherido;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $localadherido;
		$localadherido->emp_id->CurrentValue = NULL;
		$localadherido->emp_id->OldValue = $localadherido->emp_id->CurrentValue;
		$localadherido->cup_id->CurrentValue = NULL;
		$localadherido->cup_id->OldValue = $localadherido->cup_id->CurrentValue;
		$localadherido->loc_id->CurrentValue = NULL;
		$localadherido->loc_id->OldValue = $localadherido->loc_id->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $localadherido;
		if (!$localadherido->emp_id->FldIsDetailKey) {
			$localadherido->emp_id->setFormValue($objForm->GetValue("x_emp_id"));
		}
		if (!$localadherido->cup_id->FldIsDetailKey) {
			$localadherido->cup_id->setFormValue($objForm->GetValue("x_cup_id"));
		}
		if (!$localadherido->loc_id->FldIsDetailKey) {
			$localadherido->loc_id->setFormValue($objForm->GetValue("x_loc_id"));
		}
		$localadherido->lad_id->setFormValue($objForm->GetValue("x_lad_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $localadherido;
		$this->LoadOldRecord();
		$localadherido->lad_id->CurrentValue = $localadherido->lad_id->FormValue;
		$localadherido->emp_id->CurrentValue = $localadherido->emp_id->FormValue;
		$localadherido->cup_id->CurrentValue = $localadherido->cup_id->FormValue;
		$localadherido->loc_id->CurrentValue = $localadherido->loc_id->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $localadherido;
		$sFilter = $localadherido->KeyFilter();

		// Call Row Selecting event
		$localadherido->Row_Selecting($sFilter);

		// Load SQL based on filter
		$localadherido->CurrentFilter = $sFilter;
		$sSql = $localadherido->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$localadherido->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $localadherido;
		if (!$rs || $rs->EOF) return;
		$localadherido->lad_id->setDbValue($rs->fields('lad_id'));
		$localadherido->emp_id->setDbValue($rs->fields('emp_id'));
		$localadherido->cup_id->setDbValue($rs->fields('cup_id'));
		$localadherido->loc_id->setDbValue($rs->fields('loc_id'));
	}

	// Load old record
	function LoadOldRecord() {
		global $localadherido;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($localadherido->getKey("lad_id")) <> "")
			$localadherido->lad_id->CurrentValue = $localadherido->getKey("lad_id"); // lad_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$localadherido->CurrentFilter = $localadherido->KeyFilter();
			$sSql = $localadherido->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $localadherido;

		// Initialize URLs
		// Call Row_Rendering event

		$localadherido->Row_Rendering();

		// Common render codes for all row types
		// lad_id
		// emp_id
		// cup_id
		// loc_id

		if ($localadherido->RowType == EW_ROWTYPE_VIEW) { // View row

			// lad_id
			$localadherido->lad_id->ViewValue = $localadherido->lad_id->CurrentValue;
			$localadherido->lad_id->ViewCustomAttributes = "";

			// emp_id
			if (strval($localadherido->emp_id->CurrentValue) <> "") {
				$sFilterWrk = "`emp_id` = " . ew_AdjustSql($localadherido->emp_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `emp_nomfantasia`, `emp_rut` FROM `empresa`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `emp_nomfantasia` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$localadherido->emp_id->ViewValue = $rswrk->fields('emp_nomfantasia');
					$localadherido->emp_id->ViewValue .= ew_ValueSeparator(0,1,$localadherido->emp_id) . $rswrk->fields('emp_rut');
					$rswrk->Close();
				} else {
					$localadherido->emp_id->ViewValue = $localadherido->emp_id->CurrentValue;
				}
			} else {
				$localadherido->emp_id->ViewValue = NULL;
			}
			$localadherido->emp_id->ViewCustomAttributes = "";

			// cup_id
			if (strval($localadherido->cup_id->CurrentValue) <> "") {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($localadherido->cup_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cup_nombre` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `cup_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$localadherido->cup_id->ViewValue = $rswrk->fields('cup_nombre');
					$rswrk->Close();
				} else {
					$localadherido->cup_id->ViewValue = $localadherido->cup_id->CurrentValue;
				}
			} else {
				$localadherido->cup_id->ViewValue = NULL;
			}
			$localadherido->cup_id->ViewCustomAttributes = "";

			// loc_id
			if (strval($localadherido->loc_id->CurrentValue) <> "") {
				$sFilterWrk = "`loc_id` = " . ew_AdjustSql($localadherido->loc_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `loc_nombre`, `loc_direccion` FROM `local`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `loc_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$localadherido->loc_id->ViewValue = $rswrk->fields('loc_nombre');
					$localadherido->loc_id->ViewValue .= ew_ValueSeparator(0,1,$localadherido->loc_id) . $rswrk->fields('loc_direccion');
					$rswrk->Close();
				} else {
					$localadherido->loc_id->ViewValue = $localadherido->loc_id->CurrentValue;
				}
			} else {
				$localadherido->loc_id->ViewValue = NULL;
			}
			$localadherido->loc_id->ViewCustomAttributes = "";

			// emp_id
			$localadherido->emp_id->LinkCustomAttributes = "";
			$localadherido->emp_id->HrefValue = "";
			$localadherido->emp_id->TooltipValue = "";

			// cup_id
			$localadherido->cup_id->LinkCustomAttributes = "";
			$localadherido->cup_id->HrefValue = "";
			$localadherido->cup_id->TooltipValue = "";

			// loc_id
			$localadherido->loc_id->LinkCustomAttributes = "";
			$localadherido->loc_id->HrefValue = "";
			$localadherido->loc_id->TooltipValue = "";
		} elseif ($localadherido->RowType == EW_ROWTYPE_ADD) { // Add row

			// emp_id
			$localadherido->emp_id->EditCustomAttributes = "";
			if (trim(strval($localadherido->emp_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`emp_id` = " . ew_AdjustSql($localadherido->emp_id->CurrentValue) . "";
			}
			$sSqlWrk = "SELECT `emp_id`, `emp_nomfantasia` AS `DispFld`, `emp_rut` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld` FROM `empresa`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `emp_nomfantasia` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$localadherido->emp_id->EditValue = $arwrk;

			// cup_id
			$localadherido->cup_id->EditCustomAttributes = "";
			if (trim(strval($localadherido->cup_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($localadherido->cup_id->CurrentValue) . "";
			}
			$sSqlWrk = "SELECT `cup_id`, `cup_nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `emp_id` AS `SelectFilterFld` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `cup_nombre` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$localadherido->cup_id->EditValue = $arwrk;

			// loc_id
			$localadherido->loc_id->EditCustomAttributes = "";
			if (trim(strval($localadherido->loc_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`loc_id` = " . ew_AdjustSql($localadherido->loc_id->CurrentValue) . "";
			}
			$sSqlWrk = "SELECT `loc_id`, `loc_nombre` AS `DispFld`, `loc_direccion` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `emp_id` AS `SelectFilterFld` FROM `local`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `loc_nombre` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", ""));
			$localadherido->loc_id->EditValue = $arwrk;

			// Edit refer script
			// emp_id

			$localadherido->emp_id->HrefValue = "";

			// cup_id
			$localadherido->cup_id->HrefValue = "";

			// loc_id
			$localadherido->loc_id->HrefValue = "";
		}
		if ($localadherido->RowType == EW_ROWTYPE_ADD ||
			$localadherido->RowType == EW_ROWTYPE_EDIT ||
			$localadherido->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$localadherido->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($localadherido->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$localadherido->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $localadherido;

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
		global $conn, $Language, $Security, $localadherido;
		$rsnew = array();

		// emp_id
		$localadherido->emp_id->SetDbValueDef($rsnew, $localadherido->emp_id->CurrentValue, NULL, FALSE);

		// cup_id
		$localadherido->cup_id->SetDbValueDef($rsnew, $localadherido->cup_id->CurrentValue, NULL, FALSE);

		// loc_id
		$localadherido->loc_id->SetDbValueDef($rsnew, $localadherido->loc_id->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $localadherido->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($localadherido->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($localadherido->CancelMessage <> "") {
				$this->setFailureMessage($localadherido->CancelMessage);
				$localadherido->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$localadherido->lad_id->setDbValue($conn->Insert_ID());
			$rsnew['lad_id'] = $localadherido->lad_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$localadherido->Row_Inserted($rs, $rsnew);
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
