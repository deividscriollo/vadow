app.controller('reporte_comprasController', function ($scope, $route) {
	$scope.$route = $route;

	jQuery(function($) {
		$('[data-toggle="tooltip"]').tooltip();

		//para la fecha del calendario
		$(".datepicker").datepicker({ 
			format: "yyyy-mm-dd",
	        autoclose: true
		}).datepicker("setDate","today");
		// fin

		// estilo select2 
		$(".select2").css({
		    'width': '100%',
		    allow_single_deselect: true,
		    no_results_text: "No se encontraron resultados",
		    allowClear: true,
		    }).select2().on("change", function (e) {
			$(this).closest('form').validate().element($(this));
	    });

	    $("#select_proveedor1").select2({
		  	// allowClear: true
		});
		// fin

		$('#form_registro1').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: false,
			ignore: "",
			rules: {
				select_proveedor1: {
					required: true			
				},
			},
			messages: {
				select_proveedor1: {
					required: "Campo Requerido",
				},
			},
			//para prender y apagar los errores
			highlight: function (e) {
				$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
			},
			success: function (e) {
				$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
				$(e).remove();
			},
			submitHandler: function (form) {
				
			}
		});
		// Fin

		// llenar combo directores
		function llenar_select_proveedores() {
			$.ajax({
				url: 'data/reporte_compras/app.php',
				type: 'post',
				data: {llenar_proveedor:'llenar_proveedor'},
				success: function (data) {
					$('#select_proveedor1').html(data);
				}
			});
		}
		// fin 

		// inicio
		llenar_select_proveedores();
		// fin

		// generar btn 0 
		$('#btn_0').click(function() {
			var respuesta = $('#form_registro1').valid();
			if (respuesta == true) {
				var myWindow = window.open('data/reportes/reporte_agrupados_prov.php?inicio=' + $('#fecha_inicio').val() + '&fin=' +$('#fecha_fin').val() + '&id=' +$('#select_proveedor1').val());	
			}			
		})
		// fin

		// generar btn 1 
		$('#btn_1').click(function() {
			var myWindow = window.open('data/reportes/facturasCompras.php?inicio=' + $('#fecha_inicio1').val() + '&fin=' +$('#fecha_fin1').val());	
		})
		// fin
	});
});