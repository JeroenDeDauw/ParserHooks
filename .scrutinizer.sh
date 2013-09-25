#! /bin/bash

set -x

cd ..

git clone https://gerrit.wikimedia.org/r/p/mediawiki/core.git phase3 --depth 1

cd -
cd ../phase3/extensions

mkdir ParserHooks

cd -
cp -r * ../phase3/extensions/ParserHooks

cd ../phase3
cd extensions/ParserHooks

composer install --prefer-source

cd ../..
echo 'require_once( __DIR__ . "/extensions/ParserHooks/ParserHooks.php" );' >> LocalSettings.php

echo 'error_reporting(E_ALL| E_STRICT);' >> LocalSettings.php
echo 'ini_set("display_errors", 1);' >> LocalSettings.php
echo '$wgShowExceptionDetails = true;' >> LocalSettings.php
echo '$wgDevelopmentWarnings = true;' >> LocalSettings.php

