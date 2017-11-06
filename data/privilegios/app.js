app.controller('privilegiosController', function ($scope) {

	jQuery(function($) {
		// estilo select2
		$(".select2").css({
		    'width': '100%',
		    allow_single_deselect: true,
		    no_results_text: "No se encontraron resultados",
		    allowClear: true,
		    }).select2().on("change", function (e) {
			$(this).closest('form').validate().element($(this));
	    });

		$("#select_usuario").select2({
		  allowClear: true
		});
		// fin
		
		// change usuario
		$('#select_usuario').change(function() {
			$('#element_tree').html('<ul id="tree1"></ul>');
			var id = $(this).val();
			// console.log(id);
			var sampleData = initiateDemoData(id);//see below
			$('#tree1').ace_tree({
				dataSource: sampleData['dataSource1'],
				multiSelect: true,
				loaded:true,
				cacheItems: true,
				'open-icon' : 'ace-icon tree-minus',
				'close-icon' : 'ace-icon tree-plus',
				'selectable' : true,
				'selected-icon' : 'ace-icon fa fa-check',
				'unselected-icon' : 'ace-icon fa fa-times',
				loadingHTML : '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>'
			});

			$('.tree-branch-name').trigger("click");
		});
		// fin

		function cargar_tree() {
			var sampleData = initiateDemoData();//see below
			$('#tree1').ace_tree({
				dataSource: sampleData['dataSource1'],
				multiSelect: true,
				loaded:true,
				cacheItems: true,
				'open-icon' : 'ace-icon tree-minus',
				'close-icon' : 'ace-icon tree-plus',
				'selectable' : true,
				'selected-icon' : 'ace-icon fa fa-check',
				'unselected-icon' : 'ace-icon fa fa-times',
				loadingHTML : '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>'
			});

			$('.tree-branch-name').trigger("click");
		}

	    // guardar tree1
	    $('#btn_guardar').click(function() {
	    	var id = $('#select_usuario').val();

	    	if(id == '') {
	    		$.gritter.add({
					title: 'Error... Seleccione un usuario',
					class_name: 'gritter-error gritter-center',
					time: 1000,
				});
	    	} else {
		    	var vector = itemselecttree();
		    	
		    	$.ajax({
					url: 'data/privilegios/app.php',
					type: 'post',
					dataType: 'json',
					data: {updateprivilegios:'ok', data:vector, user:id},
					success: function (data) {
						var val = data;
						if(val == 1) {
							$('#element_tree').html('<ul id="tree1"></ul>');
							var sampleData = initiateDemoData(id);

							$('#tree1').ace_tree({
								dataSource: sampleData['dataSource1'],
								multiSelect: true,
								loaded:true,
								cacheItems: true,
								'open-icon' : 'ace-icon tree-minus',
								'close-icon' : 'ace-icon tree-plus',
								'selectable' : true,
								'selected-icon' : 'ace-icon fa fa-check',
								'unselected-icon' : 'ace-icon fa fa-times',
								loadingHTML : '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>'
							});

							$('.tree-branch-name').trigger("click");
						}
					}
				});
	    	}
	    });
	    // fin

		// retornar datos
		function recursosdata() {
			var retorno;
			$.ajax({
				url: 'data/privilegios/app.php',
				dataType: "json",
				type: 'post',
				data: {'retornar':'recursosdata', id:$('#select_usuario').val()},
				async:false,
				success: function (data) {
					retorno = data;
				}
			});
			return retorno;
		}
		// fin

		// inicializar tree
		function initiateDemoData() {
			var tree_data = recursosdata();
			var dataSource1 = function(options, callback) {
				var _data = null
				if(!("text" in options) && !("type" in options)) {
					_data = recursosdata();//the root tree
					callback({ data: _data });
					return;
				}
				else if("type" in options && options.type == "folder") {
					if("additionalParameters" in options && "children" in options.additionalParameters)
						_data = options.additionalParameters.children || {};
					else _data = {}
				}
				
				if(_data != null)
					setTimeout(function(){callback({ data: _data });} , parseInt(Math.random() * 500) + 200);
			}
			
			return {'dataSource1': dataSource1}
		}
		// fin

		$('#tree1')
		// .on('loaded.fu.tree', function(e) {
		// 	console.log('1',e);
		// })
		.on('updated.fu.tree', function(e, result) {
			// console.log('2',result);
		})
		.on('selected.fu.tree', function(evt, data) {
			// console.log('deselected', data);
			// var m = $('#tree1 input[type="checkbox"]:checked');;
		})
		.on('deselected.fu.tree', function(e, result) {
			console.log('4',e, result);//deselected
		})

		// cargar items
		function itemselecttree() {
            var output = "";
            var ids = "";
            var vec = ['require'];
			
            var items = $('#tree1').tree('selectedItems');
            for (var i in items) if (items.hasOwnProperty(i)) {
                var item = items[i];
                ids += item.additionalParameters['id'] + ",";
                output += item.text + ",";
                vec.push(item.id);
            }
            return vec;
        }
        // fin
	
		// llenar combo usuarios
		function llenar_select_usuarios() {
			$.ajax({
				url: 'data/privilegios/app.php',
				type: 'post',
				data: {llenar_usuarios:'llenar_usuarios'},
				success: function (data) {
					$('#select_usuario').html(data);
				}
			});
		}
		// fin

		// inicio de procesos
		llenar_select_usuarios();
		cargar_tree();
		// llenar select usuario
	});
});