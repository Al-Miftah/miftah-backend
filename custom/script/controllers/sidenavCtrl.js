/**
 * Created by Aditech on 5/25/2016.
 */
(function () {
    'use strict';
    angular.module("myApp").controller("sidenavCtrl", ["$scope", "$location", function(l, t) {
        l.selectedMenu = "dashboard", l.collapseVar = 0, l.check = function(t) {
            t == l.collapseVar ? l.collapseVar = 0 : l.collapseVar = t
        }, l.multiCheck = function(t) {
            t == l.multiCollapseVar ? l.multiCollapseVar = 0 : l.multiCollapseVar = t
        }
    }])
})();
