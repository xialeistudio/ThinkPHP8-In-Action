<?php
/**
 * File: UserRepository.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\repository;

use app\model\User;
use app\service\Repository;
use think\db\exception\DbException;
use think\Model;
use think\Paginator;

class UserRepository extends Repository
{
    /**
     * 模型类
     * @return string|Model
     */
    protected function modelClass()
    {
        return User::class;
    }

    /**
     * 排除指定用户ID的列表
     * @param array $without
     * @param int $size
     * @return Paginator
     * @throws DbException|\think\db\exception\DbException
     */
    public function listWithout(array $without = [], $size = 10)
    {
        $query = User::query();
        if (!empty($without)) {
            $query->where('user_id', 'not in', $without);
        }
        return $query->paginate([
            'list_rows' => $size,
            'query' => request()->get()
        ]);
    }

    /**
     * 用户列表
     * @param int $size
     * @param null $keyword
     * @return Paginator
     * @throws DbException
     */
    public function listByPageByKeyword($size = 10, $keyword = null)
    {
        $query = User::query();
        if (!empty($keyword)) {
            $query->where('nickname|username', 'like', '%' . $keyword . '%');
        }
        $query->order(['user_id' => 'desc']);
        return $query->paginate([
            'list_rows' => $size,
            'query' => request()->get()
        ]);
    }
}