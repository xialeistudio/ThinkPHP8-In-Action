<?php
/**
 * File: Admin.php
 * User: xialeistudio
 * Date: 2024/6/30
 **/

namespace app\controller;

use app\BaseController;
use app\Request;
use app\service\AdminService;
use Exception;

class Admin extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function do_login(Request $request)
    {
        $errmsg = $this->validate($request->post(), [
            'username|账号' => 'require|max:20',
            'password|密码' => 'require|max:40'
        ]);
        if ($errmsg !== true) {
            return $this->error($errmsg);
        }
        try {
            AdminService::Factory()->login($request->post('username'), $request->post('password'), request()->ip());
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
        return redirect('/');
    }

    public function logout()
    {
        AdminService::Factory()->logout();
        return redirect('/');
    }

    public function changepwd()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        return view('changepwd');
    }

    public function do_changepwd()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $data = \request()->post();
        try {
            $this->validate($data, [
                'old_password|旧密码' => 'require|max:40',
                'new_password|新密码' => 'require|max:40',
                'confirm_password|确认密码' => 'require|confirm:new_password'
            ]);
            AdminService::Factory()->changePwd($this->adminId(), $data['old_password'], $data['new_password']);
            return $this->success('修改成功', '/');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}