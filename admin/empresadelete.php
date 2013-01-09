<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "empresainfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$empresa_delete = new cempresa_delete();
$Page =& $empresa_delete;

// Page init
$empresa_delete->Page_Init();

// Page main
$empresa_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var empresa_delete = new ew_Page("empresa_delete");

// page properties
empresa_delete.PageID = "delete"; // page ID
empresa_delete.FormID = "fempresadelete"; // form ID
var EW_PAGE_ID = empresa_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
empresa_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
empresa_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
empresa_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
empresa_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $empresa_delete->ShowPageHeader(); ?>
<?php

// Load records for display
if ($empresa_delete->Recordset = $empresa_delete->LoadRecordset())
	$empresa_deleteTotalRecs = $empresa_delete->Recordset->RecordCount(); // Get record count
if ($empresa_deleteTotalRecs <= 0) { // No record found, exit
	if ($empresa_delete->Recordset)
		$empresa_delete->Recordset->Close();
	$empresa_delete->Page_Terminate("empresalist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $empresa->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $empresa->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$empresa_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="empresa">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($empresa_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $empresa->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $empresa->emp_id->FldCaption() ?></td>
		<td valign="top"><?php echo $empresa->emp_nomfantasia->FldCaption() ?></td>
		<td valign="top"><?php echo $empresa->emp_razonsocial->FldCaption() ?></td>
		<td valign="top"><?php echo $empresa->emp_rut->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$empresa_delete->RecCnt = 0;
$i = 0;
while (!$empresa_delete->Recordset->EOF) {
	$empresa_delete->RecCnt++;

	// Set row properties
	$empresa->ResetAttrs();
	$empresa->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$empresa_delete->LoadRowValues($empresa_delete->Recordset);

	// Render row
	$empresa_delete->RenderRow();
?>
	<tr<?php echo $empresa->RowAttributes() ?>>
		<td<?php echo $empresa->emp_id->CellAttributes() ?>>
<div<?php echo $empresa->emp_id->ViewAttributes() ?>><?php echo $empresa->emp_id->ListViewValue() ?></div></td>
		<td<?php echo $empresa->emp_nomfantasia->CellAttributes() ?>>
<div<?php echo $empresa->emp_nomfantasia->ViewAttributes() ?>><?php echo $empresa->emp_nomfantasia->ListViewValue() ?></div></td>
		<td<?php echo $empresa->emp_razonsocial->CellAttributes() ?>>
<div<?php echo $empresa->emp_razonsocial->ViewAttributes() ?>><?php echo $empresa->emp_razonsocial->ListViewValue() ?></div></td>
		<td<?php echo $empresa->emp_rut->CellAttributes() ?>>
<div<?php echo $empresa->emp_rut->ViewAttributes() ?>><?php echo $empresa->emp_rut->ListViewValue() ?></div></td>
	</tr>
<?php
	$empresa_delete->Recordset->MoveNext();
}
$empresa_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$empresa_delete->ShowPageFooter();
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
$empresa_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cempresa_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'empresa';

	// Page object name
	var $PageObjName = 'empresa_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $empresa;
		if ($empresa->UseTokenInUrl) $PageUrl .= "t=" . $empresa->TableVar . "&"; // Add page token
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
		global $objForm, $empresa;
		if ($empresa->UseTokenInUrl) {
			if ($objForm)
				return ($empresa->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($empresa->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cempresa_delete() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (empresa)
		if (!isset($GLOBALS["empresa"])) {
			$GLOBALS["empresa"] = new cempresa();
			$GLOBALS["Table"] =& $GLOBALS["empresa"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'empresa', TRUE);

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
		global $empresa;

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
		global $Language, $empresa;

		// Load key parameters
		$this->RecKeys = $empresa->GetRecordKeys(); // Load record keys
		$sFilter = $empresa->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("empresalist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in empresa class, empresainfo.php

		$empresa->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$empresa->CurrentAction = $_POST["a_delete"];
		} else {
			$empresa->CurrentAction = "D"; // Delete record directly
		}
		switch ($empresa->CurrentAction) {
			case "D": // Delete
				$empresa->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($empresa->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $empresa;

		// Call Recordset Selecting event
		$empresa->Recordset_Selecting($empresa->CurrentFilter);

		// Load List page SQL
		$sSql = $empresa->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$empresa->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $empresa;
		$sFilter = $empresa->KeyFilter();

		// Call Row Selecting event
		$empresa->Row_Selecting($sFilter);

		// Load SQL based on filter
		$empresa->CurrentFilter = $sFilter;
		$sSql = $empresa->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$empresa->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $empresa;
		if (!$rs || $rs->EOF) return;
		$empresa->emp_id->setDbValue($rs->fields('emp_id'));
		$empresa->emp_nomfantasia->setDbValue($rs->fields('emp_nomfantasia'));
		$empresa->emp_razonsocial->setDbValue($rs->fields('emp_razonsocial'));
		$empresa->emp_rut->setDbValue($rs->fields('emp_rut'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $empresa;

		// Initialize URLs
		// Call Row_Rendering event

		$empresa->Row_Rendering();

		// Common render codes for all row types
		// emp_id
		// emp_nomfantasia
		// emp_razonsocial
		// emp_rut

		if ($empresa->RowType == EW_ROWTYPE_VIEW) { // View row

			// emp_id
			$empresa->emp_id->ViewValue = $empresa->emp_id->CurrentValue;
			$empresa->emp_id->ViewCustomAttributes = "";

			// emp_nomfantasia
			$empresa->emp_nomfantasia->ViewValue = $empresa->emp_nomfantasia->CurrentValue;
			$empresa->emp_nomfantasia->ViewCustomAttributes = "";

			// emp_razonsocial
			$empresa->emp_razonsocial->ViewValue = $empresa->emp_razonsocial->CurrentValue;
			$empresa->emp_razonsocial->ViewCustomAttributes = "";

			// emp_rut
			$empresa->emp_rut->ViewValue = $empresa->emp_rut->CurrentValue;
			$empresa->emp_rut->ViewCustomAttributes = "";

			// emp_id
			$empresa->emp_id->LinkCustomAttributes = "";
			$empresa->emp_id->HrefValue = "";
			$empresa->emp_id->TooltipValue = "";

			// emp_nomfantasia
			$empresa->emp_nomfantasia->LinkCustomAttributes = "";
			$empresa->emp_nomfantasia->HrefValue = "";
			$empresa->emp_nomfantasia->TooltipValue = "";

			// emp_razonsocial
			$empresa->emp_razonsocial->LinkCustomAttributes = "";
			$empresa->emp_razonsocial->HrefValue = "";
			$empresa->emp_razonsocial->TooltipValue = "";

			// emp_rut
			$empresa->emp_rut->LinkCustomAttributes = "";
			$empresa->emp_rut->HrefValue = "";
			$empresa->emp_rut->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($empresa->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$empresa->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $empresa;
		$DeleteRows = TRUE;
		$sSql = $empresa->SQL();
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
				$DeleteRows = $empresa->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['emp_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($empresa->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($empresa->CancelMessage <> "") {
				$this->setFailureMessage($empresa->CancelMessage);
				$empresa->CancelMessage = "";
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
				$empresa->Row_Deleted($row);
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
