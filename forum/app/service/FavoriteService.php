<?php
/**
 * File: FavoriteService.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\service;

use app\BaseObject;
use app\model\Favorite;
use app\repository\FavoriteRepository;
use Exception;
use think\db\exception\DbException;
use think\facade\Db;
use think\Paginator;

class FavoriteService extends BaseObject
{
    /**
     * 添加收藏
     * @param int $userId
     * @param int $topicId
     * @return Favorite|mixed
     * @throws DbException
     */
    public function add($userId, $topicId)
    {
        $favorite = FavoriteRepository::Factory()->findOne(['user_id' => $userId, 'topic_id' => $topicId]);
        if (!empty($favorite)) {
            return $favorite;
        }
        return Db::transaction(function () use ($userId, $topicId) {
            $favorite = FavoriteRepository::Factory()->insert(['user_id' => $userId, 'topic_id' => $topicId]);
            TopicService::Factory()->addFavoriteCount($topicId, 1);
            return $favorite;
        });
    }

    /**
     * 取消收藏
     * @param int $userId
     * @param int $topicId
     * @return int
     */
    public function remove($userId, $topicId)
    {
        return Db::transaction(function () use ($userId, $topicId) {
            $count = FavoriteRepository::Factory()->delete(['user_id' => $userId, 'topic_id' => $topicId]);
            if (!$count) {
                throw new Exception('取消收藏失败');
            }
            TopicService::Factory()->addFavoriteCount($topicId, -1);
            return $count;
        });
    }

    /**
     * 检查是否收藏
     * @param int $userId
     * @param int $topicId
     * @return bool
     * @throws DbException
     */
    public function isFavorite($userId, $topicId)
    {
        return FavoriteRepository::Factory()->findOne(['user_id' => $userId, 'topic_id' => $topicId]) != null;
    }

    /**
     * 根据用户获取收藏列表
     * @param int $userId
     * @param int $size
     * @return Paginator
     * @throws DbException
     */
    public function listWithTopicByUser($userId, $size = 10)
    {
        return FavoriteRepository::Factory()->listWithTopicByUser($userId, $size);
    }
}