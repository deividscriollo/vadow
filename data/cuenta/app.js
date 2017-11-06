app.controller('cuentaController', function ($scope, $route, $location,loaddatosSRI) {
	
	$scope.$route = $route;

	jQuery(function($) {	
		//editables on first profile page
		$.fn.editable.defaults.mode = 'inline';
		$.fn.editableform.loading = "<div class='editableform-loading'><i class='ace-icon fa fa-spinner fa-spin fa-2x light-blue'></i></div>";
	    $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="ace-icon fa fa-check"></i></button>'+
	                                '<button type="button" class="btn editable-cancel"><i class="ace-icon fa fa-times"></i></button>';    

		// funcion sesion
	    function session_datos() {
	        $.ajax({
	            type: "POST",
	            url: "data/cuenta/app.php",
	            data: {session:'session'},
	            dataType: 'json',
	            async: false,
	            success: function(data) {
		            $scope.identificacion = data.identificacion;
		            $scope.nombres = data.nombres;
		            $scope.telefono = data.telefono;
		            $scope.celular = data.celular;
		            $scope.correo = data.correo;
		            $scope.ciudad = data.ciudad;
		            $scope.direccion = data.direccion;
		            $scope.usuario = data.usuario;

		            $("#avatar").attr("src","data/fotos_usuario/imagenes/"+data.imagen);

		            //text editable
				    $('#identificacion').editable({
				    	url: "data/cuenta/app.php",
				    	pk: data.id,
						type: 'text',
						value: data.identificacion,
						name: 'identificacion',
						validate: function(value) {
		                    if($.trim(value) == '') return 'Campo requerido';
		                }
				    });

					$('#nombres').editable({
						url: "data/cuenta/app.php",
						pk: data.id,
						type: 'text',
						value: data.nombres,
						name: 'nombres',
						validate: function(value) {
		                    if($.trim(value) == '') return 'Campo requerido';
		                }
				    });

					$('#telefono').editable({
						url: "data/cuenta/app.php",
						pk: data.id,
						type: 'text',
						value: data.telefono,
						name: 'telefono',
						validate: function(value) {
		                    if($.trim(value) == '') return 'Campo requerido';
		                }
				    });

					$('#celular').editable({
						url: "data/cuenta/app.php",
						pk: data.id,
						type: 'text',
						value: data.celular,
						name: 'celular',
						validate: function(value) {
		                    if($.trim(value) == '') return 'Campo requerido';
		                }
				    });
				
					$('#correo').editable({
						url: "data/cuenta/app.php",
						pk: data.id,
						type: 'text',
						value: data.correo,
						name: 'correo',
						validate: function(value) {
		                    if($.trim(value) == '') return 'Campo requerido';
		                }
				    });

					$('#ciudad').editable({
						url: "data/cuenta/app.php",
						pk: data.id,
						type: 'text',
						value: data.ciudad,
						name: 'ciudad',
						validate: function(value) {
		                    if($.trim(value) == '') return 'Campo requerido';
		                }
				    });

					$('#direccion').editable({
						url: "data/cuenta/app.php",
						pk: data.id,
						type: 'text',
						value: data.direccion,
						name: 'direccion',
						validate: function(value) {
		                    if($.trim(value) == '') return 'Campo requerido';
		                }
				    });

					$('#usuario').editable({
						url: "data/cuenta/app.php",
						pk: data.id,
						type: 'text',
						value: data.usuario,
						name: 'usuario',
						validate: function(value) {
		                    if($.trim(value) == '') return 'Campo requerido';
		                }
				    });
	            }
	        });
	    }
	    // fin

	    session_datos();

	    $('#form_pass').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: false,
			ignore: "",
			rules: {
				actual:{
					required: true,
					remote: {
				        url: "data/cuenta/app.php",
				        type: "post",
				        data: {'verificar_pass':'verificar_pass'}
				      }
				},
				nueva: {
					required: true,
					minlength: 5
				},
				confirme: {
					required: true,
					minlength: 5,
					equalTo: "#nueva"
				},
			},
			messages: {
				actual:{
					required: "Por favor, Campo Requerido.",
					remote:"Error..., La contraseña no coincide.",
				},
				nueva: {
					required: "Por favor, Campo Requerido.",
					minlength: "Por favor, Introduzca al menos 5 caracteres"
				},
				confirme: {
					required: "Por favor, Campo Requerido.",
					minlength: "Por favor, Introduzca al menos 5 caracteres",
					equalTo: "Error, Las contraseñas no coinciden"
				},
			},

			highlight: function (e) {
				$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
			},

			success: function (e) {
				$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
				$(e).remove();
			},

			errorPlacement: function (error, element) {
				if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
					var controls = element.closest('div[class*="col-"]');
					if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
					else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
				}
				else if(element.is('.select2')) {
					error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
				}
				else if(element.is('.chosen-select')) {
					error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
				}
				else error.insertAfter(element.parent());
			},
			submitHandler: function (form) {
				
			}
		});

		// recargar formulario
		function redireccionar() {
			setTimeout(function() {
			    location.reload(true);
			}, 1000);
		}
		// fin

		// guardar formulario
		$('#btn_0').click(function() {
			var respuesta = $('#form_pass').valid();
			
			if (respuesta == true) {
				$('#btn_0').attr('disabled', true);
				var submit = "btn_modificar";
				var formulario = $("#form_pass").serialize();

				$.ajax({
			        url: "data/cuenta/app.php",
			        data: formulario + "&btn_modificar=" + submit,
			        type: "POST",
			        async: true,
			        success: function (data) {
			        	var val = data;
			        	if(data == '1') {
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
	});
});