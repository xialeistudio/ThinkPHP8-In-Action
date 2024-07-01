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
}