<?php
/**
 * File: TopicScoreLogService.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\service;

use app\BaseObject;
use app\model\TopicScoreLog;
use app\repository\TopicScoreLogRepository;

class TopicScoreLogService extends BaseObject
{
    /**
     * 写入帖子积分日志
     * @param int $adminId
     * @param int $topicId
     * @param int $score
     * @param string $msg
     * @return mixed|TopicScoreLog
     */
    public function log($adminId, $topicId, $score, $msg)
    {
        return TopicScoreLogRepository::Factory()->insert([
            'score' => $score,
            'msg' => $msg,
            'topic_id' => $topicId,
            'user_id' => $adminId
        ]);
    }
}