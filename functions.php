<?php
/**
 * Financing.ca block theme bootstrap.
 *
 * @package Financing\Theme
 */

declare( strict_types = 1 );

namespace Financing\Theme;

defined( 'ABSPATH' ) || exit;

/**
 * Defines theme constants.
 */
function constants(): void {
	$theme_version = wp_get_theme()->get( 'Version' );

	if ( ! defined( 'FINANCING_CA_VERSION' ) ) {
		define( 'FINANCING_CA_VERSION', is_string( $theme_version ) ? $theme_version : '1.0.0' );
	}

	if ( ! defined( 'FINANCING_CA_PATH' ) ) {
		define( 'FINANCING_CA_PATH', untrailingslashit( get_template_directory() ) );
	}

	if ( ! defined( 'FINANCING_CA_BUILD_DIR' ) ) {
		define( 'FINANCING_CA_BUILD_DIR', FINANCING_CA_PATH . '/assets/build' );
	}

	if ( ! defined( 'FINANCING_CA_BUILD_URI' ) ) {
		define( 'FINANCING_CA_BUILD_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build' );
	}
}

constants();

require_once FINANCING_CA_PATH . '/inc/Autoloader.php';

if ( ! Autoloader::autoload() ) {
	return;
}

Main::get_instance();
