<?php
/**
 * File: Address.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\controller;

use app\BaseController;
use app\Request;
use app\service\AddressService;
use Exception;

class Address extends BaseController
{
    // 添加地址
    public function create(Request $request)
    {
        $userId = $this->userId();
        $data = $request->post();
        $this->validate($data, [
            'realname|姓名' => 'require',
            'phone|手机号码' => 'require',
            'address|地址' => 'require'
        ]);
        AddressService::Factory()->create($data, $userId);
        return json([
            'errcode' => 0,
            'errmsg' => 'ok'
        ]);
    }

    // 所有地址
    public function all()
    {
        $userId = $this->userId();
        $list = AddressService::Factory()->all($userId);
        return json($list);
    }

    // 查询地址
    public function show(Request $request)
    {
        $userId = $this->userId();
        $data = AddressService::Factory()->show($request->param('id'), $userId);
        return json($data);
    }

    // 编辑地址
    public function update(Request $request)
    {
        $userId = $this->userId();
        $data = $request->post();
        $this->validate($data, [
            'id' => 'require',
            'realname|姓名' => 'require',
            'phone|手机号码' => 'require',
            'address|地址' => 'require'
        ]);
        AddressService::Factory()->update($data['id'], $data, $userId);
        return json([
            'errcode' => 0,
            'errmsg' => 'ok'
        ]);
    }

    // 删除地址
    public function delete(Request $request)
    {
        $userId = $this->userId();
        AddressService::Factory()->delete($request->get('id'), $userId);
        return json([
            'errcode' => 0,
            'errmsg' => 'ok'
        ]);
    }
}