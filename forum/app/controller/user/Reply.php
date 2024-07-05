<?php
/**
 * File: Reply.php
 * User: xialeistudio
 * Date: 2024/7/5
 **/

namespace app\controller\user;

use app\BaseController;
use app\repository\ReplyService;

class Reply extends BaseController
{
    /**
     * 回复列表
     * @return mixed
     * @throws DbException
     */
    public function index()
    {
        if($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        $list = ReplyService::Factory()->listWithTopicWithForumByUser($this->userId());
        return view('index', ['list' => $list]);
    }
}