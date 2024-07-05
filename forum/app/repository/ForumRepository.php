<?php
/**
 * File: ForumRepository.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\repository;

use app\model\Forum;
use app\service\Repository;
use think\Model;

class ForumRepository extends Repository
{
    /**
     * 模型类
     * @return string|Model
     */
    protected function modelClass()
    {
        return Forum::class;
    }
}