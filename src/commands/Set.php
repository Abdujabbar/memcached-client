<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/27/18
 * Time: 11:13 AM
 */

namespace abdujabbor\memcached\commands;

class Set extends BaseCommand implements ICommand
{
    protected $requiredArgs = ['key', 'value', 'time'];
    public function generate(): string
    {
        if (!$this->hasError()) {
            return sprintf(
                "set %s %d %d %s".self::END_LINE,
                            $this->args['key'],
                         0,
                            $this->args['time'],
                            mb_strlen($this->args['value'])
            ) . "{$this->args['value']}".self::END_LINE;
        }
        return "";
    }
}
