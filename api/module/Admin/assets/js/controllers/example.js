'use strict';

app
.controller(
    "gridController",
    function($scope, CrudControllerService) {
        
        // first call the init method to setup
        // the service
        CrudControllerService.init();
        
        /*
         * Commented out for testing
         * function NewModel() {}
        NewModel.prototype = Object.create(Model.prototype);
        NewModel.prototype.isValid = function () {
            return false;
        };
        
        CrudControllerService.setModel(new NewModel());*/
        
        // update the scope properties for the ngView
        // from the CrudControllerService
        $scope.gridOptions = CrudControllerService.get('gridOptions') || {};
        $scope.gridOptions.data = CrudControllerService.getItems();
        $scope.title = CrudControllerService.getTitle();
    }
);
app
.controller(
    "editController",
    function($scope, $state, $stateParams, Example) {
        $scope.updateExample = function() { //Update the edited movie. Issues a PUT to /api/movies/:id
          $scope.example.$update(function() {
            $state.go('index'); // on success go back to home i.e. movies state.
          });
        };
       
        $scope.loadExample = function() { //Issues a GET request to /api/movies/:id to get a movie to update
          $scope.example = Example.get({ exampleId: $stateParams.exampleId });
        };
       
        $scope.loadExample(); // Load a movie which can be edited on UI
      });
