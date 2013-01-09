<html> 
<head> 
   <title></title> 
</head> 
<body>

<?php 
function Conectarse() 
{ 
   if (!($link=mysql_connect("localhost","chpcl_login","sesa2011"))) 
   { 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   if (!mysql_select_db("chpcl_login",$link)) 
   { 
      echo "Error seleccionando la base de datos."; 
      exit(); 
   } 
   return $link; 
} 

$link=Conectarse(); 
echo "Base de datos conseguida.<br>"; 

mysql_close($link); //cierra la conexion 
?>

</body> 
</html>