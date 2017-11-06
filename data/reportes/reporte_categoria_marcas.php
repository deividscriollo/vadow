<?php
    require('../fpdf/fpdf.php');
    include '../procesos/base.php';
    include '../procesos/funciones.php';
    conectarse();    
    date_default_timezone_set('America/Guayaquil'); 
    session_start()   ;
    class PDF extends FPDF
    {   
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
            $this->SetX(1);
            $this->SetFont('Arial','B',16);                                                    
            $this->Cell(190, 8, "EMPRESA: ".$_SESSION['empresa'], 0,1, 'C',0);                                
            $this->SetX(1);
            $this->Image('../images/logo_empresa.jpg',1,8,35,30);
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(180, 5, "PROPIETARIO: ".utf8_decode($_SESSION['propietario']),0,1, 'C',0);                                
            $this->SetX(1);
            $this->Cell(70, 5, "TEL.: ".utf8_decode($_SESSION['telefono']),0,0, 'R',0);                                
            $this->Cell(60, 5, "CEL.: ".utf8_decode($_SESSION['celular']),0,1, 'C',0);                                
            $this->SetX(5);
            $this->Cell(170, 5, "DIR.: ".utf8_decode($_SESSION['direccion']),0,1, 'C',0);                                
            $this->SetX(1);
            $this->Cell(170, 5, "SLOGAN.: ".utf8_decode($_SESSION['slogan']),0,1, 'C',0);                                
            $this->SetX(1);
            $this->Cell(170, 5, utf8_decode( $_SESSION['pais_ciudad']),0,1, 'C',0);                                                                                        
            $this->SetX(1);
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.5);
            $this->Line(1,46,210,46);            
            $this->SetFont('Arial','B',12);                                                    
            $this->SetX(1);
            $this->Cell(200, 5,utf8_decode("LISTA DE PRODUCTOS POR CATEGORÍAS Y MARCAS"),0,1, 'C',0);                                                                                        
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
    $pdf->SetX(1);
    $pdf->SetFillColor(125,120,120);
    $pdf->Cell(100, 8, utf8_decode("MARCA: ".$_GET['marca']),1,0, 'L',true);    
    $pdf->Cell(105, 8, utf8_decode("CATEGORÍA: ".$_GET['categoria']),1,1, 'L',true);    
    $pdf->Ln(2);  
    $pdf->SetX(1);      
    $pdf->Cell(30, 6, utf8_decode("Código"),1,0, 'C',0);
    $pdf->Cell(95, 6, utf8_decode("Producto"),1,0, 'C',0);
    $pdf->Cell(30, 6, utf8_decode("Precio Minorista"),1,0, 'C',0);        
    $pdf->Cell(30, 6, utf8_decode("Precio Mayorista"),1,0, 'C',0);    
    $pdf->Cell(20, 6, utf8_decode("Stock"),1,1, 'C',0);   
    if($_GET['marca']=="" && $_GET['categoria']==""){
        $sql=pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,categoria,marca from productos ");
    }else{
        if($_GET['marca']=="" && $_GET['categoria']!=""){
            $sql=pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,categoria,marca from productos where categoria='$_GET[categoria]'");
        }else{
            if($_GET['marca']!="" && $_GET['categoria']==""){
                $sql=pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,categoria,marca from productos where marca='$_GET[marca]'");
            }else{
                if($_GET['marca']!="" && $_GET['categoria']!=""){
                    $sql=pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,categoria,marca from productos where categoria='$_GET[categoria]' and marca='$_GET[marca]'"); 
                }else{

                }
            }            
        }
    }    
    $pdf->SetFont('Amble-Regular','',9);   
    $pdf->SetX(5);    
    while($row = pg_fetch_row($sql)){                
        $pdf->SetX(1);                  
        $pdf->Cell(30, 5, utf8_decode($row[0]),0,0, 'L',0);
        $pdf->Cell(95, 5, maxCaracter(utf8_decode($row[2]),50),0,0, 'L',0);
        $pdf->Cell(30, 5, utf8_decode($row[3]),0,0, 'C',0);        
        $pdf->Cell(30, 5, utf8_decode($row[4]),0,0, 'C',0);                         
        $pdf->Cell(20, 5, utf8_decode($row[5]),0,0, 'C',0);                         
        $pdf->Ln(5);        
    }    
                                                     
    $pdf->Output();
?>