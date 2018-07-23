<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/23/18
 * Time: 2:49 PM
 */


require_once __DIR__ . DIRECTORY_SEPARATOR . "/../src/bootstrap.php";


//$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//
//
//$connection = socket_connect($socket, "0.0.0.0", 11211);
//
//$command = "get hello\r\n";
//$res = socket_write($socket, $command, mb_strlen($command));
//
//var_dump($res);
//
//
//while($out = socket_read($socket, 2048)) {
//    if(trim($out) === "END") {
//        break;
//    }
//    var_dump($out);
//}




try {
    $socketClient = new \memcached\Client("0.0.0.0", 11211);
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
    die();
}

try {
    $socketClient->connect();
} catch (\memcached\exceptions\CommandException $e) {
    echo $e->getMessage() . "\n";
    die();
}


//$socketClient->set("hello", "world", 3600);
$out = $socketClient->get("hello");
var_dump($out);