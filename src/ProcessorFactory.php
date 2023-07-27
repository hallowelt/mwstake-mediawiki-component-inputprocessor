<?php

namespace MWStake\MediaWiki\Component\InputProcessor;

use Exception;
use MediaWiki\HookContainer\HookContainer;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Wikimedia\ObjectFactory\ObjectFactory;

class ProcessorFactory {
	
	/** @var array */
	private $registry = [];

	/** @var ObjectFactory */
	private $objectFacotry = null;

	/** @var HookContainer */
	private $hookContainer = null;

	/** @var LoggerInterface */
	private $logger = null;


	/**
	 * @param array $registry
	 * @param ObjectFactory $objectFacotry
	 * @param HookContainer $hookContainer
	 * @param LoggerInterface $logger
	 */
	public function __construct( $registry, $objectFacotry, $hookContainer, $logger ) {
		$this->registry = $registry;
		$this->objectFacotry = $objectFacotry;
		$this->hookContainer = $hookContainer;
		$this->logger = $logger;
	}

	/**
	 * @param string $type
	 * @return IProcessor
	 */
	public function getProcessor( $type ) {
		$this->init();
		if ( !isset( $this->registry[$type] ) ) {
			throw new Exception( 'Unknown processor type: ' . $type );
		}

		$instance = $this->objectFacotry->getObjectFromSpec( $this->registry[$type] );
		if ( !$instance instanceof IProcessor ) {
			throw new Exception( 'Processor must implement IProcessor' );
		}
		if ( $instance instanceof LoggerAwareInterface ) {
			$instance->setLogger( $this->logger );
		}
		
		return $instance;
	}

	/** @var bool */
	private $initialized = false;

	private function init() {
		if ( $this->initialized ) {
			return;
		}
		$this->hookContainer->run(
			'MWStakeMediaWikiComponentInputProcessorRegisterProcessors',
			[ &$this->registry ]
		);
		$this->initialized = true;
	}
}