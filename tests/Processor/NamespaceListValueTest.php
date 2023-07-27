<?php

namespace MWStake\MediaWiki\Component\InputProcessor\Tests\Processor;

use MWStake\MediaWiki\Component\InputProcessor\Processor\NamespaceListValue;
use PHPUnit\Framework\TestCase;

class NamespaceListValueTest extends TestCase {

	/**
	 * @dataProvider provideTestProcessData
	 * @param string $input
	 * @param array $options
	 * @param array $expectedProcessedInput
	 * @param array $expectedErrors
	 * @return void
	 * @covers \MWStake\MediaWiki\Component\InputProcessor\Processor\NamespaceListValue::process
	 */
	public function testProcess( $input, $options, $expectedProcessedInput, $expectedErrors ) {
		$mockLanguage = $this->createMock( Language::class );
		$mockNamespaceInfo = $this->createMock( NamespaceInfo::class );
		$processor = new NamespaceListValue( $mockLanguage, $mockNamespaceInfo);
		$processor->process( $input, $options );
		$this->assertEquals( $expectedProcessedInput, $processor->getProcessedInput() );
		$this->assertEquals( $expectedErrors, $processor->getErrors() );
	}

	public function provideTestProcessData() {
		return [
			'ambigous-list-no-errors' => [
				'input' => '0, 1, 2, 3, 4, 5, 6, 7, 8, 9',
				'options' => [],
				'expectedProcessedInput' => [
					'0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
				],
				'expectedErrors' => []
			]
		];
	}
}