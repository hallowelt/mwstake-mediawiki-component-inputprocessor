<?php

namespace MWStake\MediaWiki\Component\InputProcessor;

use StatusValue;

interface IProcessor {

	/**
	 *
	 * @param mixed $value
	 * @param string $fieldKey
	 * @return StatusValue
	 */
	public function process( mixed $value, string $fieldKey ): StatusValue;

	/**
	 * Set required attributes based on the array-data provided
	 *
	 * @param array $spec
	 * @return $this
	 */
	public function initializeFromSpec( array $spec ): static;
}
