<?php 
	include_once('simplehtmldom.php');

	class ServicioSRI {
		var $user_agent = array();
		var $url;
		var $url_1;
		var $proxy;
		function __construct() {
			$this->url = "https://declaraciones.sri.gob.ec/facturacion-internet/consultas/publico/ruc-datos2.jspa";			
			$this->url_1 = "https://declaraciones.sri.gob.ec/facturacion-internet/consultas/publico/ruc-establec.jspa";			
			$user_agent[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322; FDM)";
			$user_agent[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; Avant Browser [avantbrowser.com]; Hotbar 4.4.5.0)";
			$user_agent[] = "Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en; rv:1.8.1.14) Gecko/20080409 Camino/1.6 (like Firefox/2.0.0.14)";
			$user_agent[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Version/3.1 Safari/525.13";
			$user_agent[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; NeosBrowser; .NET CLR 1.1.4322; .NET CLR 2.0.50727)";
			$user_agent[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.8.1) Gecko/20061010 Firefox/2.0";
			$user_agent[] = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.6.2987.98 Safari/537.36";
			$this->user_agent = $user_agent;
		}

		// inicializacion de direccion funcionamienbto method_exists(object, method_name)
		function method_curt_ruc($ruc) {
			$rnd = rand(0, count($this->user_agent)-1);
			$agent = $this->user_agent[$rnd];

			$post = 'accion=siguiente&ruc='. $ruc;
			$ch = curl_init($this->url);			

			curl_setopt($ch, CURLOPT_POST      ,1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				
			//curl_setopt($ch, CURLOPT_POSTFIELDS    , POSTVARS);
			curl_setopt($ch, CURLOPT_POSTFIELDS    , $post);
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
			curl_setopt($ch, CURLOPT_HEADER      ,0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);			

			/// PROXY
			//Si tiene salida a Internet por Proxy, debe poner ip y puerto
			if($this->proxy) {
				curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
				curl_setopt($ch, CURLOPT_PROXY, $this->proxy['url']);  // '172.20.18.6:8080'
				if(isset($this->proxy['user']) && isset($this->proxy['password'])){
					$cred = $this->proxy['user'].':'.$this->proxy['password'];
					curl_setopt($ch, CURLOPT_PROXYUSERPWD, $cred);
				}
			}
			$res = curl_exec($ch);
			curl_close($ch);

			return $res;
		}
		// fin

		// verificar existencia del numero de  ruc en la base de datos
		function verificar_existencia_ruc($html) {
			$existencia = 'true';
			if(strpos($html, 'El RUC no se encuentra registrado en nuestra base de datos') !== false)
				$existencia = 'false';
			if(strpos($html, 'Error en el Sistema') !== false)
				$existencia = 'false';
			return $existencia;
		}
		// fin

		// proceso consulta ruc como empresa
		function consultar_ruc($ruc) {
			$html = $this->method_curt_ruc($ruc);

			if ($this->verificar_existencia_ruc($html)=='true') {
				$html = str_get_html($html);
				$htmlreturn = $html->find('table[class=formulario]', 0);
				$i = 0;
				
				foreach($html->find('table[class=formulario]', 0)->find('td') as $e) {
					if(strpos($e, 'colspan') !== false) {						
					} else {
						if ($e->plaintext) 
							$results[] = $e->plaintext;
						else
							$results[] = 'no disponible';
						$i++;
					}			        
			    }
			    return $acumulador = array('razon_social'=> $results[0], 
									'ruc'=> $results[1],
									'nombre_comercial'=> $results[2], 
									'estado_contribuyente'=> $results[3], 
									'clase_contribuyente'=> $results[4], 
									'tipo_contribuyente'=> trim($results[5]),
									'obligado_llevar_contabilidad'=> $results[6],
									'actividad_economica'=> $results[7],
									'fecha_inicio_actividades'=> trim($results[8]),
									'fecha_cese_actividades'=> trim($results[9]),
									'fecha_reinicio_actividades'=> trim($results[10]),
									'fecha_actualizacion' => trim($results[11]),
									'valid' => 'true'					
								);
			} else
				return $results[] = array('valid' => 'false');
		}
		// fin

		// proceso consulta ruc sucursales
		function establecimientoSRI($ruc) {
			$url = 'https://declaraciones.sri.gob.ec/facturacion-internet/consultas/publico/ruc-datos2.jspa';
			$ch_1 = curl_init();
			curl_setopt($ch_1, CURLOPT_URL, $url);
			curl_setopt($ch_1, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch_1, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch_1, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20100101 Firefox/15.0');
			curl_setopt ($ch_1, CURLOPT_COOKIEJAR, dirname(__FILE__).'\cookie.txt');
			curl_setopt($ch_1, CURLOPT_COOKIEFILE, dirname(__FILE__).'\cookie.txt');
			curl_setopt ($ch_1, CURLOPT_RETURNTRANSFER, 1);

			$sri = curl_exec ($ch_1);

			$lgnrnd = preg_replace('/^.*name="lgnrnd" value="/s','',$sri);
			$lgnrnd = preg_replace('/".*$/s','',$lgnrnd);

			$lgnjs = preg_replace('/^.*time=/s','',$sri);
			$lgnjs = preg_replace('/&amp.*$/s','',$lgnjs);

			
			$post = 'accion=siguiente&ruc='.$ruc;
			$post_1 = 'pagina=regresar&ruc='.$ruc;

			curl_setopt($ch_1, CURLOPT_URL, 'https://declaraciones.sri.gob.ec/facturacion-internet/consultas/publico/ruc-datos2.jspa');
			curl_setopt ($ch_1, CURLOPT_POST, 1);
			curl_setopt ($ch_1, CURLOPT_POSTFIELDS, $post);
			curl_exec ($ch_1);

			curl_setopt($ch_1, CURLOPT_URL, 'https://declaraciones.sri.gob.ec/facturacion-internet/consultas/publico/ruc-datos3.jspa');
			curl_setopt ($ch_1, CURLOPT_POST, 1);
			curl_setopt ($ch_1, CURLOPT_POSTFIELDS, $post_1);
			$repre = curl_exec ($ch_1);

			$startString  = '<div id="contenido">';
			$endString    =  '</div>';			
			$startColumn = strpos($repre, $startString) + strlen($startString);
			$endColumn   = strpos($repre, $endString, $startColumn);
			$dat = substr($repre, $startColumn, $endColumn - $startColumn);									
			$startString  = '<table width="100%" class="formulario">';						 		
			$endString    =  '</table>';			
			$startColumn = 50;
			$endColumn   = strpos($dat, $endString, $startColumn);
			$dat = substr($dat, $startColumn, $endColumn - $startColumn);									

			curl_setopt ($ch_1, CURLOPT_POST, 0);
			curl_setopt($ch_1, CURLOPT_URL, 'https://declaraciones.sri.gob.ec/facturacion-internet/consultas/publico/ruc-establec.jspa');
			curl_setopt ($ch_1, CURLOPT_RETURNTRANSFER, 1);		
			$res = curl_exec($ch_1);
			curl_close($ch_1);
			
			$filename = "cookie.txt";
			$fa = fopen($filename, "w+");
			fwrite($fa,"");
			fclose($fa);

			$startString  = '<div align="center"><b>Establecimiento Matriz</b></div>';
			$endString    = '</table><br/>';	
			$startColumn = strpos($res, $startString) + strlen($startString);
			$endColumn   = strpos($res, $endString, $startColumn);

			$establecimientos = substr($res, $startColumn, $endColumn-$startColumn);		

			$startString_1  = '<div align="center"><b>Establecimientos Adicionales</b></div>';
			$endString_1    = '</table><br/>';
			$startColumn_1 = strpos($res, $startString_1) + strlen($startString_1);
			$endColumn_1   = strpos($res, $endString_1, $startColumn_1);

			$establecimientos_1 = substr($res, $startColumn_1, $endColumn_1 - $startColumn_1);
			
			$establecimientos = $establecimientos . " " .$establecimientos_1 . " ". $dat ;		

			$establecimientos = str_replace('<table class="reporte" cellspacing="0">', "", $establecimientos);
			$establecimientos = str_replace('</table>', "", $establecimientos);				

			$establecimientos = '<table>'.$establecimientos.'</table>';				
			
			$html = str_get_html($establecimientos);
			foreach($html->find('table tr td') as $e) {
				$arr_1[] = utf8_encode(trim($e->innertext));
			}
			for ($i = 0; $i < (count($arr_1)); $i=$i+4) {
				if(strlen($arr_1[$i]) == 3 ){
					$_data['sucursal'][] = array('codigo' => $arr_1[$i+0], 'nombre_sucursal'=>$arr_1[$i+1], 'direccion'=>$arr_1[$i+2], 'estado'=>$arr_1[$i+3]);
				}
			}
			$_data['adicional'] = array('cedula' => $arr_1[count($arr_1)-3], 'representante_legal' => $arr_1[count($arr_1)-5]);
			return $_data;
		}
	}
	// fin
?>