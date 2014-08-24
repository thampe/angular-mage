(function(){
    'use strict';

    angular
        .module('mage.session', [])
        .run(initSession)
    ;

    initSession.$inject = ['$http', 'authToken'];

    function initSession($http, authToken) {
        //Set AuthToken for Requests
        $http.defaults.headers.common['Mage-Auth-Token'] = authToken;
    }

})();