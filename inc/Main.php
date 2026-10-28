<?php
/**
 * Theme bootstrap: registers every feature class.
 *
 * @package Tankless\Theme
 */

declare( strict_types = 1 );

namespace Tankless\Theme;

use Tankless\Theme\Core\Assets;
use Tankless\Theme\Core\Security_Headers;
use Tankless\Theme\Core\Seo;
use Tankless\Theme\Core\Theme_Setup;
use Tankless\Theme\Modules\Lead\Lead_Rest_Controller;
use rtCamp\WPPrimitives\Contracts\Traits\Loader;
use rtCamp\WPPrimitives\Contracts\Traits\Singleton;

/**
 * Class - Main
 */
class Main {

	use Singleton;
	use Loader;

	/**
	 * Classes to load. A class that is not listed here does not run.
	 */
	public const CLASSES = [
		Assets::class,
		Theme_Setup::class,
		Seo::class,
		Security_Headers::class,
		Lead_Rest_Controller::class,
	];

	/**
	 * Constructor.
	 */
	protected function __construct() {
		static::$instance = $this;
		$this->load( self::CLASSES );
	}
}
