<?php

namespace BinaryGary\Futbol\Futbol;

use BinaryGary\Futbol\Settings\Defaults;
use BinaryGary\Futbol\Slack\Post_Message;
use BinaryGary\Futbol\Slack\Webhooks;

class Retriever {

	const ENDPOINT = 'http://api.football-data.org/v1/competitions/467/fixtures';

	const ENDPOINT_RESULTS = 'futbol-slack-call-results';

	/**
	 * @var Post_Message
	 */
	protected $messages;

	protected $timestamp;

	public function __construct( Webhooks $webhooks ) {
		$this->messages  = $webhooks;
		$this->timestamp = time();
	}

	public function get_updates() {
		$result        = wp_remote_get( self::ENDPOINT, [
			'headers' => [
				'X-Auth-Token' => get_option( Defaults::FOOTY_KEY ),
			],
		] );

		if ( is_wp_error( $result ) ) {
			return;
		}

		$games         = json_decode( $result['body'], true )['fixtures'];
		$current_games = get_option( self::ENDPOINT_RESULTS, [] );
		update_option( self::ENDPOINT_RESULTS, $games );

		$this->send_updates( $games, $current_games );
	}

	private function send_updates( $games, $current_games ) {
		$game_number = 0;
		foreach ( $games as $game ) {
			if ( $game['status'] != $current_games[ $game_number ]['status'] ) {
				if ( array_key_exists( $game['status'], Match::STATUS ) ) {
					$this->messages->alert( $this->build_game_status_alert( $game ) );
				}
			}

			if ( $game['result']['goalsHomeTeam'] != $current_games[ $game_number ]['result']['goalsHomeTeam'] ||
			     $game['result']['goalsAwayTeam'] != $current_games[ $game_number ]['result']['goalsAwayTeam']
			) {
				$this->messages->alert( $this->build_GOAL_alert( $game ) );
			}

			$game_number ++;
		}
	}

	private function build_game_status_alert( $game ) {
		$match = new Match();
		$match->set( 'home_team', $game['homeTeamName'] )
		      ->set( 'away_team', $game['awayTeamName'] )
		      ->set( 'home_team_score', (int) $game['result']['goalsHomeTeam'] )
		      ->set( 'away_team_score', (int) $game['result']['goalsAwayTeam'] )
		      ->set( 'match_status', $game['status'] )
		      ->set( 'event', 'status_change' );

		return $match->build_message();
	}

	private function build_GOAL_alert( $game ) {

		$match = new Match();
		$match->set( 'home_team', $game['homeTeamName'] )
		      ->set( 'away_team', $game['awayTeamName'] )
		      ->set( 'home_team_score', $game['result']['goalsHomeTeam'] )
		      ->set( 'away_team_score', $game['result']['goalsAwayTeam'] )
		      ->set( 'match_status', $game['status'] )
		      ->set( 'event', 'score_change' );

		return $match->build_message();
	}

	public function add_interval( $schedules ) {
		$schedules['minutely'] = array(
			'interval' => 60,
			'display'  => __( 'Once a minute' ),
		);

		return $schedules;
	}
}
