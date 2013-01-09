<?php require_once('Connections/localhost.php'); ?>
<?php

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = "SELECT nombre, user_name, user_email, apellido, apellido2, isapre, sexo, parent, rut, fax, fono, website, ciudad, comuna, nom1, ape1, apem1, sexo1, parent1, fn1, email1, nom2, ape2, apem2, sexo2, parent2, fn2, email2, nom3, ape3, apem3, sexo3, parent3, fn3, email3, nom4, ape4, apem4, sexo4, parent4, fn4, email4, nom5, ape5, apem5, sexo5, parent5, fn5, email5, nom6, ape6, apem6, sexo6, parent6, fn6, email6 FROM users";
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista de Beneficiarios Ingresados</title>
<style type="text/css">
.titulos {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	font-weight: bold;
}
.datos {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
}
.link {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	text-align: left;
}
</style></head>

<body>
<p><a href="list.php" class="link">Exportar</a></p>
<table border="1" cellpadding="0" cellspacing="0" class="link">
  <tr>
    <td class="titulos">Nombre</td>
    <td class="titulos">Apellido Paterno</td>
    <td class="titulos">Apellido Materno</td>
    <td class="titulos">Isapre</td>
    <td class="titulos">Email</td>
    <td class="titulos">Sexo</td>
    <td class="titulos">Parentesco</td>
    <td class="titulos">Rut</td>
    <td class="titulos">F.Nacimiento</td>   
    <td class="titulos">Telefono</td>
    <td class="titulos">Dirección</td>
    <td class="titulos">Ciudad</td>
    <td class="titulos">Comuna</td>
    <td class="titulos">Nombre Ad-1</td>
    <td class="titulos">Paterno Ad-1</td>
    <td class="titulos">Materno Ad-1</td>
    <td class="titulos">Sexo Ad-1</td>
    <td class="titulos">Parentesco Ad-1</td>
<td class="titulos">F.Nac Ad-1</td>
        <td class="titulos">Email Ad-1</td>
    <td class="titulos">Nombre Ad-2</td>
    <td class="titulos">Paterno Ad-2</td>
    <td class="titulos">Materno Ad-2</td>
    <td class="titulos">Sexo Ad-2</td>
    <td class="titulos">Parentesco Ad-2</td>
    <td class="titulos">F.Nac Ad-2</td>
    <td class="titulos">Email Ad-2</td>
    <td class="titulos">Nombre Ad-3</td>
    <td class="titulos">Paterno Ad-3</td>
    <td class="titulos">Materno Ad-3</td>
    <td class="titulos">Sexo Ad-3</td>
    <td class="titulos">Parentesco Ad-3</td>
<td class="titulos">F.Nac-Ad3</td>
        <td class="titulos">Email Ad-3</td>
    <td class="titulos">Nombre Ad-4</td>
    <td class="titulos">Paterno Ad-4</td>
    <td class="titulos">Materno Ad-4</td>
    <td class="titulos">Sexo Ad-4</td>
    <td class="titulos">Parentesco Ad-4</td>
<td class="titulos">F.Nac Ad-4</td>
        <td class="titulos">Email Ad-4</td>
    <td class="titulos">Nombre Ad-5</td>
    <td class="titulos">Paterno  Ad-5</td>
    <td class="titulos">Materno  Ad-5</td>
    <td class="titulos">Sexo  Ad-5</td>
    <td class="titulos">Parentesco Ad-5</td>
<td class="titulos">F.Nac  Ad-5</td>
            <td class="titulos">Email Ad-5</td>
    <td class="titulos">Nombre  Ad-6</td>
    <td class="titulos">Paterno Ad-6</td>
    <td class="titulos">Materno Ad-6</td>
    <td class="titulos">Sexo Ad-6</td>
    <td class="titulos">Parentesco Ad-6</td>
<td class="titulos">F. Nac. Ad-6</td>
            <td class="titulos">Email Ad-6</td>
  </tr>
  <?php do { ?>
    <tr class="datos">
      <td><?php echo $row_Recordset1['nombre']; ?></td>
      <td><?php echo $row_Recordset1['apellido']; ?></td>
      <td><?php echo $row_Recordset1['apellido2']; ?></td>
      <td><?php echo $row_Recordset1['isapre']; ?></td>
      <td><?php echo $row_Recordset1['user_email']; ?></td>
      <td><?php echo $row_Recordset1['sexo']; ?></td>
      <td><?php echo $row_Recordset1['parent']; ?></td>
      <td><?php echo $row_Recordset1['rut']; ?></td>
      <td><?php echo $row_Recordset1['fax']; ?></td>
      <td><?php echo $row_Recordset1['fono']; ?></td>
      <td><?php echo $row_Recordset1['website']; ?></td>
      <td><?php echo $row_Recordset1['ciudad']; ?></td>
      <td><?php echo $row_Recordset1['comuna']; ?></td>
      <td><?php echo $row_Recordset1['nom1']; ?></td>
      <td><?php echo $row_Recordset1['ape1']; ?></td>
      <td><?php echo $row_Recordset1['apem1']; ?></td>
      <td><?php echo $row_Recordset1['sexo1']; ?></td>
      <td><?php echo $row_Recordset1['parent1']; ?></td>
      <td><?php echo $row_Recordset1['fn1']; ?></td>
      <td><?php echo $row_Recordset1['email1']; ?></td>
      <td><?php echo $row_Recordset1['nom2']; ?></td>
      <td><?php echo $row_Recordset1['ape2']; ?></td>
      <td><?php echo $row_Recordset1['apem2']; ?></td>
      <td><?php echo $row_Recordset1['sexo2']; ?></td>
      <td><?php echo $row_Recordset1['parent2']; ?></td>
      <td><?php echo $row_Recordset1['fn2']; ?></td>
      <td><?php echo $row_Recordset1['email2']; ?></td>
      <td><?php echo $row_Recordset1['nom3']; ?></td>
      <td><?php echo $row_Recordset1['ape3']; ?></td>
      <td><?php echo $row_Recordset1['apem3']; ?></td>
      <td><?php echo $row_Recordset1['sexo3']; ?></td>
      <td><?php echo $row_Recordset1['parent3']; ?></td>
      <td><?php echo $row_Recordset1['fn3']; ?></td>
            <td><?php echo $row_Recordset1['email3']; ?></td>
      <td><?php echo $row_Recordset1['nom4']; ?></td>
      <td><?php echo $row_Recordset1['ape4']; ?></td>
      <td><?php echo $row_Recordset1['apem4']; ?></td>
      <td><?php echo $row_Recordset1['sexo4']; ?></td>
      <td><?php echo $row_Recordset1['parent4']; ?></td>
      <td><?php echo $row_Recordset1['fn4']; ?></td>
            <td><?php echo $row_Recordset1['email4']; ?></td>
      <td><?php echo $row_Recordset1['nom5']; ?></td>
      <td><?php echo $row_Recordset1['ape5']; ?></td>
      <td><?php echo $row_Recordset1['apem5']; ?></td>
      <td><?php echo $row_Recordset1['sexo5']; ?></td>
      <td><?php echo $row_Recordset1['parent5']; ?></td>
      <td><?php echo $row_Recordset1['fn5']; ?></td>
                  <td><?php echo $row_Recordset1['email5']; ?></td>
      <td><?php echo $row_Recordset1['nom6']; ?></td>
      <td><?php echo $row_Recordset1['ape6']; ?></td>
      <td><?php echo $row_Recordset1['apem6']; ?></td>
      <td><?php echo $row_Recordset1['sexo6']; ?></td>
      <td><?php echo $row_Recordset1['parent6']; ?></td>
      <td><?php echo $row_Recordset1['fn6']; ?></td>
                  <td><?php echo $row_Recordset1['email6']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
