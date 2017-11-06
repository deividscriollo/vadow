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
            $this->Line(1,46,210,46);            
            $this->SetFont('Arial','B',12);                                                                            
            $this->Cell(190, 5, utf8_decode("INVENTARIO "),0,1, 'C',0);                                                                                                                            
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
    
    $sql = pg_query("select  I.comprobante, I.fecha_actual, I.hora_actual, U.nombre_usuario, U.apellido_usuario  from inventario I, usuario U where I.id_usuario = U.id_usuario and I.id_inventario='$_GET[id]'");
    while ($row = pg_fetch_row($sql)) {
        $pdf->SetX(1);                                                
        $pdf->Cell(50, 6, utf8_decode('Comprobante: '),0,0, 'C',0);                                         
        $pdf->Cell(55, 6, utf8_decode($row[0]),0,0, 'L',0);                                     
        $pdf->Cell(50, 6, utf8_decode('Fecha: '),0,0, 'C',0);                                         
        $pdf->Cell(50, 6, utf8_decode($row[1]),0,1, 'L',0);                                     
        $pdf->SetX(1);                                                
        $pdf->Cell(50, 6, utf8_decode('Hora:'),0,0, 'C',0);                                         
        $pdf->Cell(55, 6, utf8_decode($row[2]),0,0, 'L',0);                                     
        $pdf->Cell(50, 6, utf8_decode('Usuario:'),0,0, 'C',0);                                         
        $pdf->Cell(50, 6, utf8_decode($row[3]),0,1, 'L',0);                                             
        $pdf->Ln(3);
    }
    $sql2 = pg_query("select D.cod_productos, P.codigo, P.articulo, D.p_costo, D.p_venta, D.disponibles, D.existencia, D.diferencia from inventario I, detalle_inventario D, productos P where D.cod_productos = P.cod_productos and I.id_inventario = D.id_inventario and D.id_inventario='$_GET[id]'");
    $pdf->SetX(1);
    $pdf->Cell(30, 6, utf8_decode('Código'),1,0, 'C',0);                                         
    $pdf->Cell(55, 6, utf8_decode('Producto'),1,0, 'C',0);                                         
    $pdf->Cell(25, 6, utf8_decode('Precio Costo'),1,0, 'C',0);                                         
    $pdf->Cell(25, 6, utf8_decode('Precio Venta'),1,0, 'C',0);                                         
    $pdf->Cell(20, 6, utf8_decode('Stock'),1,0, 'C',0);                                         
    $pdf->Cell(25, 6, utf8_decode('Existencia'),1,0, 'C',0);                                         
    $pdf->Cell(25, 6, utf8_decode('Diferencia'),1,1, 'C',0);                                             
    $total1 = 0;
    $total2 = 0;
    while ($row = pg_fetch_row($sql2)) {
        $pdf->SetX(1);
        $total1 = $total1 + $row[3];
        $total2 = $total2 + $row[4];
        $pdf->Cell(30, 6, maxCaracter(utf8_decode($row[1]),15),0,0, 'C',0);                                             
        $pdf->Cell(55, 6, maxCaracter(utf8_decode($row[2]),30),0,0, 'L',0);                                             
        $pdf->Cell(25, 6, utf8_decode($row[3]),0,0, 'C',0);                                             
        $pdf->Cell(25, 6, utf8_decode($row[4]),0,0, 'C',0);                                             
        $pdf->Cell(20, 6, utf8_decode($row[5]),0,0, 'C',0);                                             
        $pdf->Cell(25, 6, utf8_decode($row[6]),0,0, 'C',0);                                             
        $pdf->Cell(25, 6, utf8_decode($row[7]),0,1, 'C',0);                                                     
    }
    $pdf->SetX(1);
    $pdf->Cell(205, 0, utf8_decode(''),1,1, 'R',1);                                     
    $pdf->Cell(86, 6, utf8_decode('Totales:'),0,0, 'R',0);                                     
    $pdf->Cell(25, 6,(number_format($total1,2,',','.')) ,0,0, 'C',0);                                                                                         
    $pdf->Cell(25, 6,(number_format($total2,2,',','.')) ,0,1, 'C',0);                                                                                         
    $pdf->Output();
?>