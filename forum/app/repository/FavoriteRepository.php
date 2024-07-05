<?php
/**
 * File: FavoriteRepository.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\repository;

use app\model\Favorite;
use app\service\Repository;
use think\db\exception\DbException;
use think\Paginator;

class FavoriteRepository extends Repository
{

    protected function modelClass()
    {
        return Favorite::class;
    }

    /**
     * 根据用户获取收藏列表
     * @param int $userId
     * @param int $size
     * @return Paginator
     * @throws DbException|\think\db\exception\DbException
     */
    public function listWithTopicByUser($userId, $size = 10)
    {
        $query = Favorite::where('user_id', $userId);
        $query->with(['topic']);
        $query->order(['created_at' => 'desc']);
        return $query->paginate([
            'list_rows' => $size,
            'query' => request()->get()
        ]);
    }
}