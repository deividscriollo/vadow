<?php 
	if(!isset($_SESSION)) {
        session_start();        
    }

	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();

	// contador porcentaje_iva
	$id_porcentaje = 0;
	$resultado = $class->consulta("SELECT max(id) FROM porcentaje_iva");
	while ($row = $class->fetch_array($resultado)) {
		$id_porcentaje = $row[0];
	}
	$id_porcentaje++;
	// fin

	if ($_POST['oper'] == "add") {
		$resultado = $class->consulta("SELECT count(*) FROM porcentaje_iva WHERE nombre_porcentaje = '$_POST[nombre_porcentaje]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = $row[0];
		}

		if ($data != 0) {
			$data = "3";
		} else {
			$resp = $class->consulta("INSERT INTO porcentaje_iva VALUES ('$id_porcentaje','$_POST[nombre_porcentaje]','$_POST[porcentaje]','$_POST[principal]','$_POST[observaciones]','1','$fecha');");
			$data = "1";
		}
	} else {
	    if ($_POST['oper'] == "edit") {
	    	$resultado = $class->consulta("SELECT count(*) FROM porcentaje_iva WHERE nombre_porcentaje = '$_POST[nombre_porcentaje]' AND id NOT IN ('$_POST[id]')");
			while ($row = $class->fetch_array($resultado)) {
				$data = $row[0];
			}

			if ($data != 0) {
			 	$data = "3";
			} else {
				$resp = $class->consulta("UPDATE porcentaje_iva SET nombre_porcentaje = '$_POST[nombre_porcentaje]',porcentaje = '$_POST[porcentaje]',principal = '$_POST[principal]',observaciones = '$_POST[observaciones]',fecha_creacion = '$fecha' WHERE id = '$_POST[id]'");
	    		$data = "2";
			}
	    } else {
	    	if ($_POST['oper'] == "del") {
	    		$resp = $class->consulta("UPDATE porcentaje_iva SET estado = '2' WHERE id = '$_POST[id]'");
	    		$data = "4";	
	    	}
	    }
	} 
	   
	echo $data;
?>