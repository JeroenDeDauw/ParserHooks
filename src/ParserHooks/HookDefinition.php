<?php

namespace ParserHooks;

/**
 * Definition of a parser hooks signature.
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
 * @since 1.0
 *
 * @file
 * @ingroup ParserHooks
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class HookDefinition {

	protected $names;
	protected $parameters;
	protected $defaultParameters;

	/**
	 * @since 1.0
	 *
	 * @param string|string[] $names
	 * @param array $parameters
	 * @param string|string[] $defaultParameters
	 */
	public function __construct( $names, array $parameters = array(), $defaultParameters = array() ) {
		$this->names = (array)$names;
		$this->parameters = $parameters;
		$this->defaultParameters = (array)$defaultParameters;
	}

	/**
	 * @see ParserFunction::getName
	 *
	 * @since 1.0
	 *
	 * @return string[]
	 */
	public function getNames() {
		return $this->names;
	}

	/**
	 * @see ParserFunction::getParameters
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public function getParameters() {
		return $this->parameters;
	}

	/**
	 * @see ParserFunction::getDefaultParameters
	 *
	 * @since 1.0
	 *
	 * @return string[]
	 */
	public function getDefaultParameters() {
		return $this->defaultParameters;
	}

}