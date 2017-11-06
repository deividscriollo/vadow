<?php 
	include_once('../../admin/class.php');
	$class = new constante();
	session_start(); 
	error_reporting(0);

	$resultado = $class->consulta("SELECT * FROM productos  P, porcentaje_iva V WHERE P.id_porcentaje = V.id AND P.estado = '1' AND P.codigo_barras = '$_GET[codigo_barras]'");
	while ($row = $class->fetch_array($resultado)) {
		if ($_GET['tipo_precio'] == "MINORISTA") {
	        $data = array(
	        	'id' => $row[0],
	            'codigo_barras' => $row[1],
	            'codigo' => $row[2],
	            'producto' => $row[3],
	            'precio_costo' => $row[4],
	            'precio_venta' => $row[7],
	            'descuento' => $row[19],
	            'stock' => $row[16],
	            'iva_producto' => $row[31],
	            'incluye' => $row[15]
	        );
	    } else {
	        if ($_GET['tipo_precio'] == "MAYORISTA") {
	            $data = array(
	            	'id' => $row[0],
	                'codigo_barras' => $row[1],
	                'codigo' => $row[2],
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
	}
	echo $data = json_encode($data);

?>