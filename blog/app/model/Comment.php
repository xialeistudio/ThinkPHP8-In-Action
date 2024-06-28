<?php
declare (strict_types=1);

namespace app\model;

use think\Model;

/**
 * @mixin \think\Model
 * @property integer $comment_id
 * @property string $content
 * @property integer $created_at
 * @property integer $post_id
 * @property integer $user_id
 */
class Comment extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = false;
    protected $pk = 'comment_id';

    /**
     * 所属用户
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * 所属文章
     * @return \think\model\relation\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }
}
