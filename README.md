# This repository is no longer maintained.
 
Issue reports and pull requests will not be attended.

# Magento on Angular-Steroids
Angular-Modules with some neat Magento functionality.

## Installation
Install it via [modman](https://github.com/colinmollenhour/modman). There is also a ``composer.json`` if you want to add it to *your* Composer-Repository. Or just copy the files in ``src/`` into your magento-instance.

## Usage

### URL-Generation
Required Angular Module: ``mage.url``

Inspired by ``Mage::getUrl()``.
Syntax: ``mageUrl.getUrl(path, params, secure)``

```javascript
angular
    .module('app', ['mage.url'])
    .controller('DemoUrlCtrl', ['mageUrl', function(mageUrl){

        // Shop Url
        var url = mageUrl.getUrl('catalog/product/view', {id: 1}); // => http://magento.dev/catalog/product/view?id=1
        // Secure Shop Url
        var secure = true;
        var secureUrl = mageUrl.getUrl('catalog/product/view', {id: 1}, secure); // => https://magento.dev/catalog/product/view?id=1

        //media url
        var mediaUrl = mageUrl.getMediaUrl('dhl/logo.jpg'); // => http://magento.dev/media/dhl/logo.jpg

        //skin url
        //ATTENTION: You need to provide the design folder (e.g frontend/base/default)
        var skinUrl = mageUrl.getSkinUrl('frontend/default/default/images/logo.gif'); // => http://magento.dev/skin/frontend/default/default/images/logo.gif

        //js url
        var jsUrl = mageUrl.getJsUrl('angular/angular.min.js'); // => http://magento.dev/js/angular/angular.min.js

    }]);
;
```

### Models and Collections
Required Angular Module: ``mage.model``

Query *any* Model/Collection you like. By default ``catalog/product`` and ``catlog/category`` are enabled.

#### Models
Inspired by ``Mage::getModel($modelClass)->load($id, $identifier = null)``.
Syntax: ``mageModel.getModel(modelClass, id, identifier);``, the identifier is optional and if not set defaults to the ``identifierName`` of the model.

##### Examples

```javascript
angular
    .module('app', ['mage.model'])
    .controller('DemoModelCtrl', ['mageModel', function(mageModel){

        //get the category with entity_id 3
        mageModel.getModel('catalog/category', 3).then(function (category) {
           console.log(category);
        });

        //get the product with sku 'ABC1234'
        mageModel.getModel('catalog/product', 'ABC1234', 'sku').then(function (product) {
           console.log(product);
        });
    }]);
;
```


#### Collection

Inspired by ``Mage::getModel($modelClass)->getCollection()``.
Syntax: ``mageModel.getCollection(modelClass, filters, select, limit, page);``.

* ``filters`` work like ``$collection->addAttributeToFilter()`` or ``$collection->addFieldToFilter()``
* ``select`` works like ``collection->addAttributeToSelect()``
* ``limit`` limits the collection size.
* ``page`` the current page, only useful in combination with ``limit``


##### Examples

```javascript
angular
    .module('app', ['mage.model'])
    .controller('DemoModelCtrl', ['mageModel', function(mageModel){

        //get all products with color id = 3, select all attributes limit to 30 Result and get the first result page.
        mageModel.getCollection('catalog/product', {color: 3}, ['*'], 30, 1).then(function (products) {
           console.log(products);
        });

        //get all categories and select the name attribute.
        mageModel.getCollection('catalog/category', {}, ['name']).then(function (categories) {
           console.log(categories);
        });
    }]);
;
```

#### Enable more Models

Enable more Models, by adding them to your ``config.xml``

##### Example

```xml
<?xml version="1.0"?>
<config>
<!-- (...) -->
    <default>
        <angular>
            <models>
                <unique_identifier> <!-- a unique indentier -->
                    <model>namespace/class</model> <!-- e.g customer/address -->
                    <allowed>true</allowed> <!-- optional: setting this to false will disbale this model -->
                    <serializer>namespace/serializer_class</serializer>
                    <!-- optional: if you want to use a diffrent serializer (Default: Hampe_Angular_Model_Serializer_Default), your serializer must implement the Hampe_Angular_Model_Serializer_Interface  -->
                </unique_identifier>
                <!-- (...) -->
            </models>
        </angular>
    </default>
</config>
```

### Display Prices
Required Angular Module: ``mage.price``
Display a price in the shop currency.

#### Price Service

```javascript
angular
    .module('app', ['mage.price'])
    .controller('DemoPriceCtrl', ['magePriceFormat', function(magePriceFormat){

        var formatedPrice = magePriceFormat.formatPrice(12.22) // => 12,22 €

    }]);
;
```

#### Price Filter

```html
<div ng-app="app">
    <div ng-controller="DemoPriceCtrl">
        <span>{{ 12.22|formatPrice }}</span>
    </div>
</div>
```

#### Price Directive

```html
<div ng-app="app">
    <div ng-controller="DemoPriceCtrl">
        <mage-price value="12.22"></mage-price> <!-- <span class="price">12,22 €</span> -->
    </div>
</div>
```


### Translate
Required Angular Module: ``mage.tranlator``
Uses the magento javascript translator, add your translations via a ```jstranslator.xml``` as always.

#### Translator Service
```javascript
angular
    .module('app', ['mage.tranlator'])
    .controller('DemoTranslatorCtrl', ['mageTranslator', function(mageTranslator){

        //add translation on the fly
        mageTranslator.add('Hello World', 'Hallo Welt');

        // translate
        var germanHelloWorld = mageTranslator.translate('Hello World') // => "Hallo Welt"

    }]);
;
```

#### Translator Filter

```html
<div ng-app="app">
    <div ng-controller="DemoTranslatorCtrl">
            {{ "HTML tags are not allowed"|trans }}
            <!-- HTML-Tags sind nicht erlaubt -->
    </div>
</div>
```

### Customer Information
Required Angular Module: ``mage.customer``

#### Example

```javascript
angular
    .module('app', ['mage.customer'])
    .controller('DemoCustomerCtrl', ['mageCurrentCustomer', function(mageCurrentCustomer){

        if(mageCurrentCustomer.isLoggedIn()) {
            mageCurrentCustomer.getCurrentCustomer().then(function(customer){
                console.log(customer);
            });
        }

    }]);
;
```

### Misc

For convenience, there is also an angular module ``mage``, which requires all mage-modules.

All AJAX-Requests include an auth-token (tied to the user session) in the header, to make XSS-attacks more difficult.

This software is not battle-tested (yet), so bugs are inclued for free.

## Build
Use [gulp](http://gulpjs.com) to build and minify the javascript, if you feel the need to change or fix something. Issues and Pull requests are appreciated.

## License
See the [LICENSE](LICENSE) file for license info (it's the MIT license).
