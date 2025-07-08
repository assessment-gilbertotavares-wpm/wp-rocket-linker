<?php
namespace WP_Rocket_Linker\Database\Schemas;

use BerlinDB\Database\Schema;

class LinkSchema extends Schema {
	/**
	 * Schema columns for the links table.
	 *
	 * @var array
	 */
	public $columns = array(
		'id'   => array(
			'name'     => 'link_id',
			'type'     => 'bigint',
			'length'   => 20,
			'unsigned' => true,
			'extra'    => 'auto_increment',
			'primary'  => true,
		),
		'url'  => array(
			'name'       => 'link_url',
			'type'       => 'varchar',
			'length'     => 255,
			'searchable' => true,
		),
		'name' => array(
			'name'       => 'link_name',
			'type'       => 'varchar',
			'length'     => 255,
			'searchable' => true,
		),
	);
}
