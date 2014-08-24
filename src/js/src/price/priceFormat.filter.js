(function(){
    'use strict';

    angular
        .module('mage.price')
        .filter('formatPrice', priceFormatFilter)
    ;

    priceFormatFilter.$inject = ['magePriceFormat'];

    function priceFormatFilter(magePriceFormat) {
        return function(price) {
            return magePriceFormat.formatPrice(parseFloat(price));
        }
    }
})();