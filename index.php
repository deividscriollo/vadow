<!DOCTYPE html>
<html ng-app="vadowApp" lang="es">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8">
		<title>Vadow</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="dist/font-awesome/4.5.0/css/font-awesome.min.css" />
		<!-- page specific plugin styles -->		
		<link rel="stylesheet" href="dist/css/chosen.min.css" />
		<link rel="stylesheet" href="dist/css/jquery-ui.min.css" />				
		<link rel="stylesheet" href="dist/css/ui.jqgrid.min.css" />
		<link rel="stylesheet" href="dist/css/jquery.gritter.css" />
		<link rel="stylesheet" href="dist/css/bootstrap-datepicker3.min.css" />
		<!-- text fonts -->
		<link rel="stylesheet" href="dist/css/fonts.googleapis.com.css" />
		<!-- ace styles -->
		<link rel="stylesheet" href="dist/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
		<!--<link rel="icon" href="dist/images/icon.ico" type="image/x-icon"/>-->
		<!--[if lte IE 9]>
			<link rel="stylesheet" href="dist/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="dist/css/ace-skins.min.css" />
		<link rel="stylesheet" href="dist/css/ace-rtl.min.css" />
		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="dist/css/ace-ie.min.css" />
		<![endif]-->	
		<!-- ace settings handler -->
		<script src="dist/js/ace-extra.min.js"></script>
		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
		<!--[if lte IE 8]>
		<script src="dist/js/html5shiv.min.js"></script>
		<script src="dist/js/respond.min.js"></script>
		<![endif]-->
		<!--angular-->
		<script type="text/javascript" src="dist/js/jquery.min.js"></script>	
		<script src="dist/js/chosen.jquery.min.js"></script>
		<script type="text/javascript" src="dist/angular/angular.min.js"></script>
		<script type="text/javascript" src="dist/angular/angular-route.min.js"></script>	
		<script type="text/javascript" src="dist/js/ngStorage.min.js"></script>	
		<!--controlador de rutas-->
		<script type="text/javascript" src="data/controller.js"></script>		
		<script type="text/javascript" src="data/home/app.js"></script>
		<script type="text/javascript" src="data/inventario/tipoBien/app.js"></script>
	</head>
	<body class="skin-3 no-skin">
		<div id="navbar" class="navbar navbar-default ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="navbar-header pull-left">
					<a href="index.html" class="navbar-brand">
						<small>							
							Vadow Admin
						</small>
					</a>
				</div>
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav" id="nav">
						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle" id="nav">									
								<span class="user-info">
									<small>Bienvenido(a),</small>									
								</span>
								<i class="ace-icon fa fa-caret-down"></i>
							</a>
							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										Configuraciones
									</a>
								</li>
								<li>
									<a href="" id="perfil">
										<i class="ace-icon fa fa-user"></i>
										Perfil
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="login/exit.php">
										<i class="ace-icon fa fa-power-off"></i>
										Salir
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>
		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>
				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>
						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>
						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>
						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>
					</div>
					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>
						<span class="btn btn-info"></span>
						<span class="btn btn-warning"></span>
						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->
				<!--MENU-->
				<ul class="nav nav-list">
				
				</ul><!-- /.nav-list -->
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>
			<!--container principal-->
			<div class="main-content ng-view">				
			</div><!-- /.main-content -->
			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Vadow &copy; 2017-2018
						</span>
						&nbsp; &nbsp;
						<span class="bigger-120">
							<span class="bolder">
							Version 1.0
							</span>
						</span>
					</div>
				</div>
			</div>
			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
	
		<script src="dist/js/angular-chosen.min.js"></script>
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='dist/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>				
		<script src="dist/js/bootbox.min.js"></script>
		<script src="dist/js/bootstrap.min.js"></script>
		<script src="dist/js/gritter.js"></script>
		<script src="dist/js/grid.locale-es.js"></script>
		<script src="dist/js/jquery.jqGrid.min.js"></script>		
		<script src="dist/js/jquery-ui.custom.min.js"></script>		
		<script src="dist/js/ace-elements.min.js"></script>		
		<script src="dist/js/ace.min.js"></script>		
		<script src="dist/js/moment.min.js"></script>
		
		
		<!--[if lte IE 8]>
		  <script src="dist/js/excanvas.min.js"></script>
		<![endif]-->
		<script type="text/javascript">
			jQuery(function($) {
				$(document).one('ajaxloadstart.page', function(e) {
					$tooltip.remove();
				});			
				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
				//so disable dragging when clicking on label
				var agent = navigator.userAgent.toLowerCase();
				if(ace.vars['touch'] && ace.vars['android']) {
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				  });
				}					
				/*$( "#nav" ).click(function( event ) {
					event.preventDefault();  
				});*/				
				$('.dialogs,.comments').ace_scroll({
					size: 300
			    });
			    $.extend($.gritter.options, {
				    class_name: 'gritter-light', // for light notifications (can be added directly to $.gritter.add too)
				    //position: 'bottom-left', // possibilities: bottom-left, bottom-right, top-left, top-right
					fade_in_speed: 100, // how fast notifications fade in (string or int)
					fade_out_speed: 100, // how fast the notices fade out
					time: 2000 // hang on the screen for...
				});
				$( "#perfil" ).click(function( event ) {					
					$('#modal_mod_user').modal('show');		
				});	
				function redireccionar() {
					setTimeout(function() {
					    location.reload(true);
					}, 1000);
				}	
				$("#btn_1").on('click',function(){
					if($("#inputPassword2").val() == $("#inputPassword3").val()){
						$.ajax({
					        url: "data/parametros/usuarios/cambioClave.php",
					        data: "anterior=" + $("#inputPassword1").val()+"&nueva=" + $("#inputPassword2").val()+"&repetir=" + $("#inputPassword3").val(),
					        type: "POST",					        
					        success: function (data) {			        	
					        	var val = data;
					        	if(data == '1') {
					        		$.gritter.add({
										title: '<span>Mensaje de Información </span>',										
										text: '	<span class=""></span>'
											+' <span class="text-success">Contraseñas Modificadas Correctamente </span><i class="ace-icon fa fa-spinner fa-spin green bigger-125"></i>',
										sticky: false,
										time: 2000				
									});									
						    	}  				    	
						    	redireccionar();
						    	if(data == '2') {						    		
					        		$.gritter.add({
										title: '<span>Mensaje de Información </span>',										
										text: '	<span class=""></span>'
											+' <span class="text-danger">Contraseñas Incorrectas </span><i class="ace-icon fa fa-spinner fa-spin red bigger-125"></i>',
										sticky: false,
										time: 2000				
									});	
									$("#inputPassword1").val("");
						    	}   
						    	if(data == '3') {				    		
					        		$.gritter.add({
										title: '<span>Mensaje de Información </span>',										
										text: '	<span class=""></span>'
											+' <span class="text-success">Datos Incorrectos Intente Nuevamente </span><i class="ace-icon fa fa-spinner fa-spin red bigger-125"></i>',
										sticky: false,
										time: 2000					
									});											
						    	} 
						    	redireccionar();
					        },
					        error: function (xhr, status, errorThrown) {
					        	$("#loading").css("display","none");
						        alert("Hubo un problema!");
						        console.log("Error: " + errorThrown);
						        console.log("Status: " + status);
						        console.dir(xhr);
					        }
					    });			
					}else{
						$.gritter.add({
							title: 'Mensaje de Error',
							text: 'Error las claves no coinciden. Ingrese nuevamente <i class="ace-icon fa fa-spinner fa-spin red bigger-125"></i>',
							time: 1000				
						});
						$("#inputPassword2").val("");
						$("#inputPassword3").val("");
					}
				});	
			})
		</script>	
		
	</body>
</html>