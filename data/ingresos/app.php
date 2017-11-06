<?php        
	include_once('../../admin/class.php');
	$class = new constante();
	session_start(); 
	error_reporting(0);

	// guardar ingresos
	if ($_POST['btn_guardar'] == "btn_guardar") {
		$fecha = $class->fecha_hora();
		$fecha_corta = $class->fecha();

		// contador ingreso
		$id_ingreso = 0;
		$resultado = $class->consulta("SELECT max(id) FROM ingreso");
		while ($row = $class->fetch_array($resultado)) {
			$id_ingreso = $row[0];
		}
		$id_ingreso++;
		// fin

		$resp = $class->consulta("INSERT INTO ingreso VALUES  	(	'$id_ingreso',
																	'".$_SESSION['empresa']['id']."',
																	'".$_SESSION['user']['id']."',
																	'$_POST[fecha_actual]',
																	'$_POST[hora_actual]',
																	'$_POST[origen]',
																	'$_POST[destino]',
																	'$_POST[subtotal]',
																	'$_POST[tarifa_0]',
																	'$_POST[tarifa]',
																	'$_POST[iva]',
																	'$_POST[otros]',
																	'$_POST[total_pagar]',
																	'$_POST[observaciones]',
																	'1', 
																	'$fecha')");

		// datos detalle ingreso
		$campo1 = $_POST['campo1'];
	    $campo2 = $_POST['campo2'];
	    $campo3 = $_POST['campo3'];
	    $campo4 = $_POST['campo4'];
	    $campo5 = $_POST['campo5'];
	    // Fin

	    // descomponer detalle ingreso
		$arreglo1 = explode('|', $campo1);
	    $arreglo2 = explode('|', $campo2);
	    $arreglo3 = explode('|', $campo3);
	    $arreglo4 = explode('|', $campo4);
	    $arreglo5 = explode('|', $campo5);
	    $nelem = count($arreglo1);
	    // fin

	    for ($i = 1; $i < $nelem; $i++) {
	    	// contador detalle ingreso
			$id_detalle_ingreso = 0;
			$resultado = $class->consulta("SELECT max(id) FROM detalle_ingreso");
			while ($row = $class->fetch_array($resultado)) {
				$id_detalle_ingreso = $row[0];
			}
			$id_detalle_ingreso++;
			// fin

			$resp = $class->consulta("INSERT INTO detalle_ingreso VALUES   (	'$id_detalle_ingreso',
																				'$id_ingreso',
																				'".$arreglo1[$i]."',
																				'".$arreglo2[$i]."',
																				'".$arreglo3[$i]."',
																				'".$arreglo4[$i]."',
																				'".$arreglo5[$i]."',
																				'1', 
																				'$fecha')");

			// modificar productos
           	$consulta2 = $class->consulta("SELECT * FROM productos WHERE id = '".$arreglo1[$i]."'");
           	while ($row = $class->fetch_array($consulta2)) {
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
																	'INGRESOS',
																	'".$arreglo2[$i]."',
																	'".$arreglo3[$i]."',
																	'".$arreglo5[$i]."',
																	'$cal',
																	'$_POST[origen]',
																	'$_POST[destino]',
																	'3', 
																	'$fecha')");
			// fin
	    }
		echo $id_ingreso;
	}
	// fin

	//llenar cabezera ingreso
	if (isset($_POST['llenar_cabezera_ingreso'])) {
		$resultado = $class->consulta("SELECT I.id, I.fecha_actual, I.hora_actual, I.origen, I.destino, I.subtotal, I.tarifa0, I.tarifa, I.iva_ingreso, I.descuento_ingreso, I.total_ingreso, I.observaciones FROM ingreso I WHERE I.id = '$_POST[id]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array(  'id_ingreso' => $row[0],
							'fecha_actual' => $row[1],
							'hora_actual' => $row[2],
							'origen' => $row[3],
							'destino' => $row[4],
							'subtotal' => $row[5],
							'tarifa0' => $row[6],
							'tarifa' => $row[7],
							'iva' => $row[8],
							'descuento' => $row[9],
							'total_pagar' => $row[10],
							'observaciones' => $row[11]);
		}
		print_r(json_encode($data));
	}
	//fin

	//llenar detalle proforma
	if (isset($_POST['llenar_detalle_ingreso'])) {
		$resultado = $class->consulta("SELECT D.id_producto, U.codigo, U.descripcion, D.cantidad, D.precio, D.descuento, D.total, P.porcentaje, U.incluye_iva FROM detalle_ingreso D, ingreso I, productos U, porcentaje_iva P WHERE D.id_producto = U.id AND D.id_ingreso = I.id AND U.id_porcentaje = P.id AND I.id = '".$_POST['id']."' ORDER BY D.id asc");
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

	// busqueda productos
	if (isset($_POST['buscador_productos'])) {
		$resultado = $class->consulta("SELECT * FROM productos P, porcentaje_iva V WHERE P.id_porcentaje = V.id AND P.estado = '1'");
		while ($row=$class->fetch_array($resultado)) {
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