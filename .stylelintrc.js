module.exports = {
    extends: [
		'stylelint-prettier/recommended',
		"stylelint-config-recess-order"
	],
	rules: {
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