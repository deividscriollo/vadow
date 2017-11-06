angular.module('vadowApp')	 			
	.controller('tipoBienController', function ($scope, $route, $http) {	
		$scope.$route = $route;	
		jQuery(function($) {			
			$( "#tabTipoBien" ).click(function( event ) {
				event.preventDefault();  
			});
			var grid_selector = "#table";
		    var pager_selector = "#pager";

		    //cambiar el tamaño para ajustarse al tamaño de la página
		    $(window).on('resize.jqGrid', function () {
		        $(grid_selector).jqGrid('setGridWidth', $("#tabTipoBien").width() - 10);
		    });
		    //cambiar el tamaño de la barra lateral collapse/expand
		    var parent_column = $(grid_selector).closest('[class*="col-"]');
		    $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
		        if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
		            //para dar tiempo a los cambios de DOM y luego volver a dibujar!!!
		            setTimeout(function() {
		                $(grid_selector).jqGrid('setGridWidth', parent_column.width());
		            }, 0);
		        }
		    });

		    jQuery(grid_selector).jqGrid({
		        url: 'data/inventario/tipoBien/appXml.php',
		        autoencode: false,
		        datatype: "xml",
				height: 200,
				colNames:['ID','NOMBRE','ESTADO'],
				colModel:[
					{name:'id',index:'id',align:'left',search:false,editable: true, hidden: true, editoptions: {readonly: 'readonly'}},					
					{name:'nombre',index:'nombre',width:150, editable:true, editoptions:{size:"20", maxlength:"150"}, editrules: {required: true}},
					{name:'estado',index:'estado',width:150, editable:true, editoptions:{size:"20", maxlength:"150"}, editrules: {required: true},edittype:'checkbox',formatter: "checkbox",editoptions: { value:"Activo:Inactivo"}},
					
				],	
		        rownumbers: true,
		        rowNum:10,
		        rowList:[10,20,30],
		        pager : pager_selector,
		        sortname: 'id',
		        sortorder: 'asc',
		        altRows: true,
		        multiselect: false,
		        multiboxonly: false,
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
		        editurl: "data/inventario/tipoBien/app.php",		        
		    });
		    $(window).triggerHandler('resize.jqGrid');//cambiar el tamaño para hacer la rejilla conseguir el tamaño correcto

		    function aceSwitch( cellvalue, options, cell ) {
		        setTimeout(function(){
		            $(cell) .find('input[type=checkbox]')
		            .addClass('ace ace-switch ace-switch-5')
		            .after('<span class="lbl"></span>');
		        }, 0);
		    }
		    //enable datepicker
		    function pickDate( cellvalue, options, cell ) {
		        setTimeout(function(){
		            $(cell) .find('input[type=text]')
		            .datepicker({format:'yyyy-mm-dd' , autoclose:true}); 
		        }, 0);
		    }
		    //navButtons
		    jQuery(grid_selector).jqGrid('navGrid',pager_selector,
		    {   //navbar options
		        edit: true,
		        editicon : 'ace-icon fa fa-pencil blue',
		        add: true,
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
		    	closeAfterEdit: true,
		        recreateForm: true,
		        viewPagerButtons: false,
		        overlay:true,
		        beforeShowForm : function(e) {
		            var form = $(e[0]);
		            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
		            style_edit_form(form);
		        },
		        afterSubmit: function(response)  {
	                retorno = response.responseText;
	                if(retorno == '1'){
	                	$.gritter.add({			                
			                title: 'Mensaje de Salida',			                
			                text: 'Datos Modificados Correctamente',
			                image: 'dist/images/confirm.png',
			                class_name: 'gritter-light'
			            });
           			 } else {
	                	if(retorno == '2') {
	                		$("#codigo").val("");
		                	return [false,"Error.. Este código ya esta agregado"];
		                }else{	
		                	if(retorno == '3') {
		                		$("#nombre").val("");
			                	return [false,"Error.. Este nombre ya esta agregado"];
			                }else{

			                }
		                }
	                }
	                return [true,'',retorno];
	            },
		    },
		    {
		        closeAfterAdd: true,
		        recreateForm: true,
		        viewPagerButtons: false,
		        overlay:true,
		        beforeShowForm : function(e) {
		            var form = $(e[0]);
		            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
		            .wrapInner('<div class="widget-header" />')
		            style_edit_form(form);
		        },
		        afterSubmit: function(response)  {
	                retorno = response.responseText;
	                if(retorno == '1') {
	                	 $.gritter.add({			                
			                title: 'Mensaje de Salida',			                
			                text: 'Datos Agregados Correctamente',
			                image: 'dist/images/confirm.png',
			                class_name: 'gritter-light'
			            });
	                } else {
	                	if(retorno == '2') {
	                		$("#codigo").val("");
		                	return [false,"Error.. Este código ya esta agregado"];
		                }else{	
		                	if(retorno == '3') {
		                		$("#nombre").val("");
			                	return [false,"Error.. Este nombre ya esta agregado"];
			                }else{
			                	
			                }
		                }
	                }
	                return [true,'',retorno];
	            },
		    },
		    {
		        //delete record form
		        recreateForm: true,
		        overlay:true,
		        beforeShowForm : function(e) {
		            var form = $(e[0]);
		            if(form.data('styled')) return false;
		            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
		            style_delete_form(form);
		            form.data('styled', true);
		        },
		        onClick : function(e) {
		      
		        }
		    },
		    {
		        recreateForm: true,
		        overlay:true,
		        afterShowSearch: function(e){
		            var form = $(e[0]);
		            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
		            style_search_form(form);
		        },
		        afterRedraw: function(){
		            style_search_filters($(this));
		        },
		        multipleSearch: false,
		        overlay: true,
		        sopt: ['eq', 'cn'],
		        defaultSearch: 'eq', 
		    },
		    {
		        recreateForm: true,
		        overlay:true,
		        beforeShowForm: function(e){
		            var form = $(e[0]);
		            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
		        }
		    })

		    function style_edit_form(form) {
		        //enable datepicker on "sdate" field and switches for "stock" field
		        //form.find('input[name=sdate]').datepicker({format:'yyyy-mm-dd' , autoclose:true})
		        
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

		    function styleCheckbox(table) { }
		    
		    function updateActionIcons(table) { }
		    
		    //replace icons with FontAwesome icons like above
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
	})