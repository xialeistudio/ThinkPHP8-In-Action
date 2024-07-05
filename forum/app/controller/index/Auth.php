<?php
/**
 * File: Auth.php
 * User: xialeistudio
 * Date: 2024/7/3
 **/

namespace app\controller\index;

use app\BaseController;
use app\service\UserService;

class Auth extends BaseController
{
    public function signin()
    {
        if (request()->isPost()) {
            $data = request()->post();
            try {
                $this->validate($data, [
                    'username|账号' => 'require|alphaNum|max:20',
                    'password|密码' => 'require'
                ]);
                UserService::Factory()->login($data['username'], $data['password'], request()->ip());
                return $this->success('登录成功', url('/'));
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }
        return view('signin', [
            'title' => '登录'
        ]);
    }

    public function signup()
    {
        if (request()->isPost()) {
            $data = request()->post();
            try {
                $this->validate($data, [
                    'username|账号' => 'require|alphaNum|max:20',
                    'password|密码' => 'require',
                    'confirm_password|确认密码' => 'require|confirm:password'
                ]);
                UserService::Factory()->register($data['username'], $data['password']);
                return $this->success('注册成功', url('/index.auth/signin'));
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }
        return view('signup', [
            'title' => '注册'
        ]);
    }
}