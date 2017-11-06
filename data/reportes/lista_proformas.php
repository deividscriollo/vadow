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
            $this->Cell(150, 5, "LISTA DE PEDIDOS", 0,1, 'R', 0);      
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
            $this->Cell(190, 5, utf8_decode("LISTA DE PEDIDOS"),0,1, 'C',0);                                                                                                                                        
            $this->SetFont('Arial','B',10);                                                                
            $this->Cell(90, 5, utf8_decode("Desde: ".$_GET['inicio']),0,0, 'R',0);                                                                                        
            $this->Cell(40, 5, utf8_decode("Hasta: ".$_GET['fin']),0,1, 'C',0);                                                                                                                
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
    $sub=0;
    $repetido=0;   
    $contador=0; 
    $consulta=pg_query("select id_cliente,identificacion,nombres_cli from clientes");
    while($row=pg_fetch_row($consulta)){
        $repetido=0;
        $total=0;
        $sql1=pg_query("select * from proforma where fecha_actual between '$_GET[inicio]' and '$_GET[fin]' and id_cliente='$row[0]' and estado='Activo'");
        if(pg_num_rows($sql1)){
            if($repetido==0){
                $pdf->SetX(1); 
                $pdf->SetFillColor(187, 179, 180);            
                $pdf->Cell(70, 6, maxCaracter(utf8_decode('RUC/CI:'.$row[1]),35),1,0, 'L',1);                                     
                $pdf->Cell(135, 6, maxCaracter(utf8_decode('NOMBRES:'.$row[2]),50),1,1, 'L',1);                                                             
                $pdf->Ln(2);   
                $pdf->SetX(1); 
                $pdf->Cell(25, 6, utf8_decode('Nro. factura'),1,0, 'C',0);                                     
                $pdf->Cell(30, 6, utf8_decode('Tipo Documento'),1,0, 'C',0);                                     
                $pdf->Cell(20, 6, utf8_decode('Tarifa 0%'),1,0, 'C',0);                                     
                $pdf->Cell(20, 6, utf8_decode('Tarifa IVA'),1,0, 'C',0);                                     
                $pdf->Cell(20, 6, utf8_decode('Iva'),1,0, 'C',0);                                     
                $pdf->Cell(20, 6, utf8_decode('Descuento'),1,0, 'C',0);                                     
                $pdf->Cell(20, 6, utf8_decode('Total'),1,0, 'C',0);                                                     
                $pdf->Cell(25, 6, utf8_decode('Fecha Pago'),1,0, 'C',0);                                     
                $pdf->Cell(25, 6, utf8_decode('Tipo Precio'),1,1, 'C',0);                   
                $repetido=1;
            }            
            while($row1=pg_fetch_row($sql1)){
                $pdf->Cell(25, 6, $row1[0],0,0, 'C',0);                    
                $pdf->Cell(30, 6, 'Factura',0,0, 'C',0);                    
                $pdf->Cell(20, 6, $row1[8],0,0, 'C',0);        
                $pdf->Cell(20, 6, $row1[9],0,0, 'C',0);        
                $pdf->Cell(20, 6, $row1[10],0,0, 'C',0);        
                $pdf->Cell(20, 6, $row1[11],0,0, 'C',0);        
                $pdf->Cell(20, 6, $row1[12],0,0, 'C',0);        
                $pdf->Cell(25, 6, $row1[5],0,0, 'C',0);        
                $pdf->Cell(25, 6, $row1[7],0,1, 'C',0);        
                $total=$total+$row1[12];
            }
            $pdf->SetX(1);                                             
            $pdf->Cell(207, 0, utf8_decode(""),1,1, 'R',0);
            $pdf->Cell(180, 6, utf8_decode("Total"),0,0, 'R',0);
            $pdf->Cell(25, 6, maxCaracter((number_format($total,2,',','.')),20),0,0, 'C',0);                        
            $pdf->Ln(8);                       
            $total=0; 
        }        
    }   
    $pdf->Output();
?>