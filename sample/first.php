<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/23/18
 * Time: 2:49 PM
 */


require_once __DIR__ . DIRECTORY_SEPARATOR . "/../src/bootstrap.php";

try {
    $socketClient = new \memcached\Client("123.123.123.123", 11211);
    $socketClient->connect();
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
    die();
}


//
$obj = [1,2,3,4,5,6,7,8];
//
$socketClient->set("obj", $obj, 2);
//
$out = $socketClient->get("obj");
//
var_dump($out);
//
sleep(3);
//
//
var_dump($socketClient->get("obj"));
