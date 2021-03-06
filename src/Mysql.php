<?php

namespace Mattbit\MysqlCompat;

/**
 * Class Mysql
 * Provides a facade to access the Mysql functions using a Manager singleton.
 */
class Mysql
{
    /**
     * The database manager service.
     *
     * @var Bridge
     */
    private static $bridge;

    /**
     * Forward static calls to the manager singleton.
     *
     * @param  $method
     * @param  $args
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        if (self::$bridge === null) {
            $manager = new Manager(new ConnectionFactory());
            self::$bridge = new Bridge($manager);
        }

        return call_user_func_array([self::$bridge, $method], $args);
    }

    /**
     * Defines the old global functions and constants.
     *
     * @return void
     */
    public static function defineGlobals()
    {
        require_once __DIR__ . '/globals.php';
    }
}
