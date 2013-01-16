<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg8.php" ?>
<?php include_once "ewmysql8.php" ?>
<?php include_once "phpfn8.php" ?>
<?php include_once "cuponinfo.php" ?>
<?php include_once "userfn8.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
$cupon_delete = new ccupon_delete();
$Page =& $cupon_delete;

// Page init
$cupon_delete->Page_Init();

// Page main
$cupon_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var cupon_delete = new ew_Page("cupon_delete");

// page properties
cupon_delete.PageID = "delete"; // page ID
cupon_delete.FormID = "fcupondelete"; // form ID
var EW_PAGE_ID = cupon_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cupon_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cupon_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cupon_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cupon_delete.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php $cupon_delete->ShowPageHeader(); ?>
<?php

// Load records for display
if ($cupon_delete->Recordset = $cupon_delete->LoadRecordset())
	$cupon_deleteTotalRecs = $cupon_delete->Recordset->RecordCount(); // Get record count
if ($cupon_deleteTotalRecs <= 0) { // No record found, exit
	if ($cupon_delete->Recordset)
		$cupon_delete->Recordset->Close();
	$cupon_delete->Page_Terminate("cuponlist.php"); // Return to list
}
?>
<p class="phpmaker ewTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cupon->TableCaption() ?></p>
<p class="phpmaker"><a href="<?php echo $cupon->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php
$cupon_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="cupon">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cupon_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $cupon->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $cupon->cup_id->FldCaption() ?></td>
		<td valign="top"><?php echo $cupon->emp_id->FldCaption() ?></td>
		<td valign="top"><?php echo $cupon->cup_nombre->FldCaption() ?></td>
		<td valign="top"><?php echo $cupon->cup_preview_nombre->FldCaption() ?></td>
		<td valign="top"><?php echo $cupon->cup_imagen_nombre->FldCaption() ?></td>
		<td valign="top"><?php echo $cupon->cup_vigente->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$cupon_delete->RecCnt = 0;
$i = 0;
while (!$cupon_delete->Recordset->EOF) {
	$cupon_delete->RecCnt++;

	// Set row properties
	$cupon->ResetAttrs();
	$cupon->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cupon_delete->LoadRowValues($cupon_delete->Recordset);

	// Render row
	$cupon_delete->RenderRow();
?>
	<tr<?php echo $cupon->RowAttributes() ?>>
		<td<?php echo $cupon->cup_id->CellAttributes() ?>>
<div<?php echo $cupon->cup_id->ViewAttributes() ?>><?php echo $cupon->cup_id->ListViewValue() ?></div></td>
		<td<?php echo $cupon->emp_id->CellAttributes() ?>>
<div<?php echo $cupon->emp_id->ViewAttributes() ?>><?php echo $cupon->emp_id->ListViewValue() ?></div></td>
		<td<?php echo $cupon->cup_nombre->CellAttributes() ?>>
<div<?php echo $cupon->cup_nombre->ViewAttributes() ?>><?php echo $cupon->cup_nombre->ListViewValue() ?></div></td>
		<td<?php echo $cupon->cup_preview_nombre->CellAttributes() ?>>
<?php if ($cupon->cup_preview_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($cupon->cup_preview_nombre->Upload->DbValue)) { ?>
<a<?php echo $cupon->cup_preview_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_preview_nombre->UploadPath) . $cupon->cup_preview_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_preview_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($cupon->cup_preview_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_preview_nombre->UploadPath) . $cupon->cup_preview_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_preview_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</td>
		<td<?php echo $cupon->cup_imagen_nombre->CellAttributes() ?>>
<?php if ($cupon->cup_imagen_nombre->LinkAttributes() <> "") { ?>
<?php if (!empty($cupon->cup_imagen_nombre->Upload->DbValue)) { ?>
<a<?php echo $cupon->cup_imagen_nombre->LinkAttributes() ?>><img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_imagen_nombre->UploadPath) . $cupon->cup_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_imagen_nombre->ViewAttributes() ?>></a>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($cupon->cup_imagen_nombre->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $cupon->cup_imagen_nombre->UploadPath) . $cupon->cup_imagen_nombre->Upload->DbValue ?>" border=0<?php echo $cupon->cup_imagen_nombre->ViewAttributes() ?>>
<?php } elseif (!in_array($cupon->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</td>
		<td<?php echo $cupon->cup_vigente->CellAttributes() ?>>
<div<?php echo $cupon->cup_vigente->ViewAttributes() ?>><?php echo $cupon->cup_vigente->ListViewValue() ?></div></td>
	</tr>
<?php
	$cupon_delete->Recordset->MoveNext();
}
$cupon_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<?php
$cupon_delete->ShowPageFooter();
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
$cupon_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class ccupon_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'cupon';

	// Page object name
	var $PageObjName = 'cupon_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cupon;
		if ($cupon->UseTokenInUrl) $PageUrl .= "t=" . $cupon->TableVar . "&"; // Add page token
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
		global $objForm, $cupon;
		if ($cupon->UseTokenInUrl) {
			if ($objForm)
				return ($cupon->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cupon->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccupon_delete() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (cupon)
		if (!isset($GLOBALS["cupon"])) {
			$GLOBALS["cupon"] = new ccupon();
			$GLOBALS["Table"] =& $GLOBALS["cupon"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cupon', TRUE);

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
		global $cupon;

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
		global $Language, $cupon;

		// Load key parameters
		$this->RecKeys = $cupon->GetRecordKeys(); // Load record keys
		$sFilter = $cupon->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("cuponlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in cupon class, cuponinfo.php

		$cupon->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$cupon->CurrentAction = $_POST["a_delete"];
		} else {
			$cupon->CurrentAction = "D"; // Delete record directly
		}
		switch ($cupon->CurrentAction) {
			case "D": // Delete
				$cupon->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($cupon->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $cupon;

		// Call Recordset Selecting event
		$cupon->Recordset_Selecting($cupon->CurrentFilter);

		// Load List page SQL
		$sSql = $cupon->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$cupon->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cupon;
		$sFilter = $cupon->KeyFilter();

		// Call Row Selecting event
		$cupon->Row_Selecting($sFilter);

		// Load SQL based on filter
		$cupon->CurrentFilter = $sFilter;
		$sSql = $cupon->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$cupon->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $cupon;
		if (!$rs || $rs->EOF) return;
		$cupon->cup_id->setDbValue($rs->fields('cup_id'));
		$cupon->emp_id->setDbValue($rs->fields('emp_id'));
		$cupon->cup_nombre->setDbValue($rs->fields('cup_nombre'));
		$cupon->cup_preview_nombre->Upload->DbValue = $rs->fields('cup_preview_nombre');
		$cupon->cup_preview_tipo->setDbValue($rs->fields('cup_preview_tipo'));
		$cupon->cup_preview_ancho->setDbValue($rs->fields('cup_preview_ancho'));
		$cupon->cup_preview_alto->setDbValue($rs->fields('cup_preview_alto'));
		$cupon->cup_preview_size->setDbValue($rs->fields('cup_preview_size'));
		$cupon->cup_imagen_nombre->Upload->DbValue = $rs->fields('cup_imagen_nombre');
		$cupon->cup_imagen_tipo->setDbValue($rs->fields('cup_imagen_tipo'));
		$cupon->cup_imagen_ancho->setDbValue($rs->fields('cup_imagen_ancho'));
		$cupon->cup_imagen_alto->setDbValue($rs->fields('cup_imagen_alto'));
		$cupon->cup_imagen_size->setDbValue($rs->fields('cup_imagen_size'));
		$cupon->cup_vigente->setDbValue($rs->fields('cup_vigente'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $cupon;

		// Initialize URLs
		// Call Row_Rendering event

		$cupon->Row_Rendering();

		// Common render codes for all row types
		// cup_id
		// emp_id
		// cup_nombre
		// cup_preview_nombre
		// cup_preview_tipo
		// cup_preview_ancho
		// cup_preview_alto
		// cup_preview_size
		// cup_imagen_nombre
		// cup_imagen_tipo
		// cup_imagen_ancho
		// cup_imagen_alto
		// cup_imagen_size
		// cup_vigente

		if ($cupon->RowType == EW_ROWTYPE_VIEW) { // View row

			// cup_id
			$cupon->cup_id->ViewValue = $cupon->cup_id->CurrentValue;
			$cupon->cup_id->ViewCustomAttributes = "";

			// emp_id
			if (strval($cupon->emp_id->CurrentValue) <> "") {
				$sFilterWrk = "`emp_id` = " . ew_AdjustSql($cupon->emp_id->CurrentValue) . "";
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
					$cupon->emp_id->ViewValue = $rswrk->fields('emp_rut');
					$cupon->emp_id->ViewValue .= ew_ValueSeparator(0,1,$cupon->emp_id) . $rswrk->fields('emp_nomfantasia');
					$cupon->emp_id->ViewValue .= ew_ValueSeparator(0,2,$cupon->emp_id) . $rswrk->fields('emp_razonsocial');
					$rswrk->Close();
				} else {
					$cupon->emp_id->ViewValue = $cupon->emp_id->CurrentValue;
				}
			} else {
				$cupon->emp_id->ViewValue = NULL;
			}
			$cupon->emp_id->ViewCustomAttributes = "";

			// cup_nombre
			$cupon->cup_nombre->ViewValue = $cupon->cup_nombre->CurrentValue;
			$cupon->cup_nombre->ViewCustomAttributes = "";

			// cup_preview_nombre
			if (!ew_Empty($cupon->cup_preview_nombre->Upload->DbValue)) {
				$cupon->cup_preview_nombre->ViewValue = $cupon->cup_preview_nombre->Upload->DbValue;
				$cupon->cup_preview_nombre->ImageWidth = 100;
				$cupon->cup_preview_nombre->ImageHeight = 0;
				$cupon->cup_preview_nombre->ImageAlt = $cupon->cup_preview_nombre->FldAlt();
			} else {
				$cupon->cup_preview_nombre->ViewValue = "";
			}
			$cupon->cup_preview_nombre->ViewCustomAttributes = "";

			// cup_preview_ancho
			$cupon->cup_preview_ancho->ViewValue = $cupon->cup_preview_ancho->CurrentValue;
			$cupon->cup_preview_ancho->ViewValue = ew_FormatNumber($cupon->cup_preview_ancho->ViewValue, 0, -2, -2, -2);
			$cupon->cup_preview_ancho->ViewCustomAttributes = "";

			// cup_preview_alto
			$cupon->cup_preview_alto->ViewValue = $cupon->cup_preview_alto->CurrentValue;
			$cupon->cup_preview_alto->ViewValue = ew_FormatNumber($cupon->cup_preview_alto->ViewValue, 0, -2, -2, -2);
			$cupon->cup_preview_alto->ViewCustomAttributes = "";

			// cup_imagen_nombre
			if (!ew_Empty($cupon->cup_imagen_nombre->Upload->DbValue)) {
				$cupon->cup_imagen_nombre->ViewValue = $cupon->cup_imagen_nombre->Upload->DbValue;
				$cupon->cup_imagen_nombre->ImageWidth = 100;
				$cupon->cup_imagen_nombre->ImageHeight = 0;
				$cupon->cup_imagen_nombre->ImageAlt = $cupon->cup_imagen_nombre->FldAlt();
			} else {
				$cupon->cup_imagen_nombre->ViewValue = "";
			}
			$cupon->cup_imagen_nombre->ViewCustomAttributes = "";

			// cup_imagen_ancho
			$cupon->cup_imagen_ancho->ViewValue = $cupon->cup_imagen_ancho->CurrentValue;
			$cupon->cup_imagen_ancho->ViewValue = ew_FormatNumber($cupon->cup_imagen_ancho->ViewValue, 0, -2, -2, -2);
			$cupon->cup_imagen_ancho->ViewCustomAttributes = "";

			// cup_imagen_alto
			$cupon->cup_imagen_alto->ViewValue = $cupon->cup_imagen_alto->CurrentValue;
			$cupon->cup_imagen_alto->ViewValue = ew_FormatNumber($cupon->cup_imagen_alto->ViewValue, 0, -2, -2, -2);
			$cupon->cup_imagen_alto->ViewCustomAttributes = "";

			// cup_vigente
			if (strval($cupon->cup_vigente->CurrentValue) <> "") {
				switch ($cupon->cup_vigente->CurrentValue) {
					case "1":
						$cupon->cup_vigente->ViewValue = $cupon->cup_vigente->FldTagCaption(1) <> "" ? $cupon->cup_vigente->FldTagCaption(1) : $cupon->cup_vigente->CurrentValue;
						break;
					case "0":
						$cupon->cup_vigente->ViewValue = $cupon->cup_vigente->FldTagCaption(2) <> "" ? $cupon->cup_vigente->FldTagCaption(2) : $cupon->cup_vigente->CurrentValue;
						break;
					default:
						$cupon->cup_vigente->ViewValue = $cupon->cup_vigente->CurrentValue;
				}
			} else {
				$cupon->cup_vigente->ViewValue = NULL;
			}
			$cupon->cup_vigente->ViewCustomAttributes = "";

			// cup_id
			$cupon->cup_id->LinkCustomAttributes = "";
			$cupon->cup_id->HrefValue = "";
			$cupon->cup_id->TooltipValue = "";

			// emp_id
			$cupon->emp_id->LinkCustomAttributes = "";
			$cupon->emp_id->HrefValue = "";
			$cupon->emp_id->TooltipValue = "";

			// cup_nombre
			$cupon->cup_nombre->LinkCustomAttributes = "";
			$cupon->cup_nombre->HrefValue = "";
			$cupon->cup_nombre->TooltipValue = "";

			// cup_preview_nombre
			$cupon->cup_preview_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($cupon->cup_preview_nombre->Upload->DbValue)) {
				$cupon->cup_preview_nombre->HrefValue = ew_UploadPathEx(FALSE, $cupon->cup_preview_nombre->UploadPath) . ((!empty($cupon->cup_preview_nombre->ViewValue)) ? $cupon->cup_preview_nombre->ViewValue : $cupon->cup_preview_nombre->CurrentValue); // Add prefix/suffix
				$cupon->cup_preview_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($cupon->Export <> "") $cupon->cup_preview_nombre->HrefValue = ew_ConvertFullUrl($cupon->cup_preview_nombre->HrefValue);
			} else {
				$cupon->cup_preview_nombre->HrefValue = "";
			}
			$cupon->cup_preview_nombre->TooltipValue = "";

			// cup_imagen_nombre
			$cupon->cup_imagen_nombre->LinkCustomAttributes = "";
			if (!ew_Empty($cupon->cup_imagen_nombre->Upload->DbValue)) {
				$cupon->cup_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $cupon->cup_imagen_nombre->UploadPath) . ((!empty($cupon->cup_imagen_nombre->ViewValue)) ? $cupon->cup_imagen_nombre->ViewValue : $cupon->cup_imagen_nombre->CurrentValue); // Add prefix/suffix
				$cupon->cup_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
				if ($cupon->Export <> "") $cupon->cup_imagen_nombre->HrefValue = ew_ConvertFullUrl($cupon->cup_imagen_nombre->HrefValue);
			} else {
				$cupon->cup_imagen_nombre->HrefValue = "";
			}
			$cupon->cup_imagen_nombre->TooltipValue = "";

			// cup_vigente
			$cupon->cup_vigente->LinkCustomAttributes = "";
			$cupon->cup_vigente->HrefValue = "";
			$cupon->cup_vigente->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($cupon->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$cupon->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $cupon;
		$DeleteRows = TRUE;
		$sSql = $cupon->SQL();
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
				$DeleteRows = $cupon->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['cup_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($cupon->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($cupon->CancelMessage <> "") {
				$this->setFailureMessage($cupon->CancelMessage);
				$cupon->CancelMessage = "";
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
				$cupon->Row_Deleted($row);
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
