<?php

//
// Page class
//
class ccupon_categ_grid {

	// Page ID
	var $PageID = 'grid';

	// Table name
	var $TableName = 'cupon_categ';

	// Page object name
	var $PageObjName = 'cupon_categ_grid';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cupon_categ;
		if ($cupon_categ->UseTokenInUrl) $PageUrl .= "t=" . $cupon_categ->TableVar . "&"; // Add page token
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
		global $objForm, $cupon_categ;
		if ($cupon_categ->UseTokenInUrl) {
			if ($objForm)
				return ($cupon_categ->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cupon_categ->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccupon_categ_grid() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (cupon_categ)
		if (!isset($GLOBALS["cupon_categ"])) {
			$GLOBALS["cupon_categ"] = new ccupon_categ();
			$GLOBALS["MasterTable"] =& $GLOBALS["Table"];
			$GLOBALS["Table"] =& $GLOBALS["cupon_categ"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'grid', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cupon_categ', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $cupon_categ;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$cupon_categ->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

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
		global $cupon_categ;
		$GLOBALS["Table"] =& $GLOBALS["MasterTable"];
		if ($url == "")
			return;

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Go to URL if specified
		$this->Page_Redirecting($url);
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $RowCnt;
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RecPerRow = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $RestoreSearch;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $cupon_categ;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set up master detail parameters
			$this->SetUpMasterParms();

			// Hide all options
			if ($cupon_categ->Export <> "" ||
				$cupon_categ->CurrentAction == "gridadd" ||
				$cupon_categ->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($cupon_categ->AllowAddDeleteRow) {
				if ($cupon_categ->CurrentAction == "gridadd" ||
					$cupon_categ->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($cupon_categ->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $cupon_categ->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $cupon_categ->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $cupon_categ->getDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($cupon_categ->getMasterFilter() <> "" && $cupon_categ->getCurrentMasterTable() == "cupon") {
			global $cupon;
			$rsmaster = $cupon->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate($cupon_categ->getReturnUrl()); // Return to caller
			} else {
				$cupon->LoadListRowValues($rsmaster);
				$cupon->RowType = EW_ROWTYPE_MASTER; // Master row
				$cupon->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$cupon_categ->setSessionWhere($sFilter);
		$cupon_categ->CurrentFilter = "";
	}

	//  Exit inline mode
	function ClearInlineMode() {
		global $cupon_categ;
		$cupon_categ->LastAction = $cupon_categ->CurrentAction; // Save last action
		$cupon_categ->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $conn, $Language, $objForm, $gsFormError, $cupon_categ;
		$bGridUpdate = TRUE;

		// Get old recordset
		$cupon_categ->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $cupon_categ->SQL();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = 0;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue("k_key"));
			$rowaction = strval($objForm->GetValue("k_action"));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$cupon_categ->CurrentFilter = $cupon_categ->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$cupon_categ->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$cupon_categ->EventCancelled = TRUE; // Set event cancelled
			$cupon_categ->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm, $cupon_categ;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $cupon_categ->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		global $cupon_categ;
		$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $key);
		if (count($arrKeyFlds) >= 1) {
			$cupon_categ->cct_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($cupon_categ->cct_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError, $cupon_categ;
		$rowindex = 1;
		$bGridInsert = FALSE;

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = 0;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue("k_action"));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$cupon_categ->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow(); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
					$sKey .= $cupon_categ->cct_id->CurrentValue;

					// Add filter for this record
					$sFilter = $cupon_categ->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->ClearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($bGridInsert) {

			// Get new recordset
			$cupon_categ->CurrentFilter = $sWrkFilter;
			$sSql = $cupon_categ->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
			$cupon_categ->EventCancelled = TRUE; // Set event cancelled
			$cupon_categ->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $cupon_categ, $objForm;
		if ($objForm->HasValue("x_cup_id") && $objForm->HasValue("o_cup_id") && $cupon_categ->cup_id->CurrentValue <> $cupon_categ->cup_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_cat_id") && $objForm->HasValue("o_cat_id") && $cupon_categ->cat_id->CurrentValue <> $cupon_categ->cat_id->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = 0;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue("k_action"));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm, $cupon_categ;

		// Get row based on current index
		$objForm->Index = $idx;
		if ($cupon_categ->CurrentMode == "add")
			$this->LoadFormValues(); // Load form values
		if ($cupon_categ->CurrentMode == "edit") {
			$sKey = strval($objForm->GetValue("k_key"));
			$this->RowAction = strval($objForm->GetValue("k_action"));
			$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $sKey);
			if ($this->RowAction == "insert") {
				$this->LoadFormValues(); // Load form values
			} elseif (count($arrKeyFlds) >= 1) {
				if (strval($arrKeyFlds[0]) == strval($cupon_categ->cct_id->CurrentValue)) {
					$this->LoadFormValues(); // Load form values
				}
			}
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $cupon_categ;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$cupon_categ->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$cupon_categ->CurrentOrderType = @$_GET["ordertype"];
			$cupon_categ->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $cupon_categ;
		$sOrderBy = $cupon_categ->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($cupon_categ->SqlOrderBy() <> "") {
				$sOrderBy = $cupon_categ->SqlOrderBy();
				$cupon_categ->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $cupon_categ;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset master/detail keys
			if (strtolower($sCmd) == "resetall") {
				$cupon_categ->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$cupon_categ->cup_id->setSessionValue("");
			}

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$cupon_categ->setSessionOrderBy($sOrderBy);
			}

			// Reset start position
			$this->StartRec = 1;
			$cupon_categ->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $cupon_categ;

		// "griddelete"
		if ($cupon_categ->AllowAddDeleteRow) {
			$item =& $this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $cupon_categ, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if ($cupon_categ->RowType == EW_ROWTYPE_ADD)
			$this->RowAction = "insert";
		else
			$this->RowAction = "";
		if (is_numeric($this->RowIndex)) {
			$objForm->Index = $this->RowIndex;
			if ($objForm->HasValue("k_action"))
				$this->RowAction = strval($objForm->GetValue("k_action"));
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_action\" id=\"k" . $this->RowIndex . "_action\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue("k_key");
				$this->SetupKeyValues($rowkey);
			}
		}

		// "delete"
		if ($cupon_categ->AllowAddDeleteRow) {
			if ($cupon_categ->CurrentMode == "add" || $cupon_categ->CurrentMode == "copy" || $cupon_categ->CurrentMode == "edit") {
				$oListOpt =& $this->ListOptions->Items["griddelete"];
				$oListOpt->Body = "<a href=\"javascript:void(0);\" onclick=\"ew_DeleteGridRow(this, cupon_categ_grid, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
			}
		}
		if ($cupon_categ->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . $cupon_categ->cct_id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $cupon_categ;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $cupon_categ;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$cupon_categ->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$cupon_categ->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $cupon_categ->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$cupon_categ->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$cupon_categ->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$cupon_categ->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $cupon_categ;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $cupon_categ;
		$cupon_categ->cct_id->CurrentValue = NULL;
		$cupon_categ->cct_id->OldValue = $cupon_categ->cct_id->CurrentValue;
		$cupon_categ->cup_id->CurrentValue = NULL;
		$cupon_categ->cup_id->OldValue = $cupon_categ->cup_id->CurrentValue;
		$cupon_categ->cat_id->CurrentValue = NULL;
		$cupon_categ->cat_id->OldValue = $cupon_categ->cat_id->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $cupon_categ;
		if (!$cupon_categ->cct_id->FldIsDetailKey) {
			$cupon_categ->cct_id->setFormValue($objForm->GetValue("x_cct_id"));
		}
		$cupon_categ->cct_id->setOldValue($objForm->GetValue("o_cct_id"));
		if (!$cupon_categ->cup_id->FldIsDetailKey) {
			$cupon_categ->cup_id->setFormValue($objForm->GetValue("x_cup_id"));
		}
		$cupon_categ->cup_id->setOldValue($objForm->GetValue("o_cup_id"));
		if (!$cupon_categ->cat_id->FldIsDetailKey) {
			$cupon_categ->cat_id->setFormValue($objForm->GetValue("x_cat_id"));
		}
		$cupon_categ->cat_id->setOldValue($objForm->GetValue("o_cat_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $cupon_categ;
		$cupon_categ->cct_id->CurrentValue = $cupon_categ->cct_id->FormValue;
		$cupon_categ->cup_id->CurrentValue = $cupon_categ->cup_id->FormValue;
		$cupon_categ->cat_id->CurrentValue = $cupon_categ->cat_id->FormValue;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $cupon_categ;

		// Call Recordset Selecting event
		$cupon_categ->Recordset_Selecting($cupon_categ->CurrentFilter);

		// Load List page SQL
		$sSql = $cupon_categ->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$cupon_categ->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cupon_categ;
		$sFilter = $cupon_categ->KeyFilter();

		// Call Row Selecting event
		$cupon_categ->Row_Selecting($sFilter);

		// Load SQL based on filter
		$cupon_categ->CurrentFilter = $sFilter;
		$sSql = $cupon_categ->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$row = $rs->fields;
			$cupon_categ->Row_Selected($row);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $cupon_categ;
		if (!$rs || $rs->EOF) return;
		$cupon_categ->cct_id->setDbValue($rs->fields('cct_id'));
		$cupon_categ->cup_id->setDbValue($rs->fields('cup_id'));
		$cupon_categ->cat_id->setDbValue($rs->fields('cat_id'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $cupon_categ;

		// Initialize URLs
		// Call Row_Rendering event

		$cupon_categ->Row_Rendering();

		// Common render codes for all row types
		// cct_id
		// cup_id
		// cat_id

		if ($cupon_categ->RowType == EW_ROWTYPE_VIEW) { // View row

			// cct_id
			$cupon_categ->cct_id->ViewValue = $cupon_categ->cct_id->CurrentValue;
			$cupon_categ->cct_id->ViewCustomAttributes = "";

			// cup_id
			if (strval($cupon_categ->cup_id->CurrentValue) <> "") {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($cupon_categ->cup_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cup_nombre` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$cupon_categ->cup_id->ViewValue = $rswrk->fields('cup_nombre');
					$rswrk->Close();
				} else {
					$cupon_categ->cup_id->ViewValue = $cupon_categ->cup_id->CurrentValue;
				}
			} else {
				$cupon_categ->cup_id->ViewValue = NULL;
			}
			$cupon_categ->cup_id->ViewCustomAttributes = "";

			// cat_id
			if (strval($cupon_categ->cat_id->CurrentValue) <> "") {
				$sFilterWrk = "`cat_id` = " . ew_AdjustSql($cupon_categ->cat_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cat_nombre` FROM `categoria`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `cat_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$cupon_categ->cat_id->ViewValue = $rswrk->fields('cat_nombre');
					$rswrk->Close();
				} else {
					$cupon_categ->cat_id->ViewValue = $cupon_categ->cat_id->CurrentValue;
				}
			} else {
				$cupon_categ->cat_id->ViewValue = NULL;
			}
			$cupon_categ->cat_id->ViewCustomAttributes = "";

			// cct_id
			$cupon_categ->cct_id->LinkCustomAttributes = "";
			$cupon_categ->cct_id->HrefValue = "";
			$cupon_categ->cct_id->TooltipValue = "";

			// cup_id
			$cupon_categ->cup_id->LinkCustomAttributes = "";
			$cupon_categ->cup_id->HrefValue = "";
			$cupon_categ->cup_id->TooltipValue = "";

			// cat_id
			$cupon_categ->cat_id->LinkCustomAttributes = "";
			$cupon_categ->cat_id->HrefValue = "";
			$cupon_categ->cat_id->TooltipValue = "";
		} elseif ($cupon_categ->RowType == EW_ROWTYPE_ADD) { // Add row

			// cct_id
			// cup_id

			$cupon_categ->cup_id->EditCustomAttributes = "";
			if ($cupon_categ->cup_id->getSessionValue() <> "") {
				$cupon_categ->cup_id->CurrentValue = $cupon_categ->cup_id->getSessionValue();
				$cupon_categ->cup_id->OldValue = $cupon_categ->cup_id->CurrentValue;
			if (strval($cupon_categ->cup_id->CurrentValue) <> "") {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($cupon_categ->cup_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cup_nombre` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$cupon_categ->cup_id->ViewValue = $rswrk->fields('cup_nombre');
					$rswrk->Close();
				} else {
					$cupon_categ->cup_id->ViewValue = $cupon_categ->cup_id->CurrentValue;
				}
			} else {
				$cupon_categ->cup_id->ViewValue = NULL;
			}
			$cupon_categ->cup_id->ViewCustomAttributes = "";
			} else {
			}

			// cat_id
			$cupon_categ->cat_id->EditCustomAttributes = "";

			// Edit refer script
			// cct_id

			$cupon_categ->cct_id->HrefValue = "";

			// cup_id
			$cupon_categ->cup_id->HrefValue = "";

			// cat_id
			$cupon_categ->cat_id->HrefValue = "";
		} elseif ($cupon_categ->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// cct_id
			$cupon_categ->cct_id->EditCustomAttributes = "";
			$cupon_categ->cct_id->EditValue = $cupon_categ->cct_id->CurrentValue;
			$cupon_categ->cct_id->ViewCustomAttributes = "";

			// cup_id
			$cupon_categ->cup_id->EditCustomAttributes = "";
			if ($cupon_categ->cup_id->getSessionValue() <> "") {
				$cupon_categ->cup_id->CurrentValue = $cupon_categ->cup_id->getSessionValue();
				$cupon_categ->cup_id->OldValue = $cupon_categ->cup_id->CurrentValue;
			if (strval($cupon_categ->cup_id->CurrentValue) <> "") {
				$sFilterWrk = "`cup_id` = " . ew_AdjustSql($cupon_categ->cup_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `cup_nombre` FROM `cupon`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$cupon_categ->cup_id->ViewValue = $rswrk->fields('cup_nombre');
					$rswrk->Close();
				} else {
					$cupon_categ->cup_id->ViewValue = $cupon_categ->cup_id->CurrentValue;
				}
			} else {
				$cupon_categ->cup_id->ViewValue = NULL;
			}
			$cupon_categ->cup_id->ViewCustomAttributes = "";
			} else {
			}

			// cat_id
			$cupon_categ->cat_id->EditCustomAttributes = "";

			// Edit refer script
			// cct_id

			$cupon_categ->cct_id->HrefValue = "";

			// cup_id
			$cupon_categ->cup_id->HrefValue = "";

			// cat_id
			$cupon_categ->cat_id->HrefValue = "";
		}
		if ($cupon_categ->RowType == EW_ROWTYPE_ADD ||
			$cupon_categ->RowType == EW_ROWTYPE_EDIT ||
			$cupon_categ->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$cupon_categ->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($cupon_categ->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$cupon_categ->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $cupon_categ;

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $cupon_categ;
		$DeleteRows = TRUE;
		$sSql = $cupon_categ->SQL();
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

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $cupon_categ->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['cct_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($cupon_categ->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($cupon_categ->CancelMessage <> "") {
				$this->setFailureMessage($cupon_categ->CancelMessage);
				$cupon_categ->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$cupon_categ->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $cupon_categ;
		$sFilter = $cupon_categ->KeyFilter();
		$cupon_categ->CurrentFilter = $sFilter;
		$sSql = $cupon_categ->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// cup_id
			$cupon_categ->cup_id->SetDbValueDef($rsnew, $cupon_categ->cup_id->CurrentValue, NULL, FALSE);

			// cat_id
			$cupon_categ->cat_id->SetDbValueDef($rsnew, $cupon_categ->cat_id->CurrentValue, NULL, FALSE);

			// Call Row Updating event
			$bUpdateRow = $cupon_categ->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $conn->Execute($cupon_categ->UpdateSQL($rsnew));
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($cupon_categ->CancelMessage <> "") {
					$this->setFailureMessage($cupon_categ->CancelMessage);
					$cupon_categ->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$cupon_categ->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security, $cupon_categ;

		// Set up foreign key field value from Session
			if ($cupon_categ->getCurrentMasterTable() == "cupon") {
				$cupon_categ->cup_id->CurrentValue = $cupon_categ->cup_id->getSessionValue();
			}
		$rsnew = array();

		// cup_id
		$cupon_categ->cup_id->SetDbValueDef($rsnew, $cupon_categ->cup_id->CurrentValue, NULL, FALSE);

		// cat_id
		$cupon_categ->cat_id->SetDbValueDef($rsnew, $cupon_categ->cat_id->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $cupon_categ->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($cupon_categ->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($cupon_categ->CancelMessage <> "") {
				$this->setFailureMessage($cupon_categ->CancelMessage);
				$cupon_categ->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$cupon_categ->cct_id->setDbValue($conn->Insert_ID());
			$rsnew['cct_id'] = $cupon_categ->cct_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$cupon_categ->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		global $cupon_categ;

		// Hide foreign keys
		$sMasterTblVar = $cupon_categ->getCurrentMasterTable();
		if ($sMasterTblVar == "cupon") {
			$cupon_categ->cup_id->Visible = FALSE;
			if ($GLOBALS["cupon"]->EventCancelled) $cupon_categ->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $cupon_categ->getMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $cupon_categ->getDetailFilter(); // Get detail filter
	}

	// Export PDF
	function ExportPDF($html) {
		global $gsExportFile;
		include_once "dompdf060b2/dompdf_config.inc.php";
		@ini_set("memory_limit", EW_PDF_MEMORY_LIMIT);
		set_time_limit(EW_PDF_TIME_LIMIT);
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper("", "");
		$dompdf->render();
		ob_end_clean();
		ew_DeleteTmpImages();
		$dompdf->stream($gsExportFile . ".pdf", array("Attachment" => 1)); // 0 to open in browser, 1 to download

//		exit();
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt =& $this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>
