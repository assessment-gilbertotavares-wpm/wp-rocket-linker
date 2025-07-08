<?php
/**
 * Plugin main class
 *
 * @package     WP_Rocket_Linker
 * @author      WP Media
 * @copyright   2025 WP Media
 * @license     GPL-2.0-or-later
 */

namespace WP_Rocket_Linker;

use WP_Rocket_Linker\Admin\EntriesPage;
use WP_Rocket_Linker\REST\LinksEndpoint;
use WP_Rocket_Linker\Frontend\Assets;
use WP_Rocket_Linker\Database\Database;

/**
 * Main plugin class. It manages initialization, install, and activations.
 */
class Plugin {
	/**
	 * Manages plugin initialization
	 *
	 * @return void
	 */
	public function __construct() {

		// Register plugin lifecycle hooks.
		register_deactivation_hook( ROCKET_LNKR_PLUGIN_FILENAME, array( $this, 'wpl_deactivate' ) );

		add_action( 'plugins_loaded', array( self::class, 'database' ) );
		add_action( 'rest_api_init', array( new LinksEndpoint(), 'register' ) );
		add_action( 'admin_menu', array( new EntriesPage(), 'register_menu' ) );
		( new Assets() )->register();
	}

	/**
	 * Handles plugin activation
	 *
	 * @return void
	 */
	public static function wpl_activate() {
		// Security checks.
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		$plugin = isset( $_REQUEST['plugin'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['plugin'] ) ) : '';
		check_admin_referer( "activate-plugin_{$plugin}" );
		self::database();
		if ( ! wp_next_scheduled( 'wp_rocket_linker_cleanup_daily' ) ) {
			wp_schedule_event( time(), 'daily', 'wp_rocket_linker_cleanup_daily' );
		}
	}

	/**
	 * Handles plugin deactivation
	 *
	 * @return void
	 */
	public function wpl_deactivate() {
		// Security checks.
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		$plugin = isset( $_REQUEST['plugin'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['plugin'] ) ) : '';
		check_admin_referer( "deactivate-plugin_{$plugin}" );
	}

	/**
	 * Handles plugin uninstall
	 *
	 * @return void
	 */
	public static function wpl_uninstall() {

		// Security checks.
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
	}

	/**
	 * Initializes the database tables if they don't exist
	 *
	 * @return void
	 */
	public static function database() {
		$database = new Database();
		$table    = $database->get_table();
		if ( ! $table->exists() ) {
			$table->install();
		}
	}

	/**
	 * Performs daily cleanup of old entries older than 7 days
	 *
	 * @return void
	 */
	public static function daily_cleanup() {
		// phpcs:disable WordPress.DB.DirectDatabaseQuery
		global $wpdb;
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM {$wpdb->prefix}wrl_entries WHERE entry_date < %s",
				gmdate( 'Y-m-d H:i:s', strtotime( '-7 days' ) )
			)
		);
		// phpcs:enable WordPress.DB.DirectDatabaseQuery
	}
}
