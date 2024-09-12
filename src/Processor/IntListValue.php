<?php

namespace MWStake\MediaWiki\Component\InputProcessor\Processor;

use MWStake\MediaWiki\Component\InputProcessor\Processor\Trait\ListSplitterTrait;
use StatusValue;

class IntListValue extends IntValue {
	use ListSplitterTrait;

	/**
	 * @inheritDoc
	 */
	public function initializeFromSpec( array $spec ): static {
		parent::initializeFromSpec( $spec );

		$this->setListSeparator( $spec['separator'] ?? null );
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function process( ?string $value, string $fieldKey ): StatusValue {
		$required = $this->checkRequired( $value, $fieldKey );
		if ( !$required->isGood() ) {
			return $required;
		}
		$values = $this->splitList( $value );
		$status = StatusValue::newGood();
		$processed = [];
		foreach ( $values as $value ) {
			$parentStatus = parent::process( $value, $fieldKey );
			if ( !$parentStatus->isGood() ) {
				$status->setOK( false );
				$status->merge( $parentStatus );
				continue;
			}
			$processed[] = $parentStatus->getValue();
		}
		if ( $status->isGood() ) {
			$status->setResult( true, $processed );
		}
		return $status;
	}
}
