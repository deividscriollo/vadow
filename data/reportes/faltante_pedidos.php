<?php
    require('../../fpdf/fpdf.php');
    include_once('../../admin/class.php');
    include_once('../../admin/funciones_generales.php');
    $class = new constante();    
    date_default_timezone_set('America/Guayaquil'); 
    session_start();

    class PDF extends FPDF {   
        var $widths;
        var $aligns;
        function SetWidths($w) {            
            $this->widths=$w;
        } 

        function Header() {             
            $this->AddFont('Amble-Regular','','Amble-Regular.php');
            $this->AddFont('Amble-Regular');
            $this->SetFont('Amble-Regular','',10);        
            $fecha = date('Y-m-d', time());
            $this->SetX(1);
            $this->SetY(1);
            $this->Cell(20, 5, $fecha, 0,0, 'C', 0);                         
            $this->Cell(150, 5, "FALTANTE DE PEDIDOS", 0,1, 'R', 0);      
            $this->SetFont('Arial','B',16);                                                    
            $this->Cell(190, 8, "EMPRESA: ".$_SESSION['empresa']['empresa'], 0,1, 'C',0);                                
            $this->Image('logo_empresa.jpg',1,8,40,30);
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(180, 5, "PROPIETARIO: ".utf8_decode($_SESSION['empresa']['propietario']),0,1, 'C',0);                                
            $this->Cell(70, 5, "TEL.: ".utf8_decode($_SESSION['empresa']['telefono1']),0,0, 'R',0);                                
            $this->Cell(60, 5, "CEL.: ".utf8_decode($_SESSION['empresa']['telefono2']),0,1, 'C',0);                                
            $this->Cell(170, 5, "DIR.: ".utf8_decode($_SESSION['empresa']['direccion']),0,1, 'C',0);                                
            $this->Cell(170, 5, "SLOGAN.: ".utf8_decode($_SESSION['empresa']['slogan']),0,1, 'C',0);                                
            $this->Cell(170, 5, utf8_decode( $_SESSION['empresa']['ciudad']),0,1, 'C',0);

            $this->SetFont('Arial','B',12);
            $this->Cell(170, 5, utf8_decode("FALTANTE DE PEDIDOS"),0,1, 'C',0);           
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(80, 5, utf8_decode("DESDE: ".$_GET['inicio']),0,0, 'C',0);           
            $this->Cell(80, 5, utf8_decode("HASTA: ".$_GET['fin']),0,1, 'C',0);           
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.3);
            $this->Line(1,50,210,50);
            $this->Ln(5);
            $this->SetX(1);            
            $this->Cell(30, 5, utf8_decode("Código"),1,0, 'C',0);
            $this->Cell(95, 5, utf8_decode("Producto"),1,0, 'C',0);
            $this->Cell(30, 5, utf8_decode("Total Pedido"),1,0, 'C',0);        
            $this->Cell(30, 5, utf8_decode("Stock"),1,0, 'C',0);    
            $this->Cell(20, 5, utf8_decode("Faltante"),1,1, 'C',0);   
        }
        function Footer(){            
            $this->SetY(-15);            
            $this->SetFont('Arial','I',8);            
            $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');
        }               
    }
    $pdf = new PDF('P','mm','a4');
    $pdf->AddPage();
    $pdf->SetMargins(0,0,0,0);
    $pdf->AliasNbPages();
    $pdf->AddFont('Amble-Regular');                    
    $pdf->SetFont('Amble-Regular','',10);       
    $pdf->SetFont('Arial','B',9);   
    $pdf->SetX(5);

    $codigo_producto = array();
    $nombre_producto = array();
    $cantidad_producto = array();
    $stock_producto = array();
    $resultado = $class->consulta("SELECT id FROM proforma WHERE fecha_actual BETWEEN '".$_GET['inicio']."' AND '".$_GET['fin']."' AND estado = '1'");       
    while ($row = $class->fetch_array($resultado)) {
        $resultado1 = $class->consulta("SELECT D.id_producto, D.cantidad, P.codigo, P.descripcion ,P.stock FROM detalle_proforma D, productos P WHERE D.id_producto = P.id AND D.estado = '1' AND D.id_proforma = '".$row[0]."' ORDER BY P.id ASC");

        while ($row1 = $class->fetch_array($resultado1)) {                                   
            $contador;
            $posicion = -1;
            $cont = 0;
            if(count($codigo_producto) > 0){                                
                for($contador=0; $contador < count($codigo_producto); $contador++){
                    if($codigo_producto[$contador] == $row1[2]) {
                        $posicion = $contador;
                        $codigo_producto[$contador] = $row1[2];                
                        $nombre_producto[$contador] = $row1[3];                
                        $cantidad_producto[$contador] = $cantidad_producto[$contador] + $row1[1];                
                        $stock_producto[$contador] = $row1[4];                        
                        $cont = 1;
                        break;
                    }                                        
                }
                if($cont == 0) {
                    $codigo_producto[] = $row1[2];                
                    $nombre_producto[] = $row1[3];                
                    $cantidad_producto[] = $row1[1];                
                    $stock_producto[] = $row1[4];                        
                }
            } else {                
                $codigo_producto[] = $row1[2];                
                $nombre_producto[] = $row1[3];                
                $cantidad_producto[] = $row1[1];                
                $stock_producto[] = $row1[4];                
            }          
        }
    }

    $agrupados = array();
    for($i = 0;  $i < count($codigo_producto); $i++) {
        $agrupados[$i]['codigo'] = $codigo_producto[$i];
        $agrupados[$i]['nombre_producto'] = $nombre_producto[$i];
        $agrupados[$i]['cantidad_producto'] = $cantidad_producto[$i];
        $agrupados[$i]['stock_producto'] = $stock_producto[$i];
    }            
    array_multisort($agrupados, SORT_ASC);   
    $pdf->SetFont('Amble-Regular','',9);   
    $pdf->SetX(5);        
    for($cont_vector = 0; $cont_vector < count($codigo_producto); $cont_vector++){
        $pdf->SetX(1);                  
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(30, 5, utf8_decode($agrupados[$cont_vector]['codigo']),0,0, 'L',0);
        $pdf->Cell(95, 5, maxCaracter(utf8_decode($agrupados[$cont_vector]['nombre_producto']),50),0,0, 'L',0);
        $pdf->Cell(30, 5, utf8_decode($agrupados[$cont_vector]['cantidad_producto']),0,0, 'C',0);        
        $pdf->Cell(30, 5, utf8_decode($agrupados[$cont_vector]['stock_producto']),0,0, 'C',0);                         
        $faltante = $agrupados[$cont_vector]['stock_producto'] - $agrupados[$cont_vector]['cantidad_producto'];
        if($faltante > 0) {
            $pdf->SetTextColor(240,11,11);
            $pdf->Cell(20, 5, utf8_decode('0'),0,0, 'C',0);                             
        } else {
            $pdf->SetTextColor(240,11,11);
            $pdf->Cell(20, 5, utf8_decode(abs($faltante)),0,0, 'C',0);                                 
        }        
        $pdf->Ln(5);                      
    }   
                                                     
    $pdf->Output();
?>

