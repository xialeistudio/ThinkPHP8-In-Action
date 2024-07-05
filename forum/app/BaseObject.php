<?php
/**
 * File: BaseObject.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app;
/**
 * Class BaseObject
 */
class BaseObject
{
    private static $_instances = [];

    /**
     * @return static
     */
    public final static function Factory()
    {
        if (!isset(self::$_instances[static::class])) {
            self::$_instances[static::class] = new static();
        }
        return self::$_instances[static::class];
    }
}