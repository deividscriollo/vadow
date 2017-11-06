<?php
    require('../../fpdf/fpdf.php');
    include_once('../../admin/class.php');
    include_once('../../admin/funciones_generales.php');
    $class = new constante();   
    date_default_timezone_set('America/Guayaquil'); 
    session_start();

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
            // $this->Cell(190, 8, "EMPRESA: ".$_SESSION['empresa'], 0,1, 'C',0);                                
            // $this->Image('../../images/logo_empresa.jpg',1,8,40,30);
            // $this->SetFont('Amble-Regular','',10);        
            // $this->Cell(180, 5, "PROPIETARIO: ".utf8_decode($_SESSION['propietario']),0,1, 'C',0);                                
            // $this->Cell(70, 5, "TEL.: ".utf8_decode($_SESSION['telefono']),0,0, 'R',0);                                
            // $this->Cell(60, 5, "CEL.: ".utf8_decode($_SESSION['celular']),0,1, 'C',0);                                
            // $this->Cell(170, 5, "DIR.: ".utf8_decode($_SESSION['direccion']),0,1, 'C',0);                                
            // $this->Cell(170, 5, "SLOGAN.: ".utf8_decode($_SESSION['slogan']),0,1, 'C',0);                                
            // $this->Cell(170, 5, utf8_decode( $_SESSION['pais_ciudad']),0,1, 'C',0);                                                                                                    
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.4);            
            $this->Line(1,50,210,50);            
            $this->SetFont('Arial','B',12);                                                                
            $this->Cell(90, 5, utf8_decode($_GET['inicio']),0,0, 'R',0);                                                                                        
            $this->Cell(40, 5, utf8_decode($_GET['fin']),0,1, 'C',0);                                                                                                    
            $this->Cell(190, 5, utf8_decode("DIARIO DE CAJA"),0,1, 'C',0);                                                                                                                            
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
    $pdf->SetX(1);                       
    $total=0;
    $contado=0;
    $credito=0;
    $cheque=0;
    $gastos=0;
    $cxc=0;
    $sql=pg_query("SELECT sum(total_venta::float) FROM factura_venta where fecha_actual between '$_GET[inicio]' and '$_GET[fin]' and forma_pago='Contado'");
    while($row=pg_fetch_row($sql)){
        $contado=$row[0];
    }
    $sql=pg_query("SELECT sum(total_venta::float) FROM factura_venta where fecha_actual between '$_GET[inicio]' and '$_GET[fin]' and forma_pago='Credito'");
    while($row=pg_fetch_row($sql)){
        $credito=$row[0];
    }
    $sql=pg_query("SELECT sum(total_venta::float) FROM factura_venta where fecha_actual between '$_GET[inicio]' and '$_GET[fin]' and forma_pago='Cheque'");
    while($row=pg_fetch_row($sql)){
        $cheque=$row[0];
    }
    $sql=pg_query("select sum(total::float) from gastos_internos where fecha_actual between '$_GET[inicio]' and '$_GET[fin]'");
    while($row=pg_fetch_row($sql)){
        $gastos=$row[0];
    }
    $sql=pg_query("select sum(valor_pagado::float) from pagos_cobrar where fecha_actual between '$_GET[inicio]' and '$_GET[fin]'");
    while($row=pg_fetch_row($sql)){
        $cxc=$row[0];
    }
    $pdf->SetX(10);   
    $pdf->Cell(170, 6, "INGRESOS",0,0, 'L',0);                                     
    $pdf->Cell(20, 6, "TOTAL",0,1, 'C',0);       
    
    $pdf->SetX(10);
    $pdf->Cell(170, 6, "Ventas Efectivo",0,0, 'L',0);                                     
    $pdf->Cell(20, 6, $contado,0,1, 'C',0);                                                                      

    $pdf->SetX(10);
    $pdf->Cell(170, 6, utf8_decode("Ventas Crédito"),0,0, 'L',0);                                     
    $pdf->Cell(20, 6, $credito,0,1, 'C',0);                                                                      
    
    $pdf->SetX(10);
    $pdf->Cell(170, 6, "Ventas Cheque",0,0, 'L',0);                                     
    $pdf->Cell(20, 6, $cheque,0,1, 'C',0);                                                                          
    
    $pdf->SetX(10);
    $pdf->Cell(170, 6, "Cuentas Cobrar",0,0, 'L',0);                                     
    $pdf->Cell(20, 6, $cxc,0,1, 'C',0);                                                                      
    $pdf->Ln(5);
    $pdf->SetX(10);
    $pdf->Cell(170, 6, "GASTOS",0,0, 'L',0);                                     
    $pdf->Cell(20, 6, $gastos,0,1, 'C',0);                                                                      

    $pdf->SetX(10);
    $pdf->Cell(170, 6, "RESULTADOS VENTAS",0,0, 'L',0);                                     
    $pdf->Cell(20, 6, ($contado + $cheque + $credito + $cxc),0,1, 'C',0);                                                                      
    
    $pdf->SetX(10);
    $pdf->Cell(170, 6, "TOTAL DINEO EN CAJA",0,0, 'L',0);                                     
    $pdf->Cell(20, 6, (($contado + $cxc ) - $gastos),0,1, 'C',0);                                                                                               

    $pdf->Ln(6);                                                  
    $pdf->Output();
?>