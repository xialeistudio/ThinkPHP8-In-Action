<?php
/**
 * File: Auth.php
 * User: xialeistudio
 * Date: 2024/7/3
 **/

namespace app\controller\admin;

use app\BaseController;
use app\service\AdminService;

class Auth extends BaseController
{
    public function signin()
    {
        if(request()->isPost()) {
            $data = request()->post();
            try {
                $this->validate($data, [
                    'username|账号' => 'require|max:20',
                    'password|密码' => 'require|max:20'
                ]);
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            try {
                $admin = AdminService::Factory()->login($data['username'], $data['password'], request()->ip());
                return $this->success('登录成功', '/admin');
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }
        return view('signin');
    }

    public function logout()
    {
        AdminService::Factory()->logout();
        return $this->success('退出成功', '/admin.auth/signin');
    }

    public function changepwd()
    {
        if(request()->isPost()) {
            $data = request()->post();
            try {
                $this->validate($data, [
                    'old_password|旧密码' => 'require',
                    'new_password|新密码' => 'require',
                    'confirm_password|确认密码' => 'require|confirm:new_password'
                ]);
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            try {
                AdminService::Factory()->changePassword($this->adminId(), $data['old_password'], $data['new_password']);
                return $this->success('修改成功', '/admin');
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }
        return view('changepwd');
    }
}