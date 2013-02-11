<?php

/**
 * Initialization file for the ParserHooks MediaWiki extension.
 *
 * Documentation:	 		https://www.mediawiki.org/wiki/Extension:ParserHooks
 * Support					https://www.mediawiki.org/wiki/Extension_talk:ParserHooks
 * Source code:				https://gerrit.wikimedia.org/r/gitweb?p=mediawiki/extensions/ParserHooks.git
 *
 * @file
 * @ingroup ParserHooks
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documentation group collects source code files belonging to ParserHooks.
 *
 * @defgroup ParserHooks ParserHooks
 */

/**
 * Tests part of the ParserHooks extension.
 *
 * @defgroup ParserHooksTests ParserHooksTest
 * @ingroup ParserHooks
 * @ingroup Test
 */

define( 'ParserHooks_VERSION', '0.1 alpha' );

// @codeCoverageIgnoreStart
call_user_func( function() {

	global $wgExtensionCredits, $wgExtensionMessagesFiles, $wgAutoloadClasses, $wgHooks;

	$wgExtensionCredits['other'][] = include( __DIR__ . '/ParserHooks.credits.php' );

	$wgExtensionMessagesFiles['ParserHooksExtension'] = __DIR__ . '/ParserHooks.i18n.php';

	foreach ( include( __DIR__ . '/ParserHooks.classes.php' ) as $class => $file ) {
		if ( !array_key_exists( $class, $GLOBALS['wgAutoloadLocalClasses'] ) ) {
			$wgAutoloadClasses[$class] = __DIR__ . '/' . $file;
		}
	}

	/**
	 * Hook to add PHPUnit test cases.
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UnitTestsList
	 *
	 * @since 0.1
	 *
	 * @param array $files
	 *
	 * @return boolean
	 */
	$wgHooks['UnitTestsList'][]	= function( array &$files ) {
		$testFiles = array(
//			'FunctionRunner',
			'HookDefinition',
//			'HookHandler',
//			'HookRegistrant',
		);

		foreach ( $testFiles as $file ) {
			$files[] = __DIR__ . '/tests/phpunit/' . $file . 'Test.php';
		}

		return true;
	};

} );
// @codeCoverageIgnoreEnd
