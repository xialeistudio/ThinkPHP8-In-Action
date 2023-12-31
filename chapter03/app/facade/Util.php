<?php
namespace app\facade;

use think\Facade;

/**
 * @method foo($bar)
 */
class Util extends Facade
{
    protected static function getFacadeClass()
    {
        return \app\common\Util::class;
    }
}