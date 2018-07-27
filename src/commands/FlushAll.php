<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/27/18
 * Time: 11:57 AM
 */

namespace memcached\commands;

class FlushAll extends ICommand
{
    public function generate(): string
    {
        return sprintf("flush_all\r\n");
    }
}
