<?php
    include_once('../../admin/class.php');
    $class = new constante();   
    date_default_timezone_set('America/Guayaquil');
    setlocale (LC_TIME,"spanish");

    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sidx = $_GET['sidx'];
    $sord = $_GET['sord'];
    $search = $_GET['_search'];
    if (!$sidx)
        $sidx = 1;
    
    $count = 0;
    $resultado = $class->consulta("SELECT  COUNT(*) AS count from usuarios WHERE estado = '1'");         
    while ($row = $class->fetch_array($resultado)) {
        $count = $count + $row[0];    
    }    
    if ($count > 0 && $limit > 0) {
        $total_pages = ceil($count / $limit);
    } else {
        $total_pages = 0;
    }
    if ($page > $total_pages)
        $page = $total_pages;
    $start = $limit * $page - $limit;
    if ($start < 0)
        $start = 0;
    
    if ($search == 'false') {
        $SQL = "SELECT U.id, U.identificacion, U.nombres_completos, U.telefono1, U.telefono2, U.ciudad, U.direccion, U.correo, U.usuario, U.clave, U.id_cargo, C.nombre_cargo, U.observaciones FROM usuarios U, cargos C WHERE U.id_cargo = C.id AND U.estado = '1' ORDER BY $sidx $sord offset $start limit $limit";
    } else {
        $campo = $_GET['searchField'];
      
        if ($_GET['searchOper'] == 'eq') {
            $SQL = "SELECT U.id, U.identificacion, U.nombres_completos, U.telefono1, U.telefono2, U.ciudad, U.direccion, U.correo, U.usuario, U.clave, U.id_cargo, C.nombre_cargo, U.observaciones FROM usuarios U, cargos C WHERE U.id_cargo = C.id AND U.estado = '1' AND $campo = '$_GET[searchString]' ORDER BY $sidx $sord offset $start limit $limit";
        }         
        if ($_GET['searchOper'] == 'cn') {
            $SQL = "SELECT U.id, U.identificacion, U.nombres_completos, U.telefono1, U.telefono2, U.ciudad, U.direccion, U.correo, U.usuario, U.clave, U.id_cargo, C.nombre_cargo, U.observaciones FROM usuarios U, cargos C WHERE U.id_cargo = C.id AND U.estado = '1' AND $campo like '%$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";
        }
    }  

    $resultado = $class->consulta($SQL);  
    
    header("Content-Type: text/html;charset=utf-8");   
    $s = "<?xml version='1.0' encoding='utf-8'?>";
    $s .= "<rows>";
        $s .= "<page>" . $page . "</page>";
        $s .= "<total>" . $total_pages . "</total>";
        $s .= "<records>" . $count . "</records>";
        while ($row = $class->fetch_array($resultado)) {
            $s .= "<row id='" . $row[0] . "'>";
            $s .= "<cell>" . $row[0] . "</cell>";
            $s .= "<cell>" . $row[1] . "</cell>";
            $s .= "<cell>" . $row[2] . "</cell>";
            $s .= "<cell>" . $row[3] . "</cell>";
            $s .= "<cell>" . $row[4] . "</cell>";
            $s .= "<cell>" . $row[5] . "</cell>";
            $s .= "<cell>" . $row[6] . "</cell>";
            $s .= "<cell>" . $row[7] . "</cell>";
            $s .= "<cell>" . $row[8] . "</cell>";
            $s .= "<cell>" . $row[9] . "</cell>";
            $s .= "<cell>" . $row[10] . "</cell>";
            $s .= "<cell>" . $row[11] . "</cell>";
            $s .= "<cell>" . $row[12] . "</cell>";
            $s .= "</row>";
        }
    $s .= "</rows>";
    echo $s;    
?>