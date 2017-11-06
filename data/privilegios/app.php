<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();
	error_reporting(0);
	$fecha = $class->fecha_hora();

	// modificar privilegios
	if (isset($_POST['updateprivilegios'])) {
		$vector = json_encode($_POST['data']);
		$data = 0;

		$resp = $class->consulta("UPDATE privilegios SET data = '$vector' WHERE id_usuario = '$_POST[user]'");
		if ($resp) {
			$data = 1;
		} 

		echo $data;
	}
	// fin

	//LLena combo usuarios
	if (isset($_POST['llenar_usuarios'])) {
		$id = $class->idz();
		$resultado = $class->consulta("SELECT * FROM usuarios WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row['id'].'">'.$row['nombres_completos'].'</option>';
		}
	}
	// fin

	// estado privilegios
	function buscarstatus($array, $valor){
		$retorno = array_search($valor, $array);
		if ($retorno) {
			return true;
		} else {
			return false;
		}	
	}
	// fin

	// Inicios methodo recursos data
	if (isset($_POST['retornar'])) {
		$sum;
		$result = $class->consulta("SELECT * FROM privilegios WHERE id_usuario='".$_POST['id']."'");
		while ($row = $class->fetch_array($result)) {
			$sum = json_decode($row['data']);
		}

		$acumulador = 
		array(
			'Usuarios' => 
			array(
				'text' => 'Usuarios',
				'type' => 'folder',
				'additionalParameters' => 
					array(
						'id' => 1,
						'children' => 
						array(
							'NuevoUsuario'=> 
							array(
								'text' => 'Nuevo Usuario', 
								'type' => 'item',
								'id' => 'usuarios',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'usuarios')
								)
							),
							'CargarImagen' => 
							array(
								'text' => 'Cargar Imagen',
								'id' => 'fotos_usuario',
								'type' => 'item',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'fotos_usuario')
								)
							),
							'Perfiles'=> 
							array(
								'text' => 'Perfiles', 
								'type' => 'item',
								'id' => 'cargos',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'cargos')
								)
							),
							'Privilegios'=> 
							array(
								'text' => 'Privilegios', 
								'type' => 'item',
								'id' => 'privilegios',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'privilegios')
								)
							)							
						)
					)
				),
			'Empresa' => 
				array(
				'text' => 'Empresa',
				'type' => 'folder',
				'additionalParameters' => 
					array(
						'id' => 1,
						'children' => 
						array(
							'NuevaEmpresa'=> 
							array(
								'text' => 'Nueva Empresa', 
								'type' => 'item',
								'id' => 'empresa',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'empresa')
								)
							),
							'CargarImagen'=> 
							array(
								'text' => 'Cargar Imagen', 
								'type' => 'item',
								'id' => 'logo_empresa',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'logo_empresa')
								)
							)									
						)
					)
				),
			'Generales' => 
				array(
				'text' => 'Generales',
				'type' => 'folder',
				'additionalParameters' => 
					array(
						'id' => 1,
						'children' => 
						array(
							'PorcentajeIVA'=> 
							array(
								'text' => 'Porcentaje IVA', 
								'type' => 'item',
								'id' => 'porcentaje',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'porcentaje')
								)
							),
							'TipoProductos'=> 
							array(
								'text' => 'Tipo Productos', 
								'type' => 'item',
								'id' => 'tipo_productos',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'tipo_productos')
								)
							),
							'Categorias'=> 
							array(
								'text' => 'Categorias', 
								'type' => 'item',
								'id' => 'categorias',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'categorias')
								)
							),
							'Marcas'=> 
							array(
								'text' => 'Marcas', 
								'type' => 'item',
								'id' => 'marcas',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'marcas')
								)
							),
							'Presentacion'=> 
							array(
								'text' => 'Presentación', 
								'type' => 'item',
								'id' => 'medida',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'medida')
								)
							),
							'Almacenes'=> 
							array(
								'text' => 'Almacenes', 
								'type' => 'item',
								'id' => 'bodegas',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'bodegas')
								)
							)
						)
					)
				),
			'Ingresos' => 
				array(
				'text' => 'Ingresos',
				'type' => 'folder',
				'additionalParameters' => 
					array(
					'id' => 1,
					'children' => 
						array(
						'NuevoCliente'=> 
							array(
								'text' => 'Nuevo Cliente', 
								'type' => 'item',
								'id' => 'clientes',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'clientes')
								)
							),
							'NuevoProveedor'=> 
							array(
								'text' => 'Nuevo Proveedor', 
								'type' => 'item',
								'id' => 'proveedores',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'proveedores')
								)
							)
						)
					)
				),
			'Articulos' => 
				array(
				'text' => 'Articulos',
				'type' => 'folder',
				'additionalParameters' => 
					array(
					'id' => 1,
					'children' => 
						array(
						'NuevoArticulo'=> 
							array(
								'text' => 'Nuevo Articulo', 
								'type' => 'item',
								'id' => 'productos',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'productos')
								)
							),
							'CargarImagen'=> 
							array(
								'text' => 'Cargar Imagen', 
								'type' => 'item',
								'id' => 'fotos_articulo',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'fotos_articulo')
								)
							),
							'ImportarCSV'=> 
							array(
								'text' => 'Importar CSV', 
								'type' => 'item',
								'id' => 'importar',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'importar')
								)
							)
						)
					)
				),
			'Inventario' => 
				array(
				'text' => 'Inventario',
				'type' => 'folder',
				'additionalParameters' => 
					array(
					'id' => 1,
					'children' => 
						array(
						'NuevoInventario'=> 
							array(
								'text' => 'Nuevo Inventario', 
								'type' => 'item',
								'id' => 'inventario',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'inventario')
								)
							),
							'Movimientos'=> 
							array(
								'text' => 'Movimientos', 
								'type' => 'item',
								'id' => 'movimientos',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'movimientos')
								)
							)
						)
					)
				),
			'Proformas' => 
				array(
				'text' => 'Proformas',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
					array(
						'NuevaProfroma'=> 
							array(
								'text' => 'Nueva Profroma', 
								'type' => 'item',
								'id' => 'proformas',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'proformas')
								)
							),
						)
					)
				),
			'FacturaCompra' => 
				array(
				'text' => 'Factura Compra',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'NuevaFactura'=> 
							array(
								'text' => 'Nueva Factura', 
								'type' => 'item',
								'id' => 'factura_compra',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'factura_compra')
								)
							),
							'DevolucionCompra'=> 
							array(
								'text' => 'Devolución Compra', 
								'type' => 'item',
								'id' => 'devolucion_compra',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'devolucion_compra')
								)
							)
						)
					)
				),
			'FacturaVenta' => 
				array(
				'text' => 'Factura Venta',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'NuevaFactura'=> 
							array(
								'text' => 'Nueva Factura', 
								'type' => 'item',
								'id' => 'factura_venta',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'factura_venta')
								)
							),
							'NotaCredito'=> 
							array(
								'text' => 'Nota Crédito', 
								'type' => 'item',
								'id' => 'nota_credito',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'nota_credito')
								)
							)
						)
					)
				),
			'Transacciones' => 
				array(
				'text' => 'Transacciones',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'NuevoIngreso'=> 
							array(
								'text' => 'Nuevo Ingreso', 
								'type' => 'item',
								'id' => 'ingresos',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'ingresos')
								)
							),
							'NuevoEgreso'=> 
							array(
								'text' => 'Nuevo Egreso', 
								'type' => 'item',
								'id' => 'egresos',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'egresos')
								)
							)
						)
					)
				),
			'Cartera' => 
				array(
				'text' => 'Cartera',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'CuentasCobrar'=> 
							array(
								'text' => 'Cuentas Cobrar', 
								'type' => 'item',
								'id' => 'cuentas_cobrar',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'cuentas_cobrar')
								)
							),
							'CuentasPagar'=> 
							array(
								'text' => 'Cuentas Pagar', 
								'type' => 'item',
								'id' => 'cuentas_pagar',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'cuentas_pagar')
								)
							)
						)
					)
				),
			'Reportes' => 
				array(
				'text' => 'Reportes',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'ReportesVarios'=> 
							array(
								'text' => 'Reportes Varios', 
								'type' => 'item',
								'id' => 'reportes_varios',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'reportes_varios')
								)
							),
							'ReportesEstadisticos'=> 
							array(
								'text' => 'Reportes Estadisticos', 
								'type' => 'item',
								'id' => 'reportes_estadisticos',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'reportes_estadisticos')
								)
							)
						)
					)
				),
			
			);
		$resultado = $class->consulta("SELECT * FROM usuarios WHERE ESTADO = '1' order by id asc");
		while ($row=$class->fetch_array($resultado)) {
		}
		$acu2;
		for ($i = 0; $i < count($acu); $i++) { 
			$acu2[$i] = array(
							'text' => $acu[$i], 
							'type' => 'folder',
							'additionalParameters' => 
												array(
													'id' => '1',
													'children'=> 
													array('opcion2' => 
														array(
															'text' => 'opcion2', 
															'type' => 'item',
															'id'=>'moji',
															'additionalParameters' => 
															array(
																'id' => '101',
																'item-selected' => true
															)
														)
													)
												)
											);
		}

		print(json_encode($acumulador));
	}
	// fin
?>

