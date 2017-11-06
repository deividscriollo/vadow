<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	include_once('../../admin/funciones_generales.php');
	$class = new constante();
	error_reporting(0);
	
	// guardar productos de excel
	$fecha = $class->fecha_hora();
	if (isset($_POST['btn_guardar']) == "btn_guardar") {
		$id_productos = $class->idz();

		$resp = $class->consulta("INSERT INTO productos VALUES (	'$id_productos',
																	'$_POST[var]',
																	'$_POST[var1]',
																	'$_POST[var2]',
																	'".number_format($_POST['var3'], 3, '.', '')."',
																	'0.000',
																	'0.000',
																	'".number_format($_POST['var4'], 3, '.', '')."',
																	'".number_format($_POST['var5'], 3, '.', '')."',
																	'201605121659255734fcbd130da',
																	'',
																	'',
																	'',
																	'201605111430385733885e2e043',
																	'201605121600305734eeee5f3e6',
																	'$_POST[var8]',
																	'$_POST[var6]',
																	'0',
																	'0',
																	'0',
																	'NO',
																	'$_POST[var9]',
																	'',
																	'',
																	'NO',
																	'articulo.jpg',
																	'',
																	'1', 
																	'$fecha');");	
		

		$data = 1;
		echo $data;
	}
	// fin
?>