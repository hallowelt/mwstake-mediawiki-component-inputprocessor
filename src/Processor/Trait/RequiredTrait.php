<?php

namespace MWStake\MediaWiki\Component\InputProcessor\Processor\Trait;

use StatusValue;

trait RequiredTrait {

	/** @var bool */
	protected bool $required;

	/**
	 * @param bool $required
	 * @return static
	 */
	public function setRequired( bool $required ): static {
		$this->required = $required;
		return $this;
	}

	/**
	 * @param string|null $value
	 * @param string $fieldKey
	 * @return StatusValue
	 */
	protected function checkRequired( ?string $value, string $fieldKey ): StatusValue {
		if ( $value === null && $this->required ) {
			return StatusValue::newFatal( 'inputprocessor-error-value-required', $fieldKey );
		}
		return StatusValue::newGood();
	}
}