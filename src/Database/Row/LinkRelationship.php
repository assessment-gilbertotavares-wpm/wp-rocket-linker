<?php
namespace WP_Rocket_Linker\Database\Row;

use BerlinDB\Database\Row;

/**
 * Row class for the link_relationships table
 */
class LinkRelationship extends Row {
	/**
	 * Link relationship constructor
	 *
	 * @param object $item Current row details.
	 */
	public function __construct( $item ) {
		parent::__construct( $item );

		$this->relationship_id = (int) $this->relationship_id;
		$this->entry_id        = (int) $this->entry_id;
		$this->link_id         = (int) $this->link_id;
	}
}
