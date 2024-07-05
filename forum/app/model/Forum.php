<?php
/**
 * File: Forum.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\model;

use think\Model;

/**
 * 版块表
 * Class Forum
 * @package app\model
 * @property int $forum_id
 * @property string $title
 * @property string $logo
 * @property string $desc
 * @property  int $topic_count
 * @property int $thread_count
 * @property int $status
 * @property int $created_at
 */
class Forum extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = false;

    const STATUS_VISIBLE = 1;
    const STATUS_INVISIBLE = 0;
}