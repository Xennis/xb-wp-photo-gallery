// webpack.config.js
var path = require("path");
var webpack = require('webpack');

module.exports = {
	entry: './src/js/smart-gallery/SmartGalleryModule.js',
	output: {
		filename: 'angular-module.min.js',
		path: 'dist/'
	},
    module: {
        loaders: [
            { test: /\.css$/, loader: "style-loader!css-loader" },
			{ test: /\.html$/, loader: 'html' },
			{ test: /\.png$/, loader: "url-loader?minetype=image/png" }
        ]
    },
	resolve: {
        root: [path.join(__dirname, "./src/js/bower_components")]
    },
	plugins: [
		new webpack.ResolverPlugin(
		  new webpack.ResolverPlugin.DirectoryDescriptionFilePlugin("bower.json", ["main"])
		)
	]
};