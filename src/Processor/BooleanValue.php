<?php

namespace MWStake\MediaWiki\Component\InputProcessor\Processor;

use MWStake\MediaWiki\Component\InputProcessor\GenericProcessor;
use StatusValue;

class BooleanValue extends GenericProcessor {

	/**
	 * @inheritDoc
	 */
	public function process( mixed $value, string $fieldKey ): StatusValue {
		$parentStatus = parent::process( $value, $fieldKey );
		if ( !$parentStatus->isGood() ) {
			return $parentStatus;
		}
		if ( is_bool( $value ) ) {
			return StatusValue::newGood( $value );
		}
		$trueValues = [ 'true', '1', 'yes', 'on', 1, true, 'y' ];
		$falseValues = [ 'false', '0', 'no', 'off', 0, false, 'n' ];
		if ( in_array( strtolower( $value ), $trueValues, true ) ) {
			return StatusValue::newGood( true );
		}
		if ( in_array( strtolower( $value ), $falseValues, true ) ) {
			return StatusValue::newGood( false );
		}

		return StatusValue::newFatal( 'inputprocessor-error-boolean-not-boolean', $fieldKey, $value );
	}
}
