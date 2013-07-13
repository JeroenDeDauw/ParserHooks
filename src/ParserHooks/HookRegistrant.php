<?php

namespace ParserHooks;

use Parser;

/**
 * Parser hook runner registrant.
 * Registers hook runners to a parser.
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
class HookRegistrant {

	/**
	 * @since 0.1
	 *
	 * @var Parser
	 */
	protected $parser;

	/**
	 * @since 0.1
	 *
	 * @param Parser $parser
	 */
	public function __construct( Parser &$parser ) {
		$this->parser = $parser;
	}

	/**
	 * @since 0.1
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