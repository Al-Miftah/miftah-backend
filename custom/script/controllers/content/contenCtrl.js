/**
 * Created by Aditech on 5/31/2016.
 */
(function () {
    'use strict';
    angular.module("myApp").controller('contentCtrl', ['$scope','auth','sp','$state','$stateParams','$window','$mdDialog','$mdMedia',function ($scope,auth,sp,$state,$stateParams,$window,$mdDialog,$mdMedia) {
        if(!auth.isLoggedIn()){
            $state.go('login');
        }else{
            $scope.luser = auth.currentUser();
        }
        $scope.isProcessing = false;
        $scope.load = false;
        $scope.loaded = false;
     
        $scope.playlist = [];
        $scope.channel = [];
        $scope.content_type = ['audio'];
        $scope.files = [];
        $scope.contents = [];
        $scope.playlistId = null
        $scope.channelId = null
    
        $scope.content = {id:"",
        title:"",
        admin_id:"",
        channel_id:"",
        playlist_id:"",
        type:"",
        views:"",
        likes:"",
        dislikes:"",
        url:""};

        $scope.content.type = 'audio'; 

        //get service by id
        if($stateParams.id){
            sp.getContentById($stateParams.id).success(function (data) {
                $scope.loaded = true;
                $scope.content = {id: data.id ,title: data.title ,admin_id: data.admin_id,channel_id: data.channel_id, playlist_id: data.playlist_id, type: data.type, views: data.views, likes: data.likes, dislikes: data.dislikes, url: data.url, source: data.source};
            });
        }

        if($stateParams.playlist && $stateParams.channel){
            sp.getChannelById($stateParams.channel).success(function (channel) {
                $scope.channelId = $stateParams.channel;
                $scope.channel = channel;   
            });
            sp.getPlaylistById($stateParams.playlist).success(function (data) {
                $scope.playlistId = $stateParams.playlist;
                $scope.playlist = data;   
            });
            sp.getContentByChannelAndPlaylist($stateParams.channel,$stateParams.playlist).success(function (data) {
                $scope.loaded = true;
                angular.forEach(data, function (value) {
                    value.dateadded = new Date(value.dateadded); 
                    $scope.contents.push(value);
                });
            });
        }

        $scope.CreateContent = function () {

            var content = $scope.content;
            content.playlist_id = $stateParams.playlist;
            content.channel_id = $stateParams.channel;
            content.admin_id = $scope.luser.id;
            if(!content.admin_id) content.admin_id = '0';
            content.status = 'create';
            $scope.isProcessing = true;
            $scope.load = true;

            if(content.title == "" || content.type == ""){
                swal('','Fill the form data','warning');
                $scope.isProcessing = false;
                $scope.load = false;
                return false;
            } 

            if(content.type ===  'video' && content.url === ''){
                swal('','Video url is required','warning');
                $scope.isProcessing = false;
                $scope.load = false;
                return false;
            }

            if(content.type ===  'audio' && $scope.files.length !== 1){
                swal('','You must add an audio(1) file','warning');
                $scope.isProcessing = false;
                $scope.load = false;
                return false;
            }


            if(content.type ===  'audio'){

                angular.forEach($scope.files,function(obj){
                    $scope.f = obj.lfFile;
                    console.log($scope.f);    
            
                    if($scope.f.type.split("/")[0] !== 'audio'){
                        swal('','Invalid file format','warning');
                        $scope.isProcessing = false;
                        $scope.load = false;
                        return false;
                    }

                    var newName = $scope.f.name.split(".");
                    var date = new Date();
                    var datestring = date.toString().replace(/[' "():+]/gi, "");
                    var n = datestring.substring(0, 18)+""+Math.random().toString(36).substr(2, 10);
                    $scope.file = n + "." + newName[newName.length - 1];
                    var storageRef = firebase.storage().ref('images/' + $scope.file);
                    var task = storageRef.put($scope.f);

                    $scope.type = $scope.f.type;
                    task.on(firebase.storage.TaskEvent.STATE_CHANGED,
                        function(snapshot) {
                            var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                            $scope.determinate = progress;
                            $("#progress").html(''+progress.toFixed(2)+'%');
                            console.log('Upload is ' + progress + '% done');
                            switch (snapshot.state) {
                                case firebase.storage.TaskState.PAUSED:
                                    console.log('Upload is paused');
                                    break;
                                case firebase.storage.TaskState.RUNNING:
                                    console.log('Upload is running');
                                    break;
                            }
                        },
                        function(error) {
                            switch (error.code) {
                                case 'storage/unauthorized':
                                    swal('','User does not have permission to access the object.','error');
                                    $scope.isProcessing = false;
                                    $scope.load = false;
                                    break;
                                case 'storage/canceled':
                                    swal('','User canceled the upload.','error');
                                    $scope.isProcessing = false;
                                    $scope.load = false;
                                    break;
                                case 'storage/unknown':
                                    swal('','Unknown error occurred, Please try later.','error');
                                    $scope.isProcessing = false;
                                    $scope.load = false;
                                    break;
                            }
                        }, function() {

                            content.url = JSON.stringify({
                                name: $scope.file,
                                url: task.snapshot.downloadURL
                            });
                            
                            sp.registerContent(content).success(function (res) {
                                if(res.error){
                                swal("",res.answer,"error"); 
                                }else{
                                swal("","Content successfully created","success");
                                }
                                $scope.isProcessing = false;
                                $scope.load = false;
                            }).error(function (error) {
                                // swal("",error.message,"error");
                                console.log('error');
                                $scope.isProcessing = false;
                                $scope.load = false;
                            });
                        });
                  
                    

                }); 
            }
            else
            {
                sp.registerContent(content).success(function (res) {
                    if(res.error){
                        swal("",res.answer,"error"); 
                    }else{
                        swal("","Content successfully created","success");
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

        $scope.EditContent = function(){
            var content = $scope.content;
            $scope.isProcessing = true;
            $scope.load = true;
            if(content.title == "" || content.admin_id == "" ||content.playlist_id == "" ||content.type == ""){
                swal('','Fill the form data','warning');
                $scope.isProcessing = false;
                $scope.load = false;
                return;
            }
            content.id = $stateParams.id;
            content.status = 'update';

            if(content.type ===  'audio'){

                angular.forEach($scope.files,function(obj){
                    $scope.f = obj.lfFile;

            
                    if($scope.f.type.split("/")[0] !== 'audio'){
                        swal('','Invalid file format','warning');
                        $scope.isProcessing = false;
                        $scope.load = false;
                        return false;
                    }

                    var newName = $scope.f.name.split(".");
                
                    $scope.file = content.title + "." + newName[1];
                    var task = storageRef.put($scope.f);
                    $scope.type = $scope.f.type;
                    task.on(firebase.storage.TaskEvent.STATE_CHANGED,
                        function(snapshot) {
                            var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                            $scope.determinate = progress;
                            $("#progress").html(''+progress.toFixed(2)+'%');
                            console.log('Upload is ' + progress + '% done');
                            switch (snapshot.state) {
                                case firebase.storage.TaskState.PAUSED:
                                    console.log('Upload is paused');
                                    break;
                                case firebase.storage.TaskState.RUNNING:
                                    console.log('Upload is running');
                                    break;
                            }
                        },
                        function(error) {
                            switch (error.code) {
                                case 'storage/unauthorized':
                                    swal('','User does not have permission to access the object.','error');
                                    $scope.isProcessing = false;
                                    $scope.load = false;
                                    break;
                                case 'storage/canceled':
                                    swal('','User canceled the upload.','error');
                                    $scope.isProcessing = false;
                                    $scope.load = false;
                                    break;
                                case 'storage/unknown':
                                    swal('','Unknown error occurred, Please try later.','error');
                                    $scope.isProcessing = false;
                                    $scope.load = false;
                                    break;
                            }
                        }, function() {

                            content.url = {
                                name: $scope.file,
                                url: task.snapshot.downloadURL
                            };
                            sp.registerContent(content).error(function (error) {
                                swal("",error,"error");
                                $scope.isProcessing = false;
                                $scope.load = false;
                            }).then(function (res) {
                
                                if(res.error){
                                    swal("",res.answer,"error"); 
                                }else{
                                    swal("","You've successfully updated this content info","success");
                                }
                            
                                $scope.isProcessing = false;
                                $scope.load = false;
                            })
                        });
                }); 
            }else {
                sp.registerContent(content).error(function (error) {
                    swal("",error,"error");
                    $scope.isProcessing = false;
                    $scope.load = false;
                }).then(function (res) {
    
                    if(res.error){
                        swal("",res.answer,"error"); 
                    }else{
                        swal("","You've successfully updated this content info","success");
                    }
                
                    $scope.isProcessing = false;
                    $scope.load = false;
                })
            }
          
            
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
