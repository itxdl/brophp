<?php
require 'Psr4Autoloader.php';
$classLoad = new Psr4Autoloader();
$classLoad -> register();
$path = __DIR__.'/../src';
$classLoad -> addNamespace('brophp\brolog',$path);
