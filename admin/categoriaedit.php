<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "categoriainfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$categoria_edit = new ccategoria_edit();
$Page =& $categoria_edit;

// Page init
$categoria_edit->Page_Init();

// Page main
$categoria_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var categoria_edit = new ew_Page("categoria_edit");

// page properties
categoria_edit.PageID = "edit"; // page ID
categoria_edit.FormID = "fcategoriaedit"; // form ID
var EW_PAGE_ID = categoria_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
categoria_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = 1;
	for (i=0; i<rowcnt; i++) {
		infix = "";
		elm = fobj.elements["x" + infix + "_cat_nombre"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($categoria->cat_nombre->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_cat_imagen_nombre"];
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
categoria_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
categoria_edit.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
categoria_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
categoria_edit.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $categoria_edit->ShowPageHeader(); ?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $categoria->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $categoria->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$categoria_edit->ShowMessage();
?>
<form name="fcategoriaedit" id="fcategoriaedit" action="<?php echo ew_CurrentPage() ?>" method="post" enctype="multipart/form-data" onsubmit="return categoria_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="categoria">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($categoria->cat_id->Visible) { // cat_id ?>
	<tr id="r_cat_id"<?php echo $categoria->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $categoria->cat_id->FldCaption() ?></td>
		<td<?php echo $categoria->cat_id->CellAttributes() ?>><span id="el_cat_id">
<div<?php echo $categoria->cat_id->ViewAttributes() ?>><?php echo $categoria->cat_id->EditValue ?></div>
<input type="hidden" name="x_cat_id" id="x_cat_id" value="<?php echo ew_HtmlEncode($categoria->cat_id->CurrentValue) ?>">
</span><?php echo $categoria->cat_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($categoria->cat_nombre->Visible) { // cat_nombre ?>
	<tr id="r_cat_nombre"<?php echo $categoria->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $categoria->cat_nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $categoria->cat_nombre->CellAttributes() ?>><span id="el_cat_nombre">
<input type="text" name="x_cat_nombre" id="x_cat_nombre" size="60" maxlength="32" value="<?php echo $categoria->cat_nombre->EditValue ?>"<?php echo $categoria->cat_nombre->EditAttributes() ?>>
</span><?php echo $categoria->cat_nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($categoria->cat_imagen_nombre->Visible) { // cat_imagen_nombre ?>
	<tr id="r_cat_imagen_nombre"<?php echo $categoria->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $categoria->cat_imagen_nombre->FldCaption() ?></td>
		<td<?php echo $categoria->cat_imagen_nombre->CellAttributes() ?>><span id="el_cat_imagen_nombre">
<div id="old_x_cat_imagen_nombre">
<?php if ($categoria->cat_imagen_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($categoria->cat_imagen_nombre->Upload->DbValue)) { ?>
<a<?php echo $categoria->cat_imagen_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $categoria->cat_imagen_nombre->UploadPath) . $categoria->cat_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $categoria->cat_imagen_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($categoria->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($categoria->cat_imagen_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $categoria->cat_imagen_nombre->UploadPath) . $categoria->cat_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $categoria->cat_imagen_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($categoria->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x_cat_imagen_nombre">
<?php if (!empty($categoria->cat_imagen_nombre->Upload->DbValue)) { ?>
<label><input type="radio" name="a_cat_imagen_nombre" id="a_cat_imagen_nombre" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_cat_imagen_nombre" id="a_cat_imagen_nombre" value="2"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_cat_imagen_nombre" id="a_cat_imagen_nombre" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $categoria->cat_imagen_nombre->EditAttrs["onchange"] = "this.form.a_cat_imagen_nombre[2].checked=true;" . @$categoria->cat_imagen_nombre->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_cat_imagen_nombre" id="a_cat_imagen_nombre" value="3">
<?php } ?>
<input type="file" name="x_cat_imagen_nombre" id="x_cat_imagen_nombre" size="60"<?php echo $categoria->cat_imagen_nombre->EditAttributes() ?>>
</div>
</span><?php echo $categoria->cat_imagen_nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($categoria->cat_mostrar->Visible) { // cat_mostrar ?>
	<tr id="r_cat_mostrar"<?php echo $categoria->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $categoria->cat_mostrar->FldCaption() ?></td>
		<td<?php echo $categoria->cat_mostrar->CellAttributes() ?>><span id="el_cat_mostrar">
<div id="tp_x_cat_mostrar" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><label><input type="radio" name="x_cat_mostrar" id="x_cat_mostrar" value="{value}"<?php echo $categoria->cat_mostrar->EditAttributes() ?>></label></div>
<div id="dsl_x_cat_mostrar" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $categoria->cat_mostrar->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($categoria->cat_mostrar->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_cat_mostrar" id="x_cat_mostrar" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $categoria->cat_mostrar->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $categoria->cat_mostrar->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<?php
$categoria_edit->ShowPageFooter();
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
$categoria_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class ccategoria_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'categoria';

	// Page object name
	var $PageObjName = 'categoria_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $categoria;
		if ($categoria->UseTokenInUrl) $PageUrl .= "t=" . $categoria->TableVar . "&"; // Add page token
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
		global $objForm, $categoria;
		if ($categoria->UseTokenInUrl) {
			if ($objForm)
				return ($categoria->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($categoria->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccategoria_edit() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (categoria)
		if (!isset($GLOBALS["categoria"])) {
			$GLOBALS["categoria"] = new ccategoria();
			$GLOBALS["Table"] =& $GLOBALS["categoria"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'categoria', TRUE);

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
		global $categoria;

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
		global $objForm, $Language, $gsFormError, $categoria;

		// Load key from QueryString
		if (@$_GET["cat_id"] <> "")
			$categoria->cat_id->setQueryStringValue($_GET["cat_id"]);
		if (@$_POST["a_edit"] <> "") {
			$categoria->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->GetUploadFiles(); // Get upload files
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$categoria->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$categoria->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$categoria->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($categoria->cat_id->CurrentValue == "")
			$this->Page_Terminate("categorialist.php"); // Invalid key, return to list
		switch ($categoria->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("categorialist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$categoria->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $categoria->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$categoria->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$categoria->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$categoria->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $categoria;

		// Get upload data
			if ($categoria->cat_imagen_nombre->Upload->UploadFile()) {

				// No action required
			} else {
				echo $categoria->cat_imagen_nombre->Upload->Message;
				$this->Page_Terminate();
				exit();
			}
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $categoria;
		if (!$categoria->cat_id->FldIsDetailKey) {
			$categoria->cat_id->setFormValue($objForm->GetValue("x_cat_id"));
		}
		if (!$categoria->cat_nombre->FldIsDetailKey) {
			$categoria->cat_nombre->setFormValue($objForm->GetValue("x_cat_nombre"));
		}
		if (!$categoria->cat_mostrar->FldIsDetailKey) {
			$categoria->cat_mostrar->setFormValue($objForm->GetValue("x_cat_mostrar"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $categoria;
		$this->LoadRow();
		$categoria->cat_id->CurrentValue = $categoria->cat_id->FormValue;
		$categoria->cat_nombre->CurrentValue = $categoria->cat_nombre->FormValue;
		$categoria->cat_mostrar->CurrentValue = $categoria->cat_mostrar->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $categoria;
		$sFilter = $categoria->KeyFilter();

		// Call Row Selecting event
		$categoria->Row_Selecting($sFilter);

		// Load SQL based on filter
		$categoria->CurrentFilter = $sFilter;
		$sSql = $categoria->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$categoria->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $categoria;
		if (!$rs || $rs->EOF) return;
		$categoria->cat_id->setDbValue($rs->fields('cat_id'));
		$categoria->cat_nombre->setDbValue($rs->fields('cat_nombre'));
		$categoria->cat_imagen_nombre->Upload->DbValue = $rs->fields('cat_imagen_nombre');
		$categoria->cat_imagen_tipo->setDbValue($rs->fields('cat_imagen_tipo'));
		$categoria->cat_imagen_ancho->setDbValue($rs->fields('cat_imagen_ancho'));
		$categoria->cat_imagen_alto->setDbValue($rs->fields('cat_imagen_alto'));
		$categoria->cat_imagen_size->setDbValue($rs->fields('cat_imagen_size'));
		$categoria->cat_mostrar->setDbValue($rs->fields('cat_mostrar'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $categoria;

		// Initialize URLs
		// Call Row_Rendering event

		$categoria->Row_Rendering();

		// Common render codes for all row types
		// cat_id
		// cat_nombre
		// cat_imagen_nombre
		// cat_imagen_tipo
		// cat_imagen_ancho
		// cat_imagen_alto
		// cat_imagen_size
		// cat_mostrar

		if ($categoria->RowType == EW_ROWTYPE_VIEW) { // View row

			// cat_id
			$categoria->cat_id->ViewValue = $categoria->cat_id->CurrentValue;
			$categoria->cat_id->ViewCustomAttributes = "";

			// cat_nombre
			$categoria->cat_nombre->ViewValue = $categoria->cat_nombre->CurrentValue;
			$categoria->cat_nombre->ViewCustomAttributes = "";

			// cat_imagen_nombre
			if (!ew_Empty($categoria->cat_imagen_nombre->Upload->DbValue)) {
				$categoria->cat_imagen_nombre->ViewValue = $categoria->cat_imagen_nombre->Upload->DbValue;
				$categoria->cat_imagen_nombre->ImageWidth = 100;
				$categoria->cat_imagen_nombre->ImageHeight = 0;
				$categoria->cat_imagen_nombre->ImageAlt = $categoria->cat_imagen_nombre->FldAlt();
			} else {
				$categoria->cat_imagen_nombre->ViewValue = "";
			}
			$categoria->cat_imagen_nombre->ViewCustomAttributes = "";

			// cat_imagen_tipo
			$categoria->cat_imagen_tipo->ViewValue = $categoria->cat_imagen_tipo->CurrentValue;
			$categoria->cat_imagen_tipo->ViewCustomAttributes = "";

			// cat_imagen_ancho
			$categoria->cat_imagen_ancho->ViewValue = $categoria->cat_imagen_ancho->CurrentValue;
			$categoria->cat_imagen_ancho->ViewCustomAttributes = "";

			// cat_imagen_alto
			$categoria->cat_imagen_alto->ViewValue = $categoria->cat_imagen_alto->CurrentValue;
			$categoria->cat_imagen_alto->ViewCustomAttributes = "";

			// cat_imagen_size
			$categoria->cat_imagen_size->ViewValue = $categoria->cat_imagen_size->CurrentValue;
			$categoria->cat_imagen_size->ViewCustomAttributes = "";

			// cat_mostrar
			if (strval($categoria->cat_mostrar->CurrentValue) <> "") {
				switch ($categoria->cat_mostrar->CurrentValue) {
					case "1":
						$categoria->cat_mostrar->ViewValue = $categoria->cat_mostrar->FldTagCaption(1) <> "" ? $categoria->cat_mostrar->FldTagCaption(1) : $categoria->cat_mostrar->CurrentValue;
						break;
					case "0":
						$categoria->cat_mostrar->ViewValue = $categoria->cat_mostrar->FldTagCaption(2) <> "" ? $categoria->cat_mostrar->FldTagCaption(2) : $categoria->cat_mostrar->CurrentValue;
						break;
					default:
						$categoria->cat_mostrar->ViewValue = $categoria->cat_mostrar->CurrentValue;
				}
			} else {
				$categoria->cat_mostrar->ViewValue = NULL;
			}
			$categoria->cat_mostrar->ViewCustomAttributes = "";

			// cat_id
			$categoria->cat_id->LinkCustomAttributes = "";
			$categoria->cat_id->HrefValue = "";
			$categoria->cat_id->TooltipValue = "";

			// cat_nombre
			$categoria->cat_nombre->LinkCustomAttributes = "";
			$categoria->cat_nombre->HrefValue = "";
			$categoria->cat_nombre->TooltipValue = "";

			// cat_imagen_nombre
			$categoria->cat_imagen_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($categoria->cat_imagen_nombre->Upload->DbValue)) {
				$categoria->cat_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $categoria->cat_imagen_nombre->UploadPath) . ((!empty($categoria->cat_imagen_nombre->ViewValue)) ? $categoria->cat_imagen_nombre->ViewValue : $categoria->cat_imagen_nombre->CurrentValue); // Add prefix/suffix
				$categoria->cat_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($categoria->Export <> "") $categoria->cat_imagen_nombre->HrefValue = ew_ConvertFullUrl($categoria->cat_imagen_nombre->HrefValue);
			} else {
				$categoria->cat_imagen_nombre->HrefValue = "";
			}
			$categoria->cat_imagen_nombre->TooltipValue = "";

			// cat_mostrar
			$categoria->cat_mostrar->LinkCustomAttributes = "";
			$categoria->cat_mostrar->HrefValue = "";
			$categoria->cat_mostrar->TooltipValue = "";
		} elseif ($categoria->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// cat_id
			$categoria->cat_id->EditCustomAttributes = "";
			$categoria->cat_id->EditValue = $categoria->cat_id->CurrentValue;
			$categoria->cat_id->ViewCustomAttributes = "";

			// cat_nombre
			$categoria->cat_nombre->EditCustomAttributes = "";
			$categoria->cat_nombre->EditValue = ew_HtmlEncode($categoria->cat_nombre->CurrentValue);

			// cat_imagen_nombre
			$categoria->cat_imagen_nombre->EditCustomAttributes = "";
			if (!ew_Empty($categoria->cat_imagen_nombre->Upload->DbValue)) {
				$categoria->cat_imagen_nombre->EditValue = $categoria->cat_imagen_nombre->Upload->DbValue;
				$categoria->cat_imagen_nombre->ImageWidth = 100;
				$categoria->cat_imagen_nombre->ImageHeight = 0;
				$categoria->cat_imagen_nombre->ImageAlt = $categoria->cat_imagen_nombre->FldAlt();
			} else {
				$categoria->cat_imagen_nombre->EditValue = "";
			}

			// cat_mostrar
			$categoria->cat_mostrar->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("1", $categoria->cat_mostrar->FldTagCaption(1) <> "" ? $categoria->cat_mostrar->FldTagCaption(1) : "1");
			$arwrk[] = array("0", $categoria->cat_mostrar->FldTagCaption(2) <> "" ? $categoria->cat_mostrar->FldTagCaption(2) : "0");
			$categoria->cat_mostrar->EditValue = $arwrk;

			// Edit refer script
			// cat_id

			$categoria->cat_id->HrefValue = "";

			// cat_nombre
			$categoria->cat_nombre->HrefValue = "";

			// cat_imagen_nombre
			if (!ew_Empty($categoria->cat_imagen_nombre->Upload->DbValue)) {
				$categoria->cat_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $categoria->cat_imagen_nombre->UploadPath) . ((!empty($categoria->cat_imagen_nombre->EditValue)) ? $categoria->cat_imagen_nombre->EditValue : $categoria->cat_imagen_nombre->CurrentValue); // Add prefix/suffix
				$categoria->cat_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($categoria->Export <> "") $categoria->cat_imagen_nombre->HrefValue = ew_ConvertFullUrl($categoria->cat_imagen_nombre->HrefValue);
			} else {
				$categoria->cat_imagen_nombre->HrefValue = "";
			}

			// cat_mostrar
			$categoria->cat_mostrar->HrefValue = "";
		}
		if ($categoria->RowType == EW_ROWTYPE_ADD ||
			$categoria->RowType == EW_ROWTYPE_EDIT ||
			$categoria->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$categoria->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($categoria->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$categoria->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $categoria;

		// Initialize form error message
		$gsFormError = "";
		if (!ew_CheckFileType($categoria->cat_imagen_nombre->Upload->FileName)) {
			ew_AddMessage($gsFormError, $Language->Phrase("WrongFileType"));
		}
		if ($categoria->cat_imagen_nombre->Upload->FileSize > 0 && EW_MAX_FILE_SIZE > 0 && $categoria->cat_imagen_nombre->Upload->FileSize > EW_MAX_FILE_SIZE) {
			ew_AddMessage($gsFormError, str_replace("%s", EW_MAX_FILE_SIZE, $Language->Phrase("MaxFileSize")));
		}
		if (in_array($categoria->cat_imagen_nombre->Upload->Error, array(1, 2, 3, 6, 7, 8))) {
			ew_AddMessage($gsFormError, $Language->Phrase("PhpUploadErr" . $categoria->cat_imagen_nombre->Upload->Error));
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($categoria->cat_nombre->FormValue) && $categoria->cat_nombre->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $categoria->cat_nombre->FldCaption());
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
		global $conn, $Security, $Language, $categoria;
		$sFilter = $categoria->KeyFilter();
			if ($categoria->cat_nombre->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`cat_nombre` = '" . ew_AdjustSql($categoria->cat_nombre->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$categoria->CurrentFilter = $sFilterChk;
			$sSqlChk = $categoria->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", 'cat_nombre', $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $categoria->cat_nombre->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
		$categoria->CurrentFilter = $sFilter;
		$sSql = $categoria->SQL();
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

			// cat_nombre
			$categoria->cat_nombre->SetDbValueDef($rsnew, $categoria->cat_nombre->CurrentValue, "", FALSE);

			// cat_imagen_nombre
			$categoria->cat_imagen_nombre->Upload->SaveToSession(); // Save file value to Session
			if ($categoria->cat_imagen_nombre->Upload->Action == "1") { // Keep
			} elseif ($categoria->cat_imagen_nombre->Upload->Action == "2" || $categoria->cat_imagen_nombre->Upload->Action == "3") { // Update/Remove
			$categoria->cat_imagen_nombre->Upload->DbValue = $rs->fields('cat_imagen_nombre'); // Get original value
			if (is_null($categoria->cat_imagen_nombre->Upload->Value)) {
				$rsnew['cat_imagen_nombre'] = NULL;
			} else {
				$rsnew['cat_imagen_nombre'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $categoria->cat_imagen_nombre->UploadPath), $categoria->cat_imagen_nombre->Upload->FileName);
			}
			$categoria->cat_imagen_tipo->SetDbValueDef($rsnew, trim($categoria->cat_imagen_nombre->Upload->ContentType), NULL, FALSE);
			$categoria->cat_imagen_size->SetDbValueDef($rsnew, $categoria->cat_imagen_nombre->Upload->FileSize, NULL, FALSE);
			$categoria->cat_imagen_ancho->SetDbValueDef($rsnew, $categoria->cat_imagen_nombre->Upload->ImageWidth, NULL, FALSE);
			$categoria->cat_imagen_alto->SetDbValueDef($rsnew, $categoria->cat_imagen_nombre->Upload->ImageHeight, NULL, FALSE);
			}

			// cat_mostrar
			$categoria->cat_mostrar->SetDbValueDef($rsnew, $categoria->cat_mostrar->CurrentValue, NULL, FALSE);

			// Call Row Updating event
			$bUpdateRow = $categoria->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
			if (!ew_Empty($categoria->cat_imagen_nombre->Upload->Value)) {
				$categoria->cat_imagen_nombre->Upload->SaveToFile($categoria->cat_imagen_nombre->UploadPath, $rsnew['cat_imagen_nombre'], FALSE);
			}
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $conn->Execute($categoria->UpdateSQL($rsnew));
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($categoria->CancelMessage <> "") {
					$this->setFailureMessage($categoria->CancelMessage);
					$categoria->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$categoria->Row_Updated($rsold, $rsnew);
		$rs->Close();

		// cat_imagen_nombre
		$categoria->cat_imagen_nombre->Upload->RemoveFromSession(); // Remove file value from Session
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
