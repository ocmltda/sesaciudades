<?php

// Global variable for table object
$promocion = NULL;

//
// Table class for promocion
//
class cpromocion {
	var $TableVar = 'promocion';
	var $TableName = 'promocion';
	var $TableType = 'TABLE';
	var $pro_id;
	var $pro_titulo;
	var $pro_texto;
	var $pro_imagen_nombre;
	var $pro_imagen_tipo;
	var $pro_imagen_ancho;
	var $pro_imagen_alto;
	var $pro_imagen_size;
	var $pro_vigente;
	var $fields = array();
	var $UseTokenInUrl = EW_USE_TOKEN_IN_URL;
	var $Export; // Export
	var $ExportOriginalValue = EW_EXPORT_ORIGINAL_VALUE;
	var $ExportAll = TRUE;
	var $ExportPageBreakCount = 0; // Page break per every n record (PDF only)
	var $SendEmail; // Send email
	var $TableCustomInnerHtml; // Custom inner HTML
	var $BasicSearchKeyword; // Basic search keyword
	var $BasicSearchType; // Basic search type
	var $CurrentFilter; // Current filter
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type
	var $RowType; // Row type
	var $CssClass; // CSS class
	var $CssStyle; // CSS style
	var $RowAttrs = array(); // Row custom attributes

	// Reset attributes for table object
	function ResetAttrs() {
		$this->CssClass = "";
		$this->CssStyle = "";
    	$this->RowAttrs = array();
		foreach ($this->fields as $fld) {
			$fld->ResetAttrs();
		}
	}

	// Setup field titles
	function SetupFieldTitles() {
		foreach ($this->fields as &$fld) {
			if (strval($fld->FldTitle()) <> "") {
				$fld->EditAttrs["onmouseover"] = "ew_ShowTitle(this, '" . ew_JsEncode3($fld->FldTitle()) . "');";
				$fld->EditAttrs["onmouseout"] = "ew_HideTooltip();";
			}
		}
	}
	var $TableFilter = "";
	var $CurrentAction; // Current action
	var $LastAction; // Last action
	var $CurrentMode = ""; // Current mode
	var $UpdateConflict; // Update conflict
	var $EventName; // Event name
	var $EventCancelled; // Event cancelled
	var $CancelMessage; // Cancel message
	var $AllowAddDeleteRow = TRUE; // Allow add/delete row
	var $DetailAdd = FALSE; // Allow detail add
	var $DetailEdit = FALSE; // Allow detail edit
	var $GridAddRowCount = 5;

	// Check current action
	// - Add
	function IsAdd() {
		return $this->CurrentAction == "add";
	}

	// - Copy
	function IsCopy() {
		return $this->CurrentAction == "copy" || $this->CurrentAction == "C";
	}

	// - Edit
	function IsEdit() {
		return $this->CurrentAction == "edit";
	}

	// - Delete
	function IsDelete() {
		return $this->CurrentAction == "D";
	}

	// - Confirm
	function IsConfirm() {
		return $this->CurrentAction == "F";
	}

	// - Overwrite
	function IsOverwrite() {
		return $this->CurrentAction == "overwrite";
	}

	// - Cancel
	function IsCancel() {
		return $this->CurrentAction == "cancel";
	}

	// - Grid add
	function IsGridAdd() {
		return $this->CurrentAction == "gridadd";
	}

	// - Grid edit
	function IsGridEdit() {
		return $this->CurrentAction == "gridedit";
	}

	// - Insert
	function IsInsert() {
		return $this->CurrentAction == "insert" || $this->CurrentAction == "A";
	}

	// - Update
	function IsUpdate() {
		return $this->CurrentAction == "update" || $this->CurrentAction == "U";
	}

	// - Grid update
	function IsGridUpdate() {
		return $this->CurrentAction == "gridupdate";
	}

	// - Grid insert
	function IsGridInsert() {
		return $this->CurrentAction == "gridinsert";
	}

	// - Grid overwrite
	function IsGridOverwrite() {
		return $this->CurrentAction == "gridoverwrite";
	}

	// Check last action
	// - Cancelled
	function IsCanceled() {
		return $this->LastAction == "cancel" && $this->CurrentAction == "";
	}

	// - Inline inserted
	function IsInlineInserted() {
		return $this->LastAction == "insert" && $this->CurrentAction == "";
	}

	// - Inline updated
	function IsInlineUpdated() {
		return $this->LastAction == "update" && $this->CurrentAction == "";
	}

	// - Grid updated
	function IsGridUpdated() {
		return $this->LastAction == "gridupdate" && $this->CurrentAction == "";
	}

	// - Grid inserted
	function IsGridInserted() {
		return $this->LastAction == "gridinsert" && $this->CurrentAction == "";
	}

	//
	// Table class constructor
	//
	function cpromocion() {
		global $Language;
		$AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row

		// pro_id
		$this->pro_id = new cField('promocion', 'promocion', 'x_pro_id', 'pro_id', '`pro_id`', 3, -1, FALSE, '`pro_id`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->pro_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pro_id'] =& $this->pro_id;

		// pro_titulo
		$this->pro_titulo = new cField('promocion', 'promocion', 'x_pro_titulo', 'pro_titulo', '`pro_titulo`', 200, -1, FALSE, '`pro_titulo`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pro_titulo'] =& $this->pro_titulo;

		// pro_texto
		$this->pro_texto = new cField('promocion', 'promocion', 'x_pro_texto', 'pro_texto', '`pro_texto`', 201, -1, FALSE, '`pro_texto`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pro_texto'] =& $this->pro_texto;

		// pro_imagen_nombre
		$this->pro_imagen_nombre = new cField('promocion', 'promocion', 'x_pro_imagen_nombre', 'pro_imagen_nombre', '`pro_imagen_nombre`', 200, -1, TRUE, '`pro_imagen_nombre`', FALSE, FALSE, 'IMAGE');
		$this->pro_imagen_nombre->UploadPath = '../pro-imagenes/';
		$this->fields['pro_imagen_nombre'] =& $this->pro_imagen_nombre;

		// pro_imagen_tipo
		$this->pro_imagen_tipo = new cField('promocion', 'promocion', 'x_pro_imagen_tipo', 'pro_imagen_tipo', '`pro_imagen_tipo`', 200, -1, FALSE, '`pro_imagen_tipo`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pro_imagen_tipo'] =& $this->pro_imagen_tipo;

		// pro_imagen_ancho
		$this->pro_imagen_ancho = new cField('promocion', 'promocion', 'x_pro_imagen_ancho', 'pro_imagen_ancho', '`pro_imagen_ancho`', 3, -1, FALSE, '`pro_imagen_ancho`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->pro_imagen_ancho->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pro_imagen_ancho'] =& $this->pro_imagen_ancho;

		// pro_imagen_alto
		$this->pro_imagen_alto = new cField('promocion', 'promocion', 'x_pro_imagen_alto', 'pro_imagen_alto', '`pro_imagen_alto`', 3, -1, FALSE, '`pro_imagen_alto`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->pro_imagen_alto->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pro_imagen_alto'] =& $this->pro_imagen_alto;

		// pro_imagen_size
		$this->pro_imagen_size = new cField('promocion', 'promocion', 'x_pro_imagen_size', 'pro_imagen_size', '`pro_imagen_size`', 3, -1, FALSE, '`pro_imagen_size`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->pro_imagen_size->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pro_imagen_size'] =& $this->pro_imagen_size;

		// pro_vigente
		$this->pro_vigente = new cField('promocion', 'promocion', 'x_pro_vigente', 'pro_vigente', '`pro_vigente`', 16, -1, FALSE, '`pro_vigente`', FALSE, FALSE, 'FORMATTED TEXT');
		$this->pro_vigente->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pro_vigente'] =& $this->pro_vigente;
	}

	// Get field values
	function GetFieldValues($propertyname) {
		$values = array();
		foreach ($this->fields as $fldname => $fld)
			$values[$fldname] =& $fld->$propertyname;
		return $values;
	}

	// Table caption
	function TableCaption() {
		global $Language;
		return $Language->TablePhrase($this->TableVar, "TblCaption");
	}

	// Page caption
	function PageCaption($Page) {
		global $Language;
		$Caption = $Language->TablePhrase($this->TableVar, "TblPageCaption" . $Page);
		if ($Caption == "") $Caption = "Page " . $Page;
		return $Caption;
	}

	// Export return page
	function ExportReturnUrl() {
		$url = @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_EXPORT_RETURN_URL];
		return ($url <> "") ? $url : ew_CurrentPage();
	}

	function setExportReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_EXPORT_RETURN_URL] = $v;
	}

	// Records per page
	function getRecordsPerPage() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE];
	}

	function setRecordsPerPage($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE] = $v;
	}

	// Start record number
	function getStartRecordNumber() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC];
	}

	function setStartRecordNumber($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC] = $v;
	}

	// Search highlight name
	function HighlightName() {
		return "promocion_Highlight";
	}

	// Advanced search
	function getAdvancedSearch($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld];
	}

	function setAdvancedSearch($fld, $v) {
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] <> $v) {
			$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] = $v;
		}
	}

	// Basic search keyword
	function getSessionBasicSearchKeyword() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH];
	}

	function setSessionBasicSearchKeyword($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH] = $v;
	}

	// Basic search type
	function getSessionBasicSearchType() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE];
	}

	function setSessionBasicSearchType($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE] = $v;
	}

	// Search WHERE clause
	function getSearchWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE];
	}

	function setSearchWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE] = $v;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Session WHERE clause
	function getSessionWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE];
	}

	function setSessionWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE] = $v;
	}

	// Session ORDER BY
	function getSessionOrderBy() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY];
	}

	function setSessionOrderBy($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY] = $v;
	}

	// Session key
	function getKey($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld];
	}

	function setKey($fld, $v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld] = $v;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`promocion`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (EW_PAGE_ID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
			$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . substr($sSql, 13);
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$origFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($this->SelectSQL())) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		if (substr($names, -1) == ",") $names = substr($names, 0, strlen($names)-1);
		if (substr($values, -1) == ",") $values = substr($values, 0, strlen($values)-1);
		return "INSERT INTO `promocion` ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		global $conn;
		$SQL = "UPDATE `promocion` SET ";
		foreach ($rs as $name => $value) {
			$SQL .= $this->fields[$name]->FldExpression . "=";
			$SQL .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		if (substr($SQL, -1) == ",") $SQL = substr($SQL, 0, strlen($SQL)-1);
		if ($this->CurrentFilter <> "")	$SQL .= " WHERE " . $this->CurrentFilter;
		return $SQL;
	}

	// DELETE statement
	function DeleteSQL(&$rs) {
		$SQL = "DELETE FROM `promocion` WHERE ";
		$SQL .= ew_QuotedName('pro_id') . '=' . ew_QuotedValue($rs['pro_id'], $this->pro_id->FldDataType) . ' AND ';
		if (substr($SQL, -5) == " AND ") $SQL = substr($SQL, 0, strlen($SQL)-5);
		if ($this->CurrentFilter <> "")	$SQL .= " AND " . $this->CurrentFilter;
		return $SQL;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`pro_id` = @pro_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->pro_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@pro_id@", ew_AdjustSql($this->pro_id->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "promocionlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function ListUrl() {
		return "promocionlist.php";
	}

	// View URL
	function ViewUrl() {
		return $this->KeyUrl("promocionview.php", $this->UrlParm());
	}

	// Add URL
	function AddUrl() {
		$AddUrl = "promocionadd.php";

//		$sUrlParm = $this->UrlParm();
//		if ($sUrlParm <> "")
//			$AddUrl .= "?" . $sUrlParm;

		return $AddUrl;
	}

	// Edit URL
	function EditUrl($parm = "") {
		return $this->KeyUrl("promocionedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function InlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function CopyUrl($parm = "") {
		return $this->KeyUrl("promocionadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function InlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function DeleteUrl() {
		return $this->KeyUrl("promociondelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->pro_id->CurrentValue)) {
			$sUrl .= "pro_id=" . urlencode($this->pro_id->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Add URL parameter
	function UrlParm($parm = "") {
		$UrlParm = ($this->UseTokenInUrl) ? "t=promocion" : "";
		if ($parm <> "") {
			if ($UrlParm <> "")
				$UrlParm .= "&";
			$UrlParm .= $parm;
		}
		return $UrlParm;
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["pro_id"]; // pro_id

			//return $arKeys; // do not return yet, so the values will also be checked by the following code
		}

		// check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->pro_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->pro_id->setDbValue($rs->fields('pro_id'));
		$this->pro_titulo->setDbValue($rs->fields('pro_titulo'));
		$this->pro_texto->setDbValue($rs->fields('pro_texto'));
		$this->pro_imagen_nombre->Upload->DbValue = $rs->fields('pro_imagen_nombre');
		$this->pro_imagen_tipo->setDbValue($rs->fields('pro_imagen_tipo'));
		$this->pro_imagen_ancho->setDbValue($rs->fields('pro_imagen_ancho'));
		$this->pro_imagen_alto->setDbValue($rs->fields('pro_imagen_alto'));
		$this->pro_imagen_size->setDbValue($rs->fields('pro_imagen_size'));
		$this->pro_vigente->setDbValue($rs->fields('pro_vigente'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// pro_id
		// pro_titulo
		// pro_texto
		// pro_imagen_nombre
		// pro_imagen_tipo
		// pro_imagen_ancho
		// pro_imagen_alto
		// pro_imagen_size
		// pro_vigente
		// pro_id

		$this->pro_id->ViewValue = $this->pro_id->CurrentValue;
		$this->pro_id->ViewCustomAttributes = "";

		// pro_titulo
		$this->pro_titulo->ViewValue = $this->pro_titulo->CurrentValue;
		$this->pro_titulo->ViewCustomAttributes = "";

		// pro_texto
		$this->pro_texto->ViewValue = $this->pro_texto->CurrentValue;
		$this->pro_texto->ViewCustomAttributes = "";

		// pro_imagen_nombre
		if (!ew_Empty($this->pro_imagen_nombre->Upload->DbValue)) {
			$this->pro_imagen_nombre->ViewValue = $this->pro_imagen_nombre->Upload->DbValue;
			$this->pro_imagen_nombre->ImageWidth = 100;
			$this->pro_imagen_nombre->ImageHeight = 0;
			$this->pro_imagen_nombre->ImageAlt = $this->pro_imagen_nombre->FldAlt();
		} else {
			$this->pro_imagen_nombre->ViewValue = "";
		}
		$this->pro_imagen_nombre->ViewCustomAttributes = "";

		// pro_imagen_tipo
		$this->pro_imagen_tipo->ViewValue = $this->pro_imagen_tipo->CurrentValue;
		$this->pro_imagen_tipo->ViewCustomAttributes = "";

		// pro_imagen_ancho
		$this->pro_imagen_ancho->ViewValue = $this->pro_imagen_ancho->CurrentValue;
		$this->pro_imagen_ancho->ViewValue = ew_FormatNumber($this->pro_imagen_ancho->ViewValue, 0, -2, -2, -2);
		$this->pro_imagen_ancho->ViewCustomAttributes = "";

		// pro_imagen_alto
		$this->pro_imagen_alto->ViewValue = $this->pro_imagen_alto->CurrentValue;
		$this->pro_imagen_alto->ViewValue = ew_FormatNumber($this->pro_imagen_alto->ViewValue, 0, -2, -2, -2);
		$this->pro_imagen_alto->ViewCustomAttributes = "";

		// pro_imagen_size
		$this->pro_imagen_size->ViewValue = $this->pro_imagen_size->CurrentValue;
		$this->pro_imagen_size->ViewValue = ew_FormatNumber($this->pro_imagen_size->ViewValue, 0, -2, -2, -2);
		$this->pro_imagen_size->ViewCustomAttributes = "";

		// pro_vigente
		if (strval($this->pro_vigente->CurrentValue) <> "") {
			switch ($this->pro_vigente->CurrentValue) {
				case "1":
					$this->pro_vigente->ViewValue = $this->pro_vigente->FldTagCaption(1) <> "" ? $this->pro_vigente->FldTagCaption(1) : $this->pro_vigente->CurrentValue;
					break;
				case "0":
					$this->pro_vigente->ViewValue = $this->pro_vigente->FldTagCaption(2) <> "" ? $this->pro_vigente->FldTagCaption(2) : $this->pro_vigente->CurrentValue;
					break;
				default:
					$this->pro_vigente->ViewValue = $this->pro_vigente->CurrentValue;
			}
		} else {
			$this->pro_vigente->ViewValue = NULL;
		}
		$this->pro_vigente->ViewCustomAttributes = "";

		// pro_id
		$this->pro_id->LinkCustomAttributes = "";
		$this->pro_id->HrefValue = "";
		$this->pro_id->TooltipValue = "";

		// pro_titulo
		$this->pro_titulo->LinkCustomAttributes = "";
		$this->pro_titulo->HrefValue = "";
		$this->pro_titulo->TooltipValue = "";

		// pro_texto
		$this->pro_texto->LinkCustomAttributes = "";
		$this->pro_texto->HrefValue = "";
		$this->pro_texto->TooltipValue = "";

		// pro_imagen_nombre
		$this->pro_imagen_nombre->LinkCustomAttributes = "";
		if (!ew_Empty($this->pro_imagen_nombre->Upload->DbValue)) {
			$this->pro_imagen_nombre->HrefValue = ew_UploadPathEx(FALSE, $this->pro_imagen_nombre->UploadPath) . ((!empty($this->pro_imagen_nombre->ViewValue)) ? $this->pro_imagen_nombre->ViewValue : $this->pro_imagen_nombre->CurrentValue); // Add prefix/suffix
			$this->pro_imagen_nombre->LinkAttrs["target"] = "_blank"; // Add target
			if ($this->Export <> "") $promocion->pro_imagen_nombre->HrefValue = ew_ConvertFullUrl($this->pro_imagen_nombre->HrefValue);
		} else {
			$this->pro_imagen_nombre->HrefValue = "";
		}
		$this->pro_imagen_nombre->TooltipValue = "";

		// pro_imagen_tipo
		$this->pro_imagen_tipo->LinkCustomAttributes = "";
		$this->pro_imagen_tipo->HrefValue = "";
		$this->pro_imagen_tipo->TooltipValue = "";

		// pro_imagen_ancho
		$this->pro_imagen_ancho->LinkCustomAttributes = "";
		$this->pro_imagen_ancho->HrefValue = "";
		$this->pro_imagen_ancho->TooltipValue = "";

		// pro_imagen_alto
		$this->pro_imagen_alto->LinkCustomAttributes = "";
		$this->pro_imagen_alto->HrefValue = "";
		$this->pro_imagen_alto->TooltipValue = "";

		// pro_imagen_size
		$this->pro_imagen_size->LinkCustomAttributes = "";
		$this->pro_imagen_size->HrefValue = "";
		$this->pro_imagen_size->TooltipValue = "";

		// pro_vigente
		$this->pro_vigente->LinkCustomAttributes = "";
		$this->pro_vigente->HrefValue = "";
		$this->pro_vigente->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
	}

	// Export data in Xml Format
	function ExportXmlDocument(&$XmlDoc, $HasParent, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$XmlDoc)
			return;
		if (!$HasParent)
			$XmlDoc->AddRoot($this->TableVar);

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if ($HasParent)
					$XmlDoc->AddRow($this->TableVar);
				else
					$XmlDoc->AddRow();
				if ($ExportPageType == "view") {
					$XmlDoc->AddField('pro_id', $this->pro_id->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('pro_titulo', $this->pro_titulo->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('pro_texto', $this->pro_texto->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('pro_imagen_nombre', $this->pro_imagen_nombre->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('pro_imagen_tipo', $this->pro_imagen_tipo->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('pro_imagen_ancho', $this->pro_imagen_ancho->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('pro_imagen_alto', $this->pro_imagen_alto->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('pro_imagen_size', $this->pro_imagen_size->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('pro_vigente', $this->pro_vigente->ExportValue($this->Export, $this->ExportOriginalValue));
				} else {
					$XmlDoc->AddField('pro_id', $this->pro_id->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('pro_titulo', $this->pro_titulo->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('pro_imagen_nombre', $this->pro_imagen_nombre->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('pro_imagen_ancho', $this->pro_imagen_ancho->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('pro_imagen_alto', $this->pro_imagen_alto->ExportValue($this->Export, $this->ExportOriginalValue));
					$XmlDoc->AddField('pro_vigente', $this->pro_vigente->ExportValue($this->Export, $this->ExportOriginalValue));
				}
			}
			$Recordset->MoveNext();
		}
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;

		// Write header
		$Doc->ExportTableHeader();
		if ($Doc->Horizontal) { // Horizontal format, write header
			$Doc->BeginExportRow();
			if ($ExportPageType == "view") {
				$Doc->ExportCaption($this->pro_id);
				$Doc->ExportCaption($this->pro_titulo);
				$Doc->ExportCaption($this->pro_texto);
				$Doc->ExportCaption($this->pro_imagen_nombre);
				$Doc->ExportCaption($this->pro_imagen_tipo);
				$Doc->ExportCaption($this->pro_imagen_ancho);
				$Doc->ExportCaption($this->pro_imagen_alto);
				$Doc->ExportCaption($this->pro_imagen_size);
				$Doc->ExportCaption($this->pro_vigente);
			} else {
				$Doc->ExportCaption($this->pro_id);
				$Doc->ExportCaption($this->pro_titulo);
				$Doc->ExportCaption($this->pro_imagen_nombre);
				$Doc->ExportCaption($this->pro_imagen_ancho);
				$Doc->ExportCaption($this->pro_imagen_alto);
				$Doc->ExportCaption($this->pro_vigente);
			}
			if ($this->Export == "pdf") {
				$Doc->EndExportRow(TRUE);
			} else {
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break for PDF
				if ($this->Export == "pdf" && $this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
					$Doc->ExportField($this->pro_id);
					$Doc->ExportField($this->pro_titulo);
					$Doc->ExportField($this->pro_texto);
					$Doc->ExportField($this->pro_imagen_nombre);
					$Doc->ExportField($this->pro_imagen_tipo);
					$Doc->ExportField($this->pro_imagen_ancho);
					$Doc->ExportField($this->pro_imagen_alto);
					$Doc->ExportField($this->pro_imagen_size);
					$Doc->ExportField($this->pro_vigente);
				} else {
					$Doc->ExportField($this->pro_id);
					$Doc->ExportField($this->pro_titulo);
					$Doc->ExportField($this->pro_imagen_nombre);
					$Doc->ExportField($this->pro_imagen_ancho);
					$Doc->ExportField($this->pro_imagen_alto);
					$Doc->ExportField($this->pro_vigente);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
		}
		$Doc->ExportTableFooter();
	}

	// Row styles
	function RowStyles() {
		$sAtt = "";
		$sStyle = trim($this->CssStyle);
		if (@$this->RowAttrs["style"] <> "")
			$sStyle .= " " . $this->RowAttrs["style"];
		$sClass = trim($this->CssClass);
		if (@$this->RowAttrs["class"] <> "")
			$sClass .= " " . $this->RowAttrs["class"];
		if (trim($sStyle) <> "")
			$sAtt .= " style=\"" . trim($sStyle) . "\"";
		if (trim($sClass) <> "")
			$sAtt .= " class=\"" . trim($sClass) . "\"";
		return $sAtt;
	}

	// Row attributes
	function RowAttributes() {
		$sAtt = $this->RowStyles();
		if ($this->Export == "") {
			foreach ($this->RowAttrs as $k => $v) {
				if ($k <> "class" && $k <> "style" && trim($v) <> "")
					$sAtt .= " " . $k . "=\"" . trim($v) . "\"";
			}
		}
		return $sAtt;
	}

	// Field object by name
	function fields($fldname) {
		return $this->fields[$fldname];
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}
}
?>
