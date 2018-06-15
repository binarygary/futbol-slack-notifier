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
		];
	}
}