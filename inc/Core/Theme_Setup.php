<?php
/**
 * Theme supports, editor styles and pattern categories.
 *
 * @package Tankless\Theme
 */

declare( strict_types = 1 );

namespace Tankless\Theme\Core;

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
		add_action( 'init', [ $this, 'register_block_styles' ] );
	}

	/**
	 * Registers theme supports and editor styles.
	 */
	public function setup(): void {
		load_theme_textdomain( 'the-tankless', TANKLESS_PATH . '/languages' );

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
			'the-tankless',
			[ 'label' => __( 'The Tankless sections', 'the-tankless' ) ]
		);
	}

	/**
	 * Registers the button styles used by the patterns.
	 */
	public function register_block_styles(): void {
		register_block_style(
			'core/button',
			[
				'name'  => 'light',
				'label' => __( 'Light pill', 'the-tankless' ),
			]
		);
		register_block_style(
			'core/button',
			[
				'name'  => 'text',
				'label' => __( 'Text link', 'the-tankless' ),
			]
		);
	}
}
