module.exports = {
	'*.php': [ 'vendor/bin/phpcs' ],
	'src/**/*.js': [ 'wp-scripts lint-js' ],
	'src/**/*.scss': [ 'wp-scripts lint-style' ],
};
