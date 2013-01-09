<?php
/*
	Funcion paginar
	---------------
	Esta funcion funciona con las clase db_mysql.inc y class.template.php
	regXpag = registros por pagina
	pagActual = pagina actual en la que se encuentra
	consultaSql = consulta de seleccion de registros

	NOTA: En la plantilla de listado de registros deben estar declaradas las variables:
	{previous} = pagina anterior
	{pages} = lista de links de paginas
	{next} = siguiente pagina
*/

$lang_default = 1;

function paginar($regXpag, $pagActual=1)
{
	global $t;
	global $db;
	global $SQL;
	global $PHP_SELF;
	global $INST2;
	global $SQL2;
	global $GRUPO;

	$db->query($SQL);		//consulta a la BD
	$numRegistros = $db->num_rows();
	$numPaginas = ceil($numRegistros/$regXpag);

	if (!$pagActual)
		$pagActual = 1;

	for ($i=1; $i<=$numPaginas; $i++) {
		if ($i==$pagActual) {
			$listaPag .= "<B>$i</B>&nbsp; ";
		}
		else {
			$listaPag .= "<A HREF=\"$PHP_SELF?pag=$i&SQL=$SQL2&search=si\" onMouseOver=\"window.status='P&aacute;gina $i';return true\" onMouseOut=\"window.status='';return true\">$i</A>&nbsp; ";
		}
	}

	$posReg = ($pagActual - 1)*$regXpag;
	$SQL .= " LIMIT $posReg, $regXpag";

	if ($pagActual>1)
	{
		$i = $pagActual - 1;
		//$t->set_var("previous", "<A HREF=\"$PHP_SELF?pag=$i&INST=$INST2&SQL=$SQL2&GRUPO=$GRUPO\" onMouseOver=\"window.status='P&aacute;gina $i';return true\" onMouseOut=\"window.status='';return true\">Anterior</A>");
		$t->set_var("previous", "<A HREF=\"$PHP_SELF?pag=$i&SQL=$SQL2&search=si\" onMouseOver=\"window.status='P&aacute;gina $i';return true\" onMouseOut=\"window.status='';return true\"><IMG SRC='/ilamore/admin/images/izq.gif' WIDTH='20' HEIGHT='20' BORDER='0' ALT='Página Anterior ($i)'></A>");
	}

	$t->set_var("pages", $listaPag);

	if ($pagActual<$numPaginas)
	{
		$i = $pagActual + 1;
		//$t->set_var("next", "<A HREF=\"$PHP_SELF?pag=$i&INST=$INST2&SQL=$SQL2&GRUPO=$GRUPO\" onMouseOver=\"window.status='P&aacute;gina $i';return true\" onMouseOut=\"window.status='';return true\">Siguiente</A>");
		$t->set_var("next", "<A HREF=\"$PHP_SELF?pag=$i&SQL=$SQL2&search=si\" onMouseOver=\"window.status='P&aacute;gina $i';return true\" onMouseOut=\"window.status='';return true\"><IMG SRC='/ilamore/admin/images/der.gif' WIDTH='20' HEIGHT='20' BORDER='0' ALT='Página Siguiente ($i)'></A>");
	}
}

function max_chars($texto, $largo)
{
	$len_texto = strlen($texto);
	if ($texto)
	{
		if ($len_texto > $largo)
		{
			$texto = substr($texto, 0, $largo) . "...";
		}
	}
	return $texto;
}

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

function infoimagen($imagen, &$ancho, &$alto)
{
	$info = GetImageSize($imagen);
	$ancho = $info[0];
	$alto = $info[1];
}

function infoimagenresize(&$ancho, &$alto, $max)
{
	if (($max >= $ancho) && ($max >= $alto))
		$nFactor = 1;
	elseif ($ancho > $alto)
		$nFactor = $ancho/$max;
	else
		$nFactor = $alto/$max;

	$ancho = ceil($ancho/$nFactor);
	$alto = ceil($alto/$nFactor);
}
?>