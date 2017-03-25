<?php
/**
 * Runtime configuration parameters for the Theme Setup.
 *
 * @package     KnowTheCode\Developers
 * @since       1.1.0
 * @author      hellofromTonya
 * @link        https://KnowTheCode.io
 * @license     GNU-2.0+
 */
namespace KnowTheCode\Developers;

$theme_supports = array(
	'html5'                           => array(
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form',
	),
	'genesis-accessibility'           => array(
		'404-page',
		'drop-down-menu',
		'headings',
		'rems',
		'search-form',
		'skip-links',
	),
	'genesis-responsive-viewport'     => null,
	'custom-header'                   => array(
		'width'           => 600,
		'height'          => 160,
		'header-selector' => '.site-title a',
		'header-text'     => false,
		'flex-height'     => true,
	),
	'custom-background'               => null,
	'genesis-after-entry-widget-area' => null,
	'genesis-footer-widgets'          => 3,
	'genesis-menus'                   => array(
		'primary'   => __( 'After Header Menu', CHILD_TEXT_DOMAIN ),
		'secondary' => __( 'Footer Menu', CHILD_TEXT_DOMAIN ),
	),
);

$image_sizes = array(
	'featured-image' => array(
		'width'  => 720,
		'height' => 400,
		'crop'   => true,
	),
);


return array(
	'add_theme_support' => $theme_supports,
	'add_image_size'    => $image_sizes,
);
