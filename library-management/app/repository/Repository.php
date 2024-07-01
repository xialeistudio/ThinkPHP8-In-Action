<?php
/**
 * File: Repository.php
 * User: xialeistudio
 * Date: 2024/6/30
 **/

namespace app\repository;

use think\Model;

class Repository extends AbstractRepository
{
    private $modelClass;

    /**
     * @var array 仓储 [模型类=>仓储实例]
     */
    private static $repositories = [];

    /**
     * Repository constructor.
     * @param $modelClass
     */
    private function __construct($modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * @param string $modelClass
     * @return AbstractRepository|mixed
     */
    public static function ModelFactory($modelClass)
    {
        if (!isset(self::$repositories[$modelClass])) {
            self::$repositories[$modelClass] = new Repository($modelClass);
        }
        return self::$repositories[$modelClass];

    }


    /**
     * 模型类
     * @return string|Model
     */
    protected function modelClass()
    {
        return $this->modelClass;
    }
}