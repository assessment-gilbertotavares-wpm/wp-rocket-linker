<?php
namespace WP_Rocket_Linker\Admin;

use WP_List_Table;
use WP_Rocket_Linker\Database\Database;

class EntriesTable extends WP_List_Table {
	/**
	 * Items per page in the list table.
	 *
	 * @var int
	 */
	private $items_per_page;

	/**
	 * Total number of items.
	 *
	 * @var int
	 */
	private $total_items;

	/**
	 * Constructor for the EntriesTable class.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'singular' => 'log',
				'plural'   => 'logs',
				'ajax'     => false,
			)
		);
		$this->items_per_page = $this->get_items_per_page( 'wrl_entries_per_page', 20 );
	}

	/**
	 * Returns the columns to display in the list table.
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'visible_links' => __( 'Visible Links', 'wp-rocket-linker' ),
			'screen_size'   => __( 'Screen Size', 'wp-rocket-linker' ),
			'entry_date'    => __( 'Date' ), // phpcs:ignore WordPress.WP.I18n.MissingArgDomain
		);
	}

	/**
	 * Prepares the items for display in the list table.
	 *
	 * @return void
	 */
	public function prepare_items() {
		$database = new Database();
		$query    = $database->get_query();

		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		$paged  = max( 1, isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1 );
		$offset = ( $paged - 1 ) * $this->items_per_page;

		$orderby = 'entry_date';
		if ( isset( $_GET['orderby'] ) ) {
			$orderby = sanitize_text_field( wp_unslash( $_GET['orderby'] ) );
		}

		$order = 'DESC';
		if ( isset( $_GET['order'] ) ) {
			$order_param = strtoupper( sanitize_text_field( wp_unslash( $_GET['order'] ) ) );
			if ( in_array( $order_param, array( 'ASC', 'DESC' ), true ) ) {
				$order = $order_param;
			}
		}
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		$this->items = $query->query(
			array(
				'orderby' => $orderby,
				'order'   => $order,
				'number'  => $this->items_per_page,
				'offset'  => $offset,
			)
		);

		$this->total_items = $query->query( array( 'count' => true ) );

		$this->set_pagination_args(
			array(
				'total_items' => $this->total_items,
				'per_page'    => $this->items_per_page,
				'total_pages' => ceil( $this->total_items / $this->items_per_page ),
			)
		);

		$this->_column_headers = array(
			$this->get_columns(),
			array(), // Hidden columns.
			$this->get_sortable_columns(),
		);
	}

	/**
	 * Renders the entry_date column.
	 *
	 * @param object $item The current item.
	 * @return string
	 */
	public function column_entry_date( $item ) {
		return sprintf(
			/* translators: 1: Post date, 2: Post time. */
			__( '%1$s at %2$s' ),
			wp_date( __( 'Y/m/d' ), $item->entry_date_gmt ),
			wp_date( __( 'g:i a' ), $item->entry_date_gmt )
		);
	}

	/**
	 * Renders the visible_links column.
	 *
	 * @param object $item The current item.
	 * @return string
	 */
	public function column_visible_links( $item ) {
		$links = $item->get_links();

		if ( empty( $links ) ) {
			return '<em>' . esc_html__( 'No links recorded.', 'wp-rocket-linker' ) . '</em>';
		}

		$links_output = array();

		foreach ( $links as $link ) {
			$id = $link->id ?? null;
			if ( ! $id ) {
				continue;
			}

			if ( $link ) {
				$links_output[] = sprintf(
					'<a href="%s" target="_blank" rel="noopener noreferrer">%s</a>',
					esc_url( $link->url ),
					esc_html( ! empty( $link->name ) ? $link->name : $link->url )
				);
			}
		}

		return implode( ' | ', $links_output );
	}

	/**
	 * Fallback renderer for undefined columns.
	 *
	 * @param object $item        The current item.
	 * @param string $column_name Name of the column.
	 * @return string
	 */
	public function column_default( $item, $column_name ) {
		return esc_html( $item->$column_name ?? '' );
	}

	/**
	 * Returns an array of sortable columns.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		return array(
			'entry_date' => array( 'entry_date', false ), // false = default order is ASC.
		);
	}
}
