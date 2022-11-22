<?php
/**
 * Elementor class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TLPPortfolioElementor' ) ) :
	/**
	 * Elementor class.
	 */
	class TLPPortfolioElementor {
		public function __construct() {
			if ( did_action( 'elementor/loaded' ) ) {
				add_action( 'elementor/widgets/widgets_registered', [ $this, 'init' ] );
			}
		}

		public function init() {
			global $TLPportfolio;

			require_once $TLPportfolio->incPath . '/vendor/TlpPortfolioElementorWidget.php';
			// Register widget.
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TlpPortfolioElementorWidget() );
		}
	}
endif;
