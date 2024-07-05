<?php
/**
 * File: Index.php
 * User: xialeistudio
 * Date: 2024/7/5
 **/

namespace app\controller\user;

use app\BaseController;
use app\Request;
use app\service\TopicService;
use app\service\UploadService;
use app\service\UserService;

class Index extends BaseController
{
    public function index()
    {
        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        $topics = TopicService::Factory()->listWithForumByUser($this->userId());
        return view('index', ['topics' => $topics]);
    }

    public function profile()
    {
        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        $user = UserService::Factory()->show($this->userId());
        return view('profile', ['user' => $user]);
    }

    public function do_profile(Request $request)
    {
        $data = array_filter($request->post());
        try {
            $this->validate($data, [
                'nickname|昵称' => 'require|max:20'
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        try {
            $avatar = $request->file('avatar');
            if (!empty($avatar)) {
                $data['avatar'] = UploadService::Factory()->upload($avatar);
            }
        } catch (\Exception $e) {

        }
        UserService::Factory()->updateProfile($this->userId(), $data);
        return $this->success('操作成功', url('/user.index/profile'));
    }
}