<?php
/**
 * File: Forum.php
 * User: xialeistudio
 * Date: 2024/7/3
 **/

namespace app\controller\admin;

use app\BaseController;
use app\service\ForumAdminService;
use app\service\ForumService;
use app\service\UploadService;
use app\service\UserService;

class Forum extends BaseController
{
    public function index()
    {
        if ($this->adminId() == 0) {
            return $this->adminLoginRequired();
        }
        $list = ForumService::Factory()->all();
        return view('index', [
            'list' => $list
        ]);
    }

    public function add()
    {
        if ($this->adminId() == 0) {
            return $this->adminLoginRequired();
        }
        if (request()->isPost()) {
            $data = request()->post();
            try {
                $this->validate($data, [
                    'title|标题' => 'require|max:20',
                    'desc|简介' => 'require|max:100'
                ]);
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            $logo = request()->file('logo');
            if (empty($logo)) {
                return $this->error('请上传logo');
            }
            $data['logo'] = UploadService::Factory()->upload($logo);
            ForumService::Factory()->add($data);
            return $this->success('添加成功', '/admin.forum/index');
        }
        return view('add');
    }

    public function update()
    {
        if ($this->adminId() == 0) {
            return $this->adminLoginRequired();
        }
        $forumId = request()->get('id');
        if (empty($forumId)) {
            return $this->error('参数错误');
        }
        if (request()->isPost()) {
            $data = request()->post();
            try {
                $this->validate($data, [
                    'title|标题' => 'require|max:20',
                    'desc|简介' => 'require|max:100'
                ]);
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            try {
                $logo = request()->file('logo');
                if (!empty($logo)) {
                    $data['logo'] = UploadService::Factory()->upload($logo);
                }
            } catch (\Exception $e) {
                // 未上传文件会抛异常，此处忽略
            }
            ForumService::Factory()->update($forumId, $data);
            return $this->success('编辑成功', '/admin.forum/index');
        }
        $forum = ForumService::Factory()->show($forumId);
        return view('update', [
            'forum' => $forum
        ]);
    }

    public function admins()
    {
        if ($this->adminId() == 0) {
            return $this->adminLoginRequired();
        }
        $id = request()->get('id');
        if (empty($id)) {
            return $this->error('参数错误');
        }
        $list = ForumAdminService::Factory()->listByForum($id);
        return view('admins', [
            'list' => $list->all()
        ]);
    }

    public function bind_admin()
    {
        if ($this->adminId() == 0) {
            return $this->adminLoginRequired();
        }
        $id = request()->get('id');
        if (empty($id)) {
            return $this->error('参数错误');
        }
        $adminIds = ForumAdminService::Factory()->getAllAdminIdByForum($id);
        $users = UserService::Factory()->listWithout($adminIds, 30);
        return view('bind_admin', [
            'users' => $users
        ]);
    }

    public function do_bindadmin()
    {
        if ($this->adminId() == 0) {
            return $this->adminLoginRequired();
        }
        $id = request()->get('id');
        $userId = request()->get('user_id');
        if (empty($id) || empty($userId)) {
            return $this->error('参数错误');
        }
        try {
            ForumAdminService::Factory()->bind($userId, $id);
            return $this->success('添加成功', '/admin.forum.admins?id=' . $id);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function unbind_admin()
    {
        if ($this->adminId() == 0) {
            return $this->adminLoginRequired();
        }
        $id = request()->get('id');
        $userId = request()->get('user_id');
        if (empty($id) || empty($userId)) {
            return $this->error('参数错误');
        }
        try {
            ForumAdminService::Factory()->unbind($userId, $id);
            return $this->success('移除成功', '/admin.forum.admins?id=' . $id);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}