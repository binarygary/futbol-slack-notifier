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
		];
	}

}