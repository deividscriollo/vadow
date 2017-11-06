<?php
    include_once('../../fpdf/rotation.php');
    include_once('../../admin/class.php');
    include_once('../../admin/convertir.php');
    include_once('../../admin/funciones_generales.php');
    date_default_timezone_set('America/Guayaquil');
    setlocale (LC_TIME,"spanish");
    session_start();
    $fecha = date('Y-m-d H:i:s', time());  
    $class = new constante();
    $letras = new EnLetras();

class PDF extends PDF_Rotate {
    var $widths;
    var $aligns;

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data) {
        //Calculate the height of the row
        $nb=0;
        for($i=0; $i < count($data); $i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0; $i<count($data); $i++) {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border

            $this->MultiCell( $w,5,$data[$i],0,$a,false);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }
    
    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r", '', $txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep =-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb) {
            $c = $s[$i];
            if($c == "\n") {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ') 
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax) {
                if($sep==-1) {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }  
}

    $pdf = new PDF('L','mm',array(210,170));
    $pdf->AddPage();
    $pdf->SetMargins(0,0,0,0);
    $pdf->SetFont('Arial','',10);	   
    $resultado = $class->consulta("SELECT C.nombres_completos, C.identificacion, C.direccion, C.telefono2, C.ciudad, F.fecha_actual, F.forma_pago, F.tarifa0, F.tarifa, F.iva_venta, F.descuento_venta, F.total_venta, F.estado from factura_venta F, clientes C WHERE F.id_cliente = C.id AND F.id = '$_GET[id]'");    
    while ($row = $class->fetch_array($resultado)) {        
        $pdf->SetFont('Arial','',9);	   
        $pdf->Text(25, 37, utf8_decode('' . strtoupper($row[0])), 0, 'C', 0); ////CLIENTE (X,Y)   
        $pdf->Text(25, 43, utf8_decode('' . strtoupper($row[5])), 0, 'C', 0); ///FECHA (X,Y)  
        $pdf->Text(155, 43, utf8_decode('' . strtoupper($row[1])), 0, 'C', 0); ///RUC CI(X,Y)    
        $pdf->Text(25, 49, utf8_decode('' . strtoupper($row[2])), 0, 'C', 0); ///DIRECCION(X,Y)

        $pdf->Text(200, 143, utf8_decode('' . strtoupper($row[7])), 0, 'C', 0); ////SUBTOTAL (X,Y)    
        $pdf->Text(200, 149, utf8_decode('' . strtoupper($row[8])), 0, 'C', 0); ////IVA12 (X,Y)    
        $pdf->Text(200, 156, utf8_decode('' . strtoupper($row[9])), 0, 'C', 0); ///IVA0 (X,Y)  
        $pdf->Text(200, 162, utf8_decode('' . strtoupper($row[11])), 0, 'C', 0); ///TOTAL(X,Y)              
        $pdf->Ln(1);
    }

    $pdf->SetFont('Arial','',9);	   
    $pdf->SetWidths(array(10, 120, 25, 35,30));//TAMAÑOS DE LA TABLA DE DETALLES PRODUCTOS
    $pdf->SetFillColor(85, 107, 47);
    $resultado = $class->consulta("SELECT D.cantidad, P.codigo, P.descripcion, D.precio, D.total FROM factura_venta F, detalle_factura_venta D, productos P WHERE F.id = D.id_factura_venta AND D.id_producto = P.id AND D.id_factura_venta = '$_GET[id]'");
    
    $total_items = 0;
    $posiciony = 60;
    while ($row = $class->fetch_array($resultado)) {
        $cantidad = $row[0];
        $codigo = $row[1];
        $descripcion = $row[2];
        $valor_unitario = $row[3];
        $total_venta = $row[4];
        $total_items = $total_items + $cantidad;

        $sub1 = (number_format(($total_venta / 1.14) / $cantidad,2,',','.'));
        $sub2 = (number_format(($total_venta / 1.14),2,',','.')); 

        $pdf->SetY($posiciony);
        $pdf->SetX(8);
        $pdf->multiCell(30,6, utf8_decode($cantidad),0);

        $pdf->SetY($posiciony);
        $pdf->SetX(18);
        $pdf->multiCell(75, 6, utf8_decode($codigo.' '.$descripcion),0);

        $pdf->SetY($posiciony);
        $pdf->SetX(137);
        $pdf->multiCell(75, 6, (number_format(($valor_unitario),2,',','.')),0);

        $pdf->SetY($posiciony);
        $pdf->SetX(163);
        $pdf->multiCell(75, 6, utf8_decode($sub1),0);

        $pdf->SetY($posiciony);
        $pdf->SetX(198);
        $pdf->multiCell(75, 6, utf8_decode($sub2),0);

        $posiciony = $posiciony + 5;
    }
    $pdf->Text(22, 135, utf8_decode('Nro. de Items: ' . $total_items ), 0, 'C', 0); ////SUBTOTAL (X,Y) 

    $pdf->Output('factura_dyssa.pdf','I');
?>