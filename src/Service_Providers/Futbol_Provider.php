<?php

namespace BinaryGary\Futbol\Service_Providers;


use BinaryGary\Futbol\Futbol\Retriever;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Futbol_Provider implements ServiceProviderInterface {

	const RETRIEVER = 'futbol.retriever';

	public function register( Container $container ) {
		$container[ self::RETRIEVER ] = function () use ( $container ) {
			return new Retriever( $container[ Slack_Provider::WEBHOOKS ] );
		};

		add_action( 'init', function() {
			if ( ! wp_next_scheduled( 'futbol_cron' ) ) {
				wp_schedule_event( time(), 'minutely', 'futbol_cron' );
			}
		} );

		add_filter( 'cron_schedules', function ( $schedules ) use ( $container ) {
			return $container[ self::RETRIEVER ]->add_interval( $schedules );
		} );

		add_action( 'futbol_cron', function () use ( $container ) {
			$container[ self::RETRIEVER ]->get_updates();
		} );
	}

}
