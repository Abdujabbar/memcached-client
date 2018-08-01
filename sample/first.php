<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/23/18
 * Time: 2:49 PM
 */


require_once __DIR__ . DIRECTORY_SEPARATOR . "/../vendor/autoload.php";

try {
    $socketClient = new abdujabbor\memcached\Client("127.0.0.1", 11211);
    $socketClient->connect();
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
    die();
}


try {
    $socketClient->delete("hello");
} catch (Exception $e) {
    echo $e->getMessage();
}