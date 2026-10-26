<?php
/**
 * Loads the Composer autoloader without fataling when it is missing.
 *
 * @package Financing\Theme
 */

declare( strict_types = 1 );

namespace Financing\Theme;

/**
 * Class - Autoloader
 */
final class Autoloader {

	/**
	 * Requires the Composer autoloader.
	 *
	 * @return bool True when the autoloader was loaded.
	 */
	public static function autoload(): bool {
		$autoload = FINANCING_CA_PATH . '/vendor/autoload.php';

		if ( file_exists( $autoload ) ) {
			require_once $autoload; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
			return true;
		}

		add_action(
			'admin_notices',
			static function (): void {
				printf(
					'<div class="notice notice-error"><p>%s</p></div>',
					esc_html__( 'Financing.ca theme: Composer dependencies are missing. Run "composer install" in the theme directory.', 'financing-ca' )
				);
			}
		);

		return false;
	}
}
