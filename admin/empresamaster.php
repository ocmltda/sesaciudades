<?php

// Call Row_Rendering event
$empresa->Row_Rendering();

// emp_id
// emp_nomfantasia
// emp_razonsocial
// emp_rut
// Call Row_Rendered event

$empresa->Row_Rendered();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
	<tbody>
		<tr>
			<td class="ewTableHeader"><?php echo $empresa->emp_id->FldCaption() ?></td>
			<td<?php echo $empresa->emp_id->CellAttributes() ?>>
<div<?php echo $empresa->emp_id->ViewAttributes() ?>><?php echo $empresa->emp_id->ListViewValue() ?></div></td>
		</tr>
		<tr>
			<td class="ewTableHeader"><?php echo $empresa->emp_nomfantasia->FldCaption() ?></td>
			<td<?php echo $empresa->emp_nomfantasia->CellAttributes() ?>>
<div<?php echo $empresa->emp_nomfantasia->ViewAttributes() ?>><?php echo $empresa->emp_nomfantasia->ListViewValue() ?></div></td>
		</tr>
		<tr>
			<td class="ewTableHeader"><?php echo $empresa->emp_razonsocial->FldCaption() ?></td>
			<td<?php echo $empresa->emp_razonsocial->CellAttributes() ?>>
<div<?php echo $empresa->emp_razonsocial->ViewAttributes() ?>><?php echo $empresa->emp_razonsocial->ListViewValue() ?></div></td>
		</tr>
		<tr>
			<td class="ewTableHeader"><?php echo $empresa->emp_rut->FldCaption() ?></td>
			<td<?php echo $empresa->emp_rut->CellAttributes() ?>>
<div<?php echo $empresa->emp_rut->ViewAttributes() ?>><?php echo $empresa->emp_rut->ListViewValue() ?></div></td>
		</tr>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
