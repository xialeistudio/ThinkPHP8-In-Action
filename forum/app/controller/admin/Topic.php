<?php
/**
 * File: Topic.php
 * User: xialeistudio
 * Date: 2024/7/3
 **/

namespace app\controller\admin;

use app\BaseController;
use app\service\ForumService;
use app\service\TopicService;

class Topic extends BaseController
{
    public function index()
    {
        $forumId = request()->get('forum_id');
        $keyword= request()->get('keyword');
        $list = TopicService::Factory()->listWithUserWithForum($forumId, $keyword);
        $forums = ForumService::Factory()->all();
        return view('index', [
            'list' => $list,
            'forums' => $forums
        ]);
    }
}