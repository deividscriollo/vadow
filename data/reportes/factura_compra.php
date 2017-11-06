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
            $class = new constante();             
            $this->AddFont('Amble-Regular','','Amble-Regular.php');
            $this->SetFont('Amble-Regular','',10);        
            $fecha = date('Y-m-d', time());
            $this->SetX(1);
            $this->SetY(1);
            $this->Cell(20, 5, $fecha, 0,0, 'C', 0);                         
            $this->Cell(150, 5, "FACTURA COMPRA", 0,1, 'R', 0);      
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

            $this->SetFillColor(120,120,120);
            $this->Line(1,78,210,78);            
            $this->Line(1,45,210,45);            
            $this->SetFont('Arial','B',12);                                                                
            $this->Cell(190, 5, utf8_decode("FACTURA COMPRA"),0,1, 'C',0);                                                                                                                
            $this->SetFont('Amble-Regular','',10);        
            $this->Ln(2);
            $this->SetFillColor(255,255,225);
            $resultado = $class->consulta("SELECT F.id, f.comprobante, F.fecha_actual, F.hora_actual, F.serie, F.autorizacion, F.fecha_cancelacion, P.empresa, P.representante_legal, F.forma_pago FROM factura_compra F, proveedores P WHERE F.id_proveedor = P.id and F.id = '$_GET[id]'");    
            $this->SetLineWidth(0.2);
            while ($row = $class->fetch_array($resultado)) {                          
                $this->SetX(1);                                  
                $this->Cell(85, 6, utf8_decode('COMPROBANTE: '.$row[1]),0,0, 'L',1);                                
                $this->Cell(120, 6, utf8_decode('FECHA: '.$row[2]),0,1, 'L',1);                
                $this->SetX(1);                                  
                $this->Cell(85, 6, utf8_decode('HORA: '.$row[3]),0,0, 'L',1);                
                $this->Cell(120, 6, utf8_decode('NRO. SERIE: '.$row[4]),0,1, 'L',1);                
                $this->SetX(1);                                  
                $this->Cell(85, 6, utf8_decode('NRO AUTORIZACIÓN: '.$row[5]),0,0, 'L',1);                                
                $this->Cell(120, 6, utf8_decode('FECHA CANCELACIÓN: '.$row[6]),0,1, 'L',1);                
                $this->SetX(1);                                  
                $this->Cell(85, 6, utf8_decode('FORMA PAGO: '.$row[9]),0,0, 'L',1);                                
                $this->Cell(120, 6, utf8_decode('EMPRESA: '.$row[7]),0,1, 'L',1);                
                
                $this->SetX(1);                                  
                $this->Cell(205, 6, utf8_decode('REPRESENTANTE: '.$row[8]),0,1, 'L',1);                 
            }

            $this->Ln(5);                        
            $this->SetX(1);
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(35, 5, utf8_decode("Cantidad"),1,0, 'C',0);
            $this->Cell(110, 5, utf8_decode("Descripción"),1,0, 'C',0);
            $this->Cell(30, 5, utf8_decode("V. Unitario"),1,0, 'C',0);        
            $this->Cell(30, 5, utf8_decode("V. Total"),1,0, 'C',0);                
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
    $total = 0;      
    $resultado = $class->consulta("select D.cantidad, P.descripcion, D.precio_compra, D.total_compra from factura_compra F, detalle_factura_compra D ,productos P where F.id = D.id_factura_compra and D.id_producto = P.id and D.id_factura_compra = '$_GET[id]'");   
    while ($row = $class->fetch_array($resultado)) {                
        $pdf->SetX(1);                  
        $pdf->Cell(35, 5, maxCaracter(utf8_decode($row[0]),20),0,0, 'C',0);
        $pdf->Cell(110, 5, maxCaracter(utf8_decode($row[1]),80),0,0, 'L',0);
        $pdf->Cell(30, 5, maxCaracter(utf8_decode($row[2]),20),0,0, 'C',0);        
        $pdf->Cell(30, 5, maxCaracter(utf8_decode($row[3]),20),0,0, 'C',0);                                     
        $pdf->Ln(5);                                                                
    }
    $pdf->SetX(1);                  
    $pdf->Ln(5);   
    $resultado = $class->consulta("select F.descuento_compra, F.tarifa0, F.tarifa, F.iva_compra, F.total_compra from factura_compra F, detalle_factura_compra D, productos P where F.id = D.id_factura_compra and D.id_producto = P.id and D.id_factura_compra = '$_GET[id]' limit 1");    
    while ($row = $class->fetch_array($resultado)) {
        $pdf->Cell(173, 6, utf8_decode("Descuento"),0,0, 'R',0);
        $pdf->Cell(35, 6, maxCaracter(utf8_decode($row[0]),20),0,1, 'C',0);
        $pdf->Cell(173, 6, utf8_decode("Tarifa 0"),0,0, 'R',0);
        $pdf->Cell(35, 6, maxCaracter(utf8_decode($row[1]),20),0,1, 'C',0);
        $pdf->Cell(173, 6, utf8_decode("Tarifa IVA"),0,0, 'R',0);
        $pdf->Cell(35, 6, maxCaracter(utf8_decode($row[2]),20),0,1, 'C',0);
        $pdf->Cell(173, 6, utf8_decode("Iva ...%"),0,0, 'R',0);
        $pdf->Cell(35, 6, maxCaracter(utf8_decode($row[3]),20),0,1, 'C',0);
        $pdf->Cell(173, 6, utf8_decode("Total"),0,0, 'R',0);
        $pdf->Cell(35, 6, maxCaracter(utf8_decode($row[4]),20),0,1, 'C',0);
    }

    $pdf->Output();
?>

