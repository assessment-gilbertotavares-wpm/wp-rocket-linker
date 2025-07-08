<?php
namespace WP_Rocket_Linker\Database\Queries;

use BerlinDB\Database\Query;
use WP_Rocket_Linker\Database\Schemas\EntrySchema;
use WP_Rocket_Linker\Database\Row\Entry;

/**
 * Query class for the entries table
 */
class EntryQuery extends Query {
	/**
	 * Name of the table
	 *
	 * @var string
	 */
	protected $table_name = 'wrl_entries';

	/**
	 * String used to alias the database table
	 *
	 * @var string
	 */
	protected $table_alias = 'wrle';

	/**
	 * Schema class used to define the table structure
	 *
	 * @var string
	 */
	protected $table_schema = EntrySchema::class;

	/**
	 * Primary key of the database table
	 *
	 * @var string
	 */
	protected $primary_key = 'id';

	/**
	 * Row shape class for individual entry items
	 *
	 * @var string
	 */
	protected $item_shape = Entry::class;

	/**
	 * Fields that can be updated
	 *
	 * @var array
	 */
	protected $item_updates = array(
		'screen_size',
		'entry_date',
	);

	/**
	 * Fields that can be used in WHERE clause
	 *
	 * @var array
	 */
	protected $item_filters = array(
		'id',
		'entry_date',
	);

	/**
	 * Adds a new entry and its associated visible links
	 *
	 * @param array $data Entry data, including 'visible_links'.
	 * @return int|false Entry ID on success, false on failure.
	 */
	public function add_item( $data = array() ) {
		$link_relationships_query = new LinkRelationshipQuery();
		$visible_links            = array();
		if ( isset( $data['visible_links'] ) ) {
			$visible_links = $data['visible_links'];
			unset( $data['visible_links'] );
		}
		$entry_id    = parent::add_item( $data );
		$links_query = new LinkQuery();
		foreach ( $visible_links as $link ) {
			$link_items = $links_query->query(
				array(
					'link_url'  => $link['url'],
					'link_name' => $link['name'],
				)
			);
			$link_id    = ! empty( $link_items ) ? $link_items[0]->id : null;
			if ( ! $link_id ) {
				$link_id = $links_query->add_item(
					array(
						'link_url'  => esc_url_raw( $link['url'] ),
						'link_name' => sanitize_text_field( $link['name'] ),
					)
				);
			}
			if ( $link_id ) {
				$link_relationships_query->add_item(
					array(
						'entry_id' => $entry_id,
						'link_id'  => $link_id,
					)
				);
			}
		}
		return $entry_id;
	}
}
