<?php
/**
 * File: Index.php
 * User: xialeistudio
 * Date: 2024/7/3
 **/

namespace app\controller;

use app\BaseController;
use app\model\Forum;
use app\service\ForumService;
use app\service\TopicService;
use app\service\UploadService;

class Index extends BaseController
{
    public function index()
    {
        $forums = ForumService::Factory()->all(Forum::STATUS_VISIBLE);
        $topics = TopicService::Factory()->listLatest(30);
        return view('index', [
            'title' => '首页',
            'forums' => $forums,
            'topics' => $topics
        ]);
    }

    public function upload()
    {
        if ($this->userId() == 0) {
            return json([
                'errcode' => 401,
                'errmsg' => '请先登录'
            ]);
        }
        $file = request()->file('file');
        if (empty($file)) {
            return json([
                'errcode' => 400,
                'errmsg' => '请上传文件'
            ]);
        }

        $savename = UploadService::Factory()->upload($file);
        return json([
            'errcode' => 0,
            'data' => $savename
        ]);
    }
}