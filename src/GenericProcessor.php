<?php

namespace MWStake\MediaWiki\Component\InputProcessor;

use MWStake\MediaWiki\Component\InputProcessor\Processor\Trait\RequiredTrait;
use StatusValue;

class GenericProcessor implements IProcessor {
	use RequiredTrait;

	/**
	 * @inheritDoc
	 */
	public function process( ?string $value, string $fieldKey ): StatusValue {
		$required = $this->checkRequired( $value, $fieldKey );
		if ( !$required->isGood() ) {
			return $required;
		}
		return StatusValue::newGood( $value );
	}

	/**
	 * @inheritDoc
	 */
	public function initializeFromSpec( array $spec ): static {
		$this->setRequired( $spec['required'] ?? false );
		return $this;
	}
}
