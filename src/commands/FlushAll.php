<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/27/18
 * Time: 11:57 AM
 */

namespace abdujabbor\memcached\commands;

class FlushAll extends BaseCommand implements ICommand
{
    public function generate(): string
    {
        return sprintf("flush_all".self::END_LINE);
    }
}
