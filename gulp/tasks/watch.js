/*global require, module, __dirname */
var config = require('../config').deploy,
	path = require('path'),
	gulp = require('gulp');

gulp.task('watch', function () {
	gulp.watch(config.deploy, ['deploy']);
});