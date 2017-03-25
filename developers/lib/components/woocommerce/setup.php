<?php
/**
 * Setup the module.
 *
 * @package     KnowTheCode\Developers\WooCommerce
 * @since       1.1.0
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU-2.0+
 */
namespace KnowTheCode\Module\Genesis\WooCommerce;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_products_match_height_scripts', 99 );
/**
 * Print an inline script to the footer to keep products the same height.
 *
 * @since 1.1.0
 *
 * @return void
 */
function enqueue_products_match_height_scripts() {

	// If a product page isn't showing, exit early.
	if ( ! is_shop() && ! is_product_category() && ! is_product_tag() ) {
		return;
	}

	$handle = CHILD_TEXT_DOMAIN . '-match-height';

	wp_enqueue_script(
		$handle,
		WOOCOMMERCE_MODULE_ASSETS_URL . 'js/jquery.matchHeight.min.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

	wp_add_inline_script(
		$handle,
		"jQuery(document).ready( function() { jQuery( '.product .woocommerce-LoopProduct-link').matchHeight(); });"
	);

}

add_filter( 'woocommerce_style_smallscreen_breakpoint', __NAMESPACE__ . '\modify_woocommerce_breakpoints' );
/**
 * Modify the WooCommerce breakpoints.
 *
 * @since 1.1.0
 *
 * @return string Pixel width of the theme's breakpoint.
 */
function modify_woocommerce_breakpoints() {

	$current = genesis_site_layout();
	$layouts = array(
		'one-sidebar' => array(
			'content-sidebar',
			'sidebar-content',
		),
		'two-sidebar' => array(
			'content-sidebar-sidebar',
			'sidebar-content-sidebar',
			'sidebar-sidebar-content',
		),
	);

	if ( in_array( $current, $layouts['two-sidebar'] ) ) {
		return '2000px'; // Show mobile styles immediately.
	}

	if ( in_array( $current, $layouts['one-sidebar'] ) ) {
		return '1200px';
	}

	return '860px';
}

add_filter( 'genesiswooc_products_per_page', __NAMESPACE__ . '\set_default_products_per_page' );
/**
 * Set the default products per page.
 *
 * @since 1.1.0
 *
 * @return int Number of products to show per page.
 */
function set_default_products_per_page() {
	return 8;
}

add_filter( 'woocommerce_pagination_args', __NAMESPACE__ . '\modify_woocommerce_pagination' );
/**
 * Update the next and previous arrows to the default Genesis style.
 *
 * @since 1.1.0
 *
 * @param array $args An array of pagination arguments.
 *
 * @return string New next and previous text string.
 */
function modify_woocommerce_pagination( array $args ) {

	$args['prev_text'] = sprintf( '&laquo; %s', __( 'Previous Page', CHILD_TEXT_DOMAIN ) );
	$args['next_text'] = sprintf( '%s &raquo;', __( 'Next Page', CHILD_TEXT_DOMAIN ) );

	return $args;
}

add_action( 'after_switch_theme', __NAMESPACE__ . '\set_woocommerce_image_sizes_after_switch_theme', 1 );
/**
 * Define WooCommerce image sizes on theme activation.
 *
 * @since 1.1.0
 *
 * @return void
 */
function set_woocommerce_image_sizes_after_switch_theme() {

	global $pagenow;

	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' || ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	set_woocommerce_image_sizes();
}

/**
 * Define the WooCommerce image sizes on WooCommerce activation.
 *
 * @since 1.1.0
 *
 * @param string $plugin Plugin path to the activated plugin's bootstrap file.
 *
 * @return void
 */
function set_woocommerce_image_sizes_on_plugin_activation( $plugin ) {

	if ( $plugin !== 'woocommerce/woocommerce.php' ) {
		return;
	}

	set_woocommerce_image_sizes();
}

/**
 * Set the image sizes for WooCommerce.
 *
 * @since 1.0.0
 *
 * @return void
 */
function set_woocommerce_image_sizes() {

	$catalog   = array(
		'width'  => '500', // px
		'height' => '500', // px
		'crop'   => 1,     // true
	);
	$single    = array(
		'width'  => '655', // px
		'height' => '655', // px
		'crop'   => 1,     // true
	);
	$thumbnail = array(
		'width'  => '180', // px
		'height' => '180', // px
		'crop'   => 1,     // true
	);

	// Image sizes.
	update_option( 'shop_catalog_image_size', $catalog );     // Product category thumbs.
	update_option( 'shop_single_image_size', $single );       // Single product image.
	update_option( 'shop_thumbnail_image_size', $thumbnail ); // Image gallery thumbs.
}