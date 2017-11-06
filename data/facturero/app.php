<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();
	error_reporting(0);
	$fecha = $class->fecha_hora();

	// contador facturero
	$id_facturero = 0;
	$resultado = $class->consulta("SELECT max(id) FROM facturero");
	while ($row = $class->fetch_array($resultado)) {
		$id_facturero = $row[0];
	}
	$id_facturero++;
	// fin

	if ($_POST['oper'] == "add") {
		$resultado = $class->consulta("SELECT count(*) FROM facturero WHERE autorizacion = '$_POST[autorizacion]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = $row[0];
		}

		if ($data != 0) {
			$data = "3";
		} else {
			$resp = $class->consulta("INSERT INTO facturero VALUES ('$id_facturero','$_POST[fecha_inicio]','$_POST[fecha_caducidad]','$_POST[inicio_facturero]','$_POST[finaliza_facturero]','$_POST[autorizacion]','$_POST[num_items]','1','$fecha');");
			$data = "1";
		}
	} else {
	    if ($_POST['oper'] == "edit") {
	    	$resultado = $class->consulta("SELECT count(*) FROM facturero WHERE autorizacion = '$_POST[autorizacion]' AND id NOT IN ('$_POST[id]')");
			while ($row = $class->fetch_array($resultado)) {
				$data = $row[0];
			}

			if ($data != 0) {
			 	$data = "3";
			} else {
				$resp = $class->consulta("UPDATE facturero SET fecha_inicio = '$_POST[fecha_inicio]', fecha_caducidad = '$_POST[fecha_caducidad]', inicio_facturero = '$_POST[inicio_facturero]', finaliza_facturero = '$_POST[finaliza_facturero]', autorizacion = '$_POST[autorizacion]', num_items = '$_POST[num_items]',fecha_creacion = '$fecha' WHERE id = '$_POST[id]'");
		    	$data = "2";
			}
	    } else {
	    	if ($_POST['oper'] == "del") {
	    		$resp = $class->consulta("UPDATE facturero SET estado = '2' WHERE id = '$_POST[id]'");
	    		$data = "4";	
	    	}
	    }
	}    
	echo $data;
?>