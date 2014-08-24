(function(){
    'use strict';

    angular
        .module('mage.price')
        .service('magePriceFormat', priceFormatService)
    ;

    priceFormatService.$inject = ['priceFormat'];

    function priceFormatService(priceFormat) {
        this.formatPrice = function(price) {
            price = parseFloat(price);

            return formatCurrency(price, priceFormat);
        }
    }
})();