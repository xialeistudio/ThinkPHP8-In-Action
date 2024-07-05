<?php
/**
 * File: User.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\service;

use app\BaseObject;
use app\repository\UserScoreLogRepository;
use think\Model;

class UserScoreLogService extends BaseObject
{
    /**
     * 添加积分(score为负数时减少积分)
     * @param int $userId
     * @param int $score
     * @param int $remain
     * @param string $msg
     * @return mixed|Model
     */
    public function log($userId, $score, $remain, $msg)
    {
        $log = [
            'score' => $score,
            'remain' => $remain,
            'msg' => $msg,
            'user_id' => $userId,
        ];
        return UserScoreLogRepository::Factory()->insert($log);
    }
}