<?php

namespace ParserHooks;

use Parser;

/**
 * Parser hook runner registrant.
 * Registers hook runners to a parser.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class HookRegistrant {

	/**
	 * @since 1.0
	 *
	 * @var Parser
	 */
	protected $parser;

	/**
	 * @since 1.0
	 *
	 * @param Parser $parser
	 */
	public function __construct( Parser &$parser ) {
		$this->parser = $parser;
	}

	/**
	 * @since 1.0
	 *
	 * @param FunctionRunner $runner
	 */
	public function registerFunction( FunctionRunner $runner ) {
		foreach ( $runner->getDefinition()->getNames() as $name ) {
			$this->parser->setFunctionHook(
				$name,
				function( $parser, $frame, $arguments ) use ( $runner ) {
					return $runner->run( $parser, $arguments );
				},
				SFH_OBJECT_ARGS
			);
		}
	}

}