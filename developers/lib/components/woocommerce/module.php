<?php
/**
 * WooCommerce Module Bootstrap
 *
 * @package     KnowTheCode\Module\Genesis\WooCommerce
 * @since       1.1.0
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU-2.0+
 */
namespace KnowTheCode\Module\Genesis\WooCommerce;

define( 'WOOCOMMERCE_MODULE_DIR', trailingslashit( __DIR__ ) );
define( 'WOOCOMMERCE_MODULE_ASSETS_URL', CHILD_THEME_URL . '/lib/components/woocommerce/assets/' );

add_action( 'switch_theme', __NAMESPACE__ . '\switching_theme_handler' );
/**
 * Switching the theme. Load the file(s) for processing.
 *
 * @since 1.1.0
 *
 * @return void
 */
function switching_theme_handler() {
	require_once( WOOCOMMERCE_MODULE_DIR . 'admin-notices.php' );

	reset_genesis_connect_install_notice();
}

add_action( 'activated_plugin', __NAMESPACE__ . '\plugin_activating_handler' );
/**
 * Plugin is activating.  Load the file(s) for processing.
 *
 * @since 1.1.0
 *
 * @param string $plugin Plugin path to the activated plugin's bootstrap file.
 *
 * @return void
 */
function plugin_activating_handler( $plugin ) {
	require_once( WOOCOMMERCE_MODULE_DIR . 'setup.php' );

	set_woocommerce_image_sizes_on_plugin_activation( $plugin );
}

add_action( 'deactivated_plugin', __NAMESPACE__ . '\plugin_deactivating_handler' );
/**
 * A plugin is deactivating.  Load the file(s) for processing.
 *
 * @since 1.1.0
 *
 * @param string $plugin The plugin slug.
 *
 * @return void
 */
function plugin_deactivating_handler( $plugin ) {
	require_once( WOOCOMMERCE_MODULE_DIR . 'admin-notices.php' );

	reset_genesis_connect_notice_on_deactivation( $plugin );
}

/**
 * Autoload the files, if WooCommerce is installed.
 *
 * @since 1.0.0
 *
 * @return void
 */
function autoload() {
	$filenames = array(
		'admin-notices.php',
		'setup.php',
	);

	if ( ! is_admin() ) {
		$filenames[] = 'css-handler.php';
	}

	foreach( $filenames as $filename ) {
		require_once( WOOCOMMERCE_MODULE_DIR . $filename );
	}
}

// Only load the files if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
	autoload();
}
