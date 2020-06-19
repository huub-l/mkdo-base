const path = require('path');
const webpack = require('webpack');
const minimatch = require('minimatch');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const FriendlyErrorsPlugin = require('friendly-errors-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const TerserPlugin = require('terser-webpack-plugin');
const LiveReloadPlugin = require('webpack-livereload-plugin');
const globImporter = require('node-sass-glob-importer');
const devMode = 'development' === process.env.NODE_ENV;

class MiniCssExtractPluginCleanup {
	apply(compiler) {
		compiler.hooks.emit.tapAsync(
			'MiniCssExtractPluginCleanup',
			(compilation, callback) => {
				Object.keys(compilation.assets)
					.filter(asset => {
						return [
							'themes/my-project/assets/styles/*.js',
							'themes/my-project/assets/styles/*.js.map',
							'themes/my-project/style.js',
							'themes/my-project/style.js.map',
						].some(pattern => {
							return minimatch(asset, pattern);
						});
					})
					.forEach(asset => {
						delete compilation.assets[asset];
					});

				callback();
			},
		);
	}
}

module.exports = {
	mode: process.env.NODE_ENV,
	entry: {
		'themes/my-project/assets/dist/scripts/footer':
			'./wp-content/themes/my-project/assets/src/scripts/footer.js',
		'themes/my-project/assets/dist/scripts/admin':
			'./wp-content/themes/my-project/assets/src/scripts/admin.js',
		'themes/my-project/assets/dist/scripts/customizer':
			'./wp-content/themes/my-project/assets/src/scripts/customizer.js',
		'themes/my-project/assets/dist/styles/admin':
			'./wp-content/themes/my-project/assets/src/styles/admin.scss',
		'themes/my-project/assets/dist/styles/editor':
			'./wp-content/themes/my-project/assets/src/styles/editor.scss',
		'themes/my-project/style':
			'./wp-content/themes/my-project/assets/src/styles/style.scss',
	},
	output: {
		path: path.resolve(__dirname, 'wp-content/'),
		filename: '[name].js',
	},
	devtool: devMode ? 'source-map' : 'cheap-eval-source-map',
	performance: {
		maxAssetSize: 1000000,
	},
	optimization: {
		minimize: true,
		minimizer: [
			new TerserPlugin({
				sourceMap: true,
			}),
		],
	},
	stats: {
		assets: !devMode,
		builtAt: !devMode,
		children: false,
		chunks: false,
		colors: true,
		entrypoints: !devMode,
		env: false,
		errors: !devMode,
		errorDetails: false,
		hash: false,
		maxModules: 20,
		modules: false,
		performance: !devMode,
		publicPath: false,
		reasons: false,
		source: false,
		timings: !devMode,
		version: false,
		warnings: !devMode,
	},
	module: {
		rules: [
			{
				enforce: 'pre',
				test: /\.js$/,
				exclude: /(node_modules|bower_components)/,
				use: [
					{
						loader: 'eslint-loader',
						options: {
							fix: true,
							emitWarning: true,
						},
					},
				],
			},
			{
				test: /\.js$/,
				exclude: /(node_modules|bower_components)/,
				use: [
					{
						loader: 'babel-loader',
					},
				],
			},
			{
				test: /\.s?css$/,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							sourceMap: true,
						},
					},
					{
						loader: 'postcss-loader',
						options: {
							sourceMap: true,
						},
					},
					{
						loader: 'sass-loader',
						options: {
							sourceMap: true,
							importer: globImporter(),
						},
					},
				],
			},
			{
				test: /\.(png|jpg|gif)$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							outputPath: 'themes/my-project/assets/dist/images',
							name: '[name].[ext]',
						},
					},
				],
			},
			{
				test: /\.(woff(2)?|ttf|eot)$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							outputPath: 'themes/my-project/assets/dist/fonts',
							name: '[name].[ext]',
						},
					},
				],
			},
			{
				test: /\.(svg)$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							outputPath: 'themes/my-project/assets/dist/svgs',
							name: '[name].[ext]',
						},
					},
					{
						loader: 'svgo-loader',
						options: {
							plugins: [
								{ removeTitle: false },
								{ convertColors: { shorthex: false } },
								{ convertPathData: false },
								{ removeViewBox: false },
							],
						},
					},
				],
			},
		],
	},
	plugins: [
		devMode &&
			new FriendlyErrorsPlugin({
				clearConsole: false,
			}),
		!devMode &&
			new CleanWebpackPlugin(['assets/dist', 'style.css', 'style.css.map'], {
				root: path.resolve(__dirname, 'wp-content/themes/my-project'),
				verbose: !devMode,
			}),
		new StyleLintPlugin({
			files: 'wp-content/themes/my-project/assets/styles/src/**/*.s?(a|c)ss',
			fix: true,
			failOnError: false,
			syntax: 'scss',
		}),
		new MiniCssExtractPlugin({
			filename: '[name].css',
		}),
		!devMode &&
			new ImageminPlugin({
				test: /\.(jpe?g|png|gif)$/i,
				cacheFolder: './imgcache',
			}),
		new MiniCssExtractPluginCleanup(),
		devMode && new LiveReloadPlugin(),
	].filter(Boolean),
};
