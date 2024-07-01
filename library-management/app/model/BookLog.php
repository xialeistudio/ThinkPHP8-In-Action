<?php
/**
 * File: BookLog.php
 * User: xialeistudio
 * Date: 2024/6/30
 **/

namespace app\model;

use think\Model;

/**
 * @property int $log_id
 * @property int $action
 * @property string $msg
 * @property int $created_at
 * @property string $created_ip
 * @property mixed $params
 * @property int $book_id
 */
class BookLog extends Model
{
    protected $pk = 'log_id';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = false;
    const ACTION_STORAGE = 1; // 入库
    const ACTION_LEND = 2; // 借出
    const ACTION_RETURN = 3; // 归还
    const ACTION_UPDATE = 4; // 编辑书籍

    protected $json = ['params'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }
}