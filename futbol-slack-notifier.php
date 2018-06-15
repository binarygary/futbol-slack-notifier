<?php
/*
Plugin Name: GOOOOOOOAAAALLLL! Slack Notifier
Description: Send futbol goals to slack.
Author:      Gary Kovar
Version:     1.0
Author URI:  https://www.binarygary.com/
*/

require_once trailingslashit( __DIR__ ) . 'vendor/autoload.php';

// Start the core plugin
add_action( 'plugins_loaded', function () {
	launch()->init();
}, 1, 0 );

function launch() {
	return \BinaryGary\Futbol\Core::instance( new Pimple\Container( [ 'plugin_file' => __FILE__ ] ) );
}
