<?php

namespace BinaryGary\Futbol\Slack;


use BinaryGary\Futbol\Post_Types\Slack_URL;

class Webhooks {

	/**
	 * @var Post_Message
	 */
	protected $post_message;

	public function __construct( Post_Message $post_message ) {
		$this->post_message = $post_message;
	}

	public function alert( $message ) {
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			echo print_r( $message );
		}

		$hooks = new \WP_Query( [
			'post_type'      => Slack_URL::POST_TYPE,
			'posts_per_page' => - 1,
			'post_statue'    => 'publish',
		] );

		foreach ( $hooks->posts as $post ) {
			$this->post_message->incoming_webhook( $post->post_content, $message );
		}

	}

}
