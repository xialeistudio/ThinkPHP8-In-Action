<?php
/**
 * File: User.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\controller;

use app\BaseController;
use app\Request;
use app\service\UserService;

class User extends BaseController
{
    // 授权
    public function oauth(Request $request)
    {
        $data = $request->post();
        $this->validate($data, [
            'code|授权码' => 'require',
            'nickname|昵称' => 'require',
            'avatar|头像' => 'require'
        ]);
        $user = UserService::Factory()->oauth($data);
        return json($user);
    }

    // 个人信息
    public function info()
    {
        $userId = $this->userId();
        $user =\app\model\User::find($userId);
        return json($user->toArray());
    }
}