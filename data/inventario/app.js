app.controller('inventarioController', function ($scope, $interval) {

	var combo_datos = '';

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

		// buscar productos codigo barras
	    $("#codigo_barras").change(function(e) {
	        barras();
	    });

	    function barras() {
	    	var codigo_barras = $("#codigo_barras").val();
	        
            $.getJSON('data/inventario/search.php?codigo_barras=' + codigo_barras, function(data) {
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
	    function combo(tipo) {
	        $.ajax({
	            type: "POST",
	            url: "data/inventario/app.php",
	            data: {buscadores:'buscadores',tipo_busqueda:tipo},        
	            success: function(resp) {         
	                combo_datos = JSON.parse(resp);        
	            }
	        });    
	        return combo_datos;
	    }
	    // fin

	    // buscar productos codigo
	    $("#codigo").keyup(function(e) {
	     	var tipo = 'codigo';
	     	var res = combo(tipo);

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
	     	var res = combo(tipo);

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

	    // limpiar con codigo
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

	    // limpiar con descripcion
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

	    /*---agregar a la tabla---*/
	  	$("#cantidad").on("keypress",function (e) {
	  		if(e.keyCode == 13) {//tecla del alt para el entrer poner 13 
			    var su = 0;
                var dife = 0;

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
		                  
		                    if (filas.length == 0) {
		                    	dife = (parseInt( $("#cantidad").val()) - Math.abs(parseInt( $("#stock").val())));
		                    	var datarow = {
                                    id: $("#id_producto").val(), 
                                    codigo: $("#codigo").val(), 
                                    producto: $("#producto").val(), 
                                    precio_compra: $("#precio_costo").val(), 
                                    precio_venta: $("#precio_venta").val(), 
                                    stock: $("#cantidad").val(), 
                                    existencia:  $("#cantidad").val(), 
                                    diferencia: dife
                                };

		                        su = jQuery("#table").jqGrid('addRowData', $("#id_producto").val(), datarow);
		                        limpiar_input();
		                    } else {
		                    	var repe = 0;
                                for (var i = 0; i < filas.length; i++) {
                                    var id = filas[i];

                                    if (id['id'] == $("#id_producto").val()) {
                                        repe = 1;
                                    }
                                }

		                        if (repe == 1) {
		                            dife = (parseInt( $("#cantidad").val()) - Math.abs(parseInt( $("#stock").val())));
                                    datarow = {
                                        id: $("#id_producto").val(),  
                                        codigo: $("#codigo").val(), 
                                        producto: $("#producto").val(), 
                                        precio_compra: $("#precio_costo").val(), 
                                    	precio_venta: $("#precio_venta").val(),
                                        stock: $("#cantidad").val(), 
                                        existencia:  $("#cantidad").val(), 
                                        diferencia: dife
                                    };

		                            su = jQuery("#table").jqGrid('setRowData', $("#id_producto").val(), datarow);
		                            limpiar_input();
		                        } else {
		                        	dife = (parseInt( $("#cantidad").val()) - Math.abs(parseInt( $("#stock").val())));
		                                
		                            datarow = {
                                        id: $("#id_producto").val(),  
                                        codigo: $("#codigo").val(), 
                                        producto: $("#producto").val(), 
                                        precio_compra: $("#precio_costo").val(), 
                                    	precio_venta: $("#precio_venta").val(), 
                                        stock: $("#cantidad").val(), 
                                        existencia:  $("#cantidad").val(), 
                                        diferencia: dife
                                    };

		                            su = jQuery("#table").jqGrid('addRowData', $("#id_producto").val(), datarow);
		                            limpiar_input();
		                        }
		                    }
		                    
		                  	// calcular valores
                            var valor_cos = 0;
                            var valor_ven = 0;

                            var fil = jQuery("#table").jqGrid("getRowData");
                            for (var t = 0; t < fil.length; t++) {
                                var dd = fil[t];
                                valor_cos = (valor_cos + (parseFloat(dd['precio_compra']) * parseFloat(dd['stock'])));
                                var valor_costo = (valor_cos).toFixed(2);
                                valor_ven = (valor_ven + (parseFloat(dd['precio_venta']) * parseFloat(dd['stock'])));
                                var valor_venta = (valor_ven).toFixed(2);
                            }

                            $("#total_costo").val(valor_costo);
                            $("#total_venta").val(valor_venta);
                            $("#codigo_barras").focus();
                            // fin
		                    }
		                }
		            }
		        }
		    }
	  	});

		// validacion punto
		function Valida_punto() {
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

		// recargar formulario
		function redireccionar() {
			setTimeout(function() {
			    location.reload(true);
			}, 1000);
		}
		// fin

		// inicio llamado funciones
		$("#cantidad").keypress(ValidNum);

		// guardar inventario
		$('#btn_0').click(function() {
			var formulario = $("#form_inventario").serialize();
			var submit = "btn_guardar";
			var fil = jQuery("#table").jqGrid("getRowData");

			if(fil.length == 0) {
                $.gritter.add({
					title: 'Ingrese productos al Inventario',
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
		        var v6 = new Array();

		        var string_v1 = "";
		        var string_v2 = "";
		        var string_v3 = "";
		        var string_v4 = "";
		        var string_v5 = "";
		        var string_v6 = "";

                for (var i = 0; i < fil.length; i++) {
                    var datos = fil[i];
                    v1[i] = datos['id'];
		            v2[i] = datos['precio_compra'];
		            v3[i] = datos['precio_venta'];
		            v4[i] = datos['stock'];
		            v5[i] = datos['existencia'];
		            v6[i] = datos['diferencia'];
                }

                for (i = 0; i < fil.length; i++) {
                    string_v1 = string_v1 + "|" + v1[i];
                    string_v2 = string_v2 + "|" + v2[i];
                    string_v3 = string_v3 + "|" + v3[i];
                    string_v4 = string_v4 + "|" + v4[i];
                    string_v5 = string_v5 + "|" + v5[i];
                    string_v6 = string_v6 + "|" + v6[i];
                }

                $.ajax({
                    type: "POST",
                    url: "data/inventario/app.php",
                    data: formulario +"&btn_guardar=" + submit + "&campo1=" + string_v1 + "&campo2=" + string_v2 + "&campo3=" + string_v3 + "&campo4=" + string_v4 + "&campo5=" + string_v5+ "&campo6=" + string_v6,
                    success: function(data) {
                    	var id = data;
			        	
		        		bootbox.alert("Gracias! Por su Información Inventario Agregado Correctamente!", function() {
						  	// var myWindow = window.open('data/reportes/inventario.php?hoja=A5&id='+id,'popup','width=900,height=650'); 
						  	location.reload();
						});
                    }
                });
			}	
		});
		// fin

		// reimprimir facturas
		$('#btn_3').click(function() {
			if($('#id_inventario').val() == '') {
				$.gritter.add({
					title: 'Seleccione Inventario a Reimprimir',
					class_name: 'gritter-error gritter-center',
					time: 1000,
				});	
			} else {
				// var id = $('#id_inventario').val();
				// var myWindow = window.open('data/reportes/inventario.php?hoja=A5&id='+id,'popup','width=900,height=650');
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
			height: 250,
	        colNames: ['','ID', 'CÓDIGO', 'PRODUCTO', 'P. COSTO', 'P. VENTA', 'STOCK', 'EXISTENCIA', 'DIFERENCIA'],
	        colModel:[  
	        	{name:'myac', width: 50, fixed: true, sortable: false, resize: false, formatter: 'actions',
			        formatoptions: {keys: false, delbutton: true, editbutton: false}
			    }, 
			    {name: 'id',index:'id', frozen:true, align:'left', search:false, hidden: true},   
	            {name: 'codigo', index: 'codigo', editable: false, search: true, hidden: false, editrules: {edithidden: false}, align: 'center', frozen: true, width: 200},
	            {name: 'producto', index: 'producto', editable: false, search: true, hidden: false, editrules: {edithidden: false}, align: 'center', frozen: true, width: 450},
	            {name: 'precio_compra', index: 'precio_compra', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center', frozen: true, width: 110},
	            {name: 'precio_venta', index: 'precio_venta', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center', frozen: true, width: 110},
	            {name: 'stock', index: 'stock', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center', frozen: true, width: 100},
	            {name: 'existencia', index: 'existencia', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center', frozen: true, width: 110},
	            {name: 'diferencia', index: 'diferencia', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center', frozen: true, width: 110}
	        ],          
	        rowNum: 10,       
	        width:600,
	        shrinkToFit: false,
	        height:250,
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

	                var fil = jQuery(grid_selector).jqGrid("getRowData"); 

	                for (var t = 0; t < fil.length; t++) {
	                    if(ret.iva != 0) {
	                      	if(ret.incluye == "NO") {
		                        subtotal = ret.total;
		                        sub1 = subtotal;
		                        iva1 = parseFloat(sub1 * ret.iva / 100).toFixed(3);                                          

		                        subtotal0 = parseFloat($("#tarifa_0").val()) + 0;
		                        subtotal12 = parseFloat($("#tarifa").val()) - parseFloat(sub1);
		                        iva12 = parseFloat($("#iva").val()) - parseFloat(iva1);
		                        descu_total = parseFloat($("#otros").val()) - parseFloat(ret.cal_des);

		                        subtotal0 = parseFloat(subtotal0).toFixed(3);
		                        subtotal12 = parseFloat(subtotal12).toFixed(3);
		                        iva12 = parseFloat(iva12).toFixed(3);
		                        descu_total = parseFloat(descu_total).toFixed(3);
		                    } else {
		                        if(ret.incluye == "SI") {
		                            subtotal = ret.total;
		                            sub2 = parseFloat(subtotal / 1.14).toFixed(3);
		                            iva2 = parseFloat(sub2 * ret.iva / 100).toFixed(3);

		                            subtotal0 = parseFloat($("#tarifa_0").val()) + 0;
		                            subtotal12 = parseFloat($("#tarifa").val()) - parseFloat(sub2);
		                            iva12 = parseFloat($("#iva").val()) - parseFloat(iva2);
		                            descu_total = parseFloat($("#otros").val()) - parseFloat(ret.cal_des);

		                            subtotal0 = parseFloat(subtotal0).toFixed(3);
		                            subtotal12 = parseFloat(subtotal12).toFixed(3);
		                            iva12 = parseFloat(iva12).toFixed(3);
		                            descu_total = parseFloat(descu_total).toFixed(3);
		                        }
	                        }
	                    } else {
	                        if (ret.iva == 0) {
	                            subtotal = ret.total;
	                            sub = subtotal;

	                            subtotal0 = parseFloat($("#tarifa_0").val()) - parseFloat(sub);
	                            subtotal12 = parseFloat($("#tarifa").val()) + 0;
	                            iva12 = parseFloat($("#iva").val()) + 0;
	                            descu_total = parseFloat($("#otros").val()) - parseFloat(ret.cal_des);
	                          
	                            subtotal0 = parseFloat(subtotal0).toFixed(3);
	                            subtotal12 = parseFloat(subtotal12).toFixed(3);
	                            iva12 = parseFloat(iva12).toFixed(3);
	                            descu_total = parseFloat(descu_total).toFixed(3);
	                        }
	                    }
	                }

	                total_total = parseFloat(total_total) + (parseFloat(subtotal0) + parseFloat(subtotal12) + parseFloat(iva12));
	                total_total = parseFloat(total_total).toFixed(3);

	                $("#tarifa_0").val(subtotal0);
	                $("#tarifa").val(subtotal12);
	                $("#iva").val(iva12);
	                $("#otros").val(descu_total);
	                $("#total_pagar").val(total_total);
                
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
			height: 250,
	        colNames: ['ID','IDENTIFICACIÓN','CLIENTE','DIRECCIÓN','FECHA EMISIÓN','TOTAL','ACCIÓN'],
	        colModel:[ 
			    {name:'id',index:'id', frozen:true, align:'left', search:false, hidden: true},   
	            {name:'ruc',index:'ruc', frozen:true, align:'left', search:false, hidden: false},
	            {name:'empresa',index:'empresa',frozen : true,align:'left', search:true, width: '300px'},
	            {name:'direccion',index:'direccion',frozen : true, hidden: true, align:'left', search:true,width: '300px'},
	            {name:'fecha_actual',index:'fecha_actual',frozen : true, align:'left', search:true,width: '150px'},
	            {name:'total_pagar',index:'total_pagar',frozen : true, align:'left', search:true,width: '100px'},
	            {name:'accion', index:'accion', editable: false, hidden: false, frozen: true, editrules: {required: true}, align: 'center', width: '150px'},
	        ],          
	        rowNum: 10,       
	        width:600,
	        shrinkToFit: false,
	        height:250,
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
					// anular = "<a onclick=\"angular.element(this).scope().methodsanular('"+id_proforma+"')\" title='Anular Factura' ><i class='fa fa fa-times red2' style='cursor:pointer; cursor: hand'> ANULAR</i></a>"; 
					
					jQuery(grid_selector2).jqGrid('setRowData',ids[i],{accion:pdf});
				}	
			},
	        ondblClickRow: function(rowid) {     	            	            
	            var gsr = jQuery(grid_selector2).jqGrid('getGridParam','selrow');                                              
            	var ret = jQuery(grid_selector2).jqGrid('getRowData',gsr);
            	 $("#table").jqGrid("clearGridData", true);	

            	$.ajax({
					url: 'data/proformas/app.php',
					type: 'post',
					data: {llenar_cabezera_factura:'llenar_cabezera_factura',id: ret.id},
					dataType: 'json',
					success: function (data) {
						console.log(data);
						$('#id_proforma').val(data.id_proforma);
						$('#fecha_actual').val(data.fecha_actual);
						$('#id_cliente').val(data.id_cliente);
						$('#ruc').val(data.identificacion);
						$('#cliente').val(data.nombres_completos);
						$('#direccion').val(data.direccion);
						$('#telefono').val(data.telefono2);
						$('#correo').val(data.correo);
						$("#select_tipo_precio").select2('val', data.tipo_precio).trigger("change");

						$('#tarifa').val(data.tarifa12);
						$('#tarifa_0').val(data.tarifa0);
						$('#iva').val(data.iva);
						$('#otros').val(data.descuento);
						$('#total_pagar').val(data.total_pagar);

					}
				});

				$.ajax({
					url: 'data/proformas/app.php',
					type: 'post',
					data: {llenar_detalle_factura:'llenar_detalle_factura',id: ret.id},
					dataType: 'json',
					success: function (data) {
						var tama = data.length;
						for (var i = 0; i < tama; i = i + 7) {
							var datarow = {
                                id: data[i], 
                                codigo: data[i + 1], 
                                detalle: data[i + 2], 
                                cantidad: data[i + 3], 
                                precio_u: data[i + 4], 
                                descuento: data[i + 5], 
                                total: data[i + 6]
                                };

                            jQuery("#table").jqGrid('addRowData',data[i],datarow);
						}
					}
				});  

				$('#myModal').modal('hide'); 
		        $('#btn_0').attr('disabled', true);           
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
	        view: true,
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