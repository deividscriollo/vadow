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
            $this->widths = $w;
        } 

        function Header() {                         
            $this->AddFont('Amble-Regular','','Amble-Regular.php');
            $this->SetFont('Amble-Regular','',10);        
            $fecha = date('Y-m-d', time());
            $this->SetX(1);
            $this->SetY(1);
            $this->Cell(20, 5, $fecha, 0,0, 'C', 0);                         
            $this->Cell(150, 5, "EGRESOS", 0,1, 'R', 0);      
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
            $this->SetLineWidth(0.4);            
            $this->Line(1,46,210,46);            
            $this->SetFont('Arial','B',12);                                                                            
            $this->Cell(190, 5, utf8_decode("EGRESOS "),0,1, 'C',0);                                                                                                                            
            $this->SetFont('Amble-Regular','',10);        
            $this->Ln(3);
            $this->SetFillColor(255,255,225);            
            $this->SetLineWidth(0.2);                                        
        }
        function Footer() {            
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
    
    $resultado = $class->consulta("SELECT E.origen, E.destino, E.fecha_actual, E.tarifa0, E.tarifa, E.iva_egreso, E.descuento_egreso, E.total_egreso FROM egreso E WHERE id = '$_GET[id]';");        
    while ($row = $class->fetch_array($resultado)) { 
        $pdf->SetFillColor(187, 179, 180);                                              
        $pdf->SetX(1); 
        $pdf->Cell(75, 6, maxCaracter(utf8_decode('ORIGEN:'.$row[0]),50),1,0, 'L',1);                                             
        $pdf->Cell(70, 6, maxCaracter(utf8_decode('DESTINO:'.$row[1]),50),1,0, 'L',1);                                             
        $pdf->Cell(60, 6, maxCaracter(utf8_decode('FECHA EGRESO:'.$row[2]),50),1,1, 'L',1);    
        $pdf->Ln(3);       
        
        $pdf->SetX(1);                                       
        $pdf->Cell(30, 6, utf8_decode('Código'),1,0, 'C',0);                                         
        $pdf->Cell(85, 6, utf8_decode('Producto'),1,0, 'C',0);                                         
        $pdf->Cell(20, 6, utf8_decode('Cantidad'),1,0, 'C',0);                                         
        $pdf->Cell(25, 6, utf8_decode('Precio Costo'),1,0, 'C',0);                                         
        $pdf->Cell(25, 6, utf8_decode('Precio Venta'),1,0, 'C',0);                                         
        $pdf->Cell(20, 6, utf8_decode('Total'),1,1, 'C',0);                   
    
        $temp1 = $row[3];
        $temp2 = $row[4];
        $temp3 = $row[5];
        $temp4 = $row[6];
        $temp5 = $row[7];                          
    }

    $resultado = $class->consulta("SELECT * FROM detalle_egreso D, productos P where D.id_producto = P.id and D.id_egreso ='$_GET[id]'");        
    while ($row = $class->fetch_array($resultado)) {                                            
        $pdf->Cell(30, 6, maxCaracter(utf8_decode($row[11]),15),0,0, 'L',0);                                             
        $pdf->Cell(85, 6, maxCaracter(utf8_decode($row[12]),25),0,0, 'L',0);                                             
        $pdf->Cell(20, 6, utf8_decode($row[3]),0,0, 'C',0);                                             
        $pdf->Cell(25, 6, utf8_decode($row[4]),0,0, 'C',0);                      
        $pdf->Cell(25, 6, utf8_decode($row[17]),0,0, 'C',0);                              
        $pdf->Cell(20, 6, utf8_decode($row[6]),0,1, 'C',0);                                      
    }
    
    $pdf->SetX(1);
    $pdf->Cell(205, 0, utf8_decode(''),1,1, 'R',1);                                     
    $pdf->Cell(186, 6, utf8_decode('Tarifa 0:'),0,0, 'R',0);                                         
    $pdf->Cell(20, 6,(number_format($temp1,2,',','.')) ,0,1, 'C',0);          

    $pdf->SetX(1);    
    $pdf->Cell(186, 6, utf8_decode('Tarifa IVA:'),0,0, 'R',0);                                         
    $pdf->Cell(20, 6,(number_format($temp2,2,',','.')) ,0,1, 'C',0);          

    $pdf->SetX(1);    
    $pdf->Cell(186, 6, utf8_decode('Iva:'),0,0, 'R',0);                                         
    $pdf->Cell(20, 6,(number_format($temp3,2,',','.')) ,0,1, 'C',0);          

    $pdf->SetX(1);    
    $pdf->Cell(186, 6, utf8_decode('Descuento:'),0,0, 'R',0);                                         
    $pdf->Cell(20, 6,(number_format($temp4,2,',','.')) ,0,1, 'C',0);          

    $pdf->SetX(1);    
    $pdf->Cell(186, 6, utf8_decode('Total:'),0,0, 'R',0);                                         
    $pdf->Cell(20, 6,(number_format($temp5,2,',','.')) ,0,1, 'C',0);          

    $pdf->Output();
?>