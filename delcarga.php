<?php
	//header('Content-Type: text/html; charset=utf-8');

	require_once('include/funciones.php');

	start_sess();

	//si existe la sesion entonces entro
	if (isset($_SESSION['xmlSession']) && isset($_SESSION['rut']) && isset($_SESSION['dv']))
	{
		//direccion del Web Service
		$client = new SoapClient(RUTAWS, array('trace' => 1));

		//recupero las variables del link
		$rut = trim($_GET['rut']) . '';

		//llamo a la funcion que retorna los datos del titular, ocupando el xmlSession
		$result = $client->delCarga(array("xmlSession" => $_SESSION['xmlSession'], "rutCarga" => $rut));

		//traspaso el resultado a un arreglo
		$response_arr = objectToArray($result);

		//var_dump($response_arr);

		//proceso el xml ocupando una key del retorno de la funcion
		$xmlDatos = trim($response_arr["delCargaReturn"]) . '';
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