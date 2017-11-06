<?php 
	if(!isset($_SESSION)) {
        session_start();        
    }
	
    include_once('../../admin/datos_sri.php');
	include_once('../../admin/datos_cedula.php');
	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();

	// guardar proveedores
	if (isset($_POST['btn_guardar']) == "btn_guardar") {
		// contador proveedores
		$id_proveedor = 0;
		$resultado = $class->consulta("SELECT max(id) FROM proveedores");
		while ($row = $class->fetch_array($resultado)) {
			$id_proveedor = $row[0];
		}
		$id_proveedor++;
		// fin

		$resp = $class->consulta("INSERT INTO proveedores VALUES (	'$id_proveedor',
																	'$_POST[select_documento]',
																	'$_POST[identificacion]',
																	'$_POST[empresa]',
																	'$_POST[representante_legal]',
																	'$_POST[visitador]',
																	'$_POST[telefono1]',
																	'$_POST[telefono2]',
																	'$_POST[ciudad]',
																	'$_POST[direccion]',
																	'$_POST[correo]',
																	'$_POST[sitio_web]',
																	'$_POST[cupo_credito]',
																	'$_POST[select_formas]',
																	'$_POST[select_proveedor]',
																	'$_POST[observaciones]',
																	'1', 
																	'$fecha');");	
		
		$data = 1;
		echo $data;
	}
	// fin

	// modificar proveedores
	if (isset($_POST['btn_modificar']) == "btn_modificar") {

		$resp = $class->consulta("UPDATE proveedores SET			        tipo_documento = '$_POST[select_documento]',
																			identificacion = '$_POST[identificacion]',
																			empresa = '$_POST[empresa]',
																			representante_legal = '$_POST[representante_legal]',
																			visitador = '$_POST[visitador]',
																			telefono1 = '$_POST[telefono1]',
																			telefono2 = '$_POST[telefono2]',
																			ciudad = '$_POST[ciudad]',
																			direccion = '$_POST[direccion]',
																			correo = '$_POST[correo]',
																			sitio_web = '$_POST[sitio_web]',
																			cupo_credito = '$_POST[cupo_credito]',
																			formas_pago = '$_POST[select_formas]',
																			proveedor_principal = '$_POST[select_proveedor]',
																			observaciones = '$_POST[observaciones]',
																			fecha_creacion = '$fecha' WHERE id = '$_POST[id_proveedor]'");	

		$data = 2;
		echo $data;
	}
	// fin

	//comprarar identificaciones proveedores
	if (isset($_POST['comparar_identificacion'])) {
		$cont = 0;

		$resultado = $class->consulta("SELECT * FROM proveedores P WHERE P.tipo_documento = '$_POST[tipo_documento]' AND P.identificacion = '$_POST[identificacion]' AND estado = '1'");
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

	// consultar cedula
	if (isset($_POST['consulta_cedula'])) {
		$ruc = $_POST['txt_ruc'];
		$servicio = new DatosCedula();///creamos nuevo objeto de antecedentes
		$datosCedula = $servicio->consultar_cedula($ruc); ////accedemos a la funcion datosSRI

		print_r(json_encode(['datosPersona'=>$datosCedula]));		
	}
	// fin
?>