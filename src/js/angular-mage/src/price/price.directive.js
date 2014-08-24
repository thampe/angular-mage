(function(){
    'use strict';
    angular
        .module('mage.price')
        .directive('magePrice', magePrice)
    ;

    magePrice.$inject = ['magePriceFormat'];

    function magePrice() {
        return  {
            restrict: 'EA',
            replace: true,
            scope: {price: '=value'},
            template: '<span class="price">{{price | formatPrice}}</price>'
        };

    }
})();