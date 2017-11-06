<?php        
	include_once('../../admin/class.php');
	$class = new constante();
	session_start(); 
	error_reporting(0);

	// consultar movimientos
	if(isset($_POST['cargar_tabla'])) {
		if($_POST['id_producto'] == "") {
			$resultado = $class->consulta("SELECT P.descripcion, K.fecha_kardex, K.detalle, K.cantidad, K.valor_unitario, K.total, K.saldo, K.estado FROM kardex K, productos P WHERE K.id_producto = P.id AND K.fecha_kardex BETWEEN '$_POST[fecha_inicio]' AND '$_POST[fecha_fin]' ORDER BY K.id ASC");
			while ($row = $class->fetch_array($resultado)) {
				if($row[7] == '2' || $row[7] == '4') {
					$lista[] = array(	'descripcion' => $row[0],
										'fecha_kardex' => $row[1],
										'detalle' => $row[2],
										'cantidad' => '-'. $row[3],
										'valor_unitario' => $row[4],
										'total' => $row[5],
										'saldo' => $row[6]
									);
				} else {
					$lista[] = array(	'descripcion' => $row[0],
										'fecha_kardex' => $row[1],
										'detalle' => $row[2],
										'cantidad' => $row[3],
										'valor_unitario' => $row[4],
										'total' => $row[5],
										'saldo' => $row[6]
									);	
				} 
			}
		} else {
			$resultado = $class->consulta("SELECT P.descripcion, K.fecha_kardex, K.detalle, K.cantidad, K.valor_unitario, K.total, K.saldo, K.estado FROM kardex K, productos P WHERE K.id_producto = P.id AND P.id ='$_POST[id_producto]' AND K.fecha_kardex BETWEEN '$_POST[fecha_inicio]' AND '$_POST[fecha_fin]' ORDER BY K.id ASC");
			while ($row = $class->fetch_array($resultado)) {
				if($row[7] == '2' || $row[7] == '4') {
					$lista[] = array(	'descripcion' => $row[0],
										'fecha_kardex' => $row[1],
										'detalle' => $row[2],
										'cantidad' => '-'. $row[3],
										'valor_unitario' => $row[4],
										'total' => $row[5],
										'saldo' => $row[6]
									);
				} else {
					$lista[] = array(	'descripcion' => $row[0],
										'fecha_kardex' => $row[1],
										'detalle' => $row[2],
										'cantidad' => $row[3],
										'valor_unitario' => $row[4],
										'total' => $row[5],
										'saldo' => $row[6]
									);	
				} 
			}	
		}
		echo $lista = json_encode($lista);
	}
	// fin

	// busqueda productos
	if (isset($_POST['buscadores'])) {
		$resultado = $class->consulta("SELECT * FROM productos P, porcentaje_iva V WHERE P.id_porcentaje = V.id AND P.estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			if($_POST['tipo_busqueda'] == 'codigo') {
		        $data[] = array(
		        	'id' => $row[0],
		            'value' => $row[2],
		            'codigo_barras' => $row[1],
		            'producto' => $row[3],
		            'precio_costo' => $row[4],
		            'precio_venta' => $row[7],
		            'descuento' => $row[19],
		            'stock' => $row[16],
		            'iva_producto' => $row[31],
		            'incluye' => $row[15]
		        );
		    } else {
		    	if($_POST['tipo_busqueda'] == 'producto') {
		    		$data[] = array(
			        	'id' => $row[0],
			            'value' => $row[3],
			            'codigo_barras' => $row[1],
			            'codigo' => $row[2],
			            'precio_costo' => $row[4],
			            'precio_venta' => $row[7],
			            'descuento' => $row[19],
			            'stock' => $row[16],
			            'iva_producto' => $row[31],
			            'incluye' => $row[15]
			        );	
		    	}	
		    }
		}
		echo $data = json_encode($data);
	}
	// fin
?>