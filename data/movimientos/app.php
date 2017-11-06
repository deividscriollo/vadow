<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	include_once('../../admin/funciones_generales.php');
	$class = new constante();
	error_reporting(0);
	
	$fecha = $class->fecha_hora();

	// consultar movimientos
	if(isset($_POST['cargar_tabla'])){
		$resultado = $class->consulta("SELECT P.codigo_barras, P.codigo, P.descripcion, M.saldo_inicial, M.entradas, M.salidas, M.saldo FROM movimientos M, productos P WHERE M.id_producto = P.id ORDER BY M.id ASC ");
		while ($row = $class->fetch_array($resultado)) {
			$lista[] = array('id' => $row[0],
						'codigo_barras' => $row[0],
						'codigo' => $row[1],
						'descripcion' => $row[2],
						'saldo_inicial' => $row[3],
						'entradas' => $row[4],
						'salidas' => $row[5],
						'saldo_total' => $row[6]
						);
		}
		echo $lista = json_encode($lista);
	}
	// fin
?>