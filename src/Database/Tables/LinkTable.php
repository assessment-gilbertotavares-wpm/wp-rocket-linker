<?php
namespace WP_Rocket_Linker\Database\Tables;

use BerlinDB\Database\Table;

/**
 * Custom table for storing links
 */
class LinkTable extends Table {
	/**
	 * Table name
	 *
	 * @var string
	 */
	protected $name = 'wrl_links';

	/**
	 * Database version
	 *
	 * @var int
	 */
	protected $version = 1;

	/**
	 * Setup the database schema
	 *
	 * @return void
	 */
	protected function set_schema() {
		$this->schema = '
			link_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			link_url varchar(255) NOT NULL,
			link_name varchar(255) NOT NULL,
			PRIMARY KEY (link_id),
			KEY link_url (link_url)
		';
	}
}
