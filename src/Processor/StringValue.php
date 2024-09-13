<?php

namespace MWStake\MediaWiki\Component\InputProcessor\Processor;

use MWStake\MediaWiki\Component\InputProcessor\GenericProcessor;
use StatusValue;

class StringValue extends GenericProcessor {

	/**
	 * @inheritDoc
	 */
	public function process( mixed $value, string $fieldKey ): StatusValue {
		$parentStatus = parent::process( $value, $fieldKey );
		if ( !$parentStatus->isGood() ) {
			return $parentStatus;
		}
		if ( !is_string( $value ) ) {
			return StatusValue::newFatal( 'inputprocessor-error-string-not-string', $fieldKey, $value );
		}

		return StatusValue::newGood( $value );
	}
}
