/**
 * Created by Aditech on 5/25/2016.
 */
(function () {
    'use strict';
    angular.module("myApp")
        .controller("LoginCtrl", ["$scope",'$state','auth', function($scope,$state,auth) {
            if(auth.isLoggedIn()){
              $state.go('channels');
            }
            $scope.user = {email:"",password:""};
            $scope.isProcessing = false;
            $scope.load = false;
            $scope.LoginNow = function (){
              var user = $scope.user;
              $scope.isProcessing = true;
              $scope.load = true;
              if(user.email === "" || user.password === ""){
                swal("","fill out all fields");
                $scope.isProcessing = false;
                $scope.load = false;
              }else{
                auth.Login(user).error(function (err){
                  swal("","Incorrect Email or Password","error");
                  $scope.isProcessing = false;
                  $scope.load = false;
                }).then(function(res){
                  $state.go('channels');
                  $scope.isProcessing = false;
                  $scope.load = false;
                })
              }
            }

    }])
})();
