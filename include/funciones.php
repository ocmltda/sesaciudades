<?php
/*
	Manejo de sesiones
	------------------
	Estas funciones permiten el registro de una sesion, la modificacion y la eliminacion de esta.

	newup_var_sess("prodspres", "estevalor");
	$valorVarSesion = $_SESSION["prodspres"]);

	del_sess(); //para eliminar un carro de compra por ejemplo

	//listar los productos del carro de compra
	if (isset($_SESSION["prodspres"]))
	{
		$tmpprods = $_SESSION["prodspres"];
		//echo $tmpprods;
		$items = explode(";", $tmpprods);
		for($i=0; $i<count($items); $i++)
		{
			$producto = explode("|", $items[$i]);

			$db->query("SELECT PRO_NOMBRE FROM PRODUCTO WHERE PRO_ID = " . $producto[0]);//consulta a la BD
			$db->next_record();
			$nombreproducto = trim($db->Record["PRO_NOMBRE"]);

			$productos .= "- " . $nombreproducto . " (" . $producto[1] . ")<br>";
		}
	}
*/

define('RUTAWS', 'http://beneficiosws.ejedigital.cl/ws/services/IDE?wsdl');

function start_sess()
{
	session_start();
}

function newup_var_sess($var, $value)
{
	//session_start();
	//$HTTP_SESSION_VARS["$var"] = "$value";
	$_SESSION[$var] = $value;
}

function del_sess()
{
	session_start();
	//$_SESSION = array();
	session_unset();
	session_destroy();
}

function objectToArray($d) 
{
	if (is_object($d)) 
	{
		$d = get_object_vars($d);
	}

	if (is_array($d)) 
	{
		return array_map(__FUNCTION__, $d);
		//echo array_map(__FUNCTION__, $d);
	}
	else 
	{
		return $d;
		//echo $d;
	}
}
?>