<?php

// Call Row_Rendering event
$cupon->Row_Rendering();

// cup_id
// emp_id
// cat_id
// cup_nombre
// cup_preview_nombre
// cup_imagen_nombre
// Call Row_Rendered event

$cupon->Row_Rendered();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
	<tbody>
		<tr>
			<td class="ewTableHeader"><?php echo $cupon->cup_id->FldCaption() ?></td>
			<td<?php echo $cupon->cup_id->CellAttributes() ?>>
<div<?php echo $cupon->cup_id->ViewAttributes() ?>><?php echo $cupon->cup_id->ListViewValue() ?></div></td>
		</tr>
		<tr>
			<td class="ewTableHeader"><?php echo $cupon->emp_id->FldCaption() ?></td>
			<td<?php echo $cupon->emp_id->CellAttributes() ?>>
<div<?php echo $cupon->emp_id->ViewAttributes() ?>><?php echo $cupon->emp_id->ListViewValue() ?></div></td>
		</tr>
		<tr>
			<td class="ewTableHeader"><?php echo $cupon->cat_id->FldCaption() ?></td>
			<td<?php echo $cupon->cat_id->CellAttributes() ?>>
<div<?php echo $cupon->cat_id->ViewAttributes() ?>><?php echo $cupon->cat_id->ListViewValue() ?></div></td>
		</tr>
		<tr>
			<td class="ewTableHeader"><?php echo $cupon->cup_nombre->FldCaption() ?></td>
			<td<?php echo $cupon->cup_nombre->CellAttributes() ?>>
<div<?php echo $cupon->cup_nombre->ViewAttributes() ?>><?php echo $cupon->cup_nombre->ListViewValue() ?></div></td>
		</tr>
		<tr>
			<td class="ewTableHeader"><?php echo $cupon->cup_preview_nombre->FldCaption() ?></td>
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
		</tr>
		<tr>
			<td class="ewTableHeader"><?php echo $cupon->cup_imagen_nombre->FldCaption() ?></td>
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
		</tr>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
