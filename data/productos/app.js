app.controller('productosController', function ($scope, $route) {

	$scope.$route = $route;

	jQuery(function($) {
		$('[data-toggle="tooltip"]').tooltip();
		// mascaras input
		$('#stock').ace_spinner({value:0,min:0,max:100,step:1, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
		$('#stock_minimo').ace_spinner({value:1,min:1,step:1, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
		$('#stock_maximo').ace_spinner({value:1,min:1,step:1, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
		$('#descuento').ace_spinner({value:0,min:0,step:1, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});

		// stilo select2
		$(".select2").css({
			width: '100%',
		    allow_single_deselect: true,
		    no_results_text: "No se encontraron resultados",
		    }).select2().on("change", function (e) {
			$(this).closest('form').validate().element($(this));
	    });

		$("#select_tipo,#select_categoria,#select_marca,#select_medida,#select_bodega,#select_iva").select2({
		  allowClear: true 
		});
		// fin

		// validaciones codigo barras repetidos
	    $("#codigo_barras").change(function() {
	        $.ajax({
	            type: "POST",
	            url: "data/productos/app.php",
	            data: {comparar_codigo_barras:'comparar_codigo_barras',codigo_barras: $("#codigo_barras").val()},
	            success: function(data) {
	                var val = data;
	                if (val == 1) {
	                    $("#codigo_barras").val('');
	                    $("#codigo_barras").focus();
	                    $.gritter.add({
							title: 'Error... El código de barras ya se encuentra registrado',
							class_name: 'gritter-error gritter-center',
							time: 1000,
						});	
	                }
	            }
	        });
	    });
		// fin

		// validaciones codigos repetidos
	    $("#codigo").keyup(function() {
	        $.ajax({
	            type: "POST",
	            url: "data/productos/app.php",
	            data: {comparar_codigos:'comparar_codigos',codigo: $("#codigo").val()},
	            success: function(data) {
	                var val = data;
	                if (val == 1) {
	                    $("#codigo").val('');
	                    $("#codigo").focus();
	                    $.gritter.add({
							title: 'Error... El código ya se encuentra registrado',
							class_name: 'gritter-error gritter-center',
							time: 1000,
						});	
	                }
	            }
	        });
	    });
		// fin

		//validacion formulario productos
		$('#form_productos').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: false,
			ignore: "",
			rules: {
				codigo: {
					required: true				
				},
				descripcion: {
					required: true				
				},
				precio_costo: {
					required: true				
				},
				precio_minorista: {
					required: true				
				},
				precio_mayorista: {
					required: true				
				},
				select_iva: {
					required: true				
				},
				select_tipo: {
					required: true				
				},	
			},
			messages: {
				codigo: {
					required: "Por favor, Indique un Código",
				},
				descripcion: {
					required: "Por favor, Indique una Descripción",
				},
				precio_costo: { 	
					required: "Por favor, Indique precio Costo",			
				},
				precio_minorista: {
					required: "Por favor, Indique precio Minorista",
				},
				precio_mayorista: {
					required: "Por favor, Indique precio Mayorista",
				},
				select_iva: {
					required: "Por favor, Indique porcentaje IVA",
				},
				select_tipo: {
					required: "Por favor, Indique tipo Producto",
				},
			},
			//para prender y apagar los errores
			highlight: function (e) {
				$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
			},
			success: function (e) {
				$(e).closest('.form-group').removeClass('has-error');
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

		// llenar combo tipo producto
		function llenar_select_tipo_productos() {
			$.ajax({
				url: 'data/productos/app.php',
				type: 'post',
				data: {llenar_tipo_producto:'llenar_tipo_producto'},
				success: function (data) {
					$('#select_tipo').html(data).trigger("change");
				}
			});
		}
		// fin

		// llenar combo categoria
		function llenar_select_categoria() {
			$.ajax({
				url: 'data/productos/app.php',
				type: 'post',
				data: {llenar_categoria:'llenar_categoria'},
				success: function (data) {
					$('#select_categoria').html(data).trigger("change");
				}
			});
		}
		// fin

		// llenar combo marca
		function llenar_select_marca() {
			$.ajax({
				url: 'data/productos/app.php',
				type: 'post',
				data: {llenar_marca:'llenar_marca'},
				success: function (data) {
					$('#select_marca').html(data).trigger("change");
				}
			});
		}
		// fin

		// llenar combo presentacion
		function llenar_select_unidades_medida() {
			$.ajax({
				url: 'data/productos/app.php',
				type: 'post',
				data: {llenar_unidades_medida:'llenar_unidades_medida'},
				success: function (data) {
					$('#select_medida').html(data).trigger("change");
				}
			});
		}
		// fin

		// llenar combo almacenes
		function llenar_select_bodega() {
			$.ajax({
				url: 'data/productos/app.php',
				type: 'post',
				data: {llenar_bodega:'llenar_bodega'},
				success: function (data) {
					$('#select_bodega').html(data).trigger("change");
				}
			});
		}
		// fin

		// llenar combo porcentaje
		function llenar_select_porcentaje() {
			$.ajax({
				url: 'data/productos/app.php',
				type: 'post',
				data: {llenar_porcentaje:'llenar_porcentaje'},
				success: function (data) {
					var principal = data;
					$('#select_iva').html(data).trigger("change");
				}
			});
		}
		// fin

		// llenar combo proveedores
		function llenar_select_proveedores() {
			$.ajax({
				url: 'data/productos/app.php',
				type: 'post',
				data: {llenar_proveedores:'llenar_proveedores'},
				success: function (data) {
					$('#select_proveedor').html(data);
				}
			});
		}
		// fin

		// validaciones al iniciar
		llenar_select_tipo_productos();
		llenar_select_categoria();
		llenar_select_marca();
		llenar_select_unidades_medida();
		llenar_select_bodega();
		llenar_select_porcentaje();
		llenar_select_proveedores();
		$('#btn_1').attr('disabled', true);
		$('#codigo_barras').focus();
    	$("#precio_costo").keypress(ValidPun);
    	$("#utilidad_minorista").keypress(ValidPun);
    	$("#utilidad_mayorista").keypress(ValidPun);
    	$("#precio_minorista").keypress(ValidPun);
    	$("#precio_mayorista").keypress(ValidPun);
    	$("#stock").keypress(ValidNum);
    	$("#stock_minimo").keypress(ValidNum);
    	$("#descuento").keypress(ValidNum);
    	$("#stock_maximo").keypress(ValidNum);
    	$("#expiracion").prop("checked",false);
    	$("#series").prop("checked",false);
    	// fin

		// guardar formulario
		$('#btn_0').click(function() {
			var respuesta = $('#form_productos').valid();
			
			if (respuesta == true) {
				$('#btn_0').attr('disabled', true);
				var submit = "btn_gardar";
				var formulario = $("#form_productos").serialize();

				$.ajax({
			        url: "data/productos/app.php",
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
			var respuesta = $('#form_productos').valid();

			if (respuesta == true) {
				$('#btn_1').attr('disabled', true);
				var submit = "btn_modificar";
				var formulario = $("#form_productos").serialize();

				$.ajax({
			        url: "data/productos/app.php",
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

		// abrir modal
		$('#btn_2').click(function() {
			$('#myModal').modal('show');
		});
		// fin

		// refrescar formulario
		$('#btn_3').click(function() {
			location.reload(true);
		});
		// fin

		/*jqgrid*/    
		jQuery(function($) {
		    var grid_selector = "#table";
		    var pager_selector = "#pager";
		    
		    //cambiar el tamaño para ajustarse al tamaño de la página
		    $(window).on('resize.jqGrid', function () {        
		        $(grid_selector).jqGrid( 'setGridWidth', $("#myModal .modal-dialog").width()-30);
		    });
		    //cambiar el tamaño de la barra lateral collapse/expand
		    var parent_column = $(grid_selector).closest('[class*="col-"]');
		    $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
		        if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
		            //para dar tiempo a los cambios de DOM y luego volver a dibujar!!!
		            setTimeout(function() {
		                $(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
		            }, 0);
		        }
		    });

		    // buscador clientes
		    jQuery(grid_selector).jqGrid({	        
		        datatype: "xml",
		        url: 'data/productos/xml_productos.php',        
		        colNames: ['ID','CÓDIGO BARRAS','CÓDIGO','DESCRIPCIÓN','PRECIO COSTO','UTILIDAD MINORISTA','UTILIDAD MINORISTA','PRECIO MINORISTA','PRECIO MAYORISTA','ID_TIPO_DOCUMENTO','ID_CATEGORIA','ID_MARCA','ID_UNIDAD_MEDIDA','ID_BODEGA','ID_PORCENTAJE','INCLUYE IVA','STOCK','STOCK MÍNIMO','STOCK MÁXIMO','DESCUENTO','EXPIRACIÓN','FACTURAR EXISTENCIA','PROVEEDOR','UBICACION','SERIES','OBSERVACIONES'],
		        colModel:[      
		            {name:'id',index:'id', frozen:true, align:'left', search:false, hidden: true},
		            {name:'codigo_barras',index:'codigo_barras',frozen : true, hidden: false, align:'left',search:true,width: ''},
		            {name:'codigo',index:'codigo',frozen : true, hidden: false, align:'left',search:true,width: ''},
		            {name:'descripcion',index:'descripcion',frozen : true, hidden: false, align:'left',search:true,width: ''},
		            {name:'precio_costo',index:'precio_costo',frozen : true, hidden: false, align:'left',search:false,width: ''},
		            {name:'utilidad_minorista',index:'utilidad_minorista',frozen : true, hidden: false, align:'left',search:false,width: ''},
		            {name:'utilidad_mayorista',index:'utilidad_mayorista',frozen : true, hidden: false, align:'left',search:false,width: ''},
		            {name:'precio_minorista',index:'precio_minorista',frozen : true, hidden: false, align:'left',search:false,width: ''},
		            {name:'precio_mayorista',index:'precio_mayorista',frozen : true, hidden: false, align:'left',search:false,width: ''},
		            {name:'id_tipo_documento',index:'id_tipo_documento',frozen : true, hidden: true, align:'left',search:false,width: ''},
		            {name:'id_categoria',index:'id_categoria',frozen : true, hidden: true, align:'left',search:false,width: ''},
		            {name:'id_marca',index:'id_marca',frozen : true, hidden: true, align:'left',search:false,width: ''},
		            {name:'id_unidad_medida',index:'id_unidad_medida',frozen : true, hidden: true, align:'left',search:false,width: ''},
		            {name:'id_bodega',index:'id_bodega',frozen : true, hidden: true, align:'left',search:false,width: ''},
		            {name:'id_porcentaje',index:'id_porcentaje',frozen : true, hidden: true, align:'left',search:false,width: ''},
		            {name:'incluye_iva',index:'incluye_iva',frozen : true, hidden: true, align:'left',search:false,width: ''},
		            {name:'stock',index:'stock',frozen : true, hidden: false, align:'left',search:false,width: ''},
		            {name:'stock_minimo',index:'stock_minimo',frozen : true, hidden: false, align:'left',search:false,width: ''},
		            {name:'stock_maximo',index:'stock_maximo',frozen : true, hidden: false, align:'left',search:false,width: ''},
		            {name:'descuento',index:'descuento',frozen : true, hidden: false, align:'left',search:false,width: ''},
		            {name:'expiracion',index:'expiracion',frozen : true, hidden: false, align:'left',search:false,width: ''},
		            {name:'facturar_existencia',index:'facturar_existencia',frozen : true, hidden: false, align:'left',search:false,width: ''},
		            {name:'id_proveedor',index:'id_proveedor',frozen : true, hidden: true, align:'left',search:false,width: ''},
		            {name:'ubicacion',index:'ubicacion',frozen : true, hidden: false, align:'left',search:false,width: ''},
		            {name:'series',index:'series',frozen : true, hidden: false, align:'left',search:false,width: ''},
		            {name:'observaciones',index:'observaciones',frozen : true, hidden: false, align:'left',search:false,width: ''},
		        ],          
		        rowNum: 10,       
		        width:600,
		        shrinkToFit: false,
		        height:200,
		        rowList: [10,20,30],
		        pager: pager_selector,        
		        sortname: 'id',
		        sortorder: 'asc',
		        altRows: true,
		        multiselect: false,
		        multiboxonly: true,
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
		        ondblClickRow: function(rowid) {     	            	            
		            var gsr = jQuery(grid_selector).jqGrid('getGridParam','selrow');                                              
	            	var ret = jQuery(grid_selector).jqGrid('getRowData',gsr);

	            	$('#id_producto').val(ret.id);
	            	$('#codigo_barras').val(ret.codigo_barras);
	            	$('#codigo').val(ret.codigo);
	            	$('#descripcion').val(ret.descripcion);
	            	$('#precio_costo').val(ret.precio_costo);
	            	$('#utilidad_minorista').val(ret.utilidad_minorista);
	            	$('#utilidad_mayorista').val(ret.utilidad_mayorista);
	            	$('#precio_minorista').val(ret.precio_minorista);
	            	$('#precio_mayorista').val(ret.precio_mayorista);
	            	$("#select_tipo").select2('val', ret.id_tipo_documento).trigger("change");
	            	$("#select_categoria").select2('val', ret.id_categoria).trigger("change");
	            	$("#select_marca").select2('val', ret.id_marca).trigger("change");
	            	$("#select_medida").select2('val', ret.id_unidad_medida).trigger("change");
	            	$("#select_bodega").select2('val', ret.id_bodega).trigger("change");
	            	$("#select_iva").select2('val', ret.id_porcentaje).trigger("change");
	            	if(ret.incluye_iva == "SI") {
				    	$("#incluye_iva").prop("checked",true);
				    } else {
				    	$("#incluye_iva").prop("checked",false);
				    }
	            	$('#stock').val(ret.stock);
	            	$('#stock_minimo').val(ret.stock_minimo);
	            	$('#stock_maximo').val(ret.stock_maximo);
	            	if(ret.expiracion == "SI") {
				    	$("#expiracion").prop("checked",true);
				    } else {
				    	$("#expiracion").prop("checked",false);
				    }
				    if(ret.facturar_existencia == "SI") {
				    	$("#facturar_existencia").prop("checked",true);
				    } else {
				    	$("#facturar_existencia").prop("checked",false);
				    }
				    $("#select_proveedor").select2('val', ret.id_proveedor).trigger("change");
				    $('#ubicacion').val(ret.ubicacion);
				    if(ret.series == "SI") {
				    	$("#series").prop("checked",true);
				    } else {
				    	$("#series").prop("checked",false);
				    }
	            	$('#observaciones').val(ret.observaciones);

		            $('#myModal').modal('hide'); 
		            $('#btn_0').attr('disabled', true); 
		            $('#btn_1').attr('disabled', false); 	            
		        },
		        
		        caption: "LISTA PRODUCTOS"
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
		    {   
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
		        $(grid_selector).jqGrid('GridUnload');
		        $('.ui-jqdialog').remove();
		    });
		});
		// fin
	});
});