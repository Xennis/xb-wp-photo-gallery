/*global require, module, __dirname */
var config = require('../config').serve,
	browserSync = require('browser-sync'),
	gulp = require('gulp'),
	$ = require('gulp-load-plugins')();

gulp.task('serve', ['styles', 'scripts'], function() {
    browserSync({
        port: config.port,
        server: true,
        open: 'local'
    }, function (err, bs) {
    });
});