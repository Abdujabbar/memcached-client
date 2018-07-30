<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/27/18
 * Time: 11:56 AM
 */

namespace memcached\commands;

class Delete extends BaseCommand implements ICommand
{
    protected $requiredArgs = ['key'];
    public function generate(): string
    {
        return sprintf("delete %s".self::END_LINE, $this->args['key']);
    }
}
