<?php
namespace WP_Rocket_Linker\Admin;

class EntriesPage {
	/**
	 * Registers the admin menu page and attaches the screen options hook.
	 *
	 * @return void
	 */
	public static function register_menu() {
		$hook = add_menu_page(
			__( 'WP Rocket Linker Entries', 'wp-rocket-linker' ),
			__( 'Linker Entries', 'wp-rocket-linker' ),
			'manage_options',
			'wp-rocket-linker',
			array( self::class, 'render' ),
			'dashicons-admin-links',
			30
		);
		add_action( "load-$hook", array( self::class, 'screen_options' ) );
	}

	/**
	 * Renders the admin table page displaying entries.
	 *
	 * @return void
	 */
	public static function render() {
		if ( ! class_exists( 'WP_List_Table' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
		}
		$table = new EntriesTable();
		echo '<div class="wrap">';
		printf( '<h1>%s</h1>', esc_html__( 'WP Rocket Linker Entries', 'wp-rocket-linker' ) );
		$table->prepare_items();
		$table->display();
		echo '</div>';
	}

	/**
	 * Sets up screen options and help tabs for the entries admin page.
	 *
	 * @return void
	 */
	public static function screen_options() {
		add_screen_option(
			'per_page',
			array(
				'label'   => __( 'Number of items per page:' ), // phpcs:ignore WordPress.WP.I18n.MissingArgDomain
				'default' => 20,
				'option'  => 'wrl_entries_per_page',
			)
		);
		$screen = get_current_screen();
		if ( $screen ) {
			$screen->add_help_tab(
				array(
					'id'      => 'wrl_entries_help',
					'title'   => __( 'Usage', 'wp-rocket-linker' ),
					'content' => '<p>' . __( 'This table shows which links were visible above the fold on your homepage, along with the screen size and timestamp.', 'wp-rocket-linker' ) . '</p>',
				)
			);
		}
	}
}
