<?php 
	require_once('classcorreo.php');
	function activacion_cuenta($correo,$empresa,$ruc,$id){
		$class = new constantecorreo();
		// mensaje html
		$contenido_html='
				<!DOCTYPE html>
					 <html xmlns="http://www.w3.org/1999/xhtml">
					 <head>
					  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					  <meta name="viewport" content="initial-scale=1.0" />
					  <meta name="format-detection" content="telephone=no" />
					  <title></title>
					  <style type="text/css">
					 	body {
							width: 100%;
							margin: 0;
							padding: 0;
							-webkit-font-smoothing: antialiased;
						}
						@media only screen and (max-width: 600px) {
							table[class="table-row"] {
								float: none !important;
								width: 98% !important;
								padding-left: 20px !important;
								padding-right: 20px !important;
							}
							table[class="table-row-fixed"] {
								float: none !important;
								width: 98% !important;
							}
							table[class="table-col"], table[class="table-col-border"] {
								float: none !important;
								width: 100% !important;
								padding-left: 0 !important;
								padding-right: 0 !important;
								table-layout: fixed;
							}
							td[class="table-col-td"] {
								width: 100% !important;
							}
							table[class="table-col-border"] + table[class="table-col-border"] {
								padding-top: 12px;
								margin-top: 12px;
								border-top: 1px solid #E8E8E8;
							}
							table[class="table-col"] + table[class="table-col"] {
								margin-top: 15px;
							}
							td[class="table-row-td"] {
								padding-left: 0 !important;
								padding-right: 0 !important;
							}
							table[class="navbar-row"] , td[class="navbar-row-td"] {
								width: 100% !important;
							}
							img {
								max-width: 100% !important;
								display: inline !important;
							}
							img[class="pull-right"] {
								float: right;
								margin-left: 11px;
					            max-width: 125px !important;
								padding-bottom: 0 !important;
							}
							img[class="pull-left"] {
								float: left;
								margin-right: 11px;
								max-width: 125px !important;
								padding-bottom: 0 !important;
							}
							table[class="table-space"], table[class="header-row"] {
								float: none !important;
								width: 98% !important;
							}
							td[class="header-row-td"] {
								width: 100% !important;
							}
						}
						@media only screen and (max-width: 480px) {
							table[class="table-row"] {
								padding-left: 16px !important;
								padding-right: 16px !important;
							}
						}
						@media only screen and (max-width: 320px) {
							table[class="table-row"] {
								padding-left: 12px !important;
								padding-right: 12px !important;
							}
						}
						@media only screen and (max-width: 608px) {
							td[class="table-td-wrap"] {
								width: 100% !important;
							}
						}
					  </style>
					 </head>
					 <body style="font-family: Arial, sans-serif; font-size:13px; color: #444444; min-height: 200px;" bgcolor="#E4E6E9" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
					 <table width="100%" height="100%" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0">
					 <tr><td width="100%" align="center" valign="top" bgcolor="#E4E6E9" style="background-color:#E4E6E9; min-height: 200px;">
					<table><tr><td class="table-td-wrap" align="center" width="608">

					<table class="table-row" style="table-layout: auto; padding-right: 24px; padding-left: 24px; width: 600px; background-color: #ffffff;" bgcolor="#FFFFFF" width="600" cellspacing="0" cellpadding="0" border="0"><tbody><tr height="55px" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; height: 55px;">
					   <td class="table-row-td" style="height: 55px; padding-right: 16px; font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; vertical-align: middle;" valign="middle" align="left">
					     <a href="#" style="color: #428bca; text-decoration: none; padding: 0px; font-size: 18px; line-height: 20px; height: 50px; background-color: transparent;">
						 	empresa.nextbook.ec
						 </a>
					   </td>
					 
					   <td class="table-row-td" style="height: 55px; font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; text-align: right; vertical-align: middle;" align="right" valign="middle">
					     <a href="#" style="color: #428bca; text-decoration: none; font-size: 15px; background-color: transparent;">
						   Corporativo
						 </a>
						 &nbsp;
						 <a href="#" style="color: #428bca; text-decoration: none; font-size: 15px; background-color: transparent;">
						   Contactos
						 </a>
					   </td>
					</tr></tbody></table>


					<table class="table-space" height="6" style="height: 6px; font-size: 0px; line-height: 0; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="6" style="height: 6px; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table>
					<table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

					<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 24px; padding-right: 24px;" valign="top" align="left">
					 <table class="table-col" align="left" width="552" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="552" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">	
						<div style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; text-align: center;">
							<img src="http://www.empresa.nextbook.ec/assets/dist/img/banner_correo_activacion.jpg" style="border: 0px none #444444; vertical-align: middle; display: block; padding-bottom: 9px; width:100%;" hspace="0" vspace="0" border="0">
						</div>
					 </td></tr></tbody></table>
					</td></tr></tbody></table>

					<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
					   <table class="table-col" align="left" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="528" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
						 <table class="header-row" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="528" style="font-size: 20px; margin: 0px; font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #478fca; padding-bottom: 10px; padding-top: 15px;" valign="top" align="left">Estimados, '.$empresa.'</td></tr></tbody></table>
						 <table class="header-row" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="528" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #444444; margin: 0px; font-size: 15px; padding-bottom: 8px; padding-top: 10px;" valign="top" align="left">Se ha registrado con éxito en nextbook.ec con tu número de RUC '.$ruc.', por favor haz clic en el siguiente enlace para continuar.</td></tr></tbody></table>
					   </td></tr></tbody></table>
					</td></tr></tbody></table>

					<table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
					<table class="table-space" height="24" style="height: 24px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="24" style="height: 24px; width: 600px; padding-left: 18px; padding-right: 18px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="center">&nbsp;<table bgcolor="#E8E8E8" height="0" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td bgcolor="#E8E8E8" height="1" width="100%" style="height: 1px; font-size:0;" valign="top" align="left">&nbsp;</td></tr></tbody></table></td></tr></tbody></table>
						
						

					<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
					   				<table class="table-col" align="left" width="556" style="padding-right: 18px; table-layout: fixed;" cellspacing="0" cellpadding="0" border="0">
					   					<tbody>
					   						<tr>
					   							<td class="table-col-td" width="255" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="center">
						
												<div style="font-family: Arial, sans-serif; line-height: 36px; color: #444444; font-size: 13px;">
													<a href="http://www.nextbook.ec/processcount.php?activ_reg_count=DKsf984wDMd&id='.$id.'" style="color: #b7837a; text-decoration: none; margin: 0px; text-align: center; vertical-align: baseline; border-width: 1px 1px 2px; border-style: solid; border-color: #d7a59d; padding: 6px 12px; font-size: 14px; line-height: 20px; background-color: #ffffff;">Clic aquí para activar la cuenta</a>
												</div>
					   							</td>
					   						</tr>
					   					</tbody>
					   				</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>


					<table class="table-space" height="6" style="height: 6px; font-size: 0px; line-height: 0; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="6" style="height: 6px; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table>
					<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
					 <table class="table-col" align="left" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="528" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
						 <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
						 <div style="font-family: Arial, sans-serif; line-height: 19px; color: #777777; font-size: 14px; text-align: center;">&copy; 2015 CONCEPTUAL BUSINESS GROUP</div>
						 <table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
						 <div style="font-family: Arial, sans-serif; line-height: 19px; color: #bbbbbb; font-size: 13px; text-align: center;">
							<a href="http://www.nextbook.ec/terminos.html" style="color: #428bca; text-decoration: none; background-color: transparent;">Términos de Uso</a>
							&nbsp;|&nbsp;
							<a href="http://www.nextbook.ec/info.html" style="color: #428bca; text-decoration: none; background-color: transparent;">nextbook.ec</a>
							&nbsp;|&nbsp;
							<a href="http://www.empresa.nextbook.ec" style="color: #428bca; text-decoration: none; background-color: transparent;">empresa.nextbook.ec</a>
						 </div>
						 <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
					 </td></tr></tbody></table>
					</td></tr></tbody></table>
					<table class="table-space" height="8" style="height: 8px; font-size: 0px; line-height: 0; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="8" style="height: 8px; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table></td></tr></table>
					</td></tr>
					 </table>
					 </body>
					 </html>
		';
		// Contenido
		$titulo = utf8_decode('Acivación cuenta para uso de la aplicación');
		$contenido_html=utf8_decode($contenido_html);
		// To send HTML mail, the Content-type header must be set
		$headers = "MIME-Version: 1.0\n" ;
		$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";

		// Mail it
		$acu=0;
		if ($class->registro_correo($correo,$contenido_html,$titulo)) {
			$acu=1;
		};
		return $acu;
	}
	function activacion_correo($correo,$empresa,$ruc,$id, $user, $passwor){
		// título
		$class = new constantecorreo();
		// mensaje
		$contenido_html='
				<!DOCTYPE html>
						 <html xmlns="http://www.w3.org/1999/xhtml">
						 <head>
						  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
						  <meta name="viewport" content="initial-scale=1.0" />
						  <meta name="format-detection" content="telephone=no" />
						  <title></title>
						  <style type="text/css">
						 	body {
								width: 100%;
								margin: 0;
								padding: 0;
								-webkit-font-smoothing: antialiased;
							}
							@media only screen and (max-width: 600px) {
								table[class="table-row"] {
									float: none !important;
									width: 98% !important;
									padding-left: 20px !important;
									padding-right: 20px !important;
								}
								table[class="table-row-fixed"] {
									float: none !important;
									width: 98% !important;
								}
								table[class="table-col"], table[class="table-col-border"] {
									float: none !important;
									width: 100% !important;
									padding-left: 0 !important;
									padding-right: 0 !important;
									table-layout: fixed;
								}
								td[class="table-col-td"] {
									width: 100% !important;
								}
								table[class="table-col-border"] + table[class="table-col-border"] {
									padding-top: 12px;
									margin-top: 12px;
									border-top: 1px solid #E8E8E8;
								}
								table[class="table-col"] + table[class="table-col"] {
									margin-top: 15px;
								}
								td[class="table-row-td"] {
									padding-left: 0 !important;
									padding-right: 0 !important;
								}
								table[class="navbar-row"] , td[class="navbar-row-td"] {
									width: 100% !important;
								}
								img {
									max-width: 100% !important;
									display: inline !important;
								}
								img[class="pull-right"] {
									float: right;
									margin-left: 11px;
						            max-width: 125px !important;
									padding-bottom: 0 !important;
								}
								img[class="pull-left"] {
									float: left;
									margin-right: 11px;
									max-width: 125px !important;
									padding-bottom: 0 !important;
								}
								table[class="table-space"], table[class="header-row"] {
									float: none !important;
									width: 98% !important;
								}
								td[class="header-row-td"] {
									width: 100% !important;
								}
							}
							@media only screen and (max-width: 480px) {
								table[class="table-row"] {
									padding-left: 16px !important;
									padding-right: 16px !important;
								}
							}
							@media only screen and (max-width: 320px) {
								table[class="table-row"] {
									padding-left: 12px !important;
									padding-right: 12px !important;
								}
							}
							@media only screen and (max-width: 608px) {
								td[class="table-td-wrap"] {
									width: 100% !important;
								}
							}
						  </style>
						 </head>
						 <body style="font-family: Arial, sans-serif; font-size:13px; color: #444444; min-height: 200px;" bgcolor="#E4E6E9" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
						 <table width="100%" height="100%" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0">
						 <tr><td width="100%" align="center" valign="top" bgcolor="#E4E6E9" style="background-color:#E4E6E9; min-height: 200px;">
							<table><tr><td class="table-td-wrap" align="center" width="608">

							<table class="table-row" style="table-layout: auto; padding-right: 24px; padding-left: 24px; width: 600px; background-color: #ffffff;" bgcolor="#FFFFFF" width="600" cellspacing="0" cellpadding="0" border="0"><tbody><tr height="55px" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; height: 55px;">
							   <td class="table-row-td" style="height: 55px; padding-right: 16px; font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; vertical-align: middle;" valign="middle" align="left">
							     <a href="#" style="color: #428bca; text-decoration: none; padding: 0px; font-size: 18px; line-height: 20px; height: 50px; background-color: transparent;">
								 	empresa.nextbook.ec
								 </a>
							   </td>
							 
							   <td class="table-row-td" style="height: 55px; font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; text-align: right; vertical-align: middle;" align="right" valign="middle">
							     <a href="#" style="color: #428bca; text-decoration: none; font-size: 15px; background-color: transparent;">
								   Corporativo
								 </a>
								 &nbsp;
								 <a href="#" style="color: #428bca; text-decoration: none; font-size: 15px; background-color: transparent;">
								   Contactos
								 </a>
							   </td>
							</tr></tbody></table>


							<table class="table-space" height="6" style="height: 6px; font-size: 0px; line-height: 0; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="6" style="height: 6px; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table>
							<table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

							<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 24px; padding-right: 24px;" valign="top" align="left">
							 <table class="table-col" align="left" width="552" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="552" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">	
								<div style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; text-align: center;">
									<img src="http://www.empresa.nextbook.ec/assets/dist/img/banner_correo_activacion.jpg" style="border: 0px none #444444; vertical-align: middle; display: block; padding-bottom: 9px; width: 100%;" hspace="0" vspace="0" border="0">
								</div>
							 </td></tr></tbody></table>
							</td></tr></tbody></table>

							<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
							   <table class="table-col" align="left" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="528" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
								 <table class="header-row" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="528" style="font-size: 20px; margin: 0px; font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #478fca; padding-bottom: 10px; padding-top: 15px;" valign="top" align="left">Estimados, '.$empresa.'</td></tr></tbody></table>
								 <table class="header-row" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="528" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #444444; margin: 0px; font-size: 15px; padding-bottom: 8px; padding-top: 10px;" valign="top" align="left">Su nueva información de acceso a su cuenta es la siguiente:</td></tr></tbody></table>
							   </td></tr></tbody></table>
							</td></tr></tbody></table>


							<table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
							<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
							   <table class="table-col" align="left" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="528" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
								 <table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td width="100%" bgcolor="#d9edf7" style="font-family: Arial, sans-serif; line-height: 19px; color: #31708f; font-size: 14px; font-weight: normal; padding: 15px; border: 1px solid #bce8f1; background-color: #d9edf7;" valign="top" align="left">
								    <p>Usuario: '.$ruc.'@facturanext.com</p>
									<p>Clave acceso: '.$passwor.'</p>

								   <br>
								 </td></tr></tbody></table>
							   </td></tr></tbody></table>
							</td></tr></tbody></table>
							<table class="table-space" height="24" style="height: 24px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="24" style="height: 24px; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>



							<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
							   <table class="table-col" align="left" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="528" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
								 <table class="header-row" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="528" style="font-size: 20px; margin: 0px; font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #478fca; padding-bottom: 10px; padding-top: 15px;" valign="top" align="center">
								 	Solicite a todos los establecimientos o proveedores a los que compras, envíen tus facturas electrónicas a este correo o reenvíalas directamente.
									<p>¡Nextbook.ec se encarga del resto!</p>
									</td></tr></tbody></table>
								 <table class="header-row" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="528" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #444444; margin: 0px; font-size: 15px; padding-bottom: 8px; padding-top: 10px;" valign="top" align="left"></td></tr></tbody></table>
							   </td></tr></tbody></table>
							</td></tr></tbody></table>









								


							<table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>


							<table class="table-space" height="6" style="height: 6px; font-size: 0px; line-height: 0; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="6" style="height: 6px; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table>
							<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
							 <table class="table-col" align="left" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="528" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
								 <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
								 <div style="font-family: Arial, sans-serif; line-height: 19px; color: #777777; font-size: 14px; text-align: center;">&copy; 2015 CONCEPTUAL BUSINESS GROUP</div>
								 <table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
								 <div style="font-family: Arial, sans-serif; line-height: 19px; color: #bbbbbb; font-size: 13px; text-align: center;">
									<a href="http://www.nextbook.ec/terminos.html" style="color: #428bca; text-decoration: none; background-color: transparent;">Términos de Uso</a>
									&nbsp;|&nbsp;
									<a href="http://www.nextbook.ec/info.html" style="color: #428bca; text-decoration: none; background-color: transparent;">nextbook.ec</a>
									&nbsp;|&nbsp;
									<a href="http://www.empresa.nextbook.ec" style="color: #428bca; text-decoration: none; background-color: transparent;">empresa.nextbook.ec</a>
								 </div>
								 <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
							 </td></tr></tbody></table>
							</td></tr></tbody></table>
							<table class="table-space" height="8" style="height: 8px; font-size: 0px; line-height: 0; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="8" style="height: 8px; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table></td></tr></table>
							</td></tr>
							 </table>
							 </body>
						</html>
			';
		$titulo = utf8_decode('Acivación cuenta para uso de la aplicación');
		$contenido_html=utf8_decode($contenido_html);
		// Mail it
		$acu=0;
		if ($class->registro_correo($correo,$contenido_html,$titulo)) {
			$acu=1;
		};
		return $acu;
	}
	function activacion_cuenta_colaborador($correo,$id,$nombre, $empresa){
		$class = new constantecorreo();
		// mensaje html
		$contenido_html='
		<!DOCTYPE html>
			<html xmlns="http://www.w3.org/1999/xhtml">
					 <head>
					  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					  <meta name="viewport" content="initial-scale=1.0" />
					  <meta name="format-detection" content="telephone=no" />
					  <title></title>
					  <style type="text/css">
					 	body {
							width: 100%;
							margin: 0;
							padding: 0;
							-webkit-font-smoothing: antialiased;
						}
						@media only screen and (max-width: 600px) {
							table[class="table-row"] {
								float: none !important;
								width: 98% !important;
								padding-left: 20px !important;
								padding-right: 20px !important;
							}
							table[class="table-row-fixed"] {
								float: none !important;
								width: 98% !important;
							}
							table[class="table-col"], table[class="table-col-border"] {
								float: none !important;
								width: 100% !important;
								padding-left: 0 !important;
								padding-right: 0 !important;
								table-layout: fixed;
							}
							td[class="table-col-td"] {
								width: 100% !important;
							}
							table[class="table-col-border"] + table[class="table-col-border"] {
								padding-top: 12px;
								margin-top: 12px;
								border-top: 1px solid #E8E8E8;
							}
							table[class="table-col"] + table[class="table-col"] {
								margin-top: 15px;
							}
							td[class="table-row-td"] {
								padding-left: 0 !important;
								padding-right: 0 !important;
							}
							table[class="navbar-row"] , td[class="navbar-row-td"] {
								width: 100% !important;
							}
							img {
								max-width: 100% !important;
								display: inline !important;
							}
							img[class="pull-right"] {
								float: right;
								margin-left: 11px;
					            max-width: 125px !important;
								padding-bottom: 0 !important;
							}
							img[class="pull-left"] {
								float: left;
								margin-right: 11px;
								max-width: 125px !important;
								padding-bottom: 0 !important;
							}
							table[class="table-space"], table[class="header-row"] {
								float: none !important;
								width: 98% !important;
							}
							td[class="header-row-td"] {
								width: 100% !important;
							}
						}
						@media only screen and (max-width: 480px) {
							table[class="table-row"] {
								padding-left: 16px !important;
								padding-right: 16px !important;
							}
						}
						@media only screen and (max-width: 320px) {
							table[class="table-row"] {
								padding-left: 12px !important;
								padding-right: 12px !important;
							}
						}
						@media only screen and (max-width: 608px) {
							td[class="table-td-wrap"] {
								width: 100% !important;
							}
						}
					  </style>
					 </head>
					 <body style="font-family: Arial, sans-serif; font-size:13px; color: #444444; min-height: 200px;" bgcolor="#E4E6E9" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
					 <table width="100%" height="100%" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0">
					 <tr><td width="100%" align="center" valign="top" bgcolor="#E4E6E9" style="background-color:#E4E6E9; min-height: 200px;">
					<table><tr><td class="table-td-wrap" align="center" width="608">

					<table class="table-row" style="table-layout: auto; padding-right: 24px; padding-left: 24px; width: 600px; background-color: #ffffff;" bgcolor="#FFFFFF" width="600" cellspacing="0" cellpadding="0" border="0"><tbody><tr height="55px" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; height: 55px;">
					   <td class="table-row-td" style="height: 55px; padding-right: 16px; font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; vertical-align: middle;" valign="middle" align="left">
					     <a href="#" style="color: #428bca; text-decoration: none; padding: 0px; font-size: 18px; line-height: 20px; height: 50px; background-color: transparent;">
						 	empresa.nextbook.ec
						 </a>
					   </td>
					 
					   <td class="table-row-td" style="height: 55px; font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; text-align: right; vertical-align: middle;" align="right" valign="middle">
					     <a href="#" style="color: #428bca; text-decoration: none; font-size: 15px; background-color: transparent;">
						   Corporativo
						 </a>
						 &nbsp;
						 <a href="#" style="color: #428bca; text-decoration: none; font-size: 15px; background-color: transparent;">
						   Contactos
						 </a>
					   </td>
					</tr></tbody></table>


					<table class="table-space" height="6" style="height: 6px; font-size: 0px; line-height: 0; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="6" style="height: 6px; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table>
					<table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

					<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 24px; padding-right: 24px;" valign="top" align="left">
					 <table class="table-col" align="left" width="552" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="552" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">	
						<div style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; text-align: center;">
							<img src="http://www.nextbook.ec/next/assets/images/banner_correo.jpg" style="border: 0px none #444444; vertical-align: middle; display: block; padding-bottom: 9px; width:100%;" hspace="0" vspace="0" border="0">
						</div>			
					 </td></tr></tbody></table>
					</td></tr></tbody></table>

					<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
					   <table class="table-col" align="left" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="528" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
						 <table class="header-row" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="528" style="font-size: 20px; margin: 0px; font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #478fca; padding-bottom: 10px; padding-top: 15px;" valign="top" align="left">Estimados, '.$nombre.'</td></tr></tbody></table>
						 <table class="header-row" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="528" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #444444; margin: 0px; font-size: 15px; padding-bottom: 8px; padding-top: 10px;" valign="top" align="left">'.$nombre.' te agregado como colaborador en nextbook.ec te pedimos hacer clic en el siguiente enlace para poder activar tu cuenta.</td></tr></tbody></table>
					   </td></tr></tbody></table>
					</td></tr></tbody></table>

					<table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
					<table class="table-space" height="24" style="height: 24px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="24" style="height: 24px; width: 600px; padding-left: 18px; padding-right: 18px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="center">&nbsp;<table bgcolor="#E8E8E8" height="0" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td bgcolor="#E8E8E8" height="1" width="100%" style="height: 1px; font-size:0;" valign="top" align="left">&nbsp;</td></tr></tbody></table></td></tr></tbody></table>
						
						

					<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
					   				<table class="table-col" align="left" width="556" style="padding-right: 18px; table-layout: fixed;" cellspacing="0" cellpadding="0" border="0">
					   					<tbody>
					   						<tr>
					   							<td class="table-col-td" width="255" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="center">
						
												<div style="font-family: Arial, sans-serif; line-height: 36px; color: #444444; font-size: 13px;">
													<a href="http://www.nextbook.ec/processcount.php?activ_reg_count_colaboradores=DKsf984wDMd&id='.$id.'" style="color: #b7837a; text-decoration: none; margin: 0px; text-align: center; vertical-align: baseline; border-width: 1px 1px 2px; border-style: solid; border-color: #d7a59d; padding: 6px 12px; font-size: 14px; line-height: 20px; background-color: #ffffff;">Clic aquí para activar la cuenta</a>
												</div>
					   							</td>
					   						</tr>
					   					</tbody>
					   				</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>


					<table class="table-space" height="6" style="height: 6px; font-size: 0px; line-height: 0; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="6" style="height: 6px; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table>
					<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
					 <table class="table-col" align="left" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="528" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
						 <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
						 <div style="font-family: Arial, sans-serif; line-height: 19px; color: #777777; font-size: 14px; text-align: center;">&copy; 2015 CONCEPTUAL BUSINESS GROUP</div>
						 <table class="table-space" height="12" style="height: 12px; font-size: 0px; line-height: 0; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
						 <div style="font-family: Arial, sans-serif; line-height: 19px; color: #bbbbbb; font-size: 13px; text-align: center;">
							<a href="http://www.nextbook.ec/terminos.html" style="color: #428bca; text-decoration: none; background-color: transparent;">Términos de Uso</a>
							&nbsp;|&nbsp;
							<a href="http://www.nextbook.ec/info.html" style="color: #428bca; text-decoration: none; background-color: transparent;">nextbook.ec</a>
							&nbsp;|&nbsp;
							<a href="http://www.empresa.nextbook.ec" style="color: #428bca; text-decoration: none; background-color: transparent;">empresa.nextbook.ec</a>
						 </div>
						 <table class="table-space" height="16" style="height: 16px; font-size: 0px; line-height: 0; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
					 </td></tr></tbody></table>
					</td></tr></tbody></table>
					<table class="table-space" height="8" style="height: 8px; font-size: 0px; line-height: 0; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="8" style="height: 8px; width: 600px; background-color: #e4e6e9;" width="600" bgcolor="#E4E6E9" align="left">&nbsp;</td></tr></tbody></table></td></tr></table>
					</td></tr>
					 </table>
					 </body>
		</html>
		';
		// Contenido
		$titulo = utf8_decode('Acivación cuenta para uso de la aplicación');
		$contenido_html=utf8_decode($contenido_html);

		// Mail it
		print $enviar=$class->registro_correo($correo,$contenido_html,$titulo);
		$acu=0;
		if ($enviar) {
			$acu=1;
		};
		return $acu;
	}
?>

