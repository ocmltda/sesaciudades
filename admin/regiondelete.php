<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "regioninfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$region_delete = new cregion_delete();
$Page =& $region_delete;

// Page init
$region_delete->Page_Init();

// Page main
$region_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var region_delete = new ew_Page("region_delete");

// page properties
region_delete.PageID = "delete"; // page ID
region_delete.FormID = "fregiondelete"; // form ID
var EW_PAGE_ID = region_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
region_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
region_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
region_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
region_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $region_delete->ShowPageHeader(); ?>
<?php

// Load records for display
if ($region_delete->Recordset = $region_delete->LoadRecordset())
	$region_deleteTotalRecs = $region_delete->Recordset->RecordCount(); // Get record count
if ($region_deleteTotalRecs <= 0) { // No record found, exit
	if ($region_delete->Recordset)
		$region_delete->Recordset->Close();
	$region_delete->Page_Terminate("regionlist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $region->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $region->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$region_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="region">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($region_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $region->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $region->reg_id->FldCaption() ?></td>
		<td valign="top"><?php echo $region->reg_num->FldCaption() ?></td>
		<td valign="top"><?php echo $region->reg_cod->FldCaption() ?></td>
		<td valign="top"><?php echo $region->reg_nombre->FldCaption() ?></td>
		<td valign="top"><?php echo $region->reg_alias->FldCaption() ?></td>
		<td valign="top"><?php echo $region->reg_ordenmapa->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$region_delete->RecCnt = 0;
$i = 0;
while (!$region_delete->Recordset->EOF) {
	$region_delete->RecCnt++;

	// Set row properties
	$region->ResetAttrs();
	$region->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$region_delete->LoadRowValues($region_delete->Recordset);

	// Render row
	$region_delete->RenderRow();
?>
	<tr<?php echo $region->RowAttributes() ?>>
		<td<?php echo $region->reg_id->CellAttributes() ?>>
<div<?php echo $region->reg_id->ViewAttributes() ?>><?php echo $region->reg_id->ListViewValue() ?></div></td>
		<td<?php echo $region->reg_num->CellAttributes() ?>>
<div<?php echo $region->reg_num->ViewAttributes() ?>><?php echo $region->reg_num->ListViewValue() ?></div></td>
		<td<?php echo $region->reg_cod->CellAttributes() ?>>
<div<?php echo $region->reg_cod->ViewAttributes() ?>><?php echo $region->reg_cod->ListViewValue() ?></div></td>
		<td<?php echo $region->reg_nombre->CellAttributes() ?>>
<div<?php echo $region->reg_nombre->ViewAttributes() ?>><?php echo $region->reg_nombre->ListViewValue() ?></div></td>
		<td<?php echo $region->reg_alias->CellAttributes() ?>>
<div<?php echo $region->reg_alias->ViewAttributes() ?>><?php echo $region->reg_alias->ListViewValue() ?></div></td>
		<td<?php echo $region->reg_ordenmapa->CellAttributes() ?>>
<div<?php echo $region->reg_ordenmapa->ViewAttributes() ?>><?php echo $region->reg_ordenmapa->ListViewValue() ?></div></td>
	</tr>
<?php
	$region_delete->Recordset->MoveNext();
}
$region_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$region_delete->ShowPageFooter();
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
$region_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cregion_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'region';

	// Page object name
	var $PageObjName = 'region_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $region;
		if ($region->UseTokenInUrl) $PageUrl .= "t=" . $region->TableVar . "&"; // Add page token
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
		global $objForm, $region;
		if ($region->UseTokenInUrl) {
			if ($objForm)
				return ($region->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($region->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cregion_delete() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (region)
		if (!isset($GLOBALS["region"])) {
			$GLOBALS["region"] = new cregion();
			$GLOBALS["Table"] =& $GLOBALS["region"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'region', TRUE);

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
		global $region;

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
		global $Language, $region;

		// Load key parameters
		$this->RecKeys = $region->GetRecordKeys(); // Load record keys
		$sFilter = $region->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("regionlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in region class, regioninfo.php

		$region->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$region->CurrentAction = $_POST["a_delete"];
		} else {
			$region->CurrentAction = "D"; // Delete record directly
		}
		switch ($region->CurrentAction) {
			case "D": // Delete
				$region->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($region->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $region;

		// Call Recordset Selecting event
		$region->Recordset_Selecting($region->CurrentFilter);

		// Load List page SQL
		$sSql = $region->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$region->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $region;
		$sFilter = $region->KeyFilter();

		// Call Row Selecting event
		$region->Row_Selecting($sFilter);

		// Load SQL based on filter
		$region->CurrentFilter = $sFilter;
		$sSql = $region->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$region->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $region;
		if (!$rs || $rs->EOF) return;
		$region->reg_id->setDbValue($rs->fields('reg_id'));
		$region->reg_num->setDbValue($rs->fields('reg_num'));
		$region->reg_cod->setDbValue($rs->fields('reg_cod'));
		$region->reg_nombre->setDbValue($rs->fields('reg_nombre'));
		$region->reg_alias->setDbValue($rs->fields('reg_alias'));
		$region->reg_ordenmapa->setDbValue($rs->fields('reg_ordenmapa'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $region;

		// Initialize URLs
		// Call Row_Rendering event

		$region->Row_Rendering();

		// Common render codes for all row types
		// reg_id
		// reg_num
		// reg_cod
		// reg_nombre
		// reg_alias
		// reg_ordenmapa

		if ($region->RowType == EW_ROWTYPE_VIEW) { // View row

			// reg_id
			$region->reg_id->ViewValue = $region->reg_id->CurrentValue;
			$region->reg_id->ViewCustomAttributes = "";

			// reg_num
			$region->reg_num->ViewValue = $region->reg_num->CurrentValue;
			$region->reg_num->ViewCustomAttributes = "";

			// reg_cod
			$region->reg_cod->ViewValue = $region->reg_cod->CurrentValue;
			$region->reg_cod->ViewCustomAttributes = "";

			// reg_nombre
			$region->reg_nombre->ViewValue = $region->reg_nombre->CurrentValue;
			$region->reg_nombre->ViewCustomAttributes = "";

			// reg_alias
			$region->reg_alias->ViewValue = $region->reg_alias->CurrentValue;
			$region->reg_alias->ViewCustomAttributes = "";

			// reg_ordenmapa
			$region->reg_ordenmapa->ViewValue = $region->reg_ordenmapa->CurrentValue;
			$region->reg_ordenmapa->ViewCustomAttributes = "";

			// reg_id
			$region->reg_id->LinkCustomAttributes = "";
			$region->reg_id->HrefValue = "";
			$region->reg_id->TooltipValue = "";

			// reg_num
			$region->reg_num->LinkCustomAttributes = "";
			$region->reg_num->HrefValue = "";
			$region->reg_num->TooltipValue = "";

			// reg_cod
			$region->reg_cod->LinkCustomAttributes = "";
			$region->reg_cod->HrefValue = "";
			$region->reg_cod->TooltipValue = "";

			// reg_nombre
			$region->reg_nombre->LinkCustomAttributes = "";
			$region->reg_nombre->HrefValue = "";
			$region->reg_nombre->TooltipValue = "";

			// reg_alias
			$region->reg_alias->LinkCustomAttributes = "";
			$region->reg_alias->HrefValue = "";
			$region->reg_alias->TooltipValue = "";

			// reg_ordenmapa
			$region->reg_ordenmapa->LinkCustomAttributes = "";
			$region->reg_ordenmapa->HrefValue = "";
			$region->reg_ordenmapa->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($region->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$region->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $region;
		$DeleteRows = TRUE;
		$sSql = $region->SQL();
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
				$DeleteRows = $region->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['reg_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($region->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($region->CancelMessage <> "") {
				$this->setFailureMessage($region->CancelMessage);
				$region->CancelMessage = "";
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
				$region->Row_Deleted($row);
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
