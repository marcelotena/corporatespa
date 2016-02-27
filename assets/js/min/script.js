(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);throw new Error("Cannot find module '"+o+"'")}var f=n[o]={exports:{}};t[o][0].call(f.exports,function(e){var n=t[o][1][e];return s(n?n:e)},f,f.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */
( function() {
	var container, button, menu, links, subMenus;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( var i = 0, len = subMenus.length; i < len; i++ ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}
} )();

( function() {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
})();

/*
* app.module.js
* Main config file for CorporateSPA theme
 */

angular
    .module("corporatespaApp", ['ui.router', 'ngResource', 'ngMaterial']);


(function() {

    angular
        .module('corporatespaApp')
        .factory('postFactory', function ($resource) {
            return $resource(appInfo.api_url + '/wp/v2/posts/:ID', {
                ID: '@id'
            })
        });

})();
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
(function() {

    angular
        .module('corporatespaApp')
        .controller('DetailCtrl', ['$scope', '$stateParams', 'postFactory', function ($scope, $stateParams, postFactory) {
            console.log($stateParams);
            postFactory.get({ID: $stateParams.id}, function (res) {
                $scope.post = res;
            });
        }]);

})();
(function() {

    angular
        .module('corporatespaApp')
        .filter('to_trusted', ['$sce', function ($sce) {
            return (function (text) {
                return $sce.trustAsHtml(text);
            });
        }]);

})();
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
},{}]},{},[1])