<?php 
	if(!isset($_SESSION)) {
        session_start();        
    }
    
	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();

	// contador unidades_medida
	$id_medida = 0;
	$resultado = $class->consulta("SELECT max(id) FROM unidades_medida");
	while ($row = $class->fetch_array($resultado)) {
		$id_medida = $row[0];
	}
	$id_medida++;
	// fin

	if ($_POST['oper'] == "add") {
		$resultado = $class->consulta("SELECT count(*) FROM unidades_medida WHERE nombre_unidad = '$_POST[nombre_unidad]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = $row[0];
		}

		if ($data != 0) {
			$data = "3";
		} else {
			$resp = $class->consulta("INSERT INTO unidades_medida VALUES ('$id_medida','$_POST[nombre_unidad]','$_POST[abreviatura]','$_POST[cantidad]','$_POST[principal]','$_POST[observaciones]','1','$fecha');");
			$data = "1";
		}
	} else {
	    if ($_POST['oper'] == "edit") {
	    	$resultado = $class->consulta("SELECT count(*) FROM unidades_medida WHERE nombre_unidad = '$_POST[nombre_unidad]' AND id NOT IN ('$_POST[id]')");
			while ($row = $class->fetch_array($resultado)) {
				$data = $row[0];
			}

			if ($data != 0) {
			 	$data = "3";
			} else {
				$resp = $class->consulta("UPDATE unidades_medida SET nombre_unidad = '$_POST[nombre_unidad]',abreviatura = '$_POST[abreviatura]',cantidad = '$_POST[cantidad]',principal = '$_POST[principal]',observaciones = '$_POST[observaciones]',fecha_creacion = '$fecha' WHERE id = '$_POST[id]'");
	    		$data = "2";
			}
	    } else {
	    	if ($_POST['oper'] == "del") {
	    		$resp = $class->consulta("UPDATE unidades_medida SET estado = '2' WHERE id = '$_POST[id]'");
	    		$data = "4";	
	    	}
	    }
	}
	    
	echo $data;
?>