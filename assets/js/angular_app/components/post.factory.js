(function() {

    angular
        .module('corporatespaApp')
        .factory('postFactory', function ($resource) {
            return $resource(appInfo.api_url + '/wp/v2/posts/:ID', {
                ID: '@id'
            })
        });

})();