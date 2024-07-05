<?php
/**
 * File: TopicScoreLogRepository.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\repository;

use app\model\TopicScoreLog;
use app\service\Repository;
use think\Model;

class TopicScoreLogRepository extends Repository
{
    /**
     * 模型类
     * @return string|Model
     */
    protected function modelClass()
    {
        return TopicScoreLog::class;
    }
}