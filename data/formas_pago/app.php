<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();

	// contador clientes
	$id_formas_pago = 0;
	$resultado = $class->consulta("SELECT max(id) FROM formas_pago");
	while ($row = $class->fetch_array($resultado)) {
		$id_formas_pago = $row[0];
	}
	$id_formas_pago++;
	// fin

	if ($_POST['oper'] == "add") {
		$resultado = $class->consulta("SELECT count(*) FROM formas_pago WHERE nombre_forma = '$_POST[nombre_forma]'");
		while ($row=$class->fetch_array($resultado)) {
			$data = $row[0];
		}

		if ($data != 0) {
			$data = "3";
		} else {
			$resp = $class->consulta("INSERT INTO formas_pago VALUES ('$id_formas_pago','$_POST[codigo]','$_POST[nombre_forma]','$_POST[principal]','$_POST[observaciones]','1','$fecha');");
			$data = "1";
		}
	} else {
	    if ($_POST['oper'] == "edit") {
	    	$resultado = $class->consulta("SELECT count(*) FROM formas_pago WHERE nombre_forma = '$_POST[nombre_forma]' AND id NOT IN ('$_POST[id]')");
			while ($row=$class->fetch_array($resultado)) {
				$data = $row[0];
			}

			if ($data != 0) {
			 	$data = "3";
			} else {
				$resp = $class->consulta("UPDATE formas_pago SET codigo = '$_POST[codigo]',nombre_forma = '$_POST[nombre_forma]',principal = '$_POST[principal]',observaciones = '$_POST[observaciones]',fecha_creacion = '$fecha' WHERE id = '$_POST[id]'");
	    		$data = "2";
			}
	    } else {
	    	if ($_POST['oper'] == "del") {
	    		$resp = $class->consulta("UPDATE formas_pago SET estado = '2' WHERE id = '$_POST[id]'");
	    		$data = "4";	
	    	}
	    }
	} 
	   
	echo $data;
?>