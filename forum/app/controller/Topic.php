<?php
/**
 * File: Topic.php
 * User: xialeistudio
 * Date: 2024/7/3
 **/

namespace app\controller;

use app\BaseController;
use app\repository\ReplyService;
use app\Request;
use app\service\FavoriteService;
use app\service\ForumAdminService;
use app\service\ForumService;
use app\service\TopicService;
use Exception;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

class Topic extends BaseController
{
    /**
     * 发帖表单
     * @param Request $request
     * @return mixed
     */
    public function publish(Request $request)
    {
        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        $forumId = $request->get('forum_id');
        if (empty($forumId)) {
            return $this->error('您的请求有误');
        }
        try {
            $forum = ForumService::Factory()->show($forumId, \app\model\Forum::STATUS_VISIBLE);
            return view('publish', ['forum' => $forum]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 处理发表
     * @param Request $request
     */
    public function do_publish(Request $request)
    {
        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        $data = $request->post();
        $errmsg = $this->validate($data, [
            'forum_id|所属版块' => 'require',
            'title|标题' => 'require|max:100',
            'content|内容' => 'require',
        ]);
        if ($errmsg !== true) {
            return $this->error($errmsg);
        }
        try {
            $topic = TopicService::Factory()->publish($this->userId(), $data);
            return redirect(url('/topic/show', ['id' => $topic->topic_id]));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 查看帖子
     * @param Request $request
     * @return mixed
     */
    public function show(Request $request)
    {
        $topicId = $request->get('id');
        if (empty($topicId)) {
            $this->error('您的请求有误');
        }
        try {
            TopicService::Factory()->view($topicId, $request->ip(), $this->userId());
            $topic = TopicService::Factory()->showWithUserWithForum($topicId);
            $replies = ReplyService::Factory()->listWithUserByTopic($topicId);
            $canView = !$topic->flag || ReplyService::Factory()->hasReplied($topicId, $this->userId());
            $canAccess = TopicService::Factory()->shouldAccess($this->userId(), $topic);
            $isAdmin = ForumAdminService::Factory()->isAdmin($this->userId(), $topic->forum_id);
            $isFavorite = FavoriteService::Factory()->isFavorite($this->userId(), $topicId);
            return view('show', [
                'topic' => $topic,
                'replies' => $replies,
                'firstPage' => $request->get('page', 1) == 1,
                'canView' => $canView || $canAccess,
                'canAccess' => $canAccess,
                'userId' => $this->userId(),
                'isAdmin' => $isAdmin,
                'isFavorite' => $isFavorite
            ]);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 编辑主题
     * @param Request $request
     * @return mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws Exception
     * @throws ModelNotFoundException
     */
    public function update(Request $request)
    {
        $topicId = $request->get('id');
        if (empty($topicId)) {
            return $this->error('您的请求有误');
        }
        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        try {
            $topic = TopicService::Factory()->showWithForum($topicId);
            if (!TopicService::Factory()->shouldAccess($this->userId(), $topic)) {
                return $this->error('您无权操作!');
            }
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }

        return view('update', [
            'topic' => $topic,
            'reply_visible' => $topic->isReplyVisible()
        ]);
    }

    /**
     * 处理编辑
     * @param Request $request
     * @throws DbException
     * @throws Exception
     */
    public function do_update(Request $request)
    {
        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        $topicId = $request->get('id');
        if (empty($topicId)) {
            return $this->error('您的请求有误');
        }
        $data = $request->post();
        $errmsg = $this->validate($data, [
            'title|标题' => 'require|max:100',
            'content|内容' => 'require',
        ]);
        if ($errmsg !== true) {
            return $this->error($errmsg);
        }
        try {
            $data['flag'] = isset($data['flag']) ? $data['flag'] & \app\model\Topic::FLAG_REPLY_VISIBLE : 0;
            TopicService::Factory()->update($topicId, $this->userId(), $data);
            return $this->success('编辑成功', url('show', ['id' => $topicId]));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除帖子
     * @param Request $request
     */
    public function delete(Request $request)
    {
        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        $id = $request->get('id');
        if (empty($id)) {
            return $this->error('您的请求有误');
        }
        try {
            $topic = TopicService::Factory()->delete($id, $this->userId());
            return $this->success('删除成功', url('forum/show', ['id' => $topic->forum_id]));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 置顶
     * @param Request $request
     */
    public function top(Request $request)
    {
        $id = $request->get('id');
        if (empty($id)) {
            return $this->error('您的请求有误');
        }
        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        try {
            TopicService::Factory()->setTop($this->userId(), $id);
            return $this->success('操作成功', url('show', ['id' => $id]));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 取消置顶
     * @param Request $request
     */
    public function untop(Request $request)
    {
        $id = $request->get('id');
        if (empty($id)) {
            return $this->error('您的请求有误');
        }

        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        try {
            TopicService::Factory()->unsetTop($this->userId(), $id);
            return $this->success('操作成功', url('show', ['id' => $id]));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 收藏
     * @param Request $request
     * @throws DbException
     */
    public function favorite(Request $request)
    {
        $id = $request->get('id');
        if (empty($id)) {
            return $this->error('您的请求有误');
        }

        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        try {
            FavoriteService::Factory()->add($this->userId(), $id);
            return $this->success('操作成功', url('show', ['id' => $id]));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 取消收藏
     * @param Request $request
     */
    public function unfavorite(Request $request)
    {
        $id = $request->get('id');
        if (empty($id)) {
            return $this->error('您的请求有误');
        }
        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        try {
            FavoriteService::Factory()->remove($this->userId(), $id);
            return $this->success('操作成功', url('show', ['id' => $id]));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 回帖
     * @param Request $request
     * @return mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws Exception
     * @throws ModelNotFoundException
     */
    public function reply(Request $request)
    {
        $topicId = $request->get('topic_id');
        if (empty($topicId)) {
            return $this->error('您的请求有误');
        }
        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        $topic = TopicService::Factory()->showWithForum($topicId);
        return view('reply', ['topic' => $topic]);
    }

    /**
     * 回复
     * @param Request $request
     */
    public function do_reply(Request $request)
    {
        $topicId = $request->get('topic_id');
        if (empty($topicId)) {
            return $this->error('您的请求有误');
        }

        if ($this->userId() == 0) {
            return $this->error('请先登录', url('/index.auth/signin'));
        }
        $data = $request->post();
        try {
            $this->validate($data, [
                'forum_id|版块ID' => 'require',
                'content|回复内容' => 'require'
            ]);
            $data['topic_id'] = $topicId;
            ReplyService::Factory()->publish($this->userId(), $data);
            return redirect(url('topic/show', ['id' => $topicId]));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

}