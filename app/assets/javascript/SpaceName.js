/**
 * SpaceName namspace for front-end framework agnostic 'classes' {Object}'s and
 * methods
 * - agnostic (but writtern for Angular)
 * 
 * @link https://github.com/gadgetdave/zf2-angular-ui-project-template
 * @copyright LOL
 * @license LOL
 */
var SpaceName = (function () {
    var Model,
        ControllerService,
        CrusControllerService,
        addObjectProperties,
        crudControllerServiceMethods;

    /**
     * Utility function for 'merging' object with
     * passed object
     * 
     * @param {Object} object
     * @param {Object} properties
     * 
     * @return {Object} passed object
     */
    addObjectProperties = function (object, properties) {
        // for the given object lets add the properties to the CrudController prototype
        // this is a bit cleaner than multiple lines of single property assignment
        for (var prop in properties) {
            object[prop] = properties[prop];
        }
        
        return object;
    };
    
    /**
     * Model 'class' for use with CrudControllerService
     */
    Model = function () {}
    Model.prototype.isValid = function () {
        return true;
    };

    /**
     * ControllerService 'class' for use with back end controllers that don't
     * require crud functionality
     */
    ControllerService = function () {
        this.viewConfig = {};
        this.title = '';
    };
    
    /**
     * CrontrollerService prototype {Object}
     */
    ControllerService.prototype = {
        /**
         * init method - this is used to initialise
         * the Object.
         * 
         * @return void
         */
        init : function () {
            this.setViewConfig(VIEW_DATA);
        },
        
        /**
         * populate the internal properties
         * from the passed object
         * 
         * @param {Object} variables
         * @return void
         */
        populateProperties : function (variables) {
            for (var prop in variables) {
                if (variables.hasOwnProperty(prop)) {
                    this[prop] = variables[prop];
                }
            }
        },
        
        /**
         * setter for viewConfig
         * 
         * @param {Object} vConfig
         * @return void
         */
        setViewConfig : function (vConfig) {
            if (!vConfig) {
                return;
            }
            
            this.viewConfig = vConfig;
            this.populateProperties(vConfig);
        },
        
        /**
         * getter for internal property
         * 
         * @return String
         */
        getTitle : function () {
            return this.title;
        },
        
        /**
         * @param {String} property
         * @return multitype
         */
        get : function (property) {
            if (typeof property !== 'string') {
                return;
            }
            
            return this[property];
        }
    };

    CrudControllerService = function () {
        // call the super constructor
        ControllerService.call(this);

        this.gridOptions;
        this.model = new Model();
        this.getItemsUrl = '';
        this.items;
    };

    // inherit from ControllerService
    CrudControllerService.prototype = Object.create(ControllerService.prototype);

    CrudControllerService.prototype = angular.extend(CrudControllerService.prototype, {
        /**
         * getter for internal property
         * 
         * @return {Object}
         */
        getModel : function () {
            return this.model;
        },
        
        /**
         * setter for internal property
         * 
         * @param {Object} model
         * @return void
         */
        setModel : function (model) {
            this.model = model;
        },
        
        testIsValid : function (test) {
            console.log(this.model.isValid(test));
        },
        
        /**
         * getter for internal property items
         * 
         * @param boolean 
         * @return {Array}
         */
        getItems : function (forceFetch) {
            if (this.items) {
                return this.items;
            }
            
            if (VIEW_DATA) {
                if (VIEW_DATA.items) {
                    this.items = VIEW_DATA.items;
                }
            }
            
            return this.items;
        }
    });
    
    // add service to angular app
    return {
        Model : Model,
        
        ConttrollerService : ControllerService,
        
        CrudControllerService : CrudControllerService,
        
        addObjectProperties : addObjectProperties
    };
}());