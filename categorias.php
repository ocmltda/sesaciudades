<?php
require_once('include/funciones.php');
require_once('include/class.TemplatePower.inc.php');
require_once('include/db_mysql.inc');

//make a new TemplatePower object
$t = new TemplatePower("pla_categorias.html");

//let TemplatePower do its thing, parsing etc.
$t->prepare();

//rescato el nombre de la region
$db = new DB_Sql;
	
$db->query('SELECT reg_nombre FROM region WHERE reg_id = ' . $_GET['reg']);//consulta a la BD

$nomReg = '';
//listo la region seleccionada
while($db->next_record())
{
	//$t->newBlock("categorias");
	$nomReg = $db->Record['reg_nombre'];
	$t->assign('nomreg', $nomReg . '');
}

//listo las categorias
$db->query('SELECT DISTINCT CAT.cat_id, CAT.cat_nombre, CAT.cat_imagen_nombre FROM comuna AS COM INNER JOIN `local` AS LOC ON COM.com_id = LOC.com_id INNER JOIN empresa AS EMP ON EMP.emp_id = LOC.emp_id INNER JOIN cupon AS CUP ON EMP.emp_id = CUP.emp_id INNER JOIN categoria AS CAT ON CAT.cat_id = CUP.cat_id WHERE COM.reg_id = ' . $_GET['reg'] . ' AND CUP.cup_vigente = 1 AND CAT.cat_mostrar = 1 ORDER BY CAT.cat_id ASC');//consulta a la BD

$jk = 0;
$xy = 0;
$maxCupFila = 6;
$numCupones = $db->nf();
$numFilas = floor($numCupones / $maxCupFila);
$restoFilas = $maxCupFila - ($numCupones % $maxCupFila);
//echo $numCupones . '|' . $maxCupFila . '|' . $numFilas . '|' . $restoFilas;
//listo las categorias
while($db->next_record())
{
	$t->newBlock('categorias');
	$jk++;
	$xy++;
	if ($jk == 1)
		$t->assign('trini', '<tr align="center">');
	else
		$t->assign('trini', '');
	$t->assign('idcat', $db->Record['cat_id'] . '');
	$t->assign('numreg', $_GET['reg'] . '');
	$t->assign('fotocat', $db->Record['cat_imagen_nombre'] . '');
	
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