<?php
/**
 * File: TopicScoreLog.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\model;

use think\Model;

/**
 * 主题积分日志
 * Class TopicScoreLog
 * @package app\model
 * @property int $log_id
 * @property int $score
 * @property string $msg
 * @property int $created_at
 * @property int $topic_id
 * @property int $user_id
 */
class TopicScoreLog extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = false;
}