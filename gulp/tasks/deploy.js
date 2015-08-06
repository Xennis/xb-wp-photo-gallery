/*global require, module, __dirname */
var config = require('../config').deploy,
	configDeploy = require('../config.deploy'),
	ftp = require('vinyl-ftp'),
	gulp = require('gulp'),
	$ = require('gulp-load-plugins')();
	
gulp.task('deploy', ['styles', 'scripts'], function() {

    var conn = ftp.create( {
        host:     configDeploy.host,
        user:     configDeploy.user,
        password: configDeploy.password,
        parallel: 10,
        log:      $.util.log
    } );

    // using base = '.' will transfer everything to /public_html correctly
    // turn off buffering in gulp.src for best performance

    return gulp.src( config.globs, { base: '.', buffer: false } )
        .pipe( conn.newer( configDeploy.base+config.remoteFolder) ) // only upload newer files
        .pipe( conn.dest( configDeploy.base+config.remoteFolder) );

} );