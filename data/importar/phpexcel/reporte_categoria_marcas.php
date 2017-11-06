<?php

date_default_timezone_set('America/Guayaquil');
require_once "PHPExcel.php";

//VARIABLES DE PHP
$objPHPExcel = new PHPExcel();
$Archivo = "reporte_productos_marcas_categorias.xls";

include '../procesos/base.php';
session_start();
conectarse();


// Propiedades de archivo Excel
$objPHPExcel->getProperties()->setCreator("P&S Systems")
        ->setLastModifiedBy("P&S Systems")
        ->setTitle("Reporte XLS")
        ->setSubject("Reporte de productos por categorías y marcas")
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
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

//CABECERA DE LA CONSULTA
$y = 6;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("B" . $y, 'Código')
        ->setCellValue("C" . $y, 'Atículo')
        ->setCellValue("D" . $y, 'Precio Minorista')
        ->setCellValue("E" . $y, 'Precio Mayorista')
        ->setCellValue("F" . $y, 'Stock')
        ->setCellValue("G" . $y, 'Categoría')
        ->setCellValue("H" . $y, 'Marca');


$objPHPExcel->getActiveSheet()
        ->getStyle('B6:H6')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFEEEEEE');

$objPHPExcel->getActiveSheet()
        ->getStyle('B6:H6')->getAlignment()
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
        ->getStyle('B6:H6')
        ->applyFromArray($borders);

//////////////////////CABECERA DE LA CONSULTA
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("B2", 'REPORTE DE PRODUCTOS POR CATEGORÍAS Y MARCAS');
$objPHPExcel->getActiveSheet()
        ->getStyle('B2:H2')->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('B2:H2');

$objPHPExcel->getActiveSheet()
        ->getStyle("B2:H2")
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
$objDrawing->setCoordinates('H2');    // pins the top-left corner 
$objDrawing->setOffsetX(0);                // pins the top left 
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

if ($_GET['marca'] == "" && $_GET['categoria'] == "") {
    $sql = pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,categoria,marca from productos");
}
if ($_GET['marca'] == "" && $_GET['categoria'] != "") {
    $sql = pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,categoria,marca from productos where categoria='$_GET[categoria]'");
}
if ($_GET['marca'] != "" && $_GET['categoria'] == "") {
    $sql = pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,categoria,marca from productos where  marca='$_GET[marca]'");
}
if ($_GET['marca'] != "" && $_GET['categoria'] != "") {
    $sql = pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,categoria,marca from productos where categoria='$_GET[categoria]' and marca='$_GET[marca]'");
}

while ($row = pg_fetch_row($sql)) {
    $y++;
    //BORDE DE LA CELDA
    $objPHPExcel->setActiveSheetIndex(0)
            ->getStyle('B' . $y . ":H" . $y)
            ->applyFromArray($borders);
    //MOSTRAMOS LOS VALORES
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("B" . $y, ' ' . $row[0])
            ->setCellValue("C" . $y, $row[2])
            ->setCellValue("D" . $y, $row[3])
            ->setCellValue("E" . $y, $row[4])
            ->setCellValue("F" . $y, $row[5])
            ->setCellValue("G" . $y, $row[6])
            ->setCellValue("H" . $y, $row[7]);

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
    $objPHPExcel->getActiveSheet()
            ->getStyle('H' . $y)->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}

//DATOS DE LA SALIDA DEL EXCEL
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="' . $Archivo . '"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;
?>