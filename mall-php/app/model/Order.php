<?php
/**
 * File: Order.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\model;

use think\Model;
/**
 * 订单
 * Class Order
 * @property int    $order_id
 * @property string $title
 * @property double $price
 * @property int    $status
 * @property string $realname
 * @property string $phone
 * @property string $address
 * @property array  $snapshot
 * @property int    $created_at
 * @property int    $pay_at
 * @property int    $goods_id
 * @property int    $user_id
 */
class Order extends Model
{
    const STATUS_CREATED = 0; // 已下单
    const STATUS_PAYED = 1; // 已支付
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = false;

    protected $type = [
        'snapshot' => 'json',
        'pay_at' => 'timestamp'
    ];
}