<?php

//
// Page class
//
class clocaladherido_grid {

	// Page ID
	var $PageID = 'grid';

	// Table name
	var $TableName = 'localadherido';

	// Page object name
	var $PageObjName = 'localadherido_grid';

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
	function clocaladherido_grid() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (localadherido)
		if (!isset($GLOBALS["localadherido"])) {
			$GLOBALS["localadherido"] = new clocaladherido();
			$GLOBALS["MasterTable"] =& $GLOBALS["Table"];
			$GLOBALS["Table"] =& $GLOBALS["localadherido"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'grid', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'localadherido', TRUE);

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
		global $localadherido;

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$localadherido->GridAddRowCount = $gridaddcnt;

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
		global $localadherido;
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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $localadherido;

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
			if ($localadherido->Export <> "" ||
				$localadherido->CurrentAction == "gridadd" ||
				$localadherido->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($localadherido->AllowAddDeleteRow) {
				if ($localadherido->CurrentAction == "gridadd" ||
					$localadherido->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($localadherido->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $localadherido->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $localadherido->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $localadherido->getDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($localadherido->getMasterFilter() <> "" && $localadherido->getCurrentMasterTable() == "cupon") {
			global $cupon;
			$rsmaster = $cupon->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate($localadherido->getReturnUrl()); // Return to caller
			} else {
				$cupon->LoadListRowValues($rsmaster);
				$cupon->RowType = EW_ROWTYPE_MASTER; // Master row
				$cupon->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$localadherido->setSessionWhere($sFilter);
		$localadherido->CurrentFilter = "";
	}

	//  Exit inline mode
	function ClearInlineMode() {
		global $localadherido;
		$localadherido->LastAction = $localadherido->CurrentAction; // Save last action
		$localadherido->CurrentAction = ""; // Clear action
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
		global $conn, $Language, $objForm, $gsFormError, $localadherido;
		$bGridUpdate = TRUE;

		// Get old recordset
		$localadherido->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $localadherido->SQL();
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
						$localadherido->CurrentFilter = $localadherido->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$localadherido->SendEmail = FALSE; // Do not send email on update success
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
			$localadherido->EventCancelled = TRUE; // Set event cancelled
			$localadherido->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm, $localadherido;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $localadherido->KeyFilter();
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
		global $localadherido;
		$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $key);
		if (count($arrKeyFlds) >= 1) {
			$localadherido->lad_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($localadherido->lad_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError, $localadherido;
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
				$localadherido->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow(); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
					$sKey .= $localadherido->lad_id->CurrentValue;

					// Add filter for this record
					$sFilter = $localadherido->KeyFilter();
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
			$localadherido->CurrentFilter = $sWrkFilter;
			$sSql = $localadherido->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
			$localadherido->EventCancelled = TRUE; // Set event cancelled
			$localadherido->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $localadherido, $objForm;
		if ($objForm->HasValue("x_cup_id") && $objForm->HasValue("o_cup_id") && $localadherido->cup_id->CurrentValue <> $localadherido->cup_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_emp_id") && $objForm->HasValue("o_emp_id") && $localadherido->emp_id->CurrentValue <> $localadherido->emp_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_loc_id") && $objForm->HasValue("o_loc_id") && $localadherido->loc_id->CurrentValue <> $localadherido->loc_id->OldValue)
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
		global $objForm, $localadherido;

		// Get row based on current index
		$objForm->Index = $idx;
		if ($localadherido->CurrentMode == "add")
			$this->LoadFormValues(); // Load form values
		if ($localadherido->CurrentMode == "edit") {
			$sKey = strval($objForm->GetValue("k_key"));
			$this->RowAction = strval($objForm->GetValue("k_action"));
			$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $sKey);
			if ($this->RowAction == "insert") {
				$this->LoadFormValues(); // Load form values
			} elseif (count($arrKeyFlds) >= 1) {
				if (strval($arrKeyFlds[0]) == strval($localadherido->lad_id->CurrentValue)) {
					$this->LoadFormValues(); // Load form values
				}
			}
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $localadherido;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$localadherido->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$localadherido->CurrentOrderType = @$_GET["ordertype"];
			$localadherido->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $localadherido;
		$sOrderBy = $localadherido->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($localadherido->SqlOrderBy() <> "") {
				$sOrderBy = $localadherido->SqlOrderBy();
				$localadherido->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $localadherido;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset master/detail keys
			if (strtolower($sCmd) == "resetall") {
				$localadherido->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$localadherido->cup_id->setSessionValue("");
			}

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$localadherido->setSessionOrderBy($sOrderBy);
			}

			// Reset start position
			$this->StartRec = 1;
			$localadherido->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $localadherido;

		// "griddelete"
		if ($localadherido->AllowAddDeleteRow) {
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
		global $Security, $Language, $localadherido, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if ($localadherido->RowType == EW_ROWTYPE_ADD)
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
		if ($localadherido->AllowAddDeleteRow) {
			if ($localadherido->CurrentMode == "add" || $localadherido->CurrentMode == "copy" || $localadherido->CurrentMode == "edit") {
				$oListOpt =& $this->ListOptions->Items["griddelete"];
				$oListOpt->Body = "<a href=\"javascript:void(0);\" onclick=\"ew_DeleteGridRow(this, localadherido_grid, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
			}
		}
		if ($localadherido->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . $localadherido->lad_id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $localadherido;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $localadherido;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$localadherido->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$localadherido->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $localadherido->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$localadherido->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$localadherido->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$localadherido->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $localadherido;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $localadherido;
		$localadherido->lad_id->CurrentValue = NULL;
		$localadherido->lad_id->OldValue = $localadherido->lad_id->CurrentValue;
		$localadherido->cup_id->CurrentValue = NULL;
		$localadherido->cup_id->OldValue = $localadherido->cup_id->CurrentValue;
		$localadherido->emp_id->CurrentValue = NULL;
		$localadherido->emp_id->OldValue = $localadherido->emp_id->CurrentValue;
		$localadherido->loc_id->CurrentValue = NULL;
		$localadherido->loc_id->OldValue = $localadherido->loc_id->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $localadherido;
		if (!$localadherido->lad_id->FldIsDetailKey) {
			$localadherido->lad_id->setFormValue($objForm->GetValue("x_lad_id"));
		}
		$localadherido->lad_id->setOldValue($objForm->GetValue("o_lad_id"));
		if (!$localadherido->cup_id->FldIsDetailKey) {
			$localadherido->cup_id->setFormValue($objForm->GetValue("x_cup_id"));
		}
		$localadherido->cup_id->setOldValue($objForm->GetValue("o_cup_id"));
		if (!$localadherido->emp_id->FldIsDetailKey) {
			$localadherido->emp_id->setFormValue($objForm->GetValue("x_emp_id"));
		}
		$localadherido->emp_id->setOldValue($objForm->GetValue("o_emp_id"));
		if (!$localadherido->loc_id->FldIsDetailKey) {
			$localadherido->loc_id->setFormValue($objForm->GetValue("x_loc_id"));
		}
		$localadherido->loc_id->setOldValue($objForm->GetValue("o_loc_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $localadherido;
		$localadherido->lad_id->CurrentValue = $localadherido->lad_id->FormValue;
		$localadherido->cup_id->CurrentValue = $localadherido->cup_id->FormValue;
		$localadherido->emp_id->CurrentValue = $localadherido->emp_id->FormValue;
		$localadherido->loc_id->CurrentValue = $localadherido->loc_id->FormValue;
	}

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
		$localadherido->cup_id->setDbValue($rs->fields('cup_id'));
		$localadherido->emp_id->setDbValue($rs->fields('emp_id'));
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
		// cup_id
		// emp_id
		// loc_id

		if ($localadherido->RowType == EW_ROWTYPE_VIEW) { // View row

			// lad_id
			$localadherido->lad_id->ViewValue = $localadherido->lad_id->CurrentValue;
			$localadherido->lad_id->ViewCustomAttributes = "";

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

			// cup_id
			$localadherido->cup_id->LinkCustomAttributes = "";
			$localadherido->cup_id->HrefValue = "";
			$localadherido->cup_id->TooltipValue = "";

			// emp_id
			$localadherido->emp_id->LinkCustomAttributes = "";
			$localadherido->emp_id->HrefValue = "";
			$localadherido->emp_id->TooltipValue = "";

			// loc_id
			$localadherido->loc_id->LinkCustomAttributes = "";
			$localadherido->loc_id->HrefValue = "";
			$localadherido->loc_id->TooltipValue = "";
		} elseif ($localadherido->RowType == EW_ROWTYPE_ADD) { // Add row

			// lad_id
			// cup_id

			$localadherido->cup_id->EditCustomAttributes = "";
			if ($localadherido->cup_id->getSessionValue() <> "") {
				$localadherido->cup_id->CurrentValue = $localadherido->cup_id->getSessionValue();
				$localadherido->cup_id->OldValue = $localadherido->cup_id->CurrentValue;
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
			} else {
			}

			// emp_id
			$localadherido->emp_id->EditCustomAttributes = "";

			// loc_id
			$localadherido->loc_id->EditCustomAttributes = "";

			// Edit refer script
			// lad_id

			$localadherido->lad_id->HrefValue = "";

			// cup_id
			$localadherido->cup_id->HrefValue = "";

			// emp_id
			$localadherido->emp_id->HrefValue = "";

			// loc_id
			$localadherido->loc_id->HrefValue = "";
		} elseif ($localadherido->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// lad_id
			$localadherido->lad_id->EditCustomAttributes = "";
			$localadherido->lad_id->EditValue = $localadherido->lad_id->CurrentValue;
			$localadherido->lad_id->ViewCustomAttributes = "";

			// cup_id
			$localadherido->cup_id->EditCustomAttributes = "";
			if ($localadherido->cup_id->getSessionValue() <> "") {
				$localadherido->cup_id->CurrentValue = $localadherido->cup_id->getSessionValue();
				$localadherido->cup_id->OldValue = $localadherido->cup_id->CurrentValue;
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
			} else {
			}

			// emp_id
			$localadherido->emp_id->EditCustomAttributes = "";

			// loc_id
			$localadherido->loc_id->EditCustomAttributes = "";

			// Edit refer script
			// lad_id

			$localadherido->lad_id->HrefValue = "";

			// cup_id
			$localadherido->cup_id->HrefValue = "";

			// emp_id
			$localadherido->emp_id->HrefValue = "";

			// loc_id
			$localadherido->loc_id->HrefValue = "";
		}
		if ($localadherido->RowType == EW_ROWTYPE_ADD ||
			$localadherido->RowType == EW_ROWTYPE_EDIT ||
			$localadherido->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$localadherido->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($localadherido->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$localadherido->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $localadherido;

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
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$localadherido->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $localadherido;
		$sFilter = $localadherido->KeyFilter();
		$localadherido->CurrentFilter = $sFilter;
		$sSql = $localadherido->SQL();
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
			$localadherido->cup_id->SetDbValueDef($rsnew, $localadherido->cup_id->CurrentValue, NULL, FALSE);

			// emp_id
			$localadherido->emp_id->SetDbValueDef($rsnew, $localadherido->emp_id->CurrentValue, NULL, FALSE);

			// loc_id
			$localadherido->loc_id->SetDbValueDef($rsnew, $localadherido->loc_id->CurrentValue, NULL, FALSE);

			// Call Row Updating event
			$bUpdateRow = $localadherido->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $conn->Execute($localadherido->UpdateSQL($rsnew));
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($localadherido->CancelMessage <> "") {
					$this->setFailureMessage($localadherido->CancelMessage);
					$localadherido->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$localadherido->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security, $localadherido;

		// Set up foreign key field value from Session
			if ($localadherido->getCurrentMasterTable() == "cupon") {
				$localadherido->cup_id->CurrentValue = $localadherido->cup_id->getSessionValue();
			}
		$rsnew = array();

		// cup_id
		$localadherido->cup_id->SetDbValueDef($rsnew, $localadherido->cup_id->CurrentValue, NULL, FALSE);

		// emp_id
		$localadherido->emp_id->SetDbValueDef($rsnew, $localadherido->emp_id->CurrentValue, NULL, FALSE);

		// loc_id
		$localadherido->loc_id->SetDbValueDef($rsnew, $localadherido->loc_id->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $localadherido->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($localadherido->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($localadherido->CancelMessage <> "") {
				$this->setFailureMessage($localadherido->CancelMessage);
				$localadherido->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$localadherido->lad_id->setDbValue($conn->Insert_ID());
			$rsnew['lad_id'] = $localadherido->lad_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$localadherido->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		global $localadherido;

		// Hide foreign keys
		$sMasterTblVar = $localadherido->getCurrentMasterTable();
		if ($sMasterTblVar == "cupon") {
			$localadherido->cup_id->Visible = FALSE;
			if ($GLOBALS["cupon"]->EventCancelled) $localadherido->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $localadherido->getMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $localadherido->getDetailFilter(); // Get detail filter
	}

	// PDF Export
	function ExportPDF($html) {
		echo($html);
		ew_DeleteTmpImages();
		exit();
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
