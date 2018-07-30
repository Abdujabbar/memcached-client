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

        $port = filter_var(
                        $port,
                  FILTER_VALIDATE_INT,
                        ['options' => ['min_range' => 1, 'max_range' => 65536]]
        );
        if (!$port) {
            throw new \InvalidArgumentException("Not valid port number,".
                            "port number must be an int and in range 0 <= port <= 65536");
        }

        $this->address = $address;
        $this->port = $port;
        $p = null;
        $this->resource = @fsockopen($server, $port, $p, $p, 1);
        if (!$this->resource) {
            throw new CommandException("socket_create", socket_strerror(socket_last_error()));
        }
    }

    public function getResource()
    {
        return $this->resource;
    }



    public function close()
    {
        fclose($this->resource);
    }


    public function write($buffer)
    {
        fwrite($this->resource, $buffer);
        $outLines = [];
        while (($line = fgets($this->resource))) {
            $outLines[] = trim($line);
            if (in_array(trim($line), $this->getEndlineCommands())) {
                break;
            }
        }
        return $outLines;
    }


    private function getEndlineCommands()
    {
        return ["END", "STORED", "NOT_STORED", "EXISTS", "NOT_FOUND", "DELETED", "ERROR", "OK"];
    }
}
