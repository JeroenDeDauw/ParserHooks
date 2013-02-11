<?php

namespace ParserHooks;

/**
 * Class that handles a parser function hook call coming from MediaWiki
 * by processing the parameters as declared in the hook definition and
 * then passes the result to the hook handler.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @since 0.1
 *
 * @file
 * @ingroup ParserHooks
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FunctionRunner {

	/**
	 * @since 0.1
	 *
	 * @var HookDefinition
	 */
	protected $definition;

	/**
	 * @since 0.1
	 *
	 * @var HookHandler
	 */
	protected $handler;

	/**
	 * @since 0.1
	 *
	 * @var \ParamProcessor\Processor
	 */
	protected $paramProcessor;

	/**
	 * @since 0.1
	 *
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
	 * @since 0.1
	 *
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
	 * @since 0.1
	 *
	 * @return HookHandler
	 */
	public function getHandler() {
		return $this->handler;
	}

	/**
	 * @since 0.1
	 *
	 * @return HookDefinition
	 */
	public function getDefinition() {
		return $this->definition;
	}

}
