<?php
require_once('include/funciones.php');
require_once('include/class.TemplatePower.inc.php');
require_once('include/db_mysql.inc');

//make a new TemplatePower object
$t = new TemplatePower("pla_cupXregXcat.html");

//let TemplatePower do its thing, parsing etc.
$t->prepare();

//rescato el nombre de la region
$db = new DB_Sql;
	
$db->query('SELECT reg_nombre FROM region WHERE reg_id = ' . $_GET['reg']);//consulta a la BD

$nomReg = '';
//listo las categorias
while($db->next_record())
{
	//$t->newBlock("categorias");
	$nomReg = $db->Record['reg_nombre'];
	$t->assign('nomreg', $nomReg . '');
}

//listo los cupones de la region
$db->query('SELECT cupon.cup_nombre, cupon.cup_preview_nombre, cupon.cup_imagen_nombre, cupon.cup_preview_ancho, cupon.cup_preview_alto, cupon.cup_imagen_ancho, cupon.cup_imagen_alto FROM comuna INNER JOIN `local` ON comuna.com_id = `local`.com_id INNER JOIN empresa ON empresa.emp_id = `local`.emp_id INNER JOIN cupon ON empresa.emp_id = cupon.emp_id INNER JOIN categoria ON categoria.cat_id = cupon.cat_id WHERE comuna.reg_id = ' . $_GET['reg'] . ' AND categoria.cat_id = ' . $_GET['cat']);//consulta a la BD

$jk = 0;
$xy = 0;
$maxCupFila = 3;
$numCupones = $db->nf();
$numFilas = floor($numCupones / $maxCupFila);
$restoFilas = $maxCupFila - ($numCupones % $maxCupFila);
//echo $numCupones . '|' . $maxCupFila . '|' . $numFilas . '|' . $restoFilas;
//listo las categorias
while($db->next_record())
{
	$t->newBlock('cuponescatreg');
	$jk++;
	$xy++;
	if ($jk == 1)
		$t->assign('trini', '<tr>');
	else
		$t->assign('trini', '');
	$t->assign('imgprvcupon', $db->Record['cup_preview_nombre'] . '');
	$t->assign('imgcupon', $db->Record['cup_imagen_nombre'] . '');
	$t->assign('anchocuponpopup', $db->Record['cup_imagen_ancho'] + 20 . '');
	$t->assign('altocuponpopup', $db->Record['cup_imagen_alto'] + 20 . '');
	
	if ($jk == $maxCupFila)
	{
		$t->assign('trfin', '</tr>');
		$jk = 0;
	}
	else
		$t->assign('trfin', '');

	if ($xy == $numCupones)
	{
		$t->assign('colspan', $restoFilas . '');
		$t->assign('trfin', '</tr>');
	}
	else
		$t->assign('colspan', '');
}

//print the result
$t->printToScreen();
?>