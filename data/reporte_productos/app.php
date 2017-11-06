<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class=new constante();

	//LLena combo directores
	if (isset($_POST['llenar_director'])) {
		$resultado = $class->consulta("SELECT id, nombres_completos FROM directores WHERE estado = '1'");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row['id'].'">'.$row['nombres_completos'].'</option>';
		}
	}
	// fin
?>