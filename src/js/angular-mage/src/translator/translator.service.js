(function(){
    'use strict';

    angular
        .module('mage.translator')
        .service('mageTranslator', mageTranslatorService)
    ;

    function mageTranslatorService(){
        this.translate = function(str) {
            return Translator.translate(str);
        };
        this.add = function(str, translation) {
            Translator.add(str, translation);
        };
    }
})();