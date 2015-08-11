/**
 * Controller of the state "home".
 * 
 * @param {angular.$scope} $scope
 * @param {angular.$state} $state
 */
function HomeController($scope, $state, Restangular, $http) {
	$scope.galleries = [];

	$scope.requestGalleries = function(path) {
		console.log(path);
		Restangular.all('galleries').getList({
			path: path
		}).then(function(galleries) {
			$scope.galleries = galleries;
		});	
	};

	$scope.path = $state.params.path;

	$scope.requestGalleries($scope.path);
};
	
HomeController.$inject = ['$scope', '$state', 'Restangular', '$http'];

module.exports = HomeController;