<?php        
	include_once('../../admin/class.php');
	$class = new constante();
	session_start(); 
	error_reporting(0);

	// guardar facturas
	if ($_POST['btn_guardar'] == "btn_guardar") {
		$fecha = $class->fecha_hora();
		$fecha_corta = $class->fecha();

		// contador factura
		$id_factura = 0;
		$resultado = $class->consulta("SELECT max(id) FROM factura_compra");
		while ($row = $class->fetch_array($resultado)) {
			$id_factura = $row[0];
		}
		$id_factura++;
		// fin

		// guardar factura compra
		$resp = $class->consulta("INSERT INTO factura_compra VALUES  (	'$id_factura',
																		'".$_SESSION['empresa']['id']."',
																		'$_POST[id_proveedor]',
																		'".$_SESSION['user']['id']."',
																		'$id_factura',
																		'$_POST[fecha_actual]',
																		'$_POST[hora_actual]',
																		'$_POST[fecha_registro]',
																		'$_POST[fecha_emision]',
																		'$_POST[fecha_caducidad]',
																		'$_POST[select_tipo_comprobante]',
																		'$_POST[serie]',
																		'$_POST[autorizacion]',
																		'$_POST[fecha_cancelacion]',
																		'$_POST[select_forma_pago]',
																		'$_POST[subtotal]',
																		'$_POST[tarifa_0]',
																		'$_POST[tarifa]',
																		'$_POST[iva]',
																		'$_POST[otros]',
																		'$_POST[total_pagar]',
																		'$_POST[select_forma_pago]',
																		'',
																		'',
																		'$_POST[retencion_fuente]',
																		'$_POST[retencion_iva]',
																		'',
																		'1', 
																		'$fecha')");
		// fin

		// guardar retencion fuente compra
		if ($_POST['retencion_fuente'] == "SI") {
			// contador retencion fuente
			$id_retencion_fuente = 0;
			$resultado = $class->consulta("SELECT max(id) FROM retencion_fuente_compra");
			while ($row = $class->fetch_array($resultado)) {
				$id_retencion_fuente = $row[0];
			}
			$id_retencion_fuente++;
			// fin

			$resp = $class->consulta("INSERT INTO retencion_fuente_compra VALUES  (	'$id_retencion_fuente',
																					'$id_factura',
																					'$_POST[select_retencion_fuente]',
																					'$_POST[fecha_actual]',
																					'$_POST[hora_actual]',
																					'$_POST[total_pagar]',
																					'$_POST[iva]',
																					'$_POST[calculo_fuente]',
																					'$_POST[autorizacion_retencion]',
																					'$_POST[serie_retencion]',
																					'1', 
																					'$fecha')");
		}
		// fin

		// guardar retencion iva compra
		if ($_POST['retencion_iva'] == "SI") {
			// contador retencion iva
			$id_retencion_iva = 0;
			$resultado = $class->consulta("SELECT max(id) FROM retencion_iva_compra");
			while ($row = $class->fetch_array($resultado)) {
				$id_retencion_iva = $row[0];
			}
			$id_retencion_iva++;
			// fin

			$resp = $class->consulta("INSERT INTO retencion_iva_compra VALUES  (	'$id_retencion_iva',
																					'$id_factura',
																					'$_POST[select_retencion_iva]',
																					'$_POST[fecha_actual]',
																					'$_POST[hora_actual]',
																					'$_POST[total_pagar]',
																					'$_POST[iva]',
																					'$_POST[calculo_iva]',
																					'$_POST[autorizacion_retencion]',
																					'$_POST[serie_retencion]',
																					'1', 
																					'$fecha')");
		}
		// fin

		// datos detalle factura
		$campo1 = $_POST['campo1'];
	    $campo2 = $_POST['campo2'];
	    $campo3 = $_POST['campo3'];
	    $campo4 = $_POST['campo4'];
	    $campo5 = $_POST['campo5'];
	    // Fin

	    // descomponer detalle factura
		$arreglo1 = explode('|', $campo1);
	    $arreglo2 = explode('|', $campo2);
	    $arreglo3 = explode('|', $campo3);
	    $arreglo4 = explode('|', $campo4);
	    $arreglo5 = explode('|', $campo5);
	    $nelem = count($arreglo1);
	    // fin

	    for ($i = 1; $i < $nelem; $i++) {
	    	// contador detalle factura
			$id_detalle_factura = 0;
			$resultado = $class->consulta("SELECT max(id) FROM detalle_factura_compra");
			while ($row = $class->fetch_array($resultado)) {
				$id_detalle_factura = $row[0];
			}
			$id_detalle_factura++;
			// fin

			$resp = $class->consulta("INSERT INTO detalle_factura_compra VALUES(	'$id_detalle_factura',
																					'$id_factura',
																					'".$arreglo1[$i]."',
																					'".$arreglo2[$i]."',
																					'".$arreglo3[$i]."',
																					'".$arreglo4[$i]."',
																					'".$arreglo5[$i]."',
																					'1', 
																					'$fecha')");

			// consultar productos
           	$consulta = $class->consulta("SELECT * FROM productos WHERE id = '".$arreglo1[$i]."'");
           	while ($row = $class->fetch_array($consulta)) {
                $stock = $row[16];
            }

            $cal = $stock + $arreglo2[$i];
            $class->consulta("UPDATE productos SET stock = '$cal' WHERE id = '".$arreglo1[$i]."'");
            // fin

            // consultar movimientos
           	$consulta2 = $class->consulta("SELECT * FROM movimientos WHERE id_producto = '".$arreglo1[$i]."'");
           	while ($row = $class->fetch_array($consulta2)) {
                $entrada = $row[4];
            }

            $cal2 = $entrada + $arreglo2[$i]; 
            $class->consulta("UPDATE movimientos SET entradas = '$cal2', saldo = '$cal' WHERE id_producto = '".$arreglo1[$i]."'");
            // fin

            // contador kardex
			$id_kardex = 0;
			$resultado = $class->consulta("SELECT max(id) FROM kardex");
			while ($row = $class->fetch_array($resultado)) {
				$id_kardex = $row[0];
			}
			$id_kardex++;
			// fin

			// guardar kardex
			$resp = $class->consulta("INSERT INTO kardex VALUES (	'$id_kardex',
																	'".$arreglo1[$i]."',
																	'$fecha_corta',
																	'".'F.C:'.$_POST[serie]."',
																	'".$arreglo2[$i]."',
																	'".$arreglo3[$i]."',
																	'".$arreglo5[$i]."',
																	'$cal',
																	'',
																	'',
																	'1', 
																	'$fecha');");
			// fin
	    }

		echo $id_factura;
	}
	// fin

	// LLenar tipo comprobante
	if (isset($_POST['llenar_tipo_comprobante'])) {
		$resultado = $class->consulta("SELECT id, codigo ,nombre_tipo_comprobante, principal FROM tipo_comprobante WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			if($row['principal'] == 'Si') {
				print '<option value="'.$row['id'].'" selected>'.$row['codigo'].' - '.$row['nombre_tipo_comprobante'].'</option>';	
			} else {
				print '<option value="'.$row['id'].'">'.$row['codigo'].' - '.$row['nombre_tipo_comprobante'].'</option>';	
			}
		}
	}
	// fin

	// LLenar forma pago
	if (isset($_POST['llenar_forma_pago'])) {
		$resultado = $class->consulta("SELECT id, codigo ,nombre_forma, principal FROM formas_pago WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			if($row['principal'] == 'Si') {
				print '<option value="'.$row['id'].'" selected>'.$row['codigo'].' - '.$row['nombre_forma'].'</option>';	
			} else {
				print '<option value="'.$row['id'].'">'.$row['codigo'].' - '.$row['nombre_forma'].'</option>';	
			}
		}
	}
	// fin

	// LLenar retencion fuente
	if (isset($_POST['llenar_retencion_fuente'])) {
		$resultado = $class->consulta("SELECT id, valor ,nombre_fuente FROM retencion_fuente WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row['id'].'">'.$row['valor'].'% '.$row['nombre_fuente'].'</option>';	
		}
	}
	// fin

	// LLenar retencion iva
	if (isset($_POST['llenar_retencion_iva'])) {
		$resultado = $class->consulta("SELECT id, valor ,nombre_iva FROM retencion_iva WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row['id'].'">'.$row['valor'].'% '.$row['nombre_iva'].'</option>';	
		}
	}
	// fin

	// buscar valor fuente
	if (isset($_POST['llenar_valor_fuente'])) {
		$data = "";
		$resultado = $class->consulta("SELECT valor FROM retencion_fuente WHERE id = '$_POST[id]' AND estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
		    $valor = $row[0];
		}
		$data = $valor;

		echo $data;
	}
	// fin

	// buscar valor iva
	if (isset($_POST['llenar_valor_iva'])) {
		$data = "";

		$resultado = $class->consulta("SELECT valor FROM retencion_iva WHERE id = '$_POST[id]' AND estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
		    $valor = $row[0];
		}
		$data = $valor;

		echo $data;
	}
	// fin

	// llenar cabezera factura compra
	if (isset($_POST['llenar_cabezera_factura'])) {
		$resultado = $class->consulta("SELECT F.id, F.fecha_actual, F.hora_actual, F.serie, F.id_proveedor, P.identificacion, P.empresa, P.direccion, F.fecha_registro, F.fecha_emision, F.fecha_caducidad, F.autorizacion, F.fecha_cancelacion, F.forma_pago, F.tipo_comprobante, F.subtotal, F.tarifa0, F.tarifa, F.iva_compra, F.descuento_compra, F.total_compra, F.pago_ats, F.temporal, F.observaciones, F.retiene_fuente, F.retiene_iva FROM factura_compra F, proveedores P WHERE F.id_proveedor = P.id AND F.id = '$_POST[id]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array(  'id_factura' => $row[0],
							'fecha_actual' => $row[1],
							'hora_actual' => $row[2],
							'serie' => $row[3],
							'id_proveedor' => $row[4],
							'identificacion' => $row[5],
							'empresa' => $row[6],
							'direccion' => $row[7],
							'fecha_registro' => $row[8],
							'fecha_emision' => $row[9],
							'fecha_caducidad' => $row[10],
							'autorizacion' => $row[11],
							'fecha_cancelacion' => $row[12],
							'forma_pago' => $row[13],
							'tipo_comprobante' => $row[14],
							'subtotal' => $row[15],
							'tarifa0' => $row[16],
							'tarifa' => $row[17],
							'iva' => $row[18],
							'descuento' => $row[19],
							'total_pagar' => $row[20],
							'pago_ats' => $row[21],
							'temporal' => $row[22],
							'observaciones' => $row[23],
							'retiene_fuente' => $row[24],
							'retiene_iva' => $row[25]);
		}
		print_r(json_encode($data));
	}
	//fin

	// llenar detalle factura compra
	if (isset($_POST['llenar_detalle_factura'])) {
		$resultado = $class->consulta("SELECT D.id_producto, U.codigo, U.descripcion, D.cantidad, D.precio, D.descuento, D.total, P.porcentaje, U.incluye_iva FROM detalle_factura_compra D, factura_compra F, productos U, porcentaje_iva P  WHERE D.id_producto = U.id AND D.id_factura_compra = F.id AND U.id_porcentaje = P.id AND F.id = '".$_POST['id']."' ORDER BY D.id ASC");
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

	// buscar proveedores
	if (isset($_POST['buscador_proveedores'])) {
		$resultado = $class->consulta("SELECT * FROM proveedores WHERE estado =  '1'");
		while ($row = $class->fetch_array($resultado)) {
			if($_POST['tipo_busqueda'] == 'ruc') {
		        $data[] = array(
		        	'id' => $row[0],
		            'value' => $row[2],
		            'proveedor' => $row[3],
		            'direccion' => $row[9],
		            'telefono' => $row[7],
		            'correo' => $row[10]
		        );
		    } else {
		    	if($_POST['tipo_busqueda'] == 'proveedor') {
		    		$data[] = array(
			        	'id' => $row[0],
			            'value' => $row[3],
			            'ruc' => $row[2],
			            'direccion' => $row[9],
			            'telefono' => $row[7],
			            'correo' => $row[10]
			        );	
		    	}	
		    }
		}
		echo $data = json_encode($data);
	}
	// fin

	// busqueda productos
	if (isset($_POST['buscador_productos'])) {
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