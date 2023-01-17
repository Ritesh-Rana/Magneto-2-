define([
   'uiElement',
   'ko'
],function (Component,ko) {
    'use strict';

    return Component.extend({
        getTime: ko.observable("loading"),
            getTime: function(){
                return new Date;
            }
    });
});