(function(){
    angular
        .module('mage', [
            'mage.url',
            'mage.model',
            'mage.customer',
            'mage.price',
            'mage.translator',
            'mage.session'
        ]);
})();


(function(){
    'use strict';

    angular
        .module('mage.customer', ['mage.url', 'mage.session']);
})();
(function(){
    'use strict';

    angular
        .module('mage.model', ['mage.url', 'mage.session']);
})();
(function(){
    'use strict';

    angular
        .module('mage.price', []);
})();
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
(function(){
    'use strict';

    angular
        .module('mage.translator', [])
    ;
})();
(function(){
    'use strict';

    angular
        .module('mage.url', []);
})();


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
(function(){
    'use strict';

    angular
        .module('mage.url')
        .service('mageUrl', mageUrlService)
    ;
    mageUrlService.$inject = ['baseUrl', 'skinUrl', 'mediaUrl', 'jsUrl', 'baseUrlSecure', 'skinUrlSecure', 'mediaUrlSecure', 'jsUrlSecure'];

    function mageUrlService(
        baseUrl,
        skinUrl,
        mediaUrl,
        jsUrl,
        baseUrlSecure,
        skinUrlSecure,
        mediaUrlSecure,
        jsUrlSecure
        ){
        this.getUrl = function(path, params, secure) {
            return _getUrl(!secure ? baseUrl : baseUrlSecure, path, params)
        };
        this.getSkinUrl = function(path, params, secure) {
            return _getUrl(!secure ? skinUrl : skinUrlSecure, path, params)
        };
        this.getMediaUrl = function(path, params, secure) {
            return _getUrl(!secure ? mediaUrl : mediaUrlSecure, path, params)
        };
        this.getJsUrl = function(path, params, secure) {
            return _getUrl(!secure ? jsUrl : jsUrlSecure, path, params)
        };

        function _getUrl(baseUrl, path, params) {
            path = path || "";
            params = params || {};
            
            var url = baseUrl + path;
            var query = queryBuilder(params);
            if(query) {
                url += "?"+query;
            }
            return url;
        }
    }

    //Credit: https://gist.github.com/dgs700/4677933
    function queryBuilder (a) {
        var prefix, s, add, name, r20, output;
        s = [];
        r20 = /%20/g;
        add = function (key, value) {
            // If value is a function, invoke it and return its value
            value = ( typeof value == 'function' ) ? value() : ( value == null ? "" : value );
            s[ s.length ] = encodeURIComponent(key) + "=" + encodeURIComponent(value);
        };
        if (a instanceof Array) {
            for (var name = 0; name < a.length; a++) {
                add(name, a[name]);
            }
        } else {
            for (prefix in a) {
                _buildParams(prefix, a[ prefix ], add);
            }
        }
        output = s.join("&").replace(r20, "+");
        return output;
    }
    function _buildParams(prefix, obj, add) {
        var name, i, l, rbracket;
        rbracket = /\[\]$/;
        if (obj instanceof Array) {
            for (i = 0, l = obj.length; i < l; i++) {
                if (rbracket.test(prefix)) {
                    add(prefix, obj[i]);
                } else {
                    _buildParams(prefix + "[" + ( typeof obj[i] === "object" ? i : "" ) + "]", obj[i], add);
                }
            }
        } else if (typeof obj == "object") {
            // Serialize object item.
            for (name in obj) {
                _buildParams(prefix + "[" + name + "]", obj[ name ], add);
            }
        } else {
            // Serialize scalar item.
            add(prefix, obj);
        }
    }

})();


