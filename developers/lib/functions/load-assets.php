<?php
/**
 * Asset loader handler.
 *
 * @package     KnowTheCode\Developers
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU General Public License 2.0+
 */
namespace KnowTheCode\Developers;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );
/**
 * Enqueue Scripts and Styles.
 *
 * @since 1.1.0
 *
 * @return void
 */
function enqueue_assets() {

	wp_enqueue_style(
		CHILD_TEXT_DOMAIN . '-fonts',
		'//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700',
		array(),
		CHILD_THEME_VERSION
	);
	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$script_handle = CHILD_TEXT_DOMAIN . '-responsive-menus';

	wp_enqueue_script(
		$script_handle,
		CHILD_THEME_URL . "/assets/js/responsive-menus{$suffix}.js",
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

	localize_the_responsive_menu_script( $script_handle );
}

/**
 * Localize the responsive menu script variables.
 *
 * @since 1.1.0
 *
 * @param string $script_handle Script handle
 *
 * @return void
 */
function localize_the_responsive_menu_script( $script_handle ) {

	$settings = array(
		'mainMenu'          => __( 'Menu', CHILD_TEXT_DOMAIN ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', CHILD_TEXT_DOMAIN ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	wp_localize_script(
		$script_handle,
		'developersL10n',
		$settings
	);
}
