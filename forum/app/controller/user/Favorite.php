<?php
/**
 * File: Favorite.php
 * User: xialeistudio
 * Date: 2024/7/5
 **/

namespace app\controller\user;

use app\BaseController;
use app\Request;
use app\service\FavoriteService;

class Favorite extends BaseController
{
    public function index()
    {
        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        $list = FavoriteService::Factory()->listWithTopicByUser($this->userId());
        return view('index', ['list' => $list]);
    }

    public function delete(Request $request)
    {
        if($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        $topicId = $request->get('topic_id');
        if (empty($topicId)) {
            return $this->error('您的请求有误');
        }
        try {
            FavoriteService::Factory()->remove($this->userId(), $topicId);
            return $this->success('操作成功', url('/user.favorite/index'));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}