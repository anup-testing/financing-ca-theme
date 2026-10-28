<?php
/**
 * Registers and enqueues theme assets.
 *
 * @package Tankless\Theme
 */

declare( strict_types = 1 );

namespace Tankless\Theme\Core;

use rtCamp\WPPrimitives\AssetLoader;
use rtCamp\WPPrimitives\Contracts\Interfaces\Registrable;

/**
 * Class - Assets
 */
class Assets extends AssetLoader implements Registrable {

	/**
	 * Handle prefix.
	 */
	public const HANDLE_PREFIX = 'the-tankless-';

	/**
	 * Self-hosted font files, relative to the theme root.
	 */
	public const FONTS = [
		'manrope' => 'assets/fonts/manrope-latin-var.woff2',
		'exo-2'   => 'assets/fonts/exo-2-latin-var.woff2',
	];

	/**
	 * Largest combined stylesheet size (bytes) WordPress may inline instead of linking.
	 */
	private const INLINE_STYLES_LIMIT = 40000;

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct( TANKLESS_PATH, get_template_directory_uri(), 'assets/build' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function register_hooks(): void {
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_fonts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
		add_filter( 'styles_inline_size_limit', [ $this, 'inline_styles_limit' ] );
	}

	/**
	 * Raises the inline-styles limit so the (small) theme stylesheet is printed
	 * inline and no longer blocks rendering with its own request.
	 */
	public function inline_styles_limit(): int {
		return self::INLINE_STYLES_LIMIT;
	}

	/**
	 * Self-hosted @font-face rules, printed inline on the front end and in the editor.
	 */
	public function enqueue_fonts(): void {
		$face = static function ( string $family, string $style, string $weight, string $file ): string {
			return sprintf(
				'@font-face{font-family:"%1$s";font-style:%2$s;font-weight:%3$s;font-display:swap;src:url("%4$s") format("woff2");}',
				$family,
				$style,
				$weight,
				esc_url( get_theme_file_uri( $file ) )
			);
		};

		$css  = $face( 'Manrope', 'normal', '400 800', self::FONTS['manrope'] );
		$css .= $face( 'Exo 2', 'normal', '100 900', self::FONTS['exo-2'] );

		wp_register_style( 'the-tankless-fonts', false, [], TANKLESS_VERSION );
		wp_enqueue_style( 'the-tankless-fonts' );
		wp_add_inline_style( 'the-tankless-fonts', $css );
	}

	/**
	 * Enqueues front-end styles and scripts.
	 */
	public function enqueue_assets(): void {
		$style = $this->handle( 'styles' );

		if ( $this->register_style( $style, 'css/frontend/styles' ) ) {
			wp_style_add_data( $style, 'path', TANKLESS_BUILD_DIR . '/css/frontend/styles.css' );
			wp_enqueue_style( $style );
		}

		if ( $this->register_script( $this->handle( 'frontend' ), 'js/frontend/index' ) ) {
			wp_enqueue_script( $this->handle( 'frontend' ) );
			wp_localize_script(
				$this->handle( 'frontend' ),
				'TheTankless',
				[ 'leadUrl' => esc_url_raw( rest_url( 'the-tankless/v1/lead' ) ) ]
			);
		}
	}
}
