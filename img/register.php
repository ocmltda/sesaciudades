<?php 



include 'dbc.php';

$err = array();
					 
if($_POST['doGrabar'] == 'Grabar') 
{ 

foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}



if(empty($data['nombre']) || strlen($data['nombre']) < 4)
{
$err[] = "ERROR - el nombre no válido. Por favor, introduzca al menos 3 o más caracteres de su nombre";

}


if (!isUserID($data['user_name'])) {
$err[] = "ERROR - el nombre válido de usuario. Puede contener alfabeto, números y guión bajo.";

}


if(!isEmail($data['usr_email'])) {
$err[] = "ERROR -  email invalido.";

}

if (!checkPwd($data['pwd'],$data['pwd2'])) {
$err[] = "ERROR - Contraseña no válida o no coincide. Escriba 5 caracteres o más";

}
	  
$user_ip = $_SERVER['REMOTE_ADDR'];


$sha1pass = PwdHash($data['pwd']);


$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');


$activ_code = rand(1000,9999);

$usr_email = $data['usr_email'];
$user_name = $data['user_name'];



$rs_duplicate = mysql_query("select count(*) as total from users where user_email='$usr_email' OR user_name='$user_name'") or die(mysql_error());
list($total) = mysql_fetch_row($rs_duplicate);

if ($total > 0)
{
$err[] = "El nombre de usuario o correo electrónico ya existe. Por favor, inténtelo de nuevo con diferentes 
nombre de usuario y correo electrónico. .";

}


if(empty($err)) {

$sql_insert = "INSERT into `users`
  			(`nombre`,`user_email`,`pwd`,`apellido`,`apellido2`,`isapre`,`rut`,`fax`,`fono`,`website`,`ciudad`,`comuna`,`nom1`,`ape1`,`apem1`,`sexo1`,`parent1`,`fn1`,`email1`,`nom2`,`ape2`,`apem2`,`sexo2`,`parent2`,`fn2`,`email2`,`nom3`,`ape3`,`apem3`,`sexo3`,`parent3`,`fn3`,`email3`,`nom4`,`ape4`,`apem4`,`sexo4`,`parent4`,`fn4`,`email4`,`nom5`,`ape5`,`apem5`,`sexo5`,`parent5`,`fn5`,`email5`,`nom6`,`ape6`,`apem6`,`sexo6`,`parent6`,`fn6`,`email6`,`date`,`users_ip`,`activation_code`,`sexo`,`user_name`
			)
		    VALUES
		    ('$data[nombre]','$usr_email','$sha1pass','$data[apellido]','$data[apellido2]','$data[isapre]','$data[rut]','$data[fax]','$data[fono]','$data[web]','$data[ciudad]'
			,'$data[comuna]','$data[nom1]','$data[ape1]','$data[apem1]','$data[sexo1]','$data[parent1]','$data[fn1]','$data[email1]','$data[nom2]','$data[ape2]','$data[apem2]','$data[sexo2]','$data[parent2]','$data[fn2]','$data[email2]','$data[nom3]','$data[ape3]','$data[apem3]','$data[sexo3]','$data[parent3]','$data[fn3]','$data[email3]','$data[nom4]','$data[ape4]','$data[apem4]','$data[sexo4]','$data[parent4]','$data[fn4]','$data[email4]','$data[nom5]','$data[ape5]','$data[apem5]','$data[sexo5]','$data[parent5]','$data[fn5]','$data[email5]','$data[nom6]','$data[ape6]','$data[apem6]','$data[sexo6]','$data[parent6]','$data[fn6]','$data[email6]',now(),'$user_ip','$activ_code','$data[sexo]','$user_name')";
			
mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
$user_id = mysql_insert_id($link);  
$md5_id = md5($user_id);
mysql_query("update users set md5_id='$md5_id' where id='$user_id'");


if($user_registration)  {
$a_link = " "; 
} else {
$a_link = 
" ";
}

$message = 
"Hola $nombre \n
Bienvenido a tu Club de Beneficios CHP, te invitamos a visitarnos regularmente para que te enteres de los diferentes beneficios que te iremos entregando. Tus datos son: \n

Usuario: $user_name
Email: $usr_email \n 
Contraseña: $data[pwd] \n

$a_link

Gracias


Clínica Hospital del Profesor CHP - Club de Beneficios
$host_upper
______________________________________________________
Este es un mensaje automatico. 
***NO RESPONDA ESTE CORREO****
";

	mail($usr_email, "Detalles del Registro", $message,
    "From: \"Activacion de Registro\" <auto-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion());

  header("Location: thankyou.php");  
  exit();
	 
	 } 
 }					 

?>
<html>
<head>

<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
<!--
function showMe (it, box) {
var vis = (box.checked) ? "block" : "none";
document.getElementById(it).style.display = vis;
}
//-->
</script>
  <script>
  $(document).ready(function(){
    $.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");

    $("#regForm").validate();
  });
  </script>
  
 <script language="JavaScript" type="text/javascript">
function ValRut(rutx)
{
	var count = 0;
	var count2 = 0;
	var factor = 2;
	var suma = 0;
	var sum = 0;
	var digito = 0;
	var arrRut = rutx.split('-');
	
	if(arrRut.length!=2)
	{
		document.getElementById('Verificacion').innerHTML="&nbsp;";
		document.regForm.Submit.disabled='disabled';
		return false;
	}
	
	var rut = arrRut[0];
	var dvIn = arrRut[1];
	

	count2 = rut.length - 1;
	while(count < rut.length) 
	{

		sum = factor * (parseInt(rut.substr(count2,1)));
		suma = suma + sum;
		sum = 0;

		count = count + 1;
		count2 = count2 - 1;
		factor = factor + 1;

		if(factor > 7){factor=2;}

	}
	digito = 11 - (suma % 11);

	if (digito == 11){digito = 0;}
	if (digito == 10) {digito = "k";}
	//form.dig.value = digito;
	
	if(digito==dvIn)
	{
		document.getElementById('Verificacion').innerHTML="<span class='textoAzul'>Rut OK</span>";
		document.regForm.Submit.disabled='';
	}
	else
	{
		document.getElementById('Verificacion').innerHTML="<span class='TextoChicoDestacado'>Rut Erroneo</span>";
		document.regForm.Submit.disabled='disabled';
	}
}
</script>
<link href="styles.css" rel="stylesheet" type="text/css">
<link href="css/nueva.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="675" border="0" align="center" cellpadding="5" cellspacing="0" class="main">
  <tr> 
    <td colspan="3"><img src="img/sesaheader.jpg" width="673" height="120"></td>
  </tr>
  <tr> 
    <td valign="top"><p>&nbsp;</p>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="675" align="center" valign="top" class="fondoregistro"><p>
	<?php 
	 if (isset($_GET['done'])) { ?>
	  <span class="txt">Muchas Gracias,
	  Su registro se ha completado ahora puede ingresar desde</span> <a href="login.php">Aquí</a>";
	 <?php exit();
	  }
	?></p>
      
      <p>
        <?php	
	 if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* $e <br>";
	    }
	  echo "</div>";	
	   }
	 ?>
      </p>
      <form action="register.php" method="post" name="regForm" id="regForm" >
        <table width="675" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><br>
              <br>
            <br>              <img src="img/titular.jpg" width="426" height="33"></td>
          </tr>
        </table>
        <br>
        <table width="600" border="0" cellpadding="0" cellspacing="0">
          <tr></tr>
     
          <tr>
            <td height="35" class="titulosNuestraClinica">Nombre<span class="required"><font color="#CC0000"></font></span><br></td>
            <td height="35" colspan="5"><input name="nombre" type="text" id="nombre" size="40" class="form"></td>
          </tr>
          <tr>
            <td height="35" class="titulosNuestraClinica">Apellido Paterno</td>
            <td height="35" colspan="5"><span class="example">
              <input name="apellido" type="text" id="apellido" size="40" class="form">
            </span></td>
          </tr>
          <tr>
            <td height="35" class="titulosNuestraClinica">Apellido Materno</td>
            <td height="35" colspan="5"><span class="example">
              <input name="apellido2" type="text" id="apellido2" size="40" class="form">
            </span></td>
          </tr>
          <tr>
            <td height="35" class="titulosNuestraClinica">Isapre</td>
            <td height="35" colspan="5"><select name="isapre" class="form" id="isapre">
              <option selected>Seleccione</option>
              <option>--------------------------</option>
              <option value="Fonasa">Fonasa</option>
              <option>-------------------------</option>
              <option value="Consalud">Consalud</option>
              <option value="Colmena Golden Cross">Colmena Golden Cross</option>
              <option value="Cruz Blanca">Cruz Blanca</option>
              <option value="Vida Tres">Vida Tres</option>
              <option value="Ferrosalud">Ferrosalud</option>
              <option value="Masvida">Masvida</option>
              <option>Banm&eacute;dica</option>
            </select></td>
          </tr>
          <tr>
            <td height="35" class="titulosNuestraClinica">Email</td>
            <td height="35" colspan="5"><input name="usr_email" type="text" id="usr_email3" class="form"></td>
          </tr>
          <tr> 
            <td height="35" class="titulosNuestraClinica">Sexo</span></td>
            <td height="35" colspan="5"><select name="sexo" class="form" id="select8">
                <option selected>Seleccione</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select></td>
          </tr>
          <tr> 
            <td height="35" class="titulosNuestraClinica">Rut</td>
            <td height="35" colspan="5"><input name="rut" type="text" class="form" id="rut" onKeyUp="ValRut(this.value);" value="" maxlength="10" />
            <span class="txt"><em>(EJ. 13265254-7)</em></span>            
            <td align="center" class="txt" id="Verificacion">&nbsp;</td>
          
          </tr>
          <tr> 
            <td height="35" class="titulosNuestraClinica">Fecha Nacimiento </td>
            <td height="35" colspan="5"><input name="fax" type="text" id="fax" class="form"> 
            <em><span class="txt">(EJ. dd/mm/aa) </span></em></td>
          </tr>
          <tr>
            <td height="35" class="titulosNuestraClinica">Telefono</td>
            <td height="35" colspan="5"><input name="fono" type="text" class="form" id="fono"></td>
          </tr>
          <tr>
            <td height="35" class="titulosNuestraClinica">Direccion </td>
            <td height="35" colspan="5"><input name="web" type="text" class="form" id="web" size="50"></td>
          </tr>
          <tr>
            <td height="35" class="titulosNuestraClinica">Ciudad</td>
            <td height="35" colspan="5"><input name="ciudad" type="text" class="form" id="ciudad"></td>
          </tr>
          <tr>
            <td height="35" class="titulosNuestraClinica">Comuna</td>
            <td height="35" colspan="5"><input name="comuna" type="text" class="form" id="comuna"></td>
          </tr>
          <tr> 
            <td height="35" colspan="6">&nbsp;</td>
          </tr>
          <tr> 
            
          </tr>
        </table>
        
        <table width="675" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="18" class="titulosNuestraClinica2"><img src="img/cuenta.jpg" width="426" height="33"></td>
          </tr>
        </table>
        <table width="665" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="25" class="titulosNuestraClinica" style="padding-left:10px;"><br>
              Nombre Usuario<br>
              <em><span class="texto">(Se recomienda usar solo min&uacute;sculas o may&uacute;sculas)</span></em><span class="required"><font color="#CC0000"> <br>
              <br>
<br>
            </font></span></td>
            <td colspan="5"><input name="user_name" type="text" id="user_name" class="required username" minlength="5" >
              <input name="btnAvailable" type="button" id="btnAvailable" 
			  onclick='$("#checkid").html("Por favor espere..."); $.get("checkuser.php",{ cmd: "check", user: $("#user_name").val() } ,function(data){  $("#checkid").html(data); });'
			  value="Disponibilidad">
              <span style="color:red; font: bold 12px verdana; " id="checkid" ></span></td>
          </tr>
          <tr>
            <td height="25" class="titulosNuestraClinica" style="padding-left:10px;">Contrase&ntilde;a<br>
            <em><span class="texto">(Se recomienda usar solo min&uacute;sculas o may&uacute;sculas.<br>
            M&iacute;nimo 5 car&aacute;cteres
            )<br>
            <br>
            <br>
            </span></em></td>
            <td colspan="5"><input name="pwd" type="password" minlength="5" id="pwd"></td>
          </tr>
          <tr>
            <td height="25" class="titulosNuestraClinica" style="padding-left:10px;">Confirmar Contrase&ntilde;a<span class="required"><font color="#CC0000"><br>
            </font></span></td>
            <td colspan="5"><input name="pwd2"  id="pwd4" class="required password" type="password" minlength="5" equalto="#pwd"></td>
          </tr>
          <tr>
            <td height="25" class="titulosNuestraClinica">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
          </tr>
        </table>
        <table width="665" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="titulosNuestraClinica2">AGREGA A TU GRUPO FAMILIAR</td>
          </tr>
          <tr>
            <td class="titulos"><input type="checkbox" name="c1" onClick="showMe('div1', this)">
              <span class="txt">              Pincha aqu&iacute; para agregar a otro integrante de tu Grupo Familiar</span></td>
          </tr>
        </table>
        <div id="div1" style="display:none">
          <table width="95%" border="0" cellpadding="0" cellspacing="2" class="forms">
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
            </tr>
            <tr>
              <td width="56">Nombre</td>
              <td width="120"><span ><font color="#CC0000"></font></span>
                <input name="nom1" type="text" id="nom1" size="20" class=""></td>
              <td width="55">Paterno</td>
              <td width="90" class="example"><input name="ape1" type="text" id="ape1" size="15" ></td>
              <td width="57">Materno</td>
              <td width="154" class="example"><input name="apem1" type="text" id="apem1" size="15" ></td>
            </tr>
            <tr>
              <td>Sexo</td>
              <td><select name="sexo1"  id="sexo">
                <option selected> </option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select></td>
              <td>F.Nacimiento</td>
              <td class="example"><input name="fn1" type="text" id="fn1" size="15" ></td>
              <td>email</td>
              <td class="example"><input name="email1" type="text" id="email1" size="15" ></td>
            </tr>
            <tr>
              <td>Parentesco</td>
              <td><select name="parent1"  id="sexo6">
                <option value="Esposa">Esposa</option>
                <option value="Esposo">Esposo</option>
                <option value="Hijo">Hijo</option>
                <option value="Hija">Hija</option>
                <option value="Soltero">Soltero</option>
                <option value="Soltera">Soltera</option>
                <option selected> </option>
              </select></td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
            </tr>
          </table>
          <table width="95%" border="0" class="forms">
            <tr>
              <td class="titulos"><input type="checkbox" name="c2" onClick="showMe('div2', this)">
                Agregar otro miembro a tu Grupo Familiar </td>
            </tr>
          </table>
        </div>
        <div id="div2" style="display:none">
          <table width="95%" border="0" cellpadding="0" cellspacing="2" class="forms">
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;
              </td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
            </tr>
            <tr>
              <td width="56">Nombre</td>
              <td width="120"><span ><font color="#CC0000"></font></span>
                <input name="nom2" type="text" id="nom8" size="20" class=""></td>
              <td width="55">Paterno</td>
              <td width="90" class="example"><input name="ape2" type="text" id="ape8" size="15" ></td>
              <td width="57">Materno</td>
              <td width="154" class="example"><input name="apem2" type="text" id="apem8" size="15" ></td>
            </tr>
            <tr>
              <td>Sexo</td>
              <td><select name="sexo2"  id="sexo8">
                <option selected> </option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select></td>
              <td>F.Nacimiento</td>
              <td class="example"><input name="fn2" type="text" id="fn8" size="15" ></td>
              <td>email</td>
              <td class="example"><input name="email2" type="text" id="mail8" size="15" ></td>
            </tr>
            <tr>
              <td>Parentesco</td>
              <td><select name="parent2"  id="sexo6">
                <option value="Esposa">Esposa</option>
                <option value="Esposo">Esposo</option>
                <option value="Hijo">Hijo</option>
                <option value="Hija">Hija</option>
                <option value="Soltero">Soltero</option>
                <option value="Soltera">Soltera</option>
                <option selected> </option>
              </select></td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
            </tr>
          </table>
          <table width="95%" border="0" class="forms">
            <tr>
              <td class="titulos"><input type="checkbox" name="c3" onClick="showMe('div3', this)">
                 Agregar otro miembro a tu Grupo Familiar </td>
            </tr>
          </table>
        </div>
        <div id="div3" style="display:none">
          <table width="95%" border="0" cellpadding="0" cellspacing="2" class="forms">
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
            </tr>
            <tr>
              <td width="56">Nombre</td>
              <td width="120"><span ><font color="#CC0000"></font></span>
                <input name="nom3" type="text" id="nom2" size="20" class=""></td>
              <td width="55">Paterno</td>
              <td width="90" class="example"><input name="ape3" type="text" id="ape2" size="15" ></td>
              <td width="57">Materno</td>
              <td width="154" class="example"><input name="apem3" type="text" id="apem2" size="15" ></td>
            </tr>
            <tr>
              <td>Sexo</td>
              <td><select name="sexo3"  id="sexo2">
                <option selected> </option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select></td>
              <td>F.Nacimiento</td>
              <td class="example"><input name="fn3" type="text" id="fn2" size="15" ></td>
              <td>email</td>
              <td class="example"><input name="mail" type="text" id="mail" size="15" ></td>
            </tr>
            <tr>
              <td>Parentesco</td>
              <td><select name="parent3"  id="sexo6">
                <option value="Esposa">Esposa</option>
                <option value="Esposo">Esposo</option>
                <option value="Hijo">Hijo</option>
                <option value="Hija">Hija</option>
                <option value="Soltero">Soltero</option>
                <option value="Soltera">Soltera</option>
                <option selected> </option>
              </select></td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
            </tr>
          </table>
          <table width="95%" border="0" class="forms">
            <tr>
              <td class="titulos"><input type="checkbox" name="c4" onClick="showMe('div4', this)">
                 Agregar otro miembro a tu Grupo Familiar </td>
            </tr>
          </table>
        </div>
        <div id="div4" style="display:none">
          <table width="95%" border="0" cellpadding="0" cellspacing="2" class="forms">
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
            </tr>
            <tr>
              <td width="56">Nombre</td>
              <td width="120"><span ><font color="#CC0000"></font></span>
                <input name="nom4" type="text" id="nom3" size="20" class=""></td>
              <td width="55">Paterno</td>
              <td width="90" class="example"><input name="ape4" type="text" id="ape3" size="15" ></td>
              <td width="57">Materno</td>
              <td width="154" class="example"><input name="apem4" type="text" id="apem3" size="15" ></td>
            </tr>
            <tr>
              <td>Sexo</td>
              <td><select name="sexo4"  id="sexo3">
                <option selected> </option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select></td>
              <td>F.Nacimiento</td>
              <td class="example"><input name="fn4" type="text" id="fn3" size="15" ></td>
              <td>email</td>
              <td class="example"><input name="mail2" type="text" id="mail2" size="15" ></td>
            </tr>
            <tr>
              <td>Parentesco</td>
              <td><select name="parent4"  id="sexo6">
                <option value="Esposa">Esposa</option>
                <option value="Esposo">Esposo</option>
                <option value="Hijo">Hijo</option>
                <option value="Hija">Hija</option>
                <option value="Soltero">Soltero</option>
                <option value="Soltera">Soltera</option>
                <option selected> </option>
              </select></td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
            </tr>
          </table>
          <table width="95%" border="0" class="forms">
            <tr>
              <td class="titulos"><input type="checkbox" name="c5" onClick="showMe('div5', this)">
                 Agregar otro miembro a tu Grupo Familiar </td>
            </tr>
          </table>
        </div>
        <div id="div5" style="display:none">
          <table width="95%" border="0" cellpadding="0" cellspacing="2" class="forms">
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
            </tr>
            <tr>
              <td width="56">Nombre</td>
              <td width="120"><span ><font color="#CC0000"></font></span>
                <input name="nom5" type="text" id="nom4" size="20" class=""></td>
              <td width="55">Paterno</td>
              <td width="90" class="example"><input name="ape5" type="text" id="ape4" size="15" ></td>
              <td width="57">Materno</td>
              <td width="154" class="example"><input name="apem5" type="text" id="apem4" size="15" ></td>
            </tr>
            <tr>
              <td>Sexo</td>
              <td><select name="sexo5"  id="sexo4">
                <option selected> </option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select></td>
              <td>F.Nacimiento</td>
              <td class="example"><input name="fn5" type="text" id="fn4" size="15" ></td>
              <td>email</td>
              <td class="example"><input name="mail3" type="text" id="mail3" size="15" ></td>
            </tr>
            <tr>
              <td>Parentesco</td>
              <td><select name="parent5"  id="sexo6">
                <option value="Esposa">Esposa</option>
                <option value="Esposo">Esposo</option>
                <option value="Hijo">Hijo</option>
                <option value="Hija">Hija</option>
                <option value="Soltero">Soltero</option>
                <option value="Soltera">Soltera</option>
                <option selected> </option>
              </select></td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
            </tr>
          </table>
          <table width="95%" border="0" class="forms">
            <tr>
              <td class="titulos"><input type="checkbox" name="c6" onClick="showMe('div6', this)">
                 Agregar otro miembro a tu Grupo Familiar </td>
            </tr>
          </table>
        </div>
        <div id="div6" style="display:none">
          <table width="95%" border="0" cellpadding="0" cellspacing="2" class="forms">
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
            </tr>
            <tr>
              <td width="56">Nombre</td>
              <td width="120"><span ><font color="#CC0000"></font></span>
                <input name="nom6" type="text" id="nom5" size="20" class=""></td>
              <td width="55">Paterno</td>
              <td width="90" class="example"><input name="ape6" type="text" id="ape5" size="15" ></td>
              <td width="57">Materno</td>
              <td width="154" class="example"><input name="apem6" type="text" id="apem5" size="15" ></td>
            </tr>
            <tr>
              <td>Sexo</td>
              <td><select name="sexo6"  id="sexo5">
                <option selected> </option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select></td>
              <td>F.Nacimiento</td>
              <td class="example"><input name="fn6" type="text" id="fn5" size="15" ></td>
              <td>email</td>
              <td class="example"><input name="mail4" type="text" id="mail4" size="15" ></td>
            </tr>
            <tr>
              <td>Parentesco</td>
              <td><select name="parent6"  id="sexo6">
                <option value="Esposa">Esposa</option>
                <option value="Esposo">Esposo</option>
                <option value="Hijo">Hijo</option>
                <option value="Hija">Hija</option>
                <option value="Soltero">Soltero</option>
                <option value="Soltera">Soltera</option>
                <option selected> </option>
              </select></td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="example">&nbsp;</td>
            </tr>
          </table>
          <table width="95%" border="0" class="forms">
            <tr>
            
            </tr>
          </table>
        </div>
        <p>
          <input name="doGrabar" type="submit" id="doGrabar"  value="Grabar">
        </p>
</form>
  
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3"><p>&nbsp;</p>
    <p><br>
  </p>
    <p>&nbsp;</p></td>
  </tr>
</table>
       <div style="visibility: hidden;">

<script language="JavaScript1.4" src="http://www.chp.cl/certifica-js14.js"></script>

<script type="text/javascript" src="http://www.chp.cl/certifica.js"></script>

<script type="text/javascript">

<!--

   

    tagCertifica( 25780, '/home/beneficios/registrese');

-->

</script>
</div>
</body>
</html>
