<?php
/**
 * File: Topic.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * 主题表
 * Class Topic
 * @package app\model
 * @property int $topic_id
 * @property string $title
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property int $flag
 * @property int $top
 * @property int $reply_count
 * @property int $view_count
 * @property int $favorite_count
 * @property int $forum_id
 * @property int $user_id
 */
class Topic extends Model
{
    protected $pk = 'topic_id';
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    protected $deleteTime = 'deleted_at';

    const FLAG_REPLY_VISIBLE = 1 << 0;// 回复后可见(用户设置)

    /**
     * 判断是否回复可见
     * @return int
     */
    public function isReplyVisible()
    {
        return $this->flag & self::FLAG_REPLY_VISIBLE;
    }

    /**
     * 设置是否回复可见
     * @param bool $replyVisible
     */
    public function setReplyVisible($replyVisible)
    {
        $this->flag |= self::FLAG_REPLY_VISIBLE;
        if (!$replyVisible) {
            $this->flag ^= self::FLAG_REPLY_VISIBLE;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id', 'forum_id');
    }
}