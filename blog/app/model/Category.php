<?php
declare (strict_types=1);

namespace app\model;

use think\Model;

/**
 * @mixin \think\Model
 * @property integer $category_id
 * @property string $name
 * @property integer $status
 * @property integer $posts
 * @property integer $user_id
 */
class Category extends Model
{
    const STATUS_VISIBLE = 1; // 显示
    const STATUS_INVISIBLE = 0; // 隐藏

    protected $pk = 'category_id';

    /**
     * 文章
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
