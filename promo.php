<?php
require_once('include/funciones.php');
require_once('include/class.TemplatePower.inc.php');
require_once('include/db_mysql.inc');

start_sess();

//si no existe la sesion entonces voy al login
if (!isset($_SESSION['xmlSession']) && !isset($_SESSION['rut']) && !isset($_SESSION['dv']))
{
	header('location: login.php?rf=pr');
}

//make a new TemplatePower object
$t = new TemplatePower("pla_promo.html");

//let TemplatePower do its thing, parsing etc.
$t->prepare();

//rescato el nombre de la region
$db = new DB_Sql;
	
//listo los cupones de la region
$db->query('SELECT PRO.pro_id, PRO.pro_titulo, PRO.pro_texto, PRO.pro_imagen_nombre, PRO.pro_imagen_ancho, PRO.pro_imagen_alto FROM promocion AS PRO WHERE PRO.pro_vigente = 1 ORDER BY PRO.pro_id DESC');//consulta a la BD

//listo las promociones
while($db->next_record())
{
	$t->newBlock('promociones');

	$t->assign('imgpromo', $db->Record['pro_imagen_nombre'] . '');
	$t->assign('nompromo', $db->Record['pro_titulo'] . '');
	$t->assign('textopromo', str_replace('\n', '<br>', $db->Record['pro_texto']) . '');
	$t->assign('anchopromo', $db->Record['pro_imagen_ancho'] . '');
	$t->assign('altopromo', $db->Record['pro_imagen_alto'] . '');
}

//print the result
$t->printToScreen();
?>