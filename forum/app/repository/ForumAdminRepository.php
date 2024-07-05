<?php
/**
 * File: ForumAdminRepository.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\repository;

use app\model\ForumAdmin;
use app\service\Repository;
use PDOStatement;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Model;

class ForumAdminRepository extends Repository
{
    /**
     * 模型类
     * @return string|Model
     */
    protected function modelClass()
    {
        return ForumAdmin::class;
    }

    /**
     * 根据版块获取版主列表
     * @param int $forumId
     * @return false|PDOStatement|string|Collection
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException|\think\db\exception\DbException
     */
    public function listByForum($forumId)
    {
        $query = ForumAdmin::where('forum_id', $forumId);
        $query->with(['user']);
        return $query->select();
    }

    /**
     * 获取版块管理员ID列表
     * @param int $forumId
     * @return array
     */
    public function getAllAdminIdByForum($forumId)
    {
        $query = ForumAdmin::where('forum_id', $forumId);
        return $query->column('user_id');
    }
}