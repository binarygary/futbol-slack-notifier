<?php

namespace BinaryGary\Futbol\Endpoints\Events;


abstract class Command {

	abstract public function get_keyword();

	abstract public function process( $command ): array;

}