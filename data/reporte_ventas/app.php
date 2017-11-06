<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class=new constante();

	//LLena combo clientes
	if (isset($_POST['llenar_clientes'])) {
		$resultado = $class->consulta("SELECT id, nombres_completos FROM clientes WHERE estado = '1'");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row['id'].'">'.$row['nombres_completos'].'</option>';
		}
	}
	// fin
?>