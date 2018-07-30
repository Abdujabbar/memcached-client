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
    }

    /**
     * @param string $key
     * @param $input
     * @param int $time
     * @return bool
     */
    final public function set(string $key, $input, int $time)
    {
        $command = new Set(['key' => $key, 'value' => serialize($input), 'time' => $time]);
        $outLines = $this->socket->write($command->generate());
        return trim($outLines[count($outLines) - 1]) === "STORED";
    }

    /**
     * @param $key
     * @return mixed|null
     */
    final public function get($key)
    {
        $command = new Get(['key' => $key]);
        $outLines = $this->socket->write($command->generate());
        if (count($outLines) >= 2) {
            return unserialize($outLines[count($outLines) - 2]);
        }
        return null;
    }

    /**
     * @param $key
     * @return bool
     * @throws \Exception
     */
    final public function delete($key)
    {
        $command = new Delete(['key' => $key]);
        $outLines = $this->socket->write($command->generate());
        if (count($outLines) > 0) {
            return "DELETED" === trim($outLines[count($outLines) - 1]);
        }
        throw new \Exception(implode("\n", $outLines));
    }

    /**
     * @return bool
     */
    final public function flush()
    {
        $command = new FlushAll();
        $outLines =  $this->socket->write($command->generate());
        return $outLines[count($outLines) - 1] === "OK";
    }
}
