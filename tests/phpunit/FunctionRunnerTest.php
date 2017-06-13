<?php

namespace ParserHooks\Tests;

use ParamProcessor\ProcessedParam;
use ParamProcessor\ProcessingResult;
use ParamProcessor\Processor;
use ParserHooks\FunctionRunner;
use ParserHooks\HookDefinition;
use ParserHooks\HookHandler;

/**
 * @covers ParserHooks\FunctionRunner
 * @covers ParserHooks\Internal\Runner
 *
 * @group ParserHooks
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FunctionRunnerTest extends \PHPUnit_Framework_TestCase {

	public function optionsProvider() {
		return [
			[
				[
					FunctionRunner::OPT_DO_PARSE => true,
				],
			],
			[
				[
					FunctionRunner::OPT_DO_PARSE => false,
				],
			],
		];
	}

	const HOOK_HANDLER_RESULT = 'hook handler result';

	/**
	 * @dataProvider optionsProvider
	 */
	public function testRun( array $options ) {
		$definition = new HookDefinition( 'someHook' );

		$parser = $this->getMock( \Parser::class );

		$inputParams = [
			'foo=bar',
			'baz=42',
		];

		$processedParams = new ProcessingResult( [
			'foo' => new ProcessedParam( 'foo', 'bar', false )
		] );

		$paramProcessor = $this->newMockParamProcessor( $inputParams, $processedParams );

		$hookHandler = $this->newMockHookHandler( $processedParams, $parser );

		$runner = new FunctionRunner(
			$definition,
			$hookHandler,
			$options,
			$paramProcessor
		);

		$frame = $this->getMock( \PPFrame::class );

		$frame->expects( $this->exactly( count( $inputParams ) ) )
			->method( 'expand' )
			->will( $this->returnArgument( 0 ) );

		$result = $runner->run(
			$parser,
			$inputParams,
			$frame
		);

		$this->assertResultIsValid( $result, $options );
	}

	private function assertResultIsValid( $result, array $options ) {
		$expected = [ self::HOOK_HANDLER_RESULT ];

		if ( !$options[FunctionRunner::OPT_DO_PARSE] ) {
			$expected['noparse'] = true;
			$expected['isHTML'] = true;
		}

		$this->assertEquals( $expected, $result );
	}

	private function newMockHookHandler( $expectedParameters, $parser ) {
		$hookHandler = $this->getMock( HookHandler::class );

		$hookHandler->expects( $this->once() )
			->method( 'handle' )
			->with(
				$this->equalTo( $parser ),
				$this->equalTo( $expectedParameters )
			)
			->will( $this->returnValue( self::HOOK_HANDLER_RESULT ) );

		return $hookHandler;
	}

	private function newMockParamProcessor( $expandedParams, $processedParams ) {
		$paramProcessor = $this->getMockBuilder( Processor::class )
			->disableOriginalConstructor()->getMock();

		$paramProcessor->expects( $this->once() )
			->method( 'setFunctionParams' )
			->with( $this->equalTo( $expandedParams ) );

		$paramProcessor->expects( $this->once() )
			->method( 'processParameters' )
			->will( $this->returnValue( $processedParams ) );

		return $paramProcessor;
	}

}
