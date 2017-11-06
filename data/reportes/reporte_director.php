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
        function SetWidths($w){            
            $this->widths=$w;
        } 

        function Header(){             
            $this->AddFont('Amble-Regular','','Amble-Regular.php');
            $this->SetFont('Amble-Regular','',10);        
            $fecha = date('Y-m-d', time());
            $this->SetX(1);
            $this->SetY(1);
            $this->Cell(20, 5, $fecha, 0,0, 'C', 0);                         
            $this->Cell(150, 5, "DIRECTORES", 0,1, 'R', 0);      
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
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.5);
            $this->SetFillColor(120,120,120);
            $this->Line(1,50,210,50);            
            $this->SetFont('Arial','B',12);                                                                
            $this->Cell(190, 5, utf8_decode("REPORTE DE VENTAS POR DIRECTOR"),0,1, 'C',0);                                                                                                                
            $this->SetFont('Arial','B',10);                                                                            
            $this->Cell(90, 5, utf8_decode($_GET['inicio']),0,0, 'R',0);                                                                                        
            $this->Cell(40, 5, utf8_decode($_GET['fin']),0,1, 'C',0);                                      
            $this->SetFont('Amble-Regular','',10);                                                                      
            $this->Ln(5);              
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
    $pdf->SetFont('Amble-Regular','',9); 
    
    $resultado = $class->consulta("SELECT id, identificacion ,nombres_completos FROM directores WHERE id = '$_GET[id]'");
    
    while ($row = $class->fetch_array($resultado)) {
        $pdf->SetX(1); 
        $pdf->SetFillColor(187, 179, 180);            
        $pdf->Cell(70, 6, maxCaracter(utf8_decode('RUC/CI:'.$row[1]),35),1,0, 'L',1);                                     
        $pdf->Cell(135, 6, maxCaracter(utf8_decode('DIRECTOR:'.$row[2]),50),1,1, 'L',1);                                                                  
    }

    $pdf->SetX(1);        
    $pdf->Cell(40, 6, utf8_decode("CI/RUC"),1,0, 'C',0);
    $pdf->Cell(75, 6, utf8_decode("Nombres"),1,0, 'C',0);
    $pdf->Cell(50, 6, utf8_decode("Nro. Facturas"),1,0, 'C',0);        
    $pdf->Cell(40, 6, utf8_decode("Total Facturas"),1,1, 'C',0);                        
    
    $resultado = $class->consulta("SELECT C.id, C.identificacion, C.nombres_completos FROM clientes C, asignacion_clientes_directores A WHERE A.id_cliente = C.id AND A.id_director = '$_GET[id]' ORDER BY C.id ASC");
    $cont1 = 0;
    $cont2 = 0;

    while ($row = $class->fetch_array($resultado)) {
        $temp = 0;
        $temp1 = 0;
        $resultado1 = $class->consulta("SELECT COUNT(id) AS contador, SUM(total_venta::float) as total_venta FROM factura_venta WHERE id_cliente ='$row[0]' AND estado ='1'");
        while ($row1 = $class->fetch_array($resultado1)) {
            $temp = $row1[0];
            if ($row1[1] == "") {
                $temp1 = "$ 0";
            } else {
                $temp1 = "$ " . $row1[1];
            }
            $cont1 = $cont1 + $row1[0];
            $cont2 = $cont2 + $row1[1];
        }
        $pdf->SetX(1);        
        $pdf->Cell(40, 6, utf8_decode($row[1]),0,0, 'C',0);                               
        $pdf->Cell(75, 6, utf8_decode($row[2]),0,0, 'C',0);                       
        $pdf->Cell(40, 6, utf8_decode($temp),0,0, 'C',0);                       
        $pdf->Cell(40, 6, utf8_decode($temp1),0,1, 'C',0);                           
    }

    $pdf->SetX(1);                                             
    $pdf->Cell(207, 0, utf8_decode(""),1,1, 'R',0);
    $pdf->Cell(85, 6, utf8_decode("Totales"),0,0, 'R',0);
    $pdf->Cell(25, 6, maxCaracter((number_format($cont1,2,',','.')),20),0,0, 'C',0);                                                    
    $pdf->Cell(25, 6, maxCaracter((number_format($cont2,2,',','.')),20),0,1, 'C',0);                                                    
    $pdf->Ln(3);

    $pdf->Output();
?>