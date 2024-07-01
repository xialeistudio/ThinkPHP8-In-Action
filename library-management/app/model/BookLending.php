<?php
/**
 * File: BookLending.php
 * User: xialeistudio
 * Date: 2024/6/30
 **/

namespace app\model;

use think\Model;

/**
 * @property int $book_id
 * @property int $user_id
 * @property string $lending_date
 * @property string $should_return_date
 * @property int $return_at
 * @property int $created_at
 * @property int $updated_at
 * @property string $remark
 */
class BookLending extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id')->setEagerlyType(0);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id')->setEagerlyType(0);
    }
}