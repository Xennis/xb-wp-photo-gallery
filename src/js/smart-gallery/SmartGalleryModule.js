require('angular-ui-router');

angular.module('smart-gallery', ['ui.router'])
	.controller('MainController', function() {
		console.log('hey');
	})
	
	// Config
	.config(require('./config/routing'))
;