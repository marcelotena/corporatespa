angular
    .module('corporatespaApp')
    .controller('DetailCtrl', ['$scope', '$stateParams', 'postFactory', function($scope, $stateParams, postFactory) {
        console.log($stateParams);
        postFactory.get( { ID: $stateParams.id }, function(res) {
            $scope.post = res;
        });
    }]);