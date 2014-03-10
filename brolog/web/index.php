<?php
require '../bootstrp/autoload.php';
use brophp\brolog\handler\FileHandle;
use brophp\brolog\Logger;

try{
    $logger = new Logger(new FileHandle());
    $logger -> alert('aaaaa');
}catch(Exception $e){
    echo $e->getMessage();
}