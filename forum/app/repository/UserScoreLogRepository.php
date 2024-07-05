<?php
/**
 * File: UserScoreLogRepository.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\repository;

use app\model\UserScoreLog;
use app\service\Repository;
use think\Model;

class UserScoreLogRepository extends Repository
{
    /**
     * 模型类
     * @return string|Model
     */
    protected function modelClass()
    {
        return UserScoreLog::class;
    }
}