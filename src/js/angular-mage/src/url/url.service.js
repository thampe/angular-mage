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
            return _getUrl(secure ? baseUrl : baseUrlSecure, path, params)
        };
        this.getSkinUrl = function(path, params, secure) {
            return _getUrl(secure ? skinUrl : skinUrlSecure, path, params)
        };
        this.getMediaUrl = function(path, params, secure) {
            return _getUrl(secure ? mediaUrl : mediaUrlSecure, path, params)
        };
        this.getJsUrl = function(path, params, secure) {
            return _getUrl(secure ? jsUrl : jsUrlSecure, path, params)
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


