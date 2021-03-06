<?php

namespace BinaryGary\Futbol\Service_Providers;


use BinaryGary\Futbol\Endpoints\Count;
use BinaryGary\Futbol\Endpoints\Events;
use BinaryGary\Futbol\Endpoints\OAuth;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Endpoints_Provider implements ServiceProviderInterface {

	const ENDPOINTS_OAUTH = 'endpoints.oauth';

	const ENDPOINT_EVENTS_COLLECTION = 'endpoints.events.collection';
	const ENDPOINTS_EVENTS           = 'endpoints.events';
	const ENDPOINTS_EVENTS_HELP      = 'endpoints.events.help';
	const ENDPOINTS_EVENTS_ABOUT     = 'endpoints.events.about';
	const ENDPOINTS_EVENTS_FEEDBACK  = 'endpoints.events.feedback';

	const TEAM_COUNT = 'endpoints.count.team';

	const ACTIVE_PROVIDERS = 'launch_library.active_provider';
	const ACTIVE_PADS      = 'launch_library.active_pads';

	public function register( Container $container ) {
		$container[ self::ENDPOINTS_OAUTH ] = function () use ( $container ) {
			return new OAuth( $container[ Slack_Provider::POST_MESSAGE ], $container[ Slack_Provider::REDIRECT_URI ] );
		};

		$container[ self::ENDPOINT_EVENTS_COLLECTION ] = function () use ( $container ) {
			return new Events\Launch_Collection();
		};

		$container[ self::ENDPOINTS_EVENTS_HELP ] = function () use ( $container ) {
			return new Events\Help();
		};

		$container[ self::ENDPOINTS_EVENTS_ABOUT ] = function () use ( $container ) {
			return new Events\About();
		};

		$container[ self::ENDPOINTS_EVENTS_FEEDBACK ] = function () use ( $container ) {
			return new Events\Feedback();
		};

		$container[ self::ENDPOINTS_EVENTS ] = function () use ( $container ) {
			return new Events( $container[ Slack_Provider::POST_MESSAGE ], $container[ self::ENDPOINT_EVENTS_COLLECTION ], $container[ self::ENDPOINTS_EVENTS_HELP ] );
		};

		$container[ self::TEAM_COUNT ] = function() use ( $container ) {
			return new Count( $container[ Slack_Provider::POST_MESSAGE ] );
		};

		add_action( 'rest_api_init', function () use ( $container ) {
			$container[ self::ENDPOINTS_EVENTS ]->add_keyword( $container[ self::ENDPOINTS_EVENTS_ABOUT ]->get_keyword(), $container[ self::ENDPOINTS_EVENTS_ABOUT ] );
			$container[ self::ENDPOINTS_EVENTS ]->add_keyword( $container[ self::ENDPOINTS_EVENTS_FEEDBACK ]->get_keyword(), $container[ self::ENDPOINTS_EVENTS_FEEDBACK ] );
			$container[ self::ENDPOINTS_OAUTH ]->register();
			$container[ self::ENDPOINTS_EVENTS ]->register();
			$container[ self::TEAM_COUNT ]->register();
		} );

	}

}
