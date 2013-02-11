<?php

namespace ParserHooks\Tests;

/**
 * Tests for the ParserHooks\HookDefinition class.
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
 * @ingroup ParserHooksTests
 *
 * @group ParserHooks
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class HookDefinitionTest extends \MediaWikiTestCase {

	public function namesProvider() {
		return $this->arrayWrap( array(
			'foo',
			'foo bar',
			array( 'foo' ),
			array( 'foobar' ),
			array( 'foo', 'bAr' ),
			array( 'foo', 'bar', 'baz BAH', 'BAR' ),
		) );
	}

	/**
	 * @dataProvider namesProvider
	 *
	 * @param string|string[] $names
	 */
	public function testGetNames( $names ) {
		$definition = new \ParserHooks\HookDefinition( $names );
		$obtainedNames = $definition->getNames();

		$this->assertInternalType( 'array', $obtainedNames );
		$this->assertContainsOnly( 'string', $obtainedNames );
		$this->assertArrayEquals( (array)$names, $obtainedNames );
	}

	public function parametersProvider() {
		return $this->arrayWrap( array(
			array()
		) );
	}

	/**
	 * @dataProvider parametersProvider
	 *
	 * @param array $parameters
	 */
	public function testGetParameters( array $parameters ) {
		$definition = new \ParserHooks\HookDefinition( 'foo', $parameters );

		$this->assertArrayEquals( $parameters, $definition->getParameters() );
	}

	public function defaultParametersProvider() {
		return $this->arrayWrap( array(
			'foo',
			'foo bar',
			array( 'foo' ),
			array( 'foobar' ),
			array( 'foo', 'bAr' ),
			array( 'foo', 'bar', 'baz BAH', 'BAR' ),
		) );
	}

	/**
	 * @dataProvider namesProvider
	 *
	 * @param string|string[] $defaultParameters
	 */
	public function testGetDefaultParameters( $defaultParameters ) {
		$definition = new \ParserHooks\HookDefinition( 'foo', array(), $defaultParameters );
		$obtainedDefaultParams = $definition->getDefaultParameters();

		$this->assertInternalType( 'array', $obtainedDefaultParams );
		$this->assertContainsOnly( 'string', $obtainedDefaultParams );
		$this->assertArrayEquals( (array)$defaultParameters, $obtainedDefaultParams );
	}

}
