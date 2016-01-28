var pessoas = angular.module('Pessoas', ['ngRoute', 'ngResource']);

pessoas
    .config(
        [
            '$routeProvider',
            function($routeProvider) {
                $routeProvider
                    .when('/', {
                        templateUrl: 'pessoas/templates/index.html'
                    })
                    .when('/novo', {
                        templateUrl: 'pessoas/templates/novo.html'
                    })
                    .when('/editar/:id', {
                        templateUrl: 'pessoas/templates/editar.html'
                    })
                ;
            }
        ]
    );