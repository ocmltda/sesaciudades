<?php
	require_once('include/funciones.php');

	start_sess();

	//si no existe la sesion entonces voy al login
	if (!isset($_SESSION['xmlSession']) && !isset($_SESSION['rut']) && !isset($_SESSION['dv']))
	{
		header('location: login.php');
	}

	if (isset($_GET['rok']))
	{
		if ($_GET['rok'] == 1)
			$msjaddcarga = '<font color="green"><strong>Acci�n realizada correctamente.</strong></font>';
		else
			$msjaddcarga = '<font color="red"><strong>Hubo un error en la acci�n realizada.</strong></font>';
	}
	else
		$msjaddcarga = '';
?>
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mama.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BENEFICIOS CHILE</title>
<style type="text/css">
<!--
body {
	margin-top: 0px;
	margin-bottom: 0px;
	background-color: #CCC;
}
.fondoizq {
	background-image: url(img/fondoizq.jpg);
	background-repeat: repeat-y;
	background-position: right top;
}
.fondoder {
	background-image: url(img/fondoder.jpg);
	background-repeat: repeat-y;
	background-position: left top;
}
-->
</style>
<link href="css/nueva.css" rel="stylesheet" type="text/css" />
<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript">
<!--
function confirmar(mensaje)
{
	return confirm(mensaje);
}
//-->
</script>
<!-- InstanceEndEditable -->

<!--
//-->
</script>
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
<script>
  $(document).ready(function(){
    $("#logForm").validate();
  });
  </script>
</head>

<body class="fondogeneral">
<table  width="951" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="20" rowspan="7">&nbsp;</td>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="951" align="left" valign="top">
         
          <img src="img/1ben.jpg" width="951" height="222" border="0" usemap="#Map"></td>
        </tr>
 
    </table></td>
    <td width="21" rowspan="7">&nbsp;</td>
  </tr>

  <tr>
    <td width="243" align="left" valign="top" bgcolor="#B54515">
      <?php
	  /******************** ERROR MESSAGES*************************************************
	  This code is to show error messages 
	  **************************************************************************/
	  if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "$e <br>";
	    }
	  echo "</div>";	
	   }
	  /******************************* END ********************************/	  
	  ?>
 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="fondosesa" style="padding-left:20px;"><form action="login.php" method="post" name="logForm" id="logForm" >
            <br>
            <br>
            <table border="0" align="left" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="2"  ><img src="img/cuentaben.jpg" width="163" height="23"></td>
              </tr>
              <tr>
                <td height="35" align="left"><img   src="img/rutben.jpg" width="41" height="21" /><br>
                  <span class="texto"><em>Ej: 15815926-8</em></span></td>
                <td height="35"><input name="usr_email" type="text" class="required" id="txtbox" size="15"></td>
              </tr>
              <tr>
                <td height="35" align="left"><img   src="img/clave2.jpg" width="41" height="21" /><br>
                  <span class="texto"><em>Max: 8 d&iacute;gitos</em></span></td>
                <td height="35"><input name="pwd" type="password" class="required password" id="txtbox2" size="15"></td>
              </tr>
              <tr>
                <td height="35" align="left"><br>                  <img src="img/clavessesa.jpg" width="82" height="31" border="0" usemap="#Map3"><br>
                  <br></td>
                <td height="35" align="right"><span style="padding-left:5px; padding-right:5px;">
                  <input name="doIngresar" type="submit" id="doIngresar" value="Ingresar">
                </span></td>
              </tr>
          </table>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
<br>
            <br>
            <br>
            
          </form></td>
        </tr>
      </table><img  style="margin-top:5px;"src="img/cost_ben.jpg" width="236" height="459" border="0" usemap="#Map2">
  

    <br />    <br /></td>
    <td align="left" valign="top" bgcolor="#B54515"  style="padding-left:15px;">
      <table width="693" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="img/sup.jpg" width="693" height="15"></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" style="padding:10px;"><!-- InstanceBeginEditable name="Contenido" -->
   <div class="myaccount">
      <p class="tituloPresupuesto">Mis Cargas<br />
      </p>
      <p><br />
      </p>
      <table width="520" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
	  <tr>
		<td colspan="5">CARGAS REGISTRADAS &nbsp;&nbsp;&nbsp;<?php echo $msjaddcarga; ?></td>
	  </tr>
	  <tr>
		<td width="80">&nbsp;</td>
		<td width="100">&nbsp;</td>
		<td width="100">&nbsp;</td>
		<td width="100">&nbsp;</td>
		<td width="140">&nbsp;</td>
	  </tr>
	  <tr>
		<td><strong>Rut</strong></td>
		<td><strong>Nombre</strong></td>
		<td><strong>Ap. Paterno</strong></td>
		<td><strong>Ap. Materno</strong></td>
		<td>&nbsp;</td>
	  </tr><?php
	//si existe la sesion entonces entro
	if (isset($_SESSION['xmlSession']) && isset($_SESSION['rut']) && isset($_SESSION['dv']))
	{
		//direccion del Web Service
		$client = new SoapClient(RUTAWS, array('trace' => 1));

		//llamo a la funcion que retorna los datos del titular, ocupando el xmlSession
		$result = $client->getCargas(array("xmlSession" => $_SESSION['xmlSession']));

		//traspaso el resultado a un arreglo
		$response_arr = objectToArray($result);

		//var_dump($response_arr);

		//proceso el xml ocupando una key del retorno de la funcion
		$xmlDatos = trim($response_arr["getCargasReturn"]) . '';
		$xml = simplexml_load_string($xmlDatos);

		//print_r($xml);

		if (!isset($xml->error))
		{
			foreach($xml->list->Carga as $val)
			{
				echo '<tr>';
				echo '<td>' . $val->rutCarga . '</td>';
				echo '<td>' . $val->nombre . '</td>';
				echo '<td>' . $val->paterno . '</td>';
				echo '<td>' . $val->materno . '</td>';
				echo '<td><a href="updatecarga.php?rut=' . $val->rutCarga . '">Modificar</a> | <a href="delcarga.php?rut=' . $val->rutCarga . '" onclick="return confirmar(\'�Est� seguro que desea eliminar la carga de rut ' . $val->rutCarga . '?\')">Eliminar</a></td>';
				echo '</tr>';
			}
		}
		else
		{
			header('location: login.php');
		}
	}
	else
	{
		header('location: login.php');
	}
?>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><a href="newcarga.php">Nueva Carga</a></td>
	  </tr>
	</table>
      <p>&nbsp;</p>
    <p>&nbsp;</p>
	</div>
	<?php	
      if (isset($_GET['msg'])) {
	  echo "<div class=\"error\">$_GET[msg]</div>";
	  }
	  	  
	  ?>
        <br />
    <!-- InstanceEndEditable -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><a href="javascript:window.history.back();"><img src="img/volver.jpg" width="58" height="22" border="0"></a></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td><img src="img/bajo.jpg" width="693" height="13"></td>
        </tr>
      </table>
      <br>

     </td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top">
      <img src="img/footerben.jpg" width="956" height="81"></td>
  </tr>
</table>
<map name="Map4">
</map>
<map name="Map"><area shape="rect" coords="600,9,711,26" href="trabajo.php">
  <area shape="rect" coords="801,7,863,26" href="telefonos.php"><area shape="rect" coords="492,1,583,26" href="index.php"><area shape="rect" coords="605,155,708,208" href="credito.php">
  <area shape="rect" coords="24,167,101,200" href="qsomos.php">
  <area shape="rect" coords="129,160,232,199" href="haztesocio.php">
<area shape="rect" coords="721,163,823,199" href="opinion.php">
  <area shape="rect" coords="869,7,934,24" href="opinion.php">
  <area shape="rect" coords="483,160,594,197" href="promo.php">
  <area shape="rect" coords="359,161,472,202" href="cupones.php">
  <area shape="rect" coords="249,163,347,203" href="myaccount.php">
  <area shape="rect" coords="7,18,390,130" href="index.php">
  <area shape="rect" coords="729,9,794,25" href="http://www.ecrgroup.cl/">
  <area shape="rect" coords="846,158,948,207" href="preguntas.php">
</map>

<map name="Map2">
  <area shape="rect" coords="11,11,234,51" href="credito.php">
  <area shape="rect" coords="12,109,232,150" href="preguntas.php">
  <area shape="rect" coords="6,153,228,194" href="haztesocio.php">
  <area shape="rect" coords="-1,230,227,305" href="recetas.php">
  <area shape="rect" coords="8,314,229,385" href="humor.php">
  <area shape="rect" coords="18,395,217,459" href="promo.php">
  <area shape="rect" coords="9,54,231,101" href="conv_regiones.php">
</map>

<map name="Map3">
  <area shape="rect" coords="3,-3,83,13" href="forgot.php">
  <area shape="rect" coords="-1,16,80,31" href="haztesocio.php">
</map>
</body>
<!-- InstanceEnd --></html>
