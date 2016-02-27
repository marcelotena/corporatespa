/**
 * Created by marcelotena on 26/2/16.
 * Service to load WP Menus
 */

(function(){

    angular
        .module('corporatespaApp')
        .service('menuService', ['$http', '$q', function($http, $q) {

            return {
                getMenus: getMenus
            };

            function getMenus() {

                var defered = $q.defer();
                var promise = defered.promise;

                $http.get(appInfo.api_url + '/wp-api-menus/v2/menu-locations/top-menu')
                    .success(function(data) {
                        defered.resolve(data);
                    })
                    .error(function(err) {
                        defered.reject(err);
                    });

                return promise;

            }

        }]);

})();
