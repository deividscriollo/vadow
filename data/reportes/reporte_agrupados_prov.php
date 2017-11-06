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
            $this->Cell(150, 5, "PRODUCTOS AGRUPADOS POR PROVEEDOR", 0,1, 'R', 0);
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
            $this->Line(1,55,210,55);            
            $this->SetFont('Arial','B',12);                                                                
            $this->Cell(190, 5, utf8_decode("PRODUCTOS AGRUPADOS POR PROVEEDOR"),0,1, 'C',0);                                                                                                                
            $this->SetFont('Amble-Regular','',10);        
            $this->Ln(2);
            $resultado = $class->consulta("SELECT P.id, P.identificacion, P.empresa FROM proveedores P, factura_compra F WHERE P.id = '$_GET[id]' LIMIT 1");                        
            $this->SetLineWidth(0.2);
            while ($row = $class->fetch_array($resultado)) {           
                $this->SetX(1);                  
                $this->Cell(80, 8, utf8_decode('RUC/CI: '.$row[1]),1,0, 'L',1);                                                                          
                $this->Cell(125, 8, utf8_decode('NOMBRE: '.$row[2]),1,1, 'L',1);                                                                          
            }
                                    
            $this->Ln(2);
            $this->SetX(1);
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(35, 5, utf8_decode("Nro Factura"),1,0, 'C',0);
            $this->Cell(30, 5, utf8_decode("Código"),1,0, 'C',0);
            $this->Cell(60, 5, utf8_decode("Producto"),1,0, 'C',0);        
            $this->Cell(30, 5, utf8_decode("Precio Compra"),1,0, 'C',0);    
            $this->Cell(30, 5, utf8_decode("Total Compra"),1,0, 'C',0);    
            $this->Cell(20, 5, utf8_decode("Cantidad"),1,1, 'C',0);               
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
    $total = 0;

    $resultado = $class->consulta("SELECT P.id, P.identificacion, F.id, F.serie FROM proveedores P, factura_compra F WHERE F.id_proveedor = P.id AND P.id = '$_GET[id]'");
    while ($row = $class->fetch_array($resultado)) {       
        $resultado1 = $class->consulta("SELECT D.id, P.codigo, P.descripcion, P.precio_minorista, P.precio_mayorista, P.stock, D.precio_compra, D.total_compra, D.cantidad FROM detalle_factura_compra D, productos P WHERE D.id_producto = P.id AND D.id_factura_compra = '$row[2]' order by D.id asc");

        while ($row1 = $class->fetch_array($resultado1)) {          
            $pdf->SetX(1);                  
            $pdf->Cell(35, 5, maxCaracter(utf8_decode($row[3]),20),0,0, 'L',0);
            $pdf->Cell(30, 5, maxCaracter(utf8_decode($row1[1]),12),0,0, 'L',0);
            $pdf->Cell(60, 5, maxCaracter(utf8_decode($row1[2]),40),0,0, 'L',0);        
            $pdf->Cell(30, 5, maxCaracter(utf8_decode($row1[6]),10),0,0, 'C',0);                         
            $pdf->Cell(30, 5, maxCaracter( utf8_decode($row1[7]),10),0,0, 'C',0);                         
            $pdf->Cell(20, 5, maxCaracter( utf8_decode($row1[8]),10),0,0, 'C',0);                         
            $pdf->Ln(5);        
        }    
        $total=$total+$row1[7];                                                            
    }
    $pdf->SetX(1);                  
    $pdf->Ln(5);   
    $pdf->Cell(185, 5, "Totales:",0,0, 'R',0);                         
    $pdf->Cell(20, 5, number_format($total,2,',','.'),0,1, 'C',0);

    $pdf->Output();
?>