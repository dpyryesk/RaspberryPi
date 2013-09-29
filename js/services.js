'use strict';

/* Services */

/*
angular.module('phonecatServices', ['ngResource']).
    factory('Phone', function($resource){
  return $resource('phones/:phoneId.json', {}, {
    query: {method:'GET', params:{phoneId:'phones'}, isArray:true}
  });
});
*/

angular.module('pi.services', ['ngResource']).
	value('version', '0.1').
    factory('ttsLog', function($resource){
		return $resource('/api/tts_log/', {}, {
			query: {method:'GET', params:{}, isArray:true}
		});
	});