app.controller('mainController', function ($scope, $route, $timeout) {
	$scope.$route = $route;

	jQuery(function($) {

    // $scope.name = sessionService.get('nombres_completos');
    // $scope.imagen = sessionService.get('imagen');

    // cerrar sesion
    $scope.salir = function() {
        loginService.salir();
    } 
    // fin
        
    // funcion producto mas vendido
    function productos_vendidos() {
        $.ajax({
            type: "POST",
            url: "data/inicio/app.php",
            data: {cargar_productos_vendidos:'cargar_productos_vendidos'},
            dataType: 'json',
            async: false,
            success: function(data) {
                if (data == null) {
                    $scope.pieData = [{
                        name: "SIN FACTURAS",
                        y: 0
                    }]
                } else {
                    $scope.pieData = data;
                }
            }
        });
    }
    // fin

	// funcion total proformas
    function proformas() {
        $.ajax({
            type: "POST",
            url: "data/inicio/app.php",
            data: {cargar_proformas:'cargar_proformas'},
            dataType: 'json',
            async: false,
            success: function(data) {
            	if (data.total_proforma == null) {
            		$scope.proformas = '0.00';
            	} else {
            		$scope.proformas = parseFloat(data.total_proforma).toFixed(2);	
            	}   
            }
        });
    }
    // fin

    // funcion total facturas compra
    function factura_compra() {
        $.ajax({
            type: "POST",
            url: "data/inicio/app.php",
            data: {cargar_facturas_compra:'cargar_facturas_compra'},
            dataType: 'json',
            async: false,
            success: function(data) {
            	if (data.total_compra == null) {
            		$scope.factura_compra = '0.00';
            	} else {
            		$scope.factura_compra = parseFloat(data.total_compra).toFixed(2);	
            	}                
            }
        });
    }
    // fin

    // funcion total facturas venta
    function factura_venta() {
        $.ajax({
            type: "POST",
            url: "data/inicio/app.php",
            data: {cargar_facturas_venta:'cargar_facturas_venta'},
            dataType: 'json',
            async: false,
            success: function(data) {
            	if (data.total_venta == null) {
            		$scope.factura_venta = '0.00';
            	} else {
            		$scope.factura_venta = parseFloat(data.total_venta).toFixed(2);	
            	}                
            }
        });
    }
    // fin

    // funcion total ingresos
    function ingresos() {
        $.ajax({
            type: "POST",
            url: "data/inicio/app.php",
            data: {cargar_ingresos:'cargar_ingresos'},
            dataType: 'json',
            async: false,
            success: function(data) {
            	if (data.total_ingreso == null) {
            		$scope.ingresos = '0.00';
            	} else {
            		$scope.ingresos = parseFloat(data.total_ingreso).toFixed(2);	
            	}                
            }
        });
    }
    // fin

    // funcion total egresos
    function egresos() {
        $.ajax({
            type: "POST",
            url: "data/inicio/app.php",
            data: {cargar_egresos:'cargar_egresos'},
            dataType: 'json',
            async: false,
            success: function(data) {
            	if (data.total_egreso == null) {
            		$scope.egresos = '0.00';
            	} else {
            		$scope.egresos = parseFloat(data.total_egreso).toFixed(2);	
            	}                
            }
        });
    }
    // fin

    // funcion informacion
    function informacion() {
        $.ajax({
            type: "POST",
            url: "data/inicio/app.php",
            data: {cargar_informacion:'cargar_informacion'},
            dataType: 'json',
            async: false,
            success: function(data) {
                $scope.usuario = data.usuario;
                $scope.conexion = data.fecha_creacion;               
            }
        });
    }
    // fin

    // funcion chat
    function chat() {
        $.ajax({
            type: "POST",
            url: "data/inicio/app.php",
            data: {cargar_chat:'cargar_chat'},
            dataType: 'json',
            async: false,
            success: function(data) {
                $scope.datos = data;              
            }
        });
    }
    // fin

    // funcion  guardar chat
    function save_chat() {
        if ($('#message').val() == '') {
            $.gritter.add({
                title: 'Error... Ingrese un mensaje',
                class_name: 'gritter-error gritter-center',
                time: 1000,
            });
            $('#message').focus(); 
        } else {
            $.ajax({
                type: "POST",
                url: "data/inicio/app.php",
                data: {guardar_chat:'guardar_chat', mensaje: $('#message').val()},
                dataType: 'json',
                async: false,
                success: function(data) {
                    if (data == 1) {
                        $('#message').val('');
                        $('#message').focus();
                        chat();
                    }
                }
            });
        }    
    }
    // fin

    // scroll final
    function scroll_buttom_chat() {
        // $timeout(function() {
        //     var scroller = document.getElementById("style-5");
        //     scroller.scrollTop = scroller.scrollHeight;
        // }, 0, false);
    }
    // fin

    // enviar chat
    $scope.enviar_chat = function (data, event) {
        save_chat();    
    }
    // fin

    // funcion enter
    $scope.myFunction = function(keyEvent) {
      if (keyEvent.which === 13)
        save_chat();
        // scroll_buttom_chat();
    }
    // fin

    // incio funciones
    productos_vendidos();
    proformas();
    factura_compra();
    factura_venta();
	ingresos();
	egresos();
    informacion();
    scroll_buttom_chat();
    chat();
    // fin

	});	
});