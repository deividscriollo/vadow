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
		$resp = img_64("imagenes",$_POST['img'],'png',$_POST['id_empresa']);

		$resp = $class->consulta("UPDATE empresa SET imagen = '$_POST[id_empresa].png' WHERE id = '$_POST[id_empresa]'");	
		

		$data = 1;
		echo $data;
	}
	// fin

	// consultar empresa
	if(isset($_POST['cargar_tabla'])){
		$resultado = $class->consulta("SELECT * FROM empresa ORDER BY id ASC");
		while ($row=$class->fetch_array($resultado)) {
			$lista[] = array('id' => $row[0],
						'ruc_empresa' => $row['ruc'],
						'razon_social' => $row['razon_social'],
						'actividad_economica' => $row['actividad_economica'],
						'direccion_matriz' => $row['direccion_matriz'],
						'estado' => $row['estado']
						);
		}
		echo $lista = json_encode($lista);
	}
	// fin

	//cargar imagen empresa
	if (isset($_POST['llenar_foto'])) {
		$resultado = $class->consulta("SELECT * FROM empresa WHERE id = '$_POST[id]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array('imagen' => $row['imagen']);
		}
		print_r(json_encode($data));
	}
	//fin
?>