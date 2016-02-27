/**
 * Created by marcelotena on 26/2/16.
 * Main Navbar controller
 */

angular.module('corporatespaApp')
    .controller('navbarCtrl', ['$scope', '$stateParams', 'menuService', function ($scope, $stateParams, menuService) {

        menuService
            .getMenus()
            .then( function(data) {
                $scope.menus = data;
            });

    }]);
