<?php

namespace ParserHooks;

use ParamProcessor\Processor;
use Parser;

/**
 * Class that handles a parser hook hook call coming from MediaWiki
 * by processing the parameters as declared in the hook definition and
 * then passes the result to the hook handler.
 *
 * @since 1.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class HookRunner {

	/**
	 * @since 1.1
	 *
	 * @var HookDefinition
	 */
	protected $definition;

	/**
	 * @since 1.1
	 *
	 * @var HookHandler
	 */
	protected $handler;

	/**
	 * @since 1.1
	 *
	 * @var Processor
	 */
	protected $paramProcessor;

	/**
	 * @since 1.1
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
	 * @since 1.1
	 *
	 * @param string $text
	 * @param string[] $arguments
	 * @param Parser $parser
	 *
	 * @return mixed
	 */
	public function run( $text, array $arguments, Parser &$parser ) {
		$arguments = $this->getRawArgsList( $text, $arguments );

		return $this->handler->handle(
			$parser,
			$this->getProcessedArgs( $arguments )
		);
	}

	protected function getRawArgsList( $text, array $arguments ) {
		$defaultParameters = $this->definition->getDefaultParameters();
		$defaultParam = array_shift( $defaultParameters );

		// If there is a first default parameter, set the tag contents as its value.
		if ( !is_null( $defaultParam ) && !is_null( $text ) ) {
			$arguments[$defaultParam] = $text;
		}

		return $arguments;
	}

	protected function getProcessedArgs( array $rawArgs ) {
		$this->paramProcessor->setParameters(
			$rawArgs,
			$this->definition->getParameters()
		);

		return $this->paramProcessor->processParameters();
	}

	/**
	 * @since 1.1
	 *
	 * @return HookHandler
	 */
	public function getHandler() {
		return $this->handler;
	}

	/**
	 * @since 1.1
	 *
	 * @return HookDefinition
	 */
	public function getDefinition() {
		return $this->definition;
	}

}
