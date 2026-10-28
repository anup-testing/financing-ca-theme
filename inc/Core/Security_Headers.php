<?php
/**
 * Security headers carried over from vercel.json.
 *
 * @package Tankless\Theme
 */

declare( strict_types = 1 );

namespace Tankless\Theme\Core;

use rtCamp\WPPrimitives\Contracts\Interfaces\Registrable;

/**
 * Class - Security_Headers
 */
class Security_Headers implements Registrable {

	/**
	 * {@inheritDoc}
	 */
	public function register_hooks(): void {
		add_action( 'send_headers', [ $this, 'send_headers' ] );
	}

	/**
	 * Sends the headers.
	 */
	public function send_headers(): void {
		header( 'X-Content-Type-Options: nosniff' );
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	}
}
