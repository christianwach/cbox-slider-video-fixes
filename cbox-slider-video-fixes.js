/**
 * Load YouTube Frame API
 */
(function() { // closure, so as not to leak scope
	var s = document.createElement("script");
	s.src = (location.protocol == 'https:' ? 'https' : 'http') + "://www.youtube.com/player_api";
	var before = document.getElementsByTagName("script")[0];
	before.parentNode.insertBefore(s, before);
})();



/**
 * Define what happens when the page is ready
 */
jQuery(document).ready( function($) {

	/**
	 * Trap clicks on the "pager", "next" and "previous" buttons
	 */
	$('.bx-pager.bx-default-pager, .bx-next, .bx-prev').click( function( event ) {

		// stop auto slider
		cbox_slider.stopAuto();

		// pause all videos
		$('.slide-video-embed iframe').each( function() {
			$(this).data('player').pauseVideo();
		});

	});

    /**
     * Callback for the YouTube API that fires when the API is ready
     */
	window.onYouTubeIframeAPIReady = function() {

		// iterate through videos
		$('.slide-video-embed iframe').each( function() {

			// create a new player pointer
			var player = new YT.Player( document.getElementById( $(this).attr('id') ) );

			// watch for changes on the player
			player.addEventListener( 'onStateChange', function(state) {

				switch( state.data ) {

					// if a video is playing, stop the slider
					case YT.PlayerState.PLAYING:
						cbox_slider.stopAuto();
						break;

					// if the video is paused, start the slider
					case YT.PlayerState.PAUSED:
						cbox_slider.startAuto();
						break;

					// if the video has finished, go straight to next slide
					case YT.PlayerState.ENDED:
						cbox_slider.goToNextSlide();
						cbox_slider.startAuto();
						break;

				}

			});

			// store
			$(this).data('player', player);

		});

	}

});


