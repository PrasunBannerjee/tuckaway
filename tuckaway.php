<?php
/**
 * Plugin Name:       Tuckaway
 * Plugin URI:        https://github.com/PrasunBannerjee/tuckaway
 * Description:       Adds a [readmore] shortcode that splits content into a visible part and a collapsible Read More / Read Less part.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.2
 * Author:            Prasun Bannerjee
 * Author URI:        https://prasun.in
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tuckaway
 * Domain Path:       /languages
 *
 * @package Tuckaway
 */

// Block direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ====================================================================
 * LABEL CONFIGURATION
 * ====================================================================
 * Change the two strings below to update every "Read More / Read Less"
 * instance across the entire site.
 *
 * IMPORTANT: editing this file directly means your change is
 * overwritten the next time the plugin updates. To make the change
 * permanent, either define the constants in wp-config.php instead, or
 * use the `tuckaway_labels` filter from your child theme's
 * functions.php:
 *
 *     add_filter( 'tuckaway_labels', function ( $labels ) {
 *         $labels['more'] = 'Show More';
 *         $labels['less'] = 'Show Less';
 *         return $labels;
 *     } );
 *
 * Both options are documented in readme.txt and docs/usage-manual.html.
 */
if ( ! defined( 'TUCKAWAY_LABEL_MORE' ) ) {
	define( 'TUCKAWAY_LABEL_MORE', 'Read More' );
}
if ( ! defined( 'TUCKAWAY_LABEL_LESS' ) ) {
	define( 'TUCKAWAY_LABEL_LESS', 'Read Less' );
}

/**
 * Plugin metadata constants. Not intended to be edited.
 */
define( 'TUCKAWAY_VERSION', '1.0.0' );
define( 'TUCKAWAY_FILE', __FILE__ );
define( 'TUCKAWAY_PATH', plugin_dir_path( __FILE__ ) );
define( 'TUCKAWAY_URL', plugin_dir_url( __FILE__ ) );

require_once TUCKAWAY_PATH . 'includes/class-tuckaway.php';
require_once TUCKAWAY_PATH . 'includes/class-tuckaway-shortcode.php';
require_once TUCKAWAY_PATH . 'includes/class-tuckaway-assets.php';

/**
 * Boot the plugin.
 *
 * Runs on `plugins_loaded`, the usual point for a plugin to register
 * its hooks once every plugin has loaded.
 *
 * This timing does not affect the labels. The label constants are
 * fixed when this file is read, near the top, before `plugins_loaded`
 * fires and before any theme loads, so they can only be set ahead of
 * that, in wp-config.php. The `tuckaway_labels` filter is
 * applied much later, when the assets are enqueued, so a theme or
 * plugin can add it at any point before then.
 *
 * @since 1.0.0
 *
 * @return void
 */
function tuckaway_bootstrap() {
	Tuckaway::instance()->run();
}
add_action( 'plugins_loaded', 'tuckaway_bootstrap' );
