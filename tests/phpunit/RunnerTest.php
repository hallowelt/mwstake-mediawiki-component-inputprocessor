<?php

namespace MWStake\MediaWiki\Component\InputProcessor\Tests\Processor;

use Exception;
use MediaWiki\HookContainer\HookContainer;
use MWStake\MediaWiki\Component\InputProcessor\GenericProcessor;
use MWStake\MediaWiki\Component\InputProcessor\Processor\IntValue;
use MWStake\MediaWiki\Component\InputProcessor\ProcessorFactory;
use MWStake\MediaWiki\Component\InputProcessor\Runner;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use StatusValue;
use Wikimedia\ObjectFactory\ObjectFactory;

class RunnerTest extends TestCase {

	/**
	 * @return void
	 * @covers \MWStake\MediaWiki\Component\InputProcessor\Runner::process
	 * @dataProvider provideData
	 */
	public function testRun( array $processors, array $value, array $expected, bool $exception = false ) {
		$objectFactory = $this->createMock( ObjectFactory::class );
		$objectFactory->method( 'createObject' )->willReturnCallback( static function ( $spec ) {
			if ( is_array( $spec ) && $spec['class'] === IntValue::class ) {
				return new IntValue();
			}
			throw new Exception( 'invalid-processor' );
		} );
		$processorFactory = new ProcessorFactory( [
			'integer' => [ 'class' => IntValue::class ],
		], $objectFactory, $this->createMock( HookContainer::class ) );
		$logger = $this->createMock( LoggerInterface::class );

		$runner = new Runner( $processorFactory, $logger );
		try {
			$processed = $runner->process( $processors, $value );
			$this->assertSame( $expected, $processed );
		} catch ( Exception $e ) {
			$this->assertTrue( $exception );
			$status = $runner->getStatus();
			$this->assertTrue( $status instanceof StatusValue && !$status->isOK() );
			$errors = $status->getErrors();
			$this->assertSame( $expected, $errors );
		}
	}

	public function provideData(): array {
		return [
			'valid' => [
				'processors' => [
					'dummy' => ( new GenericProcessor() )->setRequired( true ),
					'foo' => ( new IntValue() )->setMin( 1 )->setMax( 10 ),
					'bar' => [ 'type' => 'integer', 'min' => 2, 'max' => 5 ],
				],
				'value' => [
					'dummy' => 'abc',
					'foo' => '5',
					'bar' => '3'
				],
				'expected' => [
					'dummy' => 'abc',
					'foo' => 5,
					'bar' => 3
				]
			],
			'invalid' => [
				'processors' => [
					'dummy' => ( new GenericProcessor() )->setRequired( true ),
					'foo' => ( new IntValue() )->setMin( 1 )->setMax( 10 ),
					'bar' => [ 'bla' ]
				],
				'value' => [
					'dummy' => null,
					'foo' => 'abc',
					'bla' => '123'
				],
				'expected' => [
					[
						'type' => 'error',
						'message' => 'inputprocessor-error-value-required',
						'params' => [ 'dummy' ],
					],
					[
						'type' => 'error',
						'message' => 'inputprocessor-error-int-not-number',
						'params' => [ 'foo', 'abc' ]
					],
					[
						'type' => 'error',
						'message' => 'inputprocessor-error-processor-not-registered',
						'params' => [ 'bar' ]
					]
				],
				'exception' => true
			]
		];
	}
}
