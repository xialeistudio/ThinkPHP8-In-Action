<?php
/**
 * File: User.php
 * User: xialeistudio
 * Date: 2024/7/1
 **/

namespace app\controller;

use app\BaseController;
use app\service\UserService;

class User extends BaseController
{
    public function index()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }

        $list = UserService::Factory()->list(30, request()->get('keyword'));
        return view('index', [
            'list' => $list->all(),
            'page' => $list->render()
        ]);
    }

    public function add()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        return view('add');
    }

    public function do_add()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $data = request()->post();
        try {
            $this->validate($data, [
                'realname|姓名' => 'require|max:20',
                'sex|性别' => 'require|in:1,2',
                'phone|手机号' => 'require|max:11'
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        UserService::Factory()->create($data);
        return $this->success('添加成功', '/user');
    }

    public function edit()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $userId = request()->get('id');
        try {
            $user = UserService::Factory()->findOne($userId);
            return view('edit', [
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return $this->error('用户不存在');
        }
    }

    public function do_edit()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $userId = request()->get('id');
        try {
            UserService::Factory()->findOne($userId);
        } catch (\Exception $e) {
            return $this->error('用户不存在');
        }
        $data = request()->post();
        try {
            $this->validate($data, [
                'realname|姓名' => 'require|max:20',
                'sex|性别' => 'require|in:1,2',
                'phone|手机号' => 'require|max:11'
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        UserService::Factory()->update($userId, $data);
        return $this->success('编辑成功', '/user');
    }
}