(function () {
    'use strict';
    angular.module("myApp").controller('channelCtrl', ['$scope','auth','$state','$stateParams','sp',function ($scope,auth,$state,$stateParams,sp) {
        if(!auth.isLoggedIn()){
            $state.go('login');
        }
        $scope.isProcessing = false;
        $scope.load = false;
        $scope.determinate = 30;
        $scope.loaded = false;
        $scope.channels = [];
        $scope.channel = {id:"",name:"",email:"",phone:"",
        address:"",
        avatar:"",about:"",links:{},status:""};

        //FETCH ALL Channel
        sp.getAllChannels().success(function (data) {
            // $scope.channels = data;
            angular.forEach(data, function (value) {
                value.links = JSON.parse(value.links);
                value.avatar = JSON.parse(value.avatar);
                $scope.channels.unshift(value)
            });
            $scope.loaded = true;
        });

        //GET CHANNEL BY ID
        if($stateParams.id){
            sp.getChannelById($stateParams.id).success(function (data) {
                $scope.channel = {id:data.id, name:data.name, email:data.email, phone:data.phone, address:data.address, avatar:JSON.parse(data.avatar), about:data.about, links:JSON.parse(data.links), status:""};
            });
        }
        //ADD Channel
        $scope.CreateChannel = function () {
            var channel = $scope.channel;
        
            $scope.load = true;
            $scope.isProcessing = true;

            if($scope.repoFile.length === 0){
                swal('','Upload Channel picture','warning');
                $scope.isProcessing = false;
                $scope.load = false;
                return
            }

            if(channel.name === "" ||channel.phone === "" || channel.address === "" || channel.about === "" ){
                swal('','Fill the form data','warning');
                $scope.isProcessing = false;
                $scope.load = false;
                return
            }

            angular.forEach($scope.repoFile,function(obj){
                $scope.f =  obj.lfFile;
            });

            var newName = $scope.f.name.split(".");
            var date = new Date;
            var datestring = date.toString().replace(/[' "():+]/gi, "");
            var n = datestring.substring(0, 18)+""+Math.random().toString(36).substr(2, 10);
            $scope.channel.image = n + "." + newName[1];
            var storageRef = firebase.storage().ref('images/' + $scope.channel.image);
            var task = storageRef.put($scope.f);
            task.on('state_changed', function progress(snapshot) {
                    // $("#progress").html(''+progress.toFixed(2)+'%');
                },
                function error(err) {
                    swal("",err,"error");
                    console.log(err);
                    $scope.isProcessing = false;
                    $scope.load = false;
                },
                function complete() {
                    $scope.channel.avatar ={url: task.snapshot.downloadURL, name: $scope.channel.image  };
                    channel.links = JSON.stringify(channel.links);
                    channel.avatar = JSON.stringify(channel.avatar);
                    console.log(channel);
                    $scope.channel.status = 'create';
                    sp.registerChannel(channel).success(function (res) {

                        if(res.error){
                            swal("",res.answer,"error");
                            var storageRef = firebase.storage().ref('images/');
                            var desertRef = storageRef.child($scope.channel.image);
                            desertRef.delete(); 
                        }else if(res.error === false){

                            swal("","channel successfully added","success");
                            $scope.channel = {id:"",name:"",email:"",phone:"",address:"",avatar:"",about:"",links:"",status:""};
                            $scope.uploadme = '';
                        }else{
                            swal("","An Error Occurred","error");
                            var storageRef = firebase.storage().ref('images/');
                            var desertRef = storageRef.child($scope.channel.image);
                            desertRef.delete();   
                        }
                      
                        $scope.isProcessing = false;
                        $scope.load = false;
                        $("#progress").html("");
                    }).error(function (error) {
                        console.log(error);
                        swal("","","error");
                        $scope.isProcessing = false;
                        $scope.load = false;
                        $("#progress").html("");
                    });

                }
            );
        };

        //DELETE Channel
        $scope.DeleteChannel = function(channel,index){
            swal({
                    title: ".",
                    text: "Are you sure you want to delete this channel?",
                    showCancelButton: true,
                    confirmButtonClass: "md-warn  md-raised md-button",
                    cancelButtonClass: "primary md-raised md-button",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true
                },
                function(){
                    sp.deleteChannel(channel.id).success(function (data) {
                        console.log(data);
                        if(data.error){
                            swal("",data.answer,"error"); 
                        }else{
                            swal("","Channel was successfully deleted","success");
                            $scope.channels.splice(index, 1)
                            var storageRef = firebase.storage().ref('images/');
                            var desertRef = storageRef.child(channel.avatar.name);
                            desertRef.delete(); 
                           
                        }
                    }).error(function (data) {
                        swal("",data.message,"error");
                    });
                })
        };

        //EDIT Channel
        $scope.ChangeChannel = function(){
            var channel = $scope.channel;
            $scope.isProcessing = true;
            $scope.load = true;
            
            if(channel.name === "" ||channel.phone === "" || channel.address === "" || channel.about === "" ){
                swal('','Fill the form data','warning');
                $scope.isProcessing = false;
                $scope.load = false;
                return
            }
     
            channel.links = JSON.stringify(channel.links);
            channel.avatar = JSON.stringify(channel.avatar);
            channel.status = 'update';
            channel.id = $stateParams.id;
            
            sp.registerChannel(channel).error(function (error) {
                swal("",error.message,"error");
                $scope.isProcessing = false;
                $scope.load = false;
            }).success(function (res) {
                if(res.error){
                    swal("",res.answer,"error"); 
                }else{
                    swal("","You've successfully updated this channel","success");
                    $state.go("channels");
                }
                $scope.isProcessing = false;
                $scope.load = false;
            
            })
        };

        //SAVE EDITED IMAGE
        $scope.ChangeImage = function(){
            var channel = $scope.channel;
            var oldfile = channel.avatar;
            $scope.isProcessing = true;
            $scope.load = true;

            if($scope.repoFile.length === 0){
                swal('','Upload Profile Image','warning');
                $scope.isProcessing = false;
                $scope.load = false;
            } else{
                angular.forEach($scope.repoFile,function(obj){
                    $scope.f =  obj.lfFile;
                });
                var newName = $scope.f.name.split(".");
                var date = new Date;
                var datestring = date.toString().replace(/[' "():+]/gi, "");
                var n = datestring.substring(0, 18)+""+Math.random().toString(36).substr(2, 10);
                $scope.image = n + "." + newName[1];
                var storageRef = firebase.storage().ref('images/' + $scope.image);
                var task = storageRef.put($scope.f);
                task.on('state_changed',
                    function progress(snapshot) {
                        $("#progress").html(''+progress.toFixed(2)+'%');
                    },
                    function error(err) {
                        swal("",err,"error");
                        $scope.isProcessing = false;
                        $scope.load = false;
                    },
                    function complete() {

                        channel.status = 'update';
                        channel.id = $stateParams.id;
                        channel.avatar = {url: task.snapshot.downloadURL, name: $scope.image};
                        channel.links = JSON.stringify(channel.links);
                        channel.avatar = JSON.stringify(channel.avatar);
                        sp.registerChannel(channel).error(function (error) {
                            swal("",error.message,"error");
                            $scope.isProcessing = false;
                            $scope.load = false;
                        }).then(function (res) {
                            var storageRef = firebase.storage().ref('images/');
                            var desertRef = storageRef.child(oldfile.name);
                            desertRef.delete(); 
                            swal("","You've successfully updated this image","success");
                            $scope.isProcessing = false;
                            $scope.load = false;
                            $state.go("channels");
                        })
                    });
            }
        }


    }]);
})();
