<?php
/**
 * File: ForumAdmin.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\model;

use think\Model;

/**
 * 版主表
 * Class ForumAdmin
 * @package app\common\model
 * @property int $user_id
 * @property int $forum_id
 * @property int $created_at
 * @property int $expired_at
 */
class ForumAdmin extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}