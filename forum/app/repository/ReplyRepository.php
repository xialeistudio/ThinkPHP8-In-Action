<?php
/**
 * File: ReplyRepository.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\repository;

use app\model\Reply;
use app\service\Repository;
use PDOStatement;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Model;
use think\Paginator;

class ReplyRepository extends Repository
{
    /**
     * 模型类
     * @return string|Model
     */
    protected function modelClass()
    {
        return Reply::class;
    }

    /**
     * 根据主题ID获取回复列表+回复者
     * @param int $topicId
     * @param int $size
     * @return Paginator
     * @throws DbException|\think\db\exception\DbException
     */
    public function listWithUserByTopic($topicId, $size = 10)
    {
        $query = Reply::where('topic_id', $topicId);
        $query->with(['user']);
        return $query->paginate([
            'list_rows' => $size,
            'query' => request()->get()
        ]);
    }

    /**
     * 根据用户获取回复列表+主题
     * @param int $userId
     * @param int $size
     * @return Paginator
     * @throws DbException
     */
    public function listWithTopicWithForumByUser($userId, $size = 10)
    {
        $query = Reply::where('user_id', $userId);
        $query->with([
            'topic',
            'forum'
        ]);
        $query->withoutField(['content']);
        return $query->paginate([
            'list_rows' => $size,
            'query' => request()->get()
        ]);
    }

    /**
     * 回复详情
     * @param int $replyId
     * @param int $userId
     * @return array|false|PDOStatement|string|Model
     * @throws DbException
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     */
    public function showWithTopicWithForumByUser($replyId, $userId)
    {
        $query = Reply::where('reply_id', $replyId);
        if (!empty($userId)) {
            $query->where('user_id', $userId);
        }
        $query->with(['topic', 'forum']);
        return $query->find();
    }
}