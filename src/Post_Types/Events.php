<?php

namespace BinaryGary\Futbol\Post_Types;


class Events extends Post_Type {

	const NAME = 'futbol_event';

	public function post_type() {
		return self::NAME;
	}

	public function args() {
		return [
			'public' => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'labels'       => [
				'menu_name' => __( 'Futbol Event', 'tribe' ),
			],
		];
	}

}