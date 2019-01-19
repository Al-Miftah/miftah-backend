(function(){
    'use strict';
    function AuthService($http, $window){
        var sp = {};
    
        var baseUrl = '';

        //channel

        sp.registerChannel = function(data){
            return $http.post(baseUrl+'server/channel/channel.php', data)
        };

       sp.getAllChannels = function(){
         return $http.get(baseUrl+"server/requests.php?op=getchannels");
       };

       sp.getChannelById = function(id){
       return $http.get(baseUrl+"server/requests.php?op=getChannelById&id="+id);
       };

       sp.deleteChannel = function(id){
            return $http.delete(baseUrl+"server/requests.php?op=deleteChannel&id="+id);
       };

       //playlist

       sp.registerPlaylist = function(data){
        return $http.post(baseUrl+'server/playlist/playlist.php', data)
        };

        sp.getPlaylistByChannel = function(id){
            return $http.get(baseUrl+"server/requests.php?op=getPlaylistByChannel&id="+id);
        };

        sp.getPlaylistById = function(id){
            return $http.get(baseUrl+"server/requests.php?op=getPlaylistById&id="+id);
        };

        sp.deletePlaylist = function(id){
           return $http.delete(baseUrl+"server/requests.php?op=deletePlaylist&id="+id);
        };

        //content
        
       sp.registerContent = function(data){
        return $http.post(baseUrl+'server/content/content.php', data)
        };

        sp.getContentByChannelAndPlaylist = function(channel, playlist){
            return $http.get(baseUrl+"server/requests.php?op=getContentByChannelAndPlaylist&channel="+channel+"&playlist="+playlist);
        };

        sp.getContentById = function(id){
            return $http.get(baseUrl+"server/requests.php?op=getContentById&id="+id);
        };

        sp.deleteContent = function(id){
           return $http.delete(baseUrl+"server/requests.php?op=deleteContent&id="+id);
        };

       
        return sp;
    }

    angular.module('myApp')
        .factory('sp', ['$http','$window', AuthService]);

    angular.module('myApp').filter('cut', function () {
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
    }).directive("fileread", [
        function() {
            return {
                scope: {
                    fileread: "="
                },
                link: function(scope, element, attributes) {
                    element.bind("change", function(changeEvent) {
                        var reader = new FileReader();
                        reader.onload = function(loadEvent) {
                            scope.$apply(function() {
                                scope.fileread = loadEvent.target.result;
                            });
                        };
                        reader.readAsDataURL(changeEvent.target.files[0]);
                    });
                }
            }
        }
    ]);


}());
