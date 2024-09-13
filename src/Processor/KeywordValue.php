<?php

namespace MWStake\MediaWiki\Component\InputProcessor\Processor;

use MWStake\MediaWiki\Component\InputProcessor\GenericProcessor;
use StatusValue;

class KeywordValue extends GenericProcessor {

	/** @var array */
	protected array $keywords = [];

	/**
	 * @param array $spec
	 * @return $this
	 */
	public function initializeFromSpec( array $spec ): static {
		parent::initializeFromSpec( $spec );
		$this->setKeywords( $spec['keywords'] ?? [] );
		return $this;
	}

	/**
	 * @param array $keywords
	 * @return $this
	 */
	public function setKeywords( array $keywords ): static {
		$this->keywords = [];
		foreach ( $keywords as $keyword ) {
			$this->keywords[mb_strtolower( $keyword )] = $keyword;
		}
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
		if ( !array_key_exists( mb_strtolower( $value ), $this->keywords ) ) {
			return StatusValue::newFatal( 'inputprocessor-error-keyword-not-keyword', $fieldKey, $value );
		}

		return StatusValue::newGood( $this->keywords[mb_strtolower( $value )] );
	}
}
