<?php

namespace ParserHooks\Tests;

use ParamProcessor\ProcessedParam;
use ParamProcessor\ProcessingResult;
use Parser;
use ParserHooks\FunctionRunner;
use ParserHooks\HookDefinition;
use ParserHooks\HookRegistrant;
use ParserHooks\HookRunner;
use ParserOptions;
use PHPUnit\Framework\TestCase;
use Title;
use User;

/**
 * @group ParserHooks
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class TagHookTest extends TestCase {

	const HOOK_NAME = 'systemtest_tagextension';

	/**
	 * @var Parser
	 */
	protected $parser;

	public function setUp(): void {
		$this->parser = $this->getSomeParser();
	}

	protected function getSomeParser() {
		if ( class_exists( \MediaWiki\MediaWikiServices::class ) ) {
			$services = \MediaWiki\MediaWikiServices::getInstance();
			if ( is_callable( $services, 'getParserFactory' ) ) {
				return $services->getParserFactory()->create();
			}
		}
		// Fallback for MW < 1.32
		global $wgParserConf;
		return new Parser( $wgParserConf );
	}

	public function testParserFunctionReceivesArguments() {
		$this->registerParserHook();

		$name = self::HOOK_NAME;

		$result = $this->getParsedText(
			"||<$name 1337=yes>Jeroen</$name>|||"
		);

		$this->assertInternalType( 'string', $result );
		$this->assertContains(
			"||-Jeroen-|||",
			$result
		);
	}

	protected function getParsedText( $text ) {
		return $this->parser->parse(
			$text,
			Title::newFromText( "Test" ),
			ParserOptions::newFromUserAndLang( new User(), $GLOBALS['wgContLang'] ),
			false
		)->getText();
	}

	protected function registerParserHook() {
		$runner = $this->getHookRunner();

		$registrant = new HookRegistrant( $this->parser );
		$registrant->registerHook( $runner );
	}

	protected function getHookRunner() {
		return new HookRunner(
			$this->getHookDefinition(),
			$this->getHookHandler()
		);
	}

	protected function getHookDefinition() {
		return new HookDefinition(
			self::HOOK_NAME,
			[
				[
					'name' => 'name',
					'message' => 'abc',
				],
				[
					'name' => 'awesomeness',
					'message' => 'abc',
					'type' => 'integer',
					'default' => 9001,
				],
				[
					'name' => '1337',
					'message' => 'abc',
					'type' => 'boolean',
					'default' => false,
				],
			],
			[
				'name'
			]
		);
	}

	protected function getHookHandler() {
		$hookHandler = $this->createMock( 'ParserHooks\HookHandler' );

		$hookHandler->expects( $this->once() )
			->method( 'handle' )
			->with(
				$this->isInstanceOf( 'Parser' ),
				$this->callback( function( $var ) {
					if ( !( $var instanceof ProcessingResult ) ) {
						return false;
					}

					$params = $var->getParameters();
					$expectedParams = [
						'1337' => new ProcessedParam( '1337', true, false, '1337', 'yes' ),
						'awesomeness' => new ProcessedParam( 'awesomeness', 9001, true, null, null ),
						'name' => new ProcessedParam( 'name', 'Jeroen', false, 'name', 'Jeroen' ),
					];

					asort( $params );
					asort( $expectedParams );

					return $params == $expectedParams;
				} )
			)
			->will( $this->returnCallback( function( Parser $parser, ProcessingResult $result ) {
				$params = $result->getParameters();
				return '-' . $params['name']->getValue() . '-';
			} ) );

		return $hookHandler;
	}



}
