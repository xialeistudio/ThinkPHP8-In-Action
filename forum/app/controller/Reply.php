<?php
/**
 * File: Reply.php
 * User: xialeistudio
 * Date: 2024/7/5
 **/

namespace app\controller;

use app\BaseController;
use app\repository\ReplyService;
use app\Request;

class Reply extends BaseController
{
    public function update(Request $request)
    {
        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        $id = $request->get('id');
        if (empty($id)) {
            return $this->error('您的请求有误');
        }
        $reply = ReplyService::Factory()->showWithTopicWithForumByUser($id, $this->userId());
        if (empty($reply)) {
            return $this->error('您无权操作!');
        }
        return view('update', ['reply' => $reply]);
    }

    public function do_update(Request $request)
    {
        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        $id = $request->get('id');
        if (empty($id)) {
            return $this->error('您的请求有误');
        }
        $data = $request->post();
        try {
            $this->validate($data, [
                'content|回复内容' => 'require'
            ]);
            $reply = ReplyService::Factory()->update($this->userId(), $id, $data['content']);
            return $this->success('编辑成功', url('/topic/show', ['id' => $reply['topic_id']]));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

    }
}