<?php
/**
 * File: OrderService.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\service;

use app\model\Order;
use Exception;
use PDOStatement;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Db;

class OrderService extends Service
{
    /**
     * 支付
     * @param int $orderId
     * @param int $userId
     * @return Order
     */
    public function pay($orderId, $userId)
    {
        return Db::transaction(function () use ($userId, $orderId) {
            /** @var Order $order */
            $order = Order::where('order_id', $orderId)->lock(true)->find();

            if (empty($order) || $order->user_id != $userId) {
                throw new Exception('订单不存在', 404);
            }
            if ($order->status != Order::STATUS_CREATED) {
                throw new Exception('订单状态错误', 400);
            }
            $order->status = Order::STATUS_PAYED;
            $order->pay_at = time();
            if (!$order->save()) {
                throw new Exception('支付失败');
            }
            return $order;
        });
    }

    /**
     * 订单列表
     * @param int $userId
     * @param int $page
     * @param int $size
     * @return false|PDOStatement|string|Collection
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException|\think\db\exception\DbException
     */
    public function list($userId, $page = 1, $size = 10)
    {
        $query = Order::query();
        $query->where('user_id', $userId)->order(['order_id' => 'desc']);
        $query->page($page, $size);
        return $query->select();
    }

    /**
     * @param int $orderId
     * @param int $userId
     * @return Order|null
     * @throws DbException
     * @throws Exception
     */
    public function show($orderId, $userId)
    {
        $order = Order::where(['order_id' => $orderId, 'user_id' => $userId])->find();
        if (empty($order)) {
            throw new Exception('订单不存在');
        }
        return $order;
    }
}