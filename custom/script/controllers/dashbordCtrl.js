/**
 * Created by Aditech on 5/25/2016.
 */
(function () {
    'use strict';
    angular.module("myApp")
        .controller("DashboardCtrl", ["$scope", "$state", "$rootScope", "$translate", "$timeout", "$window",'auth',
        function(l, t, e, a, i, s,auth) {
             if(!auth.isLoggedIn()){
               t.go('login');
             }else{
               l.luser = auth.currentUser();
             }

            l.$on('userData',function(evt,value){
              l.luser = value.data;
            });

            //LOGOUT
            l.Logout= function(){
                s.localStorage.removeItem('access_token');
                s.localStorage.removeItem('userData');
                t.go('login');
                // auth.logOut().error(function (data) {
                //     swal('',data.message,'error');
                // }).then(function(){
                //
                // })
            };



            $(window).width() < 1450 && ($(".c-hamburger").removeClass("is-active"),
            $("body").removeClass("extended"));
            l.$state = t;
            e.$on("$stateChangeSuccess", function() {
                i(function() {
                    $("body").scrollTop(0)
                }, 200)
            });
            $("body").hasClass("extended") && i(function() {
                $(".sidebar").perfectScrollbar()
            }, 200);
            l.rtl = function() {
                $("body").toggleClass("rtl")
            };
            l.subnav = function(t) {
                return t == l.showingSubNav ? l.showingSubNav = 0 : l.showingSubNav = t, !1
            };
            l.extend = function() {
                $(".c-hamburger").toggleClass("is-active"),
                $("body").toggleClass("extended"),
                $(".sidebar").toggleClass("ps-container"),
                e.$broadcast("resize"), i(function() {
                $(".sidebar").perfectScrollbar();
            }, 200)
            };
            l.changeTheme = function(l) {
                $("<link>").appendTo("head").attr({
                type: "text/css",
                rel: "stylesheet"
            }).attr("href", "styles/app-" + l + ".css")
            };
            var n = angular.element(s);
            n.bind("resize", function() {
                $(window).width() < 1200 && ($(".c-hamburger").removeClass("is-active"),
                    $("body").removeClass("extended")),
                $(window).width() > 1600 && ($(".c-hamburger").addClass("is-active"),
                    $("body").addClass("extended"))
            });
            $(window).width() < 1200 && e.$on("$stateChangeSuccess", function() {
            $(".c-hamburger").removeClass("is-active"), $("body").removeClass("extended")
        });
            $(window).width() < 600 && e.$on("$stateChangeSuccess", function() {
                $(".mdl-grid").removeAttr("dragula")
            });
            l.changeLanguage = function(l) {
                a.use(l)
            };
    }])
})();
