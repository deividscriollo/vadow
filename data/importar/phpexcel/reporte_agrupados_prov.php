<?php

date_default_timezone_set('America/Guayaquil');
require_once "PHPExcel.php";

//VARIABLES DE PHP
$objPHPExcel = new PHPExcel();
$Archivo = "reporte_agrupados_prov.xls";

include '../procesos/base.php';
session_start();
conectarse();


// Propiedades de archivo Excel
$objPHPExcel->getProperties()->setCreator("P&S Systems")
        ->setLastModifiedBy("P&S Systems")
        ->setTitle("Reporte XLS")
        ->setSubject("Reporte de productos agrupados por proveedor")
        ->setDescription("")
        ->setKeywords("")
        ->setCategory("");


//PROPIEDADES DEL  LA CELDA
$objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

//CABECERA DE LA CONSULTA
$y = 8;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("B" . $y, 'Factura Nro')
        ->setCellValue("C" . $y, 'Código')
        ->setCellValue("D" . $y, 'Artículo')
        ->setCellValue("E" . $y, 'Precio Minorista')
        ->setCellValue("F" . $y, 'Precio Mayorista')
        ->setCellValue("G" . $y, 'Stock');


$objPHPExcel->getActiveSheet()
        ->getStyle('B8:G8')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFEEEEEE');

$objPHPExcel->getActiveSheet()
        ->getStyle('B8:G8')->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$borders = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        )
    ),
);

$objPHPExcel->getActiveSheet()
        ->getStyle('B8:G8')
        ->applyFromArray($borders);

//////////////////////CABECERA DE LA CONSULTA
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("B2", 'REPORTE DE PRODUCTOS AGRUPADOS POR PROVEEDOR');
$objPHPExcel->getActiveSheet()
        ->getStyle('B2:G2')->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('B2:G2');

$objPHPExcel->getActiveSheet()
        ->getStyle("B2:G2")
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
        ->setSize(12);
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
        ->setSize(12);
/////////////////////////
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('PHPExcel logo');
$objDrawing->setDescription('PHPExcel logo');
$objDrawing->setPath('../images/logo_empresa.jpg');       // 
$objDrawing->setHeight(70);                 // sets the image 
$objDrawing->setCoordinates('G2');    // pins the top-left corner 
$objDrawing->setOffsetX(0);                // pins the top left 
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


$sql = pg_query("select proveedores.id_proveedor, identificacion_pro,empresa_pro from proveedores,factura_compra where proveedores.id_proveedor='$_GET[id]' LIMIT 1");
while ($row = pg_fetch_row($sql)) {
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("B6", 'Proveedor: ' . $row[2]);
    $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('B6:C6');

    $objPHPExcel->getActiveSheet()
            ->getStyle("B6:C6")
            ->getFont()
            ->setBold(false)
            ->setName('Verdana')
            ->setSize(12);

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("D6", 'RUC/.CI: ' . $row[1]);
    $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('D6:E6');

    $objPHPExcel->getActiveSheet()
            ->getStyle("D6:E6")
            ->getFont()
            ->setBold(false)
            ->setName('Verdana')
            ->setSize(12);
}
$sql = pg_query("select proveedores.id_proveedor, identificacion_pro,factura_compra.id_factura_compra from proveedores,factura_compra where proveedores.id_proveedor='$_GET[id]' and factura_compra.id_proveedor=proveedores.id_proveedor");
$total = 0;
while ($row = pg_fetch_row($sql)) {

    $sql1 = pg_query("select detalle_factura_compra.id_detalle_compra,productos.codigo,productos.articulo,productos.iva_minorista,productos.iva_mayorista,productos.stock,detalle_factura_compra.precio_compra,total_compra,cantidad from detalle_factura_compra,productos where detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$row[2]'");

    while ($row1 = pg_fetch_row($sql1)) {
        $y++;
        $total = $total + $row1[7];
        //BORDE DE LA CELDA
        $objPHPExcel->setActiveSheetIndex(0)
                ->getStyle('B' . $y . ":G" . $y)
                ->applyFromArray($borders);
        //MOSTRAMOS LOS VALORES
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("B" . $y, ' ' . $row[2])
                ->setCellValue("C" . $y, $row1[1])
                ->setCellValue("D" . $y, $row1[2])
                ->setCellValue("E" . $y, $row1[6])
                ->setCellValue("F" . $y, $row1[7])
                ->setCellValue("G" . $y, $row1[8]);

        $objPHPExcel->getActiveSheet()
                ->getStyle('B' . $y)->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()
                ->getStyle('C' . $y)->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()
                ->getStyle('D' . $y)->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()
                ->getStyle('E' . $y)->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()
                ->getStyle('F' . $y)->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()
                ->getStyle('G' . $y)->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
    //////////////////    
}
$y++;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("B" . $y, 'Total:');
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('B' . $y . ':E' . $y);

$objPHPExcel->getActiveSheet()
        ->getStyle("B" . $y . ":E6" . $y)
        ->getFont()
        ->setBold(false)
        ->setName('Verdana')
        ->setSize(12);
$objPHPExcel->getActiveSheet()
        ->getStyle("B" . $y . ":E" . $y)->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)
        ->getStyle('B' . $y . ":E" . $y)
        ->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("F" . $y, $total);
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('F' . $y . ':F' . $y);
$objPHPExcel->getActiveSheet()
        ->getStyle("F" . $y . ":F" . $y)
        ->getFont()
        ->setBold(false)
        ->setName('Verdana')
        ->setSize(12);
$objPHPExcel->getActiveSheet()
        ->getStyle("F" . $y . ":F" . $y)->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)
        ->getStyle('F' . $y . ":F" . $y)
        ->applyFromArray($borders);

//DATOS DE LA SALIDA DEL EXCEL
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="' . $Archivo . '"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;
?>