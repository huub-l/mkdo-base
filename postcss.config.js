module.exports = {
	sourceMap: true,
	plugins: [
		require('autoprefixer')(),
		require('pixrem')({
			atrules: true,
		}),
		require('cssnano'),
	],
};
