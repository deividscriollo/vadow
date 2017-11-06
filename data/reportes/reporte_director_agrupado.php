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
            $this->Cell(150, 5, "DIRECTOR AGRUPADO POR EMPRESARIO", 0,1, 'R', 0);      
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

            $this->SetX(1);                                                                             
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.5);
            $this->SetFillColor(120,120,120);
            $this->Line(1,50,210,50);            
            $this->SetFont('Arial','B',12);                                                                
            $this->Cell(190, 5, utf8_decode("REPORTE DE DIRECTOR AGRUPADO POR EMPRESARIO"),0,1, 'C',0);                                                                                                                
            $this->SetFont('Arial','B',10);                                                                            
            $this->Cell(90, 5, utf8_decode($_GET['inicio']),0,0, 'R',0);                                                                                        
            $this->Cell(40, 5, utf8_decode($_GET['fin']),0,1, 'C',0);                                      
            $this->SetFont('Amble-Regular','',10);                                                                      
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
    
    $resultado = $class->consulta("SELECT id, identificacion,nombres_completos, direccion, telefono1, telefono2 FROM directores WHERE id = '$_GET[id]'");
    while ($row = $class->fetch_array($resultado)) {
        $pdf->SetX(1); 
        $pdf->SetFillColor(187, 179, 180);            
        $pdf->Cell(25, 6, maxCaracter(utf8_decode('RUC/CI:'),15),1,0, 'L',0);
        $pdf->Cell(60, 6, maxCaracter(utf8_decode($row[1]),15),1,0, 'L',0);
        $pdf->Cell(25, 6, maxCaracter(utf8_decode('DIRECTOR'),15),1,0, 'L',0);
        $pdf->Cell(95, 6, maxCaracter(utf8_decode($row[2]),50),1,1, 'L',0);
        $pdf->SetX(1); 
        $pdf->Cell(25, 6, maxCaracter(utf8_decode('TELF:'),15),1,0, 'L',0);
        $pdf->Cell(60, 6, maxCaracter(utf8_decode($row[4].'-'.$row[5]),20),1,0, 'L',0);
        $pdf->Cell(25, 6, maxCaracter(utf8_decode('DIRECCIÓN:'),15),1,0, 'L',0);
        $pdf->Cell(95, 6, maxCaracter(utf8_decode($row[3]),50),1,1, 'L',0);
    }

    $pdf->Ln(3);    
    $pdf->SetX(1);                
    $resultado = $class->consulta("SELECT C.id, C.identificacion, C.nombres_completos FROM clientes C, asignacion_clientes_directores A WHERE A.id_cliente = C.id AND A.id_director = '$_GET[id]' ORDER BY C.id asc");
    $cont1 = 0;
    $cont2 = 0;
    $cant = 0;
    $valor_uni = 0;
    $valor_tot = 0;
    $desc_tot = 0;
    $total_final = 0;
    $temp2 = 0;
    while ($row = $class->fetch_array($resultado)) {                
        $temp = 0;
        $desc = 0;
        $cant = 0;
        $valor_uni = 0;
        $valor_tot = 0;
        $desc_tot = 0;
         $resultado1 = $class->consulta("SELECT P.id, P.codigo, P.descripcion, P.id_categoria, P.id_marca, sum(cantidad::int), V.precio_venta, V.total_venta FROM factura_venta F, clientes C, directores D, detalle_factura_venta V, productos P, asignacion_clientes_directores A WHERE A.id_director = D.id AND F.id_cliente = C.id AND V.id_factura_venta = F.id AND V.id_producto = P.id AND D.id = '".$_GET['id']."' AND C.id = '".$row[0]."' AND  F.fecha_actual between '".$_GET['inicio']."' AND '".$_GET['fin']."' group by  P.id, V.precio_venta, V.total_venta, P.codigo, P.descripcion, P.id_categoria, P.id_marca");
        if($class->num_rows($resultado1)){
            $pdf->SetX(1);                
            $pdf->Cell(25, 6, utf8_decode("EMPRESARI@"),1,0, 'C',1);
            $pdf->Cell(60, 6, maxCaracter(utf8_decode($row[2]),50),1,0, 'L',1);
            $pdf->Cell(20, 6, utf8_decode("CI/RUC"),1,0, 'C',1);        
            $pdf->Cell(40, 6, maxCaracter(utf8_decode($row[1]),15),1,0, 'L',1);                            
            $pdf->Cell(40, 6, utf8_decode("COSTO PVP"),1,0, 'C',1);        
            $pdf->Cell(20, 6, utf8_decode("DESCUENTO"),1,1, 'L',1); 
            $pdf->SetX(1);  
            $pdf->Cell(25, 6, utf8_decode("COD"),1,0, 'C',0);       
            $pdf->Cell(60, 6, utf8_decode("DESCRIPCIÓN"),1,0, 'C',0);       
            $pdf->Cell(20, 6, utf8_decode("CATEGORÍA"),1,0, 'C',0);       
            $pdf->Cell(20, 6, utf8_decode("MARCA"),1,0, 'C',0);       
            $pdf->Cell(20, 6, utf8_decode("CANT"),1,0, 'C',0);       
            $pdf->Cell(20, 6, utf8_decode("VALOR UNI"),1,0, 'C',0);       
            $pdf->Cell(20, 6, utf8_decode("VALOR TOT"),1,0, 'C',0);       
            $pdf->Cell(20, 6, utf8_decode("30%"),1,1, 'C',0);      

            while ($row1 = $class->fetch_array($resultado1)) {       
                $temp = $row1[0];
                $desc = 0;
                $pdf->SetX(1);  
                $pdf->Cell(25, 6, maxCaracter(utf8_decode($row1[1]),15),0,0, 'L',0);
                $pdf->Cell(60, 6, maxCaracter(utf8_decode($row1[2]),30),0,0, 'L',0);
                $pdf->Cell(20, 6, maxCaracter(utf8_decode($row1[3]),10),0,0, 'L',0);
                $pdf->Cell(20, 6, maxCaracter(utf8_decode($row1[4]),10),0,0, 'L',0);
                $pdf->Cell(20, 6, maxCaracter(utf8_decode($row1[5]),50),0,0, 'C',0);
                $pdf->Cell(20, 6, maxCaracter(utf8_decode($row1[6]),50),0,0, 'C',0);
                $pdf->Cell(20, 6, maxCaracter(utf8_decode($row1[6] * $row1[5]),50),0,0, 'C',0);
                $desc = ($row1[6] * $row1[5]) * 0.30;
                $desc = ($row1[6] * $row1[5]) - $desc;
                $pdf->Cell(20, 6, maxCaracter(number_format($desc,3,',','.'),10),0,1, 'C',0);
                $cant = $cant + $row1[5];
                $valor_uni = $valor_uni + $row1[6];
                $valor_tot = $valor_tot + ($row1[6] * $row1[5]);
                $desc_tot = $desc_tot + $desc;
                $total_final = $total_final + $desc;
            }         
            $pdf->SetX(1);                                             
            $pdf->Cell(205, 0, utf8_decode(""),1,1, 'R',0);
            $pdf->Cell(126, 6, utf8_decode("Totales"),0,0, 'R',0);
            $pdf->Cell(20, 6, maxCaracter((number_format($cant,2,',','.')),20),0,0, 'C',0);
            $pdf->Cell(20, 6, maxCaracter((number_format($valor_uni,2,',','.')),20),0,0, 'C',0);
            $pdf->Cell(20, 6, maxCaracter((number_format($valor_tot,2,',','.')),20),0,0, 'C',0);
            $pdf->Cell(20, 6, maxCaracter((number_format($desc_tot,2,',','.')),20),0,1, 'C',0);
            $pdf->Ln(3);
        }        
    }
    $pdf->SetX(1);                                             
    $pdf->Ln(5);              
    $pdf->Cell(207, 0, utf8_decode(""),1,1, 'R',0);
    $pdf->Cell(207, 6, utf8_decode("RESUMEN DE PEDIDOS"),0,1, 'R',0);

    $pdf->Cell(127, 6, utf8_decode("TOTAL EN PEDIDOS DE EMPRESARIAS"),0,0, 'R',0);
    $pdf->Cell(40, 6, utf8_decode("YA DESC. SU 30%"),1,0, 'C',0);
    $pdf->Cell(40, 6, number_format($total_final,2,',','.'),1,1, 'C',0);

    $pdf->Cell(127, 6, utf8_decode("DESCUENTO LIDER"),0,0, 'R',0);
    $pdf->Cell(40, 6, utf8_decode("10%"),1,0, 'C',0);
    $pdf->Cell(40, 6, utf8_decode($total_final * 0.10),1,1, 'C',0);

    $pdf->Cell(127, 6, utf8_decode("SUBTOTAL"),0,0, 'R',0);
    $pdf->Cell(40, 6, utf8_decode(""),1,0, 'C',0);
    $pdf->Cell(40, 6, $total_final -($total_final * 0.10),1,1, 'C',0);    
    
    $pdf->Cell(127, 6, utf8_decode("COST0 ENVIO"),0,0, 'R',0);
    $pdf->Cell(40, 6, utf8_decode(""),1,0, 'C',0);
    $pdf->Cell(40, 6, utf8_decode(""),1,1, 'C',0);

    $pdf->Cell(127, 6, utf8_decode("TOTAL A DEPOSITAR"),0,0, 'R',0);
    $pdf->Cell(40, 6, '',1,0, 'C',0);
    $pdf->Cell(40, 6, $total_final -($total_final * 0.10),1,1, 'C',0);
                                                        
    $pdf->Ln(3);              
    $pdf->Output();
?>