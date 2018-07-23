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
    protected $connection;

    /**
     * SocketStream constructor.
     * @param $address
     * @param $port
     * @throws CommandException
     */
    public function __construct($address, $port)
    {
        $this->address = $address;
        $this->port = $port;
        $this->resource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if(!$this->resource) {
            throw new CommandException("socket_create", socket_strerror(socket_last_error()));
        }
    }

    public function getResource() {
        return $this->resource;
    }

    /**
     * @throws CommandException
     */
    public function connect() {
        $this->connection = socket_connect($this->resource, $this->address, $this->port);
        if(!$this->connection) {
            throw new CommandException("socket_connect", socket_strerror(socket_last_error()));
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function close() {
        socket_close($this->resource);
    }


    public function write($buffer) {
        if($this->connection) {
            socket_write($this->resource, $buffer, mb_strlen($buffer));
        }
        $outResult = "";
        while($out = socket_read($this->resource, 2048)) {

            $outLines = array_map('trim', array_filter(explode("\r\n", $out)));
            $endLine = array_pop($outLines);

            $outResult .= implode("\n", $outLines);

            if(in_array($endLine, ["END", "STORED"])) {
                break;
            }

        }
        return $outResult;
    }
}