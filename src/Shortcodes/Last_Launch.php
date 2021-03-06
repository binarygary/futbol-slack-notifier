<?php

namespace BinaryGary\Futbol\Shortcodes;


use BinaryGary\Futbol\Launch_Library\Retriever;

class Last_Launch {

	public function generate() {
		add_shortcode( 'last_launch', [ $this, 'last_launch' ] );
	}

	public function last_launch() {
		$launch = get_option( Retriever::LAST_NOTIFICATION_SENT );
		return $launch['attachments']['0']['title'];
	}

}