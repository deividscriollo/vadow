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
            $this->Cell(150, 5, "UTILIDAD GENERAL DE LAS FACTURAS", 0,1, 'R', 0);      
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
            $this->Line(1,50,210,50);            
            $this->SetFont('Arial','B',12);                                                                
            $this->Cell(90, 5, utf8_decode($_GET['inicio']),0,0, 'R',0);                                                                                   
            $this->Cell(40, 5, utf8_decode($_GET['fin']),0,1, 'C',0);                                                                                    
            $this->Cell(190, 5, utf8_decode("UTILIDAD GENERAL DE LAS FACTURAS"),0,1, 'C',0);                                                                                                                            
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
    
    $pdf->SetX(1);                                                
    $pdf->Cell(50, 6, utf8_decode('Nro. Factura'),1,0, 'C',0);                                     
    $pdf->Cell(40, 6, utf8_decode('Tipo Documento'),1,0, 'C',0);                                     
    $pdf->Cell(25, 6, utf8_decode('Total P. Venta'),1,0, 'C',0);                                     
    $pdf->Cell(25, 6, utf8_decode('Total P. Compra'),1,0, 'C',0);                                     
    $pdf->Cell(20, 6, utf8_decode('Utilidad'),1,0, 'C',0);                                     
    $pdf->Cell(25, 6, utf8_decode('Fecha Pago'),1,0, 'C',0);                                                     
    $pdf->Cell(20, 6, utf8_decode('Tipo Pago'),1,1, 'C',0);                    

    $total=0;
    $sub=0;    
    $contador=0; 
    $pv=0;
    $pc=0;
    $util=0;
    $resultado1 = $class->consulta("SELECT * FROM factura_venta WHERE fecha_actual between '$_GET[inicio]' and '$_GET[fin]' and estado='1'");
    while ($row1 = $class->fetch_array($resultado1)) {
        $pv=0;
        $pc=0;
        $util=0;

        $resultado2 = $class->consulta("SELECT * FROM detalle_factura_venta D, productos P WHERE D.id_producto = P.id AND D.id_factura_venta ='$row1[0]'");
        while ($row2 = $class->fetch_array($resultado2)) {
            $pv=$pv+($row2[3]*$row2[4]);
            $pc=$pc+($row2[3]*$row2[15]);
            $util=$util+(($row2[3]*$row2[4])-($row2[3]*$row2[15]));
        }
        $pdf->SetX(1);
        $pdf->Cell(50, 6, maxCaracter($row1[5],30),0,0, 'C',false);                                     
        $pdf->Cell(40, 6, utf8_decode('Factura'),0,0, 'C',false);                                     
        $pdf->Cell(25, 6, utf8_decode($pv),0,0, 'C',false);                                     
        $pdf->Cell(25, 6, utf8_decode($pc),0,0, 'C',false);                                     
        $pdf->Cell(20, 6, utf8_decode($util),0,0, 'C',false);                                     
        $pdf->Cell(25, 6, utf8_decode($row1[6]),0,0, 'C',false);                                     
        $pdf->Cell(20, 6, utf8_decode($row1[10]),0,1, 'C',false);                                                                     
        $total=$total+$util;                        
    }
    $pdf->Ln(2);
    $pdf->Cell(205, 0, utf8_decode(''),1,1, 'R',0);                                     
    $pdf->Cell(187, 6, utf8_decode('Total Utilidad'),0,0, 'R',0);                                     
    $pdf->Cell(20, 6,(number_format($total,2,',','.')) ,0,0, 'C',0);                                                                                    
    $pdf->Output();
?>