# ParserHooks release notes

### 2.0 (TBD)

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
