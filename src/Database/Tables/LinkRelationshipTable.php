<?php
namespace WP_Rocket_Linker\Database\Tables;

use BerlinDB\Database\Table;

/**
 * Custom table for storing link_relationships
 */
class LinkRelationshipTable extends Table {
	/**
	 * Table name
	 *
	 * @var string
	 */
	protected $name = 'wrl_link_relationships';

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
			relationship_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			entry_id bigint(20) unsigned NOT NULL default 0,
			link_id bigint(20) unsigned NOT NULL default 0,
			PRIMARY KEY (relationship_id),
			KEY entry_id (entry_id),
			KEY link_id (link_id)
		';
	}
}
