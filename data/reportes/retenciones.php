<?php
    require('../../fpdf/fpdf.php');
    include_once('../../admin/class.php');
    include_once('../../admin/funciones_generales.php');
    $class = new constante();   
    date_default_timezone_set('America/Guayaquil'); 
    session_start();

    $anio = date('Y', time());
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
            //$this->Cell(20, 5, $fecha, 0,0, 'C', 0);                                                                                               
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.4);
        }
        function Footer(){            
            $this->SetY(-15);            
            $this->SetFont('Arial','I',8);            
            //$this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');
        }               
    }
    //$pdf = new PDF('P','cm','Legal');
    $pdf = new PDF('L','mm',array(200,145));
    //$pdf = new PDF('L','mm','a5');
    $pdf->AddPage();
    $pdf->SetMargins(0,0,0,0);
    $pdf->AliasNbPages();
    $pdf->AddFont('Amble-Regular','','Amble-Regular.php');
    $pdf->SetFont('Amble-Regular','',10);       
    $pdf->SetFont('Arial','',9);   
    $pdf->SetX(10); 
    $pdf->SetY(44); 
    $resultado = $class->consulta("select p.empresa, rf.fecha_actual, p.identificacion, fc.serie, p.direccion, fc.autorizacion from retencion_fuente_compra rf, proveedores p, factura_compra fc where fc.id = rf.id_factura_compra and fc.id_proveedor = p.id and fc.id='$_GET[id]'");   
    while ($row = $class->fetch_array($resultado)) {                
        $pdf->SetX(27);                  
        $pdf->Cell(130, 1, maxCaracter(utf8_decode($row[1]),15),0,0, 'L',0); //fecha
		$pdf->Ln(5);  
        $pdf->SetX(27); 
		$pdf->Cell(130, 5, maxCaracter(utf8_decode($row[0]),50),0,0, 'L',0);  //PROVEEDOR
		$pdf->Cell(100, 5, maxCaracter(utf8_decode("FACTURA"),20),0,0, 'L',0); //TIPO DE COMPROBANTE 
		$r=substr($row[3],0,7);  
        $pdf->Ln(5);  
        $pdf->SetX(32);
		$pdf->Cell(75, 5, maxCaracter(utf8_decode($row[2]),20),0,0, 'L',0);   //RUC
		$pdf->Cell(50, 5, maxCaracter(utf8_decode("2017"),20),0,0, 'L',0); //EJERCICIO FISCAL
		$pdf->Cell(12, 5, maxCaracter(utf8_decode($r),20),0,0, 'L',0);     // SERIE
		//$pdf->Cell(125, 5, maxCaracter(utf8_decode($row[4]),20),0,0, 'L',0);  //  DIRECCION
        $r=substr($row[3],8,9);  
        $pdf->Cell(20, 5, maxCaracter(utf8_decode($r),20),0,0, 'L',0); //NUMERO DE FACTURA
        //$pdf->Ln(6);  
        //$pdf->SetX(32);
        //$pdf->Cell(40, 5, maxCaracter(utf8_decode($row[5]),20),0,0, 'L',0);    
        //$pdf->Cell(20, 5, maxCaracter(utf8_decode($anio+1),20),0,0, 'L',0);                               
        //$pdf->Ln(5);                                                                
    }  
    $pdf->SetFont('Amble-Regular','',12); 
    $total = 0;      
    $fuente=0;
    $iva=0;
    $pdf->SetY(80);
    $resultado = $class->consulta("select rf.id_retencion_fuente, rf.fecha_actual, rf.valor_factura, rf.iva_compra, rf.valor_retencion, r.valor, r.codigo_formulario from retencion_fuente_compra rf, retencion_fuente r, factura_compra fc where fc.id = rf.id_factura_compra and r.id = rf.id_retencion_fuente and fc.id = '$_GET[id]'");   
    while ($row = $class->fetch_array($resultado)) {                
        $pdf->SetX(12);                  
        $pdf->Cell(50, 5, maxCaracter(utf8_decode("Compra"),20),0,0, 'C',0);  //CONCEPTO
		//$pdf->Cell(30, 5, maxCaracter(utf8_decode($anio),20),0,0, 'C',0);
        $pdf->Cell(30, 5, maxCaracter(utf8_decode(number_format($row[2],2,'.','')),25),0,0, 'C',0); //BASE
        $pdf->Cell(30, 5, maxCaracter(utf8_decode("Renta"),20),0,0, 'C',0);  //    IMPUESTO  
        $pdf->Cell(30, 5, maxCaracter(utf8_decode($row[6]),20),0,0, 'C',0);  //  CODIGO
        $pdf->Cell(20, 5, maxCaracter(utf8_decode($row[5]),20),0,0, 'C',0);  //   PORCENTAJE
        $pdf->Cell(15, 5, maxCaracter(utf8_decode($row[4]),20),0,0, 'C',0);  //    VALOR RETENIDO
        $fuente=$row[4];                                  
        $pdf->Ln(5);                                                                
    }
    $resultado = $class->consulta("select ri.id_retencion_iva, ri.fecha_actual, ri.valor_factura, ri.iva_factura, ri.valor_retencion, r.valor, r.codigo_formulario from retencion_iva_compra ri, retencion_iva r, factura_compra fc where fc.id = ri.id_factura_compra and r.id=ri.id_retencion_iva and fc.id='$_GET[id]'");   
    while ($row = $class->fetch_array($resultado)) {                
        $pdf->SetX(12);                  
        $pdf->Cell(50, 5, maxCaracter(utf8_decode("Compra"),20),0,0, 'C',0);
        $pdf->Cell(30, 5, maxCaracter(utf8_decode($row[3]),25),0,0, 'C',0);
        $pdf->Cell(30, 5, maxCaracter(utf8_decode("IVA"),20),0,0, 'C',0);        
        $pdf->Cell(30, 5, maxCaracter(utf8_decode($row[6]),20),0,0, 'C',0);    
        $pdf->Cell(20, 5, maxCaracter(utf8_decode($row[5]),20),0,0, 'C',0);  
        $pdf->Cell(15, 5, maxCaracter(utf8_decode($row[4]),20),0,0, 'C',0);  
        $iva=$row[4];                                    
        $pdf->Ln(26);                                                                
    }
    $pdf->SetY(113);
    $pdf->SetX(164); // TOTAL DE LA RETENCION      
    $pdf->Cell(30, 10, maxCaracter(utf8_decode(number_format($fuente+$iva,2,'.','')),20),0,0, 'C',0);             
    $pdf->Ln(5);   
    /*$sql=pg_query("select factura_compra.descuento_compra,factura_compra.tarifa0,factura_compra.tarifa12,factura_compra.iva_compra,factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='10' LIMIT 1");    
    while($row=pg_fetch_row($sql)){
        $pdf->Cell(173, 6, utf8_decode("Descuento"),0,0, 'R',0);
        $pdf->Cell(35, 6, number_format(round($row[0],2),2,'.',''),0,1, 'C',0);
        $pdf->Cell(173, 6, utf8_decode("Tarifa 0"),0,0, 'R',0);
        $pdf->Cell(35, 6, number_format(round($row[1],2),2,'.',''),0,1, 'C',0);
        $pdf->Cell(173, 6, utf8_decode("Tarifa IVA"),0,0, 'R',0);
        $pdf->Cell(35, 6, number_format(round($row[2],2),2,'.',''),0,1, 'C',0);
        $pdf->Cell(173, 6, utf8_decode("Iva ...%"),0,0, 'R',0);
        $pdf->Cell(35, 6, number_format(round($row[3],2),2,'.',''),0,1, 'C',0);
        $pdf->Cell(173, 6, utf8_decode("Total"),0,0, 'R',0);
        $pdf->Cell(35, 6, number_format(round($row[4],2),2,'.',''),0,1, 'C',0);
    }*/
    //////////
    $pdf->Output();
?>
