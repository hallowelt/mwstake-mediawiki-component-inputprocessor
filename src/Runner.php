<?php

namespace MWStake\MediaWiki\Component\InputProcessor;

use Exception;
use Psr\Log\LoggerInterface;
use StatusValue;
use Throwable;

class Runner {

	/** @var ProcessorFactory */
	private $processorFactory;

	/** @var LoggerInterface */
	private $logger;

	/** @var StatusValue|null */
	private $status = null;

	/**
	 * @param ProcessorFactory $processorFactory
	 * @param LoggerInterface $logger
	 */
	public function __construct( ProcessorFactory $processorFactory, LoggerInterface $logger ) {
		$this->processorFactory = $processorFactory;
		$this->logger = $logger;
	}

	/**
	 * @param array $processors
	 * @param array $inputData
	 * @return array
	 * @throws Exception
	 */
	public function process( array $processors, array $inputData ): array {
		$output = [];

		$this->status = StatusValue::newGood();
		foreach ( $processors as $key => $processor ) {
			if ( is_array( $processor ) ) {
				try {
					$processor = $this->processorFactory->createWithData( $processor['type'] ?? '', $processor );
				} catch ( Throwable $ex ) {
					$this->status->setOK( false );
					$this->status->error( $ex->getMessage(), $key );
					continue;
				}

			}
			if ( !$processor instanceof IProcessor ) {
				$this->status->setOK( false );
				$this->status->error( 'inputprocessor-error-invalid-processor-object', $key );
				continue;
			}
			$value = $inputData[$key] ?? null;
			$status = $processor->process( $value, $key );
			if ( $status->isGood() ) {
				$output[$key] = $status->getValue();
			} else {
				$this->logger->error( "Error processing input $key: " . $status->getValue() );
				$this->status->setOK( false );
				$this->status->merge( $status );
			}
		}
		if ( !$this->status->isOK() ) {
			throw new Exception( 'Error processing input' );
		}
		return $output;
	}

	/**
	 * @return StatusValue|null
	 */
	public function getStatus(): ?StatusValue {
		return $this->status;
	}
}
