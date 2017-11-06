<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	include_once('../../admin/funciones_generales.php');
	$class = new constante();
	error_reporting(0);
	
	$fecha = $class->fecha_hora();
	$cadena = " ".$_POST['img'];	
	$buscar = 'data:image/png;base64,';

	// modificar imagen
	if (isset($_POST['btn_guardar']) == "btn_guardar") {
		$resp = img_64("imagenes",$_POST['img'],'png',$_POST['id_producto']);

		$resp = $class->consulta("UPDATE productos SET imagen = '$_POST[id_producto].png' WHERE id = '$_POST[id_producto]'");	
		

		$data = 1;
		echo $data;
	}
	// fin

	// consultar articulos
	if(isset($_POST['cargar_tabla'])){
		$resultado = $class->consulta("SELECT id, codigo_barras, codigo, descripcion, precio_costo, precio_minorista, precio_mayorista, stock, estado FROM productos ORDER BY id ASC ");
		while ($row=$class->fetch_array($resultado)) {
			$lista[] = array('id' => $row[0],
						'codigo_barras' => $row['codigo_barras'],
						'codigo' => $row['codigo'],
						'descripcion' => $row['descripcion'],
						'precio_costo' => $row['precio_costo'],
						'precio_minorista' => $row['precio_minorista'],
						'precio_mayorista' => $row['precio_mayorista'],
						'stock' => $row['stock'],
						'estado' => $row['estado']
						);
		}
		echo $lista = json_encode($lista);
	}
	// fin

	//cargar imagen articulos
	if (isset($_POST['llenar_foto'])) {
		$resultado = $class->consulta("SELECT * FROM productos WHERE id = '$_POST[id]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array('imagen' => $row['imagen']);
		}
		print_r(json_encode($data));
	}
	//fin
?>