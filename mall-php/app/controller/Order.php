<?php
/**
 * File: Order.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\controller;

use app\BaseController;
use app\Request;
use app\service\OrderService;

class Order extends BaseController
{
    // 支付
    public function pay(Request $request)
    {
        $userId = $this->userId();
        $order = OrderService::Factory()->pay($request->get('order_id'), $userId);
        return json($order->toArray());
    }

    // 订单列表
    public function list(Request $request)
    {
        $userId = $this->userId();
        $list = OrderService::Factory()->list($userId, $request->get('page', 1), $request->get('size', 10));
        return json($list);
    }

    // 订单详情
    public function show(Request $request)
    {
        $userId = $this->userId();
        $order = OrderService::Factory()->show($request->get('id'), $userId);
        return json($order->toArray());
    }
}