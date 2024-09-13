<?php

namespace MWStake\MediaWiki\Component\InputProcessor\Processor;

use MWStake\MediaWiki\Component\InputProcessor\GenericProcessor;
use StatusValue;

class IntValue extends GenericProcessor {

	/** @var int|null */
	protected ?int $min = null;

	/** @var int|null */
	protected ?int $max = null;

	/**
	 * @inheritDoc
	 */
	public function initializeFromSpec( array $spec ): static {
		parent::initializeFromSpec( $spec );
		$this->setMin( $spec['min'] ?? null );
		$this->setMax( $spec['max'] ?? null );
		return $this;
	}

	/**
	 * @param int|null $min
	 * @return static
	 */
	public function setMin( ?int $min ): static {
		$this->min = $min;
		return $this;
	}

	/**
	 * @param int|null $max
	 * @return static
	 */
	public function setMax( ?int $max ): static {
		$this->max = $max;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function process( mixed $value, string $fieldKey ): StatusValue {
		$parentStatus = parent::process( $value, $fieldKey );
		if ( !$parentStatus->isGood() ) {
			return $parentStatus;
		}
		$number = $this->getNumeric( $value );
		if ( !$number ) {
			return StatusValue::newFatal( 'inputprocessor-error-int-not-number', $fieldKey, $value );
		}

		if ( !$this->fitsInRange( $number ) ) {
			return StatusValue::newFatal( 'inputprocessor-error-int-out-of-range', $fieldKey, $number );
		}

		return StatusValue::newGood( $number );
	}

	/**
	 * @param int $value
	 * @return bool
	 */
	protected function fitsInRange( int $value ): bool {
		return ( $this->min === null || $value >= $this->min ) && ( $this->max === null || $value <= $this->max );
	}

	/**
	 * @param string $value
	 * @return int|null
	 */
	protected function getNumeric( string $value ): ?int {
		return is_numeric( $value ) ? (int)$value : null;
	}
}
