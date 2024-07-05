<?php
/**
 * File: ForumAdminService.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\service;

use app\BaseObject;
use app\model\ForumAdmin;
use app\repository\ForumAdminRepository;
use Exception;
use PDOStatement;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Model;

class ForumAdminService extends BaseObject
{
    /**
     * 添加版主
     * @param int $userId
     * @param int $forumId
     * @return ForumAdmin|mixed|Model
     * @throws DbException
     */
    public function bind($userId, $forumId)
    {
        /** @var ForumAdmin $model */
        $model = ForumAdminRepository::Factory()->findOne(['user_id' => $userId, 'forum_id' => $forumId]);
        if (!empty($model)) {
            return $model;
        }
        return ForumAdminRepository::Factory()->insert([
            'user_id' => $userId,
            'forum_id' => $forumId,
            'expired_at' => 0
        ]);
    }

    /**
     * 移除版主
     * @param int $userId
     * @param int $forumId
     * @return int
     * @throws Exception
     */
    public function unbind($userId, $forumId)
    {
        return ForumAdminRepository::Factory()->delete(['user_id' => $userId, 'forum_id' => $forumId]);
    }

    /**
     * 获取版主列表
     * @param int $forumId
     * @return false|PDOStatement|string|Collection
     * @throws DbException
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     */
    public function listByForum($forumId)
    {
        return ForumAdminRepository::Factory()->listByForum($forumId);
    }

    /**
     * 获取版块管理员ID列表
     * @param int $forumId
     * @return array
     */
    public function getAllAdminIdByForum($forumId)
    {
        return ForumAdminRepository::Factory()->getAllAdminIdByForum($forumId);
    }

    /**
     * 检测是否版主
     * @param int $userId
     * @param int $forumId
     * @return bool
     * @throws DbException
     */
    public function isAdmin($userId, $forumId)
    {
        return ForumAdminRepository::Factory()->findOne(['user_id' => $userId, 'forum_id' => $forumId]) != null;
    }
}