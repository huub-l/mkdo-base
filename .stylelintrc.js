module.exports = {
	extends: ['@wordpress/stylelint-config/scss', 'stylelint-config-prettier'],
	plugins: ['stylelint-scss'],
	rules: {
		'block-no-empty': null,
		'no-descending-specificity': null,
		'declaration-property-unit-whitelist': null,
		'selector-class-pattern': null,
		'declaration-property-unit-allowed-list': null,
	},
};
