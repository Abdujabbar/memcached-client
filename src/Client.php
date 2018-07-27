<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/23/18
 * Time: 11:02 AM
 */
namespace memcached;

use memcached\commands\Delete;
use memcached\commands\FlushAll;
use memcached\commands\Get;
use memcached\commands\Set;
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
        try {
            $command = new Set(['key' => $key, 'value' => serialize($input), 'time' => $time]);
            return $this->socket->write($command->generate());
        } catch (\Exception $e) {
            echo $e->getMessage() . "\r\n";
            die();
        }
    }

    /**
     * @param $key
     * @return mixed|null
     */
    final public function get($key)
    {
        try {
            $command = new Get(['key' => $key]);
            $out = $this->socket->write($command->generate());
            if (count($out) > 0) {
                return unserialize($out[count($out) - 1]);
            }
        } catch (\Exception $e) {
            echo $e->getMessage(). "\r\n";
            die();
        }
        return null;
    }

    /**
     * @param $key
     * @return array
     */
    final public function delete($key)
    {
        try {
            $command = new Delete(['key' => $key]);
            return $this->socket->write($command->generate());
        } catch (\Exception $exception) {
            echo $exception->getMessage() . "\r\n";
            die();
        }
    }

    /**
     * @return array
     */
    final public function flush()
    {
        try {
            $command = new FlushAll();
            return $this->socket->write($command->generate());
        } catch (\Exception $exception) {
            echo $exception->getMessage() . "\r\n";
            die();
        }
    }
}
