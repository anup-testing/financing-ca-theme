<?php
/**
 * Lead / newsletter form REST endpoint (footer email sign-up, future contact forms).
 *
 * Emails the site admin. Filter `tankless_lead_recipient` to route elsewhere / to a CRM.
 *
 * @package Tankless\Theme
 */

declare( strict_types = 1 );

namespace Tankless\Theme\Modules\Lead;

use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
use rtCamp\WPPrimitives\Contracts\Abstracts\AbstractRESTController;

/**
 * Class - Lead_Rest_Controller
 */
class Lead_Rest_Controller extends AbstractRESTController {

	/**
	 * Max submissions per IP per hour.
	 */
	public const RATE_LIMIT = 5;

	/**
	 * {@inheritDoc}
	 *
	 * @var string
	 */
	protected $namespace = 'the-tankless/v1';

	/**
	 * Form fields and their email labels.
	 */
	public const FIELDS = [
		'email'   => 'Email',
		'name'    => 'Name',
		'phone'   => 'Phone',
		'city'    => 'City',
		'message' => 'Message',
		'source'  => 'Form',
	];

	/**
	 * {@inheritDoc}
	 */
	public function register_routes(): void {
		register_rest_route(
			$this->namespace,
			'/lead',
			[
				'methods'             => WP_REST_Server::CREATABLE,
				'permission_callback' => '__return_true', // Public form.
				'callback'            => [ $this, 'handle' ],
			]
		);
	}

	/**
	 * Handles a lead submission.
	 *
	 * @param WP_REST_Request $request Request.
	 *
	 * @phpstan-param WP_REST_Request<array<string, mixed>> $request
	 */
	public function handle( WP_REST_Request $request ): WP_REST_Response {
		// Honeypot: bots fill it, people never see it. Pretend success.
		if ( '' !== trim( (string) $request->get_param( 'website' ) ) ) {
			return new WP_REST_Response( [ 'ok' => true ], 200 );
		}

		// phpcs:ignore WordPressVIPMinimum.Variables.ServerVariables.UserControlledHeaders, WordPressVIPMinimum.Variables.RestrictedVariables.cache_constraints___SERVER__REMOTE_ADDR__ -- Rate-limit key only.
		$ip   = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		$key  = 'tankless_lead_' . md5( $ip );
		$hits = (int) get_transient( $key );

		if ( $hits >= self::RATE_LIMIT ) {
			return new WP_REST_Response(
				[
					'ok'    => false,
					'error' => 'rate_limited',
				],
				429
			);
		}
		set_transient( $key, $hits + 1, HOUR_IN_SECONDS );

		$values = [];
		foreach ( array_keys( self::FIELDS ) as $name ) {
			$value           = (string) $request->get_param( $name );
			$values[ $name ] = 'message' === $name ? sanitize_textarea_field( $value ) : sanitize_text_field( $value );
		}

		if ( ! is_email( $values['email'] ) ) {
			return new WP_REST_Response(
				[
					'ok'    => false,
					'error' => 'invalid',
				],
				400
			);
		}

		$lines = [];
		foreach ( self::FIELDS as $name => $label ) {
			if ( '' !== $values[ $name ] ) {
				$lines[] = $label . ': ' . $values[ $name ];
			}
		}

		/**
		 * Filters the lead notification recipient.
		 *
		 * @param string $to Recipient email address.
		 */
		$to      = apply_filters( 'tankless_lead_recipient', get_option( 'admin_email' ) );
		$subject = 'New website enquiry: ' . $values['email'];
		$headers = [ 'Reply-To: ' . ( '' !== $values['name'] ? $values['name'] . ' ' : '' ) . '<' . $values['email'] . '>' ];

		// phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.wp_mail_wp_mail -- Single admin notification.
		if ( ! wp_mail( $to, $subject, implode( "\n", $lines ), $headers ) ) {
			return new WP_REST_Response(
				[
					'ok'    => false,
					'error' => 'mail_failed',
				],
				500
			);
		}

		return new WP_REST_Response( [ 'ok' => true ], 200 );
	}
}
