app.controller('proformasController', function ($scope, $interval) {

	var combo_productos = '';
	var combo_clientes = '';

	// procesos tab
	$scope.tab = 1;

    $scope.setTab = function(newTab) {
      $scope.tab = newTab;
    };

    $scope.isSet = function(tabNum) {
      return $scope.tab == tabNum;
    };
    // fin

    // formato totales
    var formatNumber = {
		separador: ".", // separador para los miles
	 	sepDecimal: '.', // separador para los decimales
	 	formatear:function (num) {
	  	num +='';
	  	var splitStr = num.split('.');
	  	var splitLeft = splitStr[0];
	  	var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
	  	var regx = /(\d+)(\d{3})/;
	  	while (regx.test(splitLeft)) {
	  		splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
	  		}
	  	return this.simbol + splitLeft  +splitRight;
	 	},
	 	new:function(num, simbol){
	  		this.simbol = simbol ||'';
	  	return this.formatear(num);
	 	}
	}
	// fin

    // para horas 
    function show() {
	    var Digital = new Date();
	    var hours = Digital.getHours();
	    var minutes = Digital.getMinutes();
	    var seconds = Digital.getSeconds();
	    var dn = "AM";    
	    if (hours > 12) {
	        dn = "PM";
	        hours = hours - 12;
	    }
	    if (hours == 0)
	        hours = 12;
	    if (minutes <= 9)
	        minutes = "0" + minutes;
	    if (seconds <= 9)
	        seconds = "0" + seconds;
	    $("#hora_actual").val(hours + ":" + minutes + ":" + seconds + " " + dn);
	}

	$interval(function() {
		show();
	}, 1000);
	// fin

	jQuery(function($) {
		$('[data-toggle="tooltip"]').tooltip();
		
		//para la fecha del calendario
		$(".datepicker").datepicker({ 
			format: "yyyy-mm-dd",
	        autoclose: true
		}).datepicker("setDate","today");
		// fin

		// stilo select2
		$(".select2").css({
		    'width': '100%',
		    allow_single_deselect: true,
		    no_results_text: "No se encontraron resultados",
		    allowClear: true,
		});
		// fin

		// limpiar select2
		$("#select_tipo_precio").select2({
		  	// allowClear: true
		});
		// fin

		// select tipo precio 
	    $("#select_tipo_precio").change(function () { 
	    	var valor = $(this).val();

	    	if (valor == "MINORISTA") {
	    		limpiar_input();
	    		$('#codigo_barras').focus();
	    	} else {
	    		if (valor == "MAYORISTA") {
	    			limpiar_input();
	    			$('#codigo_barras').focus();
	    		}
	    	}
	    });	
	    // fin

	    // limpiar ruc
	    $("#ruc").keyup(function(e) {
		    if($('#ruc').val() == '') {
		    	$('#id_cliente').val('');
		    	$('#cliente').val('');
		    	$('#direccion').val('');
		    	$('#telefono').val('');
		    	$('#correo').val('');
		    }
		});
	    // fin

	    // limpiar cliente
	    $("#cliente").keyup(function(e) {
		    if($('#cliente').val() == '') {
		    	$('#id_cliente').val('');
		    	$('#ruc').val('');
		    	$('#direccion').val('');
		    	$('#telefono').val('');
		    	$('#correo').val('');
		    }
		});
	    // fin

	    // combo datos proveedores
	    function combo1(tipo) {
	        $.ajax({
	            type: "POST",
	            url: "data/proformas/app.php",
	            data: {buscador_clientes:'buscador_clientes',tipo_busqueda:tipo},        
	            success: function(resp) {         
	                combo_clientes = JSON.parse(resp);        
	            }
	        });    
	        return combo_clientes;
	    }
	    // fin

		// busqueda cliente ruc
		$("#ruc").keyup(function(e) {
			var tipo = 'ruc';
	     	var res = combo1(tipo);

	     	$("#ruc").autocomplete({
                source: function (req, response) {                    
                    var results = $.ui.autocomplete.filter(res, req.term);                    
                    response(results.slice(0, 20));
                },
                minLength: 1,
                focus: function(event, ui) {
	                $("#id_cliente").val(ui.item.id); 
		            $("#ruc").val(ui.item.value); 
		            $("#cliente").val(ui.item.cliente);
		            $("#direccion").val(ui.item.direccion);
		            $("#telefono").val(ui.item.telefono);
		            $("#correo").val(ui.item.correo);

                	return false;
                },
                select: function(event, ui) {
                	$("#id_cliente").val(ui.item.id); 
		            $("#ruc").val(ui.item.value); 
		            $("#cliente").val(ui.item.cliente);
		            $("#direccion").val(ui.item.direccion);
		            $("#telefono").val(ui.item.telefono);
		            $("#correo").val(ui.item.correo);

	                return false;
                }

                }).data("ui-autocomplete")._renderItem = function(ul, item) {
                return $("<li>")
                .append("<a>" + item.value + "</a>")
                .appendTo(ul);
            };
		});
		// fin

		// busqueda proveedores nombre
		$("#cliente").keyup(function(e) {
			var tipo = 'cliente';
	     	var res = combo1(tipo);

	     	$("#cliente").autocomplete({
                source: function (req, response) {                    
                    var results = $.ui.autocomplete.filter(res, req.term);                    
                    response(results.slice(0, 20));
                },
                minLength: 1,
                focus: function(event, ui) {
	                $("#id_cliente").val(ui.item.id); 
		            $("#cliente").val(ui.item.value); 
		            $("#ruc").val(ui.item.ruc);
		            $("#direccion").val(ui.item.direccion);
		            $("#telefono").val(ui.item.telefono);
		            $("#correo").val(ui.item.correo);

                	return false;
                },
                select: function(event, ui) {
                	$("#id_cliente").val(ui.item.id); 
		            $("#cliente").val(ui.item.value); 
		            $("#ruc").val(ui.item.ruc);
		            $("#direccion").val(ui.item.direccion);
		            $("#telefono").val(ui.item.telefono);
		            $("#correo").val(ui.item.correo);
	                
	                return false;
                }

                }).data("ui-autocomplete")._renderItem = function(ul, item) {
                return $("<li>")
                .append("<a>" + item.value + "</a>")
                .appendTo(ul);
            };
		});
		// fin

		// limpiar imputs
	    function limpiar_input() {
	    	$('#id_producto').val('');
	    	$('#codigo_barras').val('');
	    	$('#codigo').val('');
	    	$('#producto').val('');
	    	$('#cantidad').val('');
	    	$('#precio_venta').val('');
	    	$('#precio_costo').val('');
	    	$('#descuento').val('');
	    	$('#stock').val('');
		    $('#iva_producto').val('');
		    $('#incluye').val('');
	    }
	    // fin

	    // limpiar codigo
	    $("#codigo").keyup(function(e) {
		    if($('#codigo').val() == '') {
		    	$('#id_producto').val('');
		    	$('#codigo_barras').val('');
		    	$('#producto').val('');
		    	$('#cantidad').val('');
		    	$('#precio_venta').val('');
	    		$('#precio_costo').val('');
		    	$('#descuento').val('');
		    	$('#stock').val('');
		    	$('#iva_producto').val('');
		    	$('#incluye').val('');
		    }
		});
	    // fin

	    // limpiar descripcion
	    $("#producto").keyup(function(e) {
		    if($('#producto').val() == '') {
		    	$('#id_producto').val('');
		    	$('#codigo_barras').val('');
		    	$('#codigo').val('');
		    	$('#cantidad').val('');
		    	$('#precio_venta').val('');
	    		$('#precio_costo').val('');
		    	$('#descuento').val('');
		    	$('#stock').val('');
		    	$('#iva_producto').val('');
		    	$('#incluye').val('');
		    }
		});
	    // fin

	    // buscar productos codigo barras
	    $("#codigo_barras").change(function(e) {
	        barras();
	    });

	    function barras() {
	    	var codigo_barras = $("#codigo_barras").val();
	        var precio = $("#select_tipo_precio").val(); 
	        
            $.getJSON('data/proformas/search.php?codigo_barras=' + codigo_barras + '&tipo_precio=' + precio, function(data) {
            	if(data == null) {
					swal({
		                title: "Lo sentimos Articulo no Creado",
		                type: "warning",
		            });
		            limpiar_input();
				} else {
	            	$("#id_producto").val(data.id);
	                $("#codigo_barras").val(data.codigo_barras);
	                $("#codigo").val(data.codigo);
	                $("#producto").val(data.producto);
	                $("#precio_costo").val(data.precio_costo);
	        		$("#precio_venta").val(data.precio_venta);
	                $("#descuento").val(data.descuento);
	                $("#stock").val(data.stock);
	                $("#iva_producto").val(data.iva_producto);
	                $("#incluye").val(data.incluye);
	                $('#cantidad').focus();
	            }
            });   
	    } 
	    // fin

	    // combo datos productos
	    function combo2(tipo, precio) {
	        $.ajax({
	            type: "POST",
	            url: "data/proformas/app.php",
	            data: {buscador_productos:'buscador_productos',tipo_busqueda:tipo,tipo_precio:precio},        
	            success: function(resp) {         
	                combo_productos = JSON.parse(resp);        
	            }
	        });    
	        return combo_productos;
	    }
	    // fin

	    // buscar productos codigo
	    $("#codigo").keyup(function(e) {
	    	var tipo = 'codigo';
	     	var precio = $("#select_tipo_precio").val();
	     	var res = combo2(tipo,precio);

	     	$("#codigo").autocomplete({
                source: function (req, response) {                    
                    var results = $.ui.autocomplete.filter(res, req.term);                    
                    response(results.slice(0, 20));
                },
                minLength: 1,
                focus: function(event, ui) {
	                $("#id_producto").val(ui.item.id);	
	                $("#codigo_barras").val(ui.item.codigo_barras);
	                $("#codigo").val(ui.item.value);
	                $("#producto").val(ui.item.producto);
	                $("#precio_costo").val(ui.item.precio_costo);
	            	$("#precio_venta").val(ui.item.precio_venta);
	                $("#descuento").val(ui.item.descuento);
	                $("#stock").val(ui.item.stock);
	                $("#iva_producto").val(ui.item.iva_producto);
	                $("#incluye").val(ui.item.incluye);

                	return false;
                },
                select: function(event, ui) {
                	$("#id_producto").val(ui.item.id);
	                $("#codigo_barras").val(ui.item.codigo_barras);
	                $("#codigo").val(ui.item.value);
	                $("#producto").val(ui.item.producto);
	                $("#precio_costo").val(ui.item.precio_costo);
	            	$("#precio_venta").val(ui.item.precio_venta);
	                $("#descuento").attr(ui.item.descuento);
	                $("#stock").val(ui.item.stock);
	                $("#iva_producto").val(ui.item.iva_producto);
	                $("#incluye").val(ui.item.incluye);
	                $('#cantidad').focus();

	                return false;
                }

                }).data("ui-autocomplete")._renderItem = function(ul, item) {
                return $("<li>")
                .append("<a>" + item.value + "</a>")
                .appendTo(ul);
            };
	    });
	    // fin

	    // buscar productos descripcion
	    $("#producto").keyup(function(e) {
	    	var tipo = 'producto';
	     	var precio = $("#select_tipo_precio").val();
	     	var res = combo2(tipo,precio);

	     	$("#producto").autocomplete({
                source: function (req, response) {                    
                    var results = $.ui.autocomplete.filter(res, req.term);                    
                    response(results.slice(0, 20));
                },
                minLength: 1,
                focus: function(event, ui) {
	                $("#id_producto").val(ui.item.id);	
	                $("#codigo_barras").val(ui.item.codigo_barras);
	                $("#codigo").val(ui.item.codigo);
	                $("#producto").val(ui.item.value);
	                $("#precio_costo").val(ui.item.precio_costo);
	            	$("#precio_venta").val(ui.item.precio_venta);
	                $("#descuento").val(ui.item.descuento);
	                $("#stock").val(ui.item.stock);
	                $("#iva_producto").val(ui.item.iva_producto);
	                $("#incluye").val(ui.item.incluye);

                	return false;
                },
                select: function(event, ui) {
                	$("#id_producto").val(ui.item.id);
	                $("#codigo_barras").val(ui.item.codigo_barras);
	                $("#codigo").val(ui.item.codigo);
	                $("#producto").val(ui.item.value);
	                $("#precio_costo").val(ui.item.precio_costo);
	            	$("#precio_venta").val(ui.item.precio_venta);
	                $("#descuento").attr(ui.item.descuento);
	                $("#stock").val(ui.item.stock);
	                $("#iva_producto").val(ui.item.iva_producto);
	                $("#incluye").val(ui.item.incluye);

	                $('#cantidad').focus();
	                return false;
                }

                }).data("ui-autocomplete")._renderItem = function(ul, item) {
                return $("<li>")
                .append("<a>" + item.value + "</a>")
                .appendTo(ul);
            };
	    });
	    // fin

	    /*---agregar a la tabla---*/
	  	$("#cantidad").on("keypress",function (e) {
	  		if(e.keyCode == 13) {//tecla del alt para el entrer poner 13 
			    var subtotal0 = 0;
			    var subtotal12 = 0;
			    var subtotal_total = 0;
			    var iva12 = 0;
			    var total_total = 0;
			    var descu_total = 0;

		        if ($("#codigo").val() == "") {
		            $("#codigo").focus();
		            $.gritter.add({
						title: 'Error... Ingrese un Producto',
						class_name: 'gritter-error gritter-center',
						time: 1000,
					});
		        } else {
		            if ($("#producto").val() == "") {
		                $("#producto").focus();
		                $.gritter.add({
							title: 'Error... Ingrese un Producto',
							class_name: 'gritter-error gritter-center',
							time: 1000,
						});
		            } else {
		                if ($("#cantidad").val() == "") {
		                    $("#cantidad").focus();
		                    $.gritter.add({
								title: 'Error... Ingrese una Cantidad',
								class_name: 'gritter-error gritter-center',
								time: 1000,
							});
		                } else {
		                    if ($("#precio_venta").val() == "") {
		                        $("#precio_venta").focus();
		                        $.gritter.add({
									title: 'Error... Ingrese un Precio',
									class_name: 'gritter-error gritter-center',
									time: 1000,
								});
			                } else {
			                    var filas = jQuery("#table").jqGrid("getRowData");
			                    var descuento = 0;
			                    var total = 0;
			                    var desc = 0;
			                    var precio = 0;
			                    var multi = 0;
			                    var flotante = 0;
			                    var resultado = 0;
			                    var repe = 0;
			                    var suma = 0;
			                  
			                    if (filas.length == 0) {
			                        if ($("#descuento").val() != "") {
			                            desc = $("#descuento").val();
			                            precio = (parseFloat($("#precio_venta").val())).toFixed(3);
			                            multi = (parseFloat($("#cantidad").val()) * parseFloat(precio)).toFixed(3);
			                            descuento = ((multi * parseFloat(desc)) / 100);
			                            flotante = parseFloat(descuento);
			                            resultado = (Math.round(flotante * Math.pow(10,2)) / Math.pow(10,2)).toFixed(3);
			                            total = (multi - resultado).toFixed(3);
			                        } else {
			                            desc = 0;
			                            precio = (parseFloat($("#precio_venta").val())).toFixed(3);
			                            multi = (parseFloat($("#cantidad").val()) * parseFloat(precio)).toFixed(3);
			                            descuento = ((multi * parseFloat(desc)) / 100);
			                            flotante = parseFloat(descuento);
			                            resultado = (Math.round(flotante * Math.pow(10,2)) / Math.pow(10,2)).toFixed(3);
			                            total = (parseFloat(multi)).toFixed(3);
			                        }

			                        var datarow = {
			                            id: $("#id_producto").val(), 
			                            codigo: $("#codigo").val(), 
			                            detalle: $("#producto").val(), 
			                            cantidad: $("#cantidad").val(), 
			                            precio_u: precio, 
			                            descuento: desc,
			                            cal_des: resultado, 
			                            total: total, 
			                            iva: $("#iva_producto").val(),
			                            incluye: $("#incluye").val()
			                        };

			                        jQuery("#table").jqGrid('addRowData', $("#id_producto").val(), datarow);
			                        limpiar_input();
			                    } else {
			                        for (var i = 0; i < filas.length; i++) {
			                            var id = filas[i];

			                            if (id['id'] == $("#id_producto").val()) {
			                                repe = 1;
			                                var can = id['cantidad'];
			                            }
			                        }

			                        if (repe == 1) {
			                            suma = parseInt(can) + parseInt($("#cantidad").val());

			                            if ($("#descuento").val() != "") {
			                                desc = $("#descuento").val();
			                                precio = (parseFloat($("#precio_venta").val())).toFixed(3);
			                                multi = (parseFloat(suma) * parseFloat(precio)).toFixed(3);
			                                descuento = ((multi * parseFloat(desc)) / 100);
			                                flotante = parseFloat(descuento);
			                                resultado = (Math.round(flotante * Math.pow(10,2)) / Math.pow(10,2)).toFixed(3);
			                                total = (multi - resultado).toFixed(3);
			                            } else {
			                                desc = 0;
			                                precio = (parseFloat($("#precio_venta").val())).toFixed(3);
			                                multi = (parseFloat($("#cantidad").val()) * parseFloat(precio)).toFixed(3);
			                                descuento = ((multi * parseFloat(desc)) / 100);
			                                flotante = parseFloat(descuento);
			                                resultado = (Math.round(flotante * Math.pow(10,2)) / Math.pow(10,2)).toFixed(3);
			                                total = (parseFloat(multi)).toFixed(3);
			                            }

			                            datarow = {
			                                id: $("#id_producto").val(), 
			                                codigo: $("#codigo").val(), 
			                                detalle: $("#producto").val(), 
			                                cantidad: suma, 
			                                precio_u: precio, 
			                                descuento: desc,
			                                cal_des: resultado,  
			                                total: total, 
			                                iva: $("#iva_producto").val(),
			                                incluye: $("#incluye").val()
			                            };

			                            jQuery("#table").jqGrid('setRowData', $("#id_producto").val(), datarow);
			                            limpiar_input();
			                        } else {
			                            if(filas.length < 26) {
			                                if ($("#descuento").val() != "") {
			                                    desc = $("#descuento").val();
			                                    precio = (parseFloat($("#precio_venta").val())).toFixed(3);
			                                    multi = (parseFloat($("#cantidad").val()) * parseFloat(precio)).toFixed(3);
			                                    descuento = ((multi * parseFloat(desc)) / 100);
			                                    flotante = parseFloat(descuento) ;
			                                    resultado = (Math.round(flotante * Math.pow(10,2)) / Math.pow(10,2)).toFixed(3);
			                                    total = (multi - resultado).toFixed(3);
			                                } else {
			                                    desc = 0;
			                                    precio = (parseFloat($("#precio_venta").val())).toFixed(3);
			                                    multi = (parseFloat($("#cantidad").val()) * parseFloat(precio)).toFixed(3);
			                                    descuento = ((multi * parseFloat(desc)) / 100);
			                                    flotante = parseFloat(descuento);
			                                    resultado = (Math.round(flotante * Math.pow(10,2)) / Math.pow(10,2)).toFixed(3);
			                                    total = (parseFloat(multi)).toFixed(3);
			                                }
			                            
			                                datarow = {
			                                    id: $("#id_producto").val(), 
			                                    codigo: $("#codigo").val(), 
			                                    detalle: $("#producto").val(), 
			                                    cantidad: $("#cantidad").val(), 
			                                    precio_u: precio, 
			                                    descuento: desc, 
			                                    cal_des: resultado,
			                                    total: total, 
			                                    iva: $("#iva_producto").val(), 
			                                    incluye: $("#incluye").val()
			                                };

			                                jQuery("#table").jqGrid('addRowData', $("#id_producto").val(), datarow);
			                                limpiar_input();
			                            } else {
			                                $.gritter.add({
												title: 'Error... Alcanzo el limite Máximo de Items',
												class_name: 'gritter-error gritter-center',
												time: 1000,
											});
			                            }
			                        }
			                    }
			                    
			                    // proceso incluye iva
			                    var fil = jQuery("#table").jqGrid("getRowData");
			                    var subtotal = 0;
			                    var sub = 0;
			                    var sub1 = 0;
			                    var sub2 = 0;
			                    var iva = 0;
			                    var iva1 = 0;
			                    var iva2 = 0;
			                    var suma_total = 0;
			                    // fin                                                     
			                    
			                    var fil = jQuery("#table").jqGrid("getRowData");
			                    for (var t = 0; t < fil.length; t++) {
			                        var dd = fil[t];
			                        if (dd['iva'] != 0) {
			                            if(dd['incluye'] == "NO") {
			                                subtotal = dd['total'];
			                                sub1 = subtotal;
			                                iva1 = parseFloat(sub1 * dd['iva'] / 100).toFixed(3);                                          

			                                subtotal0 = parseFloat(subtotal0) + 0;
			                                subtotal12 = parseFloat(subtotal12) + parseFloat(sub1);
			                                subtotal_total = parseFloat(subtotal0) + parseFloat(subtotal12);
			                                descu_total = parseFloat(descu_total) + parseFloat(dd['cal_des']);
			                                iva12 = parseFloat(iva12) + parseFloat(iva1);
			                            
			                                subtotal0 = parseFloat(subtotal0).toFixed(3);
			                                subtotal12 = parseFloat(subtotal12).toFixed(3);
			                                subtotal_total = parseFloat(subtotal_total).toFixed(3);
			                                iva12 = parseFloat(iva12).toFixed(3);
			                                descu_total = parseFloat(descu_total).toFixed(3);
			                                suma_total = suma_total + parseFloat(dd['cantidad']);
			                            } else {
			                                if(dd['incluye'] == "SI") {
			                                    subtotal = dd['total'];
			                                    sub2 = parseFloat(subtotal / ((dd['iva']/100)+1)).toFixed(3);
			                                    iva2 = parseFloat(sub2 * dd['iva'] / 100).toFixed(3);

			                                    subtotal0 = parseFloat(subtotal0) + 0;
			                                    subtotal12 = parseFloat(subtotal12) + parseFloat(sub2);
			                                    subtotal_total = parseFloat(subtotal0) + parseFloat(subtotal12);
			                                    iva12 = parseFloat(iva12) + parseFloat(iva2);
			                                    descu_total = parseFloat(descu_total) + parseFloat(dd['cal_des']);

			                                    subtotal0 = parseFloat(subtotal0).toFixed(3);
			                                    subtotal12 = parseFloat(subtotal12).toFixed(3);
			                                    subtotal_total = parseFloat(subtotal_total).toFixed(3);
			                                    iva12 = parseFloat(iva12).toFixed(3);
			                                    descu_total = parseFloat(descu_total).toFixed(3);
			                                    suma_total = suma_total + parseFloat(dd['cantidad']);
			                                }
			                            }
			                        } else {
			                            if (dd['iva'] == 0) {                                               
			                                subtotal = dd['total'];
			                                sub = subtotal;

			                                subtotal0 = parseFloat(subtotal0) + parseFloat(sub);
			                                subtotal12 = parseFloat(subtotal12) + 0;
			                                subtotal_total = parseFloat(subtotal0) + parseFloat(subtotal12);
			                                iva12 = parseFloat(iva12) + 0;
			                                descu_total = parseFloat(descu_total) + parseFloat(dd['cal_des']);
			                                
			                                subtotal0 = parseFloat(subtotal0).toFixed(3);
			                                subtotal12 = parseFloat(subtotal12).toFixed(3);
			                                subtotal_total = parseFloat(subtotal_total).toFixed(3);
			                                iva12 = parseFloat(iva12).toFixed(3);
			                                descu_total = parseFloat(descu_total).toFixed(3);
			                                suma_total = suma_total + parseFloat(dd['cantidad']);                                  
			                            }       
			                        }
			                    } 

			                    total_total = parseFloat(total_total) + (parseFloat(subtotal0) + parseFloat(subtotal12) + parseFloat(iva12));
			                    total_total = parseFloat(total_total).toFixed(2);

			                    $("#subtotal").val(subtotal_total);
			                    $("#tarifa").val(subtotal12);
			                    $("#tarifa_0").val(subtotal0);
			                    $("#iva").val(iva12);
			                    $("#otros").val(descu_total);
			                    $("#total_pagar").val(total_total);
			                    $("#items").val(fil.length);
				                $("#num").val(suma_total);
			                    $("#codigo_barras").focus();
		                    }
		                }
		            }
		        }
		    }
	  	});

		// validacion punto
		function ValidPun() {
		    var key;
		    if (window.event) {
		        key = event.keyCode;
		    } else if (event.which) {
		        key = event.which;
		    }

		    if (key < 48 || key > 57) {
		        if (key === 46 || key === 8) {
		            return true;
		        } else {
		            return false;
		        }
		    }
		    return true;
		}
		// fin

		// funcion validar solo numeros
		function ValidNum() {
		    if (event.keyCode < 48 || event.keyCode > 57) {
		        event.returnValue = false;
		    }
		    return true;
		}
		// fin

		// abrir en una nueva ventana reporte facturas
		$scope.methodspdf = function(id) { 
			var myWindow = window.open('data/reportes/proforma.php?hoja=A5&id='+id,'popup','width=900,height=650');
		} 
		// fin

		$scope.methodoshare = function(id) {
			var $exampleModal = $("#myModal2"),
		    $exampleModalClose = $(".modal-header button");

		    $exampleModal.on("shown.bs.modal", function() {
		        document.activeElement.blur();
		        
		        $('#link').val('http://localhost/facturacion/data/reportes/proforma.php?id='+id);
		        $('#link').focus();
		        $('#link').select();
		    });
		}

		// recargar formulario
		function redireccionar() {
			setTimeout(function() {
			    location.reload(true);
			}, 1000);
		}
		// fin

		// inicio llamado funciones
		$("#cantidad").keypress(ValidNum);
		$("#precio_venta").keypress(ValidPun);
		$("#btn_1").attr("disabled", true);
		$("#btn_2").attr("disabled", true);
		$("#btn_3").attr("disabled", true);

		// guardar proforma
		$('#btn_0').click(function() {
			var formulario = $("#form_proforma").serialize();
			var submit = "btn_guardar";
			var filas = jQuery("#table").jqGrid("getRowData");

			if($('#id_cliente').val() == '') {
				$('#ruc').focus();
				$.gritter.add({
					title: 'Seleccione un Cliente',
					class_name: 'gritter-error gritter-center',
					time: 1000,
				});	
			} else {
				if($('#select_tipo_precio').val() == '') {
					$.gritter.add({
						title: 'Seleccione un Tipo Precio',
						class_name: 'gritter-error gritter-center',
						time: 1000,
					});	
				} else {
					if(filas.length == 0) {
		                $.gritter.add({
							title: 'Ingrese productos a la Proforma',
							class_name: 'gritter-error gritter-center',
							time: 1000,
						});
		                $('#codigo').focus();	
		            } else {
		            	$("#btn_0").attr("disabled", true);
		                var v1 = new Array();
		                var v2 = new Array();
		                var v3 = new Array();
		                var v4 = new Array();
		                var v5 = new Array();

		                var string_v1 = "";
		                var string_v2 = "";
		                var string_v3 = "";
		                var string_v4 = "";
		                var string_v5 = "";

		                for (var i = 0; i < filas.length; i++) {
		                    var datos = filas[i];
		                    v1[i] = datos['id'];
		                    v2[i] = datos['cantidad'];
		                    v3[i] = datos['precio_u'];
		                    v4[i] = datos['descuento'];
		                    v5[i] = datos['total'];
		                }

		                for (i = 0; i < filas.length; i++) {
		                    string_v1 = string_v1 + "|" + v1[i];
		                    string_v2 = string_v2 + "|" + v2[i];
		                    string_v3 = string_v3 + "|" + v3[i];
		                    string_v4 = string_v4 + "|" + v4[i];
		                    string_v5 = string_v5 + "|" + v5[i];
		                }

		                $.ajax({
		                    type: "POST",
		                    url: "data/proformas/app.php",
		                    data: formulario +"&btn_guardar=" + submit + "&campo1=" + string_v1 + "&campo2=" + string_v2 + "&campo3=" + string_v3 + "&campo4=" + string_v4 + "&campo5=" + string_v5,
		                    success: function(data) {
		                    	var id = data;
				        		bootbox.alert("Gracias! Por su Información Proforma Agregada Correctamente!", function() {
								  	var myWindow = window.open('data/reportes/proforma.php?hoja=A5&id='+id,'popup','width=900,height=650'); 
								  	location.reload();
								});
		                    }
		                });
					}        
				}
			}	
		});
		// fin

		// anular proforma
		$('#btn_2').click(function() {
			var formulario = $("#form_proforma").serialize();
			var submit = "btn_anular";

			$.ajax({
                type: "POST",
                url: "data/proformas/app.php",
                data: formulario +"&btn_anular=" + submit,
                success: function(data) {
                	var val = data;
                	if(val == 1) {
                		bootbox.alert("Gracias! Por su Información Proforma Anulada Correctamente!", function() {
							location.reload();
						});	
                	}		
                }
            });
		});
		// fin

		// reimprimir proformas
		$('#btn_3').click(function() {
			if($('#id_proforma').val() == '') {
				$.gritter.add({
					title: 'Seleccione Proforma a Reimprimir',
					class_name: 'gritter-error gritter-center',
					time: 1000,
				});	
			} else {
				var id = $('#id_proforma').val();
				var myWindow = window.open('data/reportes/proforma.php?hoja=A5&id='+id,'popup','width=900,height=650');
			}
		});
		// fin

		// actualizar formulario
		$('#btn_4').click(function() {
			location.reload();
		});
		// fin
	});
	// fin
	
	/*jqgrid table 1 local*/    
	jQuery(function($) {
	    var grid_selector = "#table";
	    var pager_selector = "#pager";
	    
	    $(window).on('resize.jqGrid', function () {
			$(grid_selector).jqGrid('setGridWidth', $("#grid_container").width(), true);
	    }).trigger('resize');  

	    var parent_column = $(grid_selector).closest('[class*="col-"]');
		$(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
			if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed') {
				setTimeout(function() {
					$(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
				}, 0);
			}
	    })

	    // tabla local facturas
	    jQuery(grid_selector).jqGrid({	        
	        autoencode: false,
	        datatype: "local",
	        colNames: ['','ID','CÓDIGO','DESCRIPCIÓN','CANTIDAD','PVP','DESCUENTO','CALCULADO','VALOR TOTAL','IVA','INCLUYE'],
	        colModel:[  
	        	{name:'myac', width: 50, fixed: true, sortable: false, resize: false, formatter: 'actions',
			        formatoptions: {keys: false, delbutton: true, editbutton: false}
			    }, 
			    {name: 'id',index:'id', frozen:true, align:'left', search:false, hidden: true},   
	            {name: 'codigo', index: 'codigo', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center', frozen: true, width: 100},
	            {name: 'detalle', index: 'detalle', editable: false, frozen: true, editrules: {required: true}, align: 'center', width: 290},
	            {name: 'cantidad', index: 'cantidad', editable: true, frozen: true, editrules: {required: true}, align: 'center', width: 70, editoptions:{maxlength: 10, size:15,dataInit: function(elem){$(elem).bind("keypress", function(e) {return numeros(e)})}}}, 
	            {name: 'precio_u', index: 'precio_u', editable: true, search: false, frozen: true, editrules: {required: true}, align: 'center', width: 110, editoptions:{maxlength: 10, size:15,dataInit: function(elem){$(elem).bind("keypress", function(e) {return punto(e)})}}}, 
	            {name: 'descuento', index: 'descuento', editable: false, frozen: true, editrules: {required: true}, align: 'center', width: 70},
	            {name: 'cal_des', index: 'cal_des', editable: false, hidden: true, frozen: true, editrules: {required: true}, align: 'center', width: 90},
	            {name: 'total', index: 'total', editable: false, search: false, frozen: true, editrules: {required: true}, align: 'center', width: 110},
	            {name: 'iva', index: 'iva', align: 'center', width: 100, hidden: true},
	            {name: 'incluye', index: 'incluye', editable: false, hidden: true, frozen: true, editrules: {required: true}, align: 'center', width: 90}
	        ],          
	        rowNum: 10,       
	        width:600,
	        shrinkToFit: false,
	        height:330,
	        rowList: [10,20,30],
	        pager: pager_selector,        
	        sortname: 'id',
	        sortorder: 'asc',
	        altRows: true,
	        multiselect: false,
	        viewrecords : true,
	        shrinkToFit: true,
	        delOptions: {
            	modal: true,
	            jqModal: true,
	            onclickSubmit: function(rp_ge, rowid) {
	                var id = jQuery(grid_selector).jqGrid('getGridParam', 'selrow');
	                jQuery(grid_selector).jqGrid('restoreRow', id);
	                var ret = jQuery(grid_selector).jqGrid('getRowData', id);

	                var subtotal0 = 0;
	                var subtotal12 = 0;
	                var subtotal_total = 0;
	                var iva12 = 0;
	                var total_total = 0;
	                var descu_total = 0;

	                var subtotal = 0;
	                var sub = 0;
	                var sub1 = 0;
	                var sub2 = 0;
	                var iva = 0;
	                var iva1 = 0;
	                var iva2 = 0;
	                var suma_total = 0;

	                var filas = jQuery(grid_selector).jqGrid("getRowData"); 

	                for (var t = 0; t < filas.length; t++) {
	                    if(ret.iva != 0) {
	                      	if(ret.incluye == "NO") {
		                        subtotal = ret.total;
		                        sub1 = subtotal;
		                        iva1 = parseFloat(sub1 * ret.iva / 100).toFixed(3);                                          

		                        subtotal0 = parseFloat($("#tarifa_0").val()) + 0;
		                        subtotal12 = parseFloat($("#tarifa").val()) - parseFloat(sub1);
		                        subtotal_total = parseFloat($("#subtotal").val()) - parseFloat(sub1);
		                        iva12 = parseFloat($("#iva").val()) - parseFloat(iva1);
		                        descu_total = parseFloat($("#otros").val()) - parseFloat(ret.cal_des);

		                        subtotal0 = parseFloat(subtotal0).toFixed(3);
		                        subtotal12 = parseFloat(subtotal12).toFixed(3);
		                        subtotal_total = parseFloat(subtotal_total).toFixed(3);
		                        iva12 = parseFloat(iva12).toFixed(3);
		                        descu_total = parseFloat(descu_total).toFixed(3);
		                        suma_total = parseFloat($("#num").val()) - parseFloat(ret.cantidad);
		                    } else {
		                        if(ret.incluye == "SI") {
		                            subtotal = ret.total;
		                            sub2 = parseFloat(subtotal / ((ret.iva/100)+1)).toFixed(3);
		                            iva2 = parseFloat(sub2 * ret.iva / 100).toFixed(3);

		                            subtotal0 = parseFloat($("#tarifa_0").val()) + 0;
		                            subtotal12 = parseFloat($("#tarifa").val()) - parseFloat(sub2);
		                            subtotal_total = parseFloat($("#subtotal").val()) - parseFloat(sub2);
		                            iva12 = parseFloat($("#iva").val()) - parseFloat(iva2);
		                            descu_total = parseFloat($("#otros").val()) - parseFloat(ret.cal_des);

		                            subtotal0 = parseFloat(subtotal0).toFixed(3);
		                            subtotal12 = parseFloat(subtotal12).toFixed(3);
		                            subtotal_total = parseFloat(subtotal_total).toFixed(3);
		                            iva12 = parseFloat(iva12).toFixed(3);
		                            descu_total = parseFloat(descu_total).toFixed(3);
		                            suma_total = parseFloat($("#num").val()) - parseFloat(ret.cantidad);
		                        }
	                        }
	                    } else {
	                        if (ret.iva == 0) {
	                            subtotal = ret.total;
	                            sub = subtotal;

	                            subtotal0 = parseFloat($("#tarifa_0").val()) - parseFloat(sub);
	                            subtotal12 = parseFloat($("#tarifa").val()) + 0;
	                            subtotal_total = parseFloat($("#subtotal").val()) - parseFloat(sub);
	                            iva12 = parseFloat($("#iva").val()) + 0;
	                            descu_total = parseFloat($("#otros").val()) - parseFloat(ret.cal_des);
	                          
	                            subtotal0 = parseFloat(subtotal0).toFixed(3);
	                            subtotal12 = parseFloat(subtotal12).toFixed(3);
	                            subtotal_total = parseFloat(subtotal_total).toFixed(3);
	                            iva12 = parseFloat(iva12).toFixed(3);
	                            descu_total = parseFloat(descu_total).toFixed(3);
	                            suma_total = parseFloat($("#num").val()) - parseFloat(ret.cantidad);
	                        }
	                    }
	                }

	                total_total = parseFloat(total_total) + (parseFloat(subtotal0) + parseFloat(subtotal12) + parseFloat(iva12));
	                total_total = parseFloat(total_total).toFixed(2);

	                var item = filas.length - 1;
	                $("#subtotal").val(subtotal_total);
	                $("#tarifa_0").val(subtotal0);
	                $("#tarifa").val(subtotal12);
	                $("#iva").val(iva12);
	                $("#otros").val(descu_total);
	                $("#total_pagar").val(total_total);
	                $("#items").val(item);
                	$("#num").val(suma_total);
                
	                var su = jQuery(grid_selector).jqGrid('delRowData', rowid);
	                   if (su == true) {
	                       rp_ge.processing = true;
	                       $(".ui-icon-closethick").trigger('click'); 
	                   	}
	                return true;
	            },
	            processing: true
	        },
	        loadComplete : function() {
	            var table = this;
	            setTimeout(function(){
	                styleCheckbox(table);
	                updateActionIcons(table);
	                updatePagerIcons(table);
	                enableTooltips(table);
	            }, 0);
	        },
	        ondblClickRow: function(rowid) {     	            	            
	            var gsr = jQuery(grid_selector).jqGrid('getGridParam','selrow');                                              
            	var ret = jQuery(grid_selector).jqGrid('getRowData',gsr);	            
	        },
	    });

	    $(window).triggerHandler('resize.jqGrid');//cambiar el tamaño para hacer la rejilla conseguir el tamaño correcto

	    function aceSwitch( cellvalue, options, cell ) {
	        setTimeout(function(){
	            $(cell) .find('input[type=checkbox]')
	            .addClass('ace ace-switch ace-switch-5')
	            .after('<span class="lbl"></span>');
	        }, 0);
	    }	    	   

	    jQuery(grid_selector).jqGrid('navGrid',pager_selector,
	    {   //navbar options
	        edit: false,
	        editicon : 'ace-icon fa fa-pencil blue',
	        add: false,
	        addicon : 'ace-icon fa fa-plus-circle purple',
	        del: false,
	        delicon : 'ace-icon fa fa-trash-o red',
	        search: false,
	        searchicon : 'ace-icon fa fa-search orange',
	        refresh: false,
	        refreshicon : 'ace-icon fa fa-refresh green',
	        view: false,
	        viewicon : 'ace-icon fa fa-search-plus grey'
	    },
	    {	        
	        recreateForm: true,
	        beforeShowForm : function(e) {
	            var form = $(e[0]);
	            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
	            style_edit_form(form);
	        }
	    },
	    {
	        closeAfterAdd: true,
	        recreateForm: true,
	        viewPagerButtons: false,
	        beforeShowForm : function(e) {
	            var form = $(e[0]);
	            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
	            .wrapInner('<div class="widget-header" />')
	            style_edit_form(form);
	        }
	    },
	    {
	        recreateForm: true,
	        beforeShowForm : function(e) {
	            var form = $(e[0]);
	            if(form.data('styled')) return false;      
	            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
	            style_delete_form(form); 
	            form.data('styled', true);
	        },
	        onClick : function(e) {}
	    },
	    {
	        recreateForm: true,
	        afterShowSearch: function(e){
	            var form = $(e[0]);
	            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
	            style_search_form(form);
	        },
	        afterRedraw: function(){
	            style_search_filters($(this));
	        },

	        //multipleSearch: true
	        overlay: false,
	        sopt: ['eq', 'cn'],
            defaultSearch: 'eq',            	       
	      },
	    {
	        //view record form
	        recreateForm: true,
	        beforeShowForm: function(e){
	            var form = $(e[0]);
	            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
	        }
	    })	    
	    function style_edit_form(form) {
	        form.find('input[name=sdate]').datepicker({format:'yyyy-mm-dd' , autoclose:true})
	        form.find('input[name=stock]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');

	        //update buttons classes
	        var buttons = form.next().find('.EditButton .fm-button');
	        buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
	        buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
	        buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>')
	        
	        buttons = form.next().find('.navButton a');
	        buttons.find('.ui-icon').hide();
	        buttons.eq(0).append('<i class="ace-icon fa fa-chevron-left"></i>');
	        buttons.eq(1).append('<i class="ace-icon fa fa-chevron-right"></i>');       
	    }

	    function style_delete_form(form) {
	        var buttons = form.next().find('.EditButton .fm-button');
	        buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
	        buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
	        buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
	    }
	    
	    function style_search_filters(form) {
	        form.find('.delete-rule').val('X');
	        form.find('.add-rule').addClass('btn btn-xs btn-primary');
	        form.find('.add-group').addClass('btn btn-xs btn-success');
	        form.find('.delete-group').addClass('btn btn-xs btn-danger');
	    }
	    function style_search_form(form) {
	        var dialog = form.closest('.ui-jqdialog');
	        var buttons = dialog.find('.EditTable')
	        buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
	        buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
	        buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
	    }
	    
	    function beforeDeleteCallback(e) {
	        var form = $(e[0]);
	        if(form.data('styled')) return false; 
	        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
	        style_delete_form(form);
	        form.data('styled', true);
	    }
	    
	    function beforeEditCallback(e) {
	        var form = $(e[0]);
	        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
	        style_edit_form(form);
	    }

	    function styleCheckbox(table) {}
	    
	    function updateActionIcons(table) {}
	    
	    function updatePagerIcons(table) {
	        var replacement = 
	            {
	            'ui-icon-seek-first' : 'ace-icon fa fa-angle-double-left bigger-140',
	            'ui-icon-seek-prev' : 'ace-icon fa fa-angle-left bigger-140',
	            'ui-icon-seek-next' : 'ace-icon fa fa-angle-right bigger-140',
	            'ui-icon-seek-end' : 'ace-icon fa fa-angle-double-right bigger-140'
	        };
	        $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
	            var icon = $(this);
	            var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
	            if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
	        })
	    }

	    function enableTooltips(table) {
	        $('.navtable .ui-pg-button').tooltip({container:'body'});
	        $(table).find('.ui-pg-div').tooltip({container:'body'});
	    }

	    $(document).one('ajaxloadstart.page', function(e) {
	        $(grid_selector).jqGrid('GridUnload');
	        $('.ui-jqdialog').remove();
	    });
	});
	// fin

	/*jqgrid table 2 buscador*/    
	jQuery(function($) {
	    var grid_selector2 = "#table2";
	    var pager_selector2 = "#pager2";
	    
	    $(window).on('resize.jqGrid', function () {
			$(grid_selector2).jqGrid( 'setGridWidth', $("#myModal .modal-dialog").width()-30);
	    }).trigger('resize');  

	    var parent_column = $(grid_selector2).closest('[class*="col-"]');
		$(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
			if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
				//setTimeout is for webkit only to give time for DOM changes and then redraw!!!
				setTimeout(function() {
					$(grid_selector2).jqGrid( 'setGridWidth', parent_column.width() );
				}, 0);
			}
	    })

	    // buscador facturas
	    jQuery(grid_selector2).jqGrid({	 
	    	datatype: "xml",
		    url: 'data/proformas/xml_proformas.php',         
	        autoencode: false,
	        colNames: ['ID','IDENTIFICACIÓN','CLIENTE','DIRECCIÓN','FECHA EMISIÓN','TOTAL','PDF','COMPARTIR'],
	        colModel:[ 
			    {name:'id',index:'id', frozen:true, align:'left', search:false, hidden: true},   
	            {name:'C.identificacion',index:'C.identificacion', frozen:true, align:'left', search:true, hidden: false},
	            {name:'C.nombres_completos',index:'C.nombres_completos',frozen : true,align:'left', search:true, width: '300px'},
	            {name:'direccion',index:'direccion',frozen : true, hidden: true, align:'left', search:false,width: '300px'},
	            {name:'fecha_emision',index:'fecha_emision',frozen : true, align:'left', search:false,width: '120px'},
	            {name:'total_pagar',index:'total_pagar',frozen : true, align:'left', search:false,width: '100px'},
	            {name:'accion', index:'accion', editable: false, hidden: false, frozen: true, search:false, editrules: {required: true}, align: 'center', width: '80px'},
	            {name:'share', index:'share', editable: false, hidden: false, frozen: true, editrules: {required: true}, align: 'center', width: '100px'}
	        ],          
	        rowNum: 10,       
	        width:600,
	        shrinkToFit: false,
	        height:330,
	        rowList: [10,20,30],
	        pager: pager_selector2,        
	        sortname: 'id',
	        sortorder: 'asc',
	        altRows: true,
	        multiselect: false,
	        viewrecords : true,
	        loadComplete : function() {
	            var table = this;
	            setTimeout(function(){
	                styleCheckbox(table);
	                updateActionIcons(table);
	                updatePagerIcons(table);
	                enableTooltips(table);
	            }, 0);
	        },
	        gridComplete: function() {
				var ids = jQuery(grid_selector2).jqGrid('getDataIDs');
				for(var i = 0;i < ids.length;i++) {
					var id_proforma = ids[i];
					pdf = "<a onclick=\"angular.element(this).scope().methodspdf('"+id_proforma+"')\" title='Reporte Proforma' ><i class='fa fa-file-pdf-o red2' style='cursor:pointer; cursor: hand'> PDF</i></a>"; 
					share = "<a onclick=\"angular.element(this).scope().methodoshare('"+id_proforma+"')\" title='Compartir Anticipos' data-toggle='modal' data-target='#myModal2' ><i class='fa fa-share-alt' style='cursor:pointer; cursor: hand'> SHARE</i></a>"; 					
					jQuery(grid_selector2).jqGrid('setRowData',ids[i],{accion:pdf, share:share});
				}	
			},
	        ondblClickRow: function(rowid) {     	            	            
	            var gsr = jQuery(grid_selector2).jqGrid('getGridParam','selrow');                                              
            	var ret = jQuery(grid_selector2).jqGrid('getRowData',gsr);
            	$("#table").jqGrid("clearGridData", true);

            	$.ajax({
					url: 'data/proformas/app.php',
					type: 'post',
					data: {llenar_cabezera_proforma:'llenar_cabezera_proforma',id: ret.id},
					dataType: 'json',
					success: function (data) {
						$('#id_proforma').val(data.id_proforma);
						$('#fecha_actual').val(data.fecha_actual);
						$('#hora_actual').val(data.hora_actual);
						$('#id_cliente').val(data.id_cliente);
						$('#ruc').val(data.identificacion);
						$('#cliente').val(data.nombres_completos);
						$('#direccion').val(data.direccion);
						$('#telefono').val(data.telefono2);
						$('#correo').val(data.correo);
						$("#select_tipo_precio").select2('val', data.tipo_precio).trigger("change");

						$('#subtotal').val(data.subtotal);
						$('#tarifa').val(data.tarifa);
						$('#tarifa_0').val(data.tarifa0);
						$('#iva').val(data.iva);
						$('#otros').val(data.descuento);
						$('#total_pagar').val(data.total_pagar);

						if(data.estado == "2") {
	                        $("#estado").append($("<h3>").text("Anulada"));
	                        $("#estado h3").css("color","red");
	                        $("#btn_2").attr("disabled", true);
	                    } else {
	                        $("#estado h3").remove();
	                        $("#btn_2").attr("disabled", false);
	                    }
					}
				});

				$.ajax({
					url: 'data/proformas/app.php',
					type: 'post',
					data: {llenar_detalle_proforma:'llenar_detalle_proforma',id: ret.id},
					dataType: 'json',
					success: function (data) {
						var tama = data.length;
						var descuento = 0;
	                    var desc = 0;
	                    var precio = 0;
	                    var multi = 0;
	                    var flotante = 0;
	                    var resultado = 0;
	                    var total = 0;
	                    var suma_total = 0;

						for (var i = 0; i < tama; i = i + 9) {
							desc = data[i + 5];
                            precio = (parseFloat(data[i + 4])).toFixed(3);
                            multi = (parseFloat(data[i + 3]) * parseFloat(precio)).toFixed(3);
                            descuento = ((multi * parseFloat(desc)) / 100);
                            flotante = parseFloat(descuento);
                            resultado = (Math.round(flotante * Math.pow(10,2)) / Math.pow(10,2)).toFixed(3);
                            total = (multi - resultado).toFixed(3);

							var datarow = {
                                id: data[i], 
                                codigo: data[i + 1], 
                                detalle: data[i + 2], 
                                cantidad: data[i + 3], 
                                precio_u: precio, 
                                descuento: desc,
                                cal_des: resultado, 
                                total: total,
                                iva: data[i + 7],
                                incluye: data[i + 8]
                            };

                            jQuery("#table").jqGrid('addRowData',data[i],datarow);
                            suma_total = suma_total + parseFloat(data[i + 3]);
						}
						var filas = jQuery("#table").jqGrid("getRowData");
	                    $("#items").val(filas.length);
	                    $("#num").val(suma_total);
					}
				});
 

				$('#myModal').modal('hide'); 
		        $('#btn_0').attr('disabled', true);
		        $("#btn_3").attr("disabled", false);           
	        },
	        caption: "LISTA PROFORMAS"
	    });

	    $(window).triggerHandler('resize.jqGrid');//cambiar el tamaño para hacer la rejilla conseguir el tamaño correcto

	    function aceSwitch( cellvalue, options, cell ) {
	        setTimeout(function(){
	            $(cell) .find('input[type=checkbox]')
	            .addClass('ace ace-switch ace-switch-5')
	            .after('<span class="lbl"></span>');
	        }, 0);
	    }	    	   

	    jQuery(grid_selector2).jqGrid('navGrid',pager_selector2,
	    {   //navbar options
	        edit: false,
	        editicon : 'ace-icon fa fa-pencil blue',
	        add: false,
	        addicon : 'ace-icon fa fa-plus-circle purple',
	        del: false,
	        delicon : 'ace-icon fa fa-trash-o red',
	        search: true,
	        searchicon : 'ace-icon fa fa-search orange',
	        refresh: true,
	        refreshicon : 'ace-icon fa fa-refresh green',
	        view: false,
	        viewicon : 'ace-icon fa fa-search-plus grey'
	    },
	    {	        
	        recreateForm: true,
	        beforeShowForm : function(e) {
	            var form = $(e[0]);
	            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
	            style_edit_form(form);
	        }
	    },
	    {
	        closeAfterAdd: true,
	        recreateForm: true,
	        viewPagerButtons: false,
	        beforeShowForm : function(e) {
	            var form = $(e[0]);
	            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
	            .wrapInner('<div class="widget-header" />')
	            style_edit_form(form);
	        }
	    },
	    {
	        recreateForm: true,
	        beforeShowForm : function(e) {
	            var form = $(e[0]);
	            if(form.data('styled')) return false;      
	            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
	            style_delete_form(form); 
	            form.data('styled', true);
	        },
	        onClick : function(e) {}
	    },
	    {
	        recreateForm: true,
	        afterShowSearch: function(e){
	            var form = $(e[0]);
	            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
	            style_search_form(form);
	        },
	        afterRedraw: function(){
	            style_search_filters($(this));
	        },

	        //multipleSearch: true
	        overlay: false,
	        sopt: ['eq', 'cn'],
            defaultSearch: 'eq',            	       
	      },
	    {
	        //view record form
	        recreateForm: true,
	        beforeShowForm: function(e){
	            var form = $(e[0]);
	            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
	        }
	    })	    
	    function style_edit_form(form) {
	        form.find('input[name=sdate]').datepicker({format:'yyyy-mm-dd' , autoclose:true})
	        form.find('input[name=stock]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');

	        //update buttons classes
	        var buttons = form.next().find('.EditButton .fm-button');
	        buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
	        buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
	        buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>')
	        
	        buttons = form.next().find('.navButton a');
	        buttons.find('.ui-icon').hide();
	        buttons.eq(0).append('<i class="ace-icon fa fa-chevron-left"></i>');
	        buttons.eq(1).append('<i class="ace-icon fa fa-chevron-right"></i>');       
	    }

	    function style_delete_form(form) {
	        var buttons = form.next().find('.EditButton .fm-button');
	        buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
	        buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
	        buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
	    }
	    
	    function style_search_filters(form) {
	        form.find('.delete-rule').val('X');
	        form.find('.add-rule').addClass('btn btn-xs btn-primary');
	        form.find('.add-group').addClass('btn btn-xs btn-success');
	        form.find('.delete-group').addClass('btn btn-xs btn-danger');
	    }
	    function style_search_form(form) {
	        var dialog = form.closest('.ui-jqdialog');
	        var buttons = dialog.find('.EditTable')
	        buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
	        buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
	        buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
	    }
	    
	    function beforeDeleteCallback(e) {
	        var form = $(e[0]);
	        if(form.data('styled')) return false; 
	        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
	        style_delete_form(form);
	        form.data('styled', true);
	    }
	    
	    function beforeEditCallback(e) {
	        var form = $(e[0]);
	        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
	        style_edit_form(form);
	    }

	    function styleCheckbox(table) {}
	    

	    function updateActionIcons(table) {}
	    
	    function updatePagerIcons(table) {
	        var replacement = 
	            {
	            'ui-icon-seek-first' : 'ace-icon fa fa-angle-double-left bigger-140',
	            'ui-icon-seek-prev' : 'ace-icon fa fa-angle-left bigger-140',
	            'ui-icon-seek-next' : 'ace-icon fa fa-angle-right bigger-140',
	            'ui-icon-seek-end' : 'ace-icon fa fa-angle-double-right bigger-140'
	        };
	        $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
	            var icon = $(this);
	            var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
	            if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
	        })
	    }

	    function enableTooltips(table) {
	        $('.navtable .ui-pg-button').tooltip({container:'body'});
	        $(table).find('.ui-pg-div').tooltip({container:'body'});
	    }

	    $(document).one('ajaxloadstart.page', function(e) {
	        $(grid_selector2).jqGrid('GridUnload');
	        $('.ui-jqdialog').remove();
	    });
	});
	// fin
});