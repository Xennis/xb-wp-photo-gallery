/*global require, module, __dirname */
var config = require('../config').watch,
	browserSync = require('browser-sync'),
	path = require('path'),
	gulp = require('gulp');

gulp.task('watch', ['serve'], function () {
	//gulp.watch(config.deploy, ['deploy']);
	//gulp.watch(config.serve, ['serve']);
	
	gulp.watch('src/less/*.less', ['styles']);
	gulp.watch('src/js/**/*.js', ['webpack']);
	gulp.watch(['**/*.html', 'dist/*.js'], browserSync.reload);
});