<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "ciudadinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$ciudad_delete = new cciudad_delete();
$Page =& $ciudad_delete;

// Page init
$ciudad_delete->Page_Init();

// Page main
$ciudad_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var ciudad_delete = new ew_Page("ciudad_delete");

// page properties
ciudad_delete.PageID = "delete"; // page ID
ciudad_delete.FormID = "fciudaddelete"; // form ID
var EW_PAGE_ID = ciudad_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
ciudad_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
ciudad_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
ciudad_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ciudad_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $ciudad_delete->ShowPageHeader(); ?>
<?php

// Load records for display
if ($ciudad_delete->Recordset = $ciudad_delete->LoadRecordset())
	$ciudad_deleteTotalRecs = $ciudad_delete->Recordset->RecordCount(); // Get record count
if ($ciudad_deleteTotalRecs <= 0) { // No record found, exit
	if ($ciudad_delete->Recordset)
		$ciudad_delete->Recordset->Close();
	$ciudad_delete->Page_Terminate("ciudadlist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ciudad->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $ciudad->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$ciudad_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="ciudad">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($ciudad_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $ciudad->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $ciudad->ciu_id->FldCaption() ?></td>
		<td valign="top"><?php echo $ciudad->reg_id->FldCaption() ?></td>
		<td valign="top"><?php echo $ciudad->ciu_nombre->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$ciudad_delete->RecCnt = 0;
$i = 0;
while (!$ciudad_delete->Recordset->EOF) {
	$ciudad_delete->RecCnt++;

	// Set row properties
	$ciudad->ResetAttrs();
	$ciudad->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$ciudad_delete->LoadRowValues($ciudad_delete->Recordset);

	// Render row
	$ciudad_delete->RenderRow();
?>
	<tr<?php echo $ciudad->RowAttributes() ?>>
		<td<?php echo $ciudad->ciu_id->CellAttributes() ?>>
<div<?php echo $ciudad->ciu_id->ViewAttributes() ?>><?php echo $ciudad->ciu_id->ListViewValue() ?></div></td>
		<td<?php echo $ciudad->reg_id->CellAttributes() ?>>
<div<?php echo $ciudad->reg_id->ViewAttributes() ?>><?php echo $ciudad->reg_id->ListViewValue() ?></div></td>
		<td<?php echo $ciudad->ciu_nombre->CellAttributes() ?>>
<div<?php echo $ciudad->ciu_nombre->ViewAttributes() ?>><?php echo $ciudad->ciu_nombre->ListViewValue() ?></div></td>
	</tr>
<?php
	$ciudad_delete->Recordset->MoveNext();
}
$ciudad_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$ciudad_delete->ShowPageFooter();
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
$ciudad_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cciudad_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'ciudad';

	// Page object name
	var $PageObjName = 'ciudad_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $ciudad;
		if ($ciudad->UseTokenInUrl) $PageUrl .= "t=" . $ciudad->TableVar . "&"; // Add page token
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
		global $objForm, $ciudad;
		if ($ciudad->UseTokenInUrl) {
			if ($objForm)
				return ($ciudad->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($ciudad->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cciudad_delete() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (ciudad)
		if (!isset($GLOBALS["ciudad"])) {
			$GLOBALS["ciudad"] = new cciudad();
			$GLOBALS["Table"] =& $GLOBALS["ciudad"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ciudad', TRUE);

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
		global $ciudad;

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
		global $Language, $ciudad;

		// Load key parameters
		$this->RecKeys = $ciudad->GetRecordKeys(); // Load record keys
		$sFilter = $ciudad->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("ciudadlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in ciudad class, ciudadinfo.php

		$ciudad->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$ciudad->CurrentAction = $_POST["a_delete"];
		} else {
			$ciudad->CurrentAction = "D"; // Delete record directly
		}
		switch ($ciudad->CurrentAction) {
			case "D": // Delete
				$ciudad->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($ciudad->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $ciudad;

		// Call Recordset Selecting event
		$ciudad->Recordset_Selecting($ciudad->CurrentFilter);

		// Load List page SQL
		$sSql = $ciudad->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$ciudad->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $ciudad;
		$sFilter = $ciudad->KeyFilter();

		// Call Row Selecting event
		$ciudad->Row_Selecting($sFilter);

		// Load SQL based on filter
		$ciudad->CurrentFilter = $sFilter;
		$sSql = $ciudad->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$ciudad->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $ciudad;
		if (!$rs || $rs->EOF) return;
		$ciudad->ciu_id->setDbValue($rs->fields('ciu_id'));
		$ciudad->reg_id->setDbValue($rs->fields('reg_id'));
		$ciudad->ciu_nombre->setDbValue($rs->fields('ciu_nombre'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $ciudad;

		// Initialize URLs
		// Call Row_Rendering event

		$ciudad->Row_Rendering();

		// Common render codes for all row types
		// ciu_id
		// reg_id
		// ciu_nombre

		if ($ciudad->RowType == EW_ROWTYPE_VIEW) { // View row

			// ciu_id
			$ciudad->ciu_id->ViewValue = $ciudad->ciu_id->CurrentValue;
			$ciudad->ciu_id->ViewCustomAttributes = "";

			// reg_id
			if (strval($ciudad->reg_id->CurrentValue) <> "") {
				$sFilterWrk = "`reg_id` = " . ew_AdjustSql($ciudad->reg_id->CurrentValue) . "";
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
					$ciudad->reg_id->ViewValue = $rswrk->fields('reg_num');
					$ciudad->reg_id->ViewValue .= ew_ValueSeparator(0,1,$ciudad->reg_id) . $rswrk->fields('reg_nombre');
					$rswrk->Close();
				} else {
					$ciudad->reg_id->ViewValue = $ciudad->reg_id->CurrentValue;
				}
			} else {
				$ciudad->reg_id->ViewValue = NULL;
			}
			$ciudad->reg_id->ViewCustomAttributes = "";

			// ciu_nombre
			$ciudad->ciu_nombre->ViewValue = $ciudad->ciu_nombre->CurrentValue;
			$ciudad->ciu_nombre->ViewCustomAttributes = "";

			// ciu_id
			$ciudad->ciu_id->LinkCustomAttributes = "";
			$ciudad->ciu_id->HrefValue = "";
			$ciudad->ciu_id->TooltipValue = "";

			// reg_id
			$ciudad->reg_id->LinkCustomAttributes = "";
			$ciudad->reg_id->HrefValue = "";
			$ciudad->reg_id->TooltipValue = "";

			// ciu_nombre
			$ciudad->ciu_nombre->LinkCustomAttributes = "";
			$ciudad->ciu_nombre->HrefValue = "";
			$ciudad->ciu_nombre->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($ciudad->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$ciudad->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $ciudad;
		$DeleteRows = TRUE;
		$sSql = $ciudad->SQL();
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
				$DeleteRows = $ciudad->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['ciu_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($ciudad->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($ciudad->CancelMessage <> "") {
				$this->setFailureMessage($ciudad->CancelMessage);
				$ciudad->CancelMessage = "";
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
				$ciudad->Row_Deleted($row);
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
