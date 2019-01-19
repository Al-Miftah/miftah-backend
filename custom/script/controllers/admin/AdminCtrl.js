/**
 * Created by Aditech on 5/31/2016.
 */
(function () {
    'use strict';
    angular.module("myApp").controller('AdminCtrl', ['$scope','auth','$state','$stateParams','$rootScope',function ($scope,auth,$state,$stateParams,$rootScope) {
        if(!auth.isLoggedIn()){
          $state.go('login');
        }else{
          $scope.luser = auth.currentUser();
        }
        $scope.isProcessing = false;
        $scope.load = false;
        $scope.isLoading = true;
        //get all admins
        $scope.admins = {};
        auth.getAdministrators().success(function (data) {
          $scope.isLoading = false;
          $scope.admins = data;
        });
        //get admin by id
        if($stateParams.id){
          $scope.admin = {};
          auth.getAdminById($stateParams.id).success(function (data) {
            $scope.admin = data;
            $scope.user = {name:data.name,email:data.email,type:data.type,avatar:data.avatar,pass:"",pass1:"",pass2:"",password:"",status:"",token:""};
          });
        }
        $scope.user = {name:"",email:"",type:"",pass:"",pass1:"",pass2:"",password:"",avatar: "",status:"",token:""};
        $scope.adminType = ["Super Admin","Normal Admin"];
        $scope.AddAdmin = function () {
           var user = $scope.user;
           user.status = 'create';
           $scope.isProcessing = true;
           $scope.load = true;
           if(user.name === "" || user.email === "" || user.type === "" || user.pass1 === "" || user.pass2 === ""){
             swal('','Fill the form data','warning');
             $scope.isProcessing = false;
             $scope.load = false;
           }else if(user.pass1 !== user.pass2){
               swal('','Passwords do not match','warning');
               $scope.isProcessing = false;
               $scope.load = false;
           }

           else {
               user.password = user.pass1;
             auth.registerAdmin(user).success(function (res) {
               if(res.error){
                swal("",res.answer,"error");
               }else{
                swal("","Admin successfully added","success");
                $scope.user = {name:"",email:"",type:"",pass:"",pass1:"",pass2:""};
               }
                 $scope.isProcessing = false;
                 $scope.load = false;
             }).error(function (error) {
               swal("",error.message,"error");
                 $scope.isProcessing = false;
                 $scope.load = false;
             });
           }
       };

       $scope.ChangeInfo = function(){
         var user = $scope.user;
         user.token = auth.getToken();
         user.status = 'update';
         $scope.isProcessing = true;
         $scope.load = true;
         auth.registerAdmin(user).error(function (error) {
           swal("",error.message,"error");
           $scope.isProcessing = false;
           $scope.load = false;
         }).then(function (res) {
            if(res.error){
              swal("",res.answer,"error");
             }else{
              $rootScope.$broadcast('userData',{data:res.data.user});
              swal("","You've successfully updated your information","success")
              $scope.user = {name:"",email:"",type:"",pass:"",pass1:"",pass2:""};
             };
            $scope.isProcessing = false;
            $scope.load = false;
         })
       }

       $scope.ChangePassword = function(){
  
         var user = $scope.user;
         user.token = auth.getToken();
         $scope.isProcessing = true;
         $scope.load = true;
         if(user.pass === "" || user.pass1 === "" || user.pass2 === ""){
           swal('','Fill the form data','warning');
           $scope.isProcessing = false;
           $scope.load = false;
         }else if(user.pass1 !== user.pass2){
             swal('','Passwords do not match','warning');
             $scope.isProcessing = false;
             $scope.load = false;
         }else{
           user.status = 'change_pass';
           auth.registerAdmin(user).error(function (error) {
             swal("",error.message,"error");
             $scope.isProcessing = false;
             $scope.load = false;
           }).then(function (res) {
            if(res.data.error){
              swal("",res.data.answer,"error");
             }else{
              $rootScope.$broadcast('userData',{data:res.data.user});
              $scope.user = {pass:"",pass1:"",pass2:""};
 
               swal("","You've successfully updated changed your password","success");
             };
              $scope.isProcessing = false;
              $scope.load = false;
           });
         }
       }

       $scope.ChangeImage = function(){
         var user = $scope.user;
         $scope.isProcessing = true;
         $scope.load = true;
       if($scope.repoFile.length === 0){
           swal('','Image file not added','warning');
           $scope.isProcessing = false;
           $scope.load = false;
       }else {
           var formData = new FormData();
           angular.forEach($scope.repoFile,function(obj){
               formData.append('files[]', obj.lfFile);
               formData.append('token',  auth.getToken());
               formData.append('id',  auth.currentUser()._id);
           });
           auth.updateAvatar(formData).error(function (error) {
               swal("",error.message,"error")
               $scope.isProcessing = false;
               $scope.load = false;
           }).then(function (res) {
               $rootScope.$broadcast('userData',{data:res.data.user});
               swal("","Image Changed successfully","success");
               $scope.isProcessing = false;
               $scope.load = false;
           });
       }
       }
    }]);
})();
