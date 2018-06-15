<?php

namespace BinaryGary\Futbol\Futbol;


class Match {

	const STATUS = [
		'IN_PLAY'  => 'Start',
		'FINISHED' => 'Complete',
	];

	protected $home_team;
	protected $home_team_score;
	protected $away_team;
	protected $away_team_score;
	protected $match_status;
	protected $game_number;
	protected $event;

	protected function required_fields() {
		return [
			'event',
			'home_team',
			'home_team_score',
			'away_team',
			'away_team_score',
			'match_status',
		];
	}

	public function set( $field, $value ) {
		$this->$field = $value;

		return $this;
	}

	public function build_message() {
		if ( ! $this->required_fields_set() ) {
			throw new \Exception( 'Required params were not met' );
		}

		$message['attachments'][0] = [
			'title'  => $this->title_generator(),
			'fields' => [
				[
					'title' => sprintf( '%s %s %s', Flags::FLAGS[ $this->home_team ], (int) $this->home_team_score, $this->home_team ),
					'short' => false,
				],
				[
					'title' => sprintf( '%s %s %s', Flags::FLAGS[ $this->away_team ], (int) $this->away_team_score, $this->away_team ),
					'short' => false,
				],
			],
		];

		return $message;
	}

	private function title_generator() {
		if ( 'score_change' == $this->event ) {
			$o           = $this->random_character( 'oO0', isset( $this->game_number ) ? (int) $this->game_number/2 : 7 );
			$a           = $this->random_character( 'aA' );
			$l           = $this->random_character( 'lL1' );
			$exclamation = $this->random_character( '!' );

			return 'G' . $o . $a . $l . $exclamation;
		}

		return 'Match ' . self::STATUS[ $this->match_status ];
	}

	public function random_character( $character, $max = 3 ) {
		$random = '';
		$count  = rand( 1, $max );
		for ( $i = 0; $i < $count; $i ++ ) {
			$random .= $character[ rand( 0, strlen( $character ) - 1 ) ];
		}

		return $random;
	}

	private function required_fields_set() {
		foreach ( $this->required_fields() as $field ) {
			if ( ! isset( $this->$field ) ) {
				return false;
			}
		}

		return true;
	}

}