<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();
	
	// contador tipo_producto
	$id_tipo_producto = 0;
	$resultado = $class->consulta("SELECT max(id) FROM tipo_producto");
	while ($row = $class->fetch_array($resultado)) {
		$id_tipo_producto = $row[0];
	}
	$id_tipo_producto++;
	// fin

	if ($_POST['oper'] == "add") {
		$resultado = $class->consulta("SELECT count(*) FROM tipo_producto WHERE nombre_tipo = '$_POST[nombre_tipo]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = $row[0];
		}

		if ($data != 0) {
			$data = "3";
		} else {
			$resp = $class->consulta("INSERT INTO tipo_producto VALUES ('$id_tipo_producto','$_POST[nombre_tipo]','$_POST[principal]','$_POST[observaciones]','1','$fecha');");
			$data = "1";
		}
	} else {
	    if ($_POST['oper'] == "edit") {
	    	$resultado = $class->consulta("SELECT count(*) FROM tipo_producto WHERE nombre_tipo = '$_POST[nombre_tipo]' AND id NOT IN ('$_POST[id]')");
			while ($row = $class->fetch_array($resultado)) {
				$data = $row[0];
			}

			if ($data != 0) {
			 	$data = "3";
			} else {
				$resp = $class->consulta("UPDATE tipo_producto SET nombre_tipo = '$_POST[nombre_tipo]',principal = '$_POST[principal]',observaciones = '$_POST[observaciones]',fecha_creacion = '$fecha' WHERE id = '$_POST[id]'");
	    		$data = "2";
			}
	    } else {
	    	if ($_POST['oper'] == "del") {
	    		$resp = $class->consulta("UPDATE tipo_producto SET estado = '2' WHERE id = '$_POST[id]'");
	    		$data = "4";	
	    	}
	    }
	} 
	   
	echo $data;
?>