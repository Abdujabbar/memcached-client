<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/23/18
 * Time: 11:24 AM
 */

namespace memcached\tcp;

use memcached\exceptions\CommandException;

class Socket
{
    protected $resource;
    protected $address;
    protected $port;
    protected $connected;
    protected $timeout;


    /**
     * Socket constructor.
     * @param $address
     * @param $port
     * @throws CommandException
     */
    public function __construct($address, $port)
    {
        $server = filter_var($address, FILTER_VALIDATE_IP);
        if (!$server) {
            throw new \InvalidArgumentException("Not valid ip address");
        }

        $port = filter_var($port, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 65536]]);
        if (!$port) {
            throw new \InvalidArgumentException("Not valid port number, port number must be an int and in range 0 <= port <= 65536");
        }

        $this->address = $address;
        $this->port = $port;

        $this->resource = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$this->resource) {
            throw new CommandException("socket_create", socket_strerror(socket_last_error()));
        }
    }

    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @throws CommandException
     */
    public function connect()
    {
        $this->connected = @socket_connect($this->resource, $this->address, $this->port);
        if (!$this->connected) {
            throw new CommandException("socket_connect", socket_strerror(socket_last_error()));
        }
    }

    public function isConnected()
    {
        return $this->connected;
    }

    public function close()
    {
        $this->connected = false;
        socket_close($this->resource);
    }


    public function write($buffer)
    {
        if ($this->connected) {
            socket_write($this->resource, $buffer, mb_strlen($buffer));
        }
        $outResult = [];
        while ($out = socket_read($this->resource, 2048)) {
            $outLines = array_map('trim', array_filter(explode("\r\n", $out)));
            $endLine = array_pop($outLines);
            $outResult = $outLines;
            if (in_array($endLine, $this->getEndlineCommands())) {
                break;
            }
        }
        return $outResult;
    }


    private function getEndlineCommands()
    {
        return ["END", "STORED", "NOT_STORED", "EXISTS", "NOT_FOUND", "DELETED", "ERROR", "OK"];
    }
}
