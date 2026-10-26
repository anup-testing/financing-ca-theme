module.exports = {
	extends: [ 'plugin:@wordpress/eslint-plugin/recommended' ],
	env: { browser: true, jest: true },
	ignorePatterns: [ 'assets/build/', 'vendor/', 'node_modules/' ],
	rules: {
		// Legacy front-end script; migrate to let/const incrementally.
		'no-var': 'off',
	},
};
