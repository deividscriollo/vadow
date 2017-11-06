<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();

	// contador tipo comprobante
	$id_tipo_comprobante = 0;
	$resultado = $class->consulta("SELECT max(id) FROM tipo_comprobante");
	while ($row = $class->fetch_array($resultado)) {
		$id_tipo_comprobante = $row[0];
	}
	$id_tipo_comprobante++;
	// fin

	if ($_POST['oper'] == "add") {
		$resultado = $class->consulta("SELECT count(*) FROM tipo_comprobante WHERE nombre_tipo_comprobante = '$_POST[nombre_tipo_comprobante]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = $row[0];
		}

		if ($data != 0) {
			$data = "3";
		} else {
			$resp = $class->consulta("INSERT INTO tipo_comprobante VALUES ('$id_tipo_comprobante','$_POST[codigo]','$_POST[nombre_tipo_comprobante]','$_POST[principal]','$_POST[observaciones]','1','$fecha');");
			$data = "1";
		}
	} else {
	    if ($_POST['oper'] == "edit") {
	    	$resultado = $class->consulta("SELECT count(*) FROM tipo_comprobante WHERE nombre_tipo_comprobante = '$_POST[nombre_tipo_comprobante]' AND id NOT IN ('$_POST[id]')");
			while ($row = $class->fetch_array($resultado)) {
				$data = $row[0];
			}

			if ($data != 0) {
			 	$data = "3";
			} else {
				$resp = $class->consulta("UPDATE tipo_comprobante SET codigo = '$_POST[codigo]',nombre_tipo_comprobante = '$_POST[nombre_tipo_comprobante]',principal = '$_POST[principal]',observaciones = '$_POST[observaciones]',fecha_creacion = '$fecha' WHERE id = '$_POST[id]'");
	    		$data = "2";
			}
	    } else {
	    	if ($_POST['oper'] == "del") {
	    		$resp = $class->consulta("UPDATE tipo_comprobante SET estado = '2' WHERE id = '$_POST[id]'");
	    		$data = "4";	
	    	}
	    }
	}   
	echo $data;
?>