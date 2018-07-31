<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/31/18
 * Time: 11:18 AM
 */

class GetCommandTest extends \PHPUnit\Framework\TestCase
{
    public function testGeneration() {
        $key = "hello";
        $command = new \abdujabbor\memcached\commands\Get(['key' => $key]);
        $expected = sprintf("get %s\r\n", $key);
        $this->assertEquals(false, $command->hasError());
        $this->assertEquals($expected, $command->generate());
    }
}