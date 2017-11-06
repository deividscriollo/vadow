<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();
	error_reporting(0);
	$fecha = $class->fecha_hora();

	// contador retencion
	$id_retencion = 0;
	$resultado = $class->consulta("SELECT max(id) FROM retencion_iva");
	while ($row = $class->fetch_array($resultado)) {
		$id_retencion = $row[0];
	}
	$id_retencion++;
	// fin

	if ($_POST['oper'] == "add") {
		$resultado = $class->consulta("SELECT count(*) FROM retencion_iva WHERE nombre_iva = '$_POST[nombre_iva]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = $row[0];
		}

		if ($data != 0) {
			$data = "3";
		} else {
			$resp = $class->consulta("INSERT INTO retencion_iva VALUES ('$id_retencion','$_POST[nombre_iva]','$_POST[valor]','$_POST[codigo_formulario]','$_POST[select_cuenta_debito]','$_POST[select_cuenta_credito]','1','$fecha');");
			$data = "1";
		}
	} else {
	    if ($_POST['oper'] == "edit") {
	    	$resultado = $class->consulta("SELECT count(*) FROM retencion_iva WHERE nombre_iva = '$_POST[nombre_iva]' AND id NOT IN ('$_POST[id]')");
			while ($row = $class->fetch_array($resultado)) {
				$data = $row[0];
			}

			if ($data != 0) {
			 	$data = "3";
			} else {
				$resp = $class->consulta("UPDATE retencion_iva SET nombre_iva = '$_POST[nombre_iva]',valor = '$_POST[valor]',codigo_formulario = '$_POST[codigo_formulario]',cuenta_debito = '$_POST[select_cuenta_debito]',cuenta_credito = '$_POST[select_cuenta_credito]',fecha_creacion = '$fecha' WHERE id = '$_POST[id]'");
	    		$data = "2";
			}
	    } else {
	    	if ($_POST['oper'] == "del") {
	    		$resp = $class->consulta("UPDATE retencion_iva SET estado = '2' WHERE id = '$_POST[id]'");
	    		$data = "4";	
	    	}
	    }
	}    
	echo $data;

	// LLenar combo cuentas
	if (isset($_POST['llenar_cuenta'])) {
		$resultado = $class->consulta("SELECT id, codigo, nombre_plan FROM plan_cuentas WHERE cuenta='M' AND nombre_plan LIKE '%uente%' AND nombre_plan LIKE '%Reten%' ORDER BY id");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row['id'].'">'.$row['codigo'].' - '.$row['nombre_plan'].'</option>';
		}
	}
	// fin
?>