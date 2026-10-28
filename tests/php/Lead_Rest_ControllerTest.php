<?php
/**
 * Tests for the lead REST endpoint.
 *
 * @package Tankless\Theme
 */

declare( strict_types = 1 );

namespace Tankless\Theme\Tests;

use WP_REST_Request;
use WP_UnitTestCase;

/**
 * Class - Lead_Rest_ControllerTest
 */
class Lead_Rest_ControllerTest extends WP_UnitTestCase {

	/**
	 * Valid payload.
	 *
	 * @return array<string, string>
	 */
	private function payload(): array {
		return [
			'email'  => 'jane@example.com',
			'source' => 'footer-newsletter',
		];
	}

	/**
	 * Sends a request to the endpoint.
	 *
	 * @param array<string, string> $params Params.
	 */
	private function post( array $params ): \WP_REST_Response {
		$request = new WP_REST_Request( 'POST', '/the-tankless/v1/lead' );
		$request->set_body_params( $params );
		return rest_do_request( $request );
	}

	/**
	 * Honeypot returns success without mailing.
	 */
	public function test_honeypot_pretends_success(): void {
		$response = $this->post( [ 'website' => 'http://spam' ] + $this->payload() );
		$this->assertSame( 200, $response->get_status() );
	}

	/**
	 * Invalid email is rejected.
	 */
	public function test_invalid_email_rejected(): void {
		$response = $this->post( [ 'email' => 'nope' ] + $this->payload() );
		$this->assertSame( 400, $response->get_status() );
	}

	/**
	 * Sixth request from one IP is rate limited.
	 */
	public function test_rate_limit(): void {
		$_SERVER['REMOTE_ADDR'] = '203.0.113.9';
		for ( $i = 0; $i < 5; $i++ ) {
			$this->post( $this->payload() );
		}
		$this->assertSame( 429, $this->post( $this->payload() )->get_status() );
	}
}
