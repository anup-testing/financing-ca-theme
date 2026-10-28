<?php
/**
 * The Tankless block theme bootstrap.
 *
 * @package Tankless\Theme
 */

declare( strict_types = 1 );

namespace Tankless\Theme;

defined( 'ABSPATH' ) || exit;

/**
 * Defines theme constants.
 */
function constants(): void {
	$theme_version = wp_get_theme()->get( 'Version' );

	if ( ! defined( 'TANKLESS_VERSION' ) ) {
		define( 'TANKLESS_VERSION', is_string( $theme_version ) ? $theme_version : '1.0.0' );
	}

	if ( ! defined( 'TANKLESS_PATH' ) ) {
		define( 'TANKLESS_PATH', untrailingslashit( get_template_directory() ) );
	}

	if ( ! defined( 'TANKLESS_BUILD_DIR' ) ) {
		define( 'TANKLESS_BUILD_DIR', TANKLESS_PATH . '/assets/build' );
	}

	if ( ! defined( 'TANKLESS_BUILD_URI' ) ) {
		define( 'TANKLESS_BUILD_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build' );
	}
}

constants();

require_once TANKLESS_PATH . '/inc/Autoloader.php';

if ( ! Autoloader::autoload() ) {
	return;
}

Main::get_instance();
