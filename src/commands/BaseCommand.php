<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/27/18
 * Time: 11:12 AM
 */

namespace memcached\commands;

class BaseCommand
{
    protected $args;
    protected $errors = [];
    protected $requiredArgs = [];
    const END_LINE = "\r\n";
    public function __construct(array $args = [])
    {
        $this->args = $this->filterArgs($args);
        if (!$this->validateArgs()) {
            throw new \InvalidArgumentException("Passed arguments are wrong");
        }
    }

    public function validateArgs(): bool
    {
        foreach ($this->requiredArgs as $attribute) {
            if (empty($this->args[$attribute])) {
                $this->errors[] = sprintf("Required attribute %s does not exists", $attribute);
            }
        }

        return !$this->hasError();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function hasError()
    {
        return count($this->errors);
    }

    public function filterArgs(array $args = [])
    {
        if (count($this->requiredArgs)) {
            $allowed = $this->requiredArgs;
            return array_filter(
                $args,
                function ($key) use ($allowed) {
                    return in_array($key, $allowed);
                },
                ARRAY_FILTER_USE_KEY
            );
        }
        return $args;
    }
}
