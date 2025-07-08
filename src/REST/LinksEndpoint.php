<?php
namespace WP_Rocket_Linker\REST;

use WP_Rocket_Linker\Database\Database;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

class LinksEndpoint {
	/**
	 * Registers the REST API route for saving entry data
	 *
	 * @return void
	 */
	public static function register() {
		register_rest_route(
			'wp-rocket-linker/v1',
			'/entry',
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( self::class, 'handle' ),
				'permission_callback' => array( self::class, 'verify_permission' ),
			)
		);
	}

	/**
	 * Verifies the request by comparing a hashed token header.
	 *
	 * @return bool True if permission is granted, false otherwise.
	 */
	public static function verify_permission(): bool {
		$received_token = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_WP_ROCKET_LINKER_TOKEN'] ?? '' ) );
		$expected_token = wp_hash( 'wp_rocket_linker_submit_entry', 'auth' );

		return hash_equals( $expected_token, $received_token );
	}

	/**
	 * Handles incoming REST API requests to save a new entry with visible links
	 *
	 * @param WP_REST_Request $request The REST request containing entry data.
	 *
	 * @return WP_REST_Response The response indicating success or failure.
	 */
	public static function handle( WP_REST_Request $request ) {
		$params = $request->get_json_params();
		if (
			empty( $params['visible_links'] ) ||
			empty( $params['screen_size'] ) ||
			empty( $params['date'] ) ||
			! is_array( $params['visible_links'] )
		) {
			return new WP_REST_Response( array( 'error' => 'Invalid payload' ), 400 );
		}

		$visible_links = array();
		foreach ( $params['visible_links'] as $link ) {
			$visible_links[] = array(
				'url'  => sanitize_text_field( $link['url'] ),
				'name' => sanitize_text_field( $link['name'] ),
			);
		}
		$database = new Database();
		$query    = $database->get_query();
		$entry_id = $query->add_item(
			array(
				'entry_date'     => get_date_from_gmt( gmdate( 'Y-m-d H:i:s', strtotime( $params['date'] ) ) ),
				'entry_date_gmt' => gmdate( 'Y-m-d H:i:s', strtotime( $params['date'] ) ),
				'screen_size'    => sanitize_text_field( $params['screen_size'] ),
				'visible_links'  => $visible_links,
			)
		);

		if ( ! $entry_id ) {
			return new WP_REST_Response( array( 'error' => 'Failed to save entry' ), 500 );
		}

		return new WP_REST_Response( array( 'success' => true ), 201 );
	}
}
