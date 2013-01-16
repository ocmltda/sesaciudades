<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "cupon_regioninfo.php" ?>
<?php include_once "cuponinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$cupon_region_delete = new ccupon_region_delete();
$Page =& $cupon_region_delete;

// Page init
$cupon_region_delete->Page_Init();

// Page main
$cupon_region_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var cupon_region_delete = new ew_Page("cupon_region_delete");

// page properties
cupon_region_delete.PageID = "delete"; // page ID
cupon_region_delete.FormID = "fcupon_regiondelete"; // form ID
var EW_PAGE_ID = cupon_region_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cupon_region_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cupon_region_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cupon_region_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cupon_region_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $cupon_region_delete->ShowPageHeader(); ?>
<?php

// Load records for display
if ($cupon_region_delete->Recordset = $cupon_region_delete->LoadRecordset())
	$cupon_region_deleteTotalRecs = $cupon_region_delete->Recordset->RecordCount(); // Get record count
if ($cupon_region_deleteTotalRecs <= 0) { // No record found, exit
	if ($cupon_region_delete->Recordset)
		$cupon_region_delete->Recordset->Close();
	$cupon_region_delete->Page_Terminate("cupon_regionlist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cupon_region->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $cupon_region->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$cupon_region_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="cupon_region">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cupon_region_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $cupon_region->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $cupon_region->crg_id->FldCaption() ?></td>
		<td valign="top"><?php echo $cupon_region->cup_id->FldCaption() ?></td>
		<td valign="top"><?php echo $cupon_region->reg_id->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$cupon_region_delete->RecCnt = 0;
$i = 0;
while (!$cupon_region_delete->Recordset->EOF) {
	$cupon_region_delete->RecCnt++;

	// Set row properties
	$cupon_region->ResetAttrs();
	$cupon_region->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cupon_region_delete->LoadRowValues($cupon_region_delete->Recordset);

	// Render row
	$cupon_region_delete->RenderRow();
?>
	<tr<?php echo $cupon_region->RowAttributes() ?>>
		<td<?php echo $cupon_region->crg_id->CellAttributes() ?>>
<div<?php echo $cupon_region->crg_id->ViewAttributes() ?>><?php echo $cupon_region->crg_id->ListViewValue() ?></div></td>
		<td<?php echo $cupon_region->cup_id->CellAttributes() ?>>
<div<?php echo $cupon_region->cup_id->ViewAttributes() ?>><?php echo $cupon_region->cup_id->ListViewValue() ?></div></td>
		<td<?php echo $cupon_region->reg_id->CellAttributes() ?>>
<div<?php echo $cupon_region->reg_id->ViewAttributes() ?>><?php echo $cupon_region->reg_id->ListViewValue() ?></div></td>
	</tr>
<?php
	$cupon_region_delete->Recordset->MoveNext();
}
$cupon_region_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$cupon_region_delete->ShowPageFooter();
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
$cupon_region_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class ccupon_region_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'cupon_region';

	// Page object name
	var $PageObjName = 'cupon_region_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cupon_region;
		if ($cupon_region->UseTokenInUrl) $PageUrl .= "t=" . $cupon_region->TableVar . "&"; // Add page token
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
		global $objForm, $cupon_region;
		if ($cupon_region->UseTokenInUrl) {
			if ($objForm)
				return ($cupon_region->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cupon_region->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccupon_region_delete() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (cupon_region)
		if (!isset($GLOBALS["cupon_region"])) {
			$GLOBALS["cupon_region"] = new ccupon_region();
			$GLOBALS["Table"] =& $GLOBALS["cupon_region"];
		}

		// Table object (cupon)
		if (!isset($GLOBALS['cupon'])) $GLOBALS['cupon'] = new ccupon();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cupon_region', TRUE);

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
		global $cupon_region;

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
		global $Language, $cupon_region;

		// Load key parameters
		$this->RecKeys = $cupon_region->GetRecordKeys(); // Load record keys
		$sFilter = $cupon_region->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("cupon_regionlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in cupon_region class, cupon_regioninfo.php

		$cupon_region->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$cupon_region->CurrentAction = $_POST["a_delete"];
		} else {
			$cupon_region->CurrentAction = "D"; // Delete record directly
		}
		switch ($cupon_region->CurrentAction) {
			case "D": // Delete
				$cupon_region->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($cupon_region->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $cupon_region;

		// Call Recordset Selecting event
		$cupon_region->Recordset_Selecting($cupon_region->CurrentFilter);

		// Load List page SQL
		$sSql = $cupon_region->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$cupon_region->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cupon_region;
		$sFilter = $cupon_region->KeyFilter();

		// Call Row Selecting event
		$cupon_region->Row_Selecting($sFilter);

		// Load SQL based on filter
		$cupon_region->CurrentFilter = $sFilter;
		$sSql = $cupon_region->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$cupon_region->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $cupon_region;
		if (!$rs || $rs->EOF) return;
		$cupon_region->crg_id->setDbValue($rs->fields('crg_id'));
		$cupon_region->cup_id->setDbValue($rs->fields('cup_id'));
		$cupon_region->reg_id->setDbValue($rs->fields('reg_id'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $cupon_region;

		// Initialize URLs
		// Call Row_Rendering event

		$cupon_region->Row_Rendering();

		// Common render codes for all row types
		// crg_id
		// cup_id
		// reg_id

		if ($cupon_region->RowType == EW_ROWTYPE_VIEW) { // View row

			// crg_id
			$cupon_region->crg_id->ViewValue = $cupon_region->crg_id->CurrentValue;
			$cupon_region->crg_id->ViewCustomAttributes = "";

			// cup_id
			if (strval($cupon_region->cup_id->CurrentValue) <> "") {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($cupon_region->cup_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cup_nombre` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$cupon_region->cup_id->ViewValue = $rswrk->fields('cup_nombre');
					$rswrk->Close();
				} else {
					$cupon_region->cup_id->ViewValue = $cupon_region->cup_id->CurrentValue;
				}
			} else {
				$cupon_region->cup_id->ViewValue = NULL;
			}
			$cupon_region->cup_id->ViewCustomAttributes = "";

			// reg_id
			if (strval($cupon_region->reg_id->CurrentValue) <> "") {
				$sFilterWrk = "`reg_id` = " . ew_AdjustSql($cupon_region->reg_id->CurrentValue) . "";
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
					$cupon_region->reg_id->ViewValue = $rswrk->fields('reg_num');
					$cupon_region->reg_id->ViewValue .= ew_ValueSeparator(0,1,$cupon_region->reg_id) . $rswrk->fields('reg_nombre');
					$rswrk->Close();
				} else {
					$cupon_region->reg_id->ViewValue = $cupon_region->reg_id->CurrentValue;
				}
			} else {
				$cupon_region->reg_id->ViewValue = NULL;
			}
			$cupon_region->reg_id->ViewCustomAttributes = "";

			// crg_id
			$cupon_region->crg_id->LinkCustomAttributes = "";
			$cupon_region->crg_id->HrefValue = "";
			$cupon_region->crg_id->TooltipValue = "";

			// cup_id
			$cupon_region->cup_id->LinkCustomAttributes = "";
			$cupon_region->cup_id->HrefValue = "";
			$cupon_region->cup_id->TooltipValue = "";

			// reg_id
			$cupon_region->reg_id->LinkCustomAttributes = "";
			$cupon_region->reg_id->HrefValue = "";
			$cupon_region->reg_id->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($cupon_region->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$cupon_region->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $cupon_region;
		$DeleteRows = TRUE;
		$sSql = $cupon_region->SQL();
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
				$DeleteRows = $cupon_region->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['crg_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($cupon_region->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($cupon_region->CancelMessage <> "") {
				$this->setFailureMessage($cupon_region->CancelMessage);
				$cupon_region->CancelMessage = "";
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
				$cupon_region->Row_Deleted($row);
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
