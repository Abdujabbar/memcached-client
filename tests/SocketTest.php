<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/24/18
 * Time: 4:04 PM
 */

class SocketTest extends \PHPUnit\Framework\TestCase
{
    protected $validAddress = "127.0.0.1";
    protected $validPort = 11211;


    public function testServerAddress()
    {
        $this->expectExceptionMessage("Not valid ip address");
        $invalidAddress = "dnsjakdnsjka";
        $socket = new \memcached\tcp\Socket($invalidAddress, $this->validPort);
    }

    public function testServerPort()
    {
        $this->expectExceptionMessage("Not valid port number, port number must be an int and in range 0 <= port <= 65536");
        $invalidPort = -123;
        $socket = new \memcached\tcp\Socket($this->validAddress, $invalidPort);
    }

    public function testResource()
    {
        try {
            $socket = new \memcached\tcp\Socket($this->validAddress, $this->validPort);
            $socket->connect();
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            die();
        }
        $this->assertEquals(true, is_resource($socket->getResource()));
    }


    public function testConnectAndClose()
    {
        try {
            $socket = new \memcached\tcp\Socket($this->validAddress, $this->validPort);
            $socket->connect();
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            die();
        }
        $this->assertEquals(true, $socket->isConnected());
        $socket->close();
        $this->assertEquals(false, $socket->isConnected());
    }
}
