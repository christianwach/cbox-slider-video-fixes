<?php
/*
Plugin Name: CBOX Slider Video Fixes
Plugin URI: http://haystack.co.uk
Description: Fixes the handling of YouTube video in the default slider provided by the CBOX Theme
Author: Christian Wach
Version: 0.1
Author URI: http://haystack.co.uk
*/


/**
 * Enqueue Javascript
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
 * Filter YouTube URL to enable API
 */
function cbox_slider_video_fixes_wp_embed_handler_youtube( $html, $url, $attr, $post_ID ) {

	// get post
	$post_type = get_post_type( $post_ID );

	// is this a featured slider?
	if ( $post_type == 'features' ) {

		// do we have an oembed?
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



