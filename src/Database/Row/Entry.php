<?php
namespace WP_Rocket_Linker\Database\Row;

use BerlinDB\Database\Row;
use WP_Rocket_Linker\Database\Queries\LinkRelationshipQuery;
use WP_Rocket_Linker\Database\Queries\LinkQuery;

/**
 * Row class for the links table
 */
class Entry extends Row {
	/**
	 * Link relationship constructor
	 *
	 * @param object $item Current row details.
	 */
	public function __construct( $item ) {
		parent::__construct( $item );
		$this->id          = (int) $this->id;
		$this->screen_size = (string) $this->screen_size;

		// Optional: Parse or format specific properties.
		if ( ! empty( $this->entry_date ) && '0000-00-00 00:00:00' !== $this->entry_date ) {
			$this->entry_date = mysql2date( 'U', $this->entry_date, false );
		}

		if ( ! empty( $this->entry_date_gmt ) && '0000-00-00 00:00:00' !== $this->entry_date_gmt ) {
			$this->entry_date_gmt = mysql2date( 'U', $this->entry_date_gmt, false );
		}
	}

	/**
	 * Retrieves the list of links associated with this entry
	 *
	 * @return array List of Link objects related to this entry.
	 */
	public function get_links() {
		$link_relationships_query = new LinkRelationshipQuery();
		$link_ids                 = wp_list_pluck(
			$link_relationships_query->query(
				array(
					'entry_id' => $this->id,
				)
			),
			'link_id'
		);
		$link_query               = new LinkQuery();
		return $link_query->query(
			array(
				'link_id' => $link_ids,
				'order'   => 'asc',
			)
		);
	}
}
