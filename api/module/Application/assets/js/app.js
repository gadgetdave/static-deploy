'use strict';

// Declare app level module which depends on filters, and services
angular.module(
    'myApp',
    [
        'ui.bootstrap', 
        'ui.router',
        'ngTable'
    ]
).config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise("/index");
    
    $stateProvider.state(
        "index",
        {
            url: "/index",
            templateUrl: "/assets/views/index.html"
        }
    );
});