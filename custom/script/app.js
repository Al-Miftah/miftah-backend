"use strict";
window.app_version = 2, angular.module("myApp", ["ui.router", "ngAnimate", "ngMaterial","lfNgMdFileInput", "chart.js", "gridshore.c3js.chart", "angular-growl", "growlNotifications","angular-loading-bar", "easypiechart", "ui.sortable", angularDragula(angular), "bootstrapLightbox", "materialCalendar", "pascalprecht.translate", "ngMessages",'ngJsonExportExcel']).config(["cfpLoadingBarProvider", function(l) {
    l.latencyThreshold = 5, l.includeSpinner = !1
}]).config( ["$translateProvider", function(l) {
    l.useStaticFilesLoader({
        prefix: "languages/",
        suffix: ".json"
    }), l.preferredLanguage("en")
}]).config(['$urlRouterProvider',function (t) {
    t.otherwise("/app/dashboard/channels");
}]).config(["$stateProvider", function(l) {
  l.state("app", {
      url: "/app",
      templateUrl: "partials/app.html?v=" + window.app_version
  }).state("login", {
      url: "/login",
      parent: "app",
      templateUrl: "partials/pages/login.html?v=" + window.app_version,
      controller: "LoginCtrl"
  }).state("dashboard", {
      url: "/dashboard",
      parent: "app",
      templateUrl: "partials/layouts/dashboard.html?v=" + window.app_version,
      controller: "DashboardCtrl"
  }).state("addAdmin", {
      url: "/addAdmin",
      parent: "dashboard",
      templateUrl: "partials/pages/dashboard/admin/AddAdmin.html?v=" + window.app_version,
      controller: "AdminCtrl"
  }).state("administrators", {
      url: "/administrators",
      parent: "dashboard",
      templateUrl: "partials/pages/dashboard/admin/administrators.html?v=" + window.app_version,
      controller: "AdminCtrl"
  }).state("editAdmin", {
      url: "/editAdmin/:id",
      parent: "dashboard",
      templateUrl: "partials/pages/dashboard/admin/editAdmin.html?v=" + window.app_version,
      controller: "AdminCtrl"
  }).state("channels", {
      url: "/channels",
      parent: "dashboard",
      templateUrl: "partials/pages/dashboard/channel/channels.html?v=" + window.app_version,
      controller: "channelCtrl"
  }).state("createChannel", {
      url: "/createChannel",
      parent: "dashboard",
      templateUrl: "partials/pages/dashboard/channel/createChannel.html?v=" + window.app_version,
      controller: "channelCtrl"
  }).state("editChannel", {
      url: "/editChannel/:id",
      parent: "dashboard",
      templateUrl: "partials/pages/dashboard/channel/editChannel.html?v=" + window.app_version,
      controller: "channelCtrl"
  }).state("AddPlaylist", {
      url: "/AddPlaylist/:channel",
      parent: "dashboard",
      templateUrl: "partials/pages/dashboard/playlist/AddPlaylist.html?v=" + window.app_version,
      controller: "playlistCtrl"
  }).state("playlist", {
      url: "/playlist/:channel",
      parent: "dashboard",
      templateUrl: "partials/pages/dashboard/playlist/playlist.html?v=" + window.app_version,
      controller: "playlistCtrl"
  }).state("editPlaylist", {
      url: "/editPlaylist/:id",
      parent: "dashboard",
      templateUrl: "partials/pages/dashboard/playlist/editPlaylist.html?v=" + window.app_version,
      controller: "playlistCtrl"
  }).state("AddContent", {
    url: "/AddContent/:channel/:playlist",
    parent: "dashboard",
    templateUrl: "partials/pages/dashboard/content/AddContent.html?v=" + window.app_version,
    controller: "contentCtrl"
}).state("content", {
    url: "/content/:channel/:playlist",
    parent: "dashboard",
    templateUrl: "partials/pages/dashboard/content/content.html?v=" + window.app_version,
    controller: "contentCtrl"
}).state("editContent", {
    url: "/editContent/:id",
    parent: "dashboard",
    templateUrl: "partials/pages/dashboard/content/editContent.html?v=" + window.app_version,
    controller: "contentCtrl"
})
}])
// various events being fired
.run(['$rootScope','auth','$state',function ($rootScope) {
      $rootScope.$on('$stateChangeStart', function() {
          $rootScope.loading = true;
      });
      $rootScope.$on('$stateNotFound', function() {

      });
      $rootScope.$on('$stateChangeSuccess', function () {
            $rootScope.loading = false;
            $rootScope.$broadcast('state-change', {stateChange: true});
      });
      $rootScope.$on('$stateChangeError', function(){

      });
      $rootScope.$on('$viewContentLoading', function(){});
      $rootScope.$on('$viewContentLoaded', function(){
      });
  }]);
