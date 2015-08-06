'use strict';

app.config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise("/");
    
    $stateProvider.state(
        "index",
        {
            url: "/",
            templateUrl: "/views/index.html"
        }
    );
});

angular.module('myApp.services', []).factory('Example', function($resource) {
    return $resource('/admin/example/:exampleId', { id: '@_exampleId' }, {
        update: {
            method: 'PUT'
        }
    });
});