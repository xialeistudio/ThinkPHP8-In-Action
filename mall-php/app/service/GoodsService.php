<?php
/**
 * File: GoodsService.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\service;

use app\model\Goods;
use app\model\Order;
use Exception;
use PDOStatement;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Db;

/**
 * Class GoodsService
 * @package app\index\service
 */
class GoodsService extends Service
{
    /**
     * 数据列表
     * @param int $page
     * @param int $size
     * @return false|PDOStatement|string|Collection
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function list($page = 1, $size = 10)
    {
        $query = Goods::query();
        $query->order(['id' => 'desc']);
        $query->page($page, $size);
        return $query->select();
    }

    /**
     * 商品详情
     * @param int $id
     * @return Goods|null
     * @throws DbException
     * @throws Exception
     */
    public function show($id)
    {
        $goods = Goods::find($id);
        if (empty($goods)) {
            throw new Exception('商品不存在', 404);
        }
        return $goods;
    }

    /**
     * 购买
     * @param int   $goodsId
     * @param int   $userId
     * @param array $data
     * @return Order
     */
    public function buy($goodsId, $userId, array $data)
    {
        return Db::transaction(function () use ($goodsId, $userId, $data) {
            /** @var Goods $goods */
            $goods = Goods::where('id', $goodsId)->lock(true)->find();
            if (empty($goods)) {
                throw new Exception('商品不存在');
            }
            if ($goods->stock < 1) {
                throw new Exception('库存不足');
            }
            $goods->stock--;
            if (!$goods->save()) {
                throw new Exception('购买失败');
            }

            $orderData = [
                'title' => $goods->title,
                'price' => $goods->price,
                'status' => Order::STATUS_CREATED,
                'realname' => $data['realname'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'snapshot' => $goods->toJson(),
                'goods_id' => $goodsId,
                'user_id' => $userId
            ];
            $order = new Order();
            $order->data($orderData);
            if (!$order->save()) {
                throw new Exception('购买失败');
            }
            return $order;
        });
    }
}