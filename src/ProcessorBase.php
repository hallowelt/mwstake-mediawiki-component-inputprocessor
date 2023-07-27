<?php

namespace MWStake\MediaWiki\Component\InputProcessor;
use Status;
use StatusValue;

abstract class ProcessorBase implements IProcessor {

	/** @var Status */
	protected $status = null;

	/**
	 *
	 */
	public function __construct() {
		$this->status = Status::newFatal( 'Not implemented' );
	}

	/**
	 * @inheritDoc
	 */
	public function process( $value, $options = [] ) : StatusValue {
		$this->doProcess( $value );
		return $this->status;
	}

	/**
	 * @param string $value
	 * @return void
	 */
	abstract protected function doProcess( $value );
}