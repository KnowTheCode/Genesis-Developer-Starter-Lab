<?php
/**
 * Customizer handler.
 *
 * @package     KnowTheCode\Developers
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU General Public License 2.0+
 */
namespace KnowTheCode\Developers\Customizer;

use WP_Customize_Color_Control;

add_action( 'customize_register', __NAMESPACE__ . '\register_with_customizer' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function register_with_customizer() {
	$prefix = get_settings_prefix();

	global $wp_customize;

	$wp_customize->add_setting(
		$prefix . '_link_color',
		array(
			'default'           => get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$prefix . '_link_color',
			array(
				'description' => __( 'Change the default color for linked titles, menu links, post info links and more.', CHILD_TEXT_DOMAIN ),
			    'label'       => __( 'Link Color', CHILD_TEXT_DOMAIN ),
			    'section'     => 'colors',
			    'settings'    => $prefix . '_sample_link_color',
			)
		)
	);

	$wp_customize->add_setting(
		$prefix . '_accent_color',
		array(
			'default'           => get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$prefix . '_accent_color',
			array(
				'description' => __( 'Change the default color for button hovers.', CHILD_TEXT_DOMAIN ),
			    'label'       => __( 'Accent Color', CHILD_TEXT_DOMAIN ),
			    'section'     => 'colors',
			    'settings'    => $prefix . '_accent_color',
			)
		)
	);

}
