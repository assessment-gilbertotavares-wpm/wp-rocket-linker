<?php
namespace WP_Rocket_Linker\Database\Schemas;

use BerlinDB\Database\Schema;

class LinkRelationshipSchema extends Schema {
	/**
	 * Schema columns for the link_relationships table.
	 *
	 * @var array
	 */
	public $columns = array(
		'relationship_id' => array(
			'name'     => 'relationship_id',
			'type'     => 'bigint',
			'length'   => 20,
			'unsigned' => true,
			'extra'    => 'auto_increment',
			'primary'  => true,
		),
		'entry_id'        => array(
			'name'       => 'entry_id',
			'type'       => 'bigint',
			'length'     => 20,
			'default'    => 0,
			'unsigned'   => true,
			'searchable' => true,
			'sortable'   => true,
		),
		'link_id'         => array(
			'name'       => 'link_id',
			'type'       => 'bigint',
			'length'     => 20,
			'default'    => 0,
			'unsigned'   => true,
			'searchable' => true,
			'sortable'   => true,
		),
	);
}
