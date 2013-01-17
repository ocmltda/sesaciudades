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

$db->query('SELECT DISTINCT LOC.loc_id, LOC.loc_nombre, LOC.loc_direccion, LOC.loc_comuna, LOC.loc_ciudad, LOC.loc_googlemaps FROM `local` AS LOC INNER JOIN localadherido AS LAD ON LOC.loc_id = LAD.loc_id WHERE LAD.cup_id = ' . $_REQUEST['idcupon'] . ' AND LOC.loc_vigente = 1');

while($db->next_record())
{
	$t->newBlock('localesadh');
	$t->assign('locId', $db->Record['loc_id'] . '');
	$t->assign('linkGmap', $db->Record['loc_googlemaps'] . '');
	$t->assign('locNom', $db->Record['loc_nombre'] . '');
	if ($_POST['idlocal'] == $db->Record['loc_id'])
	{
		$t->assign('_ROOT.direcc', $db->Record['loc_direccion'] . '<br>');
		$t->assign('_ROOT.gmaploc', $db->Record['loc_googlemaps'] . '');
	}
}

//print the result
$t->printToScreen();
?>