<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/30/18
 * Time: 10:34 AM
 */

namespace memcached\commands;

interface ICommand
{
    public function generate(): string;
}
