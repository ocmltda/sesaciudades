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
<style type="text/css">
.Estilo2 {color: #333333}
.style12 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.style5 {font-size: 10px}
</style>
<style type="text/css">
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
</style>
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
      <p>
        <?php



if(isset($_POST[nombre])) {

$ip	=	$_SERVER['REMOTE_ADDR'];
$headers = "From: $email\r\n" . "MIME-Version: 1.0\n" . "Content-type: text/plain; charset=iso-8859-1"; 

$sub="SOLICITUD SOCIO BENEFICIOS CHILE";

$mensaje=":: SOLICITUD SOCIO BENEFICIOS CHILE " . chr(13). chr(10);


$mensaje=$mensaje . "Nombre: " . $_POST[nombre]        . chr(13). chr(10);

$mensaje=$mensaje . "Apellido " . $_POST[apellido]        . chr(13). chr(10);

$mensaje=$mensaje . "Apellido Materno " . $_POST[apellido2]        . chr(13). chr(10);

$mensaje=$mensaje . "Direccion " . $_POST[direccion]        . chr(13). chr(10);

$mensaje=$mensaje . "Rut " . $_POST[rut]        . chr(13). chr(10);

$mensaje=$mensaje . "Region: "   . $_POST[region]      . chr(13). chr(10);

$mensaje=$mensaje . "Telefono: " . $_POST[codigo] .  " " . $_POST[telefono]        . chr(13). chr(10);

$mensaje=$mensaje . "E-mail: " . $_POST[email]      . chr(13). chr(10);


$mensaje=$mensaje . "--------------------------------------------------------------------" . chr(13). chr(13). chr(10);
$mensaje=$mensaje . "COMENTARIOS" . chr(13). chr(13). chr(10);
$mensaje=$mensaje . "--------------------------------------------------------------------" . chr(13). chr(13). chr(10);

$mensaje=$mensaje . "Comentarios: " . $_POST[text]      . chr(13). chr(10);
}

      mail("rquezada@sesa.cl, ricardo.quezada.marin@gmail.com, gvillarino@sesa.cl, mvillarino@ecrgroup.cl", $sub, $mensaje, $headers);

?>
        <?php



if(isset($_POST[nombre])) {



$sub2=":: Desde beneficioschile.cl :: CONTACTO " . chr(13). chr(10);

$mensaje2= "Estimado Socio / a $_POST[nombre]  
Muchas gracias por tu participación. Hemos recibido tu comentario exitosamente.
Saludos Cordiales 
Beneficios Chile
 " . chr(13). chr(13). chr(10);
$headers2= "From: info@beneficioschile.cl\r\n" . "Reply-To: info@beneficioschile.cl\r\n" . "Return-path: info@beneficioschile.cl\r\n" . "MIME-Version: 1.0\n" . "Content-type: text/plain; charset=iso-8859-1"; 

}

      mail($_POST[email], $sub2, $mensaje2,  $headers2);




?>
      </p>
      <h2 class="titulosNuestraClinica2">Gracias!</h2>
      <p class="texto">Tu mensaje ha sido enviado, usando la siguiente direcci&oacute;n de correo electr&oacute;nico </p>
      <p class="style10"><span style="color:red;font-weight:bold;"> <?php print $_POST[email]; ?></span></p>
      <p class="texto">Si no es correcto, vuelve atras y envialo de nuevo
        <script type='text/javascript'>
      document.write('<p class="details"><a href="javascript:history.go(-2);">Volver a la p&aacute;gina de inicio.</a></p>');
                          </script>
        <script type='text/javascript'>
      setTimeout('history.go(-2)', 9000);
                          </script>
        <noscript>
        </noscript>
      <noscript>
      <p class="texto">Pulsa el boton &quot;atras&quot; en tu navegador para volver a la p&aacute;gina anterior.</p>
      </noscript>
      <p><br />
        <br />
      </p>
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
