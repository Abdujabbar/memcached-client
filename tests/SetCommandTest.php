<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/31/18
 * Time: 11:10 AM
 */

class SetCommandTest extends \PHPUnit\Framework\TestCase
{
    public function testGenerate() {
        $message = "world";
        $key = "hello";
        $time = 30;
        $command = new \abdujabbor\memcached\commands\Set(['key' => $key, 'value' => $message, 'time' => $time]);
        $expected = sprintf("set %s %d %d %s\r\n%s\r\n", 'hello', 0, 30, mb_strlen($message), $message);
        $this->assertEquals(false, $command->hasError());
        $this->assertEquals($expected, $command->generate());
    }

    public function testArgumentException() {
        $this->expectException("\InvalidArgumentException");
        $command = new \abdujabbor\memcached\commands\Set([]);
    }

}