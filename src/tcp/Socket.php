<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/23/18
 * Time: 11:24 AM
 */

namespace abdujabbor\memcached\tcp;

use abdujabbor\memcached\exceptions\CommandException;

class Socket
{
    /**
     * @var $resource
     */
    protected $resource;
    protected $address;
    protected $port;
    protected $timeout;


    /**
     * Socket constructor.
     * @param string $address
     * @param int $port
     * @throws CommandException
     */
    public function __construct($address = "", $port = 11211)
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
        $this->resource = @fsockopen($server, $port);

        if (!$this->resource) {
            throw new CommandException("fsockopen", socket_strerror(socket_last_error()));
        }
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }


    /**
     * @void
     */
    public function close()
    {
        fclose($this->resource);
    }

    /**
     * @param string $buffer
     * @return array
     */
    public function write($buffer = "")
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

    /**
     * @return array
     */
    private function getEndlineCommands()
    {
        return ["END", "STORED", "NOT_STORED", "EXISTS", "NOT_FOUND", "DELETED", "ERROR", "OK"];
    }
}
