<?php
namespace WP_Rocket_Linker\Database\Tables;

use BerlinDB\Database\Table;
use WP_Rocket_Linker\Database\Tables\LinkTable;
use WP_Rocket_Linker\Database\Tables\LinkRelationshipTable;

/**
 * Custom table for storing entries
 */
class EntryTable extends Table {
	/**
	 * Table name
	 *
	 * @var string
	 */
	protected $name = 'wrl_entries';

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
		$this->schema = "
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			screen_size text NOT NULL DEFAULT '',
			entry_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			entry_date_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			PRIMARY KEY (id),
			KEY entry_date (entry_date)
		";
	}

	/**
	 * Installs the main entry table and its related tables
	 *
	 * @return void
	 */
	public function install() {
		parent::install();
		$additional = array(
			new LinkTable(),
			new LinkRelationshipTable(),
		);
		foreach ( $additional as $table ) {
			if ( ! $table->exists() ) {
				$table->install();
			}
		}
	}
}
