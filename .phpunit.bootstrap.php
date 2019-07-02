<?php
require_once('vendor/autoload.php');
// Add the 'tests/' directory to the include path for unit tests, as we have Test implementation classes that we need to
// have, but don't want to include in projects that include this library
$loader = new \Composer\Autoload\ClassLoader();
$loader->add('VladShut\\eCurring', ['src/']);
$loader->add('VladShut\\eCurring\Tests', ['tests/']);
$loader->register();
$loader->setUseIncludePath(true);
