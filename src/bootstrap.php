<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/23/18
 * Time: 2:24 PM
 */

class AutoLoader
{
    public static function loader($class = "")
    {
        $file =  str_replace("\\", "/", str_replace("memcached\\", "", $class));
        $ext = ".php";
        if (file_exists(__DIR__ .DIRECTORY_SEPARATOR. $file . $ext)) {
            require_once __DIR__ .DIRECTORY_SEPARATOR. $file . $ext;
        }
        return false;
    }
}

spl_autoload_register("AutoLoader::loader");
