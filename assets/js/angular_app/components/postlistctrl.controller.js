(function() {

    angular
        .module('corporatespaApp')
        .controller('PostListCtrl', ['$scope', 'postFactory', function ($scope, postFactory) {
            $scope.page_title = 'Entradas del Blog';

            postFactory.query(function (res) {
                $scope.posts = res;
            });

        }]);

})();