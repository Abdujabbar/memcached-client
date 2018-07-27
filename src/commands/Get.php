<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/27/18
 * Time: 11:54 AM
 */

namespace memcached\commands;

class Get extends ICommand
{
    protected $requiredArgs = ['key'];
    public function generate(): string
    {
        return sprintf("get %s\r\n", $this->args['key']);
    }
}
