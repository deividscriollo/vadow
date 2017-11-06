<?php        
	include_once('../../admin/class.php');
	$class = new constante();
	session_start(); 
	error_reporting(0);

	// guardar proformas
	if ($_POST['btn_guardar'] == "btn_guardar") {
		$fecha = $class->fecha_hora();

		// contador proforma
		$id_proforma = 0;
		$resultado = $class->consulta("SELECT max(id) FROM proforma");
		while ($row = $class->fetch_array($resultado)) {
			$id_proforma = $row[0];
		}
		$id_proforma++;
		// fin

		$resp = $class->consulta("INSERT INTO proforma VALUES  (	'$id_proforma',
																	'".$_SESSION['empresa']['id']."',
																	'$_POST[id_cliente]',
																	'".$_SESSION['user']['id']."',
																	'$_POST[fecha_actual]',
																	'$_POST[hora_actual]',
																	'$_POST[select_tipo_precio]',
																	'$_POST[subtotal]',
																	'$_POST[tarifa_0]',
																	'$_POST[tarifa]',
																	'$_POST[iva]',
																	'$_POST[otros]',
																	'$_POST[total_pagar]',
																	'',
																	'1', 
																	'$fecha')");

		// datos detalle proforma
		$campo1 = $_POST['campo1'];
	    $campo2 = $_POST['campo2'];
	    $campo3 = $_POST['campo3'];
	    $campo4 = $_POST['campo4'];
	    $campo5 = $_POST['campo5'];
	    // Fin

	    // descomponer detalle proforma
		$arreglo1 = explode('|', $campo1);
	    $arreglo2 = explode('|', $campo2);
	    $arreglo3 = explode('|', $campo3);
	    $arreglo4 = explode('|', $campo4);
	    $arreglo5 = explode('|', $campo5);
	    $nelem = count($arreglo1);
	    // fin

	    for ($i = 1; $i < $nelem; $i++) {
	    	// contador detalle proforma
			$id_detalle_proforma = 0;
			$resultado = $class->consulta("SELECT max(id) FROM detalle_proforma");
			while ($row = $class->fetch_array($resultado)) {
				$id_detalle_proforma = $row[0];
			}
			$id_detalle_proforma++;
			// fin

			$resp = $class->consulta("INSERT INTO detalle_proforma VALUES 	(	'$id_detalle_proforma',
																				'$id_proforma',
																				'".$arreglo1[$i]."',
																				'".$arreglo2[$i]."',
																				'".$arreglo3[$i]."',
																				'".$arreglo4[$i]."',
																				'".$arreglo5[$i]."',
																				'1', 
																				'$fecha')");
	    }
		echo $id_proforma;
	}
	// fin

	// anular proforma
	if (isset($_POST['btn_anular']) == "btn_anular") {
		$class->consulta("UPDATE proforma SET estado = '2'  WHERE id = '$_POST[id_proforma]'");

		$data = 1;
		echo $data;
	}
	// fin

	//llenar cabezera proforma
	if (isset($_POST['llenar_cabezera_proforma'])) {
		$resultado = $class->consulta("SELECT P.id, P.fecha_actual, P.hora_actual, P.id_cliente, C.identificacion, C.nombres_completos, C.direccion, C.telefono2, C.correo, P.tipo_precio, P.subtotal, P.tarifa0, P.tarifa, P.iva_proforma, P.descuento_proforma, P.total_proforma, P.estado FROM proforma P, clientes C WHERE P.id_cliente = C.id AND P.id = '$_POST[id]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array(  'id_proforma' => $row[0],
							'fecha_actual' => $row[1],
							'hora_actual' => $row[2],
							'id_cliente' => $row[3],
							'identificacion' => $row[4],
							'nombres_completos' => $row[5],
							'direccion' => $row[6],
							'telefono2' => $row[7],
							'correo' => $row[8],
							'tipo_precio' => $row[9],
							'subtotal' => $row[10],
							'tarifa0' => $row[11],
							'tarifa' => $row[12],
							'iva' => $row[13],
							'descuento' => $row[14],
							'total_pagar' => $row[15],
							'estado' => $row[16]);
		}
		print_r(json_encode($data));
	}
	//fin

	//llenar detalle proforma
	if (isset($_POST['llenar_detalle_proforma'])) {
		$resultado = $class->consulta("SELECT D.id_producto, U.codigo, U.descripcion, D.cantidad, D.precio, D.descuento, D.total, P.porcentaje, U.incluye_iva FROM detalle_proforma D, proforma N, productos U, porcentaje_iva P  WHERE D.id_producto = U.id AND D.id_proforma = N.id AND U.id_porcentaje = P.id AND N.id = '".$_POST['id']."' ORDER BY D.id ASC");
		while ($row = $class->fetch_array($resultado)) {
			$arr_data[] = $row['0'];
		    $arr_data[] = $row['1'];
		    $arr_data[] = $row['2'];
		    $arr_data[] = $row['3'];
		    $arr_data[] = $row['4'];
		    $arr_data[] = $row['5'];
		    $arr_data[] = $row['6'];
		    $arr_data[] = $row['7'];
		    $arr_data[] = $row['8'];
		}
		echo json_encode($arr_data);
	}
	//fin

	// buscar clientes
	if (isset($_POST['buscador_clientes'])) {
		$resultado = $class->consulta("SELECT * FROM clientes WHERE estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			if($_POST['tipo_busqueda'] == 'ruc') {
				$data[] = array(
		            'id' => $row[0],
		            'value' => $row[2],
		            'cliente' => $row[3],
		            'direccion' => $row[7],
		            'telefono' => $row[4],
		            'correo' => $row[8]
		        );			
			} else {
				if($_POST['tipo_busqueda'] == 'cliente') {
					$data[] = array(
			            'id' => $row[0],
			            'value' => $row[3],
			            'ruc' => $row[2],
			            'direccion' => $row[7],
			            'telefono' => $row[4],
			            'correo' => $row[8]
			        );	
				}
			}
		}
		echo $data = json_encode($data);	
	}
	// fin

	// buscar productos
	if (isset($_POST['buscador_productos'])) {
		$resultado = $class->consulta("SELECT * FROM productos  P, porcentaje_iva V WHERE P.id_porcentaje = V.id AND P.estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			if($_POST['tipo_busqueda'] == 'codigo') {
				if ($_POST['tipo_precio'] == "MINORISTA") {
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
			        if ($_POST['tipo_precio'] == "MAYORISTA") {
			            $data[] = array(
			            	'id' => $row[0],
			                'value' => $row[2],
			                'codigo_barras' => $row[1],
			                'producto' => $row[3],
			                'precio_costo' => $row[4],
			                'precio_venta' => $row[8],
			                'descuento' => $row[19],
			                'stock' => $row[16],
			                'iva_producto' => $row[31],
			                'incluye' => $row[15]
			            );
			        }
		    	}	
			} else {
				if($_POST['tipo_busqueda'] == 'producto') {
					if ($_POST['tipo_precio'] == "MINORISTA") {
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
				    } else {
				        if ($_POST['tipo_precio'] == "MAYORISTA") {
				            $data[] = array(
				            	'id' => $row[0],
				                'value' => $row[3],
				                'codigo_barras' => $row[1],
				                'codigo' => $row[2],
				                'precio_costo' => $row[4],
				                'precio_venta' => $row[8],
				                'descuento' => $row[19],
				                'stock' => $row[16],
				                'iva_producto' => $row[31],
				                'incluye' => $row[15]
				            );
				        }
				    }
				}
			}
		}
		echo $data = json_encode($data);	
	}
	// fin
?>