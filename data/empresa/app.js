app.controller('empresaController', function ($scope, $route, loaddatosSRI) {

	$scope.$route = $route;

	jQuery(function($) {
		$('.form-control').on('focus blur', function (e) {
		    $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
		}).trigger('blur');
		
		$('[data-toggle="tooltip"]').tooltip(); 

		// mascaras input
		$('#telefono1').mask('(999) 999-999');
		$('#telefono2').mask('(999) 999-9999');

	 	// consultar ruc
		$scope.cargadatos = function(estado) {
			if($('#ruc').val() == '') {
				$.gritter.add({
					title: 'Error... Ingrese una Identificación',
					class_name: 'gritter-error gritter-center',
					time: 1000,
				});
				$('#ruc').focus();
			} else {
				$.ajax({
	                type: "POST",
	                url: "data/empresa/app.php",          
	                data:{consulta_ruc:'consulta_ruc',txt_ruc:$("#ruc").val()},
	                dataType: 'json',
	                beforeSend: function() {
	                	$.blockUI({ css: { 
				            border: 'none', 
				            padding: '15px', 
				            backgroundColor: '#000', 
				            '-webkit-border-radius': '10px', 
				            '-moz-border-radius': '10px', 
				            opacity: .5, 
				            color: '#fff' 
				        	},
				            message: '<h3>Consultando, Por favor espere un momento    ' + '<i class="fa fa-spinner fa-spin"></i>' + '</h3>'
				    	});
	                },
                    success: function(data) {
                    	$.unblockUI();
                    	if(data.datosEmpresa.valid == 'false') {
		            		$.gritter.add({
								title: 'Lo sentimos", "Usted no dispone de un RUC registrado en el SRI, o el número ingresado es Incorrecto."',
								class_name: 'gritter-error gritter-center',
								time: 1000,
							});

							$('#ruc').focus();
							$('#ruc').val("");
		            	} else {
		            		if(data.datosEmpresa.valid == 'true') {
		            			$('#razon_social').val(data.datosEmpresa.razon_social);
					            $('#nombre_comercial').val(data.datosEmpresa.nombre_comercial);
				            	$('#actividad_economica').val(data.datosEmpresa.actividad_economica);
				            	$('#representante_legal').val(data.establecimientos.adicional.representante_legal);
				            	$('#identificacion_representante').val(data.establecimientos.adicional.cedula);				            		
				            }
		            	}
	                }
	            });	
	    	} 
	    }
	    // fin

		//validacion formulario empresa
		$('#form_empresa').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: false,
			ignore: "",
			rules: {
				ruc: {
					required: true,
					digits: true,
					minlength: 13				
				},
				razon_social: {
					required: true				
				},
				nombre_comercial: {
					required: true				
				},
				representante_legal: {
					required: true				
				},
				identificacion_representante: {
					required: true				
				},
				telefono2: {
					required: true,
					minlength: 10				
				},
				ciudad: {
					required: true				
				},
				direccion_matriz: {
					required: true				
				},
				direccion_establecimiento: {
					required: true				
				},
				establecimiento: {
					required: true				
				},
				punto_emision: {
					required: true				
				},	
			},
			messages: {
				ruc: {
					required: "Por favor, Indique una identificación",
					digits: "Por favor, ingrese solo dígitos",
					minlength: "Por favor, Especifique mínimo 13 digitos"
				},
				razon_social: { 	
					required: "Por favor, Indique la Razón Social",			
				},
				nombre_comercial: { 	
					required: "Por favor, Indique Nombre Comercial",			
				},
				representante_legal: { 	
					required: "Por favor, Indique Representante Legal",			
				},
				identificacion_representante: { 	
					required: "Por favor, Indique Identificación Representante",			
				},
				telefono2: {
					required: "Por favor, Indique número celular",
					minlength: "Por favor, Especifique mínimo 10 digitos"
				},
				ciudad: {
					required: "Por favor, Indique una ciudad",
				},
				direccion_matriz: {
					required: "Por favor, Indique Dirección Matriz",
				},
				direccion_establecimiento: {
					required: "Por favor, Indique Dirección Establecimiento",
				},
				establecimiento: {
					required: "Por favor, Indique Código Establecimiento",
				},
				punto_emision: {
					required: "Por favor, Indique Punto Emisión",
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

		// validacion punto
		function ValidPun(e){
		    var key;
		    if (window.event) {
		        key = e.keyCode;
		    }
		    else if (e.which) {
		        key = e.which;
		    }

		    if (key < 48 || key > 57) {
		        if (key === 46 || key === 8)     {
		            return true;
		        } else {
		            return false;
		        }
		    }
		    return true;   
		} 
		// fin   

		// validacion solo numeros
		function ValidNum() {
		    if (event.keyCode < 48 || event.keyCode > 57) {
		        event.returnValue = false;
		    }
		    return true;
		}
		// fin

		// recargar formulario
		function redireccionar() {
			setTimeout(function() {
			    location.reload(true);
			}, 1000);
		}
		// fin

		// datos empresa
		function datos_empresa() {
			$.ajax({
                type: "POST",
                url: "data/empresa/app.php",          
                data:{consulta_empresa:'consulta_empresa'},
                dataType: 'json',
                success: function(data) {
                	if (data == null) {
                		$('#btn_1').attr('disabled', true);	
                	} else {
                		$('#btn_1').attr('disabled', false);
                		$('#btn_0').attr('disabled', true);	

                		$('#id').val(data.id);
                		$('#ruc').val(data.ruc);
                		$('#razon_social').val(data.razon_social);
                		$('#nombre_comercial').val(data.nombre_comercial);
                		$('#actividad_economica').val(data.actividad_economica);
                		$('#representante_legal').val(data.representante_legal);
                		$('#identificacion_representante').val(data.identificacion_representante);
                		$('#telefono1').val(data.telefono1);
                		$('#telefono2').val(data.telefono2);
                		$('#ciudad').val(data.ciudad);
                		$('#direccion_matriz').val(data.direccion_matriz);
                		$('#direccion_establecimiento').val(data.direccion_establecimiento);
                		$('#establecimiento').val(data.establecimiento);
                		$('#punto_emision').val(data.punto_emision);
                		$('#correo').val(data.correo);
                		$('#sitio_web').val(data.sitio_web);
                		$('#slogan').val(data.slogan);
                		$('#observaciones').val(data.observaciones);
                	}
                }
            });		
		}
		// fin

		// validaciones al iniciar
		datos_empresa();
		$('#ruc').focus();
		$("#ruc").attr("maxlength", "13");
    	$("#ruc").keypress(ValidNum);
    	$("#establecimiento").keypress(ValidNum);
    	$("#punto_emision").keypress(ValidNum);
    	// fin

		// guardar formulario
		$('#btn_0').click(function() {
			var respuesta = $('#form_empresa').valid();
			
			if (respuesta == true) {
				$('#btn_0').attr('disabled', true);
				var submit = "btn_gardar";
				var formulario = $("#form_empresa").serialize();

				$.ajax({
			        url: "data/empresa/app.php",
			        data: formulario + "&btn_guardar=" + submit,
			        type: "POST",
			        async: true,
			        success: function (data) {
			        	var val = data;
			        	if(data == '1') {
			        		$.gritter.add({
								title: 'Mensaje',
								text: 'Registro Agregado correctamente <i class="ace-icon fa fa-spinner fa-spin green bigger-125"></i>',
								time: 1000				
							});
							redireccionar();
				    	}              
			        },
			        error: function (xhr, status, errorThrown) {
				        alert("Hubo un problema!");
				        console.log("Error: " + errorThrown);
				        console.log("Status: " + status);
				        console.dir(xhr);
			        }
			    });
			}		 
		});
		// fin

		// modificar formulario
		$('#btn_1').click(function() {
			var respuesta = $('#form_empresa').valid();

			if (respuesta == true) {
				$('#btn_1').attr('disabled', true);
				var submit = "btn_modificar";
				var formulario = $("#form_empresa").serialize();

				$.ajax({
			        url: "data/empresa/app.php",
			        data: formulario + "&btn_modificar=" + submit,
			        type: "POST",
			        async: true,
			        success: function (data) {
			        	var val = data;
			        	if(data == '2') {
			        		$.gritter.add({
								title: 'Mensaje',
								text: 'Registro Modificado correctamente <i class="ace-icon fa fa-spinner fa-spin green bigger-125"></i>',
								time: 1000				
							});
							redireccionar();
				    	}              
			        },
			        error: function (xhr, status, errorThrown) {
				        alert("Hubo un problema!");
				        console.log("Error: " + errorThrown);
				        console.log("Status: " + status);
				        console.dir(xhr);
			        }
			    });
			}
		});
		// fin

		// abrir buscador
		$('#btn_2').click(function() {
			$('#myModal').modal('show');
		});
		// fin

		// refrescar formulario
		$('#btn_3').click(function() {
			location.reload(true);
		});
		// fin
	});
});