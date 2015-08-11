
/**
 * Configure the routing of the Angular module. For routing the module uses
 * the "ui.router" module.
 * 
 * @param {Object} $stateProvider From module ui.router
 * @param {Object} $urlRouterProvider From module ui.router
 */
function routing($stateProvider, $urlRouterProvider, $urlMatcherFactoryProvider) {
	// Default route
	$urlRouterProvider.otherwise('/');

	/*
	 * https://github.com/angular-ui/ui-router/issues/1119
	 * http://jsfiddle.net/jylinman/rm1Lbptf/1/
	 * 
	 */
	function valToString(val) {
		return val !== null ? val.toString() : val;
	}
	$urlMatcherFactoryProvider.type('nonURIEncoded', {
		encode: valToString,
		decode: valToString,
		is: function () { return true; }
	});
	/* (end) */

	// Set up the state
	$stateProvider
	.state('main', {
		url: '/{path:nonURIEncoded}',
		template: require('../view/page/home.html'),
		controller: require('../controller/page/HomeController')
	})
	;		
}

routing.$inject = ['$stateProvider', '$urlRouterProvider', '$urlMatcherFactoryProvider'];

module.exports = routing;