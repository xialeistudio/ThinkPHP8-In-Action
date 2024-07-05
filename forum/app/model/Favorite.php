<?php
/**
 * File: Favorite.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\model;

use think\Model;

/**
 * 收藏表
 * Class Favorite
 * @package app\model
 * @property int $user_id
 * @property int $topic_id
 * @property int $created_at
 */
class Favorite extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = false;

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'topic_id')
            ->withoutField('content');
    }
}