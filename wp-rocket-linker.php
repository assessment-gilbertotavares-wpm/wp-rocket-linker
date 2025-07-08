<?php
/**
 * WP Rocket Linker
 *
 * @package     WP_Rocket_Linker
 * @author      WP Media
 * @copyright   2025 WP Media
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:  WP Rocket Linker
 * Plugin URI:   https://github.com/assessment-gilbertotavares-wpm/wp-rocket-linker
 * Version:      1.0.0
 * Description:  Capture and analyze which homepage links are viewed above the fold over the past 7 days.
 * Author:       WP Media
 * Contributors: Gilberto Tavares (camaleaun)
 * Author URI:   https://wp-media.io
 * Text Domain:  wp-rocket-linker
 * Domain Path:  /languages
 * Requires PHP: 7.3
 * Requires WP:  6.0
 * License:      GPLv2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace WP_Rocket_Linker;

use WP_Rocket_Linker\Plugin as Rocket_Wpl_Plugin_Class;

define( 'ROCKET_LNKR_PLUGIN_FILENAME', __FILE__ ); // Filename of the plugin, including the file.

if ( ! defined( 'ABSPATH' ) ) { // If WordPress is not loaded.
	exit( 'WordPress not loaded. Can not load the plugin' );
}

// Load the dependencies installed through composer.
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/support/exceptions.php';

// Plugin initialization.
/**
 * Creates the plugin object on plugins_loaded hook
 *
 * @return void
 */
function wpl_linker_plugin_init() {
	$wpl_linker_plugin = new Rocket_Wpl_Plugin_Class();
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\wpl_linker_plugin_init' );

register_activation_hook( __FILE__, array( Rocket_Wpl_Plugin_Class::class, 'wpl_activate' ) );
register_uninstall_hook( __FILE__, array( Rocket_Wpl_Plugin_Class::class, 'wpl_uninstall' ) );
add_action( 'wp_rocket_linker_cleanup_daily', array( Rocket_Wpl_Plugin_Class::class, 'daily_cleanup' ) );
