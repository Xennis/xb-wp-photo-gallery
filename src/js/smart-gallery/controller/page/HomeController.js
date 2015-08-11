/**
 * Controller of the state "home".
 * 
 * @param {angular.$scope} $scope
 * @param {angular.$state} $state
 */
function HomeController($scope, $state) {
	console.log('Ich bein ein Conrollter')
};
	
HomeController.$inject = ['$scope', '$state'];

module.exports = HomeController;