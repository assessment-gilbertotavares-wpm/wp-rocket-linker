<?php
namespace WP_Rocket_Linker\Frontend;

class Assets {
	/**
	 * Registers the action hook to enqueue frontend assets.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
	}

	/**
	 * Enqueues the frontend JavaScript if the current page is the front page.
	 *
	 * @return void
	 */
	public function enqueue_frontend_assets() {
		if ( ! is_front_page() ) {
			return;
		}
		wp_enqueue_script(
			'wp-rocket-linker-track-links',
			plugins_url( '/assets/js/track-links.js', ROCKET_LNKR_PLUGIN_FILENAME ),
			array(),
			'1.0.0',
			true
		);
		wp_localize_script(
			'wp-rocket-linker-track-links',
			'WPRocketLinker',
			array(
				'endpoint' => esc_url_raw( rest_url( 'wp-rocket-linker/v1/entry' ) ),
				'token'    => wp_hash( 'wp_rocket_linker_submit_entry', 'auth' ),
			)
		);
	}
}
