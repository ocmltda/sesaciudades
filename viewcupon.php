<?php
require_once('include/funciones.php');
require_once('include/class.TemplatePower.inc.php');
require_once('include/db_mysql.inc');

//make a new TemplatePower object
$t = new TemplatePower("pla_viewcupon.html");

//let TemplatePower do its thing, parsing etc.
$t->prepare();

//rescato el nombre de la region
$db = new DB_Sql;
	
//listo los cupones de la region
$db->query('SELECT cupon.cup_id, cupon.cup_nombre, cupon.cup_imagen_nombre, cupon.cup_imagen_ancho, cupon.cup_imagen_alto FROM cupon WHERE cupon.cup_id = ' . $_GET['idcupon']);//consulta a la BD

while($db->next_record())
{
	$t->assign('nomcupon', $db->Record['cup_nombre'] . '');
	$t->assign('imgcupon', $db->Record['cup_imagen_nombre'] . '');
	$t->assign('anchocupon', $db->Record['cup_imagen_ancho'] . '');
	$t->assign('altocupon', $db->Record['cup_imagen_alto'] . '');
}

$t->assign('idcupon', $_REQUEST['idcupon'] . '');

$db->query('SELECT DISTINCT local.loc_id, local.loc_nombre, local.loc_direccion, local.loc_googlemaps FROM local INNER JOIN empresa ON empresa.emp_id = local.emp_id INNER JOIN cupon ON empresa.emp_id = cupon.emp_id INNER JOIN localadherido ON local.loc_id = localadherido.loc_id AND cupon.cup_id = localadherido.cup_id AND empresa.emp_id = localadherido.emp_id WHERE cupon.cup_id = ' . $_REQUEST['idcupon'] . ' AND local.loc_vigente = 1 AND cupon.cup_vigente = 1');

while($db->next_record())
{
	$t->newBlock('localesadh');
	$t->assign('locId', $db->Record['loc_id'] . '');
	//$t->assign('locId', $db->Record['loc_googlemaps'] . '');
	$t->assign('locNom', $db->Record['loc_nombre'] . '');
	if ($_POST['selLocAdh'] == $db->Record['loc_id'])
	{
		$t->assign('_ROOT.direcc', $db->Record['loc_direccion'] . '<br>');
		$t->assign('_ROOT.gmaploc', $db->Record['loc_googlemaps'] . '');
	}
}

//print the result
$t->printToScreen();
?>