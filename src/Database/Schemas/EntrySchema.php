<?php
namespace WP_Rocket_Linker\Database\Schemas;

use BerlinDB\Database\Schema;

class EntrySchema extends Schema {
	/**
	 * Schema columns for the entries table.
	 *
	 * @var array
	 */
	public $columns = array(
		'id'             => array(
			'name'     => 'id',
			'type'     => 'bigint',
			'length'   => '20',
			'unsigned' => true,
			'extra'    => 'auto_increment',
			'primary'  => true,
		),
		'screen_size'    => array(
			'name'       => 'screen_size',
			'type'       => 'text',
			'unsigned'   => true,
			'searchable' => true,
			'sortable'   => true,
		),
		'entry_date'     => array(
			'name'       => 'entry_date',
			'type'       => 'datetime',
			'date_query' => true,
			'unsigned'   => true,
			'searchable' => true,
			'sortable'   => true,
		),
		'entry_date_gmt' => array(
			'name'       => 'entry_date_gmt',
			'type'       => 'datetime',
			'unsigned'   => true,
			'searchable' => true,
			'sortable'   => true,
		),
	);
}
