angular
    .module('corporatespaApp')
    .factory('postFactory', function($resource) {
        return $resource( appInfo.api_url + 'posts/:ID', {
            ID: '@id'
        } )
    });