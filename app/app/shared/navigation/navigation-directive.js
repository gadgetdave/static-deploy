app.directive('navigation', function () {
    'use strict';
    return {
        templateUrl: '/app/shared/navigation/navigation-view.html',
        restrict: 'E',
        replace: true
    };
});