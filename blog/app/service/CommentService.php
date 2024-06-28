<?php
/**
 * File: CommentService.php
 * User: xialeistudio
 * Date: 2024/6/28
 **/

namespace app\service;

use app\model\Comment;
use app\model\Post;
use Exception;
use think\db\Query;
use think\facade\Db;

/**
 * 评论业务
 */
class CommentService
{
    /**
     * 获取文章评论列表
     * @param $postId
     * @return Comment[]|array|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getListByPost($postId)
    {
        return Comment::with(['user'])->where('post_id', $postId)->select();
    }
    /**
     * 获取用户评论列表
     * @param $userId
     * @param $size
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function getListByUser($userId, $size)
    {
        $query = Comment::with([
            'user',
            'post' => function (Query $query) use ($userId) {
                $query->field('post_id,title');
                $query->where('user_id', $userId);
            }
        ]);
        return $query->paginate($size);
    }

    /**
     * 发表评论
     * @param $userId
     * @param $postId
     * @param $content
     * @return mixed
     */
    public function publish($userId, $postId, $content)
    {
        return Db::transaction(function () use ($userId, $postId, $content) {
            $post = Post::where(['post_id' => $postId, 'status' => Post::STATUS_VISIBLE])->find();
            if (empty($post)) {
                throw new Exception('文章不存在');
            }
            $post->comment_count++;
            if (!$post->save()) {
                throw new Exception('评论失败');
            }
            $comment = new Comment();
            $comment->user_id = $userId;
            $comment->post_id = $postId;
            $comment->content = $content;
            if (!$comment->save()) {
                throw new Exception('评论不存在');
            }
        });
    }

    /**
     * 删除评论
     * @param $commentId
     * @param $userId
     * @return void
     */
    public function delete($commentId, $userId)
    {
        Db::transaction(function () use ($userId, $commentId) {
            $comment = Comment::where(['comment_id' => $commentId])->find();
            if (empty($comment)) {
                throw new Exception('您无权操作');
            }
            if (!$comment->delete()) {
                throw new Exception('删除失败');
            }
            $post = Post::where(['post_id' => $comment->post_id, 'user_id' => $userId])->find();
            if (empty($post)) {
                throw new Exception('您无权操作');
            }
            $post->comment_count--;
            if (!$post->save()) {
                throw new Exception('删除失败');
            }
        });
    }
}