<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/23/18
 * Time: 11:29 AM
 */

namespace abdujabbor\memcached\exceptions;

class CommandException extends \Exception
{
    protected $message = "Cannot run command %s, reason: %s";

    /**
     * CommandException constructor.
     * @param string $func
     * @param string $reason
     */
    public function __construct($func = "", $reason = "")
    {
        $this->message = sprintf($this->message, $func, $reason);
        parent::__construct($this->message, 0, null);
    }
}
