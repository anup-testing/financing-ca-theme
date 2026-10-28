<?php
/**
 * Head meta tags (theme colour, favicon, front-page description/Open Graph).
 *
 * @package Tankless\Theme
 */

declare( strict_types = 1 );

namespace Tankless\Theme\Core;

use rtCamp\WPPrimitives\Contracts\Interfaces\Registrable;

/**
 * Class - Seo
 */
class Seo implements Registrable {

	/**
	 * {@inheritDoc}
	 */
	public function register_hooks(): void {
		add_action( 'wp_head', [ $this, 'render_head_tags' ], 1 );
	}

	/**
	 * Prints head tags.
	 */
	public function render_head_tags(): void {
		echo '<meta name="theme-color" content="#0b0c0e" />' . "\n";
		echo '<link rel="icon" href="' . esc_url( get_theme_file_uri( 'assets/favicon.svg' ) ) . '" type="image/svg+xml" />' . "\n";

		// Preload the fonts used above the fold (self-hosted; crossorigin is required for fonts).
		foreach ( [ 'manrope', 'exo-2' ] as $font ) {
			echo '<link rel="preload" href="' . esc_url( get_theme_file_uri( Assets::FONTS[ $font ] ) ) . '" as="font" type="font/woff2" crossorigin />' . "\n";
		}

		if ( ! is_front_page() ) {
			return;
		}

		echo '<meta name="description" content="The Tankless brings smart, space-saving, cost-efficient tankless water heaters to Canadian homes, with professional installation and service across Ontario." />' . "\n";
		echo '<meta property="og:title" content="The Tankless — Where hot water meets quiet precision" />' . "\n";
		echo '<meta property="og:description" content="Endless hot water, zero maintenance and smart controls, built for Canadian homes and Canadian winters." />' . "\n";
		echo '<meta property="og:type" content="website" />' . "\n";
	}
}
