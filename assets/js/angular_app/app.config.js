(function() {

    angular
        .module('corporatespaApp')
        .config(function ($stateProvider, $urlRouterProvider) {

            $urlRouterProvider.otherwise('/');

            $stateProvider
                .state('list', {
                    url: '/',
                    controller: 'PostListCtrl',
                    templateUrl: appInfo.template_directory + 'templates/list.html'
                })
                .state('detail', {
                    url: '/posts/:id',
                    controller: 'DetailCtrl',
                    templateUrl: appInfo.template_directory + 'templates/detail.html'
                });

        });

})();