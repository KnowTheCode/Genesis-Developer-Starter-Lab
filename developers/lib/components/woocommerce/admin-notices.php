<?php
/**
 * Adds the "Genesis Connect for WooCommerce" admin notifications.
 *
 * @package     KnowTheCode\Developers\WooCommerce
 * @since       1.1.0
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU-2.0+
 */
namespace KnowTheCode\Module\Genesis\WooCommerce;

use WC_Admin_Notices;

add_action( 'admin_print_styles', __NAMESPACE__ . '\remove_default_woocommerce_notice' );
/**
 * Remove the default WooCommerce Notice.
 *
 * @since 1.1.0
 *
 * @return void
 */
function remove_default_woocommerce_notice() {

	// If below version WooCommerce 1.1.0, exit early.
	if ( ! class_exists( 'WC_Admin_Notices' ) ) {
		return;
	}

	WC_Admin_Notices::remove_notice( 'theme_support' );
}

add_action( 'admin_notices', __NAMESPACE__ . '\render_notice_to_activate_genesis_connect' );
/**
 * Add a prompt to activate "Genesis Connect for WooCommerce"
 * if WooCommerce is active but Genesis Connect is not.
 *
 * @since 1.1.0
 *
 * @return void
 */
function render_notice_to_activate_genesis_connect() {

	// If Genesis Connect is installed, exit early.
	if ( function_exists( 'gencwooc_setup' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		return;
	}

	if ( get_user_option( CHILD_TEXT_DOMAIN . '_woocommerce_message_dismissed', get_current_user_id() ) ) {
		return;
	}

	if ( current_user_can( 'install_plugins' ) ) {
		$notice_html = sprintf(
			__( 'Please %s to <strong>enable WooCommerce support for %s</strong>.', CHILD_TEXT_DOMAIN ),
			get_genesis_connect_install_link(),
			esc_html( CHILD_THEME_NAME )
		);

	} else {
		$notice_html = sprintf(
			__( 'Please install and activate <a href="https://wordpress.org/plugins/genesis-connect-woocommerce/" target="_blank">"Genesis Connect for WooCommerce"</a> to <strong>enable WooCommerce support for %s</strong>.',
				CHILD_TEXT_DOMAIN ),
			esc_html( CHILD_THEME_NAME )
		);
	}

	include( __DIR__ . '/views/theme-notice.php' );
}

/**
 * Get the Genesis Connect's plugin install link for
 * the notification message.
 *
 * @since 1.1.0
 *
 * @return string
 */
function get_genesis_connect_install_link() {
	$plugin_slug  = 'genesis-connect-woocommerce';

	$plugin_link = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'install-plugin',
				'plugin' => $plugin_slug,
			),
			network_admin_url( 'update.php' )
		),
		'install-plugin_' . $plugin_slug
	);

	return sprintf( '<a href="%s">%s</a>',
		$plugin_link,
		__( 'install and activate "Genesis Connect for WooCommerce"', CHILD_TEXT_DOMAIN )
	);
}

add_action( 'wp_ajax_dismiss_child_theme_woocommerce_notice', __NAMESPACE__ . '\dismiss_woocommerce_notice' );
/**
 * Add option to dismiss "Genesis Connect for WooCommerce" plugin install prompt.
 *
 * @since 1.1.0
 *
 * @return void
 */
function dismiss_woocommerce_notice() {
	update_user_option(
		get_current_user_id(),
		CHILD_TEXT_DOMAIN . '_woocommerce_message_dismissed',
		1
	);
}

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_update_notice_script' );
/**
 * Enqueue script to clear the "Genesis Connect for WooCommerce" plugin install prompt on dismissal.
 *
 * @since 1.1.0
 *
 * @return void
 */
function enqueue_update_notice_script() {
	wp_enqueue_script(
		CHILD_TEXT_DOMAIN . '_notice_script',
		WOOCOMMERCE_MODULE_ASSETS_URL . 'js/jquery.notice-update.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);
}

/**
 * Clear the "Genesis Connect for WooCommerce" plugin prompt
 * when either WooCommerce or Genesis Connect plugin deactivating.
 *
 * @since 1.1.0
 *
 * @param string $plugin The plugin slug.
 *
 * @return void
 */
function reset_genesis_connect_notice_on_deactivation( $plugin ) {
	$plugins = array(
		'woocommerce/woocommerce.php',
		'genesis-connect-woocommerce/genesis-connect-woocommerce.php'
	);

	if ( ! in_array( $plugin, $plugins ) ) {
		return;
	}

	reset_genesis_connect_install_notice();
}

/**
 * Clear the "Genesis Connect for WooCommerce" plugin install prompt on theme change.
 *
 * @since 1.1.0
 *
 * @return void
 */
function reset_genesis_connect_install_notice() {
	global $wpdb;

	$args  = array(
		'meta_key'   => $wpdb->prefix . CHILD_TEXT_DOMAIN . '_woocommerce_message_dismissed',
		'meta_value' => 1,
	);
	$users = get_users( $args );

	foreach ( $users as $user ) {
		delete_user_option( $user->ID, CHILD_TEXT_DOMAIN . '_woocommerce_message_dismissed' );
	}
}