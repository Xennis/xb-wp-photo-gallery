/*global require, module, __dirname */
module.exports = {
	deploy: {
		remoteFolder: 'wp-content/plugins/smart-photo-gallery/',
		globs: [
			'dist/**',
//			'lib/**',
			'src/php/**'
		]
	},
	phpunit: {
		src: 'tests\\phpunit.xml',
		phpunitpath: 'vendor\\bin\\phpunit'
	},
	scripts: {
		src: [
			'src/js/bower_components/dropzone/dist/min/dropzone.min.js',
			'src/js/components/**/*.js',
			'src/js/*.js'
		],
		dest: 'dist/',
		name: 'smart-photo-gallery.js'
	},
	styles: {
		src: 'src/less/smart-photo-gallery.less',
		dest: 'dist/'
	},
	watch: {
		deploy: ['src/js/**/*.js', 'src/less/*.less', 'src/php/**/*.php']
	}
};