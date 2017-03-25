<?php
/**
 * Description
 *
 * @package     ${NAMESPACE}
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://KnowTheCode.io
 * @license     GNU-2.0+
 */


/**
<?php
/**
 * Module Helpers
 *
 * @package     KnowTheCode\Developers\WooCommerce
 * @since       1.1.0
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU-2.0+
 */
namespace KnowTheCode\Module\Genesis\WooCommerce;

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