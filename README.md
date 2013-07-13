[![Build Status](https://secure.travis-ci.org/wikimedia/mediawiki-extensions-ParserHooks.png?branch=master)](http://travis-ci.org/wikimedia/mediawiki-extensions-ParserHooks)

# ParserHooks

OOP interface for creating MediaWiki parser hooks in a declarative fashion

## Requirements

* PHP 5.3 or later
* ParamProcessor library 1.0 or later

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



## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Authors

ParserHooks has been written by [Jeroen De Dauw](https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw)
as a hobby project to support the [SubPageList MediaWiki extension](https://www.mediawiki.org/wiki/Extension:SubPageList).

## Release notes

### 0.1

2013-07-14

* Initial release.

## Links

* [ParserHooks on Packagist](https://packagist.org/packages/mediawiki/parser-hooks)
* [ParserHooks on Ohloh](https://www.ohloh.net/p/parserhooks)
* [ParserHooks on MediaWiki.org](https://www.mediawiki.org/wiki/Extension:ParserHooks)
* [TravisCI build status](https://travis-ci.org/wikimedia/mediawiki-extensions-ParserHooks)
* [Latest version of the readme file](https://github.com/wikimedia/mediawiki-extensions-ParserHooks/blob/master/README.md)
