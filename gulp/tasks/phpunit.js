/*global require, module, __dirname */
var config = require('../config').phpunit,
	gulp = require('gulp'),
	$ = require('gulp-load-plugins')();
	
gulp.task('phpunit', function() {

    return gulp.src(config.src)
		.pipe($.phpunit(config.phpunitpath, {
			debug: false
		}));
} );