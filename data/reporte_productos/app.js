app.controller('reporte_productosController', function ($scope, $route) {
	$scope.$route = $route;

	jQuery(function($) {
		$('[data-toggle="tooltip"]').tooltip(); 

	
		// generar btn 1 
		$('#btn_abrir0').click(function() {
			var myWindow = window.open('data/reportes/reporte_productos.php');	
		})
		// fin

		// generar btn 1 
		$('#btn_abrir1').click(function() {
			var myWindow = window.open('data/reportes/reporte_existencia_minima.php');	
		})
		// fin

	});
});