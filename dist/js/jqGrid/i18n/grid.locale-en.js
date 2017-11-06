;(function($){
/**
 * jqGrid English Translation
 * Tony Tomov tony@trirand.com
 * http://trirand.com/blog/ 
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/
$.jgrid = $.jgrid || {};
$.extend($.jgrid,{
	defaults : {
		recordtext: "Mostrando {0} - {1} de {2}",
		emptyrecords: "Sin registros que mostrar",
		loadtext: "Loading...",
		pgtext : "Página {0} de {1}"
	},
	search : {
		caption: "Búsqueda...",
		Find: "Buscar",
		Reset: "Limpiar",
		odata: [{ oper:'eq', text:'Igual'},{ oper:'ne', text:'no igual a'},{ oper:'lt', text:'less'},{ oper:'le', text:'less or equal'},{ oper:'gt', text:'greater'},{ oper:'ge', text:'greater or equal'},{ oper:'bw', text:'begins with'},{ oper:'bn', text:'does not begin with'},{ oper:'in', text:'is in'},{ oper:'ni', text:'is not in'},{ oper:'ew', text:'ends with'},{ oper:'en', text:'does not end with'},{ oper:'cn', text:'Contenga'},{ oper:'nc', text:'does not contain'},{ oper:'nu', text:'is null'},{ oper:'nn', text:'is not null'}],
		groupOps: [{ op: "AND", text: "Todos" },{ op: "OR",  text: "Cualquier" }],
		operandTitle : "Haga clic para seleccionar la operación de búsqueda.",
		resetTitle : "Reiniciar la Búsqueda"
	},
	edit : {
		addCaption: "Agregar Registro",
		editCaption: "Modificar Registro",
		bSubmit: "Guardar",
		bCancel: "Cancelar",
		bClose: "Close",
		saveData: "Guardar los cambios?",
		bYes : "Si",
		bNo : "No",
		bExit : "Cancelar",
		msg: {
			required:"Campo Obligatorio",
			number:"Por favor, ingrese un número válido",
			minValue:"Valor debe ser mayor que o igual a",
			maxValue:"Valor debe ser menor que o igual a",
			email: "E-mail incorrecto",
			integer: "Por favor, introduzca un valor entero válido",
			date: "Por favor, introduzca una fecha válida",
			url: "No es una URL válida ('http://' or 'https://')",
			nodefined : "No se define!",
			novalue : " Se requiere un valor de retorno!",
			customarray : "Función personalizada debe devolver array!",
			customfcheck : "Función personalizada debe estar presente en caso de comprobación!"
			
		}
	},
	view : {
		caption: "Consultar Registro",
		bClose: "Close"
	},
	del : {
		caption: "Eliminar",
		msg: "Eliminar registro seleccionado(s)?",
		bSubmit: "Eliminar",
		bCancel: "Cancelar"
	},
	nav : {
		edittext: "",
		edittitle: "Modificar fila selecionada",
		addtext:"",
		addtitle: "Agregar nuevo registro",
		deltext: "",
		deltitle: "Eliminar fila selecionada",
		searchtext: "",
		searchtitle: "Buscar Información",
		refreshtext: "",
		refreshtitle: "Recargar datos",
		alertcap: "Aviso",
		alerttext: "Por favor, seleccione una fila",
		viewtext: "",
		viewtitle: "Ver fila selecionada"
	},
	col : {
		caption: "Seleccione una fila",
		bSubmit: "Ok",
		bCancel: "Cancelar"
	},
	errors : {
		errcap : "Error",
		nourl : "No url is set",
		norecords: "No hay registros que procesar",
		model : "Length of colNames <> colModel!"
	},
	formatter : {
		integer : {thousandsSeparator: ",", defaultValue: '0'},
		number : {decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, defaultValue: '0.00'},
		currency : {decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "", suffix:"", defaultValue: '0.00'},
		date : {
			dayNames:   [
				"Sun", "Mon", "Tue", "Wed", "Thr", "Fri", "Sat",
				"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
			],
			monthNames: [
				"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
				"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
			],
			AmPm : ["am","pm","AM","PM"],
			S: function (j) {return j < 11 || j > 13 ? ['st', 'nd', 'rd', 'th'][Math.min((j - 1) % 10, 3)] : 'th';},
			srcformat: 'Y-m-d',
			newformat: 'n/j/Y',
			parseRe : /[#%\\\/:_;.,\t\s-]/,
			masks : {
				ISO8601Long:"Y-m-d H:i:s",
				ISO8601Short:"Y-m-d",
				ShortDate: "n/j/Y", 
				LongDate: "l, F d, Y",
				FullDateTime: "l, F d, Y g:i:s A",
				MonthDay: "F d", 
				ShortTime: "g:i A", 
					SortableDateTime: "Y-m-d\\TH:i:s",
				UniversalSortableDateTime: "Y-m-d H:i:sO",
				YearMonth: "F, Y"
			},
			reformatAfterEdit : false
		},
		baseLinkUrl: '',
		showAction: '',
		target: '',
		checkbox : {disabled:true},
		idName : 'id'
	}
});
})(jQuery);