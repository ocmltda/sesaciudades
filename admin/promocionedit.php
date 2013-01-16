<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "promocioninfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$promocion_edit = new cpromocion_edit();
$Page =& $promocion_edit;

// Page init
$promocion_edit->Page_Init();

// Page main
$promocion_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var promocion_edit = new ew_Page("promocion_edit");

// page properties
promocion_edit.PageID = "edit"; // page ID
promocion_edit.FormID = "fpromocionedit"; // form ID
var EW_PAGE_ID = promocion_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
promocion_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = 1;
	for (i=0; i<rowcnt; i++) {
		infix = "";
		elm = fobj.elements["x" + infix + "_pro_titulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($promocion->pro_titulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_pro_texto"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($promocion->pro_texto->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_pro_imagen_nombre"];
		aelm = fobj.elements["a" + infix + "_pro_imagen_nombre"];
		var chk_pro_imagen_nombre = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_pro_imagen_nombre && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($promocion->pro_imagen_nombre->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_pro_imagen_nombre"];
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
promocion_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
promocion_edit.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
promocion_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
promocion_edit.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $promocion_edit->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $promocion->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $promocion->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$promocion_edit->ShowMessage();
?>
<form name="fpromocionedit" id="fpromocionedit" action="<?php echo ew_CurrentPage() ?>" method="post" enctype="multipart/form-data" onsubmit="return promocion_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="promocion">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($promocion->pro_id->Visible) { // pro_id ?>
	<tr id="r_pro_id"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_id->FldCaption() ?></td>
		<td<?php echo $promocion->pro_id->CellAttributes() ?>><span id="el_pro_id">
<div<?php echo $promocion->pro_id->ViewAttributes() ?>><?php echo $promocion->pro_id->EditValue ?></div>
<input type="hidden" name="x_pro_id" id="x_pro_id" value="<?php echo ew_HtmlEncode($promocion->pro_id->CurrentValue) ?>">
</span><?php echo $promocion->pro_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($promocion->pro_titulo->Visible) { // pro_titulo ?>
	<tr id="r_pro_titulo"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_titulo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $promocion->pro_titulo->CellAttributes() ?>><span id="el_pro_titulo">
<input type="text" name="x_pro_titulo" id="x_pro_titulo" size="60" maxlength="128" value="<?php echo $promocion->pro_titulo->EditValue ?>"<?php echo $promocion->pro_titulo->EditAttributes() ?>>
</span><?php echo $promocion->pro_titulo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($promocion->pro_texto->Visible) { // pro_texto ?>
	<tr id="r_pro_texto"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_texto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $promocion->pro_texto->CellAttributes() ?>><span id="el_pro_texto">
<textarea name="x_pro_texto" id="x_pro_texto" cols="59" rows="8"<?php echo $promocion->pro_texto->EditAttributes() ?>><?php echo $promocion->pro_texto->EditValue ?></textarea>
</span><?php echo $promocion->pro_texto->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($promocion->pro_imagen_nombre->Visible) { // pro_imagen_nombre ?>
	<tr id="r_pro_imagen_nombre"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_imagen_nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $promocion->pro_imagen_nombre->CellAttributes() ?>><span id="el_pro_imagen_nombre">
<div id="old_x_pro_imagen_nombre">
<?php if ($promocion->pro_imagen_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($promocion->pro_imagen_nombre->Upload->DbValue)) { ?>
<a<?php echo $promocion->pro_imagen_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $promocion->pro_imagen_nombre->UploadPath) . $promocion->pro_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $promocion->pro_imagen_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($promocion->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($promocion->pro_imagen_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $promocion->pro_imagen_nombre->UploadPath) . $promocion->pro_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $promocion->pro_imagen_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($promocion->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x_pro_imagen_nombre">
<?php if (!empty($promocion->pro_imagen_nombre->Upload->DbValue)) { ?>
<label><input type="radio" name="a_pro_imagen_nombre" id="a_pro_imagen_nombre" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_pro_imagen_nombre" id="a_pro_imagen_nombre" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_pro_imagen_nombre" id="a_pro_imagen_nombre" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $promocion->pro_imagen_nombre->EditAttrs["onchange"] = "this.form.a_pro_imagen_nombre[2].checked=true;" . @$promocion->pro_imagen_nombre->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_pro_imagen_nombre" id="a_pro_imagen_nombre" value="3">
<?php } ?>
<input type="file" name="x_pro_imagen_nombre" id="x_pro_imagen_nombre" size="60"<?php echo $promocion->pro_imagen_nombre->EditAttributes() ?>>
</div>
</span><?php echo $promocion->pro_imagen_nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($promocion->pro_vigente->Visible) { // pro_vigente ?>
	<tr id="r_pro_vigente"<?php echo $promocion->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $promocion->pro_vigente->FldCaption() ?></td>
		<td<?php echo $promocion->pro_vigente->CellAttributes() ?>><span id="el_pro_vigente">
<div id="tp_x_pro_vigente" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><label><input type="radio" name="x_pro_vigente" id="x_pro_vigente" value="{value}"<?php echo $promocion->pro_vigente->EditAttributes() ?>></label></div>
<div id="dsl_x_pro_vigente" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $promocion->pro_vigente->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($promocion->pro_vigente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_pro_vigente" id="x_pro_vigente" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $promocion->pro_vigente->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $promocion->pro_vigente->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<?php
$promocion_edit->ShowPageFooter();
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
$promocion_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cpromocion_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'promocion';

	// Page object name
	var $PageObjName = 'promocion_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $promocion;
		if ($promocion->UseTokenInUrl) $PageUrl .= "t=" . $promocion->TableVar . "&"; // Add page token
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
		global $objForm, $promocion;
		if ($promocion->UseTokenInUrl) {
			if ($objForm)
				return ($promocion->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($promocion->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cpromocion_edit() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (promocion)
		if (!isset($GLOBALS["promocion"])) {
			$GLOBALS["promocion"] = new cpromocion();
			$GLOBALS["Table"] =& $GLOBALS["promocion"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'promocion', TRUE);

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
		global $promocion;

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
		global $objForm, $Language, $gsFormError, $promocion;

		// Load key from QueryString
		if (@$_GET["pro_id"] <> "")
			$promocion->pro_id->setQueryStringValue($_GET["pro_id"]);
		if (@$_POST["a_edit"] <> "") {
			$promocion->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->GetUploadFiles(); // Get upload files
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$promocion->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$promocion->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$promocion->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($promocion->pro_id->CurrentValue == "")
			$this->Page_Terminate("promocionlist.php"); // Invalid key, return to list
		switch ($promocion->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("promocionlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$promocion->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $promocion->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$promocion->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$promocion->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$promocion->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $promocion;

		// Get upload data
			if ($promocion->pro_imagen_nombre->Upload->UploadFile()) {

				// No action required
			} else {
				echo $promocion->pro_imagen_nombre->Upload->Message;
				$this->Page_Terminate();
				exit();
			}
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $promocion;
		if (!$promocion->pro_id->FldIsDetailKey) {
			$promocion->pro_id->setFormValue($objForm->GetValue("x_pro_id"));
		}
		if (!$promocion->pro_titulo->FldIsDetailKey) {
			$promocion->pro_titulo->setFormValue($objForm->GetValue("x_pro_titulo"));
		}
		if (!$promocion->pro_texto->FldIsDetailKey) {
			$promocion->pro_texto->setFormValue($objForm->GetValue("x_pro_texto"));
		}
		if (!$promocion->pro_vigente->FldIsDetailKey) {
			$promocion->pro_vigente->setFormValue($objForm->GetValue("x_pro_vigente"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $promocion;
		$this->LoadRow();
		$promocion->pro_id->CurrentValue = $promocion->pro_id->FormValue;
		$promocion->pro_titulo->CurrentValue = $promocion->pro_titulo->FormValue;
		$promocion->pro_texto->CurrentValue = $promocion->pro_texto->FormValue;
		$promocion->pro_vigente->CurrentValue = $promocion->pro_vigente->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $promocion;
		$sFilter = $promocion->KeyFilter();

		// Call Row Selecting event
		$promocion->Row_Selecting($sFilter);

		// Load SQL based on filter
		$promocion->CurrentFilter = $sFilter;
		$sSql = $promocion->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$promocion->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $promocion;
		if (!$rs || $rs->EOF) return;
		$promocion->pro_id->setDbValue($rs->fields('pro_id'));
		$promocion->pro_titulo->setDbValue($rs->fields('pro_titulo'));
		$promocion->pro_texto->setDbValue($rs->fields('pro_texto'));
		$promocion->pro_imagen_nombre->Upload->DbValue = $rs->fields('pro_imagen_nombre');
		$promocion->pro_imagen_tipo->setDbValue($rs->fields('pro_imagen_tipo'));
		$promocion->pro_imagen_ancho->setDbValue($rs->fields('pro_imagen_ancho'));
		$promocion->pro_imagen_alto->setDbValue($rs->fields('pro_imagen_alto'));
		$promocion->pro_imagen_size->setDbValue($rs->fields('pro_imagen_size'));
		$promocion->pro_vigente->setDbValue($rs->fields('pro_vigente'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $promocion;

		// Initialize URLs
		// Call Row_Rendering event

		$promocion->Row_Rendering();

		// Common render codes for all row types
		// pro_id
		// pro_titulo
		// pro_texto
		// pro_imagen_nombre
		// pro_imagen_tipo
		// pro_imagen_ancho
		// pro_imagen_alto
		// pro_imagen_size
		// pro_vigente

		if ($promocion->RowType == EW_ROWTYPE_VIEW) { // View row

			// pro_id
			$promocion->pro_id->ViewValue = $promocion->pro_id->CurrentValue;
			$promocion->pro_id->ViewCustomAttributes = "";

			// pro_titulo
			$promocion->pro_titulo->ViewValue = $promocion->pro_titulo->CurrentValue;
			$promocion->pro_titulo->ViewCustomAttributes = "";

			// pro_texto
			$promocion->pro_texto->ViewValue = $promocion->pro_texto->CurrentValue;
			$promocion->pro_texto->ViewCustomAttributes = "";

			// pro_imagen_nombre
			if (!ew_Empty($promocion->pro_imagen_nombre->Upload->DbValue)) {
				$promocion->pro_imagen_nombre->ViewValue = $promocion->pro_imagen_nombre->Upload->DbValue;
				$promocion->pro_imagen_nombre->ImageWidth = 100;
				$promocion->pro_imagen_nombre->ImageHeight = 0;
				$promocion->pro_imagen_nombre->ImageAlt = $promocion->pro_imagen_nombre->FldAlt();
			} else {
				$promocion->pro_imagen_nombre->ViewValue = "";
			}
			$promocion->pro_imagen_nombre->ViewCustomAttributes = "";

			// pro_imagen_ancho
			$promocion->pro_imagen_ancho->ViewValue = $promocion->pro_imagen_ancho->CurrentValue;
			$promocion->pro_imagen_ancho->ViewValue = ew_FormatNumber($promocion->pro_imagen_ancho->ViewValue, 0, -2, -2, -2);
			$promocion->pro_imagen_ancho->ViewCustomAttributes = "";

			// pro_imagen_alto
			$promocion->pro_imagen_alto->ViewValue = $promocion->pro_imagen_alto->CurrentValue;
			$promocion->pro_imagen_alto->ViewValue = ew_FormatNumber($promocion->pro_imagen_alto->ViewValue, 0, -2, -2, -2);
			$promocion->pro_imagen_alto->ViewCustomAttributes = "";

			// pro_vigente
			if (strval($promocion->pro_vigente->CurrentValue) <> "") {
				switch ($promocion->pro_vigente->CurrentValue) {
					case "1":
						$promocion->pro_vigente->ViewValue = $promocion->pro_vigente->FldTagCaption(1) <> "" ? $promocion->pro_vigente->FldTagCaption(1) : $promocion->pro_vigente->CurrentValue;
						break;
					case "0":
						$promocion->pro_vigente->ViewValue = $promocion->pro_vigente->FldTagCaption(2) <> "" ? $promocion->pro_vigente->FldTagCaption(2) : $promocion->pro_vigente->CurrentValue;
						break;
					default:
						$promocion->pro_vigente->ViewValue = $promocion->pro_vigente->CurrentValue;
				}
			} else {
				$promocion->pro_vigente->ViewValue = NULL;
			}
			$promocion->pro_vigente->ViewCustomAttributes = "";

			// pro_id
			$promocion->pro_id->LinkCustomAttributes = "";
			$promocion->pro_id->HrefValue = "";
			$promocion->pro_id->TooltipValue = "";

			// pro_titulo
			$promocion->pro_titulo->LinkCustomAttributes = "";
			$promocion->pro_titulo->HrefValue = "";
			$promocion->pro_titulo->TooltipValue = "";

			// pro_texto
			$promocion->pro_texto->LinkCustomAttributes = "";
			$promocion->pro_texto->HrefValue = "";
			$promocion->pro_texto->TooltipValue = "";

			// pro_imagen_nombre
			$promocion->pro_imagen_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($promocion->pro_imagen_nombre->Upload->DbValue)) {
				$promocion->pro_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $promocion->pro_imagen_nombre->UploadPath) . ((!empty($promocion->pro_imagen_nombre->ViewValue)) ? $promocion->pro_imagen_nombre->ViewValue : $promocion->pro_imagen_nombre->CurrentValue); // Add prefix/suffix
				$promocion->pro_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($promocion->Export <> "") $promocion->pro_imagen_nombre->HrefValue = ew_ConvertFullUrl($promocion->pro_imagen_nombre->HrefValue);
			} else {
				$promocion->pro_imagen_nombre->HrefValue = "";
			}
			$promocion->pro_imagen_nombre->TooltipValue = "";

			// pro_vigente
			$promocion->pro_vigente->LinkCustomAttributes = "";
			$promocion->pro_vigente->HrefValue = "";
			$promocion->pro_vigente->TooltipValue = "";
		} elseif ($promocion->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// pro_id
			$promocion->pro_id->EditCustomAttributes = "";
			$promocion->pro_id->EditValue = $promocion->pro_id->CurrentValue;
			$promocion->pro_id->ViewCustomAttributes = "";

			// pro_titulo
			$promocion->pro_titulo->EditCustomAttributes = "";
			$promocion->pro_titulo->EditValue = ew_HtmlEncode($promocion->pro_titulo->CurrentValue);

			// pro_texto
			$promocion->pro_texto->EditCustomAttributes = "";
			$promocion->pro_texto->EditValue = ew_HtmlEncode($promocion->pro_texto->CurrentValue);

			// pro_imagen_nombre
			$promocion->pro_imagen_nombre->EditCustomAttributes = "";
			if (!ew_Empty($promocion->pro_imagen_nombre->Upload->DbValue)) {
				$promocion->pro_imagen_nombre->EditValue = $promocion->pro_imagen_nombre->Upload->DbValue;
				$promocion->pro_imagen_nombre->ImageWidth = 100;
				$promocion->pro_imagen_nombre->ImageHeight = 0;
				$promocion->pro_imagen_nombre->ImageAlt = $promocion->pro_imagen_nombre->FldAlt();
			} else {
				$promocion->pro_imagen_nombre->EditValue = "";
			}

			// pro_vigente
			$promocion->pro_vigente->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("1", $promocion->pro_vigente->FldTagCaption(1) <> "" ? $promocion->pro_vigente->FldTagCaption(1) : "1");
			$arwrk[] = array("0", $promocion->pro_vigente->FldTagCaption(2) <> "" ? $promocion->pro_vigente->FldTagCaption(2) : "0");
			$promocion->pro_vigente->EditValue = $arwrk;

			// Edit refer script
			// pro_id

			$promocion->pro_id->HrefValue = "";

			// pro_titulo
			$promocion->pro_titulo->HrefValue = "";

			// pro_texto
			$promocion->pro_texto->HrefValue = "";

			// pro_imagen_nombre
			if (!ew_Empty($promocion->pro_imagen_nombre->Upload->DbValue)) {
				$promocion->pro_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $promocion->pro_imagen_nombre->UploadPath) . ((!empty($promocion->pro_imagen_nombre->EditValue)) ? $promocion->pro_imagen_nombre->EditValue : $promocion->pro_imagen_nombre->CurrentValue); // Add prefix/suffix
				$promocion->pro_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($promocion->Export <> "") $promocion->pro_imagen_nombre->HrefValue = ew_ConvertFullUrl($promocion->pro_imagen_nombre->HrefValue);
			} else {
				$promocion->pro_imagen_nombre->HrefValue = "";
			}

			// pro_vigente
			$promocion->pro_vigente->HrefValue = "";
		}
		if ($promocion->RowType == EW_ROWTYPE_ADD ||
			$promocion->RowType == EW_ROWTYPE_EDIT ||
			$promocion->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$promocion->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($promocion->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$promocion->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $promocion;

		// Initialize form error message
		$gsFormError = "";
		if (!ew_CheckFileType($promocion->pro_imagen_nombre->Upload->FileName)) {
			ew_AddMessage($gsFormError, $Language->Phrase("WrongFileType"));
		}
		if ($promocion->pro_imagen_nombre->Upload->FileSize > 0 && EW_MAX_FILE_SIZE > 0 && $promocion->pro_imagen_nombre->Upload->FileSize > EW_MAX_FILE_SIZE) {
			ew_AddMessage($gsFormError, str_replace("%s", EW_MAX_FILE_SIZE, $Language->Phrase("MaxFileSize")));
		}
		if (in_array($promocion->pro_imagen_nombre->Upload->Error, array(1, 2, 3, 6, 7, 8))) {
			ew_AddMessage($gsFormError, $Language->Phrase("PhpUploadErr" . $promocion->pro_imagen_nombre->Upload->Error));
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($promocion->pro_titulo->FormValue) && $promocion->pro_titulo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $promocion->pro_titulo->FldCaption());
		}
		if (!is_null($promocion->pro_texto->FormValue) && $promocion->pro_texto->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $promocion->pro_texto->FldCaption());
		}
		if ($promocion->pro_imagen_nombre->Upload->Action == "3" && is_null($promocion->pro_imagen_nombre->Upload->Value)) {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $promocion->pro_imagen_nombre->FldCaption());
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
		global $conn, $Security, $Language, $promocion;
		$sFilter = $promocion->KeyFilter();
		$promocion->CurrentFilter = $sFilter;
		$sSql = $promocion->SQL();
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

			// pro_titulo
			$promocion->pro_titulo->SetDbValueDef($rsnew, $promocion->pro_titulo->CurrentValue, "", FALSE);

			// pro_texto
			$promocion->pro_texto->SetDbValueDef($rsnew, $promocion->pro_texto->CurrentValue, "", FALSE);

			// pro_imagen_nombre
			$promocion->pro_imagen_nombre->Upload->SaveToSession(); // Save file value to Session
			if ($promocion->pro_imagen_nombre->Upload->Action == "1") { // Keep
			} elseif ($promocion->pro_imagen_nombre->Upload->Action == "2" || $promocion->pro_imagen_nombre->Upload->Action == "3") { // Update/Remove
			$promocion->pro_imagen_nombre->Upload->DbValue = $rs->fields('pro_imagen_nombre'); // Get original value
			if (is_null($promocion->pro_imagen_nombre->Upload->Value)) {
				$rsnew['pro_imagen_nombre'] = NULL;
			} else {
				$rsnew['pro_imagen_nombre'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $promocion->pro_imagen_nombre->UploadPath), $promocion->pro_imagen_nombre->Upload->FileName);
			}
			$promocion->pro_imagen_tipo->SetDbValueDef($rsnew, trim($promocion->pro_imagen_nombre->Upload->ContentType), NULL, FALSE);
			$promocion->pro_imagen_size->SetDbValueDef($rsnew, $promocion->pro_imagen_nombre->Upload->FileSize, NULL, FALSE);
			$promocion->pro_imagen_ancho->SetDbValueDef($rsnew, $promocion->pro_imagen_nombre->Upload->ImageWidth, NULL, FALSE);
			$promocion->pro_imagen_alto->SetDbValueDef($rsnew, $promocion->pro_imagen_nombre->Upload->ImageHeight, NULL, FALSE);
			}

			// pro_vigente
			$promocion->pro_vigente->SetDbValueDef($rsnew, $promocion->pro_vigente->CurrentValue, NULL, FALSE);

			// Call Row Updating event
			$bUpdateRow = $promocion->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
			if (!ew_Empty($promocion->pro_imagen_nombre->Upload->Value)) {
				$promocion->pro_imagen_nombre->Upload->SaveToFile($promocion->pro_imagen_nombre->UploadPath, $rsnew['pro_imagen_nombre'], FALSE);
			}
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $conn->Execute($promocion->UpdateSQL($rsnew));
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($promocion->CancelMessage <> "") {
					$this->setFailureMessage($promocion->CancelMessage);
					$promocion->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$promocion->Row_Updated($rsold, $rsnew);
		$rs->Close();

		// pro_imagen_nombre
		$promocion->pro_imagen_nombre->Upload->RemoveFromSession(); // Remove file value from Session
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
