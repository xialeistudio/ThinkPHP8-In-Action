<?php
/**
 * File: TopicRepository.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\repository;

use app\model\Topic;
use app\service\Repository;
use Exception;
use PDOStatement;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Model;
use think\Paginator;

class TopicRepository extends Repository
{
    /**
     * 模型类
     * @return string|Model
     */
    protected function modelClass()
    {
        return Topic::class;
    }

    /**
     * 获取帖子详情
     * @param int $topicId
     * @param array $relations
     * @return array|false|PDOStatement|string|Model
     * @throws DataNotFoundException
     * @throws DbException
     * @throws Exception
     * @throws ModelNotFoundException
     */
    public function showWithRelations($topicId, array $relations = [])
    {
        $query = Topic::where('topic_id', $topicId);
        $query->with($relations);
        $topic = $query->find();
        if (empty($topic)) {
            throw new Exception('帖子不存在');
        }
        return $topic;
    }

    /**
     * 获取版块帖子列表
     * @param int $forumId
     * @param int $size
     * @return Paginator
     * @throws DbException
     */
    public function listWithUserByForum($forumId, $size = 10)
    {
        $query = Topic::where('forum_id', $forumId);
        $query->with(['user']);
        $query->order(['top' => 'desc', 'topic_id' => 'desc']);
        return $query->paginate([
            'list_rows' => $size,
            'query' => request()->get()
        ]);
    }

    /**
     * 管理后台帖子列表
     * @param int $forumId
     * @param null $keyword
     * @param int $size
     * @return Paginator
     * @throws DbException
     */
    public function listWithUserWithForum($forumId = 0, $keyword = null, $size = 10)
    {
        $query = Topic::with(['user', 'forum']);
        if (!empty($forumId)) {
            $query->where('forum_id', $forumId);
        }
        if (!empty($keyword)) {
            $query->where('title', 'like', '%' . $keyword . '%');
        }

        $query->order(['top' => 'desc', 'topic_id' => 'desc']);
        return $query->paginate([
            'list_rows' => $size,
            'query' => request()->get()
        ]);
    }

    /**
     * 用户主题列表
     * @param int $userId
     * @param int $size
     * @return Paginator
     * @throws DbException
     */
    public function listWithForumByUser($userId, $size = 10)
    {
        $query = Topic::where('user_id', $userId);
        $query->with(['forum']);
        $query->order(['topic_id' => 'desc']);
        return $query->paginate([
            'list_rows' => $size,
            'query' => request()->get()
        ]);
    }

    /**
     * 最新帖子
     * @param int $size
     * @return false|PDOStatement|string|Collection
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function listLatest($size = 30)
    {
        $query = Topic::withoutField('content');
        $query->order(['topic_id' => 'desc']);
        $query->limit($size);
        $query->with(['forum', 'user']);
        return $query->select();
    }
}