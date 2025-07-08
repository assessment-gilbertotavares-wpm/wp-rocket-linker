<?php
namespace WP_Rocket_Linker\Database\Queries;

use BerlinDB\Database\Query;
use WP_Rocket_Linker\Database\Schemas\LinkRelationshipSchema;
use WP_Rocket_Linker\Database\Row\LinkRelationship;
use WP_Rocket_Linker\Database\Tables\LinkRelationshipTable;

/**
 * Query class for the link_relationships table
 */
class LinkRelationshipQuery extends Query {
	/**
	 * Name of the table
	 *
	 * @var string
	 */
	protected $table_name = 'wrl_link_relationships';

	/**
	 * String used to alias the database table
	 *
	 * @var string
	 */
	protected $table_alias = 'wrlr';

	/**
	 * Schema class used to define the table structure
	 *
	 * @var string
	 */
	protected $table_schema = LinkRelationshipSchema::class;

	/**
	 * Primary key of the database table
	 *
	 * @var string
	 */
	protected $primary_key = 'relationship_id';

	/**
	 * Row shape class for individual entry items
	 *
	 * @var string
	 */
	protected $item_shape = LinkRelationship::class;

	/**
	 * Fields that can be updated
	 *
	 * @var array
	 */
	protected $item_updates = array( 'entry_id', 'link_id' );

	/**
	 * Fields that can be used in WHERE clause
	 *
	 * @var array
	 */
	protected $item_filters = array( 'entry_id', 'link_id' );

	/**
	 * Constructor that ensures the link_relationships table is registered in the database instance
	 *
	 * @param array $query Optional. Query arguments to initialize the query.
	 */
	public function __construct( $query = array() ) {
		parent::__construct( $query );
		$table = null;
		if ( isset( $this->get_db()->{$this->table_name} ) ) {
			$table = $this->get_db()->{$this->table_name};
		}
		if ( is_null( $table ) ) {
			new LinkRelationshipTable();
		}
	}
}
