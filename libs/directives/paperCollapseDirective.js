/**
 * Created by Aditech on 5/25/2016.
 */
(function () {
    'use strict';
    var pc = angular.module("paperCollapse", []);
    pc.directive("paperCollapse", function() {
        return {
            restrict: "AE",
            templateUrl: "scripts/directives/paper-collapse.ng.html",
            scope: {
                cards: "=paperCollapseCards"
            },
            controller: ["$scope", "$mdDialog", function(l, t) {
                function e(l, t) {
                    l.hide = function() {
                        t.hide()
                    }, l.cancel = function() {
                        t.cancel()
                    }
                }
                l.showAdvanced = function(l) {
                    t.show({
                        controller: e,
                        templateUrl: "partials/pages/dashboard/mail/compose.html",
                        parent: angular.element(document.body),
                        targetEvent: l,
                        clickOutsideToClose: !0
                    })
                }, e.$inject = ["$scope", "$mdDialog"]
            }]
        }
    }).filter('cut', function () {
        return function (value, wordwise, max, tail) {
            if (!value) return '';

            max = parseInt(max, 10);
            if (!max) return value;
            if (value.length <= max) return value;

            value = value.substr(0, max);
            if (wordwise) {
                var lastspace = value.lastIndexOf(' ');
                if (lastspace !== -1) {
                    //Also remove . and , so its gives a cleaner result.
                    if (value.charAt(lastspace-1) === '.' || value.charAt(lastspace-1) === ',') {
                        lastspace = lastspace - 1;
                    }
                    value = value.substr(0, lastspace);
                }
            }

            return value + (tail || ' …');
        };
    });

    function removeUnwanted(){
        return{
            restrict: 'A',
            require: 'ngModel',
            link: function (scope,elem, attr, ctrl) {
                elem.bind('keyup', function (e) {
                    scope.$apply(function () {
                        var b = new RegExp;
                        var a = elem[0].id;
                        if (a === "time") {
                            b = /[^0-9:-]/g
                        } else {
                            if (a === "duration") {
                                b = /[^0-9]/g
                            } else {
                                if (a === "period") {
                                    b = /[^0-9FBS]/g
                                }
                            }
                        }
                        elem[0].value = elem[0].value.replace(b, "");
                    })
                })
            }
        }
    };
    angular.module('NaomiApp')
        .directive('removeUnwanted',removeUnwanted );
})();
