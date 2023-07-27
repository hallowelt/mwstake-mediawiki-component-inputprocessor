<?php

namespace MWStake\MediaWiki\Component\InputProcessor;

use Psr\Log\LoggerInterface;

class Runner {

	/** @var ProcessorFactory */
	private $processorFactory = null;

	/** @var LoggerInterface */
	private $logger = null;

	/** @var array */
	private $errors = [];

	/** @var array */
	private $processedData = [];

	/**
	 * @param ProcessorFactory $processorFactory
	 * @param LoggerInterface $logger
	 */
	public function __construct( $processorFactory, $logger ) {
		$this->processorFactory = $processorFactory;
		$this->logger = $logger;
	}

	public function process( $inputDesc, $inputData ) {
		$this->clearErrors();
		$this->clearProcessedData();
		foreach ( $inputDesc as $inputName => $desc ) {
			$type = $desc['type'];
			unset( $desc['type'] );
			$processor = $this->processorFactory->getProcessor( $type );
			$inputString = $inputData[$inputName] ?? null;
			if ( $inputString === null ) {
				$this->errors[$inputName] = 'Missing input data';
				continue;
			}

			$processor->process( $inputString, $desc );
		}
	}

	private function clearErrors() {
		$this->errors = [];
	}

	private function clearProcessedData() {
		$this->processedData = [];
	}

	/**
	 * @return boolean
	 */
	public function hasErrors() : bool {
		return !empty( $this->errors );
	}

	/**
	 * @return array
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * @return array
	 */
	public function getProcessedData() {
		return $this->processedData;
	}

}