/**
 * Created by Aditech on 5/31/2016.
 */
(function () {
    'use strict';
    angular.module("myApp").controller('playlistCtrl', ['$scope','auth','sp','$state','$stateParams','$window','$mdDialog','$mdMedia',function ($scope,auth,sp,$state,$stateParams,$window,$mdDialog,$mdMedia) {
        if(!auth.isLoggedIn()){
            $state.go('login');
        }else{
            $scope.luser = auth.currentUser();
        }
        $scope.isProcessing = false;
        $scope.load = false;
        $scope.loaded = false;
     
        $scope.channel = [];
        $scope.content_type = ['audio','video','mix'];
        $scope.playlists = [];
        $scope.contents = [];
        $scope.channelId = "";
    
        $scope.playlist = {name:"",channel_id:"",content_type:"",id:"",dateadded:""};
        //get service by id
        if($stateParams.id){
            sp.getPlaylistById($stateParams.id).success(function (data) {
                $scope.loaded = true;
                $scope.channelId = data.channel_id;
                $scope.playlist = {name: data.name ,channel_id: data.channel_id ,content_type: data.content_type, id: data.id,dateadded:data.dateadded};
            });
        }

        if($stateParams.channel){
            $scope.channelId = $stateParams.channel;
            sp.getPlaylistByChannel($stateParams.channel).success(function (data) {
                $scope.loaded = true;
                angular.forEach(data, function (value) {
                    value.dateadded = new Date(value.dateadded); 
                    $scope.playlists.push(value);
                });
            });

            sp.getContentByChannelAndPlaylist($stateParams.channel,'0').success(function (data) {
                $scope.loaded = true;
                angular.forEach(data, function (value) {
                    value.dateadded = new Date(value.dateadded); 
                    $scope.contents.push(value);
                });
            });

            sp.getChannelById($stateParams.channel).success(function (data) {
                $scope.channel = data;
                console.log(data)
            });

        }

        $scope.CreatePlaylist = function () {
            var playlist = $scope.playlist;
            playlist.channel_id = $stateParams.channel;
            playlist.status = 'create';
            console.log(playlist);
            $scope.isProcessing = true;
            $scope.load = true;
            if(playlist.name === "" || playlist.name === undefined || playlist.name === null
                || playlist.content_type === "" || playlist.content_type === undefined || playlist.content_type === null){
                swal('','Fill the form data','warning');
                $scope.isProcessing = false;
                $scope.load = false;
            }else {
                sp.registerPlaylist(playlist).success(function (res) {
                    if(res.error){
                        swal("",res.answer,"error"); 
                    }else{
                        swal("","Playlist successfully created","success");
                    }
                    $scope.isProcessing = false;
                    $scope.load = false;
                }).error(function (error) {
                    // swal("",error.message,"error");
                    console.log('error');
                    $scope.isProcessing = false;
                    $scope.load = false;
                });
            }
        };

        $scope.EditPlaylist = function(){
            var playlist = $scope.playlist;
            $scope.isProcessing = true;
            $scope.load = true;
            if(playlist.name === "" || playlist.name === undefined || playlist.name === null
                || playlist.content_type === "" || playlist.content_type === undefined || playlist.content_type === null){
                swal('','Fill the form data','warning');
                $scope.isProcessing = false;
                $scope.load = false;
                return;
            }
            playlist.id = $stateParams.id;
            playlist.status = 'update';
          
            sp.registerPlaylist(playlist).error(function (error) {
                swal("",error,"error");
                $scope.isProcessing = false;
                $scope.load = false;
            }).then(function (res) {

                if(res.error){
                    swal("",res.answer,"error"); 
                }else{
                    swal("","You've successfully updated this playlist info","success");
                }
            
                $scope.isProcessing = false;
                $scope.load = false;
            })
        };

        $scope.DeletePlaylist = function(playlist,index){
            swal({
                    title: "",
                    text: "Are you sure you want to remove this playlist?",
                    showCancelButton: true,
                    confirmButtonClass: "md-warn  md-raised md-button",
                    cancelButtonClass: "primary md-raised md-button",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true
                },
                function(){
                    sp.deletePlaylist(playlist.id).success(function (data) {

                        if(data.error){
                            swal("",data.answer,"error"); 
                        }else{
                            $scope.playlists.splice(index, 1);
                        }
                    
                       
                    }).error(function (data) {
                        swal("",data.message,"error");
                    });
                })
        };

        $scope.DeleteContent = function(content,index){
            swal({
                    title: "",
                    text: "Are you sure you want to remove this content?",
                    showCancelButton: true,
                    confirmButtonClass: "md-warn  md-raised md-button",
                    cancelButtonClass: "primary md-raised md-button",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true
                },
                function(){
                    sp.deleteContent(content.id).success(function (data) {

                        if(data.error){
                            swal("",data.answer,"error"); 
                        }else{
                            $scope.contents.splice(index, 1);
                        }
                    
                       
                    }).error(function (data) {
                        swal("",data.message,"error");
                    });
                })
        };

    }]);
})();
