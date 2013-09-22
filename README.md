# ParserHooks

[![Build Status](https://secure.travis-ci.org/wikimedia/mediawiki-extensions-ParserHooks.png?branch=master)](http://travis-ci.org/wikimedia/mediawiki-extensions-ParserHooks)

On Packagist:
[![Latest Stable Version](https://poser.pugx.org/mediawiki/parser-hooks/version.png)](https://packagist.org/packages/mediawiki/parser-hooks)
[![Download count](https://poser.pugx.org/mediawiki/parser-hooks/d/total.png)](https://packagist.org/packages/mediawiki/parser-hooks)

OOP interface for creating MediaWiki parser hooks in a declarative fashion.

## Requirements

* [PHP](http://php.net/) 5.3 or later
* [ParamProcessor](https://www.mediawiki.org/wiki/Extension:ParamProcessor) 1.0 or later
* [MediaWiki](https://www.mediawiki.org/) 1.16 or later

## Installation

You can use [Composer](http://getcomposer.org/) to download and install
this package as well as its dependencies. Alternatively you can simply clone
the git repository and take care of loading yourself.

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `mediawiki/parser-hooks` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
ParserHooks 1.0:

    {
        "require": {
            "mediawiki/parser-hooks": "1.0.*"
        }
    }

### Manual

Get the ParserHooks code, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Load all dependencies and the load the ParserHooks library by including its entry point:
ParserHooks.php.

## Usage

All classes are located in the ParserHooks namespace, which is PSR-0 mapped onto the src/ directory.

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

The parameter definitions are ParamProcessor\ParamDefinition objects. See the ParamProcessor
documentation on how to specify these.

### HookHandler

The actual behaviour for your parser hook is implemented in an implementation of HookHandler.
These implementations have a handle method which gets a Parser and a ParamProcssor\ProcessingResult,
which is supposed to return a string.

### Knitting it all together

This library also provides two additional classes, FunctionRunner, and HookRegistrant. The former
takes care of invoking the ParamProcessor library based on a HookDefinition. The later takes care
of registering the parser hooks defined by your HookDefinition objects to a MediaWiki Parser object.

```php
$awesomeHookDefinition = new HookDefinition( 'awesome', array( /* ... */ ) );
$anotherHookDefinition = new HookDefinition( 'another', array( /* ... */ ) );

$awesomeHookHandler = new AwesomeHookHandler( /* ... */ );
$anotherHookHandler = new AnotherHookHandler( /* ... */ );

$hookRegistrant = new HookRegistrant( $mediaWikiParser );

$hookRegistrant->registerFunction( new FunctionRunner( $awesomeHookDefinition, $awesomeHookHandler ) );
$hookRegistrant->registerFunction( new FunctionRunner( $anotherHookDefinition, $anotherHookHandler ) );
```

If you want to have the same hook, but with other default behaviour, you can avoid any kind of
duplication by doing something as follows on top of the above code:

```php
$hookRegistrant->registerFunction( new FunctionRunner( $extraAwesomeHookDefinition, $awesomeHookHandler ) );
```

Where $extraAwesomeHookDefinition is a variation of $awesomeHookDefinition.

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Authors

ParserHooks has been written by [Jeroen De Dauw](https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw)
as a hobby project to support the [SubPageList MediaWiki extension](https://www.mediawiki.org/wiki/Extension:SubPageList).

## Release notes

### 0.1 (2013-07-14)

* Initial release ([blog post](http://www.bn2vs.com/blog/2013/07/14/parserhooks-declarative-oop-api-for-mediawiki-released/))

## Links

* [ParserHooks on Packagist](https://packagist.org/packages/mediawiki/parser-hooks)
* [ParserHooks on Ohloh](https://www.ohloh.net/p/parserhooks)
* [ParserHooks on MediaWiki.org](https://www.mediawiki.org/wiki/Extension:ParserHooks)
* [TravisCI build status](https://travis-ci.org/wikimedia/mediawiki-extensions-ParserHooks)
* [Latest version of the readme file](https://github.com/wikimedia/mediawiki-extensions-ParserHooks/blob/master/README.md)
