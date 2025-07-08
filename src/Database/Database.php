<?php
namespace WP_Rocket_Linker\Database;

use WP_Rocket_Linker\Database\Tables\EntryTable;
use WP_Rocket_Linker\Database\Queries\EntryQuery;

/**
 * Database Manager
 */
class Database {
	/**
	 * Table instance
	 *
	 * @var CacheTable
	 */
	private $table;

	/**
	 * Query instance
	 *
	 * @var CacheQuery
	 */
	private $query;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->table = new EntryTable();
		$this->query = new EntryQuery();
	}

	/**
	 * Get the query instance
	 *
	 * @return CacheQuery
	 */
	public function get_query() {
		return $this->query;
	}

	/**
	 * Get the table instance
	 *
	 * @return CacheTable
	 */
	public function get_table() {
		return $this->table;
	}
}
