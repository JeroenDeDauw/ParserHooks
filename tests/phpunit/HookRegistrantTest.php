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

	public function testRegisterFunction() {
		$parser = $this->getMock( 'Parser' );

		$parser->expects( $this->exactly( 3 ) )
			->method( 'setFunctionHook' )
			->with( $this->equalTo( 'foo' ) );

		$definition = new HookDefinition(
			array( 'foo', 'foo', 'foo' )
		);

		$runner = $this->getMockBuilder( 'ParserHooks\FunctionRunner' )
			->disableOriginalConstructor()->getMock();

		$runner->expects( $this->once() )
			->method( 'getDefinition' )
			->will( $this->returnValue( $definition ) );

		$registrant = new HookRegistrant( $parser );

		$registrant->registerFunction( $runner );
	}

}
