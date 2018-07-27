<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/27/18
 * Time: 11:13 AM
 */

namespace memcached\commands;

class Set extends ICommand
{
    protected $requiredArgs = ['key', 'value', 'time'];
    public function generate(): string
    {
        if (!$this->hasError()) {
            return sprintf(
                "set %s %d %d %s\r\n",
                            $this->args['key'],
                         0,
                            $this->args['time'],
                            mb_strlen($this->args['value'])
            ) . "{$this->args['value']}\r\n";
        }
        return "";
    }
}
