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

if ( defined( 'ParserHooks_VERSION' ) ) {
	// Do not initialize more then once.
	return;
}

define( 'ParserHooks_VERSION', '0.1 alpha' );

// @codeCoverageIgnoreStart
spl_autoload_register( function ( $className ) {
	$className = ltrim( $className, '\\' );
	$fileName = '';
	$namespace = '';

	if ( $lastNsPos = strripos( $className, '\\') ) {
		$namespace = substr( $className, 0, $lastNsPos );
		$className = substr( $className, $lastNsPos + 1 );
		$fileName  = str_replace( '\\', '/', $namespace ) . '/';
	}

	$fileName .= str_replace( '_', '/', $className ) . '.php';

	$namespaceSegments = explode( '\\', $namespace );

	if ( $namespaceSegments[0] === 'ParserHooks' ) {
		if ( count( $namespaceSegments ) === 1 || $namespaceSegments[1] !== 'Tests' ) {
			require_once __DIR__ . '/src/' . $fileName;
		}
	}
} );

call_user_func( function() {

	global $wgExtensionCredits, $wgExtensionMessagesFiles, $wgHooks;

	$wgExtensionCredits['other'][] = array(
		'path' => __FILE__,
		'name' => 'ParserHooks',
		'version' => ParserHooks_VERSION,
		'author' => array(
			'[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
		),
		'url' => 'https://www.mediawiki.org/wiki/Extension:ParserHooks',
		'descriptionmsg' => 'parserhooks-desc'
	);

	$wgExtensionMessagesFiles['ParserHooksExtension'] = __DIR__ . '/ParserHooks.i18n.php';

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
		$directoryIterator = new RecursiveDirectoryIterator( __DIR__ . '/tests/phpunit/' );

		/**
		 * @var SplFileInfo $fileInfo
		 */
		foreach ( new RecursiveIteratorIterator( $directoryIterator ) as $fileInfo ) {
			if ( substr( $fileInfo->getFilename(), -8 ) === 'Test.php' ) {
				$files[] = $fileInfo->getPathname();
			}
		}

		return true;
	};

} );
// @codeCoverageIgnoreEnd
