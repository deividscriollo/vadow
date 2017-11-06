<?php

date_default_timezone_set('America/Guayaquil');
require_once "PHPExcel.php";

//VARIABLES DE PHP
$objPHPExcel = new PHPExcel();
$Archivo = "resumen_compras_general.xls";

include '../procesos/base.php';
include '../procesos/funciones.php';
session_start();
conectarse();

// Propiedades de archivo Excel
$objPHPExcel->getProperties()->setCreator("P&S Systems")
        ->setLastModifiedBy("P&S Systems")
        ->setTitle("Reporte XLS")
        ->setSubject("RESUMEN DE FACTURAS COMPRAS GENERAL")
        ->setDescription("")
        ->setKeywords("")
        ->setCategory("");


//PROPIEDADES DEL  LA CELDA
$objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);

//////////////////////CABECERA DE LA CONSULTA
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("B2", 'RESUMEN DE FACTURAS COMPRAS GENERAL');
$objPHPExcel->getActiveSheet()
        ->getStyle('B2:L2')->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('B2:L2');

$objPHPExcel->getActiveSheet()
        ->getStyle("B2:L2")
        ->getFont()
        ->setBold(true)
        ->setName('Verdana')
        ->setSize(18);
//////////////////////////
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("B4", 'Empresa: ' . $_SESSION['empresa'] . '');
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('B4:C4');

$objPHPExcel->getActiveSheet()
        ->getStyle("B4:C4")
        ->getFont()
        ->setBold(false)
        ->setName('Verdana')
        ->setSize(10);
//////////////////////////
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("D4", 'Propietario: ' . $_SESSION['propietario'] . '');
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('D4:E4');

$objPHPExcel->getActiveSheet()
        ->getStyle("D4:E4")
        ->getFont()
        ->setBold(false)
        ->setName('Verdana')
        ->setSize(10);
/////////////////////////
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("B5", 'Desde:');
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('B5:B5');

$objPHPExcel->getActiveSheet()
        ->getStyle("B5:B5")
        ->getFont()
        ->setBold(false)
        ->setName('Verdana')
        ->setSize(10);
//////////////////////////
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("C5", $_GET['inicio']);
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('C5:C5');

$objPHPExcel->getActiveSheet()
        ->getStyle("C5:C5")
        ->getFont()
        ->setBold(false)
        ->setName('Verdana')
        ->setSize(10);
//////////////////////////
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("G5", 'HASTA:');
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('G5:G5');

$objPHPExcel->getActiveSheet()
        ->getStyle("G5:G5")
        ->getFont()
        ->setBold(false)
        ->setName('Verdana')
        ->setSize(10);
//////////////////////////
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("H5", $_GET['fin']);
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('H5:H5');

$objPHPExcel->getActiveSheet()
        ->getStyle("H5:H5")
        ->getFont()
        ->setBold(false)
        ->setName('Verdana')
        ->setSize(10);
//////////////////////////
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('PHPExcel logo');
$objDrawing->setDescription('PHPExcel logo');
$objDrawing->setPath('../images/logo_empresa.jpg');       // 
$objDrawing->setWidth(160);                 // sets the image 
$objDrawing->setHeight(60);
$objDrawing->setCoordinates('L2');    // pins the top-left corner 
$objDrawing->setOffsetX(10);                // pins the top left 
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//////////////////////////////////////////////////////////
$styleArray = array(
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
        ),
    ),
);
$objPHPExcel->getActiveSheet()->getStyle('B6:N6')->applyFromArray($styleArray);
unset($styleArray);
//////////////////////////////////////////////////////////
$total = 0;
$sub = 0;
$desc = 0;
$ivaT = 0;
$repetido = 0;
$y = 7;

    $consulta1 = pg_query("select num_serie,fecha_actual,hora_actual,fecha_cancelacion,num_autorizacion,factura_compra.forma_pago,tarifa0,tarifa12,iva_compra,descuento_compra,total_compra,empresa_pro,identificacion_pro,representante_legal,id_factura_compra from factura_compra,proveedores where factura_compra.id_proveedor=proveedores.id_proveedor and fecha_actual between '$_GET[inicio]' and '$_GET[fin]' order by factura_compra.id_factura_compra");
    $contador = pg_num_rows($consulta1);
    if ($contador > 0) {
        while ($row1 = pg_fetch_row($consulta1)) {
            if ($repetido == 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("B" . $y, 'Comprobante')
                        ->setCellValue("C" . $y, 'Identificación')
                        ->setCellValue("D" . $y, 'Proveedor')
                        ->setCellValue("E" . $y, 'Fecha')
                        ->setCellValue("F" . $y, 'Nro Factura')
                        ->setCellValue("G" . $y, 'Subtotal')
                        ->setCellValue("H" . $y, 'Descuento')
                        ->setCellValue("I" . $y, 'Tarifa 0%')
                        ->setCellValue("J" . $y, 'Tarifa 12%')
                        ->setCellValue("K" . $y, 'Iva 12%')
                        ->setCellValue("L" . $y, 'Total')
                        ->setCellValue("M" . $y, 'Fecha Pago')
                        ->setCellValue("N" . $y, 'Tipo Pago');
                $objPHPExcel->getActiveSheet()->getStyle("B" . $y . ":L" . $y)->getFont()->setBold(true)->setName('Verdana')->setSize(10);
                $objPHPExcel->getActiveSheet()->getStyle("B" . $y . ":L" . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $repetido = 1;
                $styleArray = array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle('B' . $y . ':N' . $y)->applyFromArray($styleArray);
                unset($styleArray);
                $y++;
            }
            $sub = $sub + ($row1[10] - $row1[8] - $row1[9]);
            $desc = $desc + $row1[9];
            $ivaT = $ivaT + $row1[8];
            $total = $total + $row1[10];
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("B" . $y, $row1[14])
                    ->setCellValue("C" . $y, $row1[12])
                    ->setCellValue("D" . $y, $row1[11])
                    ->setCellValue("E" . $y, $row1[1])
                    ->setCellValue("F" . $y, substr($row1[0], 8))
                    ->setCellValue("G" . $y, utf8_decode(truncateFloat(round($row1[10]-$row1[8]-$row1[9],2, PHP_ROUND_HALF_EVEN),2)))
                    ->setCellValue("H" . $y, utf8_decode(truncateFloat(round($row1[9],2, PHP_ROUND_HALF_EVEN),2)))
                    ->setCellValue("I" . $y, utf8_decode(truncateFloat(round($row1[6],2, PHP_ROUND_HALF_EVEN),2)))
                    ->setCellValue("J" . $y, utf8_decode(truncateFloat(round($row1[7],2, PHP_ROUND_HALF_EVEN),2)))
                    ->setCellValue("K" . $y, utf8_decode(truncateFloat(round($row1[8],2, PHP_ROUND_HALF_EVEN),2)))
                    ->setCellValue("L" . $y, utf8_decode(truncateFloat(round($row1[10],2, PHP_ROUND_HALF_EVEN),2)))
                    ->setCellValue("M" . $y, $row1[3])
                    ->setCellValue("N" . $y, $row1[5]);
            $objPHPExcel->getActiveSheet()->getStyle("B" . $y . ":N" . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $y = $y + 1;
        }
    }

$styleArray = array(
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
        ),
    ),
);
$objPHPExcel->getActiveSheet()->getStyle('B' . ($y - 1) . ':N' . ($y - 1))->applyFromArray($styleArray);
unset($styleArray);
//$y=$y+1;  
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueExplicit("B" . $y, 'Totales:')
        ->setCellValueExplicit("G" . $y, (number_format($sub, 2, ',', '.')), PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicit("H" . $y, (number_format($desc, 2, ',', '.')), PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicit("K" . $y, (number_format($ivaT, 2, ',', '.')), PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicit("L" . $y, (number_format($total, 2, ',', '.')), PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getStyle("B" . $y . ":J" . $y)->getFont()->setBold(true)->setName('Verdana')->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle("B" . $y . ":J" . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$y++;
$y++;
//////////////////////////////////////////////////////////
//DATOS DE LA SALIDA DEL EXCEL
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="' . $Archivo . '"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;
?>

