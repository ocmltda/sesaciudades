<?php
	require_once('include/funciones.php');

	start_sess();

	//si no existe la sesion entonces voy al login
	if (!isset($_SESSION['xmlSession']) && !isset($_SESSION['rut']) && !isset($_SESSION['dv']))
	{
		header('location: login.php?rf=pr');
	}
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
  
        <table width="100%" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <td bgcolor="white"><h2 class="titulosNuestraClinica2"><strong>Promociones   Vigentes</strong><br>
                <br />
              </h2>
                <table width="100%" cellpadding="0" cellspacing="0">
                  <thead>
                    <tr>
                      <td colspan="2" bgcolor="white"><table width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                        </thead>
                          <tbody>
                            <tr nodeindex="1" jquery1303344246968="40" sizset="1" sizcache="0">
                              <td width="41%" align="center" valign="top" bgcolor="white" class="fondoPrmo"><p>&nbsp;</p>
                                <p><img src="img/pizza.jpg" width="189" height="178" class="imgServClinic"><br>
                                  <br>
                                  <br>
                                  <br>
                                </p></td>
                              <td width="59%" valign="top" bgcolor="white" class="fondoPrmo"><p class="tituloPresupuesto"><br>
                                  Pizza-Pizza<br>
                                  <br>
                                  <span class="titulosNuestraClinica">- Gratis 1 Coca-Cola 2,5 lts. por la compra de cualquier pizza<br>
                                  Ahorro $1950<br>
                                  </span></p>
                                <p class="tituloPresupuesto"><br>
                                  <br>
                                </p></td>
                            </tr>
                            <tr nodeindex="1" jquery1303344246968="40" sizset="1" sizcache="0">
                              <td align="center" valign="top" bgcolor="white" class="fondoPrmo"><br>
                                <img src="img/pizza.jpg" width="189" height="178" class="imgServClinic"><br>
                                <br>
                                <br></td>
                              <td width="59%" valign="top" bgcolor="white" class="fondoPrmo"><span class="txt"><span class="titulosNuestraClinica"><span class="tituloPresupuesto"><br>
                                Pizza-Pizza<br>
                              </span><br>
- Gratis Postre Helado La Cremer&iacute;a Savory. por la compra de cualquier pizza. Ahorro $2.500</span></span></td>
                            </tr>
                            <tr nodeindex="1" jquery1303344246968="40" sizset="1" sizcache="0">
                              <td width="41%" align="center" valign="top" bgcolor="white" class="fondoPrmo"><p>&nbsp;</p>
<p><img src="img/logo_chinawok.jpg" width="189" height="190" class="imgServClinic"></p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p></td>
                              <td valign="top" bgcolor="white" class="fondoPrmo"><p class="tituloPresupuesto"><br>
                                CHINA WOK<br>
                                  <span class="titulosNuestraClinica"><br>
China Pack Mongoliano:</span> <span class="txt">Dos colaciones de carne mongoliana m&aacute;s dos arroz chauf&aacute;s m&aacute;s dos bebidas de 300 cc cada una, por un monto de $5490</span><br>
<br>
<span class="titulosNuestraClinica">China Pack Chapsui: </span><span class="txt">Dos colaciones de chapsui Ave m&aacute;s dos arroz chauf&aacute;n m&aacute;s dos bebidas de 300 cc cada una por un monto de $4790</span><br>
                              </p></td>
                            </tr>
                          </tbody>
                        </table>
                        <table width="100%" cellpadding="0" cellspacing="0">
                          <thead>
               
                        </thead>
                        <tbody>
                          <tr nodeindex="1" jquery1303344246968="40" sizset="1" sizcache="0">
                            <td width="41%" align="center" valign="top" bgcolor="white" class="fondoPrmo"><p>&nbsp;</p>
                              <p><img src="img/outletcoche.jpg" width="189" height="220" class="imgServClinic"> </p></td>
                            <td width="59%" align="left" valign="top" bgcolor="white" class="fondoPrmo"><p class="txt">&nbsp;</p>
                              <p class="tituloPresupuesto">Coche Bebeglo modelo Sigma </p>
                              <p class="txt">Coche Travel System <br>
                                Silla para el auto c/base
                                garantia de 6 meses desde que <br>
                                el bebe nace </p>
                              <p class="txt">Despacho gratis dentro de
                                Santiago<br>
                                <br>
                                <span class="titulosNuestraClinica">Oferta: $139.990 </span><br>
                                <span class="titulosNuestraClinica"><br>
                                  Outlet del bebe<br>
                                  Av. la   Florida #  9404<br>
                                  8914952 - 82691422</span></p></td>
                          </tr>
                        </tbody>
                  </table>
                        <table width="100%" cellpadding="0" cellspacing="0">
                          <thead>
                          </thead>
                          <tbody>
                            <tr nodeindex="1" jquery1303344246968="40" sizset="1" sizcache="0">
                              <td width="41%" align="center" valign="top" bgcolor="white" class="fondoPrmo"><p>&nbsp;</p>
                                <p><img src="img/0502b-300x214.jpg" width="190" height="134" class="imgServClinic"></p></td>
                              <td width="59%" align="left" valign="top" bgcolor="white" class="fondoPrmo"><p class="txt">&nbsp;</p>
                                <p class="tituloPresupuesto"><a href="http://www.mundobebe.cl/cuna-americana-esmaltada-blanca-unica-en-el-mercado" title="Enlace permanente a Cuna Americana Esmaltada Blanca Unica en el Mercado" class="tituloPresupuesto" rel="bookmark">CUNA AMERICANA ESMALTADA BLANCA UNICA EN EL MERCADO</a></p>
                                <p class="txt"><br>
                                  Cuna americana esmaltada blanca &uacute;nica en el mercado&nbsp; 0.75 x 1.41 interior.&nbsp; <br>
                                  2 posiciones somier&nbsp;<br> 
                                  1.- Posici&oacute;n recien nacido somier antirreflujo. <br>
                                  2.- Posici&oacute;n nivel mayor corral.-<br>
                                  <br>
                                  <a href="http://www.mundobebe.cl/cuna-americana-esmaltada-blanca-unica-en-el-mercado">http://www.mundobebe.cl/cuna-americana-esmaltada-blanca-unica-en-el-mercado                                </a><br>
                                  <br>
                                  <span class="titulosNuestraClinica">Avda Dorsal 965, Recoleta. Altura 3200 Metro Dorsal, Linea 2.</span><br>
                                  <a href="http://www.mundobebe.cl/cuna-americana-esmaltada-blanca-unica-en-el-mercado">http://www.mundobebe.cl/</a><br>
                                  <br>
                                </p></td>
                            </tr>
                          </tbody>
                        </table>
                        <p><br>
                        </p></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr nodeindex="1" jquery1303344246968="40" sizset="1" sizcache="0">
                      <td width="41%" align="center" valign="top" bgcolor="white" class="fondoPrmo"><p><br>
                        <img src="img/logonewton.jpg" width="195" height="43" class="imgServClinic"></p></td>
                      <td width="59%" align="left" valign="top" bgcolor="white" class="fondoPrmo"><p class="tituloPresupuesto">&nbsp;</p>
                        <p class="tituloPresupuesto">PROMOCION ESPECIAL DE  NAVIDAD</p>
                        <p class="titulosNuestraClinica">LENTES OPTICOS (ARMAZON  MAS CRISTALES )   $19.990.</p>
                        <p class="txt">Armazon metalico o pastico mas cristales organicos y/o   minerales blancos cuya fuerza dioptrica no se superior de +-4,00/+-2.00<br>
                          <br>
                          <br>
                        </p></td>
                    </tr>
                  </tbody>
                </table>
                <br>
                <table width="100%" cellpadding="0" cellspacing="0">
                  <thead>
                  </thead>
                  <tbody>
                    <tr nodeindex="1" jquery1303344246968="40" sizset="1" sizcache="0">
                      <td width="41%" align="center" valign="top" bgcolor="white" class="fondoPrmo"><p><img src="img/calzarte.jpg" width="96" height="95" class="imgServClinic"></p>
                        <p>&nbsp;</p></td>
                      <td width="59%" valign="top" bgcolor="white" class="fondoPrmo"><p class="tituloPresupuesto">CALZARTE</p>
                        <p class="titulosNuestraClinica">25% de dcto en Calzado de hombre y mujer (no acumulable con otras promociones).<span class="txt"><br>
                        </span></p>
                        <p class="tituloPresupuesto"><br>
                          <br>
                          <br>
                        </p></td>
                    </tr>
                  </tbody>
                </table>
                <h2 class="titulosNuestraClinica2">&nbsp;</h2></td>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      <script language="JavaScript1.4" src="http://www.chp.cl/certifica-js14.js"></script>

<script type="text/javascript" src="http://www.chp.cl/certifica.js"></script>

<script type="text/javascript">

<!--

   

    tagCertifica( 25780, '/home/beneficios/promocion');

-->

</script>
<table width="100%" cellpadding="0" cellspacing="0">
  <thead>
 
  </thead>
  <tbody>
    <tr nodeindex="1" jquery1303344246968="40" sizset="1" sizcache="0">
      <td width="41%" align="center" valign="top" bgcolor="white" class="fondoPrmo"><p>&nbsp;</p>
        <p><img src="img/bartoli.jpg" width="189" height="383" class="imgServClinic"></p></td>
      <td width="59%" align="left" valign="top" bgcolor="white" class="fondoPrmo"><p class="txt"><span class="tituloPresupuesto">BARTOLI BICICLETAS</span><br>
          <span class="texto"><strong><br>
        No pedalee m&aacute;s con estas s&uacute;per ofertas!
<br>
          </strong></span><br>
        <span class="titulosNuestraClinica">Sportiva 100 Valor Lista (Bateria Ni-Mh)</span><br>
        Ahora 395.912 (antes $449.900%<br>
        <span class="titulosNuestraClinica"><br>
        Clasica (Bater&iacute;a Ni-Mh)</span><br>
        Ahora $387.112 (Antes $439.900)<br>
        <br>
        <span class="titulosNuestraClinica">Piccola 100 </span><br>
        Ahora $334.312 (Antes 379.900)
        <br>
          <br>
      </p></td>
    </tr>
  </tbody>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
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
