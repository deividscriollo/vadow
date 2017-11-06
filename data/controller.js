var app = angular.module('vadowApp', ['ngRoute','localytics.directives']);
app.config(function($routeProvider) {
    $routeProvider        
        .when('/', {
            templateUrl : 'data/home/app.html',
            controller  : 'mainController',
            activetab: 'inicio',
            authorize: true
        })       
        .when('/tipoBien', {
            templateUrl : 'data/inventario/tipoBien/app.html',
            controller  : 'tipoBienController',
            activetab: 'tipoBien',
            authorize: true
        })          
        .otherwise("/");                               
})