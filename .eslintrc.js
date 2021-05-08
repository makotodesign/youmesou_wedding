module.exports = {
	extends: ['plugin:prettier/recommended'],
	rules: {},
	globals: {
		PUBLICDIR: true,
	},
	env: {
		browser: true, // document や console にエラーが出ないようにする
		es6: true, // es6から使える let や const にエラーがでないようにする
		jquery: true,
	},
};
