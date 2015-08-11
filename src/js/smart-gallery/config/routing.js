
/**
 * Configure the routing of the Angular module. For routing the module uses
 * the "ui.router" module.
 * 
 * @param {Object} $stateProvider From module ui.router
 * @param {Object} $urlRouterProvider From module ui.router
 */
function routing($stateProvider, $urlRouterProvider) {
	// Default route
	$urlRouterProvider.otherwise('/home/');

	// Set up the states
	$stateProvider
	.state('home', {
		url: '/home/',
		template: require('../view/page/home.html'),
		controller: require('../controller/page/HomeController')
	})
	;		
}

routing.$inject = ['$stateProvider', '$urlRouterProvider'];

module.exports = routing;