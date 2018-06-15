<?php

namespace BinaryGary\Futbol\Service_Providers;


use BinaryGary\Futbol\Slack\Post_Message;
use BinaryGary\Futbol\Slack\Redirect_URI;
use BinaryGary\Futbol\Slack\Webhooks;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Slack_Provider implements ServiceProviderInterface {

	const REDIRECT_URI = 'slack.redirect_uri';
	const POST_MESSAGE = 'slack.post_message';
	const WEBHOOKS     = 'slack.webhooks';

	public function register( Container $container ) {
		$container[ self::REDIRECT_URI ] = function () {
			return new Redirect_URI();
		};

		$container[ self::POST_MESSAGE ] = function () {
			return new Post_Message();
		};

		$container[ self::WEBHOOKS ] = function () use ( $container ) {
			return new Webhooks( $container[ self::POST_MESSAGE ] );
		};
	}

}
