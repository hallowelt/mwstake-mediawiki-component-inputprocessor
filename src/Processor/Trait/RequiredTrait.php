<?php

namespace MWStake\MediaWiki\Component\InputProcessor\Processor\Trait;

use StatusValue;

trait RequiredTrait {

	/** @var bool */
	protected bool $required = false;

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
	protected function checkRequired( mixed $value, string $fieldKey ): StatusValue {
		if ( $this->required && ( $value === null || $value === '' ) ) {
			return StatusValue::newFatal( 'inputprocessor-error-value-required', $fieldKey );
		}
		return StatusValue::newGood();
	}
}
