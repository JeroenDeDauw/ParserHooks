<?php

namespace ParserHooks\Tests;

use ParserHooks\HookDefinition;
use ParserHooks\HookRegistrant;

/**
 * @covers ParserHooks\HookRegistrant
 *
 * @group ParserHooks
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class HookRegistrantTest extends \PHPUnit_Framework_TestCase {

	// TODO: figure out how to assert this properly
	public function namesProvider() {
		return array(
			array( array( 'foo' ) ),
//			array( array( 'foo', 'bar' ) ),
//			array( array( 'foo', 'bar', 'baz', 'bah' ) ),
		);
	}

	/**
	 * @dataProvider namesProvider
	 */
	public function testRegisterFunction( array $names ) {
		$parser = $this->newMockParserForFunction( $names );
		$registrant = new HookRegistrant( $parser );

		$registrant->registerFunction( $this->newMockRunner( $names, 'ParserHooks\FunctionRunner' ) );
	}

	/**
	 * @dataProvider namesProvider
	 */
	public function testRegisterHook( array $names ) {
		$parser = $this->newMockParserForHook( $names );
		$registrant = new HookRegistrant( $parser );

		$registrant->registerHook( $this->newMockRunner( $names, 'ParserHooks\HookRunner' ) );
	}

	/**
	 * @dataProvider namesProvider
	 */
	public function testRegisterFunctionHandler( array $names ) {
		$parser = $this->newMockParserForFunction( $names );
		$registrant = new HookRegistrant( $parser );

		$registrant->registerFunctionHandler(
			new HookDefinition( $names ),
			$this->getMock( 'ParserHooks\HookHandler' )
		);
	}

	/**
	 * @dataProvider namesProvider
	 */
	public function testRegisterHookHandler( array $names ) {
		$parser = $this->newMockParserForHook( $names );
		$registrant = new HookRegistrant( $parser );

		$registrant->registerHookHandler(
			new HookDefinition( $names ),
			$this->getMock( 'ParserHooks\HookHandler' )
		);
	}

	protected function newMockParserForFunction( array $names ) {
		$parser = $this->getMock( 'Parser' );

		$parser->expects( $this->exactly( count( $names ) ) )
			->method( 'setFunctionHook' )
			->with(
				$this->equalTo( $names[0] ),
				$this->isType( 'callable' )
			);

		return $parser;
	}

	protected function newMockParserForHook( array $names ) {
		$parser = $this->getMock( 'Parser' );

		$parser->expects( $this->exactly( count( $names ) ) )
			->method( 'setHook' )
			->with(
				$this->equalTo( $names[0] ),
				$this->isType( 'callable' )
			);

		return $parser;
	}

	protected function newMockRunner( array $names, $runnerClass ) {
		$definition = new HookDefinition( $names );

		$runner = $this->getMockBuilder( $runnerClass )
			->disableOriginalConstructor()->getMock();

		$runner->expects( $this->once() )
			->method( 'getDefinition' )
			->will( $this->returnValue( $definition ) );

		return $runner;
	}

}
