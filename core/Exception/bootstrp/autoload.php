<?php
require 'Psr4Autoloader.php';
$classLoader = new Psr4Autoloader();
$classLoader -> register();
$classLoader ->addNamespace('brophp\core\Exception', dirname(dirname(__FILE__)).'/src/');

