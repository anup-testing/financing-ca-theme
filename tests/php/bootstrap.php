<?php

declare(strict_types = 1);

/**
 * PHPUnit bootstrap (requires wp-phpunit and a WP test DB; run via `npm run test:php` in wp-env).
 *
 * @package Financing\Theme
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' ) ?: dirname( __DIR__, 2 ) . '/vendor/wp-phpunit/wp-phpunit';

require_once dirname( __DIR__, 2 ) . '/vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';
require_once $_tests_dir . '/includes/functions.php';

tests_add_filter(
	'after_setup_theme',
	static function () {
		require_once dirname( __DIR__, 2 ) . '/functions.php';
	}
);

require_once $_tests_dir . '/includes/bootstrap.php';
