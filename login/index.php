<?php
	session_start();
	if ($_SESSION) {
		header('Location: ../');
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>.:Login:.</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<link rel="shortcut icon" href="https://www.propiedadintelectual.gob.ec/wp-content/themes/institucion/favicon.ico" type="image/x-icon" /> 

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="../dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../dist/font-awesome/4.2.0/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="../dist/fonts/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="../dist/css/ace.min.css" />

		<!-- animate -->
		<link rel="stylesheet" href="../dist/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="../dist/css/animate.min.css" />

	</head>

	<body class="login-layout light-login">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h2>
									<i class="fa fa-desktop"></i>
								</h2>

								<h2 class="blue" id="id-company-text">
									<span class="red">VADOW</span>
									<span class="blue" id="id-text2">Sistemas Integrales</span>
								</h2>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<!-- <i class="ace-icon fa fa-coffee green"></i> -->
												Por favor ingrese su información
											</h4>

											<div class="space-6"></div>

											<form id="form_proceso" name="form_proceso">
												<fieldset>
													<label class="form-group block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="txt_nombre" id="txt_nombre" class="form-control" placeholder="Usuario" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="form-group block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="txt_clave" id="txt_clave" class="form-control" placeholder="Password" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" class="ace" />
															<span class="lbl"> Recordar</span>
														</label>

														<button type="submit" id="btn_ingresar" name="btn_ingresar" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Ingresar</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar clearfix">
											<div>
												<a href="#" data-target="#forgot-box" class="forgot-password-link">
													<i class="ace-icon fa fa-arrow-left"></i>
													Olvidé mi contraseña
												</a>
											</div>

											<div>
												<a href="#" data-target="#signup-box" class="user-signup-link">
													Quiero Registarme
													<i class="ace-icon fa fa-arrow-right"></i>
												</a>
											</div>
										</div>
									</div>
								</div>

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Recuperar Contraseña
											</h4>

											<div class="space-6"></div>
											<p>
												Ingrese su correo electrónico, para recibir instrucciones
											</p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button type="button" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="ace-icon fa fa-lightbulb-o"></i>
															<span class="bigger-110">Enviar!</span>
														</button>
													</div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												Atrás para iniciar sesión
												<i class="ace-icon fa fa-arrow-right"></i>
											</a>
										</div>
									</div>
								</div>

								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-users blue"></i>
												Registro de nuevo usuario
											</h4>

											<div class="space-6"></div>
											<p>Ingrese sus detalles para comenzar: </p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="Username" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Password" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Repeat password" />
															<i class="ace-icon fa fa-retweet"></i>
														</span>
													</label>

													<label class="block">
														<input type="checkbox" class="ace" />
														<span class="lbl">
															Acepto el Acuerdo de usuario
														</span>
													</label>

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-40 pull-left btn btn-sm">
															<i class="ace-icon fa fa-refresh"></i>
															<span class="bigger-110">Actualizar</span>
														</button>

														<button type="button" class="width-40 pull-right btn btn-sm btn-success">
															<span class="bigger-110">Registrar</span>

															<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												<i class="ace-icon fa fa-arrow-left"></i>											
												Atrás para iniciar sesión
											</a>
										</div>
									</div>
								</div>
							</div>

							<div class="navbar-fixed-top align-right">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- basic scripts -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript">
			window.jQuery || document.write("<script src='../dist/js/jquery.min.js'>"+"<"+"/script>");
		</script>

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='../dist/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<script src="../dist/js/jquery.validate.min.js"></script>
		<script src="../dist/js/jquery.blockUI.js"></script>
		<script src="../dist/js/lockr.min.js"></script>
		<script src="login.js"></script>
	</body>
</html>
