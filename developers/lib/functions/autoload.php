<?php
/**
 * File autoloader
 *
 * We could use Composer, but it feels a bit heavy for the number of files we need to load up.  As this is procedural
 * and not OOP, we can handle loading the files directly right here in this file.  Now to add more files to be loaded,
 * well shucks you can do that right here.  A function is provided for each folder.
 *
 * Resist the temptation to add widgets, custom post types, taxonomies, and/or shortcodes in your theme.  Those features
 * go into a plugin and not in your theme.  If you put them here, I want you to picture me shaking my head back and
 * forth.  Come on....I taught you better than that.
 *
 * @package     KnowTheCode\Developers
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU General Public License 2.0+
 */
namespace KnowTheCode\Developers;

/**
 * Loads non admin files.
 *
 * @since 1.0.1
 *
 * @return void
 */
function load_nonadmin_files() {
	$filenames = array(
		'setup.php',
		'components/customizer/css-handler.php',
		'components/customizer/helpers.php',
		'functions/formatting.php',
		'functions/load-assets.php',
		'functions/markup.php',
//		'structure/archive.php',
		'structure/comments.php',
//		'structure/footer.php',
//		'structure/header.php',
		'structure/menu.php',
		'structure/post.php',
//		'structure/sidebar.php',
		'components/customizer/customizer.php',
	);

	load_specified_files( $filenames );
}

//add_action( 'admin_init', __NAMESPACE__ . '\load_admin_files' );
/**
 * Load admin files.
 *
 * @since 1.0.1
 *
 * @return void
 */
function load_admin_files() {
	$filenames = array(

	);

	load_specified_files( $filenames );
}

/**
 * Load each of the specified files.
 *
 * @since 1.0.0
 *
 * @param array $filenames
 * @param string $folder_root
 *
 * @return void
 */
function load_specified_files( array $filenames, $folder_root = '' ) {
	$folder_root = $folder_root ?: CHILD_THEME_DIR . '/lib/';

	foreach( $filenames as $filename ) {
		include( $folder_root . $filename );
	}
}

load_nonadmin_files();
