<?php

namespace ParserHooks;

class FunctionRunner {

	/**
	 * @var HookDefinition
	 */
	protected $definition;

	/**
	 * @var HookHandler
	 */
	protected $handler;

	/**
	 * @var \ParamProcessor\Processor
	 */
	protected $paramProcessor;

	/**
	 * @param HookDefinition $definition
	 * @param HookHandler $handler
	 * @param \ParamProcessor\Processor|null $paramProcessor
	 */
	public function __construct( HookDefinition $definition, HookHandler $handler, \ParamProcessor\Processor $paramProcessor = null ) {
		$this->defintion = $definition;
		$this->handler = $handler;

		if ( $paramProcessor === null ) {
			$paramProcessor = \ParamProcessor\Processor::newDefault();
		}

		$this->paramProcessor = $paramProcessor;
	}

	/**
	 * @param \Parser $parser
	 *
	 * @return mixed
	 */
	public function run( \Parser &$parser /*, n args */ ) {
		$arguments = func_get_args();

		array_shift( $arguments );

		$names = $this->definition->getNames();
		$this->paramProcessor->getOptions()->setName( $names[0] );

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
	 * @return HookHandler
	 */
	public function getHandler() {
		return $this->handler;
	}

	/**
	 * @return HookDefinition
	 */
	public function getDefinition() {
		return $this->definition;
	}

}