/**
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 */

'use strict';

/**
 * Base object to extend modules.
 */
var module = (function() {
    /**
     * App-Object represented in this scope.
     *
     * @type {{object}}
     */
    var object = {};

    // Private functions

    var environment = {/** @global config */'debug': (typeof config !== 'undefined') ? config.debug : false};

    /**
     * @returns {bool}
     * @constructor
     */
    object.DEBUG = () => environment.debug;


    // Public functions

    /**
     * Function to initialize the module.
     */
    object.init = function() {
        // Implement this function in your module.
        if (this.DEBUG()) {console.error('Missing implementation of function init in your module.');}
    };

    /**
     * Clones itself to create new module
     */
    object.clone = function() {
        var clone = Object.create( Object.getPrototypeOf( this ) ) ;
        var i , keys = Object.getOwnPropertyNames( this ) ;

        for ( i = 0 ; i < keys.length ; i ++ )
        {
            Object.defineProperty( clone , keys[ i ] ,
                Object.getOwnPropertyDescriptor( this , keys[ i ] )
            ) ;
        }

        return clone ;
    };

    return object;
})();
