<?php
/**
 * File: Goods.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\controller;

use app\BaseController;
use app\Request;
use app\service\GoodsService;

class Goods extends BaseController
{
    // 商品列表
    public function list(Request $request)
    {
        $this->userId();
        $list = GoodsService::Factory()->list($request->get('page', 1), $request->get('size', 10));
        return json($list);
    }

    // 查询商品详情
    public function show(Request $request)
    {
        $this->userId();
        $goods = GoodsService::Factory()->show($request->get('id'));
        return json($goods);
    }

    // 购买商品
    public function buy(Request $request)
    {
        $userId = $this->userId();
        $data = $request->post();
        $this->validate($data, [
            'goods_id' => 'require',
            'realname|姓名' => 'require',
            'phone|手机' => 'require',
            'address|地址' => 'require',
        ]);

        $order = GoodsService::Factory()->buy($data['goods_id'], $userId, $data);
        return json($order->toArray());
    }
}