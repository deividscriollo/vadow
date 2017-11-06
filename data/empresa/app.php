<?php 
	if(!isset($_SESSION)) {
        session_start();        
    }

	include_once('../../admin/datos_sri.php');
	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();
	error_reporting(0);

	if (isset($_POST['btn_guardar']) == "btn_guardar") {
		// contador empresa
		$id_empresa = 0;
		$resultado = $class->consulta("SELECT max(id) FROM empresa");
		while ($row = $class->fetch_array($resultado)) {
			$id_empresa = $row[0];
		}
		$id_empresa++;
		// fin

		$resp = $class->consulta("INSERT INTO empresa VALUES (	'$id_empresa',
																'$_POST[ruc]',
																'$_POST[razon_social]',
																'$_POST[nombre_comercial]',
																'$_POST[actividad_economica]',
																'$_POST[representante_legal]',
																'$_POST[identificacion_representante]',
																'$_POST[telefono1]',
																'$_POST[telefono2]',
																'$_POST[ciudad]',
																'$_POST[direccion_matriz]',
																'$_POST[direccion_establecimiento]',
																'$_POST[establecimiento]',
																'$_POST[punto_emision]',
																'$_POST[correo]',
																'$_POST[sitio_web]',
																'$_POST[slogan]',
																'empresa.png',
																'$_POST[observaciones]',
																'1', 
																'$fecha');");	
		$data = 1;
		echo $data;
	}

	if (isset($_POST['btn_modificar']) == "btn_modificar") {

		$resp = $class->consulta("UPDATE empresa SET	ruc = '$_POST[ruc]',
														razon_social = '$_POST[razon_social]',
														nombre_comercial = '$_POST[nombre_comercial]',
														actividad_economica = '$_POST[actividad_economica]',
														representante_legal = '$_POST[representante_legal]',
														identificacion_representante = '$_POST[identificacion_representante]',
														telefono1 = '$_POST[telefono1]',
														telefono2 = '$_POST[telefono2]',
														ciudad = '$_POST[ciudad]',
														direccion_matriz = '$_POST[direccion_matriz]',
														direccion_establecimiento = '$_POST[direccion_establecimiento]',
														establecimiento = '$_POST[establecimiento]',
														punto_emision = '$_POST[punto_emision]',
														correo = '$_POST[correo]',
														sitio_web = '$_POST[sitio_web]',
														slogan = '$_POST[slogan]',
														observaciones = '$_POST[observaciones]',
														fecha_creacion = '$fecha' WHERE id = '$_POST[id]'");

		$data = 2;
		echo $data;
	}

	//comparar identificaciones empresa
	if (isset($_POST['comparar_ruc'])) {
		$cont = 0;

		$resultado = $class->consulta("SELECT * FROM empresa E WHERE  E.ruc_empresa = '$_POST[ruc]' AND estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$cont++;
		}

		if ($cont == 0) {
		    $data = 0;
		} else {
		    $data = 1;
		}
		echo $data;
	}
	// fin

	// consultar ruc
	if (isset($_POST['consulta_ruc'])) {
		$ruc = $_POST['txt_ruc'];
		$servicio = new ServicioSRI();///creamos nuevo objeto de servicios SRI
		$datosEmpresa = $servicio->consultar_ruc($ruc); ////accedemos a la funcion datosSRI
		$establecimientos = $servicio->establecimientoSRI($ruc);

		print_r(json_encode(['datosEmpresa'=>$datosEmpresa,'establecimientos'=>$establecimientos]));		
	}
	// fin

	// llenar datos empresa
	if (isset($_POST['consulta_empresa'])) {
		$resultado = $class->consulta("SELECT * FROM empresa WHERE estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array(  'id' => $row[0],
							'ruc' => $row[1],
							'razon_social' => $row[2],
							'nombre_comercial' => $row[3],
							'actividad_economica' => $row[4],
							'representante_legal' => $row[5],
							'identificacion_representante' => $row[6],
							'telefono1' => $row[7],
							'telefono2' => $row[8],
							'ciudad' => $row[9],
							'direccion_matriz' => $row[10],
							'direccion_establecimiento' => $row[11],
							'establecimiento' => $row[12],
							'punto_emision' => $row[13],
							'correo' => $row[14],
							'sitio_web' => $row[15],
							'slogan' => $row[16],
							'observaciones' => $row[18]);
		}
		print_r(json_encode($data));
	}
	//fin
?>