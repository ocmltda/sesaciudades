<?php
	//header('Content-Type: text/html; charset=utf-8');

	require_once('include/funciones.php');

	start_sess();

	//si existe la sesion entonces entro
	if (isset($_SESSION['xmlSession']) && isset($_SESSION['rut']) && isset($_SESSION['dv']))
	{
		//direccion del Web Service
		$client = new SoapClient(RUTAWS, array('trace' => 1));

		//recupero las variables del formulario de login
		$rut = trim($_POST['rut']) . '';
		$fecinscripcion = trim($_POST['txtFecInsc']) . '';
		$fecinscripcion = explode("-", $fecinscripcion);
		$fecinscripcion = $fecinscripcion[2] . $fecinscripcion[1] . $fecinscripcion[0];
		$fecnacimiento = trim($_POST['txtFecNac']) . '';
		$fecnacimiento = explode("-", $fecnacimiento);
		$fecnacimiento = $fecnacimiento[2] . $fecnacimiento[1] . $fecnacimiento[0];
		$nombre = trim($_POST['txtNombre']) . '';
		$paterno = trim($_POST['txtPaterno']) . '';
		$materno = trim($_POST['txtMaterno']) . '';
		$email = trim($_POST['txtEmail']) . '';
		$sexo = trim($_POST['chkSexo']) . '';
		$telefono = trim($_POST['txtTelefono']) . '';
		$celular = trim($_POST['txtCelular']) . '';
		$parentesco = trim($_POST['txtParentesco']) . '';

		//echo "<br>xmlSession: => " . $_SESSION['xmlSession'] . "|rutCarga: => " .  $rut . "|fecInscripcion: => " . $fecinscripcion . "|fecNacimiento: => " . $fecnacimiento . "|nombre: => " . $nombre . "|paterno => " . $paterno . "|materno: => " . $materno . "|email: => " . $email . "|sexo: => " . $sexo . "|telefono: => " . $telefono . "|celular: => " . $celular . "|parentesco: => " . $parentesco;

		//exit();

		//llamo a la funcion que retorna los datos del titular, ocupando el xmlSession
		$result = $client->updCarga(array("xmlSession" => $_SESSION['xmlSession'], "rutCarga" => $rut, "fecInscripcion" => $fecinscripcion, "fecNacimiento" => $fecnacimiento, "nombre" => $nombre, "paterno" => $paterno, "materno" => $materno, "email" => $email, "sexo" => $sexo, "telefono" => $telefono, "celular" => $celular, "parentesco" => $parentesco));

		//traspaso el resultado a un arreglo
		$response_arr = objectToArray($result);

		//var_dump($response_arr);

		//proceso el xml ocupando una key del retorno de la funcion
		$xmlDatos = trim($response_arr["updCargaReturn"]) . '';
		$xml = simplexml_load_string($xmlDatos);

		//print_r($xml);

		if (!isset($xml->error))
		{
			if ($xml->valor == 'true')
				header('location: cargas.php?rok=1');
			else
				header('location: cargas.php?rok=2');
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