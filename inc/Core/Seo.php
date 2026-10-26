<?php
/**
 * Head meta tags (theme colour, favicon, front-page description/Open Graph).
 *
 * @package Financing\Theme
 */

declare( strict_types = 1 );

namespace Financing\Theme\Core;

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
		echo '<meta name="theme-color" content="#06203f" />' . "\n";
		echo '<link rel="icon" href="' . esc_url( get_theme_file_uri( 'assets/favicon.svg' ) ) . '" type="image/svg+xml" />' . "\n";

		// Preload the fonts used above the fold (self-hosted; crossorigin is required for fonts).
		foreach ( [ 'manrope', 'instrument-serif-ital' ] as $font ) {
			echo '<link rel="preload" href="' . esc_url( get_theme_file_uri( Assets::FONTS[ $font ] ) ) . '" as="font" type="font/woff2" crossorigin />' . "\n";
		}

		if ( ! is_front_page() ) {
			return;
		}

		echo '<meta name="description" content="Financing.ca helps Canadian home improvement, retail and vehicle businesses close more sales with monthly payment options up to $100,000. Instant decisions, no merchant fees, funds direct to your bank." />' . "\n";
		echo '<meta property="og:title" content="Financing.ca — Turn big quotes into easy monthly payments" />' . "\n";
		echo '<meta property="og:description" content="Offer your customers financing up to $100,000. Instant decisions, promotional rates, and funds deposited straight to your bank account." />' . "\n";
		echo '<meta property="og:type" content="website" />' . "\n";
	}
}
