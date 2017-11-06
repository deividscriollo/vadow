<?php 
	if(!isset($_SESSION)) {
        session_start();        
    }

	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();
	$fecha_corta = $class->fecha();
	error_reporting(0);

	// guardar productos
	if (isset($_POST['btn_guardar']) == "btn_guardar") {
		// contador productos
		$id_producto = 0;
		$resultado = $class->consulta("SELECT max(id) FROM productos");
		while ($row = $class->fetch_array($resultado)) {
			$id_producto = $row[0];
		}
		$id_producto++;
		// fin

		$incluye_iva = "NO";
		$expiracion = "NO";
		$facturar_existencia = "NO";
		$series = "NO";
		$valor1 = number_format($_POST['precio_costo'], 3, '.', '');
	    $valor2 = number_format($_POST['utilidad_minorista'], 3, '.', '');
	    $valor3 = number_format($_POST['utilidad_mayorista'], 3, '.', '');
	    $valor4 = number_format($_POST['precio_minorista'], 3, '.', '');
	    $valor5 = number_format($_POST['precio_mayorista'], 3, '.', '');

		if(isset($_POST["incluye_iva"]))
			$incluye_iva = "SI";
		if(isset($_POST["expiracion"]))
			$expiracion = "SI";
		if(isset($_POST["facturar_existencia"]))
			$facturar_existencia = "SI";
		if(isset($_POST["series"]))
			$series = "SI";

		$resp = $class->consulta("INSERT INTO productos VALUES (			'$id_producto',
																			'$_POST[codigo_barras]',
																			'$_POST[codigo]',
																			'$_POST[descripcion]',
																			'$valor1',
																			'$valor2',
																			'$valor3',
																			'$valor4',
																			'$valor5',
																			'$_POST[select_tipo]',
																			'$_POST[select_categoria]',
																			'$_POST[select_marca]',
																			'$_POST[select_medida]',
																			'$_POST[select_bodega]',
																			'$_POST[select_iva]',
																			'$incluye_iva',
																			'$_POST[stock]',
																			'$_POST[stock_minimo]',
																			'$_POST[stock_maximo]',
																			'$_POST[descuento]',
																			'$expiracion',
																			'$facturar_existencia',
																			'$_POST[select_proveedor]',
																			'$_POST[ubicacion]',
																			'$series',
																			'articulo.jpg',
																			'$_POST[observaciones]',
																			'1', 
																			'$fecha');");

		// contador kardex
		$id_kardex = 0;
		$resultado = $class->consulta("SELECT max(id) FROM kardex");
		while ($row = $class->fetch_array($resultado)) {
			$id_kardex = $row[0];
		}
		$id_kardex++;
		// fin

		$total = number_format($valor1 * $_POST['stock'], 3, '.', '');

		$resp = $class->consulta("INSERT INTO kardex VALUES (				'$id_kardex',
																			'$id_producto',
																			'$fecha_corta',
																			'C.P',
																			'$_POST[stock]',
																			'$valor1',
																			'$total',
																			'$_POST[stock]',
																			'',
																			'',
																			'5', 
																			'$fecha');");

		// contador kardex_valorizado
		$id_kardex_valorizado = 0;
		$resultado = $class->consulta("SELECT max(id) FROM kardex_valorizado");
		while ($row = $class->fetch_array($resultado)) {
			$id_kardex_valorizado = $row[0];
		}
		$id_kardex_valorizado++;
		// fin

		$cantidad_total = $_POST['stock'];
	    $precio_unitario_total = number_format($_POST['precio_costo'], 4, '.', '');
	    $precio_total_total = number_format($cantidad_total * $precio_unitario_total , 2, '.', '');

		$resp = $class->consulta("INSERT INTO kardex_valorizado VALUES (	'$id_kardex_valorizado',
																			'$id_producto',
																			'$fecha_corta',
																			'SALDO INICIAL',
																			'',
																			'',
																			'',
																			'',
																			'',
																			'',
																			'$cantidad_total',
																			'$precio_unitario_total',
																			'$precio_total_total', 
																			'1',
																			'$fecha');");

		// contador movimientos
		$id_movimientos = 0;
		$resultado = $class->consulta("SELECT max(id) FROM movimientos");
		while ($row = $class->fetch_array($resultado)) {
			$id_movimientos = $row[0];
		}
		$id_movimientos++;
		// fin

		$resp = $class->consulta("INSERT INTO movimientos VALUES (	'$id_movimientos',
																	'$id_producto',
																	'$fecha_corta',
																	'$_POST[stock]',
																	'0',
																	'0',
																	'$_POST[stock]',
																	'1',
																	'$fecha');");																
		

		$data = 1;
		echo $data;
	}
	// fin

	// Modificar productos
	if (isset($_POST['btn_modificar']) == "btn_modificar") {
		$incluye_iva = "NO";
		$expiracion = "NO";
		$facturar_existencia = "NO";
		$series = "NO";
		$valor1 = number_format($_POST['precio_costo'], 3, '.', '');
	    $valor2 = number_format($_POST['utilidad_minorista'], 3, '.', '');
	    $valor3 = number_format($_POST['utilidad_mayorista'], 3, '.', '');
	    $valor4 = number_format($_POST['precio_minorista'], 3, '.', '');
	    $valor5 = number_format($_POST['precio_mayorista'], 3, '.', '');

		if(isset($_POST["incluye_iva"]))
			$incluye_iva = "SI";
		if(isset($_POST["expiracion"]))
			$expiracion = "SI";
		if(isset($_POST["facturar_existencia"]))
			$facturar_existencia = "SI";
		if(isset($_POST["series"]))
			$series = "SI";

		$resp = $class->consulta("UPDATE productos SET	codigo_barras = '$_POST[codigo_barras]',
														codigo = '$_POST[codigo]',
														descripcion = '$_POST[descripcion]',
														precio_costo = '$valor1',
														utlididad_minorista = '$valor2',
														utilidad_mayorista = '$valor3',
														precio_minorista = '$valor4',
														precio_mayorista = '$valor5',
														id_tipo_producto = '$_POST[select_tipo]',
														id_categoria = '$_POST[select_categoria]',
														id_marca = '$_POST[select_marca]',
														id_unidad_medida = '$_POST[select_medida]',
														id_bodega = '$_POST[select_bodega]',
														id_porcentaje = '$_POST[select_iva]',
														incluye_iva = '$incluye_iva',
														stock = '$_POST[stock]',
														stock_minimo = '$_POST[stock_minimo]',
														stock_maximo = '$_POST[stock_maximo]',
														descuento = '$_POST[descuento]',
														expiracion = '$expiracion',
														facturar_existencia = '$facturar_existencia',
														id_proveedor = '$_POST[select_proveedor]',
														ubicacion = '$_POST[ubicacion]',
														series = '$series',
														observaciones = '$_POST[observaciones]',
														fecha_creacion = '$fecha' WHERE id = '$_POST[id_producto]'");	

		$data = 2;
		echo $data;
	}
	// fin

	// Comparar codigo barras productos 
	if (isset($_POST['comparar_codigo_barras'])) {
		$cont = 0; 

		$resultado = $class->consulta("SELECT * FROM productos P WHERE P.codigo_barras = '$_POST[codigo_barras]' AND estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$cont++;
		}

		if ($cont == 0) {
		    $data = 0;
		} else {
		    $data = 1;
		}
		echo $data;
	}
	// fin

	// Comparar codigos productos
	if (isset($_POST['comparar_codigos'])) {
		$cont = 0; 

		$resultado = $class->consulta("SELECT * FROM productos P WHERE P.codigo = '$_POST[codigo]' AND estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$cont++;
		}

		if ($cont == 0) {
		    $data = 0;
		} else {
		    $data = 1;
		}
		echo $data;
	}
	// fin

	// LLenar tipo productos
	if (isset($_POST['llenar_tipo_producto'])) {
		$resultado = $class->consulta("SELECT id, nombre_tipo, principal FROM tipo_producto WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			if($row['principal'] == 'Si') {
				print '<option value="'.$row['id'].'" selected>'.$row['nombre_tipo'].'</option>';
			} else {
				print '<option value="'.$row['id'].'">'.$row['nombre_tipo'].'</option>';
			}
		}
	}
	// fin

	// LLenar categoria
	if (isset($_POST['llenar_categoria'])) {
		$resultado = $class->consulta("SELECT id, nombre_categoria, principal FROM categorias WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			if($row['principal'] == 'Si') {
				print '<option value="'.$row['id'].'" selected>'.$row['nombre_categoria'].'</option>';
			} else {
				print '<option value="'.$row['id'].'">'.$row['nombre_categoria'].'</option>';
			}
		}
	}
	// fin

	// LLenar marca
	if (isset($_POST['llenar_marca'])) {
		$resultado = $class->consulta("SELECT id, nombre_marca, principal FROM marcas WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			if($row['principal'] == 'Si') {
				print '<option value="'.$row['id'].'" selected>'.$row['nombre_marca'].'</option>';
			} else {
				print '<option value="'.$row['id'].'">'.$row['nombre_marca'].'</option>';
			}
		}
	}
	// fin

	// LLenar unidades medida
	if (isset($_POST['llenar_unidades_medida'])) {
		$resultado = $class->consulta("SELECT id, nombre_unidad, principal FROM unidades_medida WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			if($row['principal'] == 'Si') {
				print '<option value="'.$row['id'].'" selected>'.$row['nombre_unidad'].'</option>';
			} else {
				print '<option value="'.$row['id'].'">'.$row['nombre_unidad'].'</option>';
			}
		}
	}
	// fin

	// LLenar bodega
	if (isset($_POST['llenar_bodega'])) {
		$resultado = $class->consulta("SELECT id, nombre_bodega, principal FROM bodegas WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			if($row['principal'] == 'Si') {
				print '<option value="'.$row['id'].'" selected>'.$row['nombre_bodega'].'</option>';
			} else {
				print '<option value="'.$row['id'].'">'.$row['nombre_bodega'].'</option>';
			}
		}
	}
	// fin

	// LLenar porcentaje
	if (isset($_POST['llenar_porcentaje'])) {
		$resultado = $class->consulta("SELECT id, nombre_porcentaje, principal FROM porcentaje_iva WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			if($row['principal'] == 'Si') {
				print '<option value="'.$row['id'].'" selected>'.$row['nombre_porcentaje'].'</option>';	
			} else {
				print '<option value="'.$row['id'].'">'.$row['nombre_porcentaje'].'</option>';	
			}
		}
	}
	// fin

	// LLenar combo proveedores
	if (isset($_POST['llenar_proveedores'])) {
		$resultado = $class->consulta("SELECT id, nombres_completos FROM proveedores WHERE estado = '1' ORDER BY id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row['id'].'">'.$row['nombres_completos'].'</option>';
		}
	}
	// fin
?>