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
$promocion_delete = new cpromocion_delete();
$Page =& $promocion_delete;

// Page init
$promocion_delete->Page_Init();

// Page main
$promocion_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var promocion_delete = new ew_Page("promocion_delete");

// page properties
promocion_delete.PageID = "delete"; // page ID
promocion_delete.FormID = "fpromociondelete"; // form ID
var EW_PAGE_ID = promocion_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
promocion_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
promocion_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
promocion_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
promocion_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $promocion_delete->ShowPageHeader(); ?>
<?php

// Load records for display
if ($promocion_delete->Recordset = $promocion_delete->LoadRecordset())
	$promocion_deleteTotalRecs = $promocion_delete->Recordset->RecordCount(); // Get record count
if ($promocion_deleteTotalRecs <= 0) { // No record found, exit
	if ($promocion_delete->Recordset)
		$promocion_delete->Recordset->Close();
	$promocion_delete->Page_Terminate("promocionlist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $promocion->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $promocion->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$promocion_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="promocion">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($promocion_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $promocion->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $promocion->pro_id->FldCaption() ?></td>
		<td valign="top"><?php echo $promocion->pro_titulo->FldCaption() ?></td>
		<td valign="top"><?php echo $promocion->pro_imagen_nombre->FldCaption() ?></td>
		<td valign="top"><?php echo $promocion->pro_vigente->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$promocion_delete->RecCnt = 0;
$i = 0;
while (!$promocion_delete->Recordset->EOF) {
	$promocion_delete->RecCnt++;

	// Set row properties
	$promocion->ResetAttrs();
	$promocion->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$promocion_delete->LoadRowValues($promocion_delete->Recordset);

	// Render row
	$promocion_delete->RenderRow();
?>
	<tr<?php echo $promocion->RowAttributes() ?>>
		<td<?php echo $promocion->pro_id->CellAttributes() ?>>
<div<?php echo $promocion->pro_id->ViewAttributes() ?>><?php echo $promocion->pro_id->ListViewValue() ?></div></td>
		<td<?php echo $promocion->pro_titulo->CellAttributes() ?>>
<div<?php echo $promocion->pro_titulo->ViewAttributes() ?>><?php echo $promocion->pro_titulo->ListViewValue() ?></div></td>
		<td<?php echo $promocion->pro_imagen_nombre->CellAttributes() ?>>
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
</td>
		<td<?php echo $promocion->pro_vigente->CellAttributes() ?>>
<div<?php echo $promocion->pro_vigente->ViewAttributes() ?>><?php echo $promocion->pro_vigente->ListViewValue() ?></div></td>
	</tr>
<?php
	$promocion_delete->Recordset->MoveNext();
}
$promocion_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$promocion_delete->ShowPageFooter();
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
$promocion_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cpromocion_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'promocion';

	// Page object name
	var $PageObjName = 'promocion_delete';

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
	function cpromocion_delete() {
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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		global $Language, $promocion;

		// Load key parameters
		$this->RecKeys = $promocion->GetRecordKeys(); // Load record keys
		$sFilter = $promocion->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("promocionlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in promocion class, promocioninfo.php

		$promocion->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$promocion->CurrentAction = $_POST["a_delete"];
		} else {
			$promocion->CurrentAction = "D"; // Delete record directly
		}
		switch ($promocion->CurrentAction) {
			case "D": // Delete
				$promocion->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($promocion->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $promocion;

		// Call Recordset Selecting event
		$promocion->Recordset_Selecting($promocion->CurrentFilter);

		// Load List page SQL
		$sSql = $promocion->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$promocion->Recordset_Selected($rs);
		return $rs;
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
		}

		// Call Row Rendered event
		if ($promocion->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$promocion->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $promocion;
		$DeleteRows = TRUE;
		$sSql = $promocion->SQL();
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
				$DeleteRows = $promocion->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['pro_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($promocion->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($promocion->CancelMessage <> "") {
				$this->setFailureMessage($promocion->CancelMessage);
				$promocion->CancelMessage = "";
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
				$promocion->Row_Deleted($row);
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
