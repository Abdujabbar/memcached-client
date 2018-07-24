<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/23/18
 * Time: 11:29 AM
 */

namespace memcached\exceptions;

class CommandException extends \Exception
{
    protected $message = "Cannot run command %s, reason: %s";
    public function __construct($func, $reason)
    {
        $this->message = sprintf($this->message, $func, $reason);
        parent::__construct($this->message, 0, null);
    }
}
