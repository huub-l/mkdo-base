module.exports = {
	extends: ['stylelint-config-wordpress/scss', 'stylelint-config-prettier'],
	plugins: ['stylelint-scss'],
	rules: {
		// 'block-no-empty': null,
		'no-descending-specificity': null,
		'declaration-property-unit-whitelist': null,
	},
};
