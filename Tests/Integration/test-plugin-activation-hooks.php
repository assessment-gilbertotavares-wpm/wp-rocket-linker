<?php
/**
 * Integration test for plugin loading.
 *
 * @package     WP_Rocket_Linker
 * @author      WP Media
 * @copyright   2025 WP Media
 * @license     GPL-2.0-or-later
 */

namespace WP_Rocket_Linker;

require_once dirname(dirname(__DIR__)) . "/wp-rocket-linker.php";

use WPMedia\PHPUnit\Integration\TestCase;
use Brain\Monkey\Functions;

/**
 * Integration test for plugin initialization behavior.
 */
class Plugin_Activation_Hooks_Integration_Test extends TestCase {

	/**
	 * It should call the plugin init function on the 'plugins_loaded' hook.
	 */
	public function testShouldLoadPlugin() {
		Functions\expect(__NAMESPACE__ . '\wpl_crawler_plugin_init')->once();
		do_action('plugins_loaded');
	}
}
