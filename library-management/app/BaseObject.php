<?php
/**
 * File: BaseObject.php
 * User: xialeistudio
 * Date: 2024/6/30
 **/

namespace app;

class BaseObject
{
    private static $_instances = [];

    /**
     * @return static
     */
    public static function Factory()
    {
        if (!isset(self::$_instances[static::class])) {
            self::$_instances[static::class] = new static();
        }
        return self::$_instances[static::class];
    }
}