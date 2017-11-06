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
            $this->SetFont('Amble-Regular','',10);        
            $fecha = date('Y-m-d', time());
            $this->SetX(1);
            $this->SetY(1);
            $this->Cell(20, 5, $fecha, 0,0, 'C', 0);                         
            $this->Cell(150, 5, "RESUMEN DE FACTURAS COMPRAS", 0,1, 'R', 0);      
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
            $this->Line(1,50,210,50);            
            $this->SetFont('Arial','B',12);                                                                
            $this->Cell(90, 5, utf8_decode($_GET['inicio']),0,0, 'R',0);                                                                                   
            $this->Cell(40, 5, utf8_decode($_GET['fin']),0,1, 'C',0);                                                                                
            $this->Cell(190, 5, utf8_decode("RESUMEN DE FACTURAS COMPRAS"),0,1, 'C',0);                                                                                                                            
            $this->SetFont('Amble-Regular','',10);        
            $this->Ln(3);
            $this->SetFillColor(255,255,225);            
            $this->SetLineWidth(0.2);                                        
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
    $repetido = 0;
    $sub = 0;
    $desc = 0;
    $ivaT = 0; 

    $resultado = $class->consulta('SELECT * FROM proveedores ORDER BY id ASC');
    while ($row = $class->fetch_array($resultado)) {
        $resultado1 = $class->consulta("SELECT F.serie, F.fecha_actual, F.hora_actual, F.fecha_cancelacion, F.autorizacion, F.forma_pago,tarifa0, F.tarifa, F.iva_compra, F.descuento_compra, F.total_compra, P.empresa, P.identificacion, P.representante_legal, F.id FROM factura_compra F, proveedores P WHERE F.id_proveedor = P.id AND F.id_proveedor = '$row[0]' and fecha_actual between '$_GET[inicio]' and '$_GET[fin]' order by F.id");

        $contador = $class->num_rows($resultado1);
        if($contador > 0) {
            while ($row1 = $class->fetch_array($resultado1)) {                                                        
                if($repetido == 0) {                       
                    $pdf->SetX(1); 
                    $pdf->Cell(22, 6, utf8_decode('Comprobante'),1,0, 'C',0);                                     
                    $pdf->Cell(20, 6, utf8_decode('Fecha'),1,0, 'C',0);                                     
                    $pdf->Cell(30, 6, utf8_decode('Nro Factura'),1,0, 'C',0);                                     
                    $pdf->Cell(15, 6, utf8_decode('Subtotal'),1,0, 'C',0);                                     
                    $pdf->Cell(17, 6, utf8_decode('Descuento'),1,0, 'C',0);                                     
                    $pdf->Cell(16, 6, utf8_decode('Tarifa 0%'),1,0, 'C',0);                                     
                    $pdf->Cell(17, 6, utf8_decode('Tarifa IVA'),1,0, 'C',0);                                     
                    $pdf->Cell(15, 6, utf8_decode('Iva ...%'),1,0, 'C',0);                                     
                    $pdf->Cell(15, 6, utf8_decode('Total'),1,0, 'C',0);                                     
                    $pdf->Cell(20, 6, utf8_decode('Fecha Pago'),1,0, 'C',0);                                     
                    $pdf->Cell(20, 6, utf8_decode('Tipo Pago'),1,1, 'C',0);                                                                  
                    $repetido = 1;
                }

                $pdf->SetX(1); 
                $pdf->Cell(22, 6, utf8_decode($row1[14]),0,0, 'C',0);                                     
                $pdf->Cell(20, 6, utf8_decode($row1[1]),0,0, 'C',0);                    
                $pdf->Cell(30, 6, utf8_decode(substr($row1[0],8)),0,0, 'C',0);                                
                $sub=$sub+($row1[10]-$row1[8]-$row1[9]);
                $pdf->Cell(15, 6, ($row1[10]-$row1[8]-$row1[9]),0,0, 'C',0);                                    
                $desc=$desc+$row1[9];
                $pdf->Cell(17, 6, $row1[9],0,0, 'C',0);                    
                $pdf->Cell(16, 6, $row1[6],0,0, 'C',0);                    
                $pdf->Cell(17, 6, $row1[7],0,0, 'C',0);                                                    
                $ivaT=$ivaT+$row1[8];
                $pdf->Cell(15, 6, $row1[8],0,0, 'C',0);                                    
                $total=$total+$row1[10];
                $pdf->Cell(15, 6, $row1[10],0,0, 'C',0);                    
                $pdf->Cell(20, 6, $row1[3],0,0, 'C',0);                    
                $pdf->Cell(20, 6, $row1[5],0,0, 'C',0);                         
                $pdf->Ln(6);                              
            }
        }
    } 

    $pdf->SetX(1);                  
    $pdf->Ln(8);               
    $pdf->Cell(188, 6, utf8_decode("Subtotal"),0,0, 'R',0);
    $pdf->Cell(20, 6, maxCaracter((number_format($sub,2,',','.')),20),0,1, 'C',0);
    $pdf->Cell(188, 6, utf8_decode("Descuento"),0,0, 'R',0);
    $pdf->Cell(20, 6, maxCaracter((number_format($desc,2,',','.')),20),0,1, 'C',0);
    $pdf->Cell(188, 6, utf8_decode("Iva Total"),0,0, 'R',0);
    $pdf->Cell(20, 6, maxCaracter((number_format($ivaT,2,',','.')),20),0,1, 'C',0);
    $pdf->Cell(188, 6, utf8_decode("Total"),0,0, 'R',0);
    $pdf->Cell(20, 6, maxCaracter((number_format($total,2,',','.')),20),0,1, 'C',0);
    
    $pdf->Output();
?>