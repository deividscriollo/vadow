<?php 
    function img_64($destino,$img_64,$extension,$nombre){
        define('UPLOAD_DIR', $destino.'/');    
        $img_64 = str_replace('data:image/png;base64,', '', $img_64);        
        $img_64 = str_replace(' ', '+', $img_64);
        $data_img = base64_decode($img_64);
        $file = UPLOAD_DIR . $nombre . '.'.$extension;
        if($success = file_put_contents($file, $data_img)){
            return "true";
        } else {
            return "false";
        }
    }

    function maxCaracter($texto, $cant){        
        $texto = substr($texto, 0,$cant);       
        return $texto;
    }
?>