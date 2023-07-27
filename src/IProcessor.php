<?php

namespace MWStake\MediaWiki\Component\InputProcessor;
use StatusValue;

interface IProcessor {

	/**
	 *
	 * @param string $value
	 * @param array $options
	 * @return StatusValue
	 */
	public function process( $value, $options = [] ) : StatusValue;
}