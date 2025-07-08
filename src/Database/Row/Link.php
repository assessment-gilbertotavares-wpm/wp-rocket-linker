<?php
namespace WP_Rocket_Linker\Database\Row;

use BerlinDB\Database\Row;

/**
 * Row class for the links table
 */
class Link extends Row {
	/**
	 * Link relationship constructor
	 *
	 * @param object $item Current row details.
	 */
	public function __construct( $item ) {
		parent::__construct( $item );

		$this->id   = (int) $this->link_id;
		$this->url  = (string) $this->link_url;
		$this->name = (string) $this->link_name;
		unset( $this->link_id, $this->link_url, $this->link_name );
	}
}
