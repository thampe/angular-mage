(function(){
    'use strict';

    angular
        .module('mage.model')
        .factory('mageModel', modelFactory)
    ;

    modelFactory.$inject = ['$http','mageUrl'];

    function modelFactory($http, mageUrl) {
        return {
            getModel: getModel,
            getCollection: getCollection
        };

        function getModel(model, id, field) {

            var params = {'class': model, 'id': id};
            if(field) {
                params['field'] = field;
            }
            var url = mageUrl.getUrl('angular/model/model', params);
            return $http.get(url)
                .then(onComplete)
                .catch(onError);


            function onComplete(data, status, headers, config) {
                return data.data;
            }

            function onError(error) {
                console.log("Error: "+ error);
            }
        }

        function getCollection(model, filters, select, limit, page) {

            var params = {'class': model};

            if(filters) { params['filters'] = filters; }
            if(select)  { params['select'] = select; }
            if(limit)   { params['limit'] = parseInt(limit); }
            if(page)   { params['page'] = parseInt(page); }

            var url = mageUrl.getUrl('angular/model/collection', params);

            return $http.get(url)
                .then(onComplete)
                .catch(onError);


            function onComplete(data, status, headers, config) {
                return data.data;
            }

            function onError(error) {
                console.log("Error: "+ error);
            }

        }
    }


})();