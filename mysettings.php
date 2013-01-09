<?php
	require_once('include/funciones.php');

	start_sess();

	if (isset($_POST['doSave']))
	{
		if($_POST['doSave'] == 'Guardar')  
		{
			//si existe la sesion entonces entro
			if (isset($_SESSION['xmlSession']) && isset($_SESSION['rut']) && isset($_SESSION['dv']))
			{
				//direccion del Web Service
				$client = new SoapClient(RUTAWS, array('trace' => 1));

				//recupero las variables del formulario de login
				$fecinscripcion = trim($_POST['finsc']) . '';
				$fecnacimiento = trim($_POST['fax']) . '';
				$nombre = trim($_POST['nombre']) . '';
				$paterno = trim($_POST['apellido']) . '';
				$materno = trim($_POST['apellido2']) . '';
				$email = trim($_POST['mail']) . '';
				$sexo = trim($_POST['chkSexo']) . '';
				$telefono = trim($_POST['fono']) . '';
				$celular = trim($_POST['celu']) . '';
				$direccion = trim($_POST['web']) . '';
				$ciudad = trim($_POST['ciudad']) . '';
				$comuna = trim($_POST['comuna']) . '';
				$region = trim($_POST['region']) . '';

				//llamo a la funcion que retorna los datos del titular, ocupando el xmlSession
				$result = $client->updDatosTitular(array("xmlSession" => $_SESSION['xmlSession'], "fecInscripcion" => $fecinscripcion, "fecNacimiento" => $fecnacimiento, "nombre" => $nombre, "paterno" => $paterno, "materno" => $materno, "email" => $email, "sexo" => $sexo, "telefono" => $telefono, "celular" => $celular, "direccion" => $direccion, "ciudad" => $ciudad, "comuna" => $comuna, "region" => $region));

				//traspaso el resultado a un arreglo
				$response_arr = objectToArray($result);
				
				//proceso el xml ocupando una key del retorno de la funcion
				$xmlDatos = trim($response_arr["updDatosTitularReturn"]) . '';
				$xml = simplexml_load_string($xmlDatos);

				if (!isset($xml->error))
				{
					if ($xml->valor == 'true')
						$msg[] = "Sus datos fueron actualizados.";
					else
						$msg[] = "Hubo un error en la accion realizada.";
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
		}
	}

	//si existe la sesion entonces entro
	if (isset($_SESSION['xmlSession']) && isset($_SESSION['rut']) && isset($_SESSION['dv']))
	{
		//direccion del Web Service
		$client = new SoapClient(RUTAWS, array('trace' => 1));

		//llamo a la funcion que retorna los datos del titular, ocupando el xmlSession
		$result = $client->getDatosTitular(array("xmlSession" => $_SESSION['xmlSession']));

		//traspaso el resultado a un arreglo
		$response_arr = objectToArray($result);

		//proceso el xml ocupando una key del retorno de la funcion
		$xmlDatos = trim($response_arr["getDatosTitularReturn"]) . '';
		$xml = simplexml_load_string($xmlDatos);

		if (!isset($xml->error))
		{
			$vrut = $_SESSION['rut'] . '-' . $_SESSION['dv'] . '';
			$vnombre = $xml->nombre . '';
			$vappaterno = $xml->paterno . '';
			$vapmaterno = $xml->materno . '';
			$fecnacimiento = $xml->fecNacimiento;
			$fecnacimiento = substr($fecnacimiento, 6, 2) . '-' . substr($fecnacimiento, 4, 2) . '-' . substr($fecnacimiento, 0, 4);
			$vfecnacimiento = $fecnacimiento . '';
			$vmail = $xml->email . '';
			$sexo = $xml->sexo;
			if ($sexo == 'M')
			{
				$checkedM = 'checked = "checked"';
				$checkedF = '';
			}
			else
			{
				$checkedM = '';
				$checkedF = 'checked = "checked"';
			}
			$vtelefono = $xml->telefono . '';
			$vcelular = $xml->celular . '';
			$vdireccion = $xml->direccion . '';
			$vciudad = $xml->Ciudad . '';
			$vcomuna = $xml->Comuna . '';
			$vregion = $xml->Region . '';
			$fecinscripcion = $xml->fecInscripcion;
			$fecinscripcion = substr($fecinscripcion, 6, 2) . '-' . substr($fecinscripcion, 4, 2) . '-' . substr($fecinscripcion, 0, 4);
			$vfecinscripcion = $fecinscripcion . '';
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

<!--Script para mostrar div oculto que genera credencial -->
<script src="jquery-1.6.2.js"></script>
<script>

function mostrardiv() {

div = document.getElementById('Credencial');

div.style.display = "block";

}

</script>

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
            <?php
			echo "<p>";
			
			//echo $_SESSION['xmlSession'] . '|' . $_SESSION['rut'] . '|' . $_SESSION['dv'];
			//exit();

	  if(isset($_POST['correo'])){
		$mail = $_POST['email'];
		$beneficiario = $_POST['beneficiario'];
		$randomm = $_POST['archivo'];
		$mensaje = '<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		</head>
		
		<body>
		<p>Estimado beneficiario:</p>
		<p>Se ha generado la credencial correspondiente a '.$beneficiario.',</p>
		<p>Atte.</p>
		<p>BENEFICIOS CHILE.</p>
		<p><img src="http://www.beneficioschile.cl/credencial/credenciales/'.$randomm.'.jpg" /></p>
		</body>
		</html>';
		$asunto = 'Credencial BENEFICIOS CHILE';
		$cabeceras = 'Content-Type: text/html; charset=iso-8859-1';
		mail($mail,$asunto,$mensaje, $cabeceras);
		echo "<h3 class='titulosNuestraClinica2'>La credencial ha sido enviada al correo entregado por el usuario.</h3><p>&nbsp;</p>";
		echo "</p>";
		

		}
	  ?>
      
      <h3 class="titulosNuestraClinica2">Mis datos</h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">   <?php

			/*echo "<p>";

	  if(isset($_POST['correo'])){

		$mail = $_POST['email'];

		$beneficiario = $_POST['beneficiario'];

		$randomm = $_POST['archivo'];

		$mensaje = '<html>

		<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		</head>

		

		<body>

		<p>Estimado beneficiario2:</p>

		<p>Se ha generado la credencial correspondiente a '.$beneficiario.',</p>

		<p>Atte.</p>

		<p>BENEFICIOS CHILE</p>

		<p><img src="http://www.sesaclub.cl/beneficioschile/credencial/credenciales'.$randomm.'.jpg" /></p>

		</body>

		</html>';

		$asunto = 'Credencial BENEFICIOS CHILE';

		$cabeceras = 'Content-Type: text/html; charset=iso-8859-1';

		mail($mail,$asunto,$mensaje, $cabeceras);

		echo "<h3 class='titulosNuestraClinica2'>La credencial ha sido enviada al correo entregado por el usuario.</h3><p>&nbsp;</p>";

		echo "</p>";

		



		}*/

	  ?>
            <p> 
              <?php	
	if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* Error - $e <br>";
	    }
	  echo "</div>";	
	   }
	   if(!empty($msg))  {
	    echo "<div class=\"msg\">" . $msg[0] . "</div>";

	   }
	  ?>
            </p>
      <p align="center">

        <span class="titulosNuestraClinica2"><a href="javascript:mostrardiv();" ><img src="img/crear.jpg" width="199" height="46" border="0"> </a></br>

        </span></p>

        <?php

	   $titular = $vnombre.' '.$vappaterno.' '.$vapmaterno.' ';
	   $titular = strtoupper($titular);

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
				$kq = 0;
				foreach($xml->list->Carga as $val)
				{
					$c[$kq] = strtoupper($val->nombre).' '.strtoupper($val->paterno).' '.strtoupper($val->materno).' ';
					$kq++;
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

      <p align="center">

      <div id="Credencial" style="display:none" align="center">

      <form method="post" action="credencial/tarjeta.php">

      <select name="nombre">

      <option><?php echo $titular ?></option>

      <?php for($i=0; $i<$kq; $i++){

		  	if($c[$i] != '   '){

			echo '<option>'.$c[$i].'</option>';

			}

		 }?>

      </select>

      </p>

      <input type="hidden" name="session" value="<?php if (isset($_SESSION['user_id'])) echo $_SESSION['user_id'] ?>"/>

      <input type="hidden" name="contador" value="<?php if (isset($c[6])) echo $c[6] ?>"/>

      <input type="hidden" name="creden" value="<?php if (isset($c[7])) echo $c[7] ?>"/>
      
	  <input type="hidden" name="xmlSess" value="<?php echo base64_encode($_SESSION['xmlSession']) ?>"/>
      
	  <input type="hidden" name="xmlRut" value="<?php echo base64_encode($_SESSION['rut']) ?>"/>
      
	  <input type="hidden" name="xmlDv" value="<?php echo base64_encode($_SESSION['dv']) ?>"/>

		<p>&nbsp;</p>

      <p align="center">

      <input type="submit" name="Generar" value="Generar"/>

      </form>

      </div>

       </p>   

      <p>&nbsp;</p>
		</td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <form action="mysettings.php" method="post" name="myform" id="myform">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
            <td height="30" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
		  <tr>
            <td width="27%" bgcolor="#FFFFFF" class="titulosNuestraClinica">Rut</td>
            <td width="73%" height="30" bgcolor="#FFFFFF"><span class="texto"><?php echo $vrut; ?>
            </span></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="titulosNuestraClinica"> Nombre </td>
            <td height="30" bgcolor="#FFFFFF"><span class="texto">
              <input name="nombre" type="text" id="nombre"  class="required" value="<?php echo $vnombre; ?>" size="50" maxlength="100">
            </span></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="titulosNuestraClinica">Apellido Paterno</td>
            <td height="30" bgcolor="#FFFFFF"><span class="texto">
              <input name="apellido" type="text" id="apellido"  class="required" value="<?php echo $vappaterno; ?>" size="50" maxlength="50">
            </span></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="titulosNuestraClinica">Apellido Materno</td>
            <td height="30" bgcolor="#FFFFFF"><span class="texto">
              <input name="apellido2" type="text" id="apellido2"  class="required" value="<?php echo $vapmaterno; ?>" size="50" maxlength="50">
            </span></td>
          </tr>
		  <tr>
            <td bgcolor="#FFFFFF" class="titulosNuestraClinica">Fecha Nacimiento</td>
            <td height="30" bgcolor="#FFFFFF"><span class="texto">
              <input name="fax" type="text" id="fax" value="<?php echo $vfecnacimiento; ?>" size="12" maxlength="10">
            </span></td>
          </tr>
		  <tr>
            <td bgcolor="#FFFFFF" class="titulosNuestraClinica">Email</td>
            <td height="30" bgcolor="#FFFFFF"><span class="texto">
              <input name="mail" type="text" id="mail" value="<?php echo $vmail; ?>" size="50" maxlength="100">
            </span></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="titulosNuestraClinica">Sexo</td>
            <td height="30" bgcolor="#FFFFFF"><span class="texto">
              <input name="chkSexo" type="radio" id="radio" value="M" <?php echo $checkedM; ?> />
        Masculino
        <input type="radio" name="chkSexo" id="radio2" value="F" <?php echo $checkedF; ?> />
        Femenino
              </span></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="titulosNuestraClinica">Telefono</td>
            <td height="30" bgcolor="#FFFFFF"><span class="texto">
              <input name="fono" type="text" id="fono" value="<?php echo $vtelefono; ?>" size="16" maxlength="15">
            </span>          
          </tr>
		  <tr>
            <td bgcolor="#FFFFFF" class="titulosNuestraClinica">Celular</td>
            <td height="30" bgcolor="#FFFFFF"><span class="texto">
              <input name="celu" type="text" id="celu" value="<?php echo $vcelular; ?>" size="16" maxlength="15">
            </span>          
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="titulosNuestraClinica">Direccion</td>
            <td height="30" bgcolor="#FFFFFF"><span class="texto">
              <input name="web" type="text" id="web" value="<?php echo $vdireccion; ?>" size="50" maxlength="250">
            </span>        
          </tr>
		  <tr>
            <td bgcolor="#FFFFFF" class="titulosNuestraClinica"><span class="titulosNuestraClinica">Comuna</span></td>
            <td height="30" bgcolor="#FFFFFF"><input name="comuna" type="text" id="comuna" value="<?php echo $vcomuna; ?>" size="50" maxlength="50"></td>
          </tr>
		  <tr class="texto">
            <td bgcolor="#FFFFFF" class="titulosNuestraClinica">Ciudad</td>
            <td height="30" bgcolor="#FFFFFF"><input name="ciudad" type="text" id="ciudad" value="<?php echo $vciudad; ?>" size="50" maxlength="50"></td>
          </tr>
		  <tr>
            <td bgcolor="#FFFFFF" class="titulosNuestraClinica"><span class="titulosNuestraClinica">Region</span></td>
            <td height="30" bgcolor="#FFFFFF"><input name="region" type="text" id="region" value="<?php echo $vregion; ?>" size="50" maxlength="50"></td>
          </tr>
		  <tr>
            <td bgcolor="#FFFFFF" class="titulosNuestraClinica">Fecha Inscripcion</td>
            <td height="30" bgcolor="#FFFFFF"><span class="texto">
              <input name="finsc" type="text" id="finsc" value="<?php echo $vfecinscripcion; ?>" size="12" maxlength="10">
            </span></td>
          </tr>
          <tr class="texto">
            <td colspan="2" bgcolor="#FFFFFF" class="titulosNuestraClinica"><p><br>
            </p></td>
            </tr>
        </table>
        <br>
        <p align="center"> 
          <input name="doSave" type="submit" id="doSave" value="Guardar">
</p>
    </form>
      <h3 class="titulosNuestraClinica2">&nbsp;</h3>
      <p><span class="titulosNuestraClinica2">Mis Cargas</span>      <br>
        <span class="txt">Para agregar, modificar y administrar sus cargas, haga click en el siguiente boton: </span><br>
      </p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><a href="cargas.php"><img src="img/cargas.jpg" width="141" height="30" border="0"></a></td>
        </tr>
    </table>
      <p>&nbsp;</p>
      <h3 class="titulosNuestraClinica2">Cambiar Contrase&ntilde;a</h3>
      <p>&nbsp;</p>
      <form name="pform" id="pform" method="post" action="">
        <table width="80%" border="0" align="center" cellpadding="3" cellspacing="3" class="forms">
          <tr> 
            <td width="31%" class="txt">Contrase&ntilde;a Antigua </td>
            <td width="69%"><input name="pwd_old" type="password" class="required password"  id="pwd_old"></td>
          </tr>
          <tr> 
            <td class="txt">Nueva Contrase&ntilde;a</td>
            <td><input name="pwd_new" type="password" id="pwd_new" class="required password"  ></td>
          </tr>
        </table>
        <p align="center"> 
          <input name="doUpdate" type="submit" id="doUpdate" value="modificar">
        </p>
        <p>&nbsp; </p>
      </form>
      <?php 
/*********************** MYACCOUNT MENU ****************************
This code shows my account menu only to logged in users. 
Copy this code till END and place it in a new html or php where
you want to show myaccount options. This is only visible to logged in users
*******************************************************************/
if (isset($_SESSION['user_id'])) {?>
<div class="myaccount">
  <p><a href="myaccount.php">Volver</a><br>
    <a href="logout.php">Cerrar Sesion </a></p>
  <p><a href="myaccount.php"></a></p>
  <p>&nbsp;</p></div>
<?php } 
/*******************************END**************************/
?>
      </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>
	   
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
