<?php

namespace BinaryGary\Futbol\Post_Types;


class Feedback extends Post_Type {

	const NAME = 'futbol_feedback';

	public function post_type() {
		return self::NAME;
	}

	public function args() {
		return [
			'public' => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'labels'       => [
				'menu_name' => __( 'Futbol Feedback', 'tribe' ),
			],
		];
	}
}