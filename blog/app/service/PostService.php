<?php
/**
 * File: PostService.php
 * User: xialeistudio
 * Date: 2024/6/28
 **/

namespace app\service;

use app\helper\ArrayHelper;
use app\model\Category;
use app\model\Comment;
use app\model\Post;
use app\model\Praise;
use Exception;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Db;

/**
 * 文章业务
 */
class PostService
{
    /**
     * 获取文章列表
     * @param $size
     * @param $categoryId
     * @param $userId
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function list($size = 10, $categoryId = 0, $userId = 0): \think\Paginator
    {
        $query = Post::where('status', Post::STATUS_VISIBLE)
            ->with(['user', 'category'])
            ->order(['top' => 'desc', 'sort' => 'desc', 'post_id' => 'desc']);
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }
        return $query->paginate($size);
    }

    /**
     * 统计
     * @param $status
     * @return int
     * @throws \think\db\exception\DbException
     */
    public function count($status = null)
    {
        $query = Post::where('status', Post::STATUS_VISIBLE);
        if (isset($status)) {
            $query->where('status', $status);
        }
        return $query->count();
    }

    /**
     * 文章详情
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     * @throws DbException
     */
    public function show($id, $userId = 0, $status = null)
    {

        $query = Post::where('post_id', $id)
            ->with(['user', 'category']);
        if (isset($status)) {
            $query->where('status', $status);
        }
        $data = $query->find();
        if (empty($data)) {
            throw new Exception('文章不存在');
        }
        if (empty($userId) && $data->status != Post::STATUS_VISIBLE) {
            throw new Exception('文章不存在');
        }
        return $data;
    }


    /**
     * 获取用户文章列表
     * @param $userId
     * @param $size
     * @return \think\Paginator
     * @throws DbException
     */
    public function getListByUser($userId, $size = 10)
    {
        return Post::where('user_id', $userId)
            ->with(['category'])
            ->withoutField(['content'])
            ->order(['post_id' => 'desc'])
            ->paginate($size);
    }

    /**
     * 发表文章
     * @param $userId
     * @param array $data
     * @return Post
     */
    public function publish($userId, array $data)
    {
        $data = ArrayHelper::filter($data, ['title', 'content', 'category_id', 'status', 'sort', 'top']);
        return Db::transaction(function () use ($userId, $data) {
            $category = Category::where([
                'user_id' => $userId,
                'category_id' => $data['category_id'],
            ])->find();
            if (empty($category)) {
                throw new Exception('分类不存在');
            }
            $category->posts++;
            if (!$category->save()) {
                throw new Exception('发表失败');
            }

            $post = new Post();
            $post->data($data);
            $post->user_id = $userId;
            if (!$post->save()) {
                throw new Exception('发表失败');
            }
            return $post;
        });
    }

    /**
     * 编辑文章
     * @param $postId
     * @param $userId
     * @param array $data
     * @return void
     */
    public function update($postId, $userId, array $data)
    {
        $data = ArrayHelper::filter($data, ['title', 'content', 'category_id', 'status', 'sort', 'top']);
        Db::transaction(function () use ($postId, $userId, $data) {
            $post = $this->show($postId, $userId);
            if (empty($post)) {
                throw new Exception('文章不存在');
            }
            if (!empty($data['category_id']) && $data['category_id'] != $post->category_id) {
                // 文章分类修改，需要修正分类文章数
                $oldCategory = Category::find($post->category_id); // 能够发布到该分类，证明是有效且有权限的分类
                $oldCategory->posts--;
                if (!$oldCategory->save()) {
                    throw new Exception('编辑失败');
                }
                $newCategory = Category::where([
                    'user_id' => $userId,
                    'category_id' => $data['category_id'],
                ])->find(); // category_id为外部提交，需要校验
                if (empty($newCategory)) {
                    throw new Exception('分类不存在');
                }
                $newCategory->posts++;
                if (!$newCategory->save()) {
                    throw new Exception('编辑失败');
                }
            }
            $post->data($data);
            if (!$post->save()) {
                throw new Exception('编辑失败');
            }
            return $post;
        });
    }

    /**
     * 删除文章
     * @param $postId
     * @param $userId
     * @return void
     */
    public function delete($postId, $userId)
    {
        Db::transaction(function () use ($postId, $userId) {
            $post = $this->show($postId, $userId);
            if (!$post->delete()) {
                throw new Exception('删除失败');
            }
            $category = Category::find($post->category_id);
            $category->posts--;
            if (!$category->save()) {
                throw new Exception('删除失败');
            }
            Comment::destroy(['post_id' => $postId]);
            Praise::destroy(['post_id' => $postId]);
        });
    }

    /**
     * 获取用户文章数量
     * @param $userId
     * @return int
     * @throws DbException
     */
    public function countByUser($userId)
    {
        return Post::where('user_id', $userId)->count();
    }
}