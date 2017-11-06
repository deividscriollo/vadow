<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();
	error_reporting(0);
	$fecha = $class->fecha_hora();

	// contador talonario
	$id_talonario = 0;
	$resultado = $class->consulta("SELECT max(id) FROM talonario_retencion");
	while ($row = $class->fetch_array($resultado)) {
		$id_talonario = $row[0];
	}
	$id_talonario++;
	// fin

	if ($_POST['oper'] == "add") {
		$resultado = $class->consulta("SELECT count(*) FROM talonario_retencion WHERE autorizacion = '$_POST[autorizacion]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = $row[0];
		}

		if ($data != 0) {
			$data = "3";
		} else {
			$resp = $class->consulta("INSERT INTO talonario_retencion VALUES ('$id_talonario','$_POST[fecha_inicio]','$_POST[fecha_caducidad]','$_POST[inicio_talonario]','$_POST[finaliza_talonario]','$_POST[autorizacion]','1','$fecha');");
			$data = "1";
		}
	} else {
	    if ($_POST['oper'] == "edit") {
	    	$resultado = $class->consulta("SELECT count(*) FROM talonario_retencion WHERE autorizacion = '$_POST[autorizacion]' AND id NOT IN ('$_POST[id]')");
			while ($row = $class->fetch_array($resultado)) {
				$data = $row[0];
			}

			if ($data != 0) {
			 	$data = "3";
			} else {
				$resp = $class->consulta("UPDATE talonario_retencion SET fecha_inicio = '$_POST[fecha_inicio]', fecha_caducidad = '$_POST[fecha_caducidad]', inicio_talonario = '$_POST[inicio_talonario]', finaliza_talonario = '$_POST[finaliza_talonario]', autorizacion = '$_POST[autorizacion]',fecha_creacion = '$fecha' WHERE id = '$_POST[id]'");
		    	$data = "2";
			}
	    } else {
	    	if ($_POST['oper'] == "del") {
	    		$resp = $class->consulta("UPDATE talonario_retencion SET estado = '2' WHERE id = '$_POST[id]'");
	    		$data = "4";	
	    	}
	    }
	}    
	echo $data;
?>