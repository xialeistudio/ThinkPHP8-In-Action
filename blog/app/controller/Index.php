<?php

namespace app\controller;

use app\BaseController;
use app\model\Post;
use app\Request;
use app\service\CategoryService;
use app\service\CommentService;
use app\service\PostService;
use app\service\PraiseService;
use app\service\UserService;

class Index extends BaseController
{
    public function index(PostService $service, Request $request)
    {
        $list = $service->list(10, $request->get('category_id'), $request->get('user_id'));
        return view('index', [
            'list' => $list,
            'page' => $list->render()
        ]);
    }

    public function category(CategoryService $service)
    {
        $list = $service->paginate();
        return view('category', [
            'list' => $list,
            'page' => $list->render()
        ]);
    }

    public function post(PostService $service, CommentService $commentService)
    {
        $id = \request()->get('id');
        if (empty($id)) {
            return $this->error('参数错误');
        }
        $post = $service->show($id, 0, Post::STATUS_VISIBLE);
        $comments = $commentService->getListByPost($post['post_id']);
        return view('post', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function comment(CommentService $service, UserService $userService)
    {
        $postId = \request()->get('post_id');
        if (empty($postId)) {
            return $this->error('参数错误');
        }
        $content = \request()->post('content');
        if (empty($content)) {
            return $this->error('评论内容不能为空');
        }
        $userId = $userService->userId();
        if (empty($userId)) {
            return $this->error('请先登录');
        }
        $service->publish($userId, $postId, $content);
        return $this->success('评论成功');
    }

    public function praise(PraiseService $service, UserService $userService)
    {
        $postId = \request()->get('post_id');
        if (empty($postId)) {
            return $this->error('参数错误');
        }
        $userId = $userService->userId();
        if (empty($userId)) {
            return $this->error('请先登录');
        }
        try{

            $service->praise($userId, $postId);
            return $this->success('点赞成功');
        }catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
