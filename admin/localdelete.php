<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "localinfo.php" ?>
<?php include_once "empresainfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$local_delete = new clocal_delete();
$Page =& $local_delete;

// Page init
$local_delete->Page_Init();

// Page main
$local_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var local_delete = new ew_Page("local_delete");

// page properties
local_delete.PageID = "delete"; // page ID
local_delete.FormID = "flocaldelete"; // form ID
var EW_PAGE_ID = local_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
local_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
local_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
local_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
local_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $local_delete->ShowPageHeader(); ?>
<?php

// Load records for display
if ($local_delete->Recordset = $local_delete->LoadRecordset())
	$local_deleteTotalRecs = $local_delete->Recordset->RecordCount(); // Get record count
if ($local_deleteTotalRecs <= 0) { // No record found, exit
	if ($local_delete->Recordset)
		$local_delete->Recordset->Close();
	$local_delete->Page_Terminate("locallist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $local->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $local->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$local_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="local">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($local_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $local->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $local->loc_id->FldCaption() ?></td>
		<td valign="top"><?php echo $local->emp_id->FldCaption() ?></td>
		<td valign="top"><?php echo $local->loc_nombre->FldCaption() ?></td>
		<td valign="top"><?php echo $local->loc_direccion->FldCaption() ?></td>
		<td valign="top"><?php echo $local->loc_vigente->FldCaption() ?></td>
		<td valign="top"><?php echo $local->loc_comuna->FldCaption() ?></td>
		<td valign="top"><?php echo $local->loc_ciudad->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$local_delete->RecCnt = 0;
$i = 0;
while (!$local_delete->Recordset->EOF) {
	$local_delete->RecCnt++;

	// Set row properties
	$local->ResetAttrs();
	$local->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$local_delete->LoadRowValues($local_delete->Recordset);

	// Render row
	$local_delete->RenderRow();
?>
	<tr<?php echo $local->RowAttributes() ?>>
		<td<?php echo $local->loc_id->CellAttributes() ?>>
<div<?php echo $local->loc_id->ViewAttributes() ?>><?php echo $local->loc_id->ListViewValue() ?></div></td>
		<td<?php echo $local->emp_id->CellAttributes() ?>>
<div<?php echo $local->emp_id->ViewAttributes() ?>><?php echo $local->emp_id->ListViewValue() ?></div></td>
		<td<?php echo $local->loc_nombre->CellAttributes() ?>>
<div<?php echo $local->loc_nombre->ViewAttributes() ?>><?php echo $local->loc_nombre->ListViewValue() ?></div></td>
		<td<?php echo $local->loc_direccion->CellAttributes() ?>>
<div<?php echo $local->loc_direccion->ViewAttributes() ?>><?php echo $local->loc_direccion->ListViewValue() ?></div></td>
		<td<?php echo $local->loc_vigente->CellAttributes() ?>>
<div<?php echo $local->loc_vigente->ViewAttributes() ?>><?php echo $local->loc_vigente->ListViewValue() ?></div></td>
		<td<?php echo $local->loc_comuna->CellAttributes() ?>>
<div<?php echo $local->loc_comuna->ViewAttributes() ?>><?php echo $local->loc_comuna->ListViewValue() ?></div></td>
		<td<?php echo $local->loc_ciudad->CellAttributes() ?>>
<div<?php echo $local->loc_ciudad->ViewAttributes() ?>><?php echo $local->loc_ciudad->ListViewValue() ?></div></td>
	</tr>
<?php
	$local_delete->Recordset->MoveNext();
}
$local_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$local_delete->ShowPageFooter();
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
$local_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class clocal_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'local';

	// Page object name
	var $PageObjName = 'local_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $local;
		if ($local->UseTokenInUrl) $PageUrl .= "t=" . $local->TableVar . "&"; // Add page token
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
		global $objForm, $local;
		if ($local->UseTokenInUrl) {
			if ($objForm)
				return ($local->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($local->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function clocal_delete() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (local)
		if (!isset($GLOBALS["local"])) {
			$GLOBALS["local"] = new clocal();
			$GLOBALS["Table"] =& $GLOBALS["local"];
		}

		// Table object (empresa)
		if (!isset($GLOBALS['empresa'])) $GLOBALS['empresa'] = new cempresa();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'local', TRUE);

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
		global $local;

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
		global $Language, $local;

		// Load key parameters
		$this->RecKeys = $local->GetRecordKeys(); // Load record keys
		$sFilter = $local->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("locallist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in local class, localinfo.php

		$local->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$local->CurrentAction = $_POST["a_delete"];
		} else {
			$local->CurrentAction = "D"; // Delete record directly
		}
		switch ($local->CurrentAction) {
			case "D": // Delete
				$local->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($local->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $local;

		// Call Recordset Selecting event
		$local->Recordset_Selecting($local->CurrentFilter);

		// Load List page SQL
		$sSql = $local->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$local->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $local;
		$sFilter = $local->KeyFilter();

		// Call Row Selecting event
		$local->Row_Selecting($sFilter);

		// Load SQL based on filter
		$local->CurrentFilter = $sFilter;
		$sSql = $local->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$local->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $local;
		if (!$rs || $rs->EOF) return;
		$local->loc_id->setDbValue($rs->fields('loc_id'));
		$local->emp_id->setDbValue($rs->fields('emp_id'));
		$local->loc_nombre->setDbValue($rs->fields('loc_nombre'));
		$local->loc_direccion->setDbValue($rs->fields('loc_direccion'));
		$local->loc_googlemaps->setDbValue($rs->fields('loc_googlemaps'));
		$local->loc_vigente->setDbValue($rs->fields('loc_vigente'));
		$local->loc_comuna->setDbValue($rs->fields('loc_comuna'));
		$local->loc_ciudad->setDbValue($rs->fields('loc_ciudad'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $local;

		// Initialize URLs
		// Call Row_Rendering event

		$local->Row_Rendering();

		// Common render codes for all row types
		// loc_id
		// emp_id
		// loc_nombre
		// loc_direccion
		// loc_googlemaps
		// loc_vigente
		// loc_comuna
		// loc_ciudad

		if ($local->RowType == EW_ROWTYPE_VIEW) { // View row

			// loc_id
			$local->loc_id->ViewValue = $local->loc_id->CurrentValue;
			$local->loc_id->ViewCustomAttributes = "";

			// emp_id
			if (strval($local->emp_id->CurrentValue) <> "") {
				$sFilterWrk = "`emp_id` = " . ew_AdjustSql($local->emp_id->CurrentValue) . "";
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
					$local->emp_id->ViewValue = $rswrk->fields('emp_rut');
					$local->emp_id->ViewValue .= ew_ValueSeparator(0,1,$local->emp_id) . $rswrk->fields('emp_nomfantasia');
					$local->emp_id->ViewValue .= ew_ValueSeparator(0,2,$local->emp_id) . $rswrk->fields('emp_razonsocial');
					$rswrk->Close();
				} else {
					$local->emp_id->ViewValue = $local->emp_id->CurrentValue;
				}
			} else {
				$local->emp_id->ViewValue = NULL;
			}
			$local->emp_id->ViewCustomAttributes = "";

			// loc_nombre
			$local->loc_nombre->ViewValue = $local->loc_nombre->CurrentValue;
			$local->loc_nombre->ViewCustomAttributes = "";

			// loc_direccion
			$local->loc_direccion->ViewValue = $local->loc_direccion->CurrentValue;
			$local->loc_direccion->ViewCustomAttributes = "";

			// loc_vigente
			if (strval($local->loc_vigente->CurrentValue) <> "") {
				switch ($local->loc_vigente->CurrentValue) {
					case "1":
						$local->loc_vigente->ViewValue = $local->loc_vigente->FldTagCaption(1) <> "" ? $local->loc_vigente->FldTagCaption(1) : $local->loc_vigente->CurrentValue;
						break;
					case "0":
						$local->loc_vigente->ViewValue = $local->loc_vigente->FldTagCaption(2) <> "" ? $local->loc_vigente->FldTagCaption(2) : $local->loc_vigente->CurrentValue;
						break;
					default:
						$local->loc_vigente->ViewValue = $local->loc_vigente->CurrentValue;
				}
			} else {
				$local->loc_vigente->ViewValue = NULL;
			}
			$local->loc_vigente->ViewCustomAttributes = "";

			// loc_comuna
			$local->loc_comuna->ViewValue = $local->loc_comuna->CurrentValue;
			$local->loc_comuna->ViewCustomAttributes = "";

			// loc_ciudad
			$local->loc_ciudad->ViewValue = $local->loc_ciudad->CurrentValue;
			$local->loc_ciudad->ViewCustomAttributes = "";

			// loc_id
			$local->loc_id->LinkCustomAttributes = "";
			$local->loc_id->HrefValue = "";
			$local->loc_id->TooltipValue = "";

			// emp_id
			$local->emp_id->LinkCustomAttributes = "";
			$local->emp_id->HrefValue = "";
			$local->emp_id->TooltipValue = "";

			// loc_nombre
			$local->loc_nombre->LinkCustomAttributes = "";
			$local->loc_nombre->HrefValue = "";
			$local->loc_nombre->TooltipValue = "";

			// loc_direccion
			$local->loc_direccion->LinkCustomAttributes = "";
			$local->loc_direccion->HrefValue = "";
			$local->loc_direccion->TooltipValue = "";

			// loc_vigente
			$local->loc_vigente->LinkCustomAttributes = "";
			$local->loc_vigente->HrefValue = "";
			$local->loc_vigente->TooltipValue = "";

			// loc_comuna
			$local->loc_comuna->LinkCustomAttributes = "";
			$local->loc_comuna->HrefValue = "";
			$local->loc_comuna->TooltipValue = "";

			// loc_ciudad
			$local->loc_ciudad->LinkCustomAttributes = "";
			$local->loc_ciudad->HrefValue = "";
			$local->loc_ciudad->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($local->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$local->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $local;
		$DeleteRows = TRUE;
		$sSql = $local->SQL();
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
				$DeleteRows = $local->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['loc_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($local->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($local->CancelMessage <> "") {
				$this->setFailureMessage($local->CancelMessage);
				$local->CancelMessage = "";
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
				$local->Row_Deleted($row);
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
