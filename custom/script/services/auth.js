/**
 * Created by Aditech on 5/25/2016.
 */
/**
 * Created by Aditech on 1/12/2016.
 */
(function(){
    'use strict';
    function AuthService($http, $window){
        var auth = {};
        // var baseUrl = 'http://169.254.122.238';
        var baseUrl = '';
        // var baseUrl = 'http://localhost:8080/admin/';

        //save token
          auth.saveToken = function (token){
              $window.localStorage['userToken'] = token;
          };
          //save user info
          auth.saveUser = function (user) {
              $window.localStorage['userData'] = user;
          };
          //get token
          auth.getToken = function (){
              return window.localStorage.getItem('userToken');
          };
          //check if userprofile is logged in.
          auth.isLoggedIn = function(){
              // return true;
              return window.localStorage.getItem('userData');
          };
          auth.currentUser = function(){
              if(auth.isLoggedIn()){
                  return JSON.parse(window.localStorage.getItem('userData'));
              }
          };

        auth.registerAdmin = function(user){
            return $http.post(baseUrl + 'server/admin/addadmin.php', user)
        };

        auth.Login = function(user){
            return $http.post(baseUrl  + 'server/login/index.php',user).success(function (data){
              auth.saveUser(JSON.stringify(data));
              auth.saveToken(JSON.stringify(data));
            })
        };

        auth.getAdministrators = function(){
            return $http.get(baseUrl + 'server/requests.php?op=getadmin');
        }
    
        auth.deleteAdmin = function (id){
            return $http.get(baseUrl + 'server/requests.php?id='+id+'&op=deleteAdmin');
        }

        auth.getAdminById = function(id){
            return $http.get(baseUrl + 'server/requests.php?id='+id+'&op=getAdminById');
        };


         //logout function to remove userprofile token
        auth.logOut = function(){
            return $http.post(baseUrl + 'server/logout/index.php',{token:sessionStorage.getItem('token'),
            id:JSON.parse(sessionStorage.getItem('user')).userid}).success(function(){
                $window.localStorage.removeItem('token');
                $window.localStorage.removeItem('user');
                sessionStorage.removeItem('user');
                sessionStorage.removeItem('token');
            });
        };

        return auth;
    }

    angular.module('myApp')
        .factory('auth', ['$http','$window', AuthService])
}());
