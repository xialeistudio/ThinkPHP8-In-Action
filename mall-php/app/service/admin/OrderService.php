<?php
/**
 * File: OrderService.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\service\admin;

use app\model\Order;
use app\service\Service;
use Exception;
use think\db\exception\DbException;
use think\Paginator;

class OrderService extends Service
{
    /**
     * 订单列表
     * @param int $status
     * @param int $size
     * @return Paginator
     * @throws DbException
     */
    public function list($status = null, $size = 10)
    {
        $model = Order::query();
        if (isset($status)) {
            $model->where('status', $status);
        }
        $model->order(['order_id' => 'desc']);
        return $model->paginate([
            'list_rows' => $size,
            'query' => request()->get()
        ]);
    }

    /**
     * @param int $id
     * @return Order|null
     * @throws DbException
     * @throws Exception
     */
    public function show($id)
    {
        $order = Order::find($id);
        if (empty($order)) {
            throw new Exception('订单不存在');
        }
        return $order;
    }
}