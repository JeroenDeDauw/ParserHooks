<?php

namespace ParserHooks;

use ParamProcessor\Processor;
use Parser;

/**
 * Class that handles a parser function hook call coming from MediaWiki
 * by processing the parameters as declared in the hook definition and
 * then passes the result to the hook handler.
 *
 * @since 1.0
 *
 * @file
 * @ingroup ParserHooks
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FunctionRunner {

	/**
	 * @since 1.0
	 *
	 * @var HookDefinition
	 */
	protected $definition;

	/**
	 * @since 1.0
	 *
	 * @var HookHandler
	 */
	protected $handler;

	/**
	 * @since 1.0
	 *
	 * @var Processor
	 */
	protected $paramProcessor;

	/**
	 * @since 1.0
	 *
	 * @param HookDefinition $definition
	 * @param HookHandler $handler
	 * @param Processor|null $paramProcessor
	 */
	public function __construct( HookDefinition $definition, HookHandler $handler, Processor $paramProcessor = null ) {
		$this->definition = $definition;
		$this->handler = $handler;

		if ( $paramProcessor === null ) {
			$paramProcessor = Processor::newDefault();
		}

		$this->paramProcessor = $paramProcessor;
	}

	/**
	 * @since 1.0
	 *
	 * @param Parser $parser
	 * @param string[] $arguments
	 *
	 * @return mixed
	 */
	public function run( Parser &$parser, array $arguments ) {
		$this->paramProcessor->setFunctionParams(
			$arguments,
			$this->definition->getParameters(),
			$this->definition->getDefaultParameters()
		);

		return $this->handler->handle(
			$parser,
			$this->paramProcessor->processParameters()
		);
	}

	/**
	 * @since 1.0
	 *
	 * @return HookHandler
	 */
	public function getHandler() {
		return $this->handler;
	}

	/**
	 * @since 1.0
	 *
	 * @return HookDefinition
	 */
	public function getDefinition() {
		return $this->definition;
	}

}
