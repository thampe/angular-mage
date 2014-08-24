(function(){
    'use strict';

    angular
        .module('mage.translator')
        .filter('trans', translateFilter)
    ;

    translateFilter.$inject = ['mageTranslator'];

    function translateFilter(mageTranslator) {
        return function(str) {
            return mageTranslator.translate(str);
        }
    }

})();