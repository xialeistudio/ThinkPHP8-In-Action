<?php
/**
 * File: CategoryService.php
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
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Db;

/**
 * 分类业务逻辑
 */
class CategoryService
{
    /**
     * 获取分类列表
     * @param $size
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function paginate($size = 10)
    {
        $query = Category::where('status', Category::STATUS_VISIBLE);
        $query->order(['posts' => 'desc', 'category_id' => 'desc']);
        return $query->paginate($size);
    }

    /**
     * 获取用户所有分类
     * @param $userId
     * @param null $status
     * @return Collection
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getAllByUser($userId, $status = null)
    {
        $query = Category::where(['user_id' => $userId]);
        if (isset($status)) {
            $query->where('status', $status);
        }
        return $query->select();
    }

    /**
     * 根据ID查找分类
     * @param $id
     * @param $userId
     * @return array|mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getById($id, $userId)
    {
        return Category::where(['category_id' => $id, 'user_id' => $userId])->find();
    }

    /**
     * 添加分类
     * @param $userId
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function create($userId, array $data)
    {
        if (Category::where(['name' => $data['name'], 'user_id' => $userId])->find()) {
            throw new Exception('分类已存在');
        }
        $data = ArrayHelper::filter($data, ['name', 'status']);
        $category = new Category();
        $category->user_id = $userId;
        $category->name = $data['name'];
        $category->status = $data['status'];
        return $category->save();
    }

    /**
     * 编辑分类
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     * @throws DbException
     */
    public function update($id, $userId, array $data)
    {
        $category = Category::where(['category_id' => $id, 'user_id' => $userId])->find();
        if (empty($category)) {
            throw new Exception('分类不存在');
        }
        $data = ArrayHelper::filter($data, ['name', 'status']);
        $category->data($data);

        return $category->save();
    }

    /**
     * 删除分类
     * @param $id
     * @param $userId
     * @return void
     * @throws Exception
     */
    public function delete($id, $userId)
    {
        $category = Category::where(['category_id' => $id, 'user_id' => $userId])->find();
        if (empty($category)) {
            throw new Exception('分类不存在');
        }
        if ($category->posts > 0) {
            throw new Exception('该分类下有文章，不可以删除');
        }
        if (!$category->delete()) {
            throw new Exception('分类删除失败');
        }
    }

    /**
     * 用户分类数量
     * @param $userId
     * @return int
     * @throws DbException
     */
    public function countByUser($userId)
    {
        return Category::where('user_id', $userId)->count();
    }
}