<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/23/18
 * Time: 11:02 AM
 */
namespace abdujabbor\memcached;

use abdujabbor\memcached\commands\Delete;
use abdujabbor\memcached\commands\FlushAll;
use abdujabbor\memcached\commands\Get;
use abdujabbor\memcached\commands\Set;
use abdujabbor\memcached\tcp\Socket;

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
     * @param string $server
     * @param int $port
     */
    public function __construct($server = "", $port = 11211)
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
     * @param string $input
     * @param int $time
     * @return bool
     */
    final public function set($key = "", $input = "", $time = 10)
    {
        $command = new Set(['key' => $key, 'value' => serialize($input), 'time' => $time]);
        $outLines = $this->socket->write($command->generate());
        return trim($outLines[count($outLines) - 1]) === "STORED";
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    final public function get($key = "")
    {
        $command = new Get(['key' => $key]);
        $outLines = $this->socket->write($command->generate());
        if (count($outLines) >= 2) {
            return unserialize($outLines[count($outLines) - 2]);
        }
        return null;
    }

    /**
     * @param string $key
     * @return bool
     * @throws \Exception
     */
    final public function delete($key = "")
    {
        $command = new Delete(['key' => $key]);
        $outLines = $this->socket->write($command->generate());
        if (count($outLines) > 0 && "DELETED" === trim($outLines[count($outLines) - 1])) {
            return true;
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
