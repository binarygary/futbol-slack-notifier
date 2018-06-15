<?php

namespace BinaryGary\Futbol\Slack;

use BinaryGary\Futbol\Endpoints\OAuth;
use BinaryGary\Futbol\Settings\Defaults;

class Redirect_URI {

	public function success() {
		wp_redirect( get_permalink( get_option( Defaults::SUCCESS_PAGE ) ) );
	}

	public function failure() {
		wp_redirect( get_permalink( get_option( Defaults::FAILURE_PAGE ) ) );
	}

}
