<?php
/**
 * Initialization file for the ParserHooks MediaWiki extension.
 *
 * https://github.com/JeroenDeDauw/ParserHooks
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( defined( 'ParserHooks_VERSION' ) ) {
	// Do not initialize more than once.
	return 1;
}

define( 'ParserHooks_VERSION', '1.6.2' );

wfLoadExtension( 'ParserHooks' );
// @codeCoverageIgnoreEnd
