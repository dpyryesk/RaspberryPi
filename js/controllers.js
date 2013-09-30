'use strict';

/* Controllers */

function MainController($scope, $http) {
	var buttonTextEnabled = "Say stuff!";
	var buttonIconEnabled = "comment";
	var buttonTextDisabled = "Wait a sec...";
	var buttonIconDisabled = "comment";
	var latitude = 0;
	var longitude = 0;
	
	$scope.messageTxt = "";
	$scope.fromTxt = "";
	
	// Button control
	$scope.formDisabled = false;
	$scope.buttonText = buttonTextEnabled;
	$scope.buttonIcon = buttonIconEnabled;
	
	// Say stuff
	$scope.sayStuff = function() {
		if ($scope.messageTxt.length == 0) {
			$scope.$emit('addAlert', 'Wait, you need to type in a message first!', 'warning');
			
			return;
		}
		
		$scope.formDisabled = true;
		$scope.buttonText = buttonTextDisabled;
		$scope.buttonIcon = buttonIconDisabled;
		
		var urlString = "tts.php?Body='" + $scope.messageTxt + "'&From='" + $scope.fromTxt + "'&Loc='" + latitude + " / " + longitude + "'";
		
		$http({method: 'GET', url: urlString}).
			success(function(data, status) {
				$scope.formDisabled = false;
				$scope.buttonText = buttonTextEnabled;
				$scope.buttonIcon = buttonIconEnabled;
				
				$scope.$emit('addAlert', 'Success! Pi said: ' + $scope.messageTxt, 'success');
				
				$scope.messageTxt = "";
				$scope.fromTxt = "";
			}).
			error(function(data, status) {
				$scope.formDisabled = false;
				$scope.buttonText = buttonTextEnabled;
				$scope.buttonIcon = buttonIconEnabled;
				
				$scope.$emit('addAlert', 'Failed!', 'danger');
			});
	};
	
	// Get user's location
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(geoSuccess, geoError);
	}
	
	function geoSuccess(position) {
		var crd = position.coords;
		
		latitude = crd.latitude;
		longitude = crd.longitude;
		/*
		console.log('Your current position is:');
		console.log('Latitude : ' + crd.latitude);
		console.log('Longitude: ' + crd.longitude);
		console.log('More or less ' + crd.accuracy + ' meters.');
		*/
	}
	
	function geoError(err) {
		console.warn('ERROR(' + err.code + '): ' + err.message);
	}
}

function LogController($scope, ttsLog, $modal) {
	$scope.predicate = "-date";
	$scope.logs = ttsLog.query();
	$scope.currentPage = 1;
	
	$scope.showMap = function (location) {
		var modalInstance = $modal.open({
			templateUrl: 'partials/map_modal.html',
			controller: ModalInstanceCtrl,
			resolve: {
				loc: function () {
					return location;
			}
		}
	});
  };
}

var ModalInstanceCtrl = function ($scope, $modalInstance, loc) {
	var lat = 0;
	var long = 0;

	if (loc != "undefined") {
		var str = loc.split(" / ");
		lat = str[0];
		long = str[1];
	}

	google.maps.visualRefresh = true;

	angular.extend($scope, {

	    position: {
	      coords: {
	        latitude: lat,
	        longitude: long
	      }
	    },

		/** the initial center of the map */
		centerProperty: {
			latitude: lat,
			longitude: long
		},

		/** the initial zoom level of the map */
		zoomProperty: 15,

		/** list of markers to put in the map */
		markersProperty: [{
			latitude: lat,
			longitude: long
		}]
	});
	
	
	
	$scope.close = function () {
		$modalInstance.dismiss('cancel');
	};
};

function AlertController($scope, $rootScope) {
	$scope.alerts = [];
	
	$scope.addAlert = function() {
		$scope.alerts.push({type: 'info', msg: 'another alert'});
	};

	$scope.closeAlert = function(index) {
		$scope.alerts.splice(index, 1);
	};
	
	$rootScope.$on('addAlert', function(event, messageText, messageType) {
		messageType = typeof messageType !== 'undefined' ? messageType : 'info';
		$scope.alerts.push({type: messageType, msg: messageText});
	});
}