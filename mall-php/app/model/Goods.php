<?php
/**
 * File: Goods.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * 商品
 * Class Goods
 * @property int $id
 * @property string $title
 * @property string $thumb
 * @property string $description
 * @property double $price
 * @property int $stock
 * @property int $status
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 */
class Goods extends Model
{
    const STATUS_ONLINE = 1; // 上架
    const STATUS_OFFLINE = 0; // 下架

    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}