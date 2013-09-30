<?php

/**
 * PHPUnit bootstrap file for the ParserHooks extension.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

require_once( __DIR__ . '/evilMediaWikiBootstrap.php' );

require_once( __DIR__ . '/../ParserHooks.php' );

$GLOBALS['wgExtensionMessagesFiles']['TagHookTest'] = __DIR__ . '/system/TagHookTest.i18n.php';