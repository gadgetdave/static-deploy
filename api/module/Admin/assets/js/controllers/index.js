'use strict';

app
.controller(
    "dashboardController",
    function($scope, ControllerService) {
        
        ControllerService.init();
        
        $scope.title = ControllerService.getTitle();
    }
);

