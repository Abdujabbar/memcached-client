<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/27/18
 * Time: 11:54 AM
 */

namespace abdujabbor\memcached\commands;

class Get extends BaseCommand implements ICommand
{
    protected $requiredArgs = ['key'];
    public function generate(): string
    {
        return sprintf("get %s".self::END_LINE, $this->args['key']);
    }
}
