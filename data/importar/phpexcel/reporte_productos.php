<?php
date_default_timezone_set('America/Guayaquil');
require_once "PHPExcel.php";
session_start();

//VARIABLES DE PHP
$objPHPExcel = new PHPExcel();
$Archivo = "reporte_productos.xls";

include '../procesos/base.php';
conectarse();


// Propiedades de archivo Excel
$objPHPExcel->getProperties()->setCreator("P&S Systems")
->setLastModifiedBy("P&S Systems")
->setTitle("Reporte XLS")
->setSubject("Reporte de productos")
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




//CABECERA DE LA CONSULTA
$y = 6;
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue("B".$y, 'Código')
->setCellValue("C".$y, 'Atículo')
->setCellValue("D".$y, 'Precio Minorista')
->setCellValue("E".$y, 'Precio Mayorista')
->setCellValue("F".$y, 'Stock');


$objPHPExcel->getActiveSheet()
            ->getStyle('B6:F6')            
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)            
            ->getStartColor()->setARGB('FFEEEEEE');

$objPHPExcel->getActiveSheet()
            ->getStyle('B6:F6')->getAlignment()
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
            ->getStyle('B6:F6')
			      ->applyFromArray($borders);

//////////////////////CABECERA DE LA CONSULTA
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue("B2", 'REPORTE DE PRODUCTOS');
$objPHPExcel->getActiveSheet()
            ->getStyle('B2:F2')->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('B2:F2');

$objPHPExcel->getActiveSheet()
            ->getStyle("B2:F2")
            ->getFont()
            ->setBold(true)
            ->setName('Verdana')
            ->setSize(20);
//////////////////////////
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("B4", 'Empresa: '.$_SESSION['empresa'].'');
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
            ->setCellValue("D4", 'Propietario: '.$_SESSION['propietario'].'');
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
$objDrawing->setPath('../images/logo_empresa.jpg');       // filesystem reference for the image file
$objDrawing->setHeight(70);                 // sets the image height to 36px (overriding the actual image height); 
$objDrawing->setCoordinates('F2');    // pins the top-left corner of the image to cell D24
$objDrawing->setOffsetX(0);                // pins the top left corner of the image at an offset of 10 points horizontally to the right of the top-left corner of the cell
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());     
//DETALLE DE LA CONSULTA
$sql=pg_query("select codigo,articulo,iva_minorista,iva_mayorista,stock from productos");
while($row=pg_fetch_row($sql))       
{
    $y++;
    //BORDE DE LA CELDA
		$objPHPExcel->setActiveSheetIndex(0)
    ->getStyle('B'.$y.":F".$y)
    ->applyFromArray($borders);

    //MOSTRAMOS LOS VALORES
    $objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("B".$y, ' '.$row[0])
		->setCellValue("C".$y, $row[1])
    ->setCellValue("D".$y, $row[2])
    ->setCellValue("E".$y, $row[3])
    ->setCellValue("F".$y, $row[4]);    
}

//DATOS DE LA SALIDA DEL EXCEL
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="'.$Archivo.'"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

?>