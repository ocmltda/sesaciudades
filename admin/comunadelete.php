<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "comunainfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$comuna_delete = new ccomuna_delete();
$Page =& $comuna_delete;

// Page init
$comuna_delete->Page_Init();

// Page main
$comuna_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var comuna_delete = new ew_Page("comuna_delete");

// page properties
comuna_delete.PageID = "delete"; // page ID
comuna_delete.FormID = "fcomunadelete"; // form ID
var EW_PAGE_ID = comuna_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
comuna_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
comuna_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
comuna_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
comuna_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $comuna_delete->ShowPageHeader(); ?>
<?php

// Load records for display
if ($comuna_delete->Recordset = $comuna_delete->LoadRecordset())
	$comuna_deleteTotalRecs = $comuna_delete->Recordset->RecordCount(); // Get record count
if ($comuna_deleteTotalRecs <= 0) { // No record found, exit
	if ($comuna_delete->Recordset)
		$comuna_delete->Recordset->Close();
	$comuna_delete->Page_Terminate("comunalist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $comuna->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $comuna->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$comuna_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="comuna">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($comuna_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $comuna->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $comuna->com_id->FldCaption() ?></td>
		<td valign="top"><?php echo $comuna->reg_id->FldCaption() ?></td>
		<td valign="top"><?php echo $comuna->ciu_id->FldCaption() ?></td>
		<td valign="top"><?php echo $comuna->com_nombre->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$comuna_delete->RecCnt = 0;
$i = 0;
while (!$comuna_delete->Recordset->EOF) {
	$comuna_delete->RecCnt++;

	// Set row properties
	$comuna->ResetAttrs();
	$comuna->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$comuna_delete->LoadRowValues($comuna_delete->Recordset);

	// Render row
	$comuna_delete->RenderRow();
?>
	<tr<?php echo $comuna->RowAttributes() ?>>
		<td<?php echo $comuna->com_id->CellAttributes() ?>>
<div<?php echo $comuna->com_id->ViewAttributes() ?>><?php echo $comuna->com_id->ListViewValue() ?></div></td>
		<td<?php echo $comuna->reg_id->CellAttributes() ?>>
<div<?php echo $comuna->reg_id->ViewAttributes() ?>><?php echo $comuna->reg_id->ListViewValue() ?></div></td>
		<td<?php echo $comuna->ciu_id->CellAttributes() ?>>
<div<?php echo $comuna->ciu_id->ViewAttributes() ?>><?php echo $comuna->ciu_id->ListViewValue() ?></div></td>
		<td<?php echo $comuna->com_nombre->CellAttributes() ?>>
<div<?php echo $comuna->com_nombre->ViewAttributes() ?>><?php echo $comuna->com_nombre->ListViewValue() ?></div></td>
	</tr>
<?php
	$comuna_delete->Recordset->MoveNext();
}
$comuna_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$comuna_delete->ShowPageFooter();
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
$comuna_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class ccomuna_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'comuna';

	// Page object name
	var $PageObjName = 'comuna_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $comuna;
		if ($comuna->UseTokenInUrl) $PageUrl .= "t=" . $comuna->TableVar . "&"; // Add page token
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
		global $objForm, $comuna;
		if ($comuna->UseTokenInUrl) {
			if ($objForm)
				return ($comuna->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($comuna->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccomuna_delete() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (comuna)
		if (!isset($GLOBALS["comuna"])) {
			$GLOBALS["comuna"] = new ccomuna();
			$GLOBALS["Table"] =& $GLOBALS["comuna"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'comuna', TRUE);

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
		global $comuna;

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
		global $Language, $comuna;

		// Load key parameters
		$this->RecKeys = $comuna->GetRecordKeys(); // Load record keys
		$sFilter = $comuna->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("comunalist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in comuna class, comunainfo.php

		$comuna->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$comuna->CurrentAction = $_POST["a_delete"];
		} else {
			$comuna->CurrentAction = "D"; // Delete record directly
		}
		switch ($comuna->CurrentAction) {
			case "D": // Delete
				$comuna->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($comuna->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $comuna;

		// Call Recordset Selecting event
		$comuna->Recordset_Selecting($comuna->CurrentFilter);

		// Load List page SQL
		$sSql = $comuna->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$comuna->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $comuna;
		$sFilter = $comuna->KeyFilter();

		// Call Row Selecting event
		$comuna->Row_Selecting($sFilter);

		// Load SQL based on filter
		$comuna->CurrentFilter = $sFilter;
		$sSql = $comuna->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$comuna->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $comuna;
		if (!$rs || $rs->EOF) return;
		$comuna->com_id->setDbValue($rs->fields('com_id'));
		$comuna->reg_id->setDbValue($rs->fields('reg_id'));
		$comuna->ciu_id->setDbValue($rs->fields('ciu_id'));
		$comuna->com_nombre->setDbValue($rs->fields('com_nombre'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $comuna;

		// Initialize URLs
		// Call Row_Rendering event

		$comuna->Row_Rendering();

		// Common render codes for all row types
		// com_id
		// reg_id
		// ciu_id
		// com_nombre

		if ($comuna->RowType == EW_ROWTYPE_VIEW) { // View row

			// com_id
			$comuna->com_id->ViewValue = $comuna->com_id->CurrentValue;
			$comuna->com_id->ViewCustomAttributes = "";

			// reg_id
			if (strval($comuna->reg_id->CurrentValue) <> "") {
				$sFilterWrk = "`reg_id` = " . ew_AdjustSql($comuna->reg_id->CurrentValue) . "";
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
					$comuna->reg_id->ViewValue = $rswrk->fields('reg_num');
					$comuna->reg_id->ViewValue .= ew_ValueSeparator(0,1,$comuna->reg_id) . $rswrk->fields('reg_nombre');
					$rswrk->Close();
				} else {
					$comuna->reg_id->ViewValue = $comuna->reg_id->CurrentValue;
				}
			} else {
				$comuna->reg_id->ViewValue = NULL;
			}
			$comuna->reg_id->ViewCustomAttributes = "";

			// ciu_id
			if (strval($comuna->ciu_id->CurrentValue) <> "") {
				$sFilterWrk = "`ciu_id` = " . ew_AdjustSql($comuna->ciu_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `ciu_nombre` FROM `ciudad`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `ciu_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$comuna->ciu_id->ViewValue = $rswrk->fields('ciu_nombre');
					$rswrk->Close();
				} else {
					$comuna->ciu_id->ViewValue = $comuna->ciu_id->CurrentValue;
				}
			} else {
				$comuna->ciu_id->ViewValue = NULL;
			}
			$comuna->ciu_id->ViewCustomAttributes = "";

			// com_nombre
			$comuna->com_nombre->ViewValue = $comuna->com_nombre->CurrentValue;
			$comuna->com_nombre->ViewCustomAttributes = "";

			// com_id
			$comuna->com_id->LinkCustomAttributes = "";
			$comuna->com_id->HrefValue = "";
			$comuna->com_id->TooltipValue = "";

			// reg_id
			$comuna->reg_id->LinkCustomAttributes = "";
			$comuna->reg_id->HrefValue = "";
			$comuna->reg_id->TooltipValue = "";

			// ciu_id
			$comuna->ciu_id->LinkCustomAttributes = "";
			$comuna->ciu_id->HrefValue = "";
			$comuna->ciu_id->TooltipValue = "";

			// com_nombre
			$comuna->com_nombre->LinkCustomAttributes = "";
			$comuna->com_nombre->HrefValue = "";
			$comuna->com_nombre->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($comuna->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$comuna->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $comuna;
		$DeleteRows = TRUE;
		$sSql = $comuna->SQL();
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
				$DeleteRows = $comuna->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['com_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($comuna->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($comuna->CancelMessage <> "") {
				$this->setFailureMessage($comuna->CancelMessage);
				$comuna->CancelMessage = "";
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
				$comuna->Row_Deleted($row);
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
