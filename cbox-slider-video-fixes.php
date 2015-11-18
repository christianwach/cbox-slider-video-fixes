<?php /*
--------------------------------------------------------------------------------
Plugin Name: CBOX Slider Video Fixes
Plugin URI: https://github.com/christianwach/cbox-slider-video-fixes
Description: Fixes the handling of YouTube video in the default slider provided by the CBOX Theme
Author: Christian Wach
Version: 0.2
Author URI: http://haystack.co.uk
--------------------------------------------------------------------------------
*/



/**
 * Enqueue Javascript.
 */
function cbox_slider_video_fixes_enqueue_scripts() {

	// is this the homepage template?
	if ( is_page_template( 'templates/homepage-template.php' ) ) {

		// enqueue our custom Javascript
		wp_enqueue_script(
			'cbox_slider_video_fixes_js',
			plugin_dir_url( __FILE__ ) . 'cbox-slider-video-fixes.js',
			array( 'jquery' ),
			'1.0',
			true
		);

	}

}

// add action for the above
add_action( 'wp_enqueue_scripts', 'cbox_slider_video_fixes_enqueue_scripts' );



/**
 * Filter YouTube URL to enable API.
 *
 * @param str $html The existing oEmbed HTML
 * @param str $url The YouTube video URL
 * @param str $attr The oEmbed attributes
 * @param int $post_ID The containing WordPress post ID
 * @return str $html The modified oEmbed HTML
 */
function cbox_slider_video_fixes_wp_embed_handler_youtube( $html, $url, $attr, $post_ID ) {

	// get post
	$post_type = get_post_type( $post_ID );

	// is this a featured slider?
	if ( $post_type == 'features' ) {

		// do we have an oEmbed?
		if ( false !== strpos( $html, 'feature=oembed' ) ) {

			// enable YouTube API on video
			$html = str_replace( 'feature=oembed', 'feature=oembed&enablejsapi=1', $html );

		}

	}

	// --<
	return $html;

}

// add filter for the above
add_filter( 'embed_oembed_html', 'cbox_slider_video_fixes_wp_embed_handler_youtube', 10, 4 );




/**
 * Customise the CBOX Slider.
 *
 * We need to show the slider controls because users need to be able to manually
 * navigate the slider when videos are present.
 *
 * @param array $args The existing setup arguments that are passed to the CBOX slider
 * @return array $args The modified setup arguments to be passed to the CBOX slider
 */
function cbox_slider_video_fixes_flex_slider_controls( $args ) {

	// show slider controls
	$args['controls'] = true;

	// --<
	return $args;

}

// add filter for the above
add_filter( 'cbox_flex_slider_controls', 'cbox_slider_video_fixes_flex_slider_controls' );



