<?php

//
// Page class
//
class clocal_grid {

	// Page ID
	var $PageID = 'grid';

	// Table name
	var $TableName = 'local';

	// Page object name
	var $PageObjName = 'local_grid';

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
	function clocal_grid() {
		global $conn, $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Table object (local)
		if (!isset($GLOBALS["local"])) {
			$GLOBALS["local"] = new clocal();
			$GLOBALS["MasterTable"] =& $GLOBALS["Table"];
			$GLOBALS["Table"] =& $GLOBALS["local"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'grid', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'local', TRUE);

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
		global $local;

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
			$local->GridAddRowCount = $gridaddcnt;

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
		global $local;
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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $local;

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
			if ($local->Export <> "" ||
				$local->CurrentAction == "gridadd" ||
				$local->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($local->AllowAddDeleteRow) {
				if ($local->CurrentAction == "gridadd" ||
					$local->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($local->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $local->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $local->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $local->getDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($local->getMasterFilter() <> "" && $local->getCurrentMasterTable() == "empresa") {
			global $empresa;
			$rsmaster = $empresa->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate($local->getReturnUrl()); // Return to caller
			} else {
				$empresa->LoadListRowValues($rsmaster);
				$empresa->RowType = EW_ROWTYPE_MASTER; // Master row
				$empresa->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$local->setSessionWhere($sFilter);
		$local->CurrentFilter = "";
	}

	//  Exit inline mode
	function ClearInlineMode() {
		global $local;
		$local->LastAction = $local->CurrentAction; // Save last action
		$local->CurrentAction = ""; // Clear action
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
		global $conn, $Language, $objForm, $gsFormError, $local;
		$bGridUpdate = TRUE;

		// Get old recordset
		$local->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $local->SQL();
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
						$local->CurrentFilter = $local->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$local->SendEmail = FALSE; // Do not send email on update success
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
			$local->EventCancelled = TRUE; // Set event cancelled
			$local->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm, $local;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $local->KeyFilter();
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
		global $local;
		$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $key);
		if (count($arrKeyFlds) >= 1) {
			$local->loc_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($local->loc_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError, $local;
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
				$local->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow(); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
					$sKey .= $local->loc_id->CurrentValue;

					// Add filter for this record
					$sFilter = $local->KeyFilter();
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
			$local->CurrentFilter = $sWrkFilter;
			$sSql = $local->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
			$local->EventCancelled = TRUE; // Set event cancelled
			$local->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $local, $objForm;
		if ($objForm->HasValue("x_com_id") && $objForm->HasValue("o_com_id") && $local->com_id->CurrentValue <> $local->com_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_emp_id") && $objForm->HasValue("o_emp_id") && $local->emp_id->CurrentValue <> $local->emp_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_loc_nombre") && $objForm->HasValue("o_loc_nombre") && $local->loc_nombre->CurrentValue <> $local->loc_nombre->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_loc_direccion") && $objForm->HasValue("o_loc_direccion") && $local->loc_direccion->CurrentValue <> $local->loc_direccion->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_loc_vigente") && $objForm->HasValue("o_loc_vigente") && $local->loc_vigente->CurrentValue <> $local->loc_vigente->OldValue)
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
		global $objForm, $local;

		// Get row based on current index
		$objForm->Index = $idx;
		if ($local->CurrentMode == "add")
			$this->LoadFormValues(); // Load form values
		if ($local->CurrentMode == "edit") {
			$sKey = strval($objForm->GetValue("k_key"));
			$this->RowAction = strval($objForm->GetValue("k_action"));
			$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $sKey);
			if ($this->RowAction == "insert") {
				$this->LoadFormValues(); // Load form values
			} elseif (count($arrKeyFlds) >= 1) {
				if (strval($arrKeyFlds[0]) == strval($local->loc_id->CurrentValue)) {
					$this->LoadFormValues(); // Load form values
				}
			}
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $local;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$local->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$local->CurrentOrderType = @$_GET["ordertype"];
			$local->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $local;
		$sOrderBy = $local->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($local->SqlOrderBy() <> "") {
				$sOrderBy = $local->SqlOrderBy();
				$local->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $local;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset master/detail keys
			if (strtolower($sCmd) == "resetall") {
				$local->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$local->emp_id->setSessionValue("");
			}

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$local->setSessionOrderBy($sOrderBy);
			}

			// Reset start position
			$this->StartRec = 1;
			$local->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language, $local;

		// "griddelete"
		if ($local->AllowAddDeleteRow) {
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
		global $Security, $Language, $local, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if ($local->RowType == EW_ROWTYPE_ADD)
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
		if ($local->AllowAddDeleteRow) {
			if ($local->CurrentMode == "add" || $local->CurrentMode == "copy" || $local->CurrentMode == "edit") {
				$oListOpt =& $this->ListOptions->Items["griddelete"];
				$oListOpt->Body = "<a href=\"javascript:void(0);\" onclick=\"ew_DeleteGridRow(this, local_grid, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
			}
		}
		if ($local->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . $local->loc_id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $local;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $local;
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$local->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$local->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $local->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$local->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$local->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$local->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $local;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $local;
		$local->loc_id->CurrentValue = NULL;
		$local->loc_id->OldValue = $local->loc_id->CurrentValue;
		$local->com_id->CurrentValue = NULL;
		$local->com_id->OldValue = $local->com_id->CurrentValue;
		$local->emp_id->CurrentValue = NULL;
		$local->emp_id->OldValue = $local->emp_id->CurrentValue;
		$local->loc_nombre->CurrentValue = NULL;
		$local->loc_nombre->OldValue = $local->loc_nombre->CurrentValue;
		$local->loc_direccion->CurrentValue = NULL;
		$local->loc_direccion->OldValue = $local->loc_direccion->CurrentValue;
		$local->loc_vigente->CurrentValue = 1;
		$local->loc_vigente->OldValue = $local->loc_vigente->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $local;
		if (!$local->loc_id->FldIsDetailKey) {
			$local->loc_id->setFormValue($objForm->GetValue("x_loc_id"));
		}
		$local->loc_id->setOldValue($objForm->GetValue("o_loc_id"));
		if (!$local->com_id->FldIsDetailKey) {
			$local->com_id->setFormValue($objForm->GetValue("x_com_id"));
		}
		$local->com_id->setOldValue($objForm->GetValue("o_com_id"));
		if (!$local->emp_id->FldIsDetailKey) {
			$local->emp_id->setFormValue($objForm->GetValue("x_emp_id"));
		}
		$local->emp_id->setOldValue($objForm->GetValue("o_emp_id"));
		if (!$local->loc_nombre->FldIsDetailKey) {
			$local->loc_nombre->setFormValue($objForm->GetValue("x_loc_nombre"));
		}
		$local->loc_nombre->setOldValue($objForm->GetValue("o_loc_nombre"));
		if (!$local->loc_direccion->FldIsDetailKey) {
			$local->loc_direccion->setFormValue($objForm->GetValue("x_loc_direccion"));
		}
		$local->loc_direccion->setOldValue($objForm->GetValue("o_loc_direccion"));
		if (!$local->loc_vigente->FldIsDetailKey) {
			$local->loc_vigente->setFormValue($objForm->GetValue("x_loc_vigente"));
		}
		$local->loc_vigente->setOldValue($objForm->GetValue("o_loc_vigente"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $local;
		$local->loc_id->CurrentValue = $local->loc_id->FormValue;
		$local->com_id->CurrentValue = $local->com_id->FormValue;
		$local->emp_id->CurrentValue = $local->emp_id->FormValue;
		$local->loc_nombre->CurrentValue = $local->loc_nombre->FormValue;
		$local->loc_direccion->CurrentValue = $local->loc_direccion->FormValue;
		$local->loc_vigente->CurrentValue = $local->loc_vigente->FormValue;
	}

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
		$local->com_id->setDbValue($rs->fields('com_id'));
		$local->emp_id->setDbValue($rs->fields('emp_id'));
		$local->loc_nombre->setDbValue($rs->fields('loc_nombre'));
		$local->loc_direccion->setDbValue($rs->fields('loc_direccion'));
		$local->loc_googlemaps->setDbValue($rs->fields('loc_googlemaps'));
		$local->loc_vigente->setDbValue($rs->fields('loc_vigente'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $local;

		// Initialize URLs
		// Call Row_Rendering event

		$local->Row_Rendering();

		// Common render codes for all row types
		// loc_id
		// com_id
		// emp_id
		// loc_nombre
		// loc_direccion
		// loc_googlemaps
		// loc_vigente

		if ($local->RowType == EW_ROWTYPE_VIEW) { // View row

			// loc_id
			$local->loc_id->ViewValue = $local->loc_id->CurrentValue;
			$local->loc_id->ViewCustomAttributes = "";

			// com_id
			if (strval($local->com_id->CurrentValue) <> "") {
				$sFilterWrk = "`com_id` = " . ew_AdjustSql($local->com_id->CurrentValue) . "";
			$sSqlWrk = "SELECT `com_nombre` FROM `comuna`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `com_nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$local->com_id->ViewValue = $rswrk->fields('com_nombre');
					$rswrk->Close();
				} else {
					$local->com_id->ViewValue = $local->com_id->CurrentValue;
				}
			} else {
				$local->com_id->ViewValue = NULL;
			}
			$local->com_id->ViewCustomAttributes = "";

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

			// loc_id
			$local->loc_id->LinkCustomAttributes = "";
			$local->loc_id->HrefValue = "";
			$local->loc_id->TooltipValue = "";

			// com_id
			$local->com_id->LinkCustomAttributes = "";
			$local->com_id->HrefValue = "";
			$local->com_id->TooltipValue = "";

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
		} elseif ($local->RowType == EW_ROWTYPE_ADD) { // Add row

			// loc_id
			// com_id

			$local->com_id->EditCustomAttributes = "";

			// emp_id
			$local->emp_id->EditCustomAttributes = "";
			if ($local->emp_id->getSessionValue() <> "") {
				$local->emp_id->CurrentValue = $local->emp_id->getSessionValue();
				$local->emp_id->OldValue = $local->emp_id->CurrentValue;
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
			} else {
			}

			// loc_nombre
			$local->loc_nombre->EditCustomAttributes = "";
			$local->loc_nombre->EditValue = ew_HtmlEncode($local->loc_nombre->CurrentValue);

			// loc_direccion
			$local->loc_direccion->EditCustomAttributes = "";
			$local->loc_direccion->EditValue = ew_HtmlEncode($local->loc_direccion->CurrentValue);

			// loc_vigente
			$local->loc_vigente->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("1", $local->loc_vigente->FldTagCaption(1) <> "" ? $local->loc_vigente->FldTagCaption(1) : "1");
			$arwrk[] = array("0", $local->loc_vigente->FldTagCaption(2) <> "" ? $local->loc_vigente->FldTagCaption(2) : "0");
			$local->loc_vigente->EditValue = $arwrk;

			// Edit refer script
			// loc_id

			$local->loc_id->HrefValue = "";

			// com_id
			$local->com_id->HrefValue = "";

			// emp_id
			$local->emp_id->HrefValue = "";

			// loc_nombre
			$local->loc_nombre->HrefValue = "";

			// loc_direccion
			$local->loc_direccion->HrefValue = "";

			// loc_vigente
			$local->loc_vigente->HrefValue = "";
		} elseif ($local->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// loc_id
			$local->loc_id->EditCustomAttributes = "";
			$local->loc_id->EditValue = $local->loc_id->CurrentValue;
			$local->loc_id->ViewCustomAttributes = "";

			// com_id
			$local->com_id->EditCustomAttributes = "";

			// emp_id
			$local->emp_id->EditCustomAttributes = "";
			if ($local->emp_id->getSessionValue() <> "") {
				$local->emp_id->CurrentValue = $local->emp_id->getSessionValue();
				$local->emp_id->OldValue = $local->emp_id->CurrentValue;
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
			} else {
			}

			// loc_nombre
			$local->loc_nombre->EditCustomAttributes = "";
			$local->loc_nombre->EditValue = ew_HtmlEncode($local->loc_nombre->CurrentValue);

			// loc_direccion
			$local->loc_direccion->EditCustomAttributes = "";
			$local->loc_direccion->EditValue = ew_HtmlEncode($local->loc_direccion->CurrentValue);

			// loc_vigente
			$local->loc_vigente->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("1", $local->loc_vigente->FldTagCaption(1) <> "" ? $local->loc_vigente->FldTagCaption(1) : "1");
			$arwrk[] = array("0", $local->loc_vigente->FldTagCaption(2) <> "" ? $local->loc_vigente->FldTagCaption(2) : "0");
			$local->loc_vigente->EditValue = $arwrk;

			// Edit refer script
			// loc_id

			$local->loc_id->HrefValue = "";

			// com_id
			$local->com_id->HrefValue = "";

			// emp_id
			$local->emp_id->HrefValue = "";

			// loc_nombre
			$local->loc_nombre->HrefValue = "";

			// loc_direccion
			$local->loc_direccion->HrefValue = "";

			// loc_vigente
			$local->loc_vigente->HrefValue = "";
		}
		if ($local->RowType == EW_ROWTYPE_ADD ||
			$local->RowType == EW_ROWTYPE_EDIT ||
			$local->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$local->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($local->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$local->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $local;

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($local->loc_nombre->FormValue) && $local->loc_nombre->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $local->loc_nombre->FldCaption());
		}
		if (!is_null($local->loc_direccion->FormValue) && $local->loc_direccion->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $local->loc_direccion->FldCaption());
		}
		if ($local->loc_vigente->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $local->loc_vigente->FldCaption());
		}

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
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$local->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $local;
		$sFilter = $local->KeyFilter();
		$local->CurrentFilter = $sFilter;
		$sSql = $local->SQL();
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

			// com_id
			$local->com_id->SetDbValueDef($rsnew, $local->com_id->CurrentValue, NULL, FALSE);

			// emp_id
			$local->emp_id->SetDbValueDef($rsnew, $local->emp_id->CurrentValue, NULL, FALSE);

			// loc_nombre
			$local->loc_nombre->SetDbValueDef($rsnew, $local->loc_nombre->CurrentValue, "", FALSE);

			// loc_direccion
			$local->loc_direccion->SetDbValueDef($rsnew, $local->loc_direccion->CurrentValue, "", FALSE);

			// loc_vigente
			$local->loc_vigente->SetDbValueDef($rsnew, $local->loc_vigente->CurrentValue, 0, FALSE);

			// Call Row Updating event
			$bUpdateRow = $local->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $conn->Execute($local->UpdateSQL($rsnew));
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($local->CancelMessage <> "") {
					$this->setFailureMessage($local->CancelMessage);
					$local->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$local->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security, $local;

		// Set up foreign key field value from Session
			if ($local->getCurrentMasterTable() == "empresa") {
				$local->emp_id->CurrentValue = $local->emp_id->getSessionValue();
			}
		$rsnew = array();

		// com_id
		$local->com_id->SetDbValueDef($rsnew, $local->com_id->CurrentValue, NULL, FALSE);

		// emp_id
		$local->emp_id->SetDbValueDef($rsnew, $local->emp_id->CurrentValue, NULL, FALSE);

		// loc_nombre
		$local->loc_nombre->SetDbValueDef($rsnew, $local->loc_nombre->CurrentValue, "", FALSE);

		// loc_direccion
		$local->loc_direccion->SetDbValueDef($rsnew, $local->loc_direccion->CurrentValue, "", FALSE);

		// loc_vigente
		$local->loc_vigente->SetDbValueDef($rsnew, $local->loc_vigente->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $local->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($local->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($local->CancelMessage <> "") {
				$this->setFailureMessage($local->CancelMessage);
				$local->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$local->loc_id->setDbValue($conn->Insert_ID());
			$rsnew['loc_id'] = $local->loc_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$local->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		global $local;

		// Hide foreign keys
		$sMasterTblVar = $local->getCurrentMasterTable();
		if ($sMasterTblVar == "empresa") {
			$local->emp_id->Visible = FALSE;
			if ($GLOBALS["empresa"]->EventCancelled) $local->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $local->getMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $local->getDetailFilter(); // Get detail filter
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
