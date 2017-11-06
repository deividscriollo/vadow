var app = angular.module('scotchApp', ['ngRoute','ngResource','ngStorage']);

app.directive('hcChart', function () {
    return {
        restrict: 'E',
        template: '<div></div>',
        scope: {
            options: '='
        },
        link: function (scope, element) {
            Highcharts.chart(element[0], scope.options);
        }
    };
})

app.directive('hcPieChart', function () {
    return {
        restrict: 'E',
        template: '<div></div>',
        scope: {
            title: '@',
            data: '='
        },
        link: function (scope, element) {
            Highcharts.chart(element[0], {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: scope.title
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    data: scope.data
                }]
            });
        }
    };
})

// configure our routes
app.config(function($routeProvider) {
    $routeProvider
        // route page initial
        .when('/', {
            templateUrl : 'data/inicio/index.html',
            // controller  : 'mainController',
            activetab: 'inicio'
        })
        // route facturero
        .when('/facturero', {
            templateUrl : 'data/facturero/index.html',
            controller  : 'factureroController',
            activetab: 'facturero'
        })
        // route talonario
        .when('/talonario', {
            templateUrl : 'data/talonario/index.html',
            controller  : 'talonarioController',
            activetab: 'talonario'
        })
        // route cargos
        .when('/cargos', {
            templateUrl : 'data/cargos/index.html',
            controller  : 'cargosController',
            activetab: 'cargos'
        })
        // route privilegios
        .when('/privilegios', {
            templateUrl : 'data/privilegios/index.html',
            controller  : 'privilegiosController',
            activetab: 'privilegios'
        })
        // route empresa
        .when('/empresa', {
            templateUrl : 'data/empresa/index.html',
            controller  : 'empresaController',
            activetab: 'empresa'
        })
        // route logo empresa
        .when('/logo_empresa', {
            templateUrl : 'data/logo_empresa/index.html',
            controller  : 'logo_empresaController',
            activetab: 'logo_empresa'
        })
        // route tipo_productos
        .when('/tipo_transaccion', {
            templateUrl : 'data/tipo_transaccion/index.html',
            controller  : 'tipo_transaccionController',
            activetab: 'tipo_transaccion'
        })
        // route tipo_productos
        .when('/tipo_comprobante', {
            templateUrl : 'data/tipo_comprobante/index.html',
            controller  : 'tipo_comprobanteController',
            activetab: 'tipo_comprobante'
        })
        // route tipo_productos
        .when('/formas_pago', {
            templateUrl : 'data/formas_pago/index.html',
            controller  : 'formas_pagoController',
            activetab: 'formas_pago'
        })
        // route porcentajes
        .when('/porcentaje', {
            templateUrl : 'data/porcentaje/index.html',
            controller  : 'porcentajeController',
            activetab: 'porcentaje'
        })
        // route tipo_productos
        .when('/retencion_fuente', {
            templateUrl : 'data/retencion_fuente/index.html',
            controller  : 'retencion_fuenteController',
            activetab: 'retencion_fuente'
        })
        // route tipo_productos
        .when('/retencion_iva', {
            templateUrl : 'data/retencion_iva/index.html',
            controller  : 'retencion_ivaController',
            activetab: 'retencion_iva'
        })
        // route tipo_productos
        .when('/tipo_productos', {
            templateUrl : 'data/tipo_productos/index.html',
            controller  : 'tipo_productosController',
            activetab: 'tipo_productos'
        })
        // route categorias
        .when('/categorias', {
            templateUrl : 'data/categorias/index.html',
            controller  : 'categoriasController',
            activetab: 'categorias'
        })
        // route marcas
        .when('/marcas', {
            templateUrl : 'data/marcas/index.html',
            controller  : 'marcasController',
            activetab: 'marcas'
        })
        // route unidades de medida
        .when('/medida', {
            templateUrl : 'data/medida/index.html',
            controller  : 'medidaController',
            activetab: 'medida'
        })
        // route bodegas
        .when('/bodegas', {
            templateUrl : 'data/bodegas/index.html',
            controller  : 'bodegasController',
            activetab: 'bodegas'
        })
        // route clientes
        .when('/clientes', {
            templateUrl : 'data/clientes/index.html',
            controller  : 'clientesController',
            activetab: 'clientes'
        })
        // route proveedores
        .when('/proveedores', {
            templateUrl : 'data/proveedores/index.html',
            controller  : 'proveedoresController',
            activetab: 'proveedores'
        })
        // route productos
        .when('/productos', {
            templateUrl : 'data/productos/index.html',
            controller  : 'productosController',
            activetab: 'productos'
        })
        // route usuarios
        .when('/fotos_articulo', {
            templateUrl : 'data/fotos_articulo/index.html',
            controller  : 'fotos_articuloController',
            activetab: 'fotos_articulo'
        })
        // route importar
        .when('/importar', {
            templateUrl : 'data/importar/index.html',
            controller  : 'importarController',
            activetab: 'importar'
        })
         // route importar
        .when('/inventario', {
            templateUrl : 'data/inventario/index.html',
            controller  : 'inventarioController',
            activetab: 'inventario'
        })
        // route para los movimientos
        .when('/movimientos', {
            templateUrl : 'data/movimientos/index.html',
            controller  : 'movimientosController',
            activetab: 'movimientos'
        })
        // route para los kardex
        .when('/kardex', {
            templateUrl : 'data/kardex/index.html',
            controller  : 'kardexController',
            activetab: 'kardex'
        })
          // route para el login
        .when('/login', {
            templateUrl : 'data/login/index.html',
            controller  : 'loginController',
        })
        // proceso proformas
        .when('/proformas', {
            templateUrl : 'data/proformas/index.html',
            controller  : 'proformasController',
            activetab: 'proformas'
        })
        // proceso proformas
        .when('/factura_venta', {
            templateUrl : 'data/factura_venta/index.html',
            controller  : 'factura_ventaController',
            activetab: 'factura_venta'
        })
        // proceso factura compra
        .when('/factura_compra', {
            templateUrl : 'data/factura_compra/index.html',
            controller  : 'factura_compraController',
            activetab: 'factura_compra'
        })
        // proceso devolucion compra
        .when('/devolucion_compra', {
            templateUrl : 'data/devolucion_compra/index.html',
            controller  : 'devolucion_compraController',
            activetab: 'devolucion_compra'
        })
        // proceso factura venta
        .when('/factura_venta', {
            templateUrl : 'data/factura_venta/index.html',
            controller  : 'factura_ventaController',
            activetab: 'factura_venta'
        })
        // proceso nota credito
        .when('/nota_credito', {
            templateUrl : 'data/nota_credito/index.html',
            controller  : 'nota_creditoController',
            activetab: 'nota_credito'
        })
        // proceso ingresos
        .when('/ingresos', {
            templateUrl : 'data/ingresos/index.html',
            controller  : 'ingresosController',
            activetab: 'ingresos'
        })
        // proceso egresos
        .when('/egresos', {
            templateUrl : 'data/egresos/index.html',
            controller  : 'egresosController',
            activetab: 'egresos'
        })
        // proceso cuentas cobrar
        .when('/cuentas_cobrar', {
            templateUrl : 'data/cuentas_cobrar/index.html',
            controller  : 'cuentas_cobrarController',
            activetab: 'cuentas_cobrar'
        })
        // proceso cuentas pagar
        .when('/cuentas_pagar', {
            templateUrl : 'data/cuentas_pagar/index.html',
            controller  : 'cuentas_pagarController',
            activetab: 'cuentas_pagar'
        })
        // route usuarios
        .when('/usuarios', {
            templateUrl : 'data/usuarios/index.html',
            controller  : 'usuariosController',
            activetab: 'usuarios'
        })
        // route fotos usuario
        .when('/fotos_usuario', {
            templateUrl : 'data/fotos_usuario/index.html',
            controller  : 'fotos_usuarioController',
            activetab: 'fotos_usuario'
        })
        // route cuenta
        .when('/cuenta', {
            templateUrl : 'data/cuenta/index.html',
            controller  : 'cuentaController',
            activetab: 'cuenta'
        })
        // proceso reportes varios
        .when('/reporte_directores', {
            templateUrl : 'data/reporte_directores/index.html',
            controller  : 'reporte_directoresController',
            activetab: 'reporte_directores'
        })
        // proceso reportes productos
        .when('/reporte_productos', {
            templateUrl : 'data/reporte_productos/index.html',
            controller  : 'reporte_productosController',
            activetab: 'reporte_productos'
        })
        // proceso reportes productos
        .when('/reporte_compras', {
            templateUrl : 'data/reporte_compras/index.html',
            controller  : 'reporte_comprasController',
            activetab: 'reporte_compras'
        })
        // proceso reportes productos
        .when('/reporte_ventas', {
            templateUrl : 'data/reporte_ventas/index.html',
            controller  : 'reporte_ventasController',
            activetab: 'reporte_ventas'
        })
        // proceso reportes productos
        .when('/reporte_proformas', {
            templateUrl : 'data/reporte_proformas/index.html',
            controller  : 'reporte_proformasController',
            activetab: 'reporte_proformas'
        })
        // proceso reportes estadisticos
        .when('/reportes_estadisticos', {
            templateUrl : 'data/reportes_estadisticos/index.html',
            controller  : 'reportes_estadisticosController',
            activetab: 'reportes_estadisticos'
        })
});

app.factory('Auth', function($location) {
    var user;
    return {
        setUser : function(aUser) {
            user = aUser;
        },
        isLoggedIn : function() {
            var ruta = $location.path();
            var ruta = ruta.replace("/","");
            var accesos = JSON.parse(Lockr.get('users'));
                accesos.push('inicio');
                accesos.push('');

            var a = accesos.lastIndexOf(ruta);
            if (a < 0) {
                return false;    
            } else {
                return true;
            }
        }
    }
});


app.run(['$rootScope', '$location', 'Auth', function ($rootScope, $location, Auth) {
    $rootScope.$on('$routeChangeStart', function (event) {
        var rutablock = $location.path();
        if (!Auth.isLoggedIn()) {
            event.preventDefault();
            swal({
                title: "Lo sentimos acceso denegado",
                type: "warning",
            });
        } else { }
    });
}]);

// consumir servicios sri
app.factory('loaddatosSRI', function($resource) {
    return $resource("http://186.4.167.12/appserviciosnext/public/index.php/getDatos/:id", {
        id: "@id"
    });
});
// fin

    