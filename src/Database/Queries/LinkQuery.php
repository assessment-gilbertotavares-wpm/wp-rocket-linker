<?php
namespace WP_Rocket_Linker\Database\Queries;

use BerlinDB\Database\Query;
use WP_Rocket_Linker\Database\Schemas\LinkSchema;
use WP_Rocket_Linker\Database\Row\Link;
use WP_Rocket_Linker\Database\Tables\LinkTable;

/**
 * Query class for the links table
 */
class LinkQuery extends Query {
	/**
	 * Name of the table.
	 *
	 * @var string
	 */
	protected $table_name = 'wrl_links';

	/**
	 * String used to alias the database table
	 *
	 * @var string
	 */
	protected $table_alias = 'wrl';

	/**
	 * Schema class used to define the table structure
	 *
	 * @var string
	 */
	protected $table_schema = LinkSchema::class;

	/**
	 * Primary key of the database table
	 *
	 * @var string
	 */
	protected $primary_key = 'link_id';

	/**
	 * Row shape class for individual entry items
	 *
	 * @var string
	 */
	protected $item_shape = Link::class;

	/**
	 * Fields that can be updated
	 *
	 * @var array
	 */
	protected $item_updates = array( 'link_url', 'link_name' );

	/**
	 * Fields that can be used in WHERE clause
	 *
	 * @var array
	 */
	protected $item_filters = array( 'link_id', 'link_url', 'link_name' );

	/**
	 * Constructor that ensures the links table is registered in the database instance.
	 *
	 * @param array $query Optional. Query arguments.
	 */
	public function __construct( $query = array() ) {
		parent::__construct( $query );
		$table = null;
		if ( isset( $this->get_db()->{$this->table_name} ) ) {
			$table = $this->get_db()->{$this->table_name};
		}
		if ( is_null( $table ) ) {
			new LinkTable();
		}
	}
}
