<?php

namespace ParserHooks;

use Parser;
use ParserHooks\Internal\Runner;

/**
 * Class that handles a parser function hook call coming from MediaWiki
 * by processing the parameters as declared in the hook definition and
 * then passes the result to the hook handler.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FunctionRunner extends Runner {

	const OPT_DO_PARSE = 'parse'; // Boolean, since 1.1

	/**
	 * @since 1.0
	 *
	 * @param Parser $parser
	 * @param string|string[] $arguments
	 *
	 * @return array
	 */
	public function run( Parser &$parser, $arguments ) {
		$resultText = $this->handler->handle(
			$parser,
			$this->getProcessedParams( $arguments )
		);

		return $this->getResultStructure( $resultText );
	}

	protected function getProcessedParams( $rawArguments ) {
		if ( is_string( $rawArguments ) ) {
			$rawArguments = explode( '|', $rawArguments );
		}

		$this->paramProcessor->setFunctionParams(
			$rawArguments,
			$this->definition->getParameters(),
			$this->definition->getDefaultParameters()
		);

		return $this->paramProcessor->processParameters();
	}

	protected function getResultStructure( $resultText ) {
		$result = array( $resultText );

		if ( !$this->getOption( self::OPT_DO_PARSE ) ) {
			$result['noparse'] = true;
			$result['isHTML'] = true;
		}

		return $result;
	}

	/**
	 * @see Runner::getDefaultOptions
	 *
	 * @since 1.1
	 *
	 * @return array
	 */
	protected function getDefaultOptions() {
		return array(
			self::OPT_DO_PARSE => true,
		);
	}

}
