<?php
/**
 * File: Forum.php
 * User: xialeistudio
 * Date: 2024/7/3
 **/

namespace app\controller;

use app\BaseController;
use app\service\ForumAdminService;
use app\service\ForumService;
use app\service\TopicService;

class Forum extends BaseController
{
    public function show()
    {
        $id = request()->get('id');
        if (empty($id)) {
            return $this->error('参数错误');
        }
        $forum = ForumService::Factory()->show($id, \app\model\Forum::STATUS_VISIBLE);
        $admins = ForumAdminService::Factory()->listByForum($forum->forum_id);
        $topics = TopicService::Factory()->listWithUserByForum($forum->forum_id, 10);
        return view('show', [
            'forum' => $forum,
            'admins' => $admins,
            'topics' => $topics
        ]);
    }
}