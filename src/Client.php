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
     * @throws \Exception
     */
    public function __construct($server, $port)
    {
//        $server = filter_var($server, FILTER_FLAG_IPV4);
//        if(!$server) {
//            throw new \Exception("Not valid ip address");
//        }

        $port = filter_var($port, FILTER_VALIDATE_INT);
        if(!$port) {
            throw new \Exception("Not valid port number, port number must be an int");
        }

        $this->server = $server;
        $this->port = $port;
    }



    /**
     * @throws exceptions\CommandException
     */
    final public function connect() {

        $this->socket = new Socket($this->server, $this->port);

        $this->socket->connect();

    }


    final public function set(string $key, $input, int $time) {
        return $this->socket->write($this->buildSetCommand($key, $input, $time));
    }

    final public function get($key) {
        return $this->socket->write($this->buildGetCommand($key));
    }

    final public function delete($key) {

    }

    private function  buildSetCommand(string $key, $input, int $time) {
        $buffer = serialize($input);
        return sprintf("set %s %d %d %s", $key, 0, $time, mb_strlen($buffer)) . "\r\n{$buffer}\r\n";
    }

    private function buildGetCommand($key) {
        return "get {$key}\r\n";
    }

    private function buildDeleteCommand($key) {
        return "delete {$key}";
    }

}