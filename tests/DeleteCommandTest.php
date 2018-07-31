<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/31/18
 * Time: 11:16 AM
 */

class DeleteCommandTest extends \PHPUnit\Framework\TestCase
{
    public function testGenerate()
    {
        $key = "hello";
        $command = new \abdujabbor\memcached\commands\Delete(['key' => $key]);
        $expected = sprintf("delete %s\r\n", $key);
        $this->assertEquals(false, $command->hasError());
        $this->assertEquals($expected, $command->generate());
    }


    public function testArgumentException() {
        $this->expectException("\InvalidArgumentException");
        $command = new \abdujabbor\memcached\commands\Delete([]);
    }
}