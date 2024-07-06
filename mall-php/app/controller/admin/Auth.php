<?php
/**
 * File: Auth.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\controller\admin;

use app\BaseController;
use app\service\admin\AdminService;

class Auth extends BaseController
{
    public function login()
    {
        if (request()->isPost()) {
            $data = $this->request->post();
            try {
                $this->validate($data, [
                    'username|账号' => 'require',
                    'password|密码' => 'require'
                ]);
                AdminService::Factory()->login($data['username'], $data['password']);
                return $this->success('登录成功', url('/admin.index/index'));
            } catch (\Exception $e) {
                return $this->error('用户名或密码错误');
            }
        }
        return view('login');
    }
}