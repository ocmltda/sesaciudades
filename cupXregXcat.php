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
	
$db->query('SELECT reg_nombre FROM region WHERE reg_id = ' . $_GET['rgion']);//consulta a la BD

$nomReg = '';
//listo las categorias
while($db->next_record())
{
	//$t->newBlock("categorias");
	$nomReg = $db->Record['reg_nombre'];
	$t->assign('nomreg', $nomReg . '');
}

//listo los cupones de la region
$db->query('SELECT DISTINCT CUP.cup_id, CUP.cup_nombre, CUP.cup_preview_nombre, CUP.cup_preview_ancho, CUP.cup_preview_alto, CUP.cup_imagen_nombre, CUP.cup_imagen_ancho, CUP.cup_imagen_alto FROM cupon_categ AS CCA INNER JOIN cupon AS CUP ON CUP.cup_id = CCA.cup_id INNER JOIN cupon_region AS CUR ON CUP.cup_id = CUR.cup_id WHERE CUR.reg_id = ' . $_GET['rgion'] . ' AND CCA.cat_id = ' . $_GET['cat'] . ' AND CUP.cup_vigente = 1 ORDER BY CUP.cup_id DESC');//consulta a la BD

$jk = 0;
$xy = 0;
$maxCupFila = 3;
$numCupones = $db->nf();
$numFilas = floor($numCupones / $maxCupFila);
$restoFilas = $maxCupFila - ($numCupones % $maxCupFila) + 1;
//echo $numCupones . '|' . $maxCupFila . '|' . $numFilas . '|' . $restoFilas;
//listo las categorias
while($db->next_record())
{
	$t->newBlock('cuponescatreg');

	$t->assign('idcupon', $db->Record['cup_id'] . '');

	$jk++;
	$xy++;
	if ($jk == 1)
		$t->assign('trini', '<tr>');
	else
		$t->assign('trini', '');
	$t->assign('imgprvcupon', $db->Record['cup_preview_nombre'] . '');
	$t->assign('anchoprv', $db->Record['cup_preview_ancho'] . '');
	$t->assign('altoprv', $db->Record['cup_preview_alto'] . '');
	$t->assign('imgcupon', $db->Record['cup_imagen_nombre'] . '');
	$t->assign('anchocuponpopup', $db->Record['cup_imagen_ancho'] + 20 . '');
	$t->assign('altocuponpopup', $db->Record['cup_imagen_alto'] + 150 . '');
	
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