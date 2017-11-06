<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();
	error_reporting(0);

	$cont = 0; 
	$fecha = $class->fecha_hora();

	if (isset($_POST['btn_modificar']) == "btn_modificar") {
		$data = "";
		$contrasenia = md5($_POST['confirme']);

		$resp = $class->consulta("UPDATE usuarios SET clave = '$contrasenia' WHERE id = '".$_SESSION['user']['id']."'");	
		$data = 1;
		
		echo $data;
	}

	// cargar usuarios conectados
	if (isset($_POST['session'])) {
		$resultado = $class->consulta("SELECT * FROM usuarios WHERE estado = '1' AND id = '".$_SESSION['user']['id']."'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array('id' => $row[0], 'identificacion' => $row[1], 'nombres' => $row[2], 'telefono' => $row[3], 'celular' => $row[4], 'correo' => $row[7], 'ciudad' => $row[5], 'direccion' => $row[6], 'usuario' => $row[8], 'imagen' => $row[11]);
		}

		print_r(json_encode($data));
	}
	// fin

	if (isset($_POST['verificar_pass'])) {
		$resultado = $class->consulta("SELECT * FROM usuarios WHERE clave = md5('$_POST[actual]')");
		$acu = 'false';
		while ($row = $class->fetch_array($resultado)) {	
			$acu = 'true';
		}
		print $acu;
	}
?>