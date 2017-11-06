<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();

	//LLena combo proveedor
	if (isset($_POST['llenar_proveedor'])) {
		$resultado = $class->consulta("SELECT id, empresa FROM proveedores WHERE estado = '1'");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row['id'].'">'.$row['empresa'].'</option>';
		}
	}
	// fin
?>