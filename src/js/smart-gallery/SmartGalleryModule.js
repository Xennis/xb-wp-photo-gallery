require('angular-ui-router');
require('lodash');
require('restangular');

angular.module('smart-gallery', ['ui.router', 'restangular'])
	
	// Config
	.config(require('./config/api'))
	.config(require('./config/routing'))
;