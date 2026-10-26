<?php
/**
 * Theme supports, editor styles and pattern categories.
 *
 * @package Financing\Theme
 */

declare( strict_types = 1 );

namespace Financing\Theme\Core;

use rtCamp\WPPrimitives\Contracts\Interfaces\Registrable;

/**
 * Class - Theme_Setup
 */
class Theme_Setup implements Registrable {

	/**
	 * {@inheritDoc}
	 */
	public function register_hooks(): void {
		add_action( 'after_setup_theme', [ $this, 'setup' ] );
		add_action( 'init', [ $this, 'register_pattern_category' ] );
	}

	/**
	 * Registers theme supports and editor styles.
	 */
	public function setup(): void {
		load_theme_textdomain( 'financing-ca', FINANCING_CA_PATH . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption', 'style', 'script' ] );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );

		add_editor_style(
			[
				'assets/build/css/frontend/styles.css',
				'assets/build/css/editor/editor.css',
			]
		);
	}

	/**
	 * Registers the block pattern category.
	 */
	public function register_pattern_category(): void {
		register_block_pattern_category(
			'financing-ca',
			[ 'label' => __( 'Financing.ca sections', 'financing-ca' ) ]
		);
	}
}
