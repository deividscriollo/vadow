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
        var $temp1;
        var $temp2;
        var $temp3;
        var $temp4;
        var $temp5;
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
            $this->SetFillColor(120,120,120);
            $this->Line(1,75,210,75);            
            $this->Line(1,45,210,45);            
            $this->SetFont('Arial','B',12);                                                                
            $this->Cell(190, 5, utf8_decode("DEVOLUCIÓN COMPRA"),0,1, 'C',0);                                                                                                                
            $this->SetFont('Amble-Regular','',10);        
            $this->Ln(6);
            $this->SetFillColor(255,255,225);
            $sql=pg_query("select * from devolucion_compra,proveedores,usuario,empresa where devolucion_compra.id_proveedor=proveedores.id_proveedor and devolucion_compra.id_usuario=usuario.id_usuario and devolucion_compra.id_empresa=empresa.id_empresa and id_devolucion_compra='$_GET[id]'");
            $this->SetLineWidth(0.2);
            while($row=pg_fetch_row($sql)){                                                                                    
                $this->SetX(1);                                  
                $this->Cell(100, 6, utf8_decode('CI/Ruc: '.$row[19]),0,0, 'L',1);                
                $this->Cell(105, 6, utf8_decode('Proveedor: '.$row[20]),0,1, 'L',1);                
                $this->SetX(1);                                  
                $this->Cell(100, 6, utf8_decode('Representante: '.$row[21]),0,0, 'L',1);                
                $this->Cell(105, 6, utf8_decode('Dirección: '.$row[23]),0,1, 'L',1);                
                $this->SetX(1);                                  
                $this->Cell(205, 6, utf8_decode('Dirección: '.$row[39]),0,1, 'L',1);                
                $this->SetX(1);                                                  
                $this->Cell(100, 6, utf8_decode('Celular: '.$row[25]),0,0, 'L',1);                                                
                $this->Cell(105, 6, utf8_decode('Responsable: '.$row[35].' '.$row[36]),0,0, 'L',1);                         
                $this->temp1 = $row[10];                
                $this->temp2 = $row[11];
                $this->temp3 = $row[12];
                $this->temp4 = $row[13];
                $this->temp5 = $row[14];                
            }            
            $this->Ln(8);                        
            $this->SetX(1);
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(40, 5, utf8_decode("Código"),1,0, 'C',0);
            $this->Cell(80, 5, utf8_decode("Producto"),1,0, 'C',0);
            $this->Cell(20, 5, utf8_decode("Cantidad"),1,0, 'C',0);
            $this->Cell(20, 5, utf8_decode("PVP"),1,0, 'C',0);
            $this->Cell(20, 5, utf8_decode("Descuento"),1,0, 'C',0);        
            $this->Cell(25, 5, utf8_decode("Total"),1,1, 'C',0);                
            $this->Ln(1);                
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
    $temp1 = $pdf->temp1;
    $temp2 = $pdf->temp2;
    $temp3 = $pdf->temp3;
    $temp4 = $pdf->temp4;
    $temp5 = $pdf->temp5;    
    $sql=pg_query("select * from detalle_devolucion_compra,productos where detalle_devolucion_compra.cod_productos=productos.cod_productos and id_devolucion_compra='$_GET[id]' order by id_devolucion_compra asc;");
    while($row=pg_fetch_row($sql)){                
        $pdf->SetX(1);                  
        $pdf->Cell(40, 5, maxCaracter(utf8_decode($row[9]),20),0,0, 'L',0);
        $pdf->Cell(80, 5, maxCaracter(utf8_decode($row[11]),20),0,0, 'L',0);
        $pdf->Cell(20, 5, maxCaracter(utf8_decode($row[3]),80),0,0, 'C',0);
        $pdf->Cell(20, 5, maxCaracter(utf8_decode($row[4]),20),0,0, 'C',0);        
        $pdf->Cell(20, 5, maxCaracter(utf8_decode($row[5]),20),0,0, 'C',0);                                     
        $pdf->Cell(25, 5, maxCaracter(utf8_decode($row[6]),20),0,0, 'C',0);                                     
        $pdf->Ln(5);                                                                
    }
    $pdf->SetX(1);                  
    $pdf->Ln(5);   
    $sql=pg_query("select factura_compra.descuento_compra,factura_compra.tarifa0,factura_compra.tarifa12,factura_compra.iva_compra,factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");    
    while($row=pg_fetch_row($sql)){        
        $pdf->Cell(173, 6, utf8_decode("Tarifa 0"),0,0, 'R',0);
        $pdf->Cell(35, 6, maxCaracter(utf8_decode($temp1),20),0,1, 'C',0);
        $pdf->Cell(173, 6, utf8_decode("Tarifa IVA"),0,0, 'R',0);
        $pdf->Cell(35, 6, maxCaracter(utf8_decode($temp2),20),0,1, 'C',0);
        $pdf->Cell(173, 6, utf8_decode("Iva ...%"),0,0, 'R',0);
        $pdf->Cell(35, 6, maxCaracter(utf8_decode($temp3),20),0,1, 'C',0);
        $pdf->Cell(173, 6, utf8_decode("Descuento"),0,0, 'R',0);
        $pdf->Cell(35, 6, maxCaracter(utf8_decode($temp4),20),0,1, 'C',0);
        $pdf->Cell(173, 6, utf8_decode("Total"),0,0, 'R',0);
        $pdf->Cell(35, 6, maxCaracter(utf8_decode($temp5),20),0,1, 'C',0);
    } 
    $pdf->Output();
?>