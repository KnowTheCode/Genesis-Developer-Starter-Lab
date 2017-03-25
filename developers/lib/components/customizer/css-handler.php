<?php
/**
 * Adds the CSS from the Customizer options.
 *
 * @package     KnowTheCode\Developers
 * @since       1.1.0
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU General Public License 2.0+
 */
namespace KnowTheCode\Developers\Customizer;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\build_inline_css_from_customizer_settings' );
/**
 * Checks the settings for the link color, and accent color.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.1.0
 */
function build_inline_css_from_customizer_settings() {
	$prefix = get_settings_prefix();

	$css = get_link_color_css( $prefix ) . get_accent_color_css( $prefix );

	if ( ! $css ) {
		return;
	}

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME
		? sanitize_title_with_dashes( CHILD_THEME_NAME )
		: 'child-theme';

	wp_add_inline_style( $handle, $css );

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
	$color_link = get_theme_mod(
		$prefix . '_link_color',
		get_default_link_color()
	);

	if ( get_default_link_color() === $color_link ) {
		return '';
	}

	return sprintf(
		'a,
		.entry-title a:focus,
		.entry-title a:hover,
		.genesis-nav-menu a:focus,
		.genesis-nav-menu a:hover,
		.genesis-nav-menu .current-menu-item > a,
		.genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.js nav button:focus,
		.js .menu-toggle:focus {
			color: %s;
		}',
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
		get_default_accent_color()
	);

	if ( get_default_accent_color() === $color_accent ) {
		return '';
	}

	return sprintf(
		'button:focus,
		button:hover,
		input:focus[type="button"],
		input:focus[type="reset"],
		input:focus[type="submit"],
		input:hover[type="button"],
		input:hover[type="reset"],
		input:hover[type="submit"],
		.archive-pagination li a:focus,
		.archive-pagination li a:hover,
		.archive-pagination .active a,
		.button:focus,
		.button:hover,
		.sidebar .enews-widget input[type="submit"] {
			background-color: %s;
			color: %s;
		}',
		$color_accent,
		calculate_color_contrast( $color_accent )
	);
}
