<?php
/**
 * File: Service.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\service;

class Service
{
    private static $_instances = [];

    /**
     * @return static|mixed
     */
    public static function Factory()
    {
        $className = get_called_class();
        if (isset(self::$_instances[$className])) {
            return self::$_instances[$className];
        }
        self::$_instances[$className] = new static();
        return self::$_instances[$className];
    }
}