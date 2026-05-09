# ParserHooks

[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/JeroenDeDauw/ParserHooks/ci.yml?branch=master)](https://github.com/JeroenDeDauw/ParserHooks/actions?query=workflow%3ACI)
[![Latest Stable Version](https://poser.pugx.org/mediawiki/parser-hooks/version.png)](https://packagist.org/packages/mediawiki/parser-hooks)
[![Download count](https://poser.pugx.org/mediawiki/parser-hooks/d/total.png)](https://packagist.org/packages/mediawiki/parser-hooks)

OOP interface for creating MediaWiki parser hooks in a declarative fashion.

This is a PHP library for MediaWiki extensions. It does not in itself add or enhance functionality of your wiki.

## Platform compatibility and release status

The PHP and MediaWiki version ranges listed are those in which ParserHooks is known to work. It might also
work with more recent versions of PHP and MediaWiki, though this is not guaranteed. Increases of
minimum requirements are indicated in bold. For a detailed list of changes, see the [release notes](RELEASE-NOTES.md).

<table>
	<tr>
		<th>ParserHooks</th>
		<th>PHP</th>
		<th>MediaWiki</th>
		<th>Release status</th>
	</tr>
	<tr>
		<th>3.0.x</th>
		<td>8.1 - 8.5</td>
		<td>1.43 - 1.45</td>
		<td><strong>Stable release</strong></td>
	</tr>
	<tr>
		<th>2.0.x</th>
		<td>8.1 - 8.4</td>
		<td>1.43 - 1.45</td>
		<td>Superseded by 3.0</td>
	</tr>
	<tr>
		<th>1.6.x</th>
		<td>7.2 - 8.3</td>
		<td>1.31 - 1.43</td>
		<td>Bugfixes only</td>
	</tr>
	<tr>
		<th>1.5.x</th>
		<td>5.3 - 7.1</td>
		<td>1.16 - 1.30</td>
		<td>Obsolete release, no support</td>
	</tr>
	<tr>
		<th>1.0.x - 1.4.x</th>
		<td>5.3 - 5.6</td>
		<td>1.16 - 1.23</td>
		<td>Obsolete release, no support</td>
	</tr>
</table>

## Installation

ParserHooks is a PHP library distributed via [Composer](https://getcomposer.org/).
Add a dependency on `mediawiki/parser-hooks` to your project's `composer.json`:

    {
        "require": {
            "mediawiki/parser-hooks": "~3.0"
        }
    }

No `LocalSettings.php` change is required. ParserHooks no longer ships
`extension.json` and is not registered as a MediaWiki extension; the classes
are autoloaded by Composer.

## Usage

All classes are located in the `ParserHooks` namespace, which is PSR-4 mapped onto the `src/` directory.

### General concept

The declarative OOP interface provided by this library allows you to define the signatures of
your parser hooks and the handlers for them separately. The library makes use of the parameters
specified in this definition to do parameter processing via the ParamProcessor library. This means
that the handler you write for your parser function will not need to care about what the name of
the parser function is, or how the parameters for it should be processed. It has a "sizes" parameter
that takes an array of positive integers? Your handler will always get an actual PHP array of integer
without needing to do any parsing, validation, defaulting, etc.

### HookDefinition

An instance of the HookDefinition class represents the signature of a parser hook. It defines
the name of the parser hook and the parameters (including their types, default values, etc) it
accepts. It does not define any behaviour, and is thus purely declarative. Instances of this
class are used in handling of actual parser hooks, though can also be used in other contexts.
For instance, you can feed these definitions to a tool that generates parser hook documentation
based on them.

The parameter definitions are ParamProcessor\ParamDefinition objects. See the
[ParamProcessor](https://github.com/JeroenDeDauw/ParamProcessor) documentation on how to specify these.

### HookHandler

The actual behaviour for your parser hook is implemented in an implementation of HookHandler.
These implementations have a handle method which gets a Parser and a ParamProcssor\ProcessingResult,
which is supposed to return a string.

### Knitting it all together

This library also provides two additional classes, FunctionRunner, and HookRegistrant. The former
takes care of invoking the ParamProcessor library based on a HookDefinition. The later takes care
of registering the parser hooks defined by your HookDefinition objects to a MediaWiki Parser object.

```php
$awesomeHookDefinition = new HookDefinition( 'awesome', [ /* ... */ ] );
$anotherHookDefinition = new HookDefinition( 'another', [ /* ... */ ] );

$awesomeHookHandler = new AwesomeHookHandler( /* ... */ );
$anotherHookHandler = new AnotherHookHandler( /* ... */ );

$hookRegistrant = new HookRegistrant( $mediaWikiParser );

$hookRegistrant->registerFunctionHandler( $awesomeHookDefinition, $awesomeHookHandler );
$hookRegistrant->registerFunctionHandler( $anotherHookDefinition, $anotherHookHandler );
```

If you want to have the same hook, but with other default behaviour, you can avoid any kind of
duplication by doing something as follows on top of the above code:

```php
$hookRegistrant->registerFunctionHandler( $extraAwesomeHookDefinition, $awesomeHookHandler );
```

Where $extraAwesomeHookDefinition is a variation of $awesomeHookDefinition.

### Parser functions and tag hooks

To register a parser function, use HookRegistrant::registerFunctionHandler.

```php
$hookRegistrant->registerFunctionHandler( $awesomeHookDefinition, $awesomeHookHandler );
```

To register a tag hook, use HookRegistrant::registerHookHandler.

```php
$hookRegistrant->registerHookHandler( $awesomeHookDefinition, $awesomeHookHandler );
```

Both functions take the exact same arguments, so once you created a HookDefinition and
a HookHandler, you can have them registered as both parser function and tag hook with
no extra work.

## Tests

This library comes with a set of PHPUnit tests that cover all non-trivial code. The tests
are run on every push and pull request via [GitHub Actions](https://github.com/JeroenDeDauw/ParserHooks/actions).

The tests can be run from the `tests/phpunit` directory of your MediaWiki installation
with this command:

    php tests/phpunit/phpunit.php -c extensions/ParserHooks/

## Authors

ParserHooks has been written by [Jeroen De Dauw](https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw)
as a hobby project to support the
[SubPageList MediaWiki extension](https://github.com/JeroenDeDauw/SubPageList/blob/master/README.md).

## Release notes

### 3.0.0 (2026-05-10)

* ParserHooks is now a pure PHP library, distributed via Composer. The MediaWiki extension registration files (`extension.json` and `i18n/`) have been removed.
* Remove `wfLoadExtension( 'ParserHooks' )` from `LocalSettings.php`. ParserHooks classes load automatically when the package is installed via Composer.
* ParserHooks no longer appears on `Special:Version`.

### 2.0.0 (2026-05-10)

* Increased PHP requirement to PHP 8.1
* Increased MediaWiki requirement to MediaWiki 1.43
* Removed the `ParserHooks.php` entry point. Load the extension via `wfLoadExtension( 'ParserHooks' )` instead.
* Updated translations

### 1.6.1 (2020-01-14)

* Updated translations

### 1.6 (2019-07-14)

* Added support for PHP 7.2, 7.3 and 7.4
* Added support for MediaWiki 1.31, 1.32 and 1.33
* Dropped support for PHP 7.1 and older
* Dropped support for MediaWiki 1.30 and older
* Updated translations

### 1.5 (2016-03-05)

* Added license now shown on Special:Version
* Updated translations
* Made minor style improvements
* Ensured the extension works with PHP 7 and MediaWiki up to at least 1.27

### 1.4 (2014-07-05)

* Changed the PHPUnit bootstrap so that the tests can be run via the MediaWiki test runner
* Updated the CI configuration to test the code against multiple MediaWiki versions
* Updated translations

### 1.3 (2014-06-25)

* Updated translations
* Changed class loading to PSR-4
* Updated the used Validator version to 2.x >= 2.0.4

### 1.2.1 (2013-11-22)

* Updated the used Validator version from 1.0 alpha to 1.0.0.1 stable, or later

### 1.2 (2013-09-30)

* Fixed parameter handling bug in FunctionRunner
* Added system test for tag hook handling

### 1.1 (2013-09-25)

* Added HookRunner and HookRegistrant::registerHook
* Added HookRegistrant::registerFunctionHandler and HookRegistrant::registerHookHandler
* Fixed parameter handling bug in FunctionRunner
* Improved HookRegistrantTest

You can [read the release blog post](https://www.entropywins.wtf/blog/2013/09/25/parserhooks-1-1-released/)

### 1.0.1 (2013-09-22)

* Improved HookDefinition documentation
* Added extra type checking in HookDefinition
* Added extra tests for HookDefinition
* Added coveralls.io support
* Added PHPUnit file whitelisting (for more accurate and faster generated coverage reports)

### 1.0 (2013-07-14)

* Initial release ([blog post](https://www.entropywins.wtf/blog/2013/07/14/parserhooks-declarative-oop-api-for-mediawiki-released/))

## Links

* [ParserHooks on Packagist](https://packagist.org/packages/mediawiki/parser-hooks)
* [ParserHooks on MediaWiki.org](https://www.mediawiki.org/wiki/Extension:ParserHooks)
