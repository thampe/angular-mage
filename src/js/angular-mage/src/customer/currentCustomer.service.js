(function(){
    'use strict';

    angular
        .module('mage.customer')
        .service('mageCurrentCustomer', mageCurrentCustomer);

    mageCurrentCustomer.$inject = ['$http', 'customerLoggedIn', 'mageUrl'];

    function mageCurrentCustomer($http, customerLoggedIn, mageUrl){
        this.getCurrentCustomer = getCurrentCustomer;
        this.isLoggedIn = isLoggedIn;
        this.getLoginUrl = getLoginUrl;
        this.getLogoutUrl = getLogoutUrl;


        function getCurrentCustomer() {
            var url = mageUrl.getUrl('angular/customer/currentCustomer');

            return $http.get(url, {cache: true})
                .then(onComplete)
                .catch(onError);


            function onComplete(data, status, headers, config) {
                return data.data;
            }

            function onError(error) {
                console.log("Error: "+ error);
            }
        }

        function isLoggedIn(){
            return customerLoggedIn;
        }

        function getLoginUrl () {
            return mageUrl.getUrl('customer/account/login');
        }

        function getLogoutUrl() {
            return mageUrl.getUrl('customer/account/login');
        }
    }
})();