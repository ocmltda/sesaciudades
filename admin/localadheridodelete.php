<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "localadheridoinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$localadherido_delete = new clocaladherido_delete();
$Page =& $localadherido_delete;

// Page init
$localadherido_delete->Page_Init();

// Page main
$localadherido_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var localadherido_delete = new ew_Page("localadherido_delete");

// page properties
localadherido_delete.PageID = "delete"; // page ID
localadherido_delete.FormID = "flocaladheridodelete"; // form ID
var EW_PAGE_ID = localadherido_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
localadherido_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
localadherido_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
localadherido_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
localadherido_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $localadherido_delete->ShowPageHeader(); ?>
<?php

// Load records for display
if ($localadherido_delete->Recordset = $localadherido_delete->LoadRecordset())
	$localadherido_deleteTotalRecs = $localadherido_delete->Recordset->RecordCount(); // Get record count
if ($localadherido_deleteTotalRecs <= 0) { // No record found, exit
	if ($localadherido_delete->Recordset)
		$localadherido_delete->Recordset->Close();
	$localadherido_delete->Page_Terminate("localadheridolist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $localadherido->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $localadherido->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$localadherido_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="localadherido">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($localadherido_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $localadherido->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $localadherido->lad_id->FldCaption() ?></td>
		<td valign="top"><?php echo $localadherido->emp_id->FldCaption() ?></td>
		<td valign="top"><?php echo $localadherido->cup_id->FldCaption() ?></td>
		<td valign="top"><?php echo $localadherido->loc_id->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$localadherido_delete->RecCnt = 0;
$i = 0;
while (!$localadherido_delete->Recordset->EOF) {
	$localadherido_delete->RecCnt++;

	// Set row properties
	$localadherido->ResetAttrs();
	$localadherido->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$localadherido_delete->LoadRowValues($localadherido_delete->Recordset);

	// Render row
	$localadherido_delete->RenderRow();
?>
	<tr<?php echo $localadherido->RowAttributes() ?>>
		<td<?php echo $localadherido->lad_id->CellAttributes() ?>>
<div<?php echo $localadherido->lad_id->ViewAttributes() ?>><?php echo $localadherido->lad_id->ListViewValue() ?></div></td>
		<td<?php echo $localadherido->emp_id->CellAttributes() ?>>
<div<?php echo $localadherido->emp_id->ViewAttributes() ?>><?php echo $localadherido->emp_id->ListViewValue() ?></div></td>
		<td<?php echo $localadherido->cup_id->CellAttributes() ?>>
<div<?php echo $localadherido->cup_id->ViewAttributes() ?>><?php echo $localadherido->cup_id->ListViewValue() ?></div></td>
		<td<?php echo $localadherido->loc_id->CellAttributes() ?>>
<div<?php echo $localadherido->loc_id->ViewAttributes() ?>><?php echo $localadherido->loc_id->ListViewValue() ?></div></td>
	</tr>
<?php
	$localadherido_delete->Recordset->MoveNext();
}
$localadherido_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$localadherido_delete->ShowPageFooter();
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
$localadherido_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class clocaladherido_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'localadherido';

	// Page object name
	var $PageObjName = 'localadherido_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $localadherido;
		if ($localadherido->UseTokenInUrl) $PageUrl .= "t=" . $localadherido->TableVar . "&"; // Add page token
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
		global $objForm, $localadherido;
		if ($localadherido->UseTokenInUrl) {
			if ($objForm)
				return ($localadherido->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($localadherido->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function clocaladherido_delete() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (localadherido)
		if (!isset($GLOBALS["localadherido"])) {
			$GLOBALS["localadherido"] = new clocaladherido();
			$GLOBALS["Table"] =& $GLOBALS["localadherido"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'localadherido', TRUE);

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
		global $localadherido;

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
		global $Language, $localadherido;

		// Load key parameters
		$this->RecKeys = $localadherido->GetRecordKeys(); // Load record keys
		$sFilter = $localadherido->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("localadheridolist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in localadherido class, localadheridoinfo.php

		$localadherido->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$localadherido->CurrentAction = $_POST["a_delete"];
		} else {
			$localadherido->CurrentAction = "D"; // Delete record directly
		}
		switch ($localadherido->CurrentAction) {
			case "D": // Delete
				$localadherido->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($localadherido->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $localadherido;

		// Call Recordset Selecting event
		$localadherido->Recordset_Selecting($localadherido->CurrentFilter);

		// Load List page SQL
		$sSql = $localadherido->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$localadherido->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $localadherido;
		$sFilter = $localadherido->KeyFilter();

		// Call Row Selecting event
		$localadherido->Row_Selecting($sFilter);

		// Load SQL based on filter
		$localadherido->CurrentFilter = $sFilter;
		$sSql = $localadherido->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$localadherido->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $localadherido;
		if (!$rs || $rs->EOF) return;
		$localadherido->lad_id->setDbValue($rs->fields('lad_id'));
		$localadherido->emp_id->setDbValue($rs->fields('emp_id'));
		$localadherido->cup_id->setDbValue($rs->fields('cup_id'));
		$localadherido->loc_id->setDbValue($rs->fields('loc_id'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $localadherido;

		// Initialize URLs
		// Call Row_Rendering event

		$localadherido->Row_Rendering();

		// Common render codes for all row types
		// lad_id
		// emp_id
		// cup_id
		// loc_id

		if ($localadherido->RowType == EW_ROWTYPE_VIEW) { // View row

			// lad_id
			$localadherido->lad_id->ViewValue = $localadherido->lad_id->CurrentValue;
			$localadherido->lad_id->ViewCustomAttributes = "";

			// emp_id
			if (strval($localadherido->emp_id->CurrentValue) <> "") {
				$sFilterWrk = "`emp_id` = " . ew_AdjustSql($localadherido->emp_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `emp_nomfantasia`, `emp_rut` FROM `empresa`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `emp_nomfantasia` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$localadherido->emp_id->ViewValue = $rswrk->fields('emp_nomfantasia');
					$localadherido->emp_id->ViewValue .= ew_ValueSeparator(0,1,$localadherido->emp_id) . $rswrk->fields('emp_rut');
					$rswrk->Close();
				} else {
					$localadherido->emp_id->ViewValue = $localadherido->emp_id->CurrentValue;
				}
			} else {
				$localadherido->emp_id->ViewValue = NULL;
			}
			$localadherido->emp_id->ViewCustomAttributes = "";

			// cup_id
			if (strval($localadherido->cup_id->CurrentValue) <> "") {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($localadherido->cup_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cup_nombre` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `cup_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$localadherido->cup_id->ViewValue = $rswrk->fields('cup_nombre');
					$rswrk->Close();
				} else {
					$localadherido->cup_id->ViewValue = $localadherido->cup_id->CurrentValue;
				}
			} else {
				$localadherido->cup_id->ViewValue = NULL;
			}
			$localadherido->cup_id->ViewCustomAttributes = "";

			// loc_id
			if (strval($localadherido->loc_id->CurrentValue) <> "") {
				$sFilterWrk = "`loc_id` = " . ew_AdjustSql($localadherido->loc_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `loc_nombre`, `loc_direccion` FROM `local`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `loc_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$localadherido->loc_id->ViewValue = $rswrk->fields('loc_nombre');
					$localadherido->loc_id->ViewValue .= ew_ValueSeparator(0,1,$localadherido->loc_id) . $rswrk->fields('loc_direccion');
					$rswrk->Close();
				} else {
					$localadherido->loc_id->ViewValue = $localadherido->loc_id->CurrentValue;
				}
			} else {
				$localadherido->loc_id->ViewValue = NULL;
			}
			$localadherido->loc_id->ViewCustomAttributes = "";

			// lad_id
			$localadherido->lad_id->LinkCustomAttributes = "";
			$localadherido->lad_id->HrefValue = "";
			$localadherido->lad_id->TooltipValue = "";

			// emp_id
			$localadherido->emp_id->LinkCustomAttributes = "";
			$localadherido->emp_id->HrefValue = "";
			$localadherido->emp_id->TooltipValue = "";

			// cup_id
			$localadherido->cup_id->LinkCustomAttributes = "";
			$localadherido->cup_id->HrefValue = "";
			$localadherido->cup_id->TooltipValue = "";

			// loc_id
			$localadherido->loc_id->LinkCustomAttributes = "";
			$localadherido->loc_id->HrefValue = "";
			$localadherido->loc_id->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($localadherido->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$localadherido->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $localadherido;
		$DeleteRows = TRUE;
		$sSql = $localadherido->SQL();
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
				$DeleteRows = $localadherido->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['lad_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($localadherido->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($localadherido->CancelMessage <> "") {
				$this->setFailureMessage($localadherido->CancelMessage);
				$localadherido->CancelMessage = "";
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
				$localadherido->Row_Deleted($row);
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
