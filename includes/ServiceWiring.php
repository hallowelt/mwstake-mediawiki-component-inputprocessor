<?php

use MediaWiki\Logger\LoggerFactory;
use MediaWiki\MediaWikiServices;
use MWStake\MediaWiki\Component\InputProcessor\ProcessorFactory;

return [
	'MWStakeInputProcessorFactory' => static function ( MediaWikiServices $services ) {
		$logger = LoggerFactory::getInstance( 'mwstake-inputprocessor' );
		$specRegistry = $GLOBALS['mwsgInputProcessorRegistry'] ?? [];
		return new ProcessorFactory(
			$specRegistry,
			$services->getObjectFactory(),
			$services->getHookContainer(),
			$logger
		);
	},
	'MWStakeInputProcessorRunner' => static function ( MediaWikiServices $services ) {
		$logger = LoggerFactory::getInstance( 'mwstake-inputprocessor' );
		return new Runner(
			$services->get( 'MWStakeInputProcessorFactory' ),
			$logger
		);
	},
];
