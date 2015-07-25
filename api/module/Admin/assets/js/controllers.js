'use strict';

/* Controllers */

var myAppControllers = angular.module('myApp.controllers', []);

// Here we set global functions available to all the controllers and scopes.
// Theses functions are used throughout the app and we don't want to clutter
// the controllers, so we store them in a global place.
myAppControllers.run(['$rootScope', 'Utils', function($rootScope, Utils) {
    $rootScope.openModal = Utils.openModal;

    $rootScope.goto = function(location) {
        window.location.href = location;
    };
}]);