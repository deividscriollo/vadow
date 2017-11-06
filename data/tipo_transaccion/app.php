<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();

	// contador tipo_transaccion
	$id_formas_pago = 0;
	$resultado = $class->consulta("SELECT max(id) FROM tipo_transaccion");
	while ($row = $class->fetch_array($resultado)) {
		$id_formas_pago = $row[0];
	}
	$id_formas_pago++;
	// fin

	if ($_POST['oper'] == "add") {
		$resultado = $class->consulta("SELECT count(*) FROM tipo_transaccion WHERE nombre_transaccion = '$_POST[nombre_transaccion]'");
		while ($row=$class->fetch_array($resultado)) {
			$data = $row[0];
		}

		if ($data != 0) {
			$data = "3";
		} else {
			$resp = $class->consulta("INSERT INTO tipo_transaccion VALUES ('$id_formas_pago','$_POST[abreviatura]','$_POST[nombre_transaccion]','$_POST[principal]','$_POST[observaciones]','1','$fecha');");
			$data = "1";
		}
	} else {
	    if ($_POST['oper'] == "edit") {
	    	$resultado = $class->consulta("SELECT count(*) FROM tipo_transaccion WHERE nombre_transaccion = '$_POST[nombre_transaccion]' AND id NOT IN ('$_POST[id]')");
			while ($row = $class->fetch_array($resultado)) {
				$data = $row[0];
			}

			if ($data != 0) {
			 	$data = "3";
			} else {
				$resp = $class->consulta("UPDATE tipo_transaccion SET abreviatura = '$_POST[abreviatura]',nombre_transaccion = '$_POST[nombre_transaccion]',principal = '$_POST[principal]',observaciones = '$_POST[observaciones]',fecha_creacion = '$fecha' WHERE id = '$_POST[id]'");
	    		$data = "2";
			}
	    } else {
	    	if ($_POST['oper'] == "del") {
	    		$resp = $class->consulta("UPDATE tipo_transaccion SET estado = '2' WHERE id = '$_POST[id]'");
	    		$data = "4";	
	    	}
	    }
	}    
	echo $data;
?>