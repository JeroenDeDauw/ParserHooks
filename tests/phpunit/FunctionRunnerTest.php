<?php

namespace ParserHooks\Tests;

use ParamProcessor\ProcessedParam;
use ParamProcessor\ProcessingResult;
use ParserHooks\FunctionRunner;
use ParserHooks\HookDefinition;

/**
 * @covers ParserHooks\FunctionRunner
 *
 * @file
 * @ingroup ParserHooks
 * @group ParserHooks
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FunctionRunnerTest extends \PHPUnit_Framework_TestCase {

	public function testTrue() {
		$expectedResult = 'foo bar baz';

		$definition = new HookDefinition( 'someHook' );

		$parser = $this->getMock( 'Parser' );

		$hookHandler = $this->getMock( 'ParserHooks\HookHandler' );

		$hookHandler->expects( $this->once() )
			->method( 'handle' )
			->with( $this->equalTo( $parser ) )
			->will( $this->returnValue( $expectedResult ) );

		$paramProcessor = $this->getMockBuilder( 'ParamProcessor\Processor' )
			->disableOriginalConstructor()->getMock();

		$paramProcessor->expects( $this->once() )
			->method( 'setFunctionParams' );

		$paramProcessor->expects( $this->once() )
			->method( 'processParameters' )
			->will( $this->returnValue(
				new ProcessingResult( array(
					'foo' => new ProcessedParam( 'foo', 'bar', false )
				) )
			) );

		$runner = new FunctionRunner(
			$definition,
			$hookHandler,
			$paramProcessor
		);

		$result = $runner->run( $parser );

		$this->assertEquals( $expectedResult, $result );
	}

}
