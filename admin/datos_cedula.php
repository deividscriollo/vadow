<?php 
	include_once('simplehtmldom.php');

	class DatosCedula {
		var $user_agent = array();
		var $url;
		var $proxy;

		function __construct() {
			$this->url = "https://app03.cne.gob.ec/domicilioelectoral/Default.aspx";					
			$user_agent[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322; FDM)";
			$user_agent[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; Avant Browser [avantbrowser.com]; Hotbar 4.4.5.0)";
			$user_agent[] = "Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en; rv:1.8.1.14) Gecko/20080409 Camino/1.6 (like Firefox/2.0.0.14)";
			$user_agent[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Version/3.1 Safari/525.13";
			$user_agent[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; NeosBrowser; .NET CLR 1.1.4322; .NET CLR 2.0.50727)";
			$user_agent[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.8.1) Gecko/20061010 Firefox/2.0";
			$this->user_agent = $user_agent;
		}

		function cURL($url, $header = NULL, $cookie = NULL, $p = NULL) { 
		    $ch = curl_init(); 
		    curl_setopt($ch, CURLOPT_HEADER,            $header); 
		    curl_setopt($ch, CURLOPT_NOBODY,            $header); 
		    curl_setopt($ch, CURLOPT_URL,                $url); 
		    curl_setopt($ch, CURLOPT_COOKIE,            $cookie); 
		    curl_setopt($ch, CURLOPT_COOKIESESSION,        true); 

		    curl_setopt($ch, CURLOPT_USERAGENT,            $_SERVER['HTTP_USER_AGENT']); 
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER,    true); 
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,    true); 

		    if ($p) { 
		        curl_setopt($ch, CURLOPT_POST,            true); 
		        curl_setopt($ch, CURLOPT_POSTFIELDS,    $p); 
		        curl_setopt($ch, CURLOPT_REFERER,       $url); 
		    } 
		    $result = curl_exec($ch); 

		    if ($result) { 
		        return $result; 
		    } else { 
		        return curl_error($ch); 
		    } 
		    curl_close($ch); 
		} 
		
		// proceso consulta cedula
		function consultar_cedula($cedula) {
			$post['tipo'] = 'getDataWsRc';
			$post['ci'] = $cedula;
			
			$a = $this->cURL("http://www.mdi.gob.ec/minterior1/antecedentes/data.php",false,null,$post); 
			$resultado = json_decode($a)[0];
			if ($resultado->error != "") {
				$data = explode(':', $resultado->error);
				$error['valid'] = false;
				return $error;
			} else {
				$resultado->valid=true;
				return $resultado;
			}		
		}
		// fin
	}
?>