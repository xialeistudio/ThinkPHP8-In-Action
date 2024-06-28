<?php
/**
 * File: PraiseService.php
 * User: xialeistudio
 * Date: 2024/6/28
 **/

namespace app\service;

use app\model\Post;
use app\model\Praise;
use Exception;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\db\Query;
use think\facade\Db;

/**
 * 点赞业务
 */
class PraiseService
{
    /**
     * 点赞列表
     * @param $userId
     * @param $size
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function listByUser($userId, $size)
    {
        $query = Praise::with([
            'user',
            'post' => function (Query $query) use ($userId) {
                $query->field('post_id,title');
                $query->where('user_id', $userId);
            }
        ]);
        return $query->paginate($size);
    }

    /**
     * 点赞
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     * @throws DbException
     */
    public function praise($userId, $postId)
    {
        $praise = Praise::where(['user_id' => $userId, 'post_id' => $postId])->find();
        if (!empty($praise)) {
            throw new Exception('您已经赞过啦!');
        }
        return Db::transaction(function () use ($userId, $postId) {
            $praise = new Praise();
            $praise->user_id = $userId;
            $praise->post_id = $postId;
            if (!$praise->save()) {
                throw new Exception('点赞失败');
            }
            $post = Post::where(['post_id' => $postId, 'status' => Post::STATUS_VISIBLE])->find();
            $post->praise_count++;
            if (!$post->save()) {
                throw new Exception('点赞失败');
            }
        });
    }
}