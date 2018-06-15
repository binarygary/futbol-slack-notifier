<?php

namespace BinaryGary\Futbol\Post_Types;


class Slack_URL extends Post_Type {

	const POST_TYPE = 'futbol_url';

	public function post_type() {
		return self::POST_TYPE;
	}

	public function args() {
		return [
			'public' => false,
		];
	}

}
