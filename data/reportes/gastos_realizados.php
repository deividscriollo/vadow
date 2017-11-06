<?php
    require('../../fpdf/fpdf.php');
    include '../../procesos/base.php';
    include '../../procesos/funciones.php';
    conectarse();    
    date_default_timezone_set('America/Guayaquil'); 
    session_start()   ;
    class PDF extends FPDF{   
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
            $this->Cell(150, 5, "CLIENTE", 0,1, 'R', 0);      
            $this->SetFont('Arial','B',16);                                                    
            $this->Cell(190, 8, "EMPRESA: ".$_SESSION['empresa'], 0,1, 'C',0);                                
            $this->Image('../../images/logo_empresa.jpg',1,8,40,30);
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(180, 5, "PROPIETARIO: ".utf8_decode($_SESSION['propietario']),0,1, 'C',0);                                
            $this->Cell(70, 5, "TEL.: ".utf8_decode($_SESSION['telefono']),0,0, 'R',0);                                
            $this->Cell(60, 5, "CEL.: ".utf8_decode($_SESSION['celular']),0,1, 'C',0);                                
            $this->Cell(170, 5, "DIR.: ".utf8_decode($_SESSION['direccion']),0,1, 'C',0);                                
            $this->Cell(170, 5, "SLOGAN.: ".utf8_decode($_SESSION['slogan']),0,1, 'C',0);                                
            $this->Cell(170, 5, utf8_decode( $_SESSION['pais_ciudad']),0,1, 'C',0);                                                                                                    
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.4);            
            $this->Line(1,45,210,45);            
            $this->SetFont('Arial','B',12);                                                                            
            $this->Cell(190, 5, utf8_decode("REPORTES DE GASTOS "),0,1, 'C',0);                                                                                                                            
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
    
    $total=0;
    $id_fac=0;
    $fecha=0;
    $contador=0; 
    $num_fac=0;
    $valor_pagado=0;
    $sql=pg_query("SELECT DISTINCT(id_factura_venta) FROM gastos where fecha_actual between '$_GET[inicio]' and '$_GET[fin]' order by id_factura_venta asc;");
    while($row=pg_fetch_row($sql)){
        $sql1=pg_query("select id_factura_venta,num_factura,nombres_cli,total_venta,fecha_actual from factura_venta,clientes where factura_venta.id_cliente=clientes.id_cliente and id_factura_venta='$row[0]'");
        while($row1=pg_fetch_row($sql1)){
            $pdf->SetX(1); 
            $pdf->SetFillColor(187, 179, 180);            
            $pdf->Cell(70, 6, maxCaracter(utf8_decode('NRO. FACUTRA:'.$row1[1]),35),1,0, 'L',1);                                     
            $pdf->Cell(135, 6, maxCaracter(utf8_decode('NOMBRES:'.$row1[2]),50),1,1, 'L',1);                                                             
            $pdf->Ln(2);               
            $id_fac=$row1[0];
            $num_fac=$row1[1];
            $total=$row1[3];
            $fecha=$row1[4];
        }
        $sql2=pg_query("SELECT * FROM gastos where fecha_actual between '$_GET[inicio]' and '$_GET[fin]' and id_factura_venta='$id_fac' order by id_factura_venta asc");
        $pdf->SetX(1); 
        $pdf->Cell(25, 6, utf8_decode('Nro. Factura'),1,0, 'C',0);                                     
        $pdf->Cell(25, 6, utf8_decode('Fecha Factura'),1,0, 'C',0);                                     
        $pdf->Cell(30, 6, utf8_decode('Total Venta'),1,0, 'C',0);                                                             
        $pdf->Cell(45, 6, utf8_decode('Descripción'),1,0, 'C',0);                                     
        $pdf->Cell(20, 6, utf8_decode('Fecha Pago'),1,0, 'C',0);                                     
        $pdf->Cell(20, 6, utf8_decode('Valor Pago'),1,0, 'C',0);                                     
        $pdf->Cell(20, 6, utf8_decode('Saldo'),1,0, 'C',0);                                                                                                                                    
        $pdf->Cell(20, 6, utf8_decode('Acumulado'),1,1, 'C',0);                                                                                                                                                
        $valor_pagado=0;
        while($row2=pg_fetch_row($sql2)){
            $pdf->SetX(1); 
            $pdf->Cell(25, 6, substr($num_fac,8,30),0,0, 'C',0);                                     
            $pdf->Cell(25, 6, utf8_decode($fecha),0,0, 'C',0);                                                     
            $pdf->Cell(30, 6, utf8_decode($total),0,0, 'C',0);                                         
            $pdf->Cell(45, 6, maxCaracter(utf8_decode($row2[6]),20),0,0, 'L',0);                                     
            $pdf->Cell(20, 6, utf8_decode($row2[4]),0,0, 'C',0);                                         
            $pdf->Cell(20, 6, utf8_decode($row2[7]),0,0, 'C',0);                                         
            $pdf->Cell(20, 6, utf8_decode($row2[8]),0,0, 'C',0);                                         
            $pdf->Cell(20, 6, utf8_decode($row2[9]),0,1, 'C',0);
            $valor_pagado=$valor_pagado+$row2[7];
        }   
        $pdf->SetX(1);                                             
        $pdf->Cell(207, 0, utf8_decode(""),1,1, 'R',0);
        $pdf->Cell(180, 6, utf8_decode("Utilida por factura"),0,0, 'R',0);
        $pdf->Cell(30, 6, maxCaracter((number_format(($total - $valor_pagado),2,',','.')),20),0,1, 'C',0);                                                    
        $pdf->Ln(3);                                               
    }
    $pdf->Output();
?>