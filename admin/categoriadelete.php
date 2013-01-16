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
$categoria_delete = new ccategoria_delete();
$Page =& $categoria_delete;

// Page init
$categoria_delete->Page_Init();

// Page main
$categoria_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var categoria_delete = new ew_Page("categoria_delete");

// page properties
categoria_delete.PageID = "delete"; // page ID
categoria_delete.FormID = "fcategoriadelete"; // form ID
var EW_PAGE_ID = categoria_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
categoria_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
categoria_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
categoria_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
categoria_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $categoria_delete->ShowPageHeader(); ?>
<?php

// Load records for display
if ($categoria_delete->Recordset = $categoria_delete->LoadRecordset())
	$categoria_deleteTotalRecs = $categoria_delete->Recordset->RecordCount(); // Get record count
if ($categoria_deleteTotalRecs <= 0) { // No record found, exit
	if ($categoria_delete->Recordset)
		$categoria_delete->Recordset->Close();
	$categoria_delete->Page_Terminate("categorialist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $categoria->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $categoria->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$categoria_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="categoria">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($categoria_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $categoria->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $categoria->cat_id->FldCaption() ?></td>
		<td valign="top"><?php echo $categoria->cat_nombre->FldCaption() ?></td>
		<td valign="top"><?php echo $categoria->cat_imagen_nombre->FldCaption() ?></td>
		<td valign="top"><?php echo $categoria->cat_imagen_tipo->FldCaption() ?></td>
		<td valign="top"><?php echo $categoria->cat_imagen_ancho->FldCaption() ?></td>
		<td valign="top"><?php echo $categoria->cat_imagen_alto->FldCaption() ?></td>
		<td valign="top"><?php echo $categoria->cat_imagen_size->FldCaption() ?></td>
		<td valign="top"><?php echo $categoria->cat_mostrar->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$categoria_delete->RecCnt = 0;
$i = 0;
while (!$categoria_delete->Recordset->EOF) {
	$categoria_delete->RecCnt++;

	// Set row properties
	$categoria->ResetAttrs();
	$categoria->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$categoria_delete->LoadRowValues($categoria_delete->Recordset);

	// Render row
	$categoria_delete->RenderRow();
?>
	<tr<?php echo $categoria->RowAttributes() ?>>
		<td<?php echo $categoria->cat_id->CellAttributes() ?>>
<div<?php echo $categoria->cat_id->ViewAttributes() ?>><?php echo $categoria->cat_id->ListViewValue() ?></div></td>
		<td<?php echo $categoria->cat_nombre->CellAttributes() ?>>
<div<?php echo $categoria->cat_nombre->ViewAttributes() ?>><?php echo $categoria->cat_nombre->ListViewValue() ?></div></td>
		<td<?php echo $categoria->cat_imagen_nombre->CellAttributes() ?>>
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
</td>
		<td<?php echo $categoria->cat_imagen_tipo->CellAttributes() ?>>
<div<?php echo $categoria->cat_imagen_tipo->ViewAttributes() ?>><?php echo $categoria->cat_imagen_tipo->ListViewValue() ?></div></td>
		<td<?php echo $categoria->cat_imagen_ancho->CellAttributes() ?>>
<div<?php echo $categoria->cat_imagen_ancho->ViewAttributes() ?>><?php echo $categoria->cat_imagen_ancho->ListViewValue() ?></div></td>
		<td<?php echo $categoria->cat_imagen_alto->CellAttributes() ?>>
<div<?php echo $categoria->cat_imagen_alto->ViewAttributes() ?>><?php echo $categoria->cat_imagen_alto->ListViewValue() ?></div></td>
		<td<?php echo $categoria->cat_imagen_size->CellAttributes() ?>>
<div<?php echo $categoria->cat_imagen_size->ViewAttributes() ?>><?php echo $categoria->cat_imagen_size->ListViewValue() ?></div></td>
		<td<?php echo $categoria->cat_mostrar->CellAttributes() ?>>
<div<?php echo $categoria->cat_mostrar->ViewAttributes() ?>><?php echo $categoria->cat_mostrar->ListViewValue() ?></div></td>
	</tr>
<?php
	$categoria_delete->Recordset->MoveNext();
}
$categoria_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$categoria_delete->ShowPageFooter();
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
$categoria_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class ccategoria_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'categoria';

	// Page object name
	var $PageObjName = 'categoria_delete';

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
	function ccategoria_delete() {
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
			define("EW_PAGE_ID", 'delete', TRUE);

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
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $categoria;

		// Load key parameters
		$this->RecKeys = $categoria->GetRecordKeys(); // Load record keys
		$sFilter = $categoria->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("categorialist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in categoria class, categoriainfo.php

		$categoria->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$categoria->CurrentAction = $_POST["a_delete"];
		} else {
			$categoria->CurrentAction = "D"; // Delete record directly
		}
		switch ($categoria->CurrentAction) {
			case "D": // Delete
				$categoria->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($categoria->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $categoria;

		// Call Recordset Selecting event
		$categoria->Recordset_Selecting($categoria->CurrentFilter);

		// Load List page SQL
		$sSql = $categoria->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$categoria->Recordset_Selected($rs);
		return $rs;
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

			// cat_imagen_tipo
			$categoria->cat_imagen_tipo->LinkCustomAttributes = "";
			$categoria->cat_imagen_tipo->HrefValue = "";
			$categoria->cat_imagen_tipo->TooltipValue = "";

			// cat_imagen_ancho
			$categoria->cat_imagen_ancho->LinkCustomAttributes = "";
			$categoria->cat_imagen_ancho->HrefValue = "";
			$categoria->cat_imagen_ancho->TooltipValue = "";

			// cat_imagen_alto
			$categoria->cat_imagen_alto->LinkCustomAttributes = "";
			$categoria->cat_imagen_alto->HrefValue = "";
			$categoria->cat_imagen_alto->TooltipValue = "";

			// cat_imagen_size
			$categoria->cat_imagen_size->LinkCustomAttributes = "";
			$categoria->cat_imagen_size->HrefValue = "";
			$categoria->cat_imagen_size->TooltipValue = "";

			// cat_mostrar
			$categoria->cat_mostrar->LinkCustomAttributes = "";
			$categoria->cat_mostrar->HrefValue = "";
			$categoria->cat_mostrar->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($categoria->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$categoria->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $categoria;
		$DeleteRows = TRUE;
		$sSql = $categoria->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $categoria->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['cat_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($categoria->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($categoria->CancelMessage <> "") {
				$this->setFailureMessage($categoria->CancelMessage);
				$categoria->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$categoria->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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
}
?>
