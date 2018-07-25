<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/23/18
 * Time: 11:02 AM
 */
namespace memcached;

use memcached\tcp\Socket;

class Client
{
    /**
     * @var $socket Socket
     */
    protected $socket;
    /**
     * @var $server string
     */
    protected $server;
    /**
     * @var $port integer
     */
    protected $port;

    /**
     * Client constructor.
     * @param $server
     * @param $port
     */
    public function __construct($server, $port)
    {
        $this->server = $server;
        $this->port = $port;
    }


    /**
     * @throws \Exception
     * @throws exceptions\CommandException
     */
    final public function connect()
    {
        $this->socket = new Socket($this->server, $this->port);

        $this->socket->connect();
    }

    /**
     * @param string $key
     * @param $input
     * @param int $time
     * @return array
     */
    final public function set(string $key, $input, int $time)
    {
        return $this->socket->write($this->buildSetCommand($key, $input, $time));
    }

    /**
     * @param $key
     * @return mixed|null
     */
    final public function get($key)
    {
        $out = $this->socket->write($this->buildGetCommand($key));
        if (count($out) > 0) {
            return unserialize($out[count($out) - 1]);
        }
        return null;
    }

    /**
     * @param $key
     * @return array
     */
    final public function delete($key)
    {
        return $this->socket->write($this->buildDeleteCommand($key));
    }

    /**
     * @return void
     */
    final public function flush()
    {
        $this->socket->write($this->buildFlushCommand());
    }

    /**
     * @param string $key
     * @param $input
     * @param int $time
     * @return string
     */
    private function buildSetCommand(string $key, $input, int $time)
    {
        $buffer = serialize($input);
        return sprintf("set %s %d %d %s", $key, 0, $time, mb_strlen($buffer)) . "\r\n{$buffer}\r\n";
    }

    /**
     * @param $key
     * @return string
     */
    protected function buildGetCommand($key)
    {
        return "get {$key}\r\n";
    }

    /**
     * @param $key
     * @return string
     */
    protected function buildDeleteCommand($key)
    {
        return "delete {$key}\r\n";
    }

    /**
     * @return string
     */
    protected function buildFlushCommand()
    {
        return "flush_all\r\n";
    }
}
