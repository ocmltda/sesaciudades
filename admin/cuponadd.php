<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "cuponinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$cupon_add = new ccupon_add();
$Page =& $cupon_add;

// Page init
$cupon_add->Page_Init();

// Page main
$cupon_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var cupon_add = new ew_Page("cupon_add");

// page properties
cupon_add.PageID = "add"; // page ID
cupon_add.FormID = "fcuponadd"; // form ID
var EW_PAGE_ID = cupon_add.PageID; // for backward compatibility

// extend page with ValidateForm function
cupon_add.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = 1;
	for (i=0; i<rowcnt; i++) {
		infix = "";
		elm = fobj.elements["x" + infix + "_cup_nombre"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cupon->cup_nombre->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_cup_preview_nombre"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_cup_imagen_nombre"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));

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
cupon_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cupon_add.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cupon_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cupon_add.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $cupon_add->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cupon->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $cupon->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$cupon_add->ShowMessage();
?>
<form name="fcuponadd" id="fcuponadd" action="<?php echo ew_CurrentPage() ?>" method="post" enctype="multipart/form-data" onsubmit="return cupon_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="cupon">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cupon->emp_id->Visible) { // emp_id ?>
	<tr id="r_emp_id"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->emp_id->FldCaption() ?></td>
		<td<?php echo $cupon->emp_id->CellAttributes() ?>><span id="el_emp_id">
<select id="x_emp_id" name="x_emp_id"<?php echo $cupon->emp_id->EditAttributes() ?>>
<?php
if (is_array($cupon->emp_id->EditValue)) {
	$arwrk = $cupon->emp_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon->emp_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,1,$cupon->emp_id) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][3] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk,2,$cupon->emp_id) ?><?php echo $arwrk[$rowcntwrk][3] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $cupon->emp_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cupon->cat_id->Visible) { // cat_id ?>
	<tr id="r_cat_id"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cat_id->FldCaption() ?></td>
		<td<?php echo $cupon->cat_id->CellAttributes() ?>><span id="el_cat_id">
<select id="x_cat_id" name="x_cat_id"<?php echo $cupon->cat_id->EditAttributes() ?>>
<?php
if (is_array($cupon->cat_id->EditValue)) {
	$arwrk = $cupon->cat_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon->cat_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $cupon->cat_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_nombre->Visible) { // cup_nombre ?>
	<tr id="r_cup_nombre"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $cupon->cup_nombre->CellAttributes() ?>><span id="el_cup_nombre">
<input type="text" name="x_cup_nombre" id="x_cup_nombre" size="60" maxlength="128" value="<?php echo $cupon->cup_nombre->EditValue ?>"<?php echo $cupon->cup_nombre->EditAttributes() ?>>
</span><?php echo $cupon->cup_nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_preview_nombre->Visible) { // cup_preview_nombre ?>
	<tr id="r_cup_preview_nombre"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_preview_nombre->FldCaption() ?></td>
		<td<?php echo $cupon->cup_preview_nombre->CellAttributes() ?>><span id="el_cup_preview_nombre">
<div id="old_x_cup_preview_nombre">
<?php if ($cupon->cup_preview_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($cupon->cup_preview_nombre->Upload->DbValue)) { ?>
<a<?php echo $cupon->cup_preview_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_preview_nombre->UploadPath) . $cupon->cup_preview_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_preview_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($cupon->cup_preview_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_preview_nombre->UploadPath) . $cupon->cup_preview_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_preview_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x_cup_preview_nombre">
<?php if (!empty($cupon->cup_preview_nombre->Upload->DbValue)) { ?>
<label><input type="radio" name="a_cup_preview_nombre" id="a_cup_preview_nombre" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_cup_preview_nombre" id="a_cup_preview_nombre" value="2"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_cup_preview_nombre" id="a_cup_preview_nombre" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $cupon->cup_preview_nombre->EditAttrs["onchange"] = "this.form.a_cup_preview_nombre[2].checked=true;" . @$cupon->cup_preview_nombre->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_cup_preview_nombre" id="a_cup_preview_nombre" value="3">
<?php } ?>
<input type="file" name="x_cup_preview_nombre" id="x_cup_preview_nombre" size="60"<?php echo $cupon->cup_preview_nombre->EditAttributes() ?>>
</div>
</span><?php echo $cupon->cup_preview_nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_imagen_nombre->Visible) { // cup_imagen_nombre ?>
	<tr id="r_cup_imagen_nombre"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_imagen_nombre->FldCaption() ?></td>
		<td<?php echo $cupon->cup_imagen_nombre->CellAttributes() ?>><span id="el_cup_imagen_nombre">
<div id="old_x_cup_imagen_nombre">
<?php if ($cupon->cup_imagen_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($cupon->cup_imagen_nombre->Upload->DbValue)) { ?>
<a<?php echo $cupon->cup_imagen_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_imagen_nombre->UploadPath) . $cupon->cup_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_imagen_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($cupon->cup_imagen_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_imagen_nombre->UploadPath) . $cupon->cup_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_imagen_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x_cup_imagen_nombre">
<?php if (!empty($cupon->cup_imagen_nombre->Upload->DbValue)) { ?>
<label><input type="radio" name="a_cup_imagen_nombre" id="a_cup_imagen_nombre" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_cup_imagen_nombre" id="a_cup_imagen_nombre" value="2"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_cup_imagen_nombre" id="a_cup_imagen_nombre" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $cupon->cup_imagen_nombre->EditAttrs["onchange"] = "this.form.a_cup_imagen_nombre[2].checked=true;" . @$cupon->cup_imagen_nombre->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_cup_imagen_nombre" id="a_cup_imagen_nombre" value="3">
<?php } ?>
<input type="file" name="x_cup_imagen_nombre" id="x_cup_imagen_nombre" size="60"<?php echo $cupon->cup_imagen_nombre->EditAttributes() ?>>
</div>
</span><?php echo $cupon->cup_imagen_nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cupon->cup_vigente->Visible) { // cup_vigente ?>
	<tr id="r_cup_vigente"<?php echo $cupon->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cupon->cup_vigente->FldCaption() ?></td>
		<td<?php echo $cupon->cup_vigente->CellAttributes() ?>><span id="el_cup_vigente">
<div id="tp_x_cup_vigente" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><label><input type="radio" name="x_cup_vigente" id="x_cup_vigente" value="{value}"<?php echo $cupon->cup_vigente->EditAttributes() ?>></label></div>
<div id="dsl_x_cup_vigente" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cupon->cup_vigente->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cupon->cup_vigente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_cup_vigente" id="x_cup_vigente" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cupon->cup_vigente->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $cupon->cup_vigente->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<?php
$cupon_add->ShowPageFooter();
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
$cupon_add->Page_Terminate();
?>
<?php

//
// Page class
//
class ccupon_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'cupon';

	// Page object name
	var $PageObjName = 'cupon_add';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cupon;
		if ($cupon->UseTokenInUrl) $PageUrl .= "t=" . $cupon->TableVar . "&"; // Add page token
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
		global $objForm, $cupon;
		if ($cupon->UseTokenInUrl) {
			if ($objForm)
				return ($cupon->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cupon->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccupon_add() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (cupon)
		if (!isset($GLOBALS["cupon"])) {
			$GLOBALS["cupon"] = new ccupon();
			$GLOBALS["Table"] =& $GLOBALS["cupon"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cupon', TRUE);

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
		global $cupon;

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
		global $objForm, $Language, $gsFormError, $cupon;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$cupon->CurrentAction = $_POST["a_add"]; // Get form action
			$this->LoadOldRecord(); // Load old recordset
			$this->GetUploadFiles(); // Get upload files
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$cupon->CurrentAction = "I"; // Form error, reset action
				$cupon->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back

			// Load key values from QueryString
			$bCopy = TRUE;
			if (@$_GET["cup_id"] != "") {
				$cupon->cup_id->setQueryStringValue($_GET["cup_id"]);
				$cupon->setKey("cup_id", $cupon->cup_id->CurrentValue); // Set up key
			} else {
				$cupon->setKey("cup_id", ""); // Clear key
				$bCopy = FALSE;
			}
			if ($bCopy) {
				$cupon->CurrentAction = "C"; // Copy record
			} else {
				$cupon->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Perform action based on action code
		switch ($cupon->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("cuponlist.php"); // No matching record, return to list
				}
				break;
			case "A": // ' Add new record
				$cupon->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $cupon->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cuponview.php")
						$sReturnUrl = $cupon->ViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$cupon->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$cupon->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $cupon;

		// Get upload data
			if ($cupon->cup_preview_nombre->Upload->UploadFile()) {

				// No action required
			} else {
				echo $cupon->cup_preview_nombre->Upload->Message;
				$this->Page_Terminate();
				exit();
			}
			if ($cupon->cup_imagen_nombre->Upload->UploadFile()) {

				// No action required
			} else {
				echo $cupon->cup_imagen_nombre->Upload->Message;
				$this->Page_Terminate();
				exit();
			}
	}

	// Load default values
	function LoadDefaultValues() {
		global $cupon;
		$cupon->emp_id->CurrentValue = NULL;
		$cupon->emp_id->OldValue = $cupon->emp_id->CurrentValue;
		$cupon->cat_id->CurrentValue = NULL;
		$cupon->cat_id->OldValue = $cupon->cat_id->CurrentValue;
		$cupon->cup_nombre->CurrentValue = NULL;
		$cupon->cup_nombre->OldValue = $cupon->cup_nombre->CurrentValue;
		$cupon->cup_preview_nombre->Upload->DbValue = NULL;
		$cupon->cup_preview_nombre->OldValue = $cupon->cup_preview_nombre->Upload->DbValue;
		$cupon->cup_preview_nombre->CurrentValue = NULL; // Clear file related field
		$cupon->cup_imagen_nombre->Upload->DbValue = NULL;
		$cupon->cup_imagen_nombre->OldValue = $cupon->cup_imagen_nombre->Upload->DbValue;
		$cupon->cup_imagen_nombre->CurrentValue = NULL; // Clear file related field
		$cupon->cup_vigente->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $cupon;
		if (!$cupon->emp_id->FldIsDetailKey) {
			$cupon->emp_id->setFormValue($objForm->GetValue("x_emp_id"));
		}
		if (!$cupon->cat_id->FldIsDetailKey) {
			$cupon->cat_id->setFormValue($objForm->GetValue("x_cat_id"));
		}
		if (!$cupon->cup_nombre->FldIsDetailKey) {
			$cupon->cup_nombre->setFormValue($objForm->GetValue("x_cup_nombre"));
		}
		if (!$cupon->cup_vigente->FldIsDetailKey) {
			$cupon->cup_vigente->setFormValue($objForm->GetValue("x_cup_vigente"));
		}
		$cupon->cup_id->setFormValue($objForm->GetValue("x_cup_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $cupon;
		$this->LoadOldRecord();
		$cupon->cup_id->CurrentValue = $cupon->cup_id->FormValue;
		$cupon->emp_id->CurrentValue = $cupon->emp_id->FormValue;
		$cupon->cat_id->CurrentValue = $cupon->cat_id->FormValue;
		$cupon->cup_nombre->CurrentValue = $cupon->cup_nombre->FormValue;
		$cupon->cup_vigente->CurrentValue = $cupon->cup_vigente->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cupon;
		$sFilter = $cupon->KeyFilter();

		// Call Row Selecting event
		$cupon->Row_Selecting($sFilter);

		// Load SQL based on filter
		$cupon->CurrentFilter = $sFilter;
		$sSql = $cupon->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$cupon->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $cupon;
		if (!$rs || $rs->EOF) return;
		$cupon->cup_id->setDbValue($rs->fields('cup_id'));
		$cupon->emp_id->setDbValue($rs->fields('emp_id'));
		$cupon->cat_id->setDbValue($rs->fields('cat_id'));
		$cupon->cup_nombre->setDbValue($rs->fields('cup_nombre'));
		$cupon->cup_preview_nombre->Upload->DbValue = $rs->fields('cup_preview_nombre');
		$cupon->cup_preview_tipo->setDbValue($rs->fields('cup_preview_tipo'));
		$cupon->cup_preview_ancho->setDbValue($rs->fields('cup_preview_ancho'));
		$cupon->cup_preview_alto->setDbValue($rs->fields('cup_preview_alto'));
		$cupon->cup_preview_size->setDbValue($rs->fields('cup_preview_size'));
		$cupon->cup_imagen_nombre->Upload->DbValue = $rs->fields('cup_imagen_nombre');
		$cupon->cup_imagen_tipo->setDbValue($rs->fields('cup_imagen_tipo'));
		$cupon->cup_imagen_ancho->setDbValue($rs->fields('cup_imagen_ancho'));
		$cupon->cup_imagen_alto->setDbValue($rs->fields('cup_imagen_alto'));
		$cupon->cup_imagen_size->setDbValue($rs->fields('cup_imagen_size'));
		$cupon->cup_vigente->setDbValue($rs->fields('cup_vigente'));
	}

	// Load old record
	function LoadOldRecord() {
		global $cupon;

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($cupon->getKey("cup_id")) <> "")
			$cupon->cup_id->CurrentValue = $cupon->getKey("cup_id"); // cup_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$cupon->CurrentFilter = $cupon->KeyFilter();
			$sSql = $cupon->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		}
		return TRUE;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $cupon;

		// Initialize URLs
		// Call Row_Rendering event

		$cupon->Row_Rendering();

		// Common render codes for all row types
		// cup_id
		// emp_id
		// cat_id
		// cup_nombre
		// cup_preview_nombre
		// cup_preview_tipo
		// cup_preview_ancho
		// cup_preview_alto
		// cup_preview_size
		// cup_imagen_nombre
		// cup_imagen_tipo
		// cup_imagen_ancho
		// cup_imagen_alto
		// cup_imagen_size
		// cup_vigente

		if ($cupon->RowType == EW_ROWTYPE_VIEW) { // View row

			// cup_id
			$cupon->cup_id->ViewValue = $cupon->cup_id->CurrentValue;
			$cupon->cup_id->ViewCustomAttributes = "";

			// emp_id
			if (strval($cupon->emp_id->CurrentValue) <> "") {
				$sFilterWrk = "`emp_id` = " . ew_AdjustSql($cupon->emp_id->CurrentValue) . "";
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
					$cupon->emp_id->ViewValue = $rswrk->fields('emp_rut');
					$cupon->emp_id->ViewValue .= ew_ValueSeparator(0,1,$cupon->emp_id) . $rswrk->fields('emp_nomfantasia');
					$cupon->emp_id->ViewValue .= ew_ValueSeparator(0,2,$cupon->emp_id) . $rswrk->fields('emp_razonsocial');
					$rswrk->Close();
				} else {
					$cupon->emp_id->ViewValue = $cupon->emp_id->CurrentValue;
				}
			} else {
				$cupon->emp_id->ViewValue = NULL;
			}
			$cupon->emp_id->ViewCustomAttributes = "";

			// cat_id
			if (strval($cupon->cat_id->CurrentValue) <> "") {
				$sFilterWrk = "`cat_id` = " . ew_AdjustSql($cupon->cat_id->CurrentValue) . "";
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
					$cupon->cat_id->ViewValue = $rswrk->fields('cat_nombre');
					$rswrk->Close();
				} else {
					$cupon->cat_id->ViewValue = $cupon->cat_id->CurrentValue;
				}
			} else {
				$cupon->cat_id->ViewValue = NULL;
			}
			$cupon->cat_id->ViewCustomAttributes = "";

			// cup_nombre
			$cupon->cup_nombre->ViewValue = $cupon->cup_nombre->CurrentValue;
			$cupon->cup_nombre->ViewCustomAttributes = "";

			// cup_preview_nombre
			if (!ew_Empty($cupon->cup_preview_nombre->Upload->DbValue)) {
				$cupon->cup_preview_nombre->ViewValue = $cupon->cup_preview_nombre->Upload->DbValue;
				$cupon->cup_preview_nombre->ImageWidth = 100;
				$cupon->cup_preview_nombre->ImageHeight = 0;
				$cupon->cup_preview_nombre->ImageAlt = $cupon->cup_preview_nombre->FldAlt();
			} else {
				$cupon->cup_preview_nombre->ViewValue = "";
			}
			$cupon->cup_preview_nombre->ViewCustomAttributes = "";

			// cup_preview_ancho
			$cupon->cup_preview_ancho->ViewValue = $cupon->cup_preview_ancho->CurrentValue;
			$cupon->cup_preview_ancho->ViewValue = ew_FormatNumber($cupon->cup_preview_ancho->ViewValue, 0, -2, -2, -2);
			$cupon->cup_preview_ancho->ViewCustomAttributes = "";

			// cup_preview_alto
			$cupon->cup_preview_alto->ViewValue = $cupon->cup_preview_alto->CurrentValue;
			$cupon->cup_preview_alto->ViewValue = ew_FormatNumber($cupon->cup_preview_alto->ViewValue, 0, -2, -2, -2);
			$cupon->cup_preview_alto->ViewCustomAttributes = "";

			// cup_imagen_nombre
			if (!ew_Empty($cupon->cup_imagen_nombre->Upload->DbValue)) {
				$cupon->cup_imagen_nombre->ViewValue = $cupon->cup_imagen_nombre->Upload->DbValue;
				$cupon->cup_imagen_nombre->ImageWidth = 100;
				$cupon->cup_imagen_nombre->ImageHeight = 0;
				$cupon->cup_imagen_nombre->ImageAlt = $cupon->cup_imagen_nombre->FldAlt();
			} else {
				$cupon->cup_imagen_nombre->ViewValue = "";
			}
			$cupon->cup_imagen_nombre->ViewCustomAttributes = "";

			// cup_imagen_ancho
			$cupon->cup_imagen_ancho->ViewValue = $cupon->cup_imagen_ancho->CurrentValue;
			$cupon->cup_imagen_ancho->ViewValue = ew_FormatNumber($cupon->cup_imagen_ancho->ViewValue, 0, -2, -2, -2);
			$cupon->cup_imagen_ancho->ViewCustomAttributes = "";

			// cup_imagen_alto
			$cupon->cup_imagen_alto->ViewValue = $cupon->cup_imagen_alto->CurrentValue;
			$cupon->cup_imagen_alto->ViewValue = ew_FormatNumber($cupon->cup_imagen_alto->ViewValue, 0, -2, -2, -2);
			$cupon->cup_imagen_alto->ViewCustomAttributes = "";

			// cup_vigente
			if (strval($cupon->cup_vigente->CurrentValue) <> "") {
				switch ($cupon->cup_vigente->CurrentValue) {
					case "1":
						$cupon->cup_vigente->ViewValue = $cupon->cup_vigente->FldTagCaption(1) <> "" ? $cupon->cup_vigente->FldTagCaption(1) : $cupon->cup_vigente->CurrentValue;
						break;
					case "0":
						$cupon->cup_vigente->ViewValue = $cupon->cup_vigente->FldTagCaption(2) <> "" ? $cupon->cup_vigente->FldTagCaption(2) : $cupon->cup_vigente->CurrentValue;
						break;
					default:
						$cupon->cup_vigente->ViewValue = $cupon->cup_vigente->CurrentValue;
				}
			} else {
				$cupon->cup_vigente->ViewValue = NULL;
			}
			$cupon->cup_vigente->ViewCustomAttributes = "";

			// emp_id
			$cupon->emp_id->LinkCustomAttributes = "";
			$cupon->emp_id->HrefValue = "";
			$cupon->emp_id->TooltipValue = "";

			// cat_id
			$cupon->cat_id->LinkCustomAttributes = "";
			$cupon->cat_id->HrefValue = "";
			$cupon->cat_id->TooltipValue = "";

			// cup_nombre
			$cupon->cup_nombre->LinkCustomAttributes = "";
			$cupon->cup_nombre->HrefValue = "";
			$cupon->cup_nombre->TooltipValue = "";

			// cup_preview_nombre
			$cupon->cup_preview_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($cupon->cup_preview_nombre->Upload->DbValue)) {
				$cupon->cup_preview_nombre->HrefValue = ew_UploadPathEx(FALSE, $cupon->cup_preview_nombre->UploadPath) . ((!empty($cupon->cup_preview_nombre->ViewValue)) ? $cupon->cup_preview_nombre->ViewValue : $cupon->cup_preview_nombre->CurrentValue); // Add prefix/suffix
				$cupon->cup_preview_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($cupon->Export <> "") $cupon->cup_preview_nombre->HrefValue = ew_ConvertFullUrl($cupon->cup_preview_nombre->HrefValue);
			} else {
				$cupon->cup_preview_nombre->HrefValue = "";
			}
			$cupon->cup_preview_nombre->TooltipValue = "";

			// cup_imagen_nombre
			$cupon->cup_imagen_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($cupon->cup_imagen_nombre->Upload->DbValue)) {
				$cupon->cup_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $cupon->cup_imagen_nombre->UploadPath) . ((!empty($cupon->cup_imagen_nombre->ViewValue)) ? $cupon->cup_imagen_nombre->ViewValue : $cupon->cup_imagen_nombre->CurrentValue); // Add prefix/suffix
				$cupon->cup_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($cupon->Export <> "") $cupon->cup_imagen_nombre->HrefValue = ew_ConvertFullUrl($cupon->cup_imagen_nombre->HrefValue);
			} else {
				$cupon->cup_imagen_nombre->HrefValue = "";
			}
			$cupon->cup_imagen_nombre->TooltipValue = "";

			// cup_vigente
			$cupon->cup_vigente->LinkCustomAttributes = "";
			$cupon->cup_vigente->HrefValue = "";
			$cupon->cup_vigente->TooltipValue = "";
		} elseif ($cupon->RowType == EW_ROWTYPE_ADD) { // Add row

			// emp_id
			$cupon->emp_id->EditCustomAttributes = "";
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
			$cupon->emp_id->EditValue = $arwrk;

			// cat_id
			$cupon->cat_id->EditCustomAttributes = "";
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
			$cupon->cat_id->EditValue = $arwrk;

			// cup_nombre
			$cupon->cup_nombre->EditCustomAttributes = "";
			$cupon->cup_nombre->EditValue = ew_HtmlEncode($cupon->cup_nombre->CurrentValue);

			// cup_preview_nombre
			$cupon->cup_preview_nombre->EditCustomAttributes = "";
			if (!ew_Empty($cupon->cup_preview_nombre->Upload->DbValue)) {
				$cupon->cup_preview_nombre->EditValue = $cupon->cup_preview_nombre->Upload->DbValue;
				$cupon->cup_preview_nombre->ImageWidth = 100;
				$cupon->cup_preview_nombre->ImageHeight = 0;
				$cupon->cup_preview_nombre->ImageAlt = $cupon->cup_preview_nombre->FldAlt();
			} else {
				$cupon->cup_preview_nombre->EditValue = "";
			}

			// cup_imagen_nombre
			$cupon->cup_imagen_nombre->EditCustomAttributes = "";
			if (!ew_Empty($cupon->cup_imagen_nombre->Upload->DbValue)) {
				$cupon->cup_imagen_nombre->EditValue = $cupon->cup_imagen_nombre->Upload->DbValue;
				$cupon->cup_imagen_nombre->ImageWidth = 100;
				$cupon->cup_imagen_nombre->ImageHeight = 0;
				$cupon->cup_imagen_nombre->ImageAlt = $cupon->cup_imagen_nombre->FldAlt();
			} else {
				$cupon->cup_imagen_nombre->EditValue = "";
			}

			// cup_vigente
			$cupon->cup_vigente->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("1", $cupon->cup_vigente->FldTagCaption(1) <> "" ? $cupon->cup_vigente->FldTagCaption(1) : "1");
			$arwrk[] = array("0", $cupon->cup_vigente->FldTagCaption(2) <> "" ? $cupon->cup_vigente->FldTagCaption(2) : "0");
			$cupon->cup_vigente->EditValue = $arwrk;

			// Edit refer script
			// emp_id

			$cupon->emp_id->HrefValue = "";

			// cat_id
			$cupon->cat_id->HrefValue = "";

			// cup_nombre
			$cupon->cup_nombre->HrefValue = "";

			// cup_preview_nombre
			if (!ew_Empty($cupon->cup_preview_nombre->Upload->DbValue)) {
				$cupon->cup_preview_nombre->HrefValue = ew_UploadPathEx(FALSE, $cupon->cup_preview_nombre->UploadPath) . ((!empty($cupon->cup_preview_nombre->EditValue)) ? $cupon->cup_preview_nombre->EditValue : $cupon->cup_preview_nombre->CurrentValue); // Add prefix/suffix
				$cupon->cup_preview_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($cupon->Export <> "") $cupon->cup_preview_nombre->HrefValue = ew_ConvertFullUrl($cupon->cup_preview_nombre->HrefValue);
			} else {
				$cupon->cup_preview_nombre->HrefValue = "";
			}

			// cup_imagen_nombre
			if (!ew_Empty($cupon->cup_imagen_nombre->Upload->DbValue)) {
				$cupon->cup_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $cupon->cup_imagen_nombre->UploadPath) . ((!empty($cupon->cup_imagen_nombre->EditValue)) ? $cupon->cup_imagen_nombre->EditValue : $cupon->cup_imagen_nombre->CurrentValue); // Add prefix/suffix
				$cupon->cup_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($cupon->Export <> "") $cupon->cup_imagen_nombre->HrefValue = ew_ConvertFullUrl($cupon->cup_imagen_nombre->HrefValue);
			} else {
				$cupon->cup_imagen_nombre->HrefValue = "";
			}

			// cup_vigente
			$cupon->cup_vigente->HrefValue = "";
		}
		if ($cupon->RowType == EW_ROWTYPE_ADD ||
			$cupon->RowType == EW_ROWTYPE_EDIT ||
			$cupon->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$cupon->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($cupon->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$cupon->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $cupon;

		// Initialize form error message
		$gsFormError = "";
		if (!ew_CheckFileType($cupon->cup_preview_nombre->Upload->FileName)) {
			ew_AddMessage($gsFormError, $Language->Phrase("WrongFileType"));
		}
		if ($cupon->cup_preview_nombre->Upload->FileSize > 0 && EW_MAX_FILE_SIZE > 0 && $cupon->cup_preview_nombre->Upload->FileSize > EW_MAX_FILE_SIZE) {
			ew_AddMessage($gsFormError, str_replace("%s", EW_MAX_FILE_SIZE, $Language->Phrase("MaxFileSize")));
		}
		if (in_array($cupon->cup_preview_nombre->Upload->Error, array(1, 2, 3, 6, 7, 8))) {
			ew_AddMessage($gsFormError, $Language->Phrase("PhpUploadErr" . $cupon->cup_preview_nombre->Upload->Error));
		}
		if (!ew_CheckFileType($cupon->cup_imagen_nombre->Upload->FileName)) {
			ew_AddMessage($gsFormError, $Language->Phrase("WrongFileType"));
		}
		if ($cupon->cup_imagen_nombre->Upload->FileSize > 0 && EW_MAX_FILE_SIZE > 0 && $cupon->cup_imagen_nombre->Upload->FileSize > EW_MAX_FILE_SIZE) {
			ew_AddMessage($gsFormError, str_replace("%s", EW_MAX_FILE_SIZE, $Language->Phrase("MaxFileSize")));
		}
		if (in_array($cupon->cup_imagen_nombre->Upload->Error, array(1, 2, 3, 6, 7, 8))) {
			ew_AddMessage($gsFormError, $Language->Phrase("PhpUploadErr" . $cupon->cup_imagen_nombre->Upload->Error));
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($cupon->cup_nombre->FormValue) && $cupon->cup_nombre->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $cupon->cup_nombre->FldCaption());
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
		global $conn, $Language, $Security, $cupon;
		$rsnew = array();

		// emp_id
		$cupon->emp_id->SetDbValueDef($rsnew, $cupon->emp_id->CurrentValue, NULL, FALSE);

		// cat_id
		$cupon->cat_id->SetDbValueDef($rsnew, $cupon->cat_id->CurrentValue, NULL, FALSE);

		// cup_nombre
		$cupon->cup_nombre->SetDbValueDef($rsnew, $cupon->cup_nombre->CurrentValue, "", FALSE);

		// cup_preview_nombre
		$cupon->cup_preview_nombre->Upload->SaveToSession(); // Save file value to Session
		if ($cupon->cup_preview_nombre->Upload->Action == "1") { // Keep
			if ($rsold) {
				$rsnew['cup_preview_nombre'] = $rsold->fields['cup_preview_nombre'];
				$rsnew['cup_preview_tipo'] = $rsold->fields['cup_preview_tipo'];
				$rsnew['cup_preview_size'] = $rsold->fields['cup_preview_size'];
				$rsnew['cup_preview_ancho'] = $rsold->fields['cup_preview_ancho'];
				$rsnew['cup_preview_alto'] = $rsold->fields['cup_preview_alto'];
			}
		} elseif ($cupon->cup_preview_nombre->Upload->Action == "2" || $cupon->cup_preview_nombre->Upload->Action == "3") { // Update/Remove
		if (is_null($cupon->cup_preview_nombre->Upload->Value)) {
			$rsnew['cup_preview_nombre'] = NULL;
		} else {
			$rsnew['cup_preview_nombre'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $cupon->cup_preview_nombre->UploadPath), $cupon->cup_preview_nombre->Upload->FileName);
		}
		$cupon->cup_preview_tipo->SetDbValueDef($rsnew, trim($cupon->cup_preview_nombre->Upload->ContentType), NULL, FALSE);
		$cupon->cup_preview_size->SetDbValueDef($rsnew, $cupon->cup_preview_nombre->Upload->FileSize, NULL, FALSE);
		$cupon->cup_preview_ancho->SetDbValueDef($rsnew, $cupon->cup_preview_nombre->Upload->ImageWidth, NULL, FALSE);
		$cupon->cup_preview_alto->SetDbValueDef($rsnew, $cupon->cup_preview_nombre->Upload->ImageHeight, NULL, FALSE);
		}

		// cup_imagen_nombre
		$cupon->cup_imagen_nombre->Upload->SaveToSession(); // Save file value to Session
		if ($cupon->cup_imagen_nombre->Upload->Action == "1") { // Keep
			if ($rsold) {
				$rsnew['cup_imagen_nombre'] = $rsold->fields['cup_imagen_nombre'];
				$rsnew['cup_imagen_tipo'] = $rsold->fields['cup_imagen_tipo'];
				$rsnew['cup_imagen_size'] = $rsold->fields['cup_imagen_size'];
				$rsnew['cup_imagen_ancho'] = $rsold->fields['cup_imagen_ancho'];
				$rsnew['cup_imagen_alto'] = $rsold->fields['cup_imagen_alto'];
			}
		} elseif ($cupon->cup_imagen_nombre->Upload->Action == "2" || $cupon->cup_imagen_nombre->Upload->Action == "3") { // Update/Remove
		if (is_null($cupon->cup_imagen_nombre->Upload->Value)) {
			$rsnew['cup_imagen_nombre'] = NULL;
		} else {
			$rsnew['cup_imagen_nombre'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $cupon->cup_imagen_nombre->UploadPath), $cupon->cup_imagen_nombre->Upload->FileName);
		}
		$cupon->cup_imagen_tipo->SetDbValueDef($rsnew, trim($cupon->cup_imagen_nombre->Upload->ContentType), NULL, FALSE);
		$cupon->cup_imagen_size->SetDbValueDef($rsnew, $cupon->cup_imagen_nombre->Upload->FileSize, NULL, FALSE);
		$cupon->cup_imagen_ancho->SetDbValueDef($rsnew, $cupon->cup_imagen_nombre->Upload->ImageWidth, NULL, FALSE);
		$cupon->cup_imagen_alto->SetDbValueDef($rsnew, $cupon->cup_imagen_nombre->Upload->ImageHeight, NULL, FALSE);
		}

		// cup_vigente
		$cupon->cup_vigente->SetDbValueDef($rsnew, $cupon->cup_vigente->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $cupon->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			if (!ew_Empty($cupon->cup_preview_nombre->Upload->Value)) {
				$cupon->cup_preview_nombre->Upload->SaveToFile($cupon->cup_preview_nombre->UploadPath, $rsnew['cup_preview_nombre'], FALSE);
			}
			if (!ew_Empty($cupon->cup_imagen_nombre->Upload->Value)) {
				$cupon->cup_imagen_nombre->Upload->SaveToFile($cupon->cup_imagen_nombre->UploadPath, $rsnew['cup_imagen_nombre'], FALSE);
			}
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($cupon->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($cupon->CancelMessage <> "") {
				$this->setFailureMessage($cupon->CancelMessage);
				$cupon->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$cupon->cup_id->setDbValue($conn->Insert_ID());
			$rsnew['cup_id'] = $cupon->cup_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$cupon->Row_Inserted($rs, $rsnew);
		}

		// cup_preview_nombre
		$cupon->cup_preview_nombre->Upload->RemoveFromSession(); // Remove file value from Session

		// cup_imagen_nombre
		$cupon->cup_imagen_nombre->Upload->RemoveFromSession(); // Remove file value from Session
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
