'use strict';


// Declare app level module
angular.module('pi', ['pi.filters', 'pi.services', 'ui.bootstrap', 'google-maps']).
		config(['$routeProvider', function($routeProvider) {
			$routeProvider.when('/main', {templateUrl: 'partials/main.html', controller: 'MainController'});
			$routeProvider.when('/log', {templateUrl: 'partials/tts_log.html', controller: 'LogController'});
			$routeProvider.otherwise({redirectTo: '/main'});
	}]);
