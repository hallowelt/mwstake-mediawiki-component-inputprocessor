<?php

namespace MWStake\MediaWiki\Component\InputProcessor\Tests\Processor;

use MWStake\MediaWiki\Component\InputProcessor\IProcessor;
use PHPUnit\Framework\TestCase;

abstract class ProcessorTestBase extends TestCase {

	/**
	 * @dataProvider provideTestProcessData
	 * @param mixed $input
	 * @param array $options
	 * @param mixed $expected
	 * @param bool $expectException
	 * @return void
	 */
	public function testProcess( $input, array $options, $expected, bool $expectException = false ) {
		$processor = $this->getProcessor();
		$processor->initializeFromSpec( $options );

		$status = $processor->process( $input, 'test' );
		$this->assertSame( !$expectException, $status->isGood() );
		if ( $status->isGood() ) {
			$this->assertSame( $expected, $status->getValue() );
		} else {
			$this->assertSame( $expected, $status->getErrors()[0] );
		}
	}

	/**
	 * @return IProcessor
	 */
	abstract protected function getProcessor(): IProcessor;

	abstract public function provideTestProcessData(): array;
}
