<?php 
include_once('../admin/class.php');
$class=new constante();
$resultado = $class->consulta("DELETE FROM sucursales_empresa WHERE nombre_empresa_sucursal='';");
		

?>