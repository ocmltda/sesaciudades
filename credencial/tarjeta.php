<?php

require_once('../include/funciones.php');

start_sess();

//si existe la sesion entonces entro
if (isset($_SESSION['xmlSession']) && isset($_SESSION['rut']) && isset($_SESSION['dv']))
{
	// texto a convertir

	if(isset($_POST['Generar']))
	{
		$nombre = strtoupper($_POST['nombre']);

		//$empresa = $_POST['empresa'];
		$empresa = '';
		if (isset($_POST['rut']))
			$rut = $_POST['rut'];
		else
			$rut = '';
	}

	// Imagen de fondo

	$im = imagecreatefromjpeg('tarjeta.jpg');


	//Fuente y color

	$font ='./goth.ttf';

	$font_size = 16;

	$font_color =  0x2C4176;

	$font_color2 =  0x373737;



	// Impresion del Texto segun los parametros de acontinuacion

	//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )

	imagettftext($im, $font_size, 0, 38, 230, $font_color2, $font, $nombre); //Fondo blanco Nombre
	//imagettftext($im, $font_size, 0, 261, 391, $font_color2, $font, $rut); //Fondo blanco Nombre
	//imagettftext($im, $font_size, 0, 260, 98, $font_color, $font, $empresa); //texto azul Nombre






	// mostrar la imagen

	//header("Content-type: image/jpeg");

	$random = rand();

	imagejpeg($im,'credenciales/'.$random.'.jpg');

	imagedestroy($im);

	//start_sess();

	newup_var_sess('xmlSession', base64_decode($_POST['xmlSess']));
	newup_var_sess('rut', base64_decode($_POST['xmlRut']));
	newup_var_sess('dv', base64_decode($_POST['xmlDv']));
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script src="../SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css">
</head>
<style type="text/css">
.txt {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #039;
}
.Titulo {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 15px;
	color: #F90;
}
a {
	font-weight: bold;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
a:link {
	text-decoration: none;
	color: #039;
}
a:visited {
	text-decoration: none;
	color: #039;
}
a:hover {
	text-decoration: none;
	color: #06C;
}
a:active {
	text-decoration: none;
	color: #039;
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="470"><table width="450" border="0">
      <tr>
        <td colspan="2"><p><img src="credenciales/<?php echo $random ?>.jpg" /></p>
          <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td width="141" class="txt">Imprimir Credencial:</td>
        <td width="299"><input type="button" name="imprimir" value="Imprimir" onclick='window.print();'/></td>
      </tr>
      <form id="formcorreo" name="formcorreo" method="post" action="../mysettings.php">
        <tr>
          <td class="txt">Enviar por email:</td>
          <td><input name="email" type="text" class="txt" size="50" /></td>
          <input type="hidden" name="beneficiario" value="<?php echo $nombre ?>"/>
          <input type="hidden" name="archivo" value="<?php echo $random ?>"/>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" name="correo" value="Enviar" /></td>
        </tr>
      </form>
    </table></td>
    <td align="left" valign="top"><p class="Titulo">Preguntas Frecuentes:</p>
      <div id="Accordion1" class="Accordion" tabindex="0">
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">1.<a href="../preguntas.php"> &iquest;Quieres enviar tu Credencial Digital por Correo electr&oacute;nico a tu PC o Celular?</a> <br>
            <br>
          </div>
          <div class="AccordionPanelContent"><br>
            <span class="txt"><br>
             Enviar imagen por correo electr&oacute;nico,  como archivo adjunto, para esto una vez que generaste la Credencial Digital de la persona que deseas, debes parar tu cursor sobre la imagen, y seleccionas el bot&oacute;n derecho de tu mouse sobre la imagen de la Credencial Digital, y puede seleccionar : el tama&ntilde;o con el cual la deseas enviar, una vez seleccionado el tama&ntilde;o, te generar&aacute; un correo nuevo para que lo env&iacute;es a la direcci&oacute;n que desees, debiera ser tu direcci&oacute;n de correo, para que la bajes en tu PC o en tu celular.<br>
            <br>
            </span><br>
            <br>
<br>
          </div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab"> 2. <a href="../preguntas.php">&iquest;Quieres enviar un correo con la imagen de la Credencial Digital como archivo adjunto en un correo electr&oacute;nico ?</a><br>
            <br>
          </div>
          <div class="AccordionPanelContent"><br>
            <br>
            <span class="txt">Enviar imagen por correo electr&oacute;nico,  como archivo adjunto, para esto una vez que generaste la Credencial Digital de la persona que deseas, debes parar tu cursor sobre la imagen, y seleccionas el bot&oacute;n derecho de tu mouse sobre la imagen de la Credencial Digital, y puede seleccionar : el tama&ntilde;o con el cual la deseas enviar, una vez seleccionado el tama&ntilde;o, te generar&aacute; un correo nuevo para que lo env&iacute;es a la direcci&oacute;n que desees, debiera ser tu direcci&oacute;n de correo, para que la bajes en tu PC o en tu celular.<br>
          </span> </div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">3. &iquest;<a href="../preguntas.php">Quieres guardar la imagen de tu Credencial Digital en tu pc ?</a><br>
            <br>
          </div>
          <div class="AccordionPanelContent"><span class="txt"><br>
            <br>
          Guardar la Imagen como,  ,para esto una vez que generaste la Credencial Digital de la persona que deseas, debes parar tu cursor sobre la imagen, y seleccionar el bot&oacute;n derecho de tu mouse sobre la imagen de la Credencial Digital, y seleccionas Guardar Imagen como, la cual la podr&aacute;s grabar en tu PC o Celular como archivo JPG, te recomendamos que la guardes con un nombre descriptivo y f&aacute;cil ( Credencia Digital Beneficios Chile Juan P&eacute;rez  ), despu&eacute;s la podr&aacute;s rescatar como cualquier imagen que tengas guardada.</span></div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">4. &iquest;<a href="../preguntas.php">Quieres copiar la imagen de Tu Credencial Digital en alg&uacute;n archivo? ( Word, excel, power point )</a><br>
            <br>
          </div>
          <div class="AccordionPanelContent"><br>
          <span class="txt">Copiar Imagen, para esto una vez que generaste la Credencial Digital de la persona que deseas, debes parar tu cursor sobre la imagen, y seleccionas el bot&oacute;n derecho de tu mouse sobre la imagen de la Credencial Digital, y seleccionas Copiar, y luego puedes pegar la imagen de la Credencial Digital, en un archivo, Word, excel o power point. </span> </div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab"> 5. &iquest;<a href="../preguntas.php">Deseas imprimir tu Credencial Digital de manera &oacute;ptima ?</a><br>
            <br>
            <br>
          </div>
          <div class="AccordionPanelContent"><br>
          <span class="txt">Una vez que gener&eacute; la Credencial Digital deseada, se recomienda, debes parar tu cursor sobre la imagen, y seleccionas el bot&oacute;n derecho de tu mouse sobre la imagen de la Credencial Digital, y seleccionas Imprimir Imagen, y te dar&aacute; las opciones para una limpia impresi&oacute;n de la imagen, a todo color o en blanco y negro.</span></div>
        </div>
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><a href="../mysettings.php"><img src="../img/volver.jpg" width="58" height="22" border="0"></a></td>
  </tr>
</table>
<script type="text/javascript">
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
</script>
</html>