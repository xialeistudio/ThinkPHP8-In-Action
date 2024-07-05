<?php
/**
 * File: UserScoreLog.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\model;

use think\Model;

/**
 * 用户积分日志
 * Class UserScoreLog
 * @package app\model
 * @property int $log_id
 * @property int $remain
 * @property string $msg
 * @property int $created_at
 * @property int $user_id
 */
class UserScoreLog extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = false;
}