<?php
/**
 * The [readmore] shortcode.
 *
 * @package Tuckaway
 */

// Block direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers [readmore] and renders it as a single empty marker span.
 *
 * Output is intentionally nothing but that marker. All actual
 * splitting, wrapping, and animation logic happens client side in JS,
 * so the shortcode stays valid no matter which widget, block, or
 * editor renders it, and produces no visible output of its own if the
 * script is ever unavailable.
 *
 * @since 1.0.0
 */
final class Tuckaway_Shortcode {

	/**
	 * Shortcode tag.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const TAG = 'readmore';

	/**
	 * Second tag that does exactly the same thing.
	 *
	 * [readmore] is the obvious name for any read-more plugin to claim,
	 * and when two active plugins register the same tag only one of them
	 * wins. [tuckaway] carries this plugin's own name, so it always
	 * reaches this plugin whatever else is installed.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const TAG_ALIAS = 'tuckaway';

	/**
	 * CSS class the front-end script looks for.
	 *
	 * This one is effectively public API: the documentation tells site
	 * owners to paste `<span class="taway-marker"></span>` by hand into
	 * widgets that do not run shortcodes. Renaming it in a future
	 * release would silently break every page doing that, so treat it
	 * as fixed.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const MARKER_CLASS = 'taway-marker';

	/**
	 * Hook the shortcode.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function register() {
		add_shortcode( self::TAG, array( __CLASS__, 'render' ) );
		add_shortcode( self::TAG_ALIAS, array( __CLASS__, 'render' ) );
	}

	/**
	 * Render the marker.
	 *
	 * @since 1.0.0
	 *
	 * @param array<string,mixed>|string $atts    Shortcode attributes. Unused; the
	 *                                            shortcode takes none.
	 * @param string|null                $content Enclosed content. Unused; the
	 *                                            shortcode is self-closing.
	 * @return string Marker markup.
	 */
	public static function render( $atts = array(), $content = null ) {
		unset( $atts, $content );

		// The assets load only on views that use the plugin, and this
		// is the most reliable signal that this one does.
		Tuckaway_Assets::request();

		return '<span class="' . esc_attr( self::MARKER_CLASS ) . '" aria-hidden="true"></span>';
	}
}
