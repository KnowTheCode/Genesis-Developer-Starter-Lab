<?php
/**
 * Adds the CSS from the WooCommerce Module options.
 *
 * @package     KnowTheCode\Developers\WooCommerce
 * @since       1.1.0
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU-2.0+
 */
namespace KnowTheCode\Module\Genesis\WooCommerce;

use KnowTheCode\Developers\Customizer as customizer;

add_filter( 'woocommerce_enqueue_styles', __NAMESPACE__ . '\enqueue_woocommerce_styles' );
/**
 * Enqueue the theme's custom WooCommerce styles to the WooCommerce plugin.
 *
 * @since 1.1.0
 *
 * @param array $enqueue_styles An array of styles
 *
 * @return array Required values for the Genesis Sample Theme's WooCommerce stylesheet.
 */
function enqueue_woocommerce_styles( $enqueue_styles ) {

	$enqueue_styles[ get_woo_style_handle() ] = array(
		'src'     => CHILD_URL . '/lib/components/woocommerce/assets/css/woocommerce.css',
		'deps'    => '',
		'version' => CHILD_THEME_VERSION,
		'media'   => 'screen',
	);

	return $enqueue_styles;
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\build_incline_css_from_customizer_settings' );
/**
 * Checks the settings for the link color, and accent color.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.1.0
 *
 * @return void
 */
function build_incline_css_from_customizer_settings() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$prefix = customizer\get_settings_prefix();

	$css = get_link_color_css( $prefix ) . get_accent_color_css( $prefix );

	if ( ! $css ) {
		return;
	}

	wp_add_inline_style( get_woo_style_handle(), $css );
}

/**
 * Get the Link Color Styles.
 *
 * @since 1.1.0
 *
 * @param string $prefix
 *
 * @return string
 */
function get_link_color_css( $prefix ) {
	$color_link   = get_theme_mod(
		$prefix . '_link_color',
		customizer\get_default_link_color()
	);

	if ( customizer\get_default_link_color() === $color_link ) {
		return '';
	}

	return sprintf(
		'.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,
		.woocommerce ul.products li.product h3:hover,
		.woocommerce ul.products li.product .price,
		.woocommerce .woocommerce-breadcrumb a:hover,
		.woocommerce .woocommerce-breadcrumb a:focus,
		.woocommerce .widget_layered_nav ul li.chosen a::before,
		.woocommerce .widget_layered_nav_filters ul li a::before,
		.woocommerce .widget_rating_filter ul li.chosen a::before {
			color: %s;
		',
		$color_link
	);
}

/**
 * Get the Accent Color styles.
 *
 * @since 1.1.0
 *
 * @param string $prefix
 *
 * @return string
 */
function get_accent_color_css( $prefix ) {
	$color_accent = get_theme_mod(
		$prefix . '_accent_color',
		customizer\get_default_accent_color()
	);

	if ( customizer\get_default_accent_color() === $color_accent ) {
		return '';
	}

	return sprintf(
		'.woocommerce a.button:hover,
		.woocommerce a.button:focus,
		.woocommerce a.button.alt:hover,
		.woocommerce a.button.alt:focus,
		.woocommerce button.button:hover,
		.woocommerce button.button:focus,
		.woocommerce button.button.alt:hover,
		.woocommerce button.button.alt:focus,
		.woocommerce input.button:hover,
		.woocommerce input.button:focus,
		.woocommerce input.button.alt:hover,
		.woocommerce input.button.alt:focus,
		.woocommerce input[type="submit"]:hover,
		.woocommerce input[type="submit"]:focus,
		.woocommerce span.onsale,
		.woocommerce #respond input#submit:hover,
		.woocommerce #respond input#submit:focus,
		.woocommerce #respond input#submit.alt:hover,
		.woocommerce #respond input#submit.alt:focus,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-handle,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-range {
			background-color: %1$s;
			color: %2$s;
		}
		.woocommerce-error,
		.woocommerce-info,
		.woocommerce-message {
			border-top-color: %1$s;
		}
		.woocommerce-error::before,
		.woocommerce-info::before,
		.woocommerce-message::before {
			color: %1$s;
		}',
		$color_accent,
		customizer\calculate_color_contrast( $color_accent )
	);
}

/**
 * Get styles handle for the WooCommerce module.
 *
 * @since 1.1.0
 *
 * @return string
 */
function get_woo_style_handle() {
	if ( defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ) {
		return sanitize_title_with_dashes( CHILD_THEME_NAME ) . '-woocommerce-styles';
	}

	return 'child-theme-woocomerce-styles';
}
