<?php
/**
 * File: User.php
 * User: xialeistudio
 * Date: 2024/6/28
 **/

namespace app\controller;

use app\BaseController;
use app\service\CategoryService;
use app\service\PostService;
use app\service\UserService;
use think\exception\ValidateException;

class User extends BaseController
{

    public function index(UserService $service, PostService $postService, CategoryService $categoryService)
    {
        if ($service->isGuest()) {
            return $service->loginRequired();
        }
        $userId = $service->userId();
        $post = $postService->getListByUser($userId);
        return view('', [
            'title' => '用户中心',
            'postList' => $post->all(),
            'postPager' => $post->render()
        ]);
    }

    public function logout(UserService $service)
    {
        $service->logout();
        return redirect('/');
    }

    public function signin(UserService $service)
    {
        if (request()->isPost()) {
            $data = request()->post();
            try {
                $this->validate($data, [
                    'captcha|验证码' => 'require|captcha',
                    'username|账号' => 'require|alphaNum|max:40',
                    'password|密码' => 'require',
                ]);
                $service->signin($data['username'], $data['password']);
                return redirect('/user/index');
            } catch (ValidateException $e) {
                return view('signin', [
                    'title' => '用户登录',
                    'error' => $e->getError()
                ]);
            }
        }
        return view('signin', [
            'title' => '用户登录'
        ]);
    }

    public function signup(UserService $service)
    {
        if (request()->isPost()) {
            $data = request()->post();
            try {
                $this->validate($data, [
                    'captcha|验证码' => 'require|captcha',
                    'username|账号' => 'require|alphaNum|max:40',
                    'password|密码' => 'require',
                    'password2|确认密码' => 'require'
                ]);
                if ($data['password'] != $data['password2']) {
                    throw new ValidateException('两次输入的密码不一致');
                }
                $service->signup($data['username'], $data['password']);
                $service->signin($data['username'], $data['password']);
                return redirect('/user/index');
            } catch (ValidateException $e) {
                return view('signup', [
                    'title' => '用户注册',
                    'error' => $e->getError()
                ]);
            }
        }
        return view('signup', [
            'title' => '用户注册'
        ]);
    }

    public function change_password(UserService $service)
    {
        if ($service->isGuest()) {
            return $service->loginRequired();
        }
        if (request()->isPost()) {
            $data = request()->post();
            try {
                $this->validate($data, [
                    'password|密码' => 'require',
                    'password2|确认密码' => 'require'
                ]);
                if ($data['password'] != $data['password2']) {
                    throw new ValidateException('两次输入的密码不一致');
                }
                $service->changePassword($service->userId(), $data['password']);
                return  $this->success('修改成功',url('/user'));
            } catch (ValidateException $e) {
                return view('change_password', [
                    'title' => '修改密码',
                    'error' => $e->getError()
                ]);
            }
        }
        return view('change_password', [
            'title' => '修改密码'
        ]);
    }

}