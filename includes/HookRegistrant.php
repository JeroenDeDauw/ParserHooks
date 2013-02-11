<?php

namespace ParserHooks;

use Parser;

class HookRegistrant {

	/**
	 * @var \Parser
	 */
	protected $parser;

	/**
	 * @param \Parser $parser
	 */
	public function __construct( Parser &$parser ) {
		$this->parser = $parser;
	}

	/**
	 * @param FunctionRunner $runner
	 */
	public function registerFunction( FunctionRunner $runner ) {
		$this->parser->setFunctionHook(
			$runner->getDefinition(),
			array( $runner, 'run' ),
			SFH_OBJECT_ARGS
		);
	}

}