module.exports = {
    extends: [
		'stylelint-prettier/recommended',
		"stylelint-config-recess-order"
	],
	rules: {
		'color-hex-length': 'short',
		'prettier/prettier': [
			true,
			{
				'singleQuote': true,
				'useTabs': true,
			}
		],
	},
	ignoreFiles: ["**/*.css"]
};